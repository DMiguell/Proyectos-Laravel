<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo','imagen','descripcion','skills','categoria_id','experiencia_id','ubicacion_id','salario_id',
    ];
    // Relacion 1:1 categoria y vacante(para poder ver el nombre de la categoria y no solo el numero (id))
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }
    public function salario(){
        return $this->belongsTo(Salario::class);
    }
    public function ubicacion(){
        return $this->belongsTo(Ubicacion::class);
    }
    public function experiencia(){
        return $this->belongsTo(Experiencia::class);
    }

    // Relacion 1:1 y vacante
    public function reclutador()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // Relacion 1:n vacante y candidatos () cuarta forma
    public function candidatos()
    {
        return $this->hasMany(Candidato::class);
    }
    
    
}
