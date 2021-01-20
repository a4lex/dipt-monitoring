
<div class="row">
    <div class="col-12-lg">



        <div class="card-body">
            <form class="form-inline">
                <div class="row">
                    <div class="col-12 justify-content-center">

                        <div class="form-group">
                            <div class="form-group mx-3">
                                <label class="mr-2">Custom Select: </label>
                                <select id='rrdPeriod' class="custom-select">
                                    <option value="1h">Last Hour</option>
                                    <option value="12h">Last 12 Hours</option>
                                    <option value="1d" selected>Last Day</option>
                                    <option value="1w">Last Week</option>
                                    <option value="1m">Last Months</option>
                                    <option value="1y">Last Year</option>
                                </select>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="chart_1" checked>
                                <label class="form-check-label" for="chart_1">TX/RX Signal</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="chart_2">
                                <label class="form-check-label" for="chart_2">TX/RX Signal By Chain</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="chart_3" checked>
                                <label class="form-check-label" for="chart_3">TX/RX CCQ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="chart_4">
                                <label class="form-check-label" for="chart_4">TX/RX Rate</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="chart_5" checked>
                                <label class="form-check-label" for="chart_5">TX/RX Traffic</label>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
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
"            <div class='col-md-12'>" +
"                <div class='card card-info'>\n" +
"                    <div class='card-header'>\n" +
"                        <h3 class='card-title text-center'>__TITLE__</h3>\n" +
"                    </div>\n" +
"                    <div class='card-body row'>\n" +
"                        <div class='chart col-lg-12 col-sm-12'>" +
"                            <canvas id='__ID__' height='500' class='chartjs-render-monitor' " +
"style='min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;'></canvas>" +
"                        </div>\n" +
"                        <div class='chart __COL__ col-sm-12'>" +
"                            <canvas id='__ID__' height='500' class='chartjs-render-monitor' " +
"style='min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;'></canvas>" +
"                        </div>\n" +
"                        <div class='chart __COL__ col-sm-12'>" +
"                            <canvas id='__ID__' height='500' class='chartjs-render-monitor' " +
"style='min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;'></canvas>" +
"                        </div>\n" +
"                        <div class='chart __COL__ col-sm-12'>" +
"                            <canvas id='__ID__' height='500' class='chartjs-render-monitor' " +
"style='min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;'></canvas>" +
"                        </div>\n" +
"                        <div class='chart __COL__ col-sm-12'>" +
"                            <canvas id='__ID__' height='500' class='chartjs-render-monitor' " +
"style='min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;'></canvas>" +
"                        </div>\n" +
"                    </div>\n" +
"                </div>" +
"            </div>";

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
            '1' : { names : [ 's1', 's2'], vlabel : 'dB', },
            '2' : { names : [ 's1_ch0', 's1_ch1', 's2_ch0', 's2_ch1' ], vlabel : 'dB', },
            '3' : { names : [ 'ccq1', 'ccq2'], vlabel : '%', },
            '4' : { names : [ 'rate1', 'rate2' ], vlabel : 'Mbps', },
            '5' : { names : [ 'diff_byte1', 'diff_byte2' ], vlabel : 'KBps', },
        };

        // TODO very bad idea, but i can't get access to this data...
        var dataDT;
        var initExtraBottom = function (data) {
            dataDT = data;
            // console.log(dataDT);
            initChart();
        }

        $(function () {
            $('#rrdPeriod').change(function (){
                initChart();
            });

            $('[id^=chart_]').change(function (){
                initChart();
            });
        });

        var initChart = function () {

            var parentNode = document.getElementById('charts');
            parentNode.innerHTML = "";

            for(var id in dataDT) {


                var row = dataDT[id]._aData

                var divID = 'link_div_' + row.id;
                var title = row.d1_name + ' - ' + row.d2_name;

                var div = document.createElement("div");
                div.id = divID;
                div.className = 'col-12';
                parentNode.appendChild(div);

                var htmlTemplate = CHART_TEMPLATE.replace(/__TITLE__/g, title);
                var activeChart = 0;
                for(var i in chartGroups) {
                    if (!$('#chart_' + i).prop('checked')) continue;

                    activeChart ++;
                    var chartID = 'chart_' + row.id + '_' + i;
                    htmlTemplate = htmlTemplate.replace('__ID__', chartID);
                }

                htmlTemplate = htmlTemplate
                    .replace(/<div class=\'chart.*__ID__.*<\/div>/g, '')
                    .replace(/__COL__/g, 'col-lg-' + (12/(activeChart-1)));


                $('#'+divID).html(htmlTemplate);

                for(var i in chartGroups) {
                    if (!$('#chart_' + i).prop('checked')) continue;

                    var chartID = 'chart_' + row.id + '_' + i;
                    loadDataset(
                        '#'+chartID,
                        // chartGroups[i].vlabel,
                        {   id: row.id,
                            source: 'devices',
                            names: chartGroups[i].names,
                            period: $('#rrdPeriod').val() }
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


