<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldData extends Model
{
    use HasFactory;

    protected $fillable = [
        'column',
        'field_id',
        'value',
        'page_date'
    ];

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function getIsOutOfRangeAttribute(): bool
    {
        if (is_null($this->value)) {
            return false;
        }

        $this->load('field');

        if (!is_null($this->field->minimum) && !is_null($this->field->maximum)
            && ($this->value < $this->field->minimum || $this->value > $this->field->maximum)) {
            return true;
        }

        if (!is_null($this->field->minimum) && $this->value < $this->field->minimum) {
            return true;
        }

        if (!is_null($this->field->maximum) && $this->value > $this->field->maximum) {
            return true;
        }

        return false;
    }
}
