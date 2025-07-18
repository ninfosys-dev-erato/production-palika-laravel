<x-layout.app header="{{ __('grantmanagement::grantmanagement.group_report') }}">
    <livewire:grant_management.group_report_form :action="App\Enums\Action::CREATE" />
</x-layout.app>