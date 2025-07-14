<x-layout.app header="Manage Roles">
    <div class="card">
        <div class="card-header">
            <h5 class="text-primary fw-bold">{{ __('Assign Permission') }}</h5>
            <small>नोट: कुनै पनि मोड्युलमा सम्पादन, हटाउने वा अन्य अनुमति सम्बन्धी कार्यहरू गर्नको लागि, तपाईंले सबैभन्दा पहिले सो मोड्युल हेर्न सक्ने अनुमति पाउनुपर्छ। यसले सुनिश्चित गर्छ कि पहुँच केवल अधिकृत प्रयोगकर्ताहरूलाई मात्र दिइएको छ।'</small>
        </div>
        <div class="card-body">
            <livewire:roles.manage_role_permission />
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-danger">{{__('Back')}}</a>
        </div>
    </div>
</x-layout.app>
