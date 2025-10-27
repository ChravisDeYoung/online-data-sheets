<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Field extends Model
{
    use HasFactory;

    public const TYPE_TEXT = 1;
    public const TYPE_NUMBER = 2;
    public const TYPE_DATE = 3;
    public const TYPE_SELECT = 4;
    public const TYPE_CHECKBOX = 5;
    public const TYPE_TEXTAREA = 6;

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

    protected $with = ['page'];

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

    public function fieldData(): HasOne
    {
        return $this->hasOne(FieldData::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

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


    public function getRequiredColumnsArrayAttribute()
    {
        return $this->required_columns
            ? explode(',', $this->required_columns)
            : [];
    }
}
