<?php

namespace App\Models;
use App\Http\Requests\PasajeroServicio\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasajeroServicio extends Model
{
    use HasFactory;    

    protected $fillable = ['pasajero_id', 'itinerario_servicio_id', 'estado_activo'];
}
