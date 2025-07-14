<x-layout.app header="{{ __('grantmanagement::grantmanagement.farmer_report') }}">
    <livewire:grant_management.farmer_report_form :action="App\Enums\Action::CREATE" />
</x-layout.app>