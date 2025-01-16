<?php

namespace App\Http\Requests\Destino;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             "codigo" => 'required|min:3|max:3',
            "nombre" => 'required|min:3|max:25',
            "estado_activo" => 'required|min:3|max:',

        ];
    }
}
