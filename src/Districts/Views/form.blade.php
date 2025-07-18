<x-layout.app header="District  {{ucfirst(strtolower($action->value))}} Form">
    <div class="container-xxl flex-grow-1 container-p-y">

        <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">District</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($district))
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
        @if(isset($district))
            <livewire:districts.district_form  :$action :$district />
        @else
            <livewire:districts.district_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
    </div>
</x-layout.app>
