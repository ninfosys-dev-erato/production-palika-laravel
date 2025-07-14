<div>
        @foreach($row as $data)
                <span class="text-primary small"><code>{{ucwords($data['fromUser']['name']) }}
                    ({{ ucwords($data['old_status']) }})</code>
                </span>
                →
                <span class="text-success small"> <code>{{ ucwords($data['toUser']['name']) }}
                        ({{ ucwords($data['new_status']) }}) </code>
                </span><br>
        @endforeach
</div>
