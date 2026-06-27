<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cotizacion\StoreCotizacionRequest;

use App\Models\Cotizacion;
use App\Models\Proveedor;
use App\Http\Resources\CotizacionResource;
use App\Http\Resources\DestinoTuristicoResource;
use App\DTO\CotizacionDTO;
use App\Factory\CotizacionFactory;
use App\Services\CotizacionServiceApi;
use App\Services\DestinoTuristicoServiceApi;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Json;

class CotizacionApiController extends Controller
{
    protected CotizacionServiceApi $cotizacionService;
    protected DestinoTuristicoServiceApi $destinoService;

    public function __construct(CotizacionServiceApi $cotizacionService, DestinoTuristicoServiceApi $destinoService)
    {
        $this->cotizacionService = $cotizacionService;
        $this->destinoService = $destinoService;
    }

    public function destino_select()
    {
        return response()->json(
            $this->destinoService->getDestinosForSelect()
        );
    }

    public function destino_search(Request $request)
    {
        $search = $request->input('search');
        return response()->json(
            $this->destinoService->searchDestinos($search)
        );
    }

    public function destino($id)
    {
        $destino = $this->cotizacionService->generarDesdeDestino($id);
        //dd('destino', Json::encode($destino, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        //return response()->json($cotizacion);
        return new DestinoTuristicoResource($destino);
    }
    /**
     * Cargar estructura inicial basada en un destino (plantilla)
     */
    public function create($id = null)
    {
        return response()->json(
            $this->cotizacionService->createEmpty()
        );
    }

    /**
     * Guardar nueva cotización
     */
    public function store(Request  $request)
    {    
        $data = $request->all();
        $dto = CotizacionFactory::fromArray($data);
        //dd('DTO recibido en el controlador:', Json::encode($dto, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        //Log::debug($dto);
        $cotizacion = $this->cotizacionService->create($dto);
        //dd('cotizacion creada', Json::encode($cotizacion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        //return response()->json($cotizacion);
        return new CotizacionResource($cotizacion);
    }

    /**
     * Cargar cotización para editar
     */
    public function edit(int $id)
    {                
        $cotizacion = $this->cotizacionService->editarCotizacion($id);
        return new CotizacionResource($cotizacion);
    }

    /**
     * Actualizar cotización existente
     */
    public function update(Request $request, Cotizacion $cotizacion)
    {
        $data = $request->all();

        $dto = CotizacionFactory::fromArray($data);

        $cotizacion = $this->cotizacionService->update($dto, $cotizacion);

        return new CotizacionResource($cotizacion);
    }

    /**
     * Listar cotizaciones (opcional)
     */
    public function index()
    {
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