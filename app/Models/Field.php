<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Field extends Model
{
    use HasFactory;

    public const TYPE_TEXT = 0;
    public const TYPE_NUMBER = 1;
    public const TYPE_DATE = 2;
    public const TYPE_SELECT = 3;
    public const TYPE_CHECKBOX = 4;
    public const TYPE_TEXTAREA = 5;

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

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
