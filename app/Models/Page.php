<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Page
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $column_count
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @mixin \Eloquent
 * @package App\Models
 */
class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> $fillable
     */
    protected $fillable = [
        'name',
        'slug',
        'column_count'
    ];

    /**
     * Get the fields for the page.
     *
     * @return HasMany The fields for the page.
     */
    public function fields(): HasMany
    {
        return $this
            ->hasMany(Field::class)
            ->orderBy('subsection_sort_order')
            ->orderBy('sort_order');
    }

    /**
     * Search for pages.
     *
     * @param $query
     * @param $search
     * @return void
     */
    public function scopeSearch($query, $search)
    {
        $query->when($search, function () use ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }
}
