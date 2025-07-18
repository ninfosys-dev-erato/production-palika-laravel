<x-layout.app header="Agenda List">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-6">
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start gap-2 align-items-sm-center gap-6 pb-4 border-bottom">
                        <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt="user-avatar"
                            class="d-block w-px-100  rounded" id="uploadedAvatar">
                        <div>

                            <h5>{{ auth()->user()->name }}</h5>
                            <h6>{{ auth()->user()->email }}</h6>


                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 ">
                    <livewire:profile.profile_form />
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.1.0/ckeditor5.css">
    @endpush
</x-layout.app>
