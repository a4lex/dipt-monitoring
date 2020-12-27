<div class="form-group">
    <label>{{ $col['label'] }} : </label>
    <select id="select_{{ $loop->index }}" class="select2" name="{{ $col['alias'] }}[]"
            multiple="multiple" data-placeholder="Pick {{ $col['label'] }}" style="width: 100%;">
    @forelse(explode(',', $data[$col['alias']] ?? '') as $id_name)
        <?php $matches = array(); ?>
        @if (preg_match('/^(\d+)\:(.*)$/', $id_name, $matches))
        <option value="{{ $matches[1] }}" selected>{{ $matches[2] }}</option>
        @endif
    @endforeach
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
                                text: item.name,
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
