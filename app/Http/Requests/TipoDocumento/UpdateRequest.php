<?php

namespace App\Http\Requests\TipoDocumento;

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
    public function rules()
    {
        return [
            'nombre' => [
                'required',               // Campo obligatorio
                'string',                 // Debe ser una cadena de texto
                'min:3',                  // Longitud mínima de 3 caracteres
                'max:25',                 // Longitud máxima de 25 caracteres
                Rule::unique('tipo_documentos', 'nombre') // Único en la tabla tipo_documentos
                ->ignore(id: request('update'), idColumn: 'id') // Ignora el registro actual al actualizar
              //->ignore($this->route('tipoDocumento')->id, 'id') // Ignora el registro actual al actualizar
            ],
            'estado_activo' => [
                'required|in:1,0',        // Campo obligatorio y debe ser 1 o 0
            ],
        ];
    }

    /**
     * Mensajes de error personalizados (opcional).
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            'nombre.min' => 'El campo nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El campo nombre no puede tener más de 25 caracteres.',
            'nombre.unique' => 'El nombre ya está registrado en otro documento.',
            'estado_activo.required' => 'El campo estado activo es obligatorio.',
            'estado_activo.boolean' => 'El campo estado activo debe ser verdadero (1) o falso (0).',
        ];
    }
}
