<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Role
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @mixin \Eloquent
 * @package App\Models
 * @method static create(string[] $array)
 */
class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> $fillable
     */
    protected $fillable = [
        'name',
        'description'
    ];

    #region Relationships

    /**
     * Get the roles.
     *
     * @return BelongsToMany The roles.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    #endregion
}
