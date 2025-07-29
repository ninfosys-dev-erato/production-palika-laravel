@props([
    'label' => '',
    'id' => '',
    'formId' => '',
    'value' => '',
    'class' => '',
    'helper' => '',
    'required' => false,
    'disabled' => false,
    'isLivewire' => true,
])

<div wire:ignore>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea id="{{ $id }}" name="{{ $id }}" @class(['form-control', $class])
        @if ($required) required @endif @if ($disabled) disabled @endif>{{ $value }}</textarea>

    @if ($helper)
        <div id="{{ $id }}-helper" class="form-text">{{ $helper }}</div>
    @endif

    @error($id)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.1.0/ckeditor5.css">
    @endpush

    @push('scripts')
        <script type="importmap">
            {
                "imports": {
                    "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.1.0/ckeditor5.js",
                    "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.1.0/"
                }
            }
        </script>
    @endpush
@endonce

@push('scripts')
    <script type="module">
        import {
            ClassicEditor
        } from 'ckeditor5';
        import editorConfig from "/assets/js/ck-editor.js";

        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file.then((file) => new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append('upload', file);

                    fetch('{{ route('ckeditor.upload') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.url) {
                                resolve({
                                    default: result.url
                                });
                            } else {
                                reject(result.error || 'Upload failed');
                            }
                        })
                        .catch(error => {
                            reject(error.message || 'Upload error');
                        });
                }));
            }

            abort() {}
        }

        function CustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        let myEditor;

        ClassicEditor
            .create(document.querySelector('#{{ $id }}'), {
                ...editorConfig,
                extraPlugins: [CustomUploadAdapterPlugin],
                disallowedContent: 'script,style,iframe,figure',
                allowedContent: true,
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                forceSimpleAmpersand: true
            })
            .then(editor => {
                myEditor = editor;
                editor.setData(@json($value));
                editor.model.document.on('change:data', () => {
                    const sanitizedData = sanitizeEditorData(editor.getData());
                    @this.updateLetter('{{ $formId }}', sanitizedData);
                });
            })
            .catch(error => {
                console.error('CKEditor initialization error:', error);
            });

        function sanitizeEditorData(data) {
            const doc = new DOMParser().parseFromString(data, 'text/html');
            doc.querySelectorAll('script, iframe').forEach(node => node.remove());
            return doc.body.innerHTML;
        }

        function setEditorData(editorInstance, newData) {
            if (editorInstance) {
                editorInstance.setData(newData);
            }
        }

        Livewire.on('update-editor-{{ $formId }}', (event) => {
            if (typeof myEditor !== 'undefined' && myEditor) {
                let data = event[0].content;
                setEditorData(myEditor, data);
            }
        });
    </script>
@endpush 