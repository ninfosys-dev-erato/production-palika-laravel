<x-layout.app header="{{__('grantmanagement::grantmanagement.grant_program_list')}}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('grantmanagement::grantmanagement.grant_program')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{__('grantmanagement::grantmanagement.show')}}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{
    __('grantmanagement::grantmanagement.grant_program_details') }}</h5>
                    </div>
                    <div>

                        <div>
                            <a href="{{ route("admin.grant_programs.index")}}" class="btn btn-info">
                                <i
                                    class="bx bx-list-ol"></i>{{ __('grantmanagement::grantmanagement.grant_program_list') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="row">

                            {{-- Fiscal Year --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.fiscal_year') }}:</strong>
                                {{ $grantProgram['fiscalYear']['year'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Type of Grant --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.grant_type') }}:</strong>
                                {{ $grantProgram['grantType']['title'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Program Name --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.program_name') }}:</strong>
                                {{ $grantProgram['program_name'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.grant_delivered_type') }}:</strong>
                                {{ $grantProgram['grant_provided_type'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            @if(!empty($grantProgram) && $grantProgram['grant_provided_type'] === "cash")
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.grant_amount') }}:</strong>
                                    {{ $grantProgram['grant_amount'] ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                            @elseif(!empty($grantProgram) && $grantProgram['grant_provided_type'] === "gensi")
                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.grant_items') }}:</strong>
                                    {{ $grantProgram['grant_provided'] ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>

                                <div class="mb-3">
                                    <strong>{{ __('grantmanagement::grantmanagement.grant_quantity') }}:</strong>
                                    {{ $grantProgram['grant_provided_quantity'] ?? __('grantmanagement::grantmanagement.n_a') }}
                                </div>
                            @endif

                            {{-- Granting Organization --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.grant_office') }}:</strong>
                                {{ isset($grantProgram['grantingOrganization']['office_name']) ? $grantProgram['grantingOrganization']['office_name'] : __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Branch --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.branch') }}:</strong>
                                {{ isset($grantProgram['branch']['title']) ? $grantProgram['branch']['title'] : __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- For Grant --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.for_grant') }}:</strong>
                                {{ implode(', ', $grantProgram['for_grant'] ?? []) ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                            {{-- Condition --}}
                            <div class="mb-3">
                                <strong>{{ __('grantmanagement::grantmanagement.condition') }}:</strong>
                                {{ $grantProgram['condition'] ?? __('grantmanagement::grantmanagement.n_a') }}
                            </div>

                        </div>
                    </div>


                    <div class="card-footer">
                        <a href="{{ route('admin.grant_programs.index') }}" class="btn btn-danger">
                            {{ __('grantmanagement::grantmanagement.back') }}
                        </a>
                    </div>
                </div>



            </div>
        </div>
    </div>



</x-layout.app>