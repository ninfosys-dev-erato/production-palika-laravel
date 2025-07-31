<?php

namespace Src\DigitalBoard\Livewire;

use App\Enums\Action;
use App\Facades\ImageServiceFacade;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\DigitalBoard\DTO\ProgramAdminDto;
use Src\DigitalBoard\Models\Program;
use Src\DigitalBoard\Service\ProgramAdminService;

class ProgramForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?Action $action;

    public bool $canShowOnAdmin = false;
    public $uploadedImage;
    public $existingImage;
    public array $wards = [];
    public array $selectedWards = [];

    public $program;
    public function rules(): array
    {
        return [
            'program.title' => ['required'],
            'uploadedImage' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ];
    }

    public function messages(): array
    {
        return [
            'program.title.required' => __('digitalboard::digitalboard.the_title_is_required'),
            'uploadedImage.required' => __('digitalboard::digitalboard.the_uploaded_image_is_required'),
            'uploadedImage.image' => __('digitalboard::digitalboard.the_uploaded_file_must_be_an_image'),
            'uploadedImage.mimes' => __('digitalboard::digitalboard.the_image_must_be_a_file_of_type_jpeg_png_jpg_gif'),
            'uploadedImage.max' => __('digitalboard::digitalboard.the_image_size_must_not_exceed_2mb'),
        ];  
    }

    public function render()
    {
        return view("DigitalBoard::livewire.programs.form");
    }

    public function mount(Program $program, Action $action)
    {
        $this->program = $program;
        $this->action = $action;
        $this->wards = getWardsArray();

        if ($program->exists) {
            $this->canShowOnAdmin = $program->can_show_on_admin ?? false;
            $this->selectedWards = $program->wards()?->pluck('ward')->toArray() ?? [];
            $this->uploadedImage = $program->photo;
        }
    }

    public function save()
    {
        $this->validate();
        if($this->uploadedImage && $this->uploadedImage instanceof \Illuminate\Http\File ||
        $this->uploadedImage instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile ||
        $this->uploadedImage instanceof \Illuminate\Http\UploadedFile)
        {
            $path = ImageServiceFacade::compressAndStoreImage(image: $this->uploadedImage, path: config('src.DigitalBoard.program.photo_path'), disk: getStorageDisk('public'));
            $this->program->photo = $path;
        }
        
        $this->program->can_show_on_admin = $this->canShowOnAdmin;

        $dto = ProgramAdminDto::fromLiveWireModel($this->program);
        $service = new ProgramAdminService();

        DB::beginTransaction();
        try {
            switch ($this->action) {
                case Action::CREATE:
                    $program = $service->store($dto);
                    $service->storeProgramWard($program, $this->selectedWards);
                    DB::commit();
                    $this->successFlash(__("Program Created Successfully"));
                    return redirect()->route('admin.digital_board.programs.index');
                case Action::UPDATE:
                    $program = $service->update($this->program, $dto);
                    $service->storeProgramWard($program, $this->selectedWards);
                    DB::commit();
                    $this->successFlash(__("Program Updated Successfully"));
                return redirect()->route('admin.digital_board.programs.index');
                default:
                    return redirect()->route('admin.digital_board.notices.index');
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('digitalboard::digitalboard.an_error_occurred_during_operation_please_try_again_later'));
        }
    }
}
