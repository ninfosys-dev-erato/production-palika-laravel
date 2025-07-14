<x-layout.app header="{{ __('yojana::yojana.plan_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        @if ($category == 'plan')
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.plan.index') }}">{{ __('yojana::yojana.plan_management') }}</a>
                <li class="breadcrumb-item"><a href="#">{{ __('yojana::yojana.plan') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('yojana::yojana.list') }}</li>
            </ol>
        @elseif($category == 'program')
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.programs.index') }}">{{ __('yojana::yojana.plan_management') }}</a>
                <li class="breadcrumb-item"><a href="#">{{ __('yojana::yojana.program') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('yojana::yojana.list') }}</li>
            </ol>
        @endif
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    @if ($category == 'plan')
                        <div class="d-flex justify-content-between card-header">
                            <h5 class="text-primary fw-bold mb-0">{{ __('yojana::yojana.plan_list') }}</h5>
                        </div>
                        <div>
                            @perm('plans create')
                                <a href="{{ route('admin.plans.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                                    {{ __('yojana::yojana.add_plan') }}</a>
                            @endperm
                        </div>
                    @elseif($category == 'program')
                        <div class="d-flex justify-content-between card-header">
                            <h5 class="text-primary fw-bold mb-0">{{ __('yojana::yojana.program_list') }}</h5>
                        </div>
                        <div>
                            @perm('plans create')
                                <a href="{{ route('admin.programs.create') }}" class="btn btn-info"><i
                                        class="bx bx-plus"></i>
                                    {{ __('yojana::yojana.add_program') }}</a>
                            @endperm
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <livewire:yojana.plan_table theme="bootstrap-4" :$category />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
