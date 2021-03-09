<style>
    .btn-primary-outline {
        background-color: transparent;
    }
</style>
<div class="row">
    <div class="col-12-lg">
        <div class="form-inline form-group mx-3">
            <label class="mr-2">Pick Period: </label>
            <select id='rrdPeriod' class="custom-select">
                <option value="1h">Last Hour</option>
                <option value="12h">Last 12 Hours</option>
                <option value="1d" selected>Last Day</option>
                <option value="1w">Last Week</option>
                <option value="1m">Last Months</option>
                <option value="1y">Last Year</option>
            </select>
        </div>
    </div>

    <div class="col-12-lg">
        <div id="charts" class="row">

        </div>
    </div>
</div>


@push('scripts')

    <script>

        const CHART_TEMPLATE = "" +
            "            <div class='col-12'>" +
            "                <div class='card card-info'>\n" +
            "                    <div class='card-header'>\n" +
            "                        <h3 class='card-title'>__TITLE__</h3>\n" +
            "                    </div>\n" +
            "                    <div class='card-body row'>\n" +
            "                        <div class='chart col-lg-12 col-sm-12'>" +
            "                            <canvas id='__ID__' height='500' class='chartjs-render-monitor' " +
            "style='min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;'></canvas>" +
            "                        </div>\n" +
            "__CHART_CHILD__" +
            "                    </div>\n" +
            "                </div>" +
            "            </div>";

        const CHART_CHILD_TEMPLATE = "" +
            "                        <div class='chart __COL__ col-sm-12' default-size='__COL__'>" +
            "                            <button type='button' class='btn btn-sm btn-primary-outline position-absolute ch_size' style='right: 0;'>" +
            "                                <i class='fas fa-expand-arrows-alt'></i>" +
            "                            </button>" +
            "                            <canvas id='__ID__' height='500' class='chartjs-render-monitor' " +
            "style='min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;'></canvas>" +
            "                        </div>\n";

        const chartGroups = {
        @foreach(\App\DeviceType::all() as $deviceType)
            '{{$deviceType->name}}' : {!! $deviceType->getChartsMaps() !!},
        @endforeach
        };

        // TODO very bad idea, but i can't get access to this data...
        var dataDT;
        var initExtraBottom = function (data) {
            dataDT = data;
            initChart();
        }

        $(function () {
            $('#rrdPeriod').change(function (){
                initChart();
            });
        });

        var initChart = function () {
            var parentNode = document.getElementById('charts');
            parentNode.innerHTML = "";

            console.log(dataDT);
            for(var id in dataDT) {

                var row = dataDT[id]._aData;
                if (row.device_type_id == undefined) {
                    continue;
                }
                var divID = 'link_div_' + row.id;
                var chartGroup = chartGroups[row.device_type_id];
                var title = row.name + ' [' + row.ip + '] - ' + row.location;

                var div = document.createElement("div");
                div.id = divID;
                div.className = 'col-lg-12';
                parentNode.appendChild(div);

                var htmlTemplate = CHART_TEMPLATE
                    .replace(/__TITLE__/g, title)
                    .replace(/__CHART_CHILD__/g, CHART_CHILD_TEMPLATE.repeat(chartGroup.length-1))
                var activeChart = 0;

                for (var i = 0; i < chartGroup.length; i++) {
                    activeChart ++;
                    var chartID = 'chart_' + row.id + '_' + i;
                    htmlTemplate = htmlTemplate.replace('__ID__', chartID);
                }

                $('#'+divID).html(
                    htmlTemplate.replace(/__COL__/g, 'col-lg-' + ((12/(activeChart-1)) < 4 ? 4 : (12/(activeChart-1))))
                );

                for (var i = 0; i < chartGroup.length; i++) {
                    var chartID = 'chart_' + row.id + '_' + i;
                    loadDataset(
                        '#'+chartID,
                        {   id: row.id,
                            source: 'devices',
                            names: chartGroup[i].names,
                            period: $('#rrdPeriod').val() }
                    );
                }
            }
        }

        $(document).on('click', '.ch_size', function () {
            var wrapper = $(this).closest('.chart');
            if($(wrapper).hasClass('col-lg-12')) {
                $(this).find('i').removeClass('fa-compress-arrows-alt').addClass('fa-expand-arrows-alt')
                $(wrapper).attr('class', $(wrapper).attr('class').replace(/col-lg-\d+/g, $(wrapper).attr('default-size')))
            } else {
                $(this).find('i').removeClass('fa-expand-arrows-alt').addClass('fa-compress-arrows-alt')
                $(wrapper).attr('class', $(wrapper).attr('class').replace(/col-lg-\d+/g, 'col-lg-12'))
            }
            // $($(wrapper).find('canvas')).attr('height', $(wrapper).attr('height'))
        });

        var loadDataset = function (canvas, data) {
            $.get('{{ url('rrd') }}', data,
                function(responce){
                    new Chart($(canvas).get(0).getContext('2d'), {
                        type: 'line',
                        data: responce.data,
                        options: responce.options,
                    })
                })
                .fail(function() {
                    // if($(canvas).closest('.card-body').find('.chart').length !== 0) {
                    $(canvas).closest('.chart').remove();
                    // } else {
                    //     $(canvas).closest('.card').remove();
                    // }
                });
        }
    </script>
@endpush


