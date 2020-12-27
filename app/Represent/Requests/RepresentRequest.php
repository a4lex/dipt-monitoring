<?php

namespace App\Represent\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Represent\Represent;


abstract class RepresentRequest extends FormRequest
{
    protected $represent;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Return created represent
     *
     * @return Represent
     */
    public function getRepresent()
    {
        return $this->represent = $this->represent
            ?? Represent::from($this->route('model'));
    }

    /**
     * Return imloded string from array
     *
     * @param $args
     * @return string
     */
    protected   function stringify($args)
    {
        return is_array($args) ? implode(',', $args) : $args;
    }
}
