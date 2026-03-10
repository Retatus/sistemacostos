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
            "nro_dia" => 'required',
            "nro_orden" => 'required',
            "hora" => 'required|min:3|max:5',
            "itinerario_servicio_id" => 'required',
            "cotizacion_id" => 'required',
            "precio_id" => 'required',
            "moneda" => 'required',
            "precio_unitario" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "cantidad" => 'required',
            "capacidad" => 'required',
            "tipo_habitacion_id" => 'required',
            "subtotal" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "observacion" => 'required|min:3|max:50',
            "tipo_costo_id" => 'required',
            "estado_activo" => 'required',

        ];
    }
}
