<?php

namespace Src\DigitalBoard\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\DigitalBoard\DTO\NoticeAdminDto;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Service\NoticeAdminService;

use function PHPUnit\Framework\isEmpty;

class NoticeForm extends Component
{
    use SessionFlash, HelperDate, WithFileUploads;

    public ?Notice $notice;
    public ?Action $action;

    public bool $canShowOnAdmin = false;
    public array $wards = [];
    public array $selectedWards = [];

    public $uploadedImage;
    public $existingImage;

    public function rules(): array
    {
        return [
            'notice.title' => ['required'],
            'notice.date' => ['required'],
            'notice.description' => ['required'],
            'uploadedImage' => ['required', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048']
        ];
    }

    public function messages(): array
    {
        return [
            'notice.title.required' => __('digitalboard::digitalboard.the_title_is_required'),
            'notice.date.required' => __('digitalboard::digitalboard.the_date_is_required'),
            'notice.description.required' => __('digitalboard::digitalboard.the_description_is_required'),
            'uploadedImage.required' => __('digitalboard::digitalboard.the_uploaded_image_is_required'),
            'uploadedImage.file' => __('digitalboard::digitalboard.the_uploaded_file_must_be_an_image'),
            'uploadedImage.mimes' => __('digitalboard::digitalboard.the_image_must_be_a_file_of_type_jpeg_png_jpg'),
            'uploadedImage.max' => __('digitalboard::digitalboard.the_image_size_must_not_exceed_2mb'),
        ];
    }

    public function render()
    {
        return view("DigitalBoard::livewire.notices.form");
    }

    public function mount(Notice $notice, Action $action)
    {
        $this->notice = $notice;
        $this->action = $action;
        $this->wards = getWardsArray();

        if ($action === Action::UPDATE) {
            $this->canShowOnAdmin = $notice->can_show_on_admin ?? false;
            $this->notice->date = $this->convertEnglishToNepali($this->notice->date);
            $this->selectedWards = $notice->wards()?->pluck('ward')->toArray() ?? [];
            $this->uploadedImage = $notice->file;
        }
    }

    public function save()
    {
        $this->validate();
        $this->notice->file = $this->storeFile($this->uploadedImage);

        $this->notice->can_show_on_admin = $this->canShowOnAdmin;
        $this->notice->date = $this->convertNepaliToEnglish($this->notice->date);

        $dto = NoticeAdminDto::fromLiveWireModel($this->notice);
        $service = new NoticeAdminService();

        DB::beginTransaction();
        try {
            switch ($this->action) {
                case Action::CREATE:
                    $notice = $service->store($dto);
                    $service->storeNoticeWard($notice, $this->selectedWards);
                    DB::commit();
                    $this->successFlash(__('digitalboard::digitalboard.notice_created_successfully'));
                    return redirect()->route('admin.digital_board.notices.index');
                case Action::UPDATE:
                    $notice = $service->update($this->notice, $dto);
                    $service->storeNoticeWard($notice, $this->selectedWards);
                    DB::commit();
                    $this->successFlash(__('digitalboard::digitalboard.notice_updated_successfully'));
                    return redirect()->route('admin.digital_board.notices.index');
                default:
                    return redirect()->route('admin.digital_board.notices.index');
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('digitalboard::digitalboard.an_error_occurred_during_operation_please_try_again_later'));
        }
    }
    private function storeFile($file): string
    {
        if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
                return ImageServiceFacade::compressAndStoreImage($file, config('src.DigitalBoard.notice.notice_path'));
            }
    
            return FileFacade::saveFile(
                path: config('src.DigitalBoard.notice.notice_path'),
                filename: null,
                file: $file
            );
        }
    
        return '';
    }
}
