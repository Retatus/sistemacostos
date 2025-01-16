<?php

namespace App\Http\Requests\proveedor;

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
            "ruc" => 'required|min:3|max:15',
            "razon_social" => 'required|min:3|max:100',
            "direccion" => 'required|min:3|max:100',
            "tipo_comprobante" => 'required|min:3|max:25',
            "correo" => 'required|min:3|max:100',
            "tipo_sunat" => 'required|min:3|max:25',
            "contacto" => 'required|min:3|max:50',
            "estado_activo" => 'required',
            "proveedor_categoria" => 'required',

        ];
    }
}
