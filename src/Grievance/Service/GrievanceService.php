<?php

namespace Src\Grievance\Service;

use App\Facades\FileTrackingFacade;
use App\Facades\ImageServiceFacade;
use App\Facades\FileFacade;
use App\Models\User;
use Domains\CustomerGateway\Grievance\DTO\GrievanceDto;
use Domains\CustomerGateway\Grievance\Resources\GrievanceTypeResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Src\Customers\Notifications\GrievanceStatusNotification;
use Src\Grievance\DTO\GrievanceDetailAdminDto;
use Src\Grievance\Enums\GrievancePriorityEnum;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Grievance\Models\GrievanceAssignHistory;
use Src\Grievance\Models\GrievanceDetail;
use Src\Grievance\Models\GrievanceFile;
use Src\Grievance\Models\GrievanceSetting;
use Src\Grievance\Models\GrievanceType;
use Src\Users\Notifications\GrievanceAssignedUserNotification;

class GrievanceService
{

    protected $path;

    public function __construct()
    {
        $this->path = config('src.Grievance.grievance.path');
    }

    public function create(GrievanceDto $grievanceDto, $customer)
    {
       
        $grievance = GrievanceDetail::create([
            'token' => strtoupper(Str::random(7)),
            'grievance_type_id' => $grievanceDto->grievance_type_id,
            'grievance_detail_id' => $grievanceDto->grievance_detail_id,
            'customer_id' => $customer->id,
            'branch_id' => $grievanceDto->branch_id,
            'subject' => $grievanceDto->subject,
            'description' => $grievanceDto->description,
            'status' => GrievanceStatusEnum::UNSEEN,
            'is_public' => $grievanceDto->is_public,
            'is_anonymous' => $grievanceDto->is_anonymous,
            'priority' => GrievancePriorityEnum::LOW,
            'local_body_id' => $customer->kyc->permanent_local_body_id,
            'ward_id' => $customer->kyc->permanent_ward,
            'is_visible_to_public' => true,
            'is_ward' => $grievanceDto->is_ward,
            'grievance_medium' => $grievanceDto->grievance_medium
        ]);

        if (!empty($grievanceDto->files)) {
            GrievanceFile::create([
                'grievance_detail_id' => $grievance->id,
                'file_name' => $grievanceDto->files,
            ]);
        }

        $locale = App::getLocale();
        $message = $locale === 'ne'
            ? __('complaint_registered', ['token' => $grievance->token])
            : 'Congratulations! Your complaint has been registered with complaint number ' . $grievance->token . '. We will follow-up on your complaint and contact you.';

        return [
            'message' => $message,
            'grievanceToken' => $grievance->token,
        ];
    }

    public function complaintsByUser($customer): Collection
    {

        $myComplaints =   QueryBuilder::for(GrievanceDetail::class)
            ->where('customer_id', $customer)
            ->allowedFilters(['id', 'token', 'status',  AllowedFilter::scope('created_after'), AllowedFilter::scope('created_before')])
            ->with('grievanceDetail', 'grievanceType', 'files', 'branch', 'histories')
            ->allowedSorts(['subject', 'created_at'])
            ->get();

        $this->attachImagePaths($myComplaints, $this->path);

        return $myComplaints;
    }

    public function showAllComplaints(): Collection
    {
        $allComplaints =  QueryBuilder::for(GrievanceDetail::class)
            ->where('is_public', true)
            ->allowedFilters(['id', 'token', 'status',  AllowedFilter::scope('created_after'), AllowedFilter::scope('created_before')])
            ->with('grievanceDetail', 'grievanceType', 'files', 'branch', 'histories')
            ->allowedSorts(['subject', 'created_at'])
            ->get();

        $this->attachImagePaths($allComplaints, $this->path);
        return $allComplaints;
    }

    public function showAllComplaintsV2(): LengthAwarePaginator
    {
        $allComplaints =  QueryBuilder::for(GrievanceDetail::class)
            ->where('is_public', true)
            ->where('is_visible_to_public', true)
            ->allowedFilters(['id', 'token', 'status',  AllowedFilter::scope('created_after'), AllowedFilter::scope('created_before')])
            ->with('grievanceDetail', 'grievanceType', 'files', 'branch', 'histories')
            ->allowedSorts(['subject', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $this->attachImagePaths($allComplaints, $this->path);
        return $allComplaints;
    }

    public function complaintsByUserV2($customer): LengthAwarePaginator
    {
        $myComplaints =   QueryBuilder::for(GrievanceDetail::class)
            ->where('customer_id', $customer)
            ->allowedFilters(['id', 'token', 'status',  AllowedFilter::scope('created_after'), AllowedFilter::scope('created_before')])
            ->with('grievanceDetail', 'grievanceType', 'files', 'branch', 'histories')
            ->allowedSorts(['subject', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);


        $this->attachImagePaths($myComplaints, $this->path);

        return $myComplaints;
    }

    public function showComplaintDetail(int $id): Collection
    {
        return GrievanceDetail::where('id', $id)
            ->with('grievanceDetail', 'grievanceType', 'branch', 'files', 'histories')
            ->get();
    }
    public function showComplaintDetailV2(int $id): GrievanceDetail|null
    {
        return GrievanceDetail::where('id', $id)
            ->with('grievanceDetail', 'grievanceType', 'branch', 'files', 'histories')
            ->first();
    }

    public function attachImagePaths($complaints, $path): mixed
    {
        // Since we're now using customFileAsset in views (darta approach),
        // we don't need to modify the model attributes here
        // This prevents JSON encoding issues with malformed UTF-8 characters
        return $complaints;
    }
    public function grievanceType()
    {
        $response = QueryBuilder::for(GrievanceType::class)
            ->allowedFilters(['id', 'title'])
            ->whereNull('deleted_at')
            ->get();

        $types =  GrievanceTypeResource::collection($response);

        return $types;
    }

    public function toggleGrievanceTypeUser(int $userId, int $grievanceTypeId): void
    {
        $user = User::find($userId);
        $grievanceType = GrievanceType::find($grievanceTypeId);

        if ($user && $grievanceType) {
            if ($user->grievanceTypes->contains($grievanceTypeId)) {
                $user->grievanceTypes()->detach($grievanceTypeId);
            } else {
                $user->grievanceTypes()->attach($grievanceTypeId);
            }
        }
    }


    public function updateStatus(GrievanceDetail $grievanceDetail, GrievanceDetailAdminDto $grievanceDetailAdminDto,GrievanceStatusEnum $oldStatus, array $updateData)
    {
        FileTrackingFacade::recordFile($grievanceDetail);
        $this->updateApprovedAtIfClosed($grievanceDetail, $grievanceDetailAdminDto->status);    
        tap($grievanceDetail)->update($updateData);

        GrievanceAssignHistory::create([
            'grievance_detail_id' => $grievanceDetail->id,
            'from_user_id' => $grievanceDetailAdminDto->assigned_user_id ?? Auth::guard('web')->id(),
            'to_user_id' => $grievanceDetailAdminDto->assigned_user_id,
            'old_status' => $oldStatus, 
            'new_status' => $grievanceDetailAdminDto->status,
            'suggestions' => $grievanceDetailAdminDto->suggestions,
            'documents' => $grievanceDetailAdminDto->documents,
        ]);

        return $grievanceDetail;
    }

    private function updateApprovedAtIfClosed(GrievanceDetail $grievanceDetail, $status)
    {
        if ($status->value === GrievanceStatusEnum::CLOSED->value) {
            $grievanceDetail->approved_at = now();
            $grievanceDetail->save();
            $grievanceDetail->customer->notify(new GrievanceStatusNotification('closed',  $grievanceDetail->token));
        }
    }

    public function updateAssignedUser(GrievanceDetail $grievanceDetail, GrievanceDetailAdminDto $grievanceDetailAdminDto, $fromUserId)
    {
        FileTrackingFacade::recordFile($grievanceDetail);
        tap($grievanceDetail)->update([
            'assigned_user_id' => $grievanceDetailAdminDto->assigned_user_id,
            'escalation_date' => Carbon::now()->addDays(GrievanceSetting::first()->escalation_days),
        ]);

        $assignedUser = User::find($grievanceDetailAdminDto->assigned_user_id);
        $assignedUser->notify(new GrievanceAssignedUserNotification($grievanceDetail));

        GrievanceAssignHistory::create([
            'grievance_detail_id' => $grievanceDetail->id,
            'from_user_id' => $fromUserId ?? Auth::guard('web')->id(),
            'to_user_id' => $grievanceDetailAdminDto->assigned_user_id, 
            'old_status' => null,
            'new_status' => null, 
        ]);
    
        return $grievanceDetail;

    }
    public function updatePriority(GrievanceDetail $grievanceDetail, GrievanceDetailAdminDto $grievanceDetailAdminDto)
    {
        FileTrackingFacade::recordFile($grievanceDetail);
        return tap($grievanceDetail)->update([
            'priority' => $grievanceDetailAdminDto->priority,
        ]);
    }
    public function notifyUsers(GrievanceDetail $grievanceDetail)
    {
        $roles = $grievanceDetail->grievanceType?->roles?->pluck('id')->toArray();
        $usersByRoles = User::with("roles")
            ->whereHas("roles", function($q) use ($roles) {
                $q->whereIn("id", $roles);
            })
            ->get()
            ->keyBy('id'); 
        $departments = $grievanceDetail->grievanceType->departments;
        $usersByDepartments = $departments->flatMap(function ($branch) {
            return $branch->users;
        })->keyBy('id'); 

        $combinedUsers = $usersByRoles->union($usersByDepartments);

        $combinedUsersArray = $combinedUsers->toArray();

        return $combinedUsersArray;
    }

    public function getDocuments(GrievanceDetail $grievanceDetail)
    {
        return $grievanceDetail->files
            ->map(function ($file) use ($grievanceDetail) {
                $fileNames = is_array($file->file_name) ? $file->file_name : [$file->file_name];

                return collect($fileNames)
                    ->filter()
                    ->map(function ($fileName) use ($grievanceDetail) {
                        $source = $grievanceDetail->is_public ? 'public' : 'local';

                        return ImageServiceFacade::getImage(
                            config('src.Grievance.grievance.path'),
                            $fileName,
                            $source
                        );
                    })
                    ->toArray();
            })
            ->flatten(1)
            ->values()
            ->toArray();
    }  

}
