<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Diagnosa extends Model
{
    use HasFactory;

    protected $table = 'diagnosa';
    protected $fillable = ['user_id', 'penyakit_id', 'tanggal'];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    // Accessor untuk mendapatkan tanggal dalam timezone Indonesia
    public function getTanggalWibAttribute()
    {
        return $this->tanggal ? $this->tanggal->setTimezone('Asia/Jakarta') : null;
    }

    // Accessor untuk format tanggal yang readable
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal ? $this->tanggal->setTimezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB' : null;
    }

    // Mutator untuk memastikan tanggal disimpan dengan timezone yang benar
    public function setTanggalAttribute($value)
    {
        if ($value) {
            // Jika value sudah Carbon instance
            if ($value instanceof Carbon) {
                $this->attributes['tanggal'] = $value->utc();
            } else {
                // Jika value adalah string, parse dengan timezone Indonesia lalu convert ke UTC
                $this->attributes['tanggal'] = Carbon::parse($value, 'Asia/Jakarta')->utc();
            }
        } else {
            $this->attributes['tanggal'] = null;
        }
    }

    // Boot method untuk mengatur default timezone saat membuat record baru
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->tanggal) {
                $model->tanggal = now('Asia/Jakarta');
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class);
    }

    public function gejalas()
    {
        return $this->belongsToMany(Gejala::class, 'diagnosa_gejala');
    }
}
