<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class İletisim extends Model
{
    use HasFactory;
    protected $table='iletisim';
    protected $fillable=['ad_soyad','email','yves','updated_at','created_at'];
}
