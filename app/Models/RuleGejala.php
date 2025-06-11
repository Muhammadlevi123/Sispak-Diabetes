<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleGejala extends Model
{
    use HasFactory;

    protected $table = 'rule_gejala';
    public $timestamps = false;

    protected $fillable = ['rule_id', 'gejala_id'];

    // Relasi: Many to One -> Rule
    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    // Relasi: Many to One -> Gejala
    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
}
