<?php

namespace App\Http\Requests\proveedor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
            "ruc" => 'required|string|regex:/^\d{11,18}$/',
            "razon_social" => 'required|min:3|max:100',
            "direccion" => 'required|min:3|max:100',
            "tipo_comprobante" => 'required|min:1|max:2',
            "tipo_documento" => 'required|min:1|max:2',
            "correo" => 'required|min:3|max:100',
            "tipo_sunat" => 'required|min:1|max:1',
            "contacto" => 'required|min:3|max:50',
            "estado_activo" => 'required',
            "proveedor_categoria_id" => 'required',
        ];
    }

    public function messages():array
    {
        return [         
            'ruc.required' => 'El RUC es obligatorio',
            'ruc.regex' => 'El RUC debe contener solo números entre 11 y 18 dígitos',   
            'razon_social.required' => 'La razón social es obligatoria',
            'razon_social.min' => 'La razón social debe tener al menos 3 caracteres',
            'razon_social.max' => 'La razón social no debe exceder 100 caracteres',
            'direccion.required' => 'La direccion es obligatoria',
            'direccion.min' => 'La direccion debe tener al menos 3 caracteres',
            'direccion.max' => 'La direccion no debe exceder 100 caracteres',
            'tipo_comprobante.required' => 'El tipo de comprobante es obligatorio',
            'tipo_comprobante.min' => 'El tipo de comprobante debe tener al menos 2 caracteres',
            'tipo_comprobante.max' => 'El tipo de comprobante no debe exceder 2 caracteres',
            'tipo_documento.required' => 'El tipo de documento es obligatorio',
            'tipo_documento.min' => 'El tipo de documento debe tener al menos 1 caracteres',
            'tipo_documento.max' => 'El tipo de documento no debe exceder 1 caracteres',
            'correo.required' => 'El correo es obligatorio',
            'correo.min' => 'El correo debe tener al menos 3 caracteres',
            'correo.max' => 'El correo no debe exceder 100 caracteres',
            'tipo_sunat.required' => 'El tipo SUNAT es obligatorio',
            'tipo_sunat.min' => 'El tipo SUNAT debe tener al menos 1 caracteres',
            'tipo_sunat.max' => 'El tipo SUNAT no debe exceder 1 caracteres',
            'contacto.required' => 'El contacto es obligatorio',
            'contacto.min' => 'El contacto debe tener al menos 3 caracteres',        
            'contacto.max' => 'El contacto no debe exceder 50 caracteres',
            'estado_activo.required' => 'El estado activo es obligatorio',
            'proveedor_categoria_id.required' => 'La categoría del proveedor es obligatoria',
        ];
    }   
}
