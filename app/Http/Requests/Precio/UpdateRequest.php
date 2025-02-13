<?php

namespace App\Http\Requests\Precio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class UpdateRequest extends FormRequest
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
             "anio" => 'required|min:3|max:',
            "moneda" => 'required',
            "precio" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "tipo_pasajero_id" => 'required',
            "servicio_id" => 'required',
            "estado_activo" => 'required',

        ];
    }
}
