<div class="form-group">
    <label>{{ $col['label'] }} :</label>
    <input type="text" name="{{ $col['alias'] }}" class="form-control" placeholder="{{ $col['label'] }}"
           value="{{ isset($data[$col['alias']]) ? long2ip($data[$col['alias']]) : '' }}">
</div>