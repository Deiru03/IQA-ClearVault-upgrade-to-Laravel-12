<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'name',
        'description',
        // 'department_id',
        'profile_picture',
        'campus_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
