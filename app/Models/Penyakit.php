<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakit';

    protected $fillable = ['kode_penyakit', 'nama_penyakit', 'deskripsi', 'solusi'];

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function diagnosas()
    {
        return $this->hasMany(Diagnosa::class);
    }
}

