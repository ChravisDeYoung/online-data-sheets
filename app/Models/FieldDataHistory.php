<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/***
 * Class FieldDataHistory
 *
 * @property int $field_data_id
 * @property string $old_value
 * @property string $new_value
 * @property int $user_id
 * @mixin \Eloquent
 * @package App\Models
 */
class FieldDataHistory extends Model
{
    use HasFactory;

    protected $fillable = ['field_data_id', 'old_value', 'new_value', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
