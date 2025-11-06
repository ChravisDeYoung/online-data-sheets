<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class DashboardTile
 *
 * @property int $id
 * @property int $page_id
 * @property int $parent_dashboard_tile_id
 * @property string $title
 * @property int $sort_order
 * @mixin \Eloquent
 * @package App\Models
 */
class  DashboardTile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> $fillable
     */
    protected $fillable = [
        'page_id',
        'parent_dashboard_tile_id',
        'title',
        'sort_order',
    ];

    /**
     * Get the children dashboard tiles for the dashboard tile.
     *
     * @return HasMany The children dashboard tiles.
     */
    public function childrenDashboardTiles(): hasMany
    {
        return $this->hasMany(DashboardTile::class, 'parent_dashboard_tile_id');
    }

    /**
     * Get the page that owns the dashboard tile.
     *
     * @return BelongsTo The page that owns the dashboard tile.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the parent dashboard tile for the dashboard tile.
     *
     * @return BelongsTo The parent dashboard tile.
     */
    public function parentDashboardTile(): BelongsTo
    {
        return $this->belongsTo(DashboardTile::class, 'parent_dashboard_tile_id');
    }

    /**
     * Search for dashboard tiles.
     *
     * @param $query
     * @param $search
     * @return void
     */
    public function scopeSearch($query, $search): void
    {
        $query->when($search, function () use ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });
    }
}
