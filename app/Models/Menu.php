<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['nama_menu','deskripsi_menu','harga_menu','gambar_menu', 'jenis_menu'];
}
