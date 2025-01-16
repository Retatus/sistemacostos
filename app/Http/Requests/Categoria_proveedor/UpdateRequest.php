<?php

namespace App\Http\Requests\Categoria_proveedor;

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
            "nombre" => ['required', 'string','max:100', 'min:3', Rule::unique(table: 'categoria_proveedor', column: 'nombre')->ignore(id: request('categoria_proveedor'), idColumn : 'id')],
            "estado" => 'required|in:1,0',
        ];
    }
     public function messages():array
     {
         return [
             'nombre.unique' => 'El nombre ya existe',
         ];
     }
}