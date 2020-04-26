<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\MtBoard;
use App\Represent\Represent;
use App\Service\CreateMikrotik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class MtBoardController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CreateMikrotik $createMt
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function store(Request $request, CreateMikrotik $createMt)
    {

        if (! Represent::from('mt_boards')->can('create')) {
            return response()
                ->json(['errors' => ['access'=>['Not authorized.']]],403);
        }

        $validator = Validator::make($request->all(), [
            'ip'        => 'required|ip',
            'username'  => 'string',
            'password'  => 'string',
            'port'      => 'numeric',
            'legacy'    => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()
                ->json(['errors' => $validator->errors()], 422);
        }

        // use exist password or pick all unique passwords from DB
        $passList = $request->exists('password')
            ? [$request->get('password')]
            : MtBoard::getAllPasswords();

        // try login with passwords
        foreach ($passList as $pass) {

            $mtWithErr = $createMt(
                $request->ip,
                $request->get('username', 'admin'),
                $pass,
                $request->get('port', 8728),
                $request->get('legacy', false)
            );

            if (isset($mtWithErr[1])) {
                return $mtWithErr[1];
            }
        }

        return response()
            ->json(['errors' => ['internal'=>['Can not create new MT board.']]],418);
    }





//
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        //
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, $id)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy($id)
//    {
//        //
//    }
}
