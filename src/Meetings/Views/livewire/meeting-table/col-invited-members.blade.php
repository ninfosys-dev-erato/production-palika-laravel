<div>
        <ul class="list-unstyled m-0">
                @foreach($row as $member)
                        <li class="d-flex align-items-center mb-2">
                                <div>
                                        <h6 class="m-0">  <i class="bx bx-user-circle text-secondary fs-5 me-2"></i>{{ $member->name }} ({{ $member->designation }})</h6>
                                        <small class="text-muted">
                                                @if (!empty($member->phone))
                                                        <i class="bx bx-phone me-1"></i>
                                                        <a href="tel:{{ $member->phone }}" class="text-decoration-none">{{ $member->phone }}</a>
                                                @endif
                                        </small>
                                </div>
                        </li>
                @endforeach
        </ul>
</div>
