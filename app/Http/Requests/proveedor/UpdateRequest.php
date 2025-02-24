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
            "tipo_documento_id" => ['required', Rule::in([1, 2, 3])],
            "ruc" => [
                'required',
                //Rule::unique('proveedors', 'ruc')->ignore(request('proveedors'), 'id'),
                Rule::when(intval($this->input('tipo_documento_id')) == 1, ['digits:8']),  // DNI (8 dígitos)
                Rule::when(intval($this->input('tipo_documento_id')) == 2, ['digits:11']), // RUC (11 dígitos)
                Rule::when(intval($this->input('tipo_documento_id')) == 3, ['regex:/^[A-Za-z0-9]{6,12}$/']), // PASAPORTE (6 a 12 caracteres alfanuméricos)
            ],
            "razon_social" => 'required|min:3|max:100',
            "direccion" => 'required|min:3|max:100',
            "tipo_comprobante" => 'required',
            "correo" => 'required|min:3|max:100',
            "tipo_sunat" => 'required',
            "contacto" => 'required|min:3|max:50',
            "estado_activo" => 'required|in:1,0',
            "proveedor_categoria_id" => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'ruc.required' => 'El número de documento es obligatorio.',
            'ruc.unique' => 'El número de documento ya está registrado.',

            // Mensajes específicos según tipo de documento
            'ruc.digits' => 'El RUC debe tener exactamente 11 dígitos.',
            'ruc.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'ruc.regex' => 'El pasaporte debe contener entre 6 y 12 caracteres alfanuméricos.',

            'razon_social.required' => 'La razón social es obligatoria',
            'razon_social.min' => 'La razón social debe tener al menos 3 caracteres',
            'razon_social.max' => 'La razón social no debe exceder 100 caracteres',
            'direccion.required' => 'La dirección es obligatoria',
            'direccion.min' => 'La dirección debe tener al menos 3 caracteres',
            'direccion.max' => 'La dirección no debe exceder 100 caracteres',
            'tipo_comprobante.required' => 'El tipo de comprobante es obligatorio',
            'tipo_documento_id.required' => 'El tipo de documento es obligatorio',
            'correo.required' => 'El correo es obligatorio',
            'correo.min' => 'El correo debe tener al menos 3 caracteres',
            'correo.max' => 'El correo no debe exceder 100 caracteres',
            'tipo_sunat.required' => 'El tipo SUNAT es obligatorio',
            'contacto.required' => 'El contacto es obligatorio',
            'contacto.min' => 'El contacto debe tener al menos 3 caracteres',
            'contacto.max' => 'El contacto no debe exceder 50 caracteres',
            'estado_activo.required' => 'El estado activo es obligatorio',
            'proveedor_categoria_id.required' => 'La categoría del proveedor es obligatoria',
        ];
    }

}
