<?php

namespace App\Http\Requests\DestinoTuristico;

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
             "nombre" => 'required|min:3|max:100',
            "descripcion" => 'required',
            "pais" => 'required',
            "nro_dias" => 'required',
            "costo_total" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "margen" => 'required',
            "ganancia" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            "venta" => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',

        ];
    }
}
