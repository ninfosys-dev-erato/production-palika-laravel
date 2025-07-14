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
    <textarea id="{{ $id }}" name="{{ $name }}" @class(['form-control', $class])
        @if ($required) required @endif @if ($disabled) disabled @endif>{{ $value }}</textarea>
    @if ($helper)
        <div id="{{ $id }}-helper" class="form-text">{{ $helper }}</div>
    @endif
    @error($name)
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

        // Custom upload adapter
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
        let myEditor; // Declare editor instance globally
        ClassicEditor
            .create(document.querySelector('#{{ $id }}'), {
                ...editorConfig,
                extraPlugins: [CustomUploadAdapterPlugin],
                // Sanitize by allowing only basic HTML elements
                // allowedContent: 'div class p br table tr td ul ol li blockquote strong em a[href] img[src,alt] span[style]',
                // extraAllowedContent: '*[style](*)',
                allowedContent : true,
                extraAllowedContent : 'span;ul;li;table;td;style;*[id];*(*);*{*}',
                enterMode: 'div',
                ShiftEnterMode:'br',
                // disallowedContent: 'script,style,font,span,[id],iframe',
                // removePlugins: ['Font', 'FontSize', 'FontColor'], // Disable unnecessary plugins like font styling
                removePlugins: ['TableCaption', 'TableProperties', 'ImageCaption', 'ImageResize'],
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        classes: true,
                        attributes: true,
                        styles: true
                    },
                        {
                            name: 'table',
                            classes: true,
                            attributes: true,
                            styles: true
                        },
                        {
                            name: 'tr',
                            classes: true,
                            attributes: true,
                            styles: true
                        },
                        {
                            name: 'td',
                            classes: true,
                            attributes: true,
                            styles: true
                        },
                        {
                            name: 'th',
                            classes: true,
                            attributes: true,
                            styles: true
                        }
                    ]
                },
                forceSimpleAmpersand: true
            })
            {{--.then(editor => {--}}
            {{--    myEditor = editor; // Store the editor instance--}}
            {{--    editor.setData(@json($value));--}}
            {{--    editor.model.document.on('change:data', format => {--}}
            {{--        const sanitizedData = editor.getData();--}}
            {{--        @this.set('{{ $name }}', sanitizedData);--}}
            {{--    });--}}
            {{--})--}}
            .then(editor => {
                myEditor = editor;
                editor.setData(@json($value));

                // REMOVE <figure> from tables
                const conversion = editor.conversion;
                conversion.for('upcast').elementToElement({
                    view: {
                        name: 'figure',
                        classes: 'table'
                    },
                    model: (viewElement, { writer: modelWriter }) => {
                        const tableElement = viewElement.getChild(0);
                        return conversion.elementToElement({
                            view: tableElement.name,
                            model: 'table'
                        }).model(viewElement, { writer: modelWriter });
                    }
                });

                // You can also do this for images if needed
                conversion.for('upcast').elementToElement({
                    view: {
                        name: 'figure',
                        classes: 'image'
                    },
                    model: (viewElement, { writer: modelWriter }) => {
                        const imageElement = viewElement.getChild(0);
                        return conversion.elementToElement({
                            view: imageElement.name,
                            model: 'imageBlock'
                        }).model(viewElement, { writer: modelWriter });
                    }
                });

                editor.model.document.on('change:data', () => {
                    let rawData = editor.getData();
                    // Final fallback: strip <figure> with regex
                    rawData = rawData.replace(/<figure[^>]*>/g, '').replace(/<\/figure>/g, '');
                @this.set('{{ $name }}', rawData);
                });
            }).catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });


        function setEditorData(editorInstance, newData) {
            if (editorInstance) {
                editorInstance.setData(newData);
            }
        }
        Livewire.on('update-editor', (event) => {
            if (typeof myEditor !== 'undefined' && myEditor) {
                let data = event[0].{{ $name }};
                setEditorData(myEditor, data);
            }
        });
    </script>
@endpush
