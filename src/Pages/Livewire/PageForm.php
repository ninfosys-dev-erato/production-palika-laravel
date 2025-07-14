<?php

namespace Src\Pages\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Src\Pages\DTO\PageAdminDto;
use Src\Pages\Models\Page;
use Src\Pages\Service\PageAdminService;

class PageForm extends Component
{
    use SessionFlash;

    public ?Page $page;
    public ?Action $action;

    public function rules(): array
    {
        $slugRule = $this->action === Action::CREATE
            ? ['required', Rule::unique('tbl_pages', 'slug')]
            : ['nullable', Rule::unique('tbl_pages', 'slug')->ignore($this->page->id)->whereNull('deleted_at')];

        return [
            'page.slug' => $slugRule,
            'page.title' => ['required'],
            'page.content' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'page.slug.required' => __('The slug field is required.'),
            'page.slug.unique' => __('The slug must be unique.'),
            'page.title.required' => __('pages::pages.title_is_required'),
            'page.content.required' => __('pages::pages.content_is_required'),
        ];
    }


    public function render()
    {
        return view("Pages::livewire.form");
    }

    public function mount(Page $page, Action $action)
    {
        $this->page = $page;
        $this->action = $action;
    }

    public function cleanHtml($content)
    {
        $content = str_replace(['<pre>', '</pre>', '<code class="language-plaintext">', '</code>'], '', $content);
        return $content;    
    }

    public function save()
    {
        $this->validate();

        $this->page['content'] = html_entity_decode($this->page['content']);
        $this->page['content'] = $this->cleanHtml($this->page['content']);

        try{
            $dto = PageAdminDto::fromLiveWireModel($this->page);
            $service = new PageAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('pages::pages.page_created_successfully'));
                    return redirect()->route('admin.pages.index');
                case Action::UPDATE:
                    $service->update($this->page, $dto);
                    $this->successFlash(__('pages::pages.page_updated_successfully'));
                    return redirect()->route('admin.pages.index');
                default:
                    return redirect()->route('admin.pages.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
