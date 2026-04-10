<?php

namespace App\Services;

use App\Repositories\DestinoTuristicoRepository;

class DestinoTuristicoServiceApi
{
    protected $repository;

    public function __construct(DestinoTuristicoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function RecuperarDestino($destinoId)
    {
        return $this->repository->DestinoSeleccionado($destinoId);
    }
}