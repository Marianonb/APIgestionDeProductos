<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'precio', 'cantidad'];

    // Atributos
    protected $attributes = [
        'precio' => 0.00,
        'cantidad' => 0
    ];

    // Métodos
    public function incrementarCantidad($cantidad)
    {
        $this->cantidad += $cantidad;
        $this->save();
    }

    public function decrementarCantidad($cantidad)
    {
        if ($this->cantidad >= $cantidad) {
            $this->cantidad -= $cantidad;
            $this->save();
            return true;
        }
        return false;
    }

}

