<div>
<span class="strong" {{ $row->committee && $row->committee->committee_name ? 'text-primary' : 'text-danger' }}">
    {{ $row->committee && $row->committee->committee_name ? $row->committee->committee_name : 'No Committee Assigned' }}
</span>
    <ul class="list-unstyled">
        @foreach($row->committeeMembers as $member)
            <li class="py-1 border-bottom">
                <div>
                    <span class="fw-medium small text-dark">{{ $member->name }}</span>
                    <span class="text-muted small">({{ $member->designation }})</span>
                    @if (!empty($member->phone))
                        <a href="tel:{{ $member->phone }}" class="text-decoration-none text-primary small">
                            {{ $member->phone }}
                        </a>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>
