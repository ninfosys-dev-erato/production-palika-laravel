<div>
    <div class="container mt-3">
        @foreach ($mapApplySteps as $index => $step)
            @foreach ($step->mapApplyStepTemplates as $letter)
                @php
                    $form = Src\Settings\Models\Form::findOrFail($letter->form_id);
                @endphp

                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-info" onclick="history.back()">
                        <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
                    </button>


                    <button type="button" class="btn btn-danger" wire:click="print({{ $letter->id }})"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Print">
                        <i class="bx bx-printer"></i> {{ __('ebps::ebps.print') }}
                    </button>
                </div>

                <div class="col-md-12 mt-3">
                    <div style="border-radius: 10px; text-align: center; padding: 20px;">
                        <div id="printContent" class="a4-container">

                            <style>
                                {{ $form->styles ?? '' }}
                            </style>

                            {!! $letter->template !!}
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

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
                                        <th class="text-center">{{ __('ebps::ebps.actions') }}</th>
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
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                    wire:click="deleteFile({{ $file->id }})"
                                                    wire:confirm="{{ __('ebps::ebps.are_you_sure_you_want_to_delete_this_file') }}">
                                                    <i class="bx bx-trash"></i> {{ __('ebps::ebps.delete') }}
                                                </button>
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
