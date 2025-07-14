<x-layout.app header="LocalBody  {{ucfirst(strtolower($action->value))}} Form">
    <div class="container-xxl flex-grow-1 container-p-y">

        <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">LocalBody</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($localBody))
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
        @if(isset($localBody))
            <livewire:local_bodies.local_body_form  :$action :$localBody />
        @else
            <livewire:local_bodies.local_body_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
    </div>
</x-layout.app>
