<?php

namespace App\Http\Requests\CotizacionServicioPasajero;

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
             "cotizacion_servicio_id" => 'required',
            "pasajero_id" => 'required',
            "precio" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "cantidad" => 'required',
            "descuento" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "total" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "estado_activo" => 'required',

        ];
    }
}
