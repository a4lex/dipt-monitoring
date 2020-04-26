<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepresentRequest;
use App\Represent\Represent;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        $represent = Represent::from('users');

        if(request()->ajax()){

            if (request('_type') == 'query') {
                return $represent
                    ->where($represent->getPrefValColAlias(), 'LIKE', '%' . request('q'). '%')
                    ->get()
                    ->toJson();
            } else {
                return datatables()->of($represent->query)
                    ->editColumn($represent->col_val, '<a href="{{url("/users/" . $id)}}"> {{$name}} </a>')
                    ->addColumn('action', function ($m) {
                        return  '<a href="' . url('/users/' . $m->id . '/edit') . '"> Edit </a>';
                    })
                    ->rawColumns(['action', 'name'])
                    ->toJson();
            }


        } else {
            return view('represent.index')
                ->with(compact(['represent']));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $represent = Represent::from('users');
        $data = (array) $represent
            ->where($represent->getPrefIdColAlias(), $id)
            ->first();

        return view('represent.edit')
            ->with(compact(['represent', 'data']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRepresentRequest $request
     * @param $id
     * @return array
     */
    public function update(StoreRepresentRequest $request, $id)
    {
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
