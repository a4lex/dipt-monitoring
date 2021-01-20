<?php


namespace App\Service;

use App\Device;
use App\InitVariable;
use Ndum\Laravel\Snmp;

class CreateDevice
{
//    protected $oids = array(
//        '1' => array( // Ubiquiti AirFiber
//            'name'      => '1.3.6.1.2.1.1.5.0', //'SNMPv2-MIB::sysName.0',
//            'location'  => '1.3.6.1.2.1.1.6.0', // 'SNMPv2-MIB::sysLocation.0',
//            'firmware'  => '1.3.6.1.4.1.41112.1.3.2.1.40.1', //'SNMPv2-SMI::enterprises.41112.1.3.2.1.40.1',
//            'mac'       => '1.3.6.1.4.1.41112.1.3.2.1.45.1', // 'SNMPv2-SMI::enterprises.41112.1.3.2.1.45.1',
//        ),
//        '2' => array( // Extreme Switch
//            'name'      => '1.3.6.1.2.1.1.5.0',
//            'location'  => '1.3.6.1.2.1.1.6.0',
//            'model'     => '1.0.8802.1.1.2.1.3.4.0',
////            'mac'       => '1.0.8802.1.1.2.1.3.2.0', // TODO scrol down
//        ),
//        '3' => array(
//            'name'      => '1.3.6.1.2.1.1.5.0', //'SNMPv2-MIB::sysName.0',
//            'location'  => '1.3.6.1.2.1.1.6.0', // 'SNMPv2-MIB::sysLocation.0',
//            'firmware'  => '',
//            'mac'       => '1.3.6.1.4.1.41112.1.3.2.1.45.1', // 'SNMPv2-SMI::enterprises.41112.1.3.2.1.45.1',
//        ),
//    );

    protected $ifWlanList;
    protected $identity;
    protected $routerboard;
    protected $resource;
    protected $snmp;
    protected $community;

    public function __invoke($device_type_id, $ip, $username, $password, $community)
    {
        if (!is_array($password))
            $listPass = [$password];

        if (!is_array($community))
            $listCommunity = [$community];


        $initVars = InitVariable::where('device_type_id', $device_type_id)
            ->select('name', 'query')
            ->get();

        $lastErr = null;
        $snmp = new Snmp();
        $snmpResponce = array();

        foreach ($listCommunity as $community) {
            $lastErr = null;
            $snmp->newClient($ip, 1, $community);
            try {
                foreach ($initVars as $var) {
                    $snmpResponce[$var['name']] = $snmp->getValue($var['query']);
                }
                break;
            } catch (\Exception $e) {
                $lastErr = $e->getMessage();
            }
        }

        if ($lastErr != null) return [$lastErr, null];

//          TODO  in future...
//        if (array_key_exists('mac', $snmpResponce)) {
//            dd($snmpResponce['mac']); --> \x00\x04–˜K¨  extreme retyrn byte present of mac
//            $mac = preg_replace('/[^0-9A-F]/i', '', strtoupper($snmpResponce['mac']));
//            $mac = preg_replace('~(..)(?!$)\.?~', '\1:', $mac);
//        } else {
//            $mac = '00:00:00:00:00:00';
//        }

        $device = Device::updateOrCreate([
            'name'              => $snmpResponce['name']
        ], array_merge([
            'ip'                => $ip,
            'device_type_id'    => $device_type_id,
            'username'          => $username,
            'password'          => $password,
            'community'         => $community,
            'mac'               => array_key_exists('mac', $snmpResponce) ? $snmpResponce['mac'] : '00:00:00:00:00:00',
            'model'             => array_key_exists('model', $snmpResponce) ? substr($snmpResponce['model'], 0, 64) : 'unknown',
            'firmware'          => array_key_exists('firmware', $snmpResponce) ? substr($snmpResponce['firmware'], 0, 32) : 'unknown',
            'location1'         => array_key_exists('location1', $snmpResponce) ? $snmpResponce['location1'] : 'unknown',
        ]));

        return [null, $device];
    }

}
