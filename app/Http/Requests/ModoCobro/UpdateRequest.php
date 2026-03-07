<?php

namespace App\Http\Requests\ModoCobro;

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
            "codigo" => 'required|min:3|max:20',
            "nombre" => 'required|min:3|max:50',
            "requiere_cantidad" => 'required',
            "requiere_habitacion" => 'required',
            "estado_activo" => 'required',

        ];
    }
}
