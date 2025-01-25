<?php

namespace App\Http\Requests\ServicioDetalle;

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
             "descripcion" => 'required|min:3|max:100',
            "proveedor_categoria_id" => 'required',
            "costo_id" => 'required',
            "destino_id" => 'required',
            "distribucion_venta_id" => 'required',
            "estado_activo" => 'required|in:1,0',

        ];
    }
}
