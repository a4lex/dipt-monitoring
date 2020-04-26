<div class="form-group">
    <label>{{ $col['label'] }} :</label>
    <div class="custom-control custom-switch">
        <input type="hidden" name="{{ $col['alias'] }}" value="{{ $data[$col['alias']] ?? '0' }}">
        <input type="checkbox" class="custom-control-input" id="switch_{{ $col['alias'] }}"
            {{ (isset($data[$col['alias']]) && $data[$col['alias']]) ? 'checked' : '' }}>
        <label class="custom-control-label" for="switch_{{ $col['alias'] }}"></label>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('#switch_{{ $col['alias'] }}').change(function (e) {
                var name = e.target.id.replace('switch_', '');
                var state = $(this).is(":checked") ? '1' : '0';
                $('#form_{{ $represent->name }} [name="' + name + '"]').val(state);
            });
        });
    </script>
@endpush


