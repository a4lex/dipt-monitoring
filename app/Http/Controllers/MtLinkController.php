<?php

namespace App\Http\Controllers;

use App\Represent\Represent;
use Illuminate\Http\Request;

class MtLinkController extends Controller
{
    function chart() {
        $represent = Represent::from('mt_links');

        if (! $represent->can('view')) {
            abort(403); ;
        }

        return view('mtboard.chart');
    }
}
