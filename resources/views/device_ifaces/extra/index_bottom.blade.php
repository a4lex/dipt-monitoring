
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
            "                        <div class='chart __COL__ col-sm-12'>" +
            "                            <canvas id='__ID__' height='500' class='chartjs-render-monitor' " +
            "style='min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;'></canvas>" +
            "                        </div>\n";

        const CHART_LINE_OPTION = {
            maintainAspectRatio : false,
            responsive : true,
            datasetFill : false,
            tooltips : {mode : 'index', intersect : false},
            hover : {mode : 'nearest', intersect : false },
            legend: {
                display: true,
            },
            scales: {
                xAxes: [{
                    gridLines : {
                        display : false,
                    },
                }],
                yAxes: [{
                    gridLines : {
                        display : true,
                        ticks : {suggestedMin : 0},
                    },
                    scaleLabel:{ display : true, labelString : 'dB'},
                }]
            }
        };

        const chartGroups = {
            @foreach(\App\DeviceTypeIfaceType::all() as $devIfType)
            '{{$devIfType->device_type_id . '-' . $devIfType->iface_type_id   }}' : {!! $devIfType->getChartsMaps() !!},
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
                if (row.device_type_id == undefined || chartGroups[row.device_type_id] == undefined) {
                    continue;
                }
                var divID = 'link_div_' + row.id;
                var chartGroup = chartGroups[row.device_type_id];
                var title = row.device_id + ' [' + row.name + '] - ' + row.iface_type_id;

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
                    htmlTemplate.replace(/__COL__/g, 'col-lg-' + (12/(activeChart-1)))
                );

                for (var i = 0; i < chartGroup.length; i++) {
                    var chartID = 'chart_' + row.id + '_' + i;
                    loadDataset(
                        '#'+chartID,
                        // chartGroup[i].vlabel,
                        {   id: row.id,
                            source: 'ifaces',
                            names: chartGroup[i].names,
                            period: $('#rrdPeriod').val(),
                        }
                    );
                }
            }
        }

        var loadDataset = function (canvas, /*vlabel,*/ data) {
            $.get('{{ url('rrd') }}', data,
                function(responce){
                    // CHART_LINE_OPTION.scales.yAxes[0].scaleLabel.labelString = dataset['vlabel'];
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


