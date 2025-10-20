<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardTile extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'parent_dashboard_tile_id',
        'title',
        'sort_order',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
