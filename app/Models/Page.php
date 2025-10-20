<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
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
