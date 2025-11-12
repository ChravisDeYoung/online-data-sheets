<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class FieldData
 *
 * @property int $id
 * @property string $column
 * @property int $field_id
 * @property string $value
 * @property string $page_date
 * @mixin \Eloquent
 * @package App\Models
 */
class FieldData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> $fillable
     */
    protected $fillable = [
        'column',
        'field_id',
        'value',
        'page_date'
    ];

    /**
     * Get the field that owns the field data.
     *
     * @return BelongsTo The field.
     */
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * Get the field data histories.
     *
     * @return HasMany The field data.
     */
    public function fieldDataHistories(): HasMany
    {
        return $this->hasMany(FieldDataHistory::class);
    }

    /**
     * Get the value of the field data as a boolean.
     *
     * @return bool Whether the value is out of range.
     */
    public function getIsOutOfRangeAttribute(): bool
    {
        if (is_null($this->value)) {
            return false;
        }

        $this->load('field');

        if ((!is_null($this->field->minimum)
                && !is_null($this->field->maximum)
                && ($this->value < $this->field->minimum || $this->value > $this->field->maximum))
            // only the minimum is set
            || (!is_null($this->field->minimum)
                && $this->value < $this->field->minimum)
            // only the maximum is set
            || (!is_null($this->field->maximum)
                && $this->value > $this->field->maximum)) {
            return true;
        }

        return false;
    }
}
