<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'mahasiswas';

    protected $fillable = ['npm','nama','tanggal','foto','prodi_id'];

    public function prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }
}