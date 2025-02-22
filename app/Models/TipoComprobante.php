<?php

namespace App\Models;
use App\Http\Requests\TipoComprobante\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'estado_activo'];
}
