<?php

namespace App\Represent\Requests;

class DestroyRepresentRequest extends RepresentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $represent = $this->getRepresent();

        return  $represent->can('delete')
            && $represent->exists($this->route('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
