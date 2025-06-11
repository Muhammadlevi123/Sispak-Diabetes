<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosaGejala extends Model
{
    use HasFactory;

    protected $table = 'diagnosa_gejala';
    public $timestamps = false;

    protected $fillable = ['diagnosa_id', 'gejala_id'];

    // Relasi: Many to One -> Diagnosa
    public function diagnosa()
    {
        return $this->belongsTo(Diagnosa::class);
    }

    // Relasi: Many to One -> Gejala
    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
}
