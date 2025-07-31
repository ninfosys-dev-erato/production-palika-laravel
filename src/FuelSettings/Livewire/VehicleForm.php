<?php

namespace Src\FuelSettings\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\FuelSettings\DTO\VehicleAdminDto;
use Src\FuelSettings\Models\Vehicle;
use Src\FuelSettings\Models\VehicleCategory;
use Src\Employees\Models\Employee;
use Src\FuelSettings\Service\VehicleAdminService;
use App\Facades\ImageServiceFacade;
use Livewire\WithFileUploads;

class VehicleForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?Vehicle $vehicle;
    public ?Action $action;

    public $vehicleCategory;
    public $employees;
    public $license_photo;
    public $signature;

    public function rules(): array
    {
        return [
            'vehicle.employee_id' => ['required'],
            'vehicle.vehicle_category_id' => ['required'],
            'vehicle.vehicle_number' => ['required'],
            'vehicle.chassis_number' => ['required'],
            'vehicle.engine_number' => ['required'],
            'vehicle.fuel_type' => ['required'],
            'vehicle.driver_name' => ['required'],
            'vehicle.license_number' => ['required'],
            'license_photo' => ['required'],
            'signature' => ['required'],
            'vehicle.driver_contact_no' => ['required'],
            'vehicle.vehicle_detail' => ['required'],


        ];
    }
    public function message()
    {
        return [
            'license_photo.image' => __('The icon must be an image file.'),
            'license_photo.mimes' => __('The icon must be a file of type: jpeg, png, bmp, gif, svg, webp.'),
        ];
    }

    public function render()
    {
        return view("FuelSettings::livewire.vehicle-form");
    }

    public function mount(Vehicle $vehicle, Action $action)
    {
        $this->vehicle = $vehicle;
        $this->action = $action;
        $this->vehicleCategory = VehicleCategory::whereNull('deleted_at')->get();

        $this->employees = Employee::select('id', 'name')->get();
    }

    public function save()
    {

        $this->validate();
        try{
            if ($this->license_photo) {
                $this->vehicle->license_photo = ImageServiceFacade::compressAndStoreImage($this->license_photo, config('src.FuelSettings.fuelSettings.license_path'), getStorageDisk('public'));
            }
            if ($this->signature) {
                $this->vehicle->signature = ImageServiceFacade::compressAndStoreImage($this->signature, config('src.FuelSettings.fuelSettings.sign_path'), getStorageDisk('public'));
            }

            $dto = VehicleAdminDto::fromLiveWireModel($this->vehicle);
            $service = new VehicleAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash("Vehicle Created Successfully");
                    return redirect()->route('admin.vehicles.index');
                case Action::UPDATE:
                    $service->update($this->vehicle, $dto);
                    $this->successFlash("Vehicle Updated Successfully");
                    return redirect()->route('admin.vehicles.index');
                default:
                    return redirect()->route('admin.vehicles.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
