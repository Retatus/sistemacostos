<?php

namespace App\Models;
use App\Http\Requests\ClaseServicio\StoreRequest;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseServicio extends Model
{
    use HasFactory;    

    protected $fillable = ['nombre', 'estado'];
}
