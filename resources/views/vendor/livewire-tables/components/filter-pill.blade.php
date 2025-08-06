@aware(['tableName','isTailwind','isBootstrap4','isBootstrap5'])
@props([
    'filterKey', 
    'filterPillData'
])

<x-livewire-tables::tools.filter-pills.pills-item :$filterKey :$filterPillData /> 