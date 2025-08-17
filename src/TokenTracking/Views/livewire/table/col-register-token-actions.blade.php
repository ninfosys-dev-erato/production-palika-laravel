@php
    use Illuminate\Support\Facades\Cache;
    $branches = Cache::remember('active_branches', 60, function () {
        return \Src\Employees\Models\Branch::whereNull('deleted_at')->get();
    });
@endphp

<div class="btn-group-wrapper">
    <div class="btn-group" role="group">

        @if ($row->exit_time)

            {{-- Feedback Button --}}
            <button type="button" class="btn btn-primary btn-sm" wire:click="feedBack({{ $row->id }})"
                title="Give Feedback">
                <i class="bx bx-comment-detail"></i>
            </button>
        @else
            {{-- View Button --}}
            <button class="btn btn-success btn-sm" wire:click="view({{ $row->id }})">
                <i class="bx bx-show"></i>
            </button>

            @if ($row->stage === \Src\TokenTracking\Enums\TokenStageEnum::ENTRY)
                {{-- Edit Button --}}
                <button class="btn btn-primary btn-sm" wire:click="edit({{ $row->id }})">
                    <i class="bx bx-edit"></i>
                </button>
            @endif

            {{-- Delete Button --}}
            <button type="button" class="btn btn-danger btn-sm" wire:click="delete({{ $row->id }})"
                wire:confirm="Are you sure you want to delete this record?">
                <i class="bx bx-trash"></i>
            </button>


            {{-- Exit Time Button --}}
            <button type="button" class="btn btn-warning btn-sm" wire:click="exitTime({{ $row->id }})"
                wire:confirm="Are you sure you want to add exit time?" title="Mark Exit Time">
                <i class="bx bx-time-five"></i>
            </button>

        @endif

    </div>

    @if (!$row->exit_time)
        <!-- Dropdown Below the Button Group -->
        <div>
            <label for="branch-{{ $row->id }}"
                class="form-label text-sm font-medium text-gray-700">{{ __('tokentracking::tokentracking.branch') }}</label>
            <select id="branch-{{ $row->id }}" wire:change="updateBranch({{ $row->id }}, $event.target.value)"
                class="form-select form-select-sm p-2 px-4 rounded shadow-none w-full"
                style="appearance: none; -webkit-appearance: none; -moz-appearance: none; background: #f8fafc; border: 1px solid #ddd;">
                <option value="" disabled selected>{{ __('tokentracking::tokentracking.select_branch') }}</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->title }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>
