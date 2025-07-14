<div>
    <ul class="list-unstyled">
        @foreach($row as $agenda)
            <li class="py-1 border-bottom">
               <i class="bx bx-checkbox-checked"></i> <span class="text-body small">{{ $agenda->proposal }}</span>
            </li>
        @endforeach
    </ul>
</div>
