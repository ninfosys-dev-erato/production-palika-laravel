<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class='col-md-12'>
                    <label for='form_template' class='form-label'>{{ __('ejalas::ejalas.form_template') }}</label>
                    <select wire:model='formTemplateId' name='form_template' id='form_template' class='form-select' wire:change='getFormTemplate'>
                        <option value="" hidden>{{ __('ejalas::ejalas.select_form_template') }}</option>
                    @foreach ($formTemplate as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('formTemplate')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($certificateTemplate)
    
    <div class="d-flex align-items-center justify-content-between flex-wrap mt-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button class="btn btn-outline-primary" type="button" wire:loading.attr="disabled"
                wire:click="saveTemplate">
                <i class="bx bx-save"></i>
                {{ __('ejalas::ejalas.save') }}
            </button>
            <button class="btn btn-outline-primary" type="button" wire:loading.attr="disabled"
                wire:click="resetTemplate">
                <i class="bx bx-reset"></i>
                {{ __('ejalas::ejalas.reset') }}
            </button>
            <!-- Toggle Preview/Edit Mode -->
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0" for="previewToggle">
                    {{ $preview ? __('ejalas::ejalas.preview') : __('ejalas::ejalas.edit') }}
                </label>
                <div class="form-check form-switch mb-0">
                    <input type="checkbox" id="previewToggle" class="form-check-input"
                        style="width: 3rem; height: 1.3rem;" wire:model="editMode" wire:click="togglePreview">
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            @if ($preview)
                <button class="btn btn-outline-primary" type="button" onclick="printDiv()">
                    <i class="bx bx-printer"></i>
                    {{ __('ejalas::ejalas.print') }}
                </button>
            @endif
        </div>
    </div>


    


        <div class="col-md-12">
            <div style="border-radius: 10px; text-align: center; padding: 20px;">

                <div class="{{ !$preview ? 'd-none' : '' }} a4-container" id="printContent">
                    {!! $certificateTemplate !!}
                    <style>
                        {!! $style !!}
                    </style>

                </div>
            </div>
        </div>
      
 
            
        <style>
        /* Ensure A4 Size */
        .a4-container {
            width: 210mm;
            min-height: 297mm;
            padding: 7mm 20mm;
            margin: auto;
            background: white;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            text-align: left;
            position: relative;
        }
    </style>
    @else
        <div class="card mt-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center py-5">
                            <i class="bx bx-file-blank" style="font-size: 4rem; color: #6c757d;"></i>
                            <h5 class="mt-3 text-muted">{{ __('ejalas::ejalas.no_form_selected') }}</h5>
                            <p class="text-muted">{{ __('ejalas::ejalas.please_select_form_template') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="col-md-12  {{ !$certificateTemplate || $preview ? 'd-none' : '' }}" >
            <x-form.ck-editor-input label="" id="certificateTemplate" name="certificateTemplate" :value="$certificateTemplate"
                wire:model.defer="certificateTemplate"  />
        </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


    <script>
        async function printDiv() {
            const {
                jsPDF
            } = window.jspdf;
            const element = document.getElementById('printContent');

            const canvas = await html2canvas(element, {
                scale: 2,
                useCORS: true
            });

            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');

            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = pdf.internal.pageSize.getHeight();

            const imgProps = pdf.getImageProperties(imgData);
            const imgHeight = (imgProps.height * pdfWidth) / imgProps.width;

            let heightLeft = imgHeight;
            let position = 0;

            // Add first page
            pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
            heightLeft -= pdfHeight;

            // Add more pages only if needed
            while (heightLeft > 1) {
                position -= pdfHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
                heightLeft -= pdfHeight;
            }

            // Trigger browser print dialog
            pdf.autoPrint();
            window.open(pdf.output('bloburl'), '_blank');
        }
    </script>


<script>
    document.addEventListener("livewire:navigated", initCKEditor);
    document.addEventListener("livewire:load", initCKEditor);
    Livewire.hook('morph.added', (el) => {
        if (el.querySelector('#certificate_letter')) {
            initCKEditor();
        }
    });

    function initCKEditor() {
        const editorElement = document.querySelector('#certificate_letter');
        if (editorElement && !editorElement.classList.contains('ck-initialized')) {
            ClassicEditor.create(editorElement)
                .then(editor => {
                    editorElement.classList.add('ck-initialized');
                    editor.model.document.on('change:data', () => {
                        @this.set('certificateTemplate', editor.getData());
                    });
                })
                .catch(error => console.error(error));
        }
    }
</script>


</div>