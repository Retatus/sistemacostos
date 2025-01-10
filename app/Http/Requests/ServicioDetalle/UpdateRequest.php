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
             "descripcion" => 'required|min:3|max:75',
            "costo_id" => 'required|min:3|max:',
            "destino_id" => 'required|min:3|max:',
            "distribucion_venta_id" => 'required|min:3|max:',
            "estado_activo" => 'required',

        ];
    }
}
