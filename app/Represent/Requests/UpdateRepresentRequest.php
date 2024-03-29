<?php

namespace App\Represent\Requests;

class UpdateRepresentRequest extends RepresentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $represent = $this->getRepresent();

        return  $represent->can('edit')
             && $represent->exists($this->route('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $represent = $this->getRepresent();
        $request = $this;

        return array_map(function ($col) use ($represent, $request) {
            return array_merge(
                explode('|', $col['rules']),
                [
                    $col['editable']     ? 'editable:1' : 'editable:0',
                    $col['singular']     ? "unique:{$represent->model},{$col['alias']},{$request->route('id')}" : '',
                    $col['popup_values'] ? "allowed2apply:{$col['popup_values']},{$this->stringify($request->request->get($col['alias']))}" : '',
                ]);
        }, $this->represent->columns);
    }
}
