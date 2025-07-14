<x-layout.app header="{{ __('grantmanagement::grantmanagement.grant_release_report') }}">
    <livewire:grant_management.grant_release_report_form :action="App\Enums\Action::CREATE" />
</x-layout.app>