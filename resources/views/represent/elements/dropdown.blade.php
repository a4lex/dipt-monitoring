<div class="form-group">
    <label>{{ $col['label'] }} : </label>
    <select class="form-control select2" id="select_{{ $loop->index }}" name="{{ $col['alias'] }}">
        <option selected="selected" value="{{ $data[$col['alias'] . '_key'] ?? '' }}">{{ $data[$col['alias']] ?? '' }}</option>
    </select>
</div>

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('#select_{{ $loop->index }}').select2({
                theme: 'bootstrap4',
                ajax: {
                    cache: true,
                    dataType: 'json',
                    url: '{{ url($col['popup_values']) }}',
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function (index, item) {
                            results.push({
                                id: item.id,
                                text: item.name
                            });
                        });
                        return {
                            "results":results
                        };
                    },
                }
            });
        });
    </script>
@endpush
