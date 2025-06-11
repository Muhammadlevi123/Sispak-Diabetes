<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $table = 'gejala';
    protected $fillable = ['kode_gejala', 'nama_gejala'];

    public function rules()
    {
        return $this->belongsToMany(Rule::class, 'rule_gejala');
    }

    public function diagnosas()
    {
        return $this->belongsToMany(Diagnosa::class, 'diagnosa_gejala');
    }
}
