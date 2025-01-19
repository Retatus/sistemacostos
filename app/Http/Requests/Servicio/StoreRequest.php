<?php

namespace App\Http\Requests\Servicio;

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
            "monto" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "moneda" => 'required',
            "proveedor_id" => 'required',
            "servicio_detalle_id" => 'required',
            "ubicacion" => 'required|min:3|max:50',
            "tipo_pax" => 'required',
            "servicio_clase_id" => 'required',
            "estado_activo" => 'required|in:1,0',

        ];
    }

    public function messages():array
     {
         return [
             'monto.required' => 'El monto es obligatorio',
             'monto.numeric' => 'El monto debe ser un número',
             'monto.regex' => 'El monto debe tener dos decimales',
             'moneda.required' => 'La moneda es obligatoria',
             'proveedor_id.required' => 'El proveedor es obligatorio',
             'servicio_detalle_id.required' => 'El detalle del servicio es obligatorio',
             'ubicacion.required' => 'La ubicación es obligatoria',
             'ubicacion.min' => 'La ubicación debe tener al menos 3 caracteres',
             'ubicacion.max' => 'La ubicación no debe exceder 50 caracteres',
             'tipo_pax.required' => 'El tipo de pax es obligatorio',
             'servicio_clase_id.required' => 'La clase de servicio es obligatoria',
             'estado_activo.required' => 'El estado activo es obligatorio',
         ];
     }
}
