<?php

namespace Src\DigitalBoard\Livewire;

use App\Enums\Action;
use App\Facades\VideoServiceFacade;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\DigitalBoard\DTO\VideoAdminDto;
use Src\DigitalBoard\Models\Video;
use Src\DigitalBoard\Service\VideoAdminService;

class VideoForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?Video $video;
    public ?Action $action;
    public $videoFile = null;
    public bool $canShowOnAdmin = false;
    public bool $isPrivate = false;
    public array $wards = [];
    public array $selectedWards = [];

    public function rules(): array
    {
        $rules = [
            'video.title' => ['required'],
            'video.url' => ['nullable', 'url', 'required_without:videoFile'],
            'videoFile' => ['nullable', 'file', 'mimetypes:video/mp4', 'required_without:video.url' , 'max:102400'],
        ];

        if($this->video->exists)
        {
            $rules['videoFile'] = ['nullable'];
        }
        return $rules;
    }
    public function messages(): array
    {
        return [
            'video.title.required' => __('digitalboard::digitalboard.the_title_is_required'),
            'video.url.required_without' => __('digitalboard::digitalboard.the_video_url_or_file_is_required'),
            'video.url.url' => __('digitalboard::digitalboard.the_video_url_must_be_a_valid_url'),
            'videoFile.required_without' => __('digitalboard::digitalboard.the_video_url_or_file_is_required'),
            'videoFile.file' => __('digitalboard::digitalboard.the_uploaded_file_must_be_a_video_file'),
            'videoFile.mimetypes' => __('digitalboard::digitalboard.the_video_file_must_be_of_type_mp4'),
            'videoFile.max' => __('digitalboard::digitalboard.the_video_file_must_not_be_greater_than_100_mb'),
        ];
    }


    public function render()
    {
        return view("DigitalBoard::livewire.videos.form");
    }

    public function mount(Video $video, Action $action)
    {
        $this->video = $video;
        $this->action = $action;
        $this->wards = getWardsArray();

        if ($video->exists) {
            $this->canShowOnAdmin = $video->can_show_on_admin;
            $this->isPrivate = $video->is_private;
            $this->selectedWards = $video->wards()?->pluck('ward')->toArray() ?? [];
        }
    }

    public function save()
    {
        $this->validate();

        $this->video->can_show_on_admin = $this->canShowOnAdmin;
        $this->video->is_private = $this->isPrivate;

        DB::beginTransaction();

        try {
            if($this->videoFile && $this->videoFile instanceof \Illuminate\Http\File ||
            $this->videoFile instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ||
            $this->videoFile instanceof \Illuminate\Http\UploadedFile){
                $storedFileName = $this->storeVideoFile();
                if ($storedFileName) {
                    $this->video->file = $storedFileName;
                }
            }

            $dto = VideoAdminDto::fromLiveWireModel($this->video);
            $service = new VideoAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $video = $service->store($dto);
                    $service->storeVideoWards($video, $this->selectedWards);
                    DB::commit();
                    $this->successFlash(__("Video Created Successfully"));
                    return redirect()->route('admin.digital_board.videos.index');

                case Action::UPDATE:
                    $video = $service->update($this->video, $dto);
                    $service->storeVideoWards($video, $this->selectedWards);
                    DB::commit();
                    $this->successFlash(__("Video Updated Successfully"));
                    return redirect()->route('admin.digital_board.videos.index');

                default:
                    return redirect()->route('admin.digital_board.videos.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($storedFileName)) {
                $disk = $this->isPrivate ? getStorageDisk('private') : getStorageDisk('public');
                VideoServiceFacade::deleteVideo(
                    config('src.DigitalBoard.video.video_path'),
                    $storedFileName,
                    $disk
                );
            }
            logger($e);
            $this->errorFlash(__('digitalboard::digitalboard.an_error_occurred_during_operation_please_try_again_later'));
        }
    }

    private function storeVideoFile(): ?string
    {
        if ($this->videoFile) {
            $disk = $this->isPrivate ? getStorageDisk('private') : getStorageDisk('public');
            return VideoServiceFacade::storeVideo(
                $this->videoFile,
                config('src.DigitalBoard.video.video_path'),
                $disk
            );
        } elseif ($this->video->exists && $this->video->isDirty('is_private')) {
            $oldDisk = $this->video->getOriginal('is_private') ? getStorageDisk('private') : getStorageDisk('public');
            $newDisk = $this->isPrivate ? getStorageDisk('private') : getStorageDisk('public');

            VideoServiceFacade::transferBetweenDisks(
                config('src.DigitalBoard.video.video_path'),
                $this->video->file,
                $oldDisk,
                $newDisk
            );
            return null;
        }
        return null;
    }
}
