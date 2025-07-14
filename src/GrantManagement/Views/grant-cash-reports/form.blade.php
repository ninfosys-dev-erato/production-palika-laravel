<x-layout.app header="{{ __('grantmanagement::grantmanagement.grant_cash_report') }}">
    <livewire:grant_management.cash_grant_report_form :action="App\Enums\Action::CREATE" />
</x-layout.app>