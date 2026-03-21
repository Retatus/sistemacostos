<?php

namespace App\Http\Requests\CotizacionServicio;

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
             "cotizacion_id" => 'required',
            "cotizacion_dia_id" => 'required',
            "servicio_id" => 'required',
            "proveedor_id" => 'required',
            "orden" => 'required',
            "hora" => 'required|min:3|max:5',
            "nombre_servicio" => 'required|min:3|max:100',
            "observacion" => 'required',
            "tipo_costo_id" => 'required',
            "tipo_habitacion_id" => 'required',
            "precio_id" => 'required',
            "moneda" => 'required',
            "precio_unitario" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "cantidad" => 'required',
            "capacidad" => 'required',
            "subtotal" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "estado_activo" => 'required',

        ];
    }
}
