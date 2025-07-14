<div class="text-sm text-gray-700 leading-relaxed space-y-1">
    <div>
        <strong>{{ __('tokentracking::tokentracking.entry') }}:</strong>
        {{ $row->entry_time ? \Carbon\Carbon::parse($row->entry_time)->format('h:i A') : '—' }}
    </div>

    @if($row->exit_time)
        <div>
            <strong>{{ __('tokentracking::tokentracking.exit') }}:</strong>
            {{ \Carbon\Carbon::parse($row->exit_time)->format('h:i A') }}
        </div>
    @endif

    <div>
        <strong>{{ __('tokentracking::tokentracking.estimated') }}:</strong>
        {{ $row->estimated_time ?? '—' }}
    </div>
</div>
