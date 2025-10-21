<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DashboardTile extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'parent_dashboard_tile_id',
        'title',
        'sort_order',
    ];

    public function childrenDashboardTiles(): hasMany
    {
        return $this->hasMany(DashboardTile::class, 'parent_dashboard_tile_id');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function parentDashboardTile(): BelongsTo
    {
        return $this->belongsTo(DashboardTile::class, 'parent_dashboard_tile_id');
    }

    public function scopeSearch($query, $search)
    {
        $query->when($search, function () use ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });
    }
}
