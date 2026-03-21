<?php

namespace App\Http\Requests\CotizacionDia;

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
             "cotizacion_id" => 'required',
            "dia" => 'required',
            "nombre" => 'required|min:3|max:100',
            "descripcion" => 'required',
            "estado_activo" => 'required',

        ];
    }
}
