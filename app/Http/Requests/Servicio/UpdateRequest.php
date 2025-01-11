<?php

namespace App\Http\Requests\Servicio;

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
            "monto" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "moneda" => 'required',
            "proveedor_id" => 'required',
            "servicio_detalle_id" => 'required',
            "ubicacion" => 'required|min:3|max:50',
            "tipo_pax" => 'required',
            "servicio_clase_id" => 'required',
            "estado_activo" => 'required',

        ];
    }
}
