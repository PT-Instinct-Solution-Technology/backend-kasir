<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeliMenu extends Model
{
    use HasFactory;
    protected $fillable = ['jumlah_beli', 'menu_id'];
}
