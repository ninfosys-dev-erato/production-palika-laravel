<?php

namespace Src\DigitalBoard\Livewire;

use App\Enums\Action;
use App\Facades\ImageServiceFacade;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\DigitalBoard\DTO\PopUpAdminDto;
use Src\DigitalBoard\Models\PopUp;
use Src\DigitalBoard\Service\PopUpAdminService;

class PopUpForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?PopUp $popUp;
    public ?Action $action;

    public $uploadedImage;
    public bool $isActive = false;
    public bool $canShowOnAdmin = false;
    public array $wards = [];
    public array $selectedWards = [];

    public function rules(): array
    {
        return [
            'popUp.title' => ['required'],
            'uploadedImage' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'popUp.display_duration' => ['required', 'integer', 'min:1'],
            'popUp.iteration_duration' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'popUp.title.required' => __('digitalboard::digitalboard.the_title_is_required'),
            'uploadedImage.required' => __('digitalboard::digitalboard.the_uploaded_image_is_required'),
            'uploadedImage.image' => __('digitalboard::digitalboard.the_uploaded_file_must_be_an_image'),
            'uploadedImage.mimes' => __('digitalboard::digitalboard.the_image_must_be_a_file_of_type_jpeg_png_jpg_gif'),
            'uploadedImage.max' => __('digitalboard::digitalboard.the_image_size_must_not_exceed_2mb'),
            'popUp.display_duration.required' => __('digitalboard::digitalboard.the_display_duration_is_required'),
            'popUp.display_duration.integer' => __('digitalboard::digitalboard.the_display_duration_must_be_an_integer'),
            'popUp.display_duration.min' => __('digitalboard::digitalboard.the_display_duration_must_be_at_least_1'),
            'popUp.iteration_duration.required' => __('digitalboard::digitalboard.the_iteration_duration_is_required'),
            'popUp.iteration_duration.integer' => __('digitalboard::digitalboard.the_iteration_duration_must_be_an_integer'),
            'popUp.iteration_duration.min' => __('digitalboard::digitalboard.the_iteration_duration_must_be_at_least_1'),
        ];
    }

    public function render()
    {
        return view("DigitalBoard::livewire.popup.form");
    }

    public function mount(PopUp $popUp, Action $action)
    {
        $this->popUp = $popUp;
        $this->action = $action;

        $this->wards = getWardsArray();

        if ($popUp->exists) {
            $this->canShowOnAdmin = $popUp->can_show_on_admin ?? false;
            $this->isActive = $popUp->is_active ?? false;
            $this->selectedWards = $popUp->wards()?->pluck('ward')->toArray() ?? [];
            $this->uploadedImage = $popUp->photo;
        }
    }

    public function save()
    {
        $this->validate();

        if (
            $this->uploadedImage && $this->uploadedImage instanceof \Illuminate\Http\File ||
            $this->uploadedImage instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ||
            $this->uploadedImage instanceof \Illuminate\Http\UploadedFile
        ) {
            $path = ImageServiceFacade::compressAndStoreImage(image: $this->uploadedImage, path: config('src.DigitalBoard.popup.popup_path'), disk: getStorageDisk('public'));
            $this->popUp->photo = $path;
        }
        $this->popUp->can_show_on_admin = $this->canShowOnAdmin;
        $this->popUp->is_active = $this->isActive;

        $dto = PopUpAdminDto::fromLiveWireModel($this->popUp);
        $service = new PopUpAdminService();

        DB::beginTransaction();

        try {
            switch ($this->action) {
                case Action::CREATE:
                    $popup = $service->store($dto);
                    $service->storePopupWards($popup, $this->selectedWards);
                    DB::commit();

                    $this->successFlash(__("Pop Up Created Successfully"));
                    return redirect()->route('admin.digital_board.pop_ups.index');

                case Action::UPDATE:
                    $popup =  $service->update($this->popUp, $dto);
                    $service->storePopupWards($popup, $this->selectedWards);
                    DB::commit();

                    $this->successFlash(__("Pop Up Updated Successfully"));
                    return redirect()->route('admin.digital_board.pop_ups.index');

                default:
                    return redirect()->route('admin.digital_board.pop_ups.index');
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('digitalboard::digitalboard.an_error_occurred_during_operation_please_try_again_later'));
        }
    }
}
