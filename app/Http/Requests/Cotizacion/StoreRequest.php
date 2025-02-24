<?php

namespace App\Http\Requests\Cotizacion;

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
             "proveedor_id" => 'required',
            "file_nro" => 'required|min:3|max:10',
            "file_nombre" => 'required|min:3|max:25',
            "comprobante_id" => 'required',
            "fecha" => 'required',
            "nro_pasajeros" => 'required',
            "nro_ninio" => 'required',
            "nro_adulto" => 'required',
            "nro_estudiante" => 'required',
            "idioma" => 'required',
            "mercado" => 'required',
            "destino_turistico_id" => 'required',
            "pais_id" => 'required',
            "fecha_inicio" => 'required',
            "fecha_fin" => 'required',
            "nro_dias" => 'required',
            "estado_cotizacion" => 'required',
            "costo_parcial" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "descuento_estudiante" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "descuento_ninio" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "descuento_otro" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "costo_total" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "estado_activo" => 'required',

        ];
    }
}
