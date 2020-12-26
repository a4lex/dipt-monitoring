@extends('app')

@section('content')

    @includeIf($represent->name . '.extra.index_top')

    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ $represent->label }}</h3>
                    @if($represent->can('create'))
                    <a href="{{ $represent->name }}/create" class="button float-right"><i class="far fa-lg fa-plus-square"></i></a>
                    @endif
                </div>
                <div class="card-body">
                    <div id="represent_wrapper" class="dataTables_wrapper represent-bootstrap4">

                        <div class="row">
                            <div class="col-sm-12">
                                <table id="represent" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="represent_info">
                                    <thead>
                                    <tr role="row">
                                        @foreach ($represent->columns as $key=>$col)
                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">{{$col['label']}}</th>
                                        @endforeach
                                        @if($represent->canAny(['edit', 'delete']))
                                            <th tabindex="0" rowspan="1" colspan="1" aria-sort="ascending">Action</th>
                                        @endif
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @includeIf($represent->name . '.extra.index_bottom')

@endsection

@push('scripts')
    <script src="{{ asset('https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $.extend( $.fn.dataTableExt.oStdClasses, {
                'sFilterInput': 'form-control form-control-sm',
                'sLengthSelect': 'custom-select custom-select-sm form-control form-control-sm',
            });

            // Edit record
            $('#represent').on('click', 'button.edit_row', function (e) {
                e.preventDefault();

                var id = e.currentTarget.id.substring(4);
                window.location.href = '/{{ $represent->name }}/'  + id + '/edit';
            } );

            // Delete a record
            $('#represent').on('click', 'button.delete_row', function (e) {
                e.preventDefault();

                var id = e.currentTarget.id.substring(4);

                $(this).attr("disabled", true);

                toastr.warning("Delete item? &nbsp; <button type='button' id='confirm_del' " +
                    "class='btn btn-xs'><i class='far fa-lg fa-check-circle text-white'></i></button>",'', {
                    allowHtml: true,
                    onShown: function (toast) {
                        $("#confirm_del").click(function(){

                            $.ajax({
                                method: 'DELETE',
                                url:    '/{{ $represent->name }}/'  + id ,
                                success: function(response){
                                    toastr.success(response.message)
                                },
                                error : function (response) {
                                    toastr.error(response.responseJSON.message)
                                }
                            });

                            $('#represent').DataTable().ajax.reload(null, false);
                        })
                    }
                });

            } );

            $('#represent').DataTable( {
                renderer: 'bootstrap',
                pagingType: 'full_numbers',
                buttons: [
                    'colvis',
                    'excel',
                    'print'
                ],
                sDom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>tr<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>><"clear">',
                lengthMenu: [10, 20, 50, 100, 500, 1000],
                language: {
                    decimal:        "",
                    emptyTable:     'No data available in table',
                    info:           'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty:      'Showing 0 to 0 of 0 entries',
                    infoFiltered:   '(filtered from _MAX_ total entries)',
                    lengthMenu:     'Show entries: _MENU_',
                    loadingRecords: 'Loading...',
                    processing:     'Processing...',
                    search:         'Search',
                    zeroRecords:    'No matching records found',
                    paginate: {
                        first:      'First',
                        last:       'Last',
                        previous:   '<i class="fa fa-lg fa-angle-left"></i>',
                        next:       '<i class="fa fa-lg fa-angle-right"></i>'
                    },
                    aria: {
                        sortAscending:  'activate to sort column ascending',
                        sortDescending: 'activate to sort column descending',
                    }
                },

                processing:     true,
                serverSide:     true,
                autoWidth:      false,
                scrollX:        true,
                deferRender:    false,
                order:          [0, 'asc'],
                searchPanes:{
                    panes: [
                        {
                            className: 'form-control form-control-sm'
                        }
                    ],
                },
                'columns': [
                    @foreach ($represent->columns as $key => $col)
                    {
                        data:       '{{ $key }}',
                        className:  'col-checker text-nowrap {{ $col['styles'] }}',
                        {{--visible:    {{ $col['visible'] ? 'true' : 'false' }},--}}
                        orderable:  {{ $col['orderable'] ? 'true' : 'false' }},
                    },
                    @endforeach

                    @if($represent->canAny(['edit', 'delete']))
                    {
                        className:  'col-checker align-middle text-nowrap text-center',
                        visible:    true,
                        orderable:  false,
                        render: function ( data, type, row, meta ) {
                            return '' +
                            @if($represent->can('edit'))
                            // '<button class="btn btn-xs py-0 edit_row" id="row_' + row.id + '"> <i class="far fa-lg fa-edit"></i> </button>' +
                                '<a class="btn btn-xs py-0 edit_row" href="{{ url("/{$represent->name}") }}/' + row.id + '/edit"> <i class="far fa-lg fa-edit"></i> </a>' +
                            @endif
                            @if($represent->can('delete'))
                            '<button class="btn btn-xs py-0 delete_row" id="row_' + row.id + '"> <i class="far fa-lg fa-trash-alt"></i> </button>' +
                            @endif
                            '';
                        }
                    },
                    @endif
                ],
                'ajax': {
                    type : 'GET',
                    url : '{{ url('/' . $represent->name) }}',
                    // TODO bad idea use initExtraTop & initExtraBottom
                    dataSrc : function (json) {
                        if (typeof initExtraTop != 'undefined') initExtraTop(json.data);
                        if (typeof initExtraBottom != 'undefined') initExtraBottom(json.data);
                        return json.data;
                    }
                }
            });
        });
    </script>
@endpush


