<?php

namespace App\Http\Requests\Cotizacion;

use Illuminate\Foundation\Http\FormRequest;

class StoreCotizacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [

            // 🔹 Cotizacion
            'id' => 'nullable|integer|exists:cotizacions,id',
            'proveedor_id' => 'required|integer|exists:proveedors,id',
            'file_nro' => 'required|string|max:10',
            'file_nombre' => 'required|string|max:25',
            'comprobante_id' => 'required|integer|exists:comprobantes,id',
            'fecha' => 'required|date',
            'estado_reserva' => 'required|integer',
            'estado_documentacion' => 'required|integer',
            'nro_pasajeros' => 'required|integer|min:0',
            'nro_ninio' => 'required|integer|min:0',
            'nro_adulto' => 'required|integer|min:0',
            'nro_estudiante' => 'required|integer|min:0',
            'idioma_id' => 'required|integer|exists:idiomas,id',
            'mercado_id' => 'required|integer|exists:mercados,id',
            'destino_turistico_id' => 'required|integer|exists:destinos_turisticos,id',
            'pais_id' => 'required|integer|exists:paises,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'nro_dias' => 'required|integer|min:1',
            'estado_cotizacion' => 'required|integer',
            'costo_parcial' => 'required|numeric|min:0',
            'descuento_estudiante' => 'required|numeric|min:0',
            'descuento_ninio' => 'required|numeric|min:0',
            'descuento_otro' => 'required|numeric|min:0',
            'costo_total' => 'required|numeric|min:0',
            'estado_activo' => 'required|integer',
            'destino_turistico_detalle' => 'nullable|array',
            'destino_turistico_detalle_monto_x_categoria' => 'nullable|array',
            'destinos_turisticos' => 'nullable|array',
            'dias' => 'required|array|min:1',
            'pasajeros' => 'required|array|min:1',

            // 🔹 Pasajeros
            'pasajeros' => 'required|array|min:1',
            'pasajeros.*.temp_id' => 'required|string|max:50',
            'pasajeros.*.nombre' => 'required|string|max:25',
            'pasajeros.*.apellido_paterno' => 'required|string|max:25',
            'pasajeros.*.apellido_materno' => 'nullable|string|max:25',
            'pasajeros.*.documento_tipo_id' => 'required|integer|exists:documento_tipos,id',
            'pasajeros.*.documento_numero' => 'required|string|max:15',
            'pasajeros.*.pais_id' => 'required|integer|exists:paises,id',
            'pasajeros.*.documento_file' => 'nullable|string|max:255',
            'pasajeros.*.temp_file_name' => 'nullable|string|max:255',
            'pasajeros.*.temp_file_preview' => 'nullable|string|max:255',
            'pasajeros.*.tipo_pasajero_id' => 'required|string|max:50',
            'pasajeros.*.clase_id' => 'required|integer|exists:clases,id',
            'pasajeros.*.cotizacion_id' => 'required|integer|exists:cotizacions,id',
            'pasajeros.*.estado_activo' => 'required|integer',

            // 🔹 Días
            'dias' => 'required|array|min:1',
            'dias.*.dia' => 'required|integer|min:1',
            'dias.*.nombre' => 'required|string|max:100',
            'dias.*.descripcion' => 'nullable|string',

            // 🔹 Servicios
            'dias.*.servicios' => 'required|array|min:1',

            'dias.*.servicios.*.servicio_id' => 'required|integer|exists:servicios,id',
            'dias.*.servicios.*.proveedor_id' => 'required|integer|exists:proveedors,id',

            'dias.*.servicios.*.orden' => 'required|integer|min:1',
            'dias.*.servicios.*.hora' => 'nullable|date_format:H:i',

            'dias.*.servicios.*.nombre_servicio' => 'required|string|max:255',
            'dias.*.servicios.*.observacion' => 'nullable|string',

            'dias.*.servicios.*.tipo_costo_id' => 'required|exists:tipo_costos,id',
            'dias.*.servicios.*.tipo_habitacion_id' => 'nullable|exists:tipo_habitacions,id',
            'dias.*.servicios.*.precio_id' => 'nullable|exists:precios,id',

            'dias.*.servicios.*.moneda' => 'required|in:USD,PEN',
            'dias.*.servicios.*.precio_unitario' => 'required|numeric|min:0',
            'dias.*.servicios.*.cantidad' => 'required|integer|min:1',
            'dias.*.servicios.*.capacidad' => 'nullable|integer|min:1',
            'dias.*.servicios.*.subtotal' => 'required|numeric|min:0',

            // 🔹 Pasajeros por servicio (pivot)
            'dias.*.servicios.*.pasajeros' => 'nullable|array',

            'dias.*.servicios.*.pasajeros.*.pasajero_index' => 'required|integer|min:0',
            'dias.*.servicios.*.pasajeros.*.precio' => 'required|numeric|min:0',
            'dias.*.servicios.*.pasajeros.*.cantidad' => 'required|integer|min:1',
            'dias.*.servicios.*.pasajeros.*.descuento' => 'nullable|numeric|min:0',
            'dias.*.servicios.*.pasajeros.*.total' => 'required|numeric|min:0',
        ];
    }
}
