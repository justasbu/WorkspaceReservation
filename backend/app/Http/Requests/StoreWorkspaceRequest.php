<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkspaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tableNumber' => ['string', 'required'],
            'monitorsCount' => ['integer', 'required'],
            'mount' => ['string', 'required'],
            'dockingStation' => ['string', 'required'],
            'headPhones' => ['string', 'required', 'max:255'],
            'tableType' => ['string', 'required'],
            'zone_id' => ['integer', 'required']

        ];
    }
}
