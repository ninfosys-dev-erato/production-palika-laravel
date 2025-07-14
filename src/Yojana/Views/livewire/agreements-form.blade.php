<form wire:submit.prevent="save">

    <div class="col-12">
        <div class="divider divider-primary text-start text-primary">
            <div class="divider-text  fw-bold fs-6  mb-3">
                {{ __('yojana::yojana.contracting_party') }}
            </div>
        </div>
    </div>

    <div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group mb-3'>

                    @if ($model == \Src\Yojana\Enums\ImplementationMethods::OperatedByConsumerCommittee)
                        <label for='consumer_committee_id'
                            class='form-label'>{{ __('yojana::yojana.consumer_committee') }}</label>
                        {{--                            <input wire:model='agreement.consumer_committee_id' name='consumer_committee_id' type='text' class='form-control' readonly> --}}
                        <select disabled wire:model='agreement.consumer_committee_id' name='consumer_committee_id'
                            type='text'
                            class='form-control {{ $errors->has('agreement.consumer_committee_id') ? 'is-invalid' : '' }}'>
                            <option value="" hidden>{{ __('yojana::yojana.select_consumer_committee') }}</option>
                            @foreach ($consumerCommittees as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    @elseif(
                        $model == \Src\Yojana\Enums\ImplementationMethods::OperatedByNGO ||
                            $model == \Src\Yojana\Enums\ImplementationMethods::OperatedByContract ||
                            $model == \Src\Yojana\Enums\ImplementationMethods::OperatedByQuotation)
                        <label for='consumer_committee_id'
                            class='form-label'>{{ __('yojana::yojana.organization') }}</label>
                        {{--                            <input wire:model='agreement.consumer_committee_id' name='consumer_committee_id' type='text' class='form-control' readonly> --}}
                        <select disabled wire:model='agreement.consumer_committee_id' name='consumer_committee_id'
                            type='text'
                            class='form-control {{ $errors->has('agreement.consumer_committee_id') ? 'is-invalid' : '' }}'>
                            <option value="" hidden>{{ __('yojana::yojana.select_organization') }}</option>
                            @foreach ($organizations as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    @elseif($model == \Src\Yojana\Enums\ImplementationMethods::OperatedByTrust)
                        <label for='consumer_committee_id' class='form-label'>{{ __('yojana::yojana.trust') }}</label>
                        {{--                            <input wire:model='agreement.consumer_committee_id' name='consumer_committee_id' type='text' class='form-control' readonly> --}}
                        <select disabled wire:model='agreement.consumer_committee_id' name='consumer_committee_id'
                            type='text'
                            class='form-control {{ $errors->has('agreement.consumer_committee_id') ? 'is-invalid' : '' }}'>
                            <option value="" hidden>{{ __('yojana::yojana.select_organization') }}</option>
                            @foreach ($applications as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>

                    @endif
                    <div>
                        @error('agreement.consumer_committee_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='implementation_method_id'
                        class='form-label'>{{ __('yojana::yojana.implementation_method') }}</label>
                    <select disabled wire:model='agreement.implementation_method_id' name='implementation_method_id'
                        type='text'
                        class='form-control {{ $errors->has('agreement.implementation_method_id') ? 'is-invalid' : '' }}'
                        readonly>
                        <option value="" hidden>{{ __('yojana::yojana.select_implementation_method') }}</option>
                        @foreach ($implementationMethods as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('agreement.implementation_method_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6' wire:ignore>
                <div class='form-group mb-3'>
                    <label for='plan_start_date' class='form-label'>{{ __('yojana::yojana.plan_start_date') }}</label>
                    <input wire:model='agreement.plan_start_date' name='plan_start_date' type='text'
                        class='form-control nepali-date'
                        placeholder="{{ __('yojana::yojana.enter_plan_start_date') }}">
                    <div>
                        @error('agreement.plan_start_date')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6' wire:ignore>
                <div class='form-group mb-3'>
                    <label for='plan_completion_date'
                        class='form-label'>{{ __('yojana::yojana.plan_completion_date') }}</label>
                    <input wire:model='agreement.plan_completion_date' name='plan_completion_date'
                        type='text' class='form-control nepali-date'
                        placeholder="{{ __('yojana::yojana.enter_plan_completion_date') }}">
                    <div>
                        @error('agreement.plan_completion_date')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='experience' class='form-label'>{{ __('yojana::yojana.experience') }}</label>
                    <input wire:model='agreement.experience' name='experience' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_experience') }}">
                    <div>
                        @error('agreement.experience')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="col-12">
        <div class="divider divider-primary text-start text-primary">
            <div class="divider-text  fw-bold fs-6  mt-3">
                {{ __('yojana::yojana.project_cost_statement') }}
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
        <div class="row">
            <div class='col-md-5'>
                <div class='form-group'>
                    <label class="form-label" for='cost_source'>{{ __('yojana::yojana.cost_source') }}</label>
                    <select wire:model='costDetails.cost_source' name='cost_source' type='text'
                        class='form-control {{ $errors->has('costDetails.cost_source') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_cost_source') }}</option>
                        @foreach ($sourceTypes as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('costDetails.cost_source')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-2'>
                <div class='form-group'>
                    <label class="form-label" for='cost_amount'>{{ __('yojana::yojana.amount') }}</label>
                    <input wire:model='costDetails.cost_amount' name='cost_amount' type='number'
                        class='form-control {{ $errors->has('costDetails.cost_amount') ? 'is-invalid' : '' }}'
                        placeholder='{{ __('yojana::yojana.enter_amount') }}'>
                    <div>
                        @error('costDetails.cost_amount')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-2 mt-4 center'>
                <p wire:click="addCostRecord" class="btn btn-info ms-2 mt-1">{{ __('yojana::yojana.add') }}</p>
            </div>
        </div>
    </div>
    </div>

    <div class="card">
        <div class="card-body">
        <h6 class="text-primary">{{ __('yojana::yojana.added_cost_records') }}</h6>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>{{ __('yojana::yojana.sno') }}</th>
                        <th>{{ __('yojana::yojana.source_of_cost') }}</th>
                        <th>{{ __('yojana::yojana.amount') }}</th>
                        <th>{{ __('yojana::yojana.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($costRecords))
                        <tr>
                            <td colspan="8" class="text-muted text-center">
                                {{ __('yojana::yojana.no_records_to_show') }}
                            </td>
                        </tr>
                    @else
                        @foreach ($costRecords as $index => $costRecord)
                        <tr class="text-center">
                            <td>{{ replaceNumbersWithLocale($index + 1, true) }}</td>
                            <td>{{ $sourceTypes[$costRecord['cost_source']] ?? '-' }}</td>
                            <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($costRecord['cost_amount'] ?? 0), true) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger"
                                    wire:click="removeCostRecord('{{ $index }}')">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <div class="col-12">
        <div class="divider divider-primary text-start text-primary">
            <div class="divider-text  fw-bold fs-6  mt-3">
                {{ __('yojana::yojana.statement_of_substantive_grants') }}
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class='col-md-6'>
                    <div class='form-group mb-3'>
                        <label for='source_type_id' class='form-label'>{{ __('yojana::yojana.source_type') }}</label>
                        {{--        <input wire:model='agreementGrant.source_type_id' name='source_type_id' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_source_type_id')}}"> --}}
                        <select wire:model='agreementGrant.source_type_id' name='source_type_id' type='text'
                            class='form-control {{ $errors->has('agreementGrant.source_type_id') ? 'is-invalid' : '' }}'>
                            <option value="" hidden>{{ __('yojana::yojana.select_source_type') }}</option>
                            @foreach ($sourceTypes as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('agreementGrant.source_type_id')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class='form-group mb-3'>
                        <label for='material_name' class='form-label'>{{ __('yojana::yojana.material_name') }}</label>
                        <input wire:model='agreementGrant.material_name' name='material_name' type='text'
                            class='form-control' placeholder="{{ __('yojana::yojana.enter_material_name') }}">
                        <div>
                            @error('agreementGrant.material_name')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class='form-group mb-3'>
                        <label for='unit' class='form-label'>{{ __('yojana::yojana.unit') }}</label>
                        <input wire:model='agreementGrant.unit' name='unit' type='text' class='form-control'
                            placeholder="{{ __('yojana::yojana.enter_unit') }}">
                        <div>
                            @error('agreementGrant.unit')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class='form-group mb-3'>
                        <label for='amount' class='form-label'>{{ __('yojana::yojana.amount') }}</label>
                        <input wire:model='agreementGrant.amount' name='amount' type='number' class='form-control'
                            placeholder="{{ __('yojana::yojana.enter_amount') }}">
                        <div>
                            @error('agreementGrant.amount')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-header d-flex justify-content-end">
                    <button type="button" class="btn btn-info" wire:click="addGrantRecord">
                        {{ __('yojana::yojana.add') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6 class="text-primary">{{ __('yojana::yojana.added_grants') }}</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>{{ __('yojana::yojana.sno') }}</th>
                            <th>{{ __('yojana::yojana.source_type') }}</th>
                            <th>{{ __('yojana::yojana.material_name') }}</th>
                            <th>{{ __('yojana::yojana.unit') }}</th>
                            <th>{{ __('yojana::yojana.amount') }}</th>
                            <th>{{ __('yojana::yojana.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($grantRecords))
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    {{ __('yojana::yojana.no_grant_records_added') }}
                                </td>
                            </tr>
                        @endif

                        @foreach ($grantRecords as $index => $grant)
                            <tr class="text-center">
                                <td>{{ replaceNumbersWithLocale($index + 1, true) }}</td>
                                <td>{{ $sourceTypes[$grant['source_type_id']] }}</td>
                                <td>{{ $grant['material_name'] }}</td>
                                <td>{{ $grant['unit'] }}</td>
                                <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($grant['amount'] ?? 0), true) }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        wire:click="removeGrantRecord({{ $index }})">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="divider divider-primary text-start text-primary">
            <div class="divider-text  fw-bold fs-6  mt-3">
                {{ __('yojana::yojana.beneficiary_details') }}
            </div>
        </div>
    </div>

    <div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='beneficiary_id' class='form-label'>{{ __('yojana::yojana.beneficiary') }}</label>
                    {{--        <input wire:model='agreementBeneficiary.beneficiary_id' name='beneficiary_id' type='text' class='form-control' placeholder="{{__('yojana::yojana.enter_beneficiary_id')}}"> --}}
                    <select wire:model='agreementBeneficiary.beneficiary_id' name='beneficiary_id' type='text'
                        class='form-control {{ $errors->has('agreementBeneficiary.beneficiary_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_beneficiary') }}</option>
                        @foreach ($beneficiaries as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('agreementBeneficiary.beneficiary_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='total_count' class='form-label'>{{ __('yojana::yojana.total_count') }}</label>
                    <input wire:model='agreementBeneficiary.total_count' name='total_count' type='number'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_total_count') }}">
                    <div>
                        @error('agreementBeneficiary.total_count')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='men_count' class='form-label'>{{ __('yojana::yojana.men_count') }}</label>
                    <input wire:model='agreementBeneficiary.men_count' name='men_count' type='number'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_men_count') }}">
                    <div>
                        @error('agreementBeneficiary.men_count')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='women_count' class='form-label'>{{ __('yojana::yojana.women_count') }}</label>
                    <input wire:model='agreementBeneficiary.women_count' name='women_count' type='number'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_women_count') }}">
                    <div>
                        @error('agreementBeneficiary.women_count')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-header d-flex justify-content-end">
                <button type="button" class="btn btn-info" wire:click="addBeneficiaryRecord">
                    {{ __('yojana::yojana.add') }}
                </button>
            </div>
        </div>
    </div>
    </div>
    <div class="card">
    <div class="card-body">
        <h6 class="text-primary">{{ __('yojana::yojana.added_beneficiaries') }}</h6>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>{{ __('yojana::yojana.sno') }}</th>
                        <th>{{ __('yojana::yojana.beneficiary') }}</th>
                        <th>{{ __('yojana::yojana.total_count') }}</th>
                        <th>{{ __('yojana::yojana.men_count') }}</th>
                        <th>{{ __('yojana::yojana.women_count') }}</th>
                        <th>{{ __('yojana::yojana.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($beneficiaryRecords))
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                {{ __('yojana::yojana.no_beneficiary_records_added') }}
                            </td>
                        </tr>
                    @endif

                    @foreach ($beneficiaryRecords as $index => $beneficiary)
                        <tr class="text-center">
                            <td>{{ replaceNumbersWithLocale($index + 1, true) }}</td>
                            <td>{{ $beneficiaries[$beneficiary['beneficiary_id']] }}</td>
                            <td>{{ replaceNumbersWithLocale($beneficiary['total_count'] ?? '-', true) }}</td>
                            <td>{{ replaceNumbersWithLocale($beneficiary['men_count'] ?? '-', true) }}</td>
                            <td>{{ replaceNumbersWithLocale($beneficiary['women_count'] ?? '-', true) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger"
                                    wire:click="removeBeneficiaryRecord({{ $index }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>


    <div class="divider divider-primary text-start text-primary">
        <div class="divider-text  fw-bold fs-6  mt-3">
            {{ __('yojana::yojana.payment_installment_details') }}
        </div>
    </div>

    <div class="card">
    <div class="col-md-12">
        <div class="card-body">
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                        name="basedOnWorkProgress" id="basedOnWorkProgress" wire:change="toggleInstallmentTable">
                    <label class="form-check-label form-label" for="basedOnWorkProgress">
                        {{ __('yojana::yojana.is_based_on_work_progress') }}
                    </label>
                </div>
            </div>

            @if ($basedOnWorkProgress == false)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>{{ __('yojana::yojana.installment') }}</th>
                                <th>{{ __('yojana::yojana.installment_approximate_release_date') }}</th>
                                <th>{{ __('yojana::yojana.cash_in_amount') }}</th>
                                <th>{{ __('yojana::yojana.goods_in_amount') }}</th>
                                <th>{{ __('yojana::yojana.percentage') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @for ($i = 0; $i <= 2; $i++)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td wire:ignore>
                                    <input wire:model="installmentDetails.{{ $i }}.release_date"
                                        type="text" class="form-control nepali-date">
                                </td>
                                <td>
                                    <input wire:model="installmentDetails.{{ $i }}.cash_amount"
                                        type="number" class="form-control">
                                </td>
                                <td>
                                    <input wire:model="installmentDetails.{{ $i }}.goods_amount"
                                        type="number" class="form-control">
                                </td>
                                <td>
                                    <input wire:model="installmentDetails.{{ $i }}.percentage"
                                        type="number" class="form-control">
                                </td>
                            </tr>
                        @endfor
            </tbody>
            </table>
        </div>
        @endif
            <div class="row mt-2">

            <div class="col-md-3 mt-3">
                <div class="form-check">
                    <input class="form-check-input m-1" type="checkbox" wire:model="isDepositRequired"
                           name="isDepositRequired" id="isDepositRequired" wire:change="toggleDepositField">
                    <label class="form-check-label form-label" for="isDepositRequired">
                        {{ __('yojana::yojana.is_deposit_required') }}
                    </label>
                </div>
            </div>

            <div class='col-md-3'>
                <div class='form-group mb-3'>
                    <label for='deposit_number' class='form-label'>{{ __('yojana::yojana.deposit_number') }}</label>
                    <input wire:model='agreement.deposit_number' name='deposit_number' type='number' class='form-control' @if(!$isDepositRequired) disabled @endif>
                    <div>
                        @error('agreement.deposit_number')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            </div>

    </div>
    </div>
    </div>

    <div class="col-12">
        <div class="divider divider-primary text-start text-primary">
            <div class="divider-text  fw-bold fs-6  mt-3">
                {{ __('yojana::yojana.signature') }}
            </div>
        </div>
    </div>

    <div class="card mb-3">
    <div class="card-body">

        <div class="row">
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='signature_party'
                           class='form-label'>{{ __('yojana::yojana.signature_party') }}</label>

                    <select name="signature_party"
                            class="form-control {{ $errors->has('agreement.consumer_committee_id') ? 'is-invalid' : '' }}"
                            wire:change="loadParty($event.target.value)">
                        <option value="">{{ __('yojana::yojana.select_signature_party') }}</option>
                        @foreach ($signatureParties as $signatureParty)
                            <option value="{{ $signatureParty->value }}">{{ $signatureParty->label() }}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('agreementSignatureDetail.signature_party')
                        <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            @if($isOption == true)
                <div class='col-md-6'>
                    <div class='form-group mb-3'>
                        <label for='name' class='form-label'>{{ __('yojana::yojana.name') }}</label>
                        <select name='name' type='text' wire:change="loadDetails($event.target.value)"
                                class='form-control {{ $errors->has('agreementSignatureDetail.name') ? 'is-invalid' : '' }}'>
                            <option value="" hidden>{{ __('yojana::yojana.select') }}</option>
                            @foreach ($partyNames as $party)
                                <option value="{{ $party->id }}">{{ $party->name}} | {{ __('yojana::yojana.designation') . ' :- ' . (
                                    is_object($party->designation)
                                        ? (method_exists($party->designation, 'label')
                                            ? $party->designation->label()
                                            : ($party->designation->title ?? '')
                                        )
                                        : ''
                                ) }}</option>
                            @endforeach
                        </select>
                        <div>
                            @error('agreementSignatureDetail.name')
                            <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            @else
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='name' class='form-label'>{{ __('yojana::yojana.name') }}</label>
                    <input wire:model='agreementSignatureDetail.name' name='name' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_name') }}">
                    <div>
                        @error('agreementSignatureDetail.name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            @endif
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='position' class='form-label'>{{ __('yojana::yojana.position') }}</label>
                    <input wire:model='agreementSignatureDetail.position' name='position' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_position') }}">
                    <div>
                        @error('agreementSignatureDetail.position')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='address' class='form-label'>{{ __('yojana::yojana.address') }}</label>
                    <input wire:model='agreementSignatureDetail.address' name='address' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_address') }}">
                    <div>
                        @error('agreementSignatureDetail.address')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group mb-3'>
                    <label for='contact_number' class='form-label'>{{ __('yojana::yojana.contact_number') }}</label>
                    <input wire:model='agreementSignatureDetail.contact_number' name='contact_number' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_contact_number') }}">
                    <div>
                        @error('agreementSignatureDetail.contact_number')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6' wire:ignore>
                <div class='form-group mb-3'>
                    <label for='date' class='form-label'>{{ __('yojana::yojana.date') }}</label>
                    <input wire:model='agreementSignatureDetail.date' name='date' type='text'
                        class='form-control nepali-date' placeholder="{{ __('yojana::yojana.enter_date') }}">
                    <div>
                        @error('agreementSignatureDetail.date')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-header d-flex justify-content-end">
                <button type="button" class="btn btn-info " wire:click="addSignatureRecord">
                    {{ __('yojana::yojana.add') }}
                </button>
            </div>

        </div>
    </div>
    </div>

    <div class="card">
    <div class="card-body">
            <h6 class="text-primary">{{ __('yojana::yojana.signature_details') }}</h6>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>{{ __('yojana::yojana.sno') }}</th>
                        <th>{{ __('yojana::yojana.name') }}</th>
                        <th>{{ __('yojana::yojana.position') }}</th>
                        <th>{{ __('yojana::yojana.address') }}</th>
                        <th>{{ __('yojana::yojana.contact_number') }}</th>
                        <th>{{ __('yojana::yojana.date') }}</th>
                        <th>{{ __('yojana::yojana.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($signatureRecords))
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                {{ __('yojana::yojana.no_signature_records_added') }}
                            </td>
                        </tr>
                    @endif

                    @foreach ($signatureRecords as $index => $signature)
                        <tr class="text-center">
                            <td>{{ replaceNumbersWithLocale($index + 1, true) }}</td>
                            <td>{{ $signature['name'] }}</td>
                            <td>{{ $signature['position'] }}</td>
                            <td>{{ $signature['address'] }}</td>
                            <td>{{ replaceNumbers($signature['contact_number'] ?? '-', true) }}</td>
                            <td>{{ $signature['date'] }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger"
                                    wire:click="removeSignatureRecord({{ $index }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
    </div>
</form>
