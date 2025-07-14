<div class="">
    <div class="text-xl font-semibold text-gray-800">🎟️ Token</div>
    <div class="text-sm text-gray-700 space-y-2">
        <div>{{ $token->token }}</div>
        <div>{{ $token->token_purpose_label }}</div>
        <div>{{ ucfirst($token->status) }}</div>
        <div>{{ $token->entry_time }} - {{ $token->exit_time }}</div>
        <div>{{ $token->currentBranch?->name ?? 'N/A' }}</div>
    </div>

    @if($token->tokenHolder)
        <div class="border-t pt-4">
            <div class="text-xl font-semibold text-gray-800">👤 Holder</div>
            <div class="text-sm text-gray-700 space-y-2 mt-2">
                <div>{{ $token->tokenHolder->name }}</div>
                <div>{{ $token->tokenHolder->email }}</div>
                <div>{{ $token->tokenHolder->mobile_no }}</div>
                <div>{{ $token->tokenHolder->address }}</div>
            </div>
        </div>
    @else
        <div class="text-sm text-gray-500 italic">No holder information.</div>
    @endif
</div>
