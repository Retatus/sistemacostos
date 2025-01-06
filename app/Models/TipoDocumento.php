<?php

namespace App\Models;
use App\Http\Requests\TipoDocumento\StoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;    

    protected $fillable = ['codigo', 'nombre', 'estado'];
}
