<?php

namespace App\Http\Requests\DestinoTuristico;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class DestinoTuristicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            // Reglas generales
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'pais_id' => 'required|integer|exists:pais,id',
            'nro_dias' => 'required|integer|min:1',
            'costo_total' => 'required|numeric|min:0',
            'margen' => 'required|numeric|min:0|max:100',
            'ganancia' => 'required|numeric|min:0',
            'venta' => 'required|numeric|min:0',
            'estado_activo' => 'required|boolean',

            // Reglas de los detalles anidados
            'destino_turistico_detalle' => 'required|array|min:1',
            'destino_turistico_detalle.*.nro_dia' => 'required|integer|min:1',
            'destino_turistico_detalle.*.itinerario_id' => 'required|integer|exists:itinerarios,id',
            'destino_turistico_detalle.*.nombre' => 'nullable|string|max:255',
            'destino_turistico_detalle.*.observacion' => 'nullable|string|max:1000',
            'destino_turistico_detalle.*.estado_activo' => 'required|boolean',
            'destino_turistico_detalle.*.destino_turistico_id' => 'nullable|integer|exists:destinos_turisticos,id',
            'destino_turistico_detalle.*.descripcion' => 'nullable|string|max:1000',

            // Reglas de los servicios anidados
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio' => 'required|array|min:1',
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.proveedor_categoria_id' => 'required|integer|exists:proveedor_categorias,id',
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.proveedor_id' => 'required|integer|exists:proveedors,id',
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.servicio_id' => 'required|integer|exists:servicios,id',
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.costo' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            // Mensajes generales
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 1000 caracteres.',
            'pais_id.required' => 'El país es obligatorio.',
            'pais_id.exists' => 'El país seleccionado no es válido.',
            'nro_dias.required' => 'El número de días es obligatorio.',
            'nro_dias.min' => 'El número de días debe ser al menos 1.',
            'costo_total.required' => 'El costo total es obligatorio.',
            'costo_total.min' => 'El costo total no puede ser negativo.',
            'margen.required' => 'El margen es obligatorio.',
            'margen.min' => 'El margen debe ser al menos 0.',
            'margen.max' => 'El margen no puede superar el 100%.',
            'ganancia.required' => 'La ganancia es obligatoria.',
            'ganancia.min' => 'La ganancia no puede ser negativa.',
            'venta.required' => 'El valor de venta es obligatorio.',
            'venta.min' => 'El valor de venta no puede ser negativo.',
            'estado_activo.required' => 'El estado activo es obligatorio.',
            'estado_activo.boolean' => 'El estado activo debe ser verdadero o falso.',

            // Mensajes de los detalles
            'destino_turistico_detalle.required' => 'Debe incluir al menos un detalle de destino turístico.',
            'destino_turistico_detalle.*.nro_dia.required' => 'El número de día es obligatorio para el detalle :index.',
            'destino_turistico_detalle.*.itinerario_id.required' => 'El itinerario es obligatorio para el detalle :index.',
            'destino_turistico_detalle.*.itinerario_id.exists' => 'El itinerario seleccionado no es válido para el detalle :index.',
            'destino_turistico_detalle.*.descripcion.max' => 'La descripción no puede superar los 1000 caracteres en el detalle :index.',
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.required' => 'Debe incluir al menos un servicio en el detalle del destino turístico :index.',

            // Mensajes de los servicios anidados
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.proveedor_categoria_id.required' => 'La categoría del proveedor es obligatoria para el servicio :service_index del detalle :index.',
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.proveedor_id.required' => 'El proveedor es obligatorio para el servicio :service_index del detalle :index.',
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.servicio_id.required' => 'El detalle del servicio es obligatorio para el servicio :service_index del detalle :index.',
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.costo.required' => 'El costo es obligatorio para el servicio :service_index del detalle :index.',
        ];
    }

    public function attributes(): array
    {
        return [
            // Atributos generales
            'nombre' => 'nombre',
            'descripcion' => 'descripción',
            'pais_id' => 'país',
            'nro_dias' => 'número de días',
            'costo_total' => 'costo total',
            'margen' => 'margen',
            'ganancia' => 'ganancia',
            'venta' => 'valor de venta',
            'estado_activo' => 'estado activo',

            // Atributos de los detalles
            'destino_turistico_detalle' => 'detalles del destino turístico',
            'destino_turistico_detalle.*.nro_dia' => 'número de día',
            'destino_turistico_detalle.*.itinerario_id' => 'itinerario',
            'destino_turistico_detalle.*.descripcion' => 'descripción',

            // Atributos de los servicios anidados
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.proveedor_categoria_id' => 'categoría del proveedor',
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.proveedor_id' => 'proveedor',
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.servicio_id' => 'detalle del servicio',
            'destino_turistico_detalle.*.destino_turistico_detalle_servicio.*.costo' => 'costo',
        ];
    }
}
