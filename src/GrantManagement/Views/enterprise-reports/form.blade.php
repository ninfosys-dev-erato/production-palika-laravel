<x-layout.app header="{{ __('grantmanagement::grantmanagement.enterprise_report') }}">
    <livewire:grant_management.enterprise_report_form :action="App\Enums\Action::CREATE" />
</x-layout.app>