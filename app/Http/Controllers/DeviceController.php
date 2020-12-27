<?php

namespace App\Http\Controllers;

use App\DeviceType;
use App\Represent\Represent;
use App\Service\CreateDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class DeviceController extends Controller
{
    /**
     * Show the form for creating a new device.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $represent = Represent::from('devices');

        if (! $represent->can('create')) {
            abort(403); ;
        }

        return view('devices.create')->with('device_types', DeviceType::all('id','name'));
    }



    /**
     * Store a newly created device in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, CreateDevice $createDevice)
    {
        if (! Represent::from('devices')->can('create')) {
            abort(403); ;
        }

        $validator = Validator::make($request->all(), [
            'device_type_id'    => 'required|integer|exists:device_types,id',
            'ip'                => 'required|ip',
            'username'          => 'required|string',
            'password'          => 'required|string',
            'community'         => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $deviceWithErr = $createDevice(
            $request->device_type_id,
            $request->ip,
            $request->username,
            $request->password,
            $request->community
        );

        return isset($deviceWithErr[0])
            ? back()
                ->withErrors(new MessageBag(['ip' => $deviceWithErr[0]]))
                ->withInput()
            : redirect('/devices');
    }
}
