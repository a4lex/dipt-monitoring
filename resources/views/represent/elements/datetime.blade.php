<div class="form-group">
    <label>{{ $col['label'] }} :</label>
    <input type="text" name="{{ $col['alias'] }}" class="form-control" placeholder="{{ $col['label'] }}"
           value="{{ $data[$col['alias']] ?? '' }}">
</div>
