<?php

namespace App\Http\Requests\Cotizacion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class CotizacionRequest extends FormRequest
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
            'proveedor_razon_social' => 'required|string|max:255',
            'file_nro' => 'required|string|max:10',
            'file_nombre' => 'required|string|max:25',
            'fecha' => 'required|date',
            'nro_pasajeros' => 'required|integer|min:1',
            'nro_ninio' => 'required|integer|min:0',
            'nro_adulto' => 'required|integer|min:0',
            'nro_estudiante' => 'required|integer|min:0',
            'destino_turistico_detalle' => 'nullable|array',
            'destino_turistico_detalle_monto_x_categoria' => 'nullable|array',
            'fecha_inicio' =>  'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'nro_dias' => 'required|integer|min:1',
            'estado_cotizacion' => 'required|string|max:10',
            'costo_parcial' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'descuento_estudiante' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'descuento_ninio' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'descuento_otro' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'costo_total' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',

            'Pasajeros.*.nombre' => 'required|string|max:255',
            'Pasajeros.*.apellido_paterno' => 'required|string|max:255',
            'Pasajeros.*.apellido_materno' => 'required|string|max:255',
            'Pasajeros.*.documento_numero' => 'required|string|max:20',
            'Pasajeros.*.documento_file' => 'required|file|mimes:pdf',
        ];
    }
    public function messages(): array
    {
        return [
            'proveedor_razon_social.required' => 'La razon social del proveedor es obligatorio.',
            'proveedor_razon_social.string' => 'La razon social del proveedor debe ser una cadena de texto.',
            'proveedor_razon_social.max' => 'La razon social del proveedor no debe superar los 255 caracteres.',
            'file_nro.required' => 'El numero de archivo es obligatorio.',
            'file_nro.string' => 'El numero de archivo debe ser una cadena de texto.',
            'file_nro.max' => 'El numero de archivo no debe superar los 10 caracteres.',
            'file_nombre.required' => 'El nombre del archivo es obligatorio.',
            'file_nombre.string' => 'El nombre del archivo debe ser una cadena de texto.',
            'file_nombre.max' => 'El nombre del archivo no debe superar los 25 caracteres.',
            'fecha.required' => 'La fecha de la cotizacion es obligatorio.',
            'fecha.date' => 'La fecha de la cotizacion debe ser una fecha valida.',
            'nro_pasajeros.required' => 'El numero de pasajeros es obligatorio.',
            'nro_pasajeros.integer' => 'El numero de pasajeros debe ser un numero entero.',
            'nro_pasajeros.min' => 'El numero de pasajeros debe ser al menos 1.',
            'nro_ninio.required' => 'El numero de ninios es obligatorio.',
            'nro_ninio.integer' => 'El numero de ninios debe ser un numero entero.',
            'nro_ninio.min' => 'El numero de ninios debe ser al menos 0.',
            'nro_adulto.required' => 'El numero de adultos es obligatorio.',
            'nro_adulto.integer' => 'El numero de adultos debe ser un numero entero.',
            'nro_adulto.min' => 'El numero de adultos debe ser al menos 0.',
            'nro_estudiante.required' => 'El numero de estudiantes es obligatorio.',
            'nro_estudiante.integer' => 'El numero de estudiantes debe ser un numero entero.',
            'nro_estudiante.min' => 'El numero de estudiantes debe ser al menos 0.',
            'destino_turistico_detalle.array' => 'El detalle del destino turistico debe ser un array.',
            'destino_turistico_detalle_monto_x_categoria.array' => 'El detalle del monto por categoria del destino turistico debe ser un array.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatorio.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha valida.',
            'fecha_fin.required' => 'La fecha de fin es obligatorio.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha valida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser mayor o igual a la fecha de inicio.',
            'nro_dias.required' => 'El numero de dias es obligatorio.',
            'nro_dias.integer' => 'El numero de dias debe ser un numero entero.',
            'nro_dias.min' => 'El numero de dias debe ser al menos 1.',
            'estado_cotizacion.required' => 'El estado de la cotizacion es obligatorio.',
            'estado_cotizacion.string' => 'El estado de la cotizacion debe ser una cadena de texto.',
            'estado_cotizacion.max' => 'El estado de la cotizacion no debe superar los 10 caracteres.',
            'costo_parcial.required' => 'El costo parcial es obligatorio.',
            'costo_parcial.numeric' => 'El costo parcial debe ser un numero.',
            'costo_parcial.regex' => 'El costo parcial debe tener un formato valido.',
            'descuento_estudiante.required' => 'El descuento estudiante es obligatorio.',
            'descuento_estudiante.numeric' => 'El descuento estudiante debe ser un numero.',
            'descuento_estudiante.regex' => 'El descuento estudiante debe tener un formato valido.',
            'descuento_ninio.required' => 'El descuento ninio es obligatorio.',
            'descuento_ninio.numeric' => 'El descuento ninio debe ser un numero.',
            'descuento_ninio.regex' => 'El descuento ninio debe tener un formato valido.',
            'descuento_otro.required' => 'El descuento otro es obligatorio.',
            'descuento_otro.numeric' => 'El descuento otro debe ser un numero.',
            'descuento_otro.regex' => 'El descuento otro debe tener un formato valido.',
            'costo_total.required' => 'El costo total es obligatorio.',
            'costo_total.numeric' => 'El costo total debe ser un numero.',
            'costo_total.regex' => 'El costo total debe tener un formato valido.',

            'Pasajeros.*.nombre.required' => 'El nombre es obligatorio :index.',
            'Pasajeros.*.nombre.string' => 'El nombre debe ser una cadena de texto :index.',
            'Pasajeros.*.nombre.max' => 'El nombre no debe superar los 255 caracteres :index.',
            'Pasajeros.*.apellido_paterno.required' => 'El apellido paterno es obligatorio :index.',
            'Pasajeros.*.apellido_paterno.string' => 'El apellido paterno debe ser una cadena de texto :index.',
            'Pasajeros.*.apellido_paterno.max' => 'El apellido paterno no debe superar los 255 caracteres :index.',
            'Pasajeros.*.apellido_materno.required' => 'El apellido materno es obligatorio :index.',
            'Pasajeros.*.apellido_materno.string' => 'El apellido materno debe ser una cadena de texto :index.',
            'Pasajeros.*.apellido_materno.max' => 'El apellido materno no debe superar los 255 caracteres :index.',
            'Pasajeros.*.documento_numero.required' => 'El numero de documento es obligatorio :index.',
            'Pasajeros.*.documento_numero.string' => 'El numero de documento debe ser una cadena de texto :index.',
            'Pasajeros.*.documento_numero.max' => 'El numero de documento no debe superar los 20 caracteres :index.',
            'Pasajeros.*.documento_file.required' => 'El archivo de documento es obligatorio :index.',
            'Pasajeros.*.documento_file.file' => 'El archivo de documento debe ser un archivo :index.',
            'Pasajeros.*.documento_file.mimes' => 'El archivo de documento debe ser un archivo pdf :index.',
        ];
    }

    public function attributes(): array
    {
        return [
            'descuento_estudiante' => 'descuento estudiante',
            'descuento_ninio' => 'descuento ninio',
            'descuento_otro' => 'descuento otro',
            'costo_total' => 'costo total',
            'Pasajeros.*.nombre' => 'nombre',
            'Pasajeros.*.apellido_paterno' => 'apellido paterno',
            'Pasajeros.*.apellido_materno' => 'apellido materno',
            'Pasajeros.*.documento_numero' => 'numero de documento',
            'Pasajeros.*.documento_file' => 'archivo de documento',
        ];    
    }
}
