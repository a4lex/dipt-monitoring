<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SnmpTemplate;

class RRDController extends Controller
{
    const PERIODS = array(
        '1h'  => array(
            'time_format' => 'H:i',
            'rrd_xport_conf' => array('--start', '-1h',  '--end', 'now', '--step', '300',
                'DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"' )
        ),
        '12h' => array(
            'time_format' => 'H:i',
            'rrd_xport_conf' => array('--start', '-12h', '--end', 'now', '--step', '300',
                'DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"' )
        ),
        '1d'  => array(
            'time_format' => 'H:i',
            'rrd_xport_conf' => array('--start', '-1d', '--end', 'now', '--step', '300',
                'DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"' )
        ),
        '1w'  => array(
            'time_format' => 'D H:i',
            'rrd_xport_conf' => array('--start', '-1w', '--end', 'now', '--step', '300',
                'DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"' )
        ),
        '1m'  => array(
            'time_format' => 'd F',
            'rrd_xport_conf' => array('--start', '-1m', '--end', 'now', '--step', '33600',
                'DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"' )
        ),
        '1y'  => array(
            'time_format' => 'F',
            'rrd_xport_conf' => array('--start', '-1y', '--end', 'now', '--step', '403200',
                'DEF:metric={{rrd_db_file}}:val:AVERAGE', 'XPORT:metric:"default"' )
        ),
    );

    function getRRDData (Request $request) {

        $rrdDir = env('RRD_DIR', '/var/www/html/rrd');
        $period = $request->get('period', '1h');

        $data = array(
            'labels' => array(),
            'datasets' => array(),
        );


        foreach ($request->get('names') as $snmpName) {
            $template = SnmpTemplate::where('name', $snmpName)->firstOrFail();

            $rrdDBFile = "{$rrdDir}/{$template->shared}/{$template->name}/" .
                sprintf("%010d", $request->get('id', 0));
            $options = self::PERIODS[$period]['rrd_xport_conf'];
            $options[6] = str_replace('{{rrd_db_file}}', $rrdDBFile, $options[6]);
            $rrdData = rrd_xport($options);

            $vals = array_map(function ($v) {
                return is_nan($v) == 'NAN' ? 'null' : $v;
            }, array_values($rrdData['data'][0]['data']));

            array_push($data['datasets'], array(
                'label' => $template->pname,
                'borderColor' => $template->color,
                'pointRadius' => false,
                'backgroundColor' => substr($template->color, 0, 7) . ($template->fill_bg ? '0F' : '00'),
                'data' => $vals,
                'borderWidth' => 1,
            ));
        }

        // TODO pick it from user tables
        date_default_timezone_set('Europe/Moscow');

        foreach (array_keys($rrdData['data'][0]['data']) as $unix_time) {
            array_push($data['labels'], date(self::PERIODS[$period]['time_format'], $unix_time));
        }

        date_default_timezone_set(env('TIMEZONE_DEFAULT', 'UTC'));


        return $data;
    }
}
