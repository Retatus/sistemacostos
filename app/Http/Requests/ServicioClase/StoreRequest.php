<?php

namespace App\Http\Requests\ServicioClase;

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
            'nombre' => ['required','string','min:3','max:25', Rule::unique(table: 'servicio_clases', column: 'nombre')->ignore(id: request('store'), idColumn: 'id')],
            //"estado_activo" => 'required',

        ];
    }
}
