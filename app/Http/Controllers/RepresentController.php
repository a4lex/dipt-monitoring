<?php

namespace App\Http\Controllers;

use App\Represent\Requests\DestroyRepresentRequest;
use App\Represent\Requests\StoreRepresentRequest;
use App\Represent\Requests\UpdateRepresentRequest;
use App\Represent\Represent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class RepresentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(string $model)
    {
        $represent = Represent::from($model);

        if (! $represent->can('view')) {
            abort(403); ;
        }

//        dd($represent->query->toSql());
//        $datatable = datatables()->of($represent->query);

        if(request()->ajax()){

            if (request('_type') == 'query') {
                return $represent
                    ->where($represent->getPrefValColAlias(), 'LIKE', '%' . request('q'). '%')
                    ->get()
                    ->toJson();

            } else {
                // TODO think about wrapper raw query...
                $datatable = datatables()->of(
//                    $represent->query->toSql()
                    DB::table( DB::raw("({$represent->query->toSql()}) as represent"))
                );

                $rawColumns = [];

                foreach ($represent->columns as $columnName => $column) {
                    if(view()->exists($represent->getTableViewName($columnName))) {
                        $rawColumns[] = $columnName;
                        $datatable->editColumn($columnName,
                            function ($item) use ($columnName, $represent) {
                                return view($represent->getTableViewName($columnName))
                                    ->with(compact(['item', 'columnName', 'represent']));
                            }
                        );
                    }
                }

                return $datatable
                    ->rawColumns($rawColumns)
                    ->toJson();
            }

        } else {
//            dd(\request()->all());

            return view('represent.index')
                ->with(compact(['represent']));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($model)
    {
        $represent = Represent::from($model);

        if (! $represent->can('create')) {
            abort(403); ;
        }

        return view('represent.create')
            ->with(compact(['represent']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRepresentRequest $request)
    {
        $represent = $request->getRepresent()->getInstance();
        $obj = $represent->create($request->all());

        dd($request->all());
        if(isset($represent->pivotes)) {
            foreach ($represent->pivotes as $pivot) {
                $obj->{$pivot}()->sync($request->get('snmp_templates'));
            }
        }

        return redirect($request->getRepresent()->name);
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
    public function edit(string $model, int $id)
    {
        $represent = Represent::from($model);

        if (! $represent->can('edit')) {
            abort(403);
        }

        $data = (array) $represent
            ->where($represent->getPrefIdColAlias(), $id)
            ->first();

        return view('represent.edit')
            ->with(compact(['represent', 'data']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRepresentRequest $request
     * @param $id
     * @return array
     */
    public function update(UpdateRepresentRequest $request, $model, $id)
    {
        $represent = $request->getRepresent()
            ->getInstance()
            ->find($id);

        $represent->update($request->all());

        if(isset($represent->pivotes)) {
            foreach ($represent->pivotes as $pivot) {
                $represent->{$pivot}()->sync($request->get('snmp_templates'));
            }
        }

        return  back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRepresentRequest $request
     * @param $model
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyRepresentRequest $request, $model, $id)
    {
        $request->getRepresent()
            ->getInstance()
            ->find($id)
            ->delete();

        if ($request->isJson() or $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => "Item successfully removed",
            ], 200);
        }

        return redirect($request->getRepresent()->name);
    }
}
