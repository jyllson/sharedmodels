<?php

namespace Lundash\SharedModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandTheme extends Model
{
    use HasFactory, SoftDeletes;

	protected $table = 'brand_themes';

    protected $fillable = [
        'name',
        'brand_id',
        'logo',
        'favicon',
        'font',
        'font2',
        'font3',
        'colorBD', 
        'colorBL',
        'colorBR',
        'colorBRD',
        'colorBRL',
        'colorBRR',
        'colorTD',
        'colorTL', 
        'colorTR',
        'colorTRD',
        'colorTRL',
        'colorTRR',
        'color2A',
        'color2D',
        'color2L',
        'color2R',
        'color3A',
        'color3D',
        'color3L',
        'color3R',
        'enabled'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
