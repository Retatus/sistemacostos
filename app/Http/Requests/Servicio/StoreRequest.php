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
            "proveedor_id" => 'required',
            "servicio_detalle_id" => 'required',
            "ubicacion_id" => 'required',
            "estado_activo" => 'required|in:1,0',

        ];
    }

    public function messages():array
     {
         return [
             'proveedor_id.required' => 'El proveedor es obligatorio',
             'servicio_detalle_id.required' => 'El detalle del servicio es obligatorio',
             'ubicacion.required' => 'La ubicación es obligatoria',
             'estado_activo.required' => 'El estado activo es obligatorio',
         ];
     }
}
