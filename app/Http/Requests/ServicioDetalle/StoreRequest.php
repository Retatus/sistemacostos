<?php

namespace App\Http\Requests\ServicioDetalle;

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
             "descripcion" => 'required|min:3|max:75',
            "costo" => 'required|min:3|max:15',
            "destino" => 'required',
            "distribucion" => 'required',
            "estado_activo" => 'required',

        ];
    }
}
