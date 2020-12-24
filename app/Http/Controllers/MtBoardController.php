<?php

namespace App\Http\Controllers;

use App\MtBoard;
use App\Represent\Represent;
use App\Represent\Requests\StoreRepresentRequest;
use App\Service\CreateMikrotik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class MtBoardController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $represent = Represent::from('mt_boards');

        if (! $represent->can('create')) {
            abort(403); ;
        }

        return view('mtboard.create');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (! Represent::from('mt_boards')->can('edit')) {
            abort(403); ;
        }

        $mtBoard = MtBoard::where('id', $id)
            ->with('wireslessIfaces')
            ->first();

        return view('mtboard.edit')
            ->with(compact(['mtBoard']));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CreateMikrotik $createMt
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, CreateMikrotik $createMt)
    {
        if (! Represent::from('mt_boards')->can('create')) {
            abort(403); ;
        }

        $validator = Validator::make($request->all(), [
            'ip'        => 'required|ip',
            'username'  => 'required|string',
            'password'  => 'required|string',
            'port'      => 'required|numeric',
            'legacy'    => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $mtWithErr = $createMt(
            $request->ip,
            $request->username,
            $request->password,
            $request->port,
            $request->legacy
        );

        return isset($mtWithErr[0])
            ? back()
                ->withErrors(new MessageBag(['ip' => $mtWithErr[0]]))
                ->withInput()
            : redirect(action('MtBoardController@edit', $mtWithErr[1]));
    }
}
