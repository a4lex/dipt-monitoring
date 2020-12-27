<h6>
    @foreach(explode(',', $item->$columnName) as $part)
        <span class="badge badge-pill badge-primary">
            {{ preg_replace('/^\d+\:/', '', $part) }}
        </span>
    @endforeach
</h6>
