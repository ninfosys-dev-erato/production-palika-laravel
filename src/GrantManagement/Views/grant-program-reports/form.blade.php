<x-layout.app header="{{ __('grantmanagement::grantmanagement.grant_program_report') }}">
    <livewire:grant_management.grant_program_report_form :action="App\Enums\Action::CREATE" />
</x-layout.app>