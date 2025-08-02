<?php

namespace Src\Settings\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\WithPagination;
use Src\Settings\Models\LetterHeadSample;
use Src\Settings\Service\LetterHeadSampleAdminService;
use App\Traits\HelperTemplate;

class LetterHeadSampleDisplay extends Component
{
    use SessionFlash, WithPagination, HelperTemplate;

    public $globalData;




    public function render()
    {
        $letterHeads = LetterHeadSample::whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($letterHead) {
                $globalData = $this->getGlobalData(null);
                $letterHead->content = str_replace(
                    array_keys($globalData),
                    array_values($globalData),
                    $letterHead->content
                );
                return $letterHead;
            });

        return view('Settings::livewire.letterHeadSample.display', compact('letterHeads'));
    }

    public function edit($id)
    {
        if (!can('letter_head_sample_update')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        return redirect()->route('admin.letter-head-sample.edit', ['id' => $id]);
    }

    public function delete($id)
    {
        if (!can('letter_head_sample_delete')) {
            self::WARNING_FLASH('You Cannot Perform this action');
            return false;
        }
        $service = new LetterHeadSampleAdminService();
        $service->delete(LetterHeadSample::findOrFail($id));
        $this->successFlash("Letter Head Sample Deleted Successfully");
        $this->dispatch('$refresh');
    }
}
