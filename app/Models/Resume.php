<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Resume extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
