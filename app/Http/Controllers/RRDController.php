<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SnmpTemplate;

class RRDController extends Controller
{
    const BYTES_LABEL = [ '', 'Bytes', 'kBytes', 'MBytes', /*'GBytes', 'TBytes',*/ ];

    const PERIODS = array(
        '1h'  => array(
            'time_format' => 'H:i',
            'rrd_xport_conf' => array('DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"',
                '--start', '-1h',  '--end', 'now', '--step', '300', )
        ),
        '12h' => array(
            'time_format' => 'H:i',
            'rrd_xport_conf' => array('DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"',
                '--start', '-12h', '--end', 'now', '--step', '300', )
        ),
        '1d'  => array(
            'time_format' => 'H:i',
            'rrd_xport_conf' => array('DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"',
                '--start', '-1d', '--end', 'now', '--step', '300', )
        ),
        '1w'  => array(
            'time_format' => 'D H:i',
            'rrd_xport_conf' => array('DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"',
                '--start', '-7d', '--end', 'now', '--step', '300', )
        ),
        '1m'  => array(
            'time_format' => 'd F',
            'rrd_xport_conf' => array('DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"',
                '--start', '-30d', '--end', 'now', '--step', '300', )
        ),
        '1y'  => array(
            'time_format' => 'F',
            'rrd_xport_conf' => array('DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"',
                '--start', '-365d', '--end', 'now', '--step', '300', )
        ),
    );


    const OPTIONS = array(
        'responsive' => true,
        'maintainAspectRatio' => false,
        'datasetFill' => false,
        'tooltips' => array('mode' => 'index', 'intersect' => false),
        'hover' => array('mode' => 'nearest', 'intersect' => false ),
        'legend'=>  array('display'=>  true),
        'scales'=>  array(
            'xAxes'=>  array(array(
                'gridLines' =>  array(
                    'display' =>  false,
                ),
            )),
            'yAxes'=>  array(array(
                'gridLines' =>  array(
                    'display' =>  true,
                                'ticks' => array('suggestedMin' =>  0),
                    ),
                'scaleLabel'=> array(
                    'display' =>  true, 'labelString' =>  'Count'),
                ),
            )
        )
    );



function getRRDData (Request $request) {

        $rrdDir = env('RRD_DIR', '/var/www/html/rrd');
        $period = $request->get('period', '1h');
        switch ($request->get('source', 'other')) {
            case 'ifaces' :
                $subDir = 'ifaces/';
                break;
            case 'devices' :
                $subDir = 'devices/';
                break;
            default :
                $subDir = '/';
        }

        $result = array(
            'data' => array(
                'labels' => array(),
                'datasets' => array(),
            ),
            'options' => self::OPTIONS,
        );

//
//        $vlabel = null;
//        $power = 1;

        foreach ($request->get('names') as $snmpName) {
            $template = SnmpTemplate::where('name', $snmpName)->firstOrFail();

            $rrdDBFile = "{$rrdDir}/{$subDir}{$template->shared}/{$template->name}/" .
                sprintf("%010d", $request->get('id', 0));
            $options = self::PERIODS[$period]['rrd_xport_conf'];
            $options[0] = str_replace('{{rrd_db_file}}', $rrdDBFile, $options[0]);
            $rrdData = rrd_xport($options);

//            if ($template->vlabel == 'bytes') {
//
//                $avgValue = 0;
//                $vals = array_map(function ($v) use (&$avgValue) {
//                    if (is_nan($v) == 'NAN') {
//                        return 'null';
//                    } else {
//                        $avgValue = ($avgValue + $v)/2;
//                        return $v;
//                    }
//                }, array_values($rrdData['data'][0]['data']));
//
//                if($power != 1) {
//                    for ($i = 0; $i < count(self::BYTES_LABEL); $i++) {
//                        if ($avgValue < pow(1024, $i)) {
//                            $power = $i;
//                            $vlabel = self::BYTES_LABEL[$i];
//                            break;
//                        }
//                    }
//                }
//
//
//                $vals = array_map(function ($v) use (&$power) {
//                    if (is_nan($v) == 'NAN') {
//                        return 'null';
//                    } else {
////                        dd($v,$power,$v/pow(1024, $power));
//                        return $v/pow(1024, $power);
//                    }
//                }, array_values($rrdData['data'][0]['data']));
//
////                $vals = array_map(function ($v) use ($power) {
////                    return (is_nan($v) == 'NAN') ? $v/pow(1024, $power) : 'null';
////                }, array_values($rrdData['data'][0]['data']));
//
//            } else {
                $vals = array_map(function ($v) {
                    return is_nan($v) == 'NAN' ? 'null' : $v;
                }, array_values($rrdData['data'][0]['data']));
//            }


            array_push($result['data']['datasets'], array(
                'label' => $template->pname,
                'borderColor' => $template->color,
                'pointRadius' => false,
                'backgroundColor' => substr($template->color, 0, 7) . ($template->fill_bg ? '0F' : '00'),
                'data' => $vals,
                'borderWidth' => 1,
            ));
        }

        $result['options']['scales']['yAxes'][0]['scaleLabel']['labelString'] = $template->vlabel;





        // TODO pick it from user tables
        date_default_timezone_set('Europe/Moscow');

        foreach (array_keys($rrdData['data'][0]['data']) as $unix_time) {
            array_push($result['data']['labels'], date(self::PERIODS[$period]['time_format'], $unix_time));
        }

        date_default_timezone_set(env('TIMEZONE_DEFAULT', 'UTC'));


        return $result;
    }
}
