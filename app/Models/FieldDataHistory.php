<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldDataHistory extends Model
{
    use HasFactory;

    protected $fillable = ['field_data_id', 'old_value', 'new_value'];
}
