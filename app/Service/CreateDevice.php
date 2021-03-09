<?php


namespace App\Service;

use App\Device;
use App\InitVariable;
use Ndum\Laravel\Snmp;

class CreateDevice
{
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

        if (array_key_exists('mac', $snmpResponce)) {
            $unpucked = unpack("h*", $snmpResponce['mac']);
            $snmpResponce['mac'] = isset($unpucked[1]) ? $unpucked[1] : $snmpResponce['mac'];
            $snmpResponce['mac'] = preg_replace('/[^0-9A-F]/i', '', strtoupper($snmpResponce['mac']));
            $snmpResponce['mac'] = preg_replace('~(..)(?!$)\.?~', '\1:', $snmpResponce['mac']);
        } else {
            $snmpResponce['mac'] = '00:00:00:00:00:00';
        }

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
