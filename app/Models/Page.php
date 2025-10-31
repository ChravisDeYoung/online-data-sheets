<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Page
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

    protected $fillable = [
        'name',
        'slug',
        'column_count'
    ];

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function scopeSearch($query, $search)
    {
        $query->when($search, function () use ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }
}
