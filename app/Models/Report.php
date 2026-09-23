<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_teknisi',
        'tanggal_kegiatan',
        'kategori',
        'asal_teknisi',
        'lokasi',
        'isi_laporan',
        'status',
        'deskripsi_kendala',
        'foto',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}