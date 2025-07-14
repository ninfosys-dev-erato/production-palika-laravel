<x-layout.app header="Group List">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">Admin Setting</a>
            </li>
            <li class="breadcrumb-item"><a href="#">Group</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Setting Group
                    @perm('group_create')
                        <div>
                            <a href="{{ route('admin.admin_setting.group.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> Add Group</a>

                        </div>
                    @endperm

                </div>
                <div class="card-body">
                    <livewire:admin_settings.group_table theme="bootstrap-4" />
                </div>
            </div>
        </div>

    </div>
</x-layout.app>
