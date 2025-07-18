@props([
    'label' => '',
    'id' => '',
    'name' => '',
    'value' => '',
    'class' => '',
    'helper' => '',
    'required' => false,
    'disabled' => false,
    'isLivewire' => true,
])

<div wire:ignore>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea id="{{ $id }}" name="{{ $name }}"
              @class(['form-control summernote', $class])
              @if ($required) required @endif
              @if ($disabled) disabled @endif>{{ $value }}</textarea>

    @if ($helper)
        <div id="{{ $id }}-helper" class="form-text">{{ $helper }}</div>
    @endif

    @error($name)
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('#{{ $id }}').summernote({
                placeholder: '',
                tabsize: 2,
                height: 1200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        @this.set('{{ $name }}', contents);
                    }
                }
            });
            let buttons = $('.note-editor button[data-toggle="dropdown"]');

            buttons.each((key, value)=>{
                $(value).on('click', function(e){
                    $(this).closest('.note-btn-group').toggleClass('open');
                })
            })
        });

    </script>
@endpush
