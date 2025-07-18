<x-layout.app header="Province  {{ucfirst(strtolower($action->value))}} Form">
    <div class="container-xxl flex-grow-1 container-p-y">

        <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">Province</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($province))
                        Create
                    @else
                        Edit
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
        @if(isset($province))
            <livewire:provinces.province_form  :$action :$province />
        @else
            <livewire:provinces.province_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
    </div>
</x-layout.app>
