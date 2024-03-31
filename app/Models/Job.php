<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Job extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public $table = "vacancies";

    public $guarded = [];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function logo()
    {
        return $this->company()->firstMediaUrl('company-logo');
    }

    // public function salaryFrom() : Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => "Rs. ".$value.".00",
    //     );
    // }

    // public function salaryTo() : Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => "Rs. ".$value.".00",
    //     );
    // }
}
