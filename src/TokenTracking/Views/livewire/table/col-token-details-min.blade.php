<div>
    <div class="text-sm text-gray-800 space-y-4 leading-snug">
        <div class="text-lg font-semibold underline text-blue-700">
           <strong>{{ $token->token }}</strong> | <u>{{ $token->token_purpose->label() }}</u>
        </div>

        <div class="text-sm text-green-700 font-semibold">
            {{ $token->currentBranch?->title ?? 'N/A' }}
        </div>
    </div>
</div>
