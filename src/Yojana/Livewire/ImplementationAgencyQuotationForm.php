<?php
namespace Src\Yojana\Livewire;

use Livewire\Component;

class ImplementationAgencyQuotationForm extends Component
{
    public array $quotations = [];

    protected $validationAttributes = [
        'quotations.*.name' => 'quotations name',
        'quotations.*.address' => 'quotations address',
        'quotations.*.amount' => 'quotations amount',
        'quotations.*.date' => 'quotations date',
        'quotations.*.percentage' => 'quotations percentage',
    ];

    public function mount()
    {
        // Start with 3 empty rows
        $this->quotations = array_fill(0, 3, [
            'name' => '',
            'address' => '',
            'amount' => '',
            'date' => '',
            'percentage' => '',
        ]);
    }

    public function addQuotation()
    {
        $this->quotations[] = [
            'name' => '',
            'address' => '',
            'amount' => '',
            'date' => '',
            'percentage' => '',
        ];
    }

    public function removeQuotation($index)
    {
        unset($this->quotations[$index]);
        $this->quotations = array_values($this->quotations); // reindex
    }

    public function save()
    {
        // Example validation, tweak as needed
        $this->validate([
            'quotations.*.name' => 'required|string',
            'quotations.*.address' => 'required|string',
            'quotations.*.amount' => 'required|numeric',
            'quotations.*.date' => 'required|date',
            'quotations.*.percentage' => 'required|numeric|min:0|max:100',
        ]);

        session()->flash('success', 'Quotations saved successfully!');
    }

    public function render()
    {
        return view('Yojana::livewire.implementation-agencies.quotation-form');
    }
}
