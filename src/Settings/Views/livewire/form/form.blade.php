<div class="form">
    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-md-6">
                <x-form.text-input
                        label="{{__('settings::settings.title')}}"
                        id="title"
                        name="form.title"
                />

            </div>
            @if($show_module)
            <div class="col-md-6">
                <x-form.select-input
                        label="{{__('settings::settings.module')}}"
                        id="module"
                        name="form.module"
                        placeholder="{{__('settings::settings.select_module')}}"
                        :options="$modules"
                        readonly
                />
            </div>
                @endif
        </div>
        <hr>
        <div class="col-md-12 d-flex justify-content-between">
            <span>{{__('settings::settings.form_field')}}</span>
            <button class="btn btn-sm btn-primary" type="button" wire:click="addField"><i class="bx bx-plus"></i> {{__('settings::settings.add_item')}}</button>
        </div>
        <hr>
            <div>
                @foreach($fields as $field)
                    <div class="row mt-2">
                    <div class="col-md-12" wire:target="addOptionListItem">
                        {!! @$field['type'] !!}
                        @if(@$field['options'])
                            <?php
                                $replace = implode('', $field['options']);
                                $field['content'] =str_replace('<p> </p>',$replace , $field['content'])
                            ?>
                        @endif
                        @if(!empty($field['fields']))
                                <?php

                                $htmlArray = [];
                                foreach ($field['fields'] as $tableField) {

                                    if (!empty($tableField['options'])) {
                                        $replace = implode('', $tableField['options']);
                                        $tableField['content'] = str_replace('<p> </p>', $replace, $tableField['content']);
                                    }
                                    $htmlArray[] = $tableField['type'] . @$tableField['content'];
                                }
                                $replace = implode('', $htmlArray);
                                $field['content'] = str_replace('<p> </p>', $replace, $field['content']);
                                ?>
                        @endif
                        {!! @$field['content'] !!}
                    </div>
                    </div>
                    <hr>
                @endforeach
            </div>
            @if(count($fields)> 0)
                <div>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('settings::settings.save')}}</button>
                </div>
            @endif
    </form>
</div>
