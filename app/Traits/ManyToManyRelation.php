<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ManyToManyRelation {

    public function sync_relations (Request $request)
    {
        if(isset($this->relations)) {
            foreach ($this->relations as $relations) {
                $this->{$relations}()->sync($request->get($relations));
            }
        }
    }

}
