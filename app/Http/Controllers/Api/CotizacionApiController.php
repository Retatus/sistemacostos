<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cotizacion\StoreCotizacionRequest;

use App\Models\Cotizacion;
use App\Http\Resources\CotizacionResource;
use App\DTO\CotizacionDTO;
use App\Services\CotizacionServiceApi;
use Illuminate\Support\Facades\Log;

class CotizacionApiController extends Controller
{
    protected CotizacionServiceApi $service;

    public function __construct(CotizacionServiceApi $service)
    {
        $this->service = $service;
    }

    /**
     * Cargar estructura inicial basada en un destino (plantilla)
     */
    public function create(Request $request)
    {
        $destinoId = $request->query('destino_id');
        //dd('destino_id', $destinoId);

        if (!$destinoId) {
            return response()->json(['error' => 'destino_id es requerido'], 422);
        }

        // El service arma la cotización vacía basada en la plantilla
        $cotizacion = $this->service->buildFromDestino($destinoId);
        
        return new CotizacionResource($cotizacion);
    }

    /**
     * Guardar nueva cotización
     */
    public function store(Request  $request)
    {    
        $dto = CotizacionDTO::fromRequest($request);

        //Log::debug($dto);
        $cotizacion = $this->service->create($dto);

        return new CotizacionResource($cotizacion);
    }

    /**
     * Cargar cotización para editar
     */
    public function edit(Cotizacion $cotizacion)
    {
        $cotizacion->load([
            'destino',
            'dias.servicios.pasajeros',
            'pasajeros'
        ]);

        return new CotizacionResource($cotizacion);
    }

    /**
     * Actualizar cotización existente
     */
    public function update(Request $request, Cotizacion $cotizacion)
    {
        $dto = CotizacionDTO::fromRequest($request, $cotizacion->id);

        $cotizacion = $this->service->update($dto, $cotizacion);

        return new CotizacionResource($cotizacion);
    }

    /**
     * Listar cotizaciones (opcional)
     */
    public function index()
    {
        // $paginator = Cotizacion::with([
        //     'pasajeros',
        //     'dias.servicios.pasajeros'
        // ])
        // ->latest()
        // ->paginate(20);
        // return response()->json($paginator);

        return CotizacionResource::collection(
            Cotizacion::with([
                'pasajeros', 
                'dias.servicios.pasajeros'
            ])
            ->latest()
            ->paginate(20)
        );
    }

    /**
     * Mostrar una cotización (opcional)
     */
    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load([
            'destino',
            'dias.servicios.pasajeros',
            'pasajeros'
        ]);

        return new CotizacionResource($cotizacion);
    }

    /**
     * Eliminar cotización (opcional)
     */
    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->delete();

        return response()->json(['message' => 'Cotización eliminada']);
    }
}