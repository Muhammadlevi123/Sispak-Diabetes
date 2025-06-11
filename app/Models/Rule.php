<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'rules';
    protected $primaryKey = 'id';
    protected $fillable = ['kode_rule', 'penyakit_id', 'keterangan'];

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class);
    }

    public function gejala()
    {
        return $this->belongsToMany(Gejala::class, 'rule_gejala');
    }
}

