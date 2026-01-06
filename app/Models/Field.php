<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Field
 *
 * @property int $id
 * @property int $page_id
 * @property string $name
 * @property int $type
 * @property string $subsection
 * @property int $subsection_sort_order
 * @property int $sort_order
 * @property string $minimum
 * @property string $maximum
 * @property string $select_options
 * @property string $required_columns
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @mixin \Eloquent
 * @package App\Models
 */
class Field extends Model
{
    use HasFactory;

    /**
     * Field types
     */
    public const TYPE_TEXT = 1;
    public const TYPE_NUMBER = 2;
    public const TYPE_DATE = 3;
    public const TYPE_SELECT = 4;
    public const TYPE_CHECKBOX = 5;
    public const TYPE_TEXTAREA = 6;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> $fillable
     */
    protected $fillable = [
        'page_id',
        'name',
        'type',
        'subsection',
        'subsection_sort_order',
        'sort_order',
        'minimum',
        'maximum',
        'select_options',
        'required_columns'
    ];

    /**
     * Get the types of fields.
     * @return string[] The types of fields.
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_TEXT => 'Text',
            self::TYPE_NUMBER => 'Number',
            self::TYPE_DATE => 'Date',
            self::TYPE_SELECT => 'Select',
            self::TYPE_CHECKBOX => 'Checkbox',
            self::TYPE_TEXTAREA => 'Textarea',
        ];
    }

    #region Accessors

    /**
     * Get the required columns as an array.
     *
     * @return string[] The required columns as an array.
     */
    public function getRequiredColumnsArrayAttribute(): array
    {
        return $this->required_columns
            ? explode(',', $this->required_columns)
            : [];
    }
    #endregion

    #region Query Scopes
    /**
     * Search for fields.
     *
     * @param $query
     * @param $search
     * @return void
     */
    public function scopeSearch($query, $search)
    {
        $query->when($search, function () use ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('subsection', 'like', '%' . $search . '%')
                ->orWhereHas('page', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        });
    }
    #endregion

    #region Relationships
    /**
     * Get the field data.
     *
     * @return HasMany The field data.
     */
    public function fieldData(): HasMany
    {
        return $this->hasMany(FieldData::class);
    }

    /**
     * Get the page that owns the field.
     *
     * @return BelongsTo The page that owns the field.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the users subscribed to the field.
     *
     * @return BelongsToMany
     */
    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'field_subscriber', 'field_id', 'user_id');
    }
    #endregion
}
