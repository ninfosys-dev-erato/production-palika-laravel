<?php

namespace Src\Downloads\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\ImageServiceFacade;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Downloads\DTO\DownloadAdminDto;
use Src\Downloads\Models\Download;
use Src\Downloads\Service\DownloadAdminService;

class DownloadForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?Download $download;
    public ?Action $action;
    public $files = [];

    public $existingImages = [];

    public function rules(): array
    {
        return [
    'download.title' => ['required'],
    'download.title_en' => ['required'],
    'files.*' => ['file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048'], 
    'download.status' => ['required'],
    'download.order' => ['required'],
];
    }

    public function messages(): array
    {
        return [
           'download.title.required' => __('downloads::downloads.the_title_is_required.'),
           'download.title_en.required' => __('downloads::downloads.the_english_title_is_required.'),
           'files.*.file' => __('downloads::downloads.each_file_must_be_a_valid_file.'),
           'files.*.mimes' => __('downloads::downloads.the_file_must_be_a_pdf,_doc,_docx,_jpg,_jpeg,_or_png.'),
           'files.*.max' => __('downloads::downloads.the_file_must_not_exceed_2mb_in_size.'),
           'download.status.required' => __('downloads::downloads.the_status_is_required.'),
           'download.order.required' => __('downloads::downloads.the_order_is_required.'),
        ];
    }

    public function render(){
        return view("Downloads::livewire.form");
    }

    public function mount(Download $download,Action $action)
    {
        $this->download = $download;
        $this->download->status = 'active';
        $this->action = $action;
        $this->existingImages = $this->download->files;
    }

    public function save()
    {
        $this->validate();

        try{
            $storedDocuments = $this->files ? $this->processFiles($this->files) : [];

            $this->download->files = $storedDocuments;  

            $dto = DownloadAdminDto::fromLiveWireModel($this->download);
            $service = new DownloadAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('downloads::downloads.download_created_successfully'));
                    return redirect()->route('admin.downloads.index');
                case Action::UPDATE:
                    $service->update($this->download,$dto);
                    $this->successFlash(__('downloads::downloads.downloads::downloads.0'));
                    return redirect()->route('admin.downloads.index');
                default:
                    return redirect()->route('admin.downloads.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(__('downloads::downloads.something_went_wrong_while_saving') . $e->getMessage());
        }
    }

    private function processFiles(array|string $files): array
    {
        $storedFiles = [];
        foreach ($files as $file) {
            if($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
            $storedFiles[] = $this->storeFile($file);
        }
        return $storedFiles;
    }

    private function storeFile($file): string
    {
        if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
            return ImageServiceFacade::compressAndStoreImage($file,  config('src.Downloads.download.file_path'));
        }

        return FileFacade::saveFile(
            path: config('src.Downloads.download.file_path'),
            filename: null,
            file: $file
        );
    }
}
