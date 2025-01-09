<?php

namespace App\Models;
use App\Http\Requests\DistribucionVenta\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistribucionVenta extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'descripcion', 'estado'];
}
