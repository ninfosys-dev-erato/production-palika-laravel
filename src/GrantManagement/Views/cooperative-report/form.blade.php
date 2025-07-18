<x-layout.app header="{{ __('grantmanagement::grantmanagement.cooperative_report') }}">
    <livewire:grant_management.cooperative_report_form :action="App\Enums\Action::CREATE" />
</x-layout.app>