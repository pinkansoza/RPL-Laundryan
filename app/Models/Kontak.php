<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;

    protected $table = 'kontaks';

    protected $fillable = [
        'tiktok',
        'whatsapp',
        'instagram',
        'jam_operasional',
        'url_gmaps',
        'jam_pickup',
    ];

    protected $casts = [
        'jam_pickup' => 'array',
    ];
}