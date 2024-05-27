<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationPhoto extends Model
{
    use HasFactory;

    public function Publication()
    {
        return $this->belongsTo(Publication::class);
    }
}
