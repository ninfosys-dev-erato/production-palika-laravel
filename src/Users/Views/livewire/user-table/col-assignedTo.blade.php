<div>
    <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
        @foreach ($roles as $role)
            <li> <span class="badge bg-label-primary me-1">
                    {{ ucwords(str_replace('_', ' ', $role->name)) }}</span>
            </li>
        @endforeach
    </ul>
</div>
