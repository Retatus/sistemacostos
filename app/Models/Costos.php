<?php

namespace App\Models;
use App\Http\Requests\Costos\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costos extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'estado_activo'];
}
