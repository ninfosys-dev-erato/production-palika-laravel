<div>
    @if($token->tokenHolder)
            <div class="text-sm text-gray-700 space-y-2 mt-2">
                <div>{{ $token->tokenHolder->name }}</div>
                <div>{{ $token->tokenHolder->email }}</div>
                <div>{{ $token->tokenHolder->mobile_no }}</div>
                <div>{{ $token->tokenHolder->address }}</div>
            </div>
    @else
        <div class="text-sm text-gray-500 italic">No holder information.</div>
    @endif
</div>
