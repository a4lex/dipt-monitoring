@extends('app')

@section('content')

    <style>
        table tr.search th {
            border-bottom: 0px solid #ffffff;
            border: 0px solid #ffffff;
        }
        table tr.search th input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
        .dataTables_scroll {
            margin-top: -7px;
        }
    </style>
    @includeIf($represent->name . '.extra.index_top')

    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header p-2">
                    <h3 class="card-title m-1">
                        {{ $represent->label }}, showing <b id="title_from"></b> to <b id="title_to"></b> of <b id="title_of"></b> entries
                    </h3>
                    <div id="represent_buttons" class="float-right"></div>
                </div>
                <div class="card-body p-0">
                    <div id="represent_wrapper" class="dataTables_wrapper represent-bootstrap4">

                        <div class="row">
                            <div class="col-sm-12">
                                <table id="represent" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="represent_info">
                                    <thead>
                                    <tr class="search">
                                        @foreach ($represent->columns as $key=>$col)
                                            @if ($col['searchable'])
                                                <th>
                                                    <input type="text" id="filter_{{$loop->index}}" placeholder="Search by {{$col['label']}}" />
                                                </th>
                                            @else
                                                <th></th>
                                            @endif
                                        @endforeach
                                        @if($represent->canAny(['edit', 'delete']))
                                            <th></th>
                                        @endif
                                    </tr>
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
    <script type="text/javascript">
        $(function() {
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
            });

            $('#represent').on('column-visibility.dt', function ( e, settings, column, state ) {
                $.post('{{ url('change_visibility') }}', {
                        column_id:  settings.aoColumns[column].sql_id,
                        visible:    (state ? 1 : 0),
                });
            } );

            $('#represent').DataTable( {
                renderer: 'bootstrap',
                pagingType: 'full_numbers',
                buttons: [
                    // "copy", "csv", "excel", "pdf", "print",
                    {
                        extend: 'colvis',
                        className: 'btn btn-default btn-sm'
                    },
                    @if($represent->can('create'))
                    {
                        text: 'Create',
                        className: 'btn btn-default btn-sm',
                        action: function ( e, dt, node, config ) {
                            window.open("{{ $represent->name }}/create", '_blank').focus();
                        }
                    },
                    @endif
                ],
                // sDom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>tr<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>><"clear">',
                sDom: 'tr<"row mx-3 my-2"<"col-sm-12 col-md-5"l> <"col-sm-12 col-md-7"p>> <"clear">',
                lengthMenu: [10, 20, 50, 100, 500, 1000],
                // searching: false,
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
                        sql_id:     '{{ $col['sql_id'] }}',
                        className:  'col-checker text-nowrap {{ $col['styles'] }}',
                        visible:    {{ $col['visible'] ? 'true' : 'false' }},
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
                ajax: {
                    type : 'GET',
                    url : '{{ url('/' . $represent->name) }}',
                    dataSrc : function (json) {
                        $('#title_from').html(parseInt(json.input.start,10) + 1);
                        $('#title_to').html(parseInt(json.input.start) + json.data.length);
                        $('#title_of').html(json.recordsFiltered);
                        return json.data;
                    }
                },
                initComplete: function () {
                    var that = this.api();
                    that.buttons().container().appendTo('#represent_buttons');
                    that.columns().every(function (colIdx) {
                        $('#filter_' + colIdx).on('keyup change clear', function () {
                            if (that.column(colIdx).search() !== this.value) {
                                that.column(colIdx)
                                    .search(this.value)
                                    .draw()
                            }
                        } );
                    } );
                },
                // TODO bad idea use initExtraTop & initExtraBottom
                drawCallback : function (settings) {
                    if (typeof initExtraTop !== 'undefined') setTimeout(initExtraTop(settings.aoData), 0);
                    if (typeof initExtraBottom !== 'undefined') setTimeout(initExtraBottom(settings.aoData), 0);
                    return true;
                }
            });
        });
    </script>
@endpush


