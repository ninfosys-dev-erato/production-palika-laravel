<x-layout.app header="{{__('Advance Payment '.ucfirst(strtolower($action->value)) .' Form')}} ">
           <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{route('admin.advance_payments.index')}}">{{__('yojana::yojana.advance_payment')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   @if(isset($advancePayment))
                        {{__('yojana::yojana.edit')}}
                    @else
                       {{__('yojana::yojana.create')}}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
    <div class="card">
     <div class="card-header d-flex justify-content-between">
                            @if (!isset($advancePayment))
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ !isset($advancePayment) ? __('yojana::yojana.create_advance_payment') : __('yojana::yojana.update_advance_payment') }}</h5>
                            @endif
                            <div>
                                <a href="{{ route("admin.advance_payments.index")}}"
                                    class="btn btn-info">
                                    <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.advance_payment_list') }}
                                </a>
                            </div>
                        </div>
        @if(isset($advancePayment))
            <livewire:yojana.advance_payment_form  :$action :$advancePayment />
        @else
            <livewire:yojana.advance_payment_form  :$action />
        @endif
    </div>
    </div>
            </div>
        </div>
</x-layout.app>
