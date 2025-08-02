@php($tableName = $this->getTableName)
@php($tableId = $this->getTableId)
@php($primaryKey = $this->getPrimaryKey)
@php($isTailwind = $this->isTailwind)
@php($isBootstrap = $this->isBootstrap)
@php($isBootstrap4 = $this->isBootstrap4)
@php($isBootstrap5 = $this->isBootstrap5)

<div>
    <div {{ $this->getTopLevelAttributes() }}>

        @includeWhen(
            $this->hasConfigurableAreaFor('before-wrapper'),
            $this->getConfigurableAreaFor('before-wrapper'),
            $this->getParametersForConfigurableArea('before-wrapper')
        )

        <x-livewire-tables::wrapper :component="$this" :tableName="$tableName" :$primaryKey :$isTailwind :$isBootstrap :$isBootstrap4 :$isBootstrap5>
            @if($this->hasActions && !$this->showActionsInToolbar)
                <x-livewire-tables::includes.actions/>
            @endif

            @includeWhen(
                $this->hasConfigurableAreaFor('before-tools'),
                $this->getConfigurableAreaFor('before-tools'),
                $this->getParametersForConfigurableArea('before-tools')
            )

            @if($this->shouldShowTools)
                <x-livewire-tables::tools>
                    @if ($this->showSortPillsSection)
                        <x-livewire-tables::tools.sorting-pills />
                    @endif
                    @if($this->showFilterPillsSection)
                        <x-livewire-tables::tools.filter-pills />
                    @endif

                    @includeWhen(
                        $this->hasConfigurableAreaFor('before-toolbar'),
                        $this->getConfigurableAreaFor('before-toolbar'),
                        $this->getParametersForConfigurableArea('before-toolbar')
                    )

                    @if($this->shouldShowToolBar)
                        <x-livewire-tables::tools.toolbar />
                    @endif

                    @includeWhen(
                        $this->hasConfigurableAreaFor('after-toolbar'),
                        $this->getConfigurableAreaFor('after-toolbar'),
                        $this->getParametersForConfigurableArea('after-toolbar')
                    )

                </x-livewire-tables::tools>
            @endif

            <x-livewire-tables::table>
                <x-slot name="thead">
                    <thead>
                    <tr class="text-center">
                        <th rowspan="3" width="30" class="no-short">सि.न.</th>
                        <th rowspan="3">{{ __('yojana::yojana.process_indicator') }}</th>
                        <th rowspan="3">{{ __('yojana::yojana.unit') }}</th>
                        <th colspan="2" rowspan="2">{{ __('yojana::yojana.total_project_goal') }}</th>
                        <th colspan="2" rowspan="2">{{ __('yojana::yojana.last_fy_progress') }}</th>
                        <th colspan="8">{{ __('yojana::yojana.current_fy_goal') }}</th>
                        <th rowspan="3">{{ __('yojana::yojana.actions') }}</th>
                    </tr>
                    <tr class="text-center">
                        <th colspan="2">{{ __('yojana::yojana.total_goals') }}</th>
                        <th colspan="2">{{ __('yojana::yojana.first_quarter') }}</th>
                        <th colspan="2">{{ __('yojana::yojana.second_quarter') }}</th>
                        <th colspan="2">{{ __('yojana::yojana.third_quarter') }}</th>
                    </tr>
                    <tr class="text-center">
                        @for($i = 0; $i < 6; $i++)
                            <th>{{ __('yojana::yojana.physical') }}</th>
                            <th>{{ __('yojana::yojana.financial') }}</th>
                        @endfor
                    </tr>
                    </thead>
                </x-slot>

                @if($this->secondaryHeaderIsEnabled() && $this->hasColumnsWithSecondaryHeader())
                    <x-livewire-tables::table.tr.secondary-header />
                @endif

                @if($this->hasDisplayLoadingPlaceholder())
                    <x-livewire-tables::includes.loading colCount="{{ $this->columns->count()+1 }}" />
                @endif

                @if($this->showBulkActionsSections)
                    <x-livewire-tables::table.tr.bulk-actions :displayMinimisedOnReorder="true" />
                @endif

                @forelse ($this->getRows as $rowIndex => $row)
                    <tr wire:key="{{ $tableName }}-row-physical-{{ $row->{$primaryKey} }}">
                        <td rowspan="2">{{ $rowIndex + 1 }}</td>
                        <td rowspan="2">{{ $row->processIndicator?->title }}</td>
                        <td rowspan="2">{{ $row->processIndicator?->unit->{'title_' . app()->getLocale()} ?? $row->processIndicator?->unit->title ?? '' }}</td>

                        <td>{{ replaceNumbers($row->total_physical_goals, true) }}</td>
                        <td>{{ replaceNumbers($row->total_financial_goals, true) }}</td>

                        <td>{{ replaceNumbers($row->last_year_physical_progress, true) }}</td>
                        <td>{{ replaceNumbers($row->last_year_financial_progress, true) }}</td>

                        <td>{{ replaceNumbers($row->total_physical_progress, true) }}</td>
                        <td>{{ replaceNumbers($row->total_financial_progress, true) }}</td>

                        <td>{{ replaceNumbers($row->first_quarter_physical_progress, true) }}</td>
                        <td>{{ replaceNumbers($row->first_quarter_financial_progress, true) }}</td>

                        <td>{{ replaceNumbers($row->second_quarter_physical_progress, true) }}</td>
                        <td>{{ replaceNumbers($row->second_quarter_financial_progress, true) }}</td>

                        <td>{{ replaceNumbers($row->third_quarter_physical_progress, true) }}</td>
                        <td>{{ replaceNumbers($row->third_quarter_financial_progress, true) }}</td>

                        <td rowspan="2">
                            @if (can('plan edit'))
                                <button class="btn btn-primary btn-sm" wire:click="edit({{ $row->id }})">
                                    <i class="bx bx-edit"></i>
                                </button>
                            @endif
                            @if (can('plan delete'))
                                <button class="btn btn-danger btn-sm" wire:click="delete({{ $row->id }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    <tr wire:key="{{ $tableName }}-row-financial-{{ $row->{$primaryKey} }}">
                        {{-- This row is intentionally left blank in case future financial progress rows needed --}}
                    </tr>
                @empty
                    <x-livewire-tables::table.empty />
                @endforelse

                @if ($this->footerIsEnabled() && $this->hasColumnsWithFooter())
                    <x-slot name="tfoot">
                        @if ($this->useHeaderAsFooterIsEnabled())
                            <x-livewire-tables::table.tr.secondary-header />
                        @else
                            <x-livewire-tables::table.tr.footer />
                        @endif
                    </x-slot>
                @endif
            </x-livewire-tables::table>

            <x-livewire-tables::pagination />

            @includeIf($customView)
        </x-livewire-tables::wrapper>

        @includeWhen(
            $this->hasConfigurableAreaFor('after-wrapper'),
            $this->getConfigurableAreaFor('after-wrapper'),
            $this->getParametersForConfigurableArea('after-wrapper')
        )

    </div>
</div>
