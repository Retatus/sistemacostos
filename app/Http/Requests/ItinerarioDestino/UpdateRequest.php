<?php

namespace App\Http\Requests\ItinerarioDestino;

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
            "itinerario_id" => 'required',
            "destino_turistico_id" => 'required',
            "nombre" => 'required|min:3|max:45',
            "descripcion" => 'required',
            "observacion" => 'required|min:3|max:100',
            "estado_activo" => 'required',

        ];
    }
}
