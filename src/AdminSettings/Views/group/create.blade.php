<x-layout.app header="Group {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">Admin Setting</a>
            </li>
            <li class="breadcrumb-item"><a href="#">Group</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ ucfirst(strtolower($action->value)) }}
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Group {{ ucfirst(strtolower($action->value)) }}
                    <div>
                        @perm('letter_head access')
                            <a href="{{ route('admin.admin_setting.group.index') }}" class="btn btn-info"><i
                                    class="bx bx-list-ol"></i>Group List</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($group))
                        <livewire:admin_settings.group_form :$action :$group />
                    @else
                        <livewire:admin_settings.group_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
