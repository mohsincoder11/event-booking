<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required|in:VIP,Standard,Economy',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ];
    }
}
