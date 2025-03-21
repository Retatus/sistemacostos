<?php

namespace App\Http\Requests\ItinerarioServicio;

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
            "nro_orden" => 'required',
            "servicio_id" => 'required',
            "itinerario_destino_id" => 'required',
            "observacion" => 'required|min:3|max:100',
            "monto" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "estado_activo" => 'required',
        ];
    }
}
