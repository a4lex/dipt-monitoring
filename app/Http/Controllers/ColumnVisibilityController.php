<?php

namespace App\Http\Controllers;

use App\Represent\Models\RepColumnVisibility;
use Illuminate\Http\Request;

class ColumnVisibilityController extends Controller
{


    /**
     * Set or create visibility of column.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function change_visibility(Request $request)
    {
        $colVisibility = RepColumnVisibility::updateOrCreate(
            [
                'user_id'   => auth()->id(),
                'column_id' => $request->get('column_id'),
            ], [
                'user_id'   => auth()->id(),
                'column_id' => $request->get('column_id'),
                'visible'   => $request->get('visible'),
            ]
        );
    }

}
