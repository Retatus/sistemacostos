<?php

namespace App\Http\Requests\Pasajero;

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
             "nombre" => 'required|min:3|max:25',
            "apellido_paterno" => 'required|min:3|max:25',
            "apellido_materno" => 'required|min:3|max:25',
            "documento_tipo_id" => 'required',
            "documento_numero" => 'required|min:3|max:15',
            "pais_id" => 'required',
            "documento_file" => 'required|min:3|max:225',
            "tipo_pasajero_id" => 'required',
            "clase_id" => 'required',
            "cotizacion_id" => 'required',
            "estado_activo" => 'required',

        ];
    }
}
