<?php

namespace App\Http\Requests\TipoDocumento;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
            'codigo' => ['required','string','min:2','max:2', Rule::unique(table: 'tipo_documentos', column: 'nombre')->ignore(id: request('store'), idColumn: 'id')],
            'nombre' => ['required','string','min:3','max:15', Rule::unique(table: 'tipo_documentos', column: 'nombre')->ignore(id: request('store'), idColumn: 'id')],
            'estado' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.unique' => 'El :attribute ya está registrado.',
            'required' => 'El campo :attribute es obligatorio.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'max' => 'El campo :attribute debe tener como máximo :max caracteres.',
            'unique' => 'El campo :attribute debe ser único.',
        ];
    }
}
