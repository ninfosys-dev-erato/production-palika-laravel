<?php

namespace Src\Ebps\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Ebps\Models\HouseOwnerDetail;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyDetail;
use Src\Ebps\Models\OrganizationDetail;
use Illuminate\Support\Collection;

class RequestedChangesTable extends Component
{
    use SessionFlash;
    public Collection $items;

    public $item;

    public function mount()
    {
        $houseOwnerPending = HouseOwnerDetail::query()
            ->where('status', 'pending')
            ->whereNotNull('parent_id')
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'type' => 'House Owner',
                'name' => $item->owner_name,
                'contact' => $item->mobile_no,
                'status' => $item->status,
                'reason' => $item->reason_of_owner_change,
                'created_at' => $item->created_at,
            ]);

        $organizationPending = OrganizationDetail::query()
            ->where('status', 'pending')
            ->whereNotNull('parent_id')
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'type' => 'Organization',
                'name' => $item->name,
                'contact' => $item->contact_no,
                'status' => $item->status,
                'reason' => $item->reason_of_organization_change,
                'created_at' => $item->created_at,
                'organization_id' => $item->organization_id,
                'map_apply_id' => $item->map_apply_id,
            ]);

        $this->items = collect();

        if ($houseOwnerPending->isNotEmpty()) {
            $this->items = $this->items->merge($houseOwnerPending);
        }

        if ($organizationPending->isNotEmpty()) {
            $this->items = $this->items->merge($organizationPending);
        }

        $this->items = $this->items->sortByDesc('created_at')->values();

    }
        
    public function render()
    {
        return view('Ebps::livewire.requested-changes');
    }


    public function approveRequest($type, $id)
    {
        if ($type === 'House Owner') {
            $item = HouseOwnerDetail::find($id);
            if (!$item) {
                session()->flash('error', 'Item not found.');
                return;
            }

            if ($item->status !== 'approved') {
                $item->status = 'approved';
                $item->save();

                $mapApply = MapApply::where('house_owner_id', $item->parent_id)->first();
                if ($mapApply) {
                    $mapApply->house_owner_id = $item->id;
                    $mapApply->save();
                }
            }

        } elseif ($type === 'Organization') {
            $item = OrganizationDetail::find($id);
            if (!$item) {
                session()->flash('error', 'Item not found.');
                return;
            }

            if ($item->status !== 'approved') {
                $item->status = 'approved';
                $item->save();

                $organizationDetail = OrganizationDetail::where('id', $item->parent_id )->first();
                $mapApplyDetail = MapApplyDetail::where('organization_id', $organizationDetail->organization_id)->where('map_apply_id', $organizationDetail->map_apply_id)->first();
                if($mapApplyDetail)
                {
                    $mapApplyDetail->organization_id = $item->organization_id;
                    $mapApplyDetail->save();

                }
            }

        } else {
            session()->flash('error', 'Invalid type.');
            $this->errorFlash(__('ebps::ebps.invalid_type'));
            return;
        }

        $this->successFlash(__('ebps::ebps.request_approved_successfully'));
        return redirect()->route('admin.ebps.requested-change');
    }


}
