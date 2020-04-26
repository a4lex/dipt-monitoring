<?php


namespace App\Service;

use App\MtBoard;
use App\MtIface;
use Exception;
use RouterOS\Client;
use RouterOS\Query;

class CreateMikrotik
{

    protected $data = [
//        'if-ether'      => [ 'query' => '/interface/ethernet/print', ],
        'ifWlanList'        => [ 'query' => '/interface/wireless/print', 'single' => false, ],
        'identity'      => [ 'query' => '/system/identity/print', 'single' => true, ],
        'routerboard'   => [ 'query' => '/system/routerboard/print', 'single' => true, ],
        'resource'      => [ 'query' => '/system/resource/print', 'single' => true, ],
        'community'     => [ 'query' => '/snmp/community/print', 'single' => true, ],
        'snmp'          => [ 'query' => '/snmp/print', 'single' => true, ],
    ];

    protected $ifWlanList;
    protected $identity;
    protected $routerboard;
    protected $resource;
    protected $snmp;
    protected $community;

    public function __invoke($host, $user = 'admin', $pass = 'P1nkMT4us', $port = 8728, $legacy = false)
    {

        // fetch data from board via API
        try {
            $this->init($host, $user, $pass, (int) $port, (bool) $legacy);
        } catch (Exception $e) {
            return [$e->getMessage(), null];
        }

        // create new or update exists board
        $mtBoard = MtBoard::updateOrCreate(
            [
                'name' => $this->identity['name']
            ], [
                'last_ip' => $host,
                'username' => $user,
                'password' => $pass,
                'community' => $this->community['name'] ?? 'vis_mikrotik',
                'location2' => iconv('cp1251', 'utf-8', $this->snmp['location'] ?? ''),
                'sn' => $this->routerboard['serial-number'] ?? 'Unknown',
                'model' => $this->resource['board-name'] ?? 'Unknown',
                'version' => $this->resource['version'] ?? 'Unknown',
                'firmware' => $this->routerboard['current-firmware'] ?? 'Unknown',
            ]
        );

        // iface that still exists on boards
        $ifWlan4Save = [];

        // save all wireless ifaces of board
        foreach ($this->ifWlanList as $ifWlan) {

            if(in_array($ifWlan['interface-type'], ['virtual'])) {
                continue;
            }

            $ifData = $this->getWlanData($ifWlan);
            $ifWlan4Save[] = $ifWlan['radio-name'];

            $dbIfWlan = $mtBoard->wireslessIfaces()
                ->where('radio_name', '=', $ifWlan['radio-name'])
                ->first();

            if ($dbIfWlan) {
                $dbIfWlan->update($ifData);
            } else {
                $mtBoard->wireslessIfaces()
                    ->save(new MtIface($ifData));
            }
        }

        // remove old wireless ifaces of board
        $mtBoard->wireslessIfaces()
            ->whereNotIn('radio_name', $ifWlan4Save)
            ->delete();

        return [null, $mtBoard];
    }

    /**
     * Create connection and fetch data from board
     *
     * @param $host
     * @param $user
     * @param $pass
     * @param $port
     * @param $legacy
     * @throws \RouterOS\Exceptions\ClientException
     * @throws \RouterOS\Exceptions\ConfigException
     * @throws \RouterOS\Exceptions\QueryException
     */
    private function init($host, $user, $pass, $port, $legacy)
    {
        $client = new Client([
            'host' => $host, 'user' => $user, 'pass' => $pass, 'port' => $port, 'legacy' => $legacy, 'attempts' => 3,
        ]);

        foreach ($this->data as $key => $request) {
            $query = new Query($request['query']);
            $response = $client->query($query)->read();
            $this->$key = $this->data[$key]['single']
                ? $response[0]
                : $response;
        }
    }

    /**
     * Return data-array of wireless iface
     *
     * @param $ifWlan
     * @return array
     */
    private function getWlanData ($ifWlan)
    {
        return [
            'name' => $ifWlan['name'],
            'radio_name' => $ifWlan['radio-name'],
            'mode' => $ifWlan['mode'],
            'frequency' => $ifWlan['frequency'],
            'ch_width' => $ifWlan['channel-width'],
            'mac' => $ifWlan['mac-address'],
            'height' => 0,
            'azimuth' => 0,
        ];
    }
}
