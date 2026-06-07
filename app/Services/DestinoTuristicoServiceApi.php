<?php

namespace App\Services;

use App\Mappers\DestinoToCotizacionMapper;
use App\Repositories\DestinoTuristicoRepository;
use Nette\Utils\Json;

class DestinoTuristicoServiceApi
{
    protected $repository;

    public function __construct(DestinoTuristicoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getDestinosForSelect()
    {
        return $this->repository->getAllForSelect();
    }

    public function searchDestinos(string $search = null)
    {
        return $this->repository->searchForAutocomplete($search);
    }

    public function RecuperarDestino($destinoId)
    {
        return $this->repository->DestinoSeleccionado($destinoId);
    }

    public function RecuperarDestinoParaCotizacion($destinoId)
    {
        $destino = $this->repository->DestinoSeleccionado($destinoId);

        //dd('destino', Json::encode($destino, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return DestinoToCotizacionMapper::map($destino);
    }
}