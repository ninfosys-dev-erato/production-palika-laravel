<div>
    <div class="container mt-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <button type="button" class="btn btn-info" onclick="history.back()">
                    <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
                </button>
            </div>
        </div>

        @if (isset($mapApplySteps) && $mapApplySteps->isNotEmpty())
            @foreach ($mapApplySteps as $index => $step)
                @if ($step->mapApplyStepTemplates->isNotEmpty())
                    @foreach ($step->mapApplyStepTemplates as $letter)
                        @if ($letter->form_id)
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-danger" wire:click="print({{ $letter->id }})"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Print">
                                    <i class="bx bx-printer"></i> {{ __('ebps::ebps.print') }}
                                </button>
                            </div>

                            @php
                                $form = Src\Settings\Models\Form::find($letter->form_id);
                            @endphp

                            <div class="col-md-12 mt-3">
                                <div style="border-radius: 10px; text-align: center; padding: 20px;">
                                    <div id="printContent" class="a4-container">
                                        <style>
                                            {{ $form?->styles ?? '' }}
                                        </style>
                                        {!! $letter->template !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @endif

        @if (isset($files) && count($files) > 0)
            <div class="mt-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-white"
                        style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <h5 class="mb-0"><i class="bx bx-file me-2"></i>{{ __('Uploaded Files') }}</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 80px;">{{ __('क्र.स') }}</th>
                                        <th class="text-center">{{ __('File Name') }}</th>
                                        <th class="text-center">{{ __('फाइल') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $index => $file)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $file->title }}</td>
                                            <td class="text-center">
                                                @if ($file->file)
                                                    <a href="{{ customFileAsset(config('src.Ebps.ebps.path'), $file->file, 'local', 'tempUrl') }}"
                                                        target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="bx bx-show me-1"></i> {{ __('View') }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">{{ __('No file') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        @endif
    </div>


    <style>
        /* Ensure A4 Size */
        .a4-container {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: auto;
            background: white;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            text-align: left;
        }

        /* Print Styling */
        @media print {
            body {
                background: white !important;
            }

            .btn {
                display: none;
            }

            .a4-container {
                width: 210mm;
                height: 297mm;
                box-shadow: none;
                margin: 0;
                padding: 20mm;
                page-break-after: always;
            }
        }
    </style>


</div>
