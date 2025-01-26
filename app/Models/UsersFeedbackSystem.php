<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersFeedbackSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'c1_1', 'c1_2', 'c1_3', 'c1_4', 'c1_5',
        'c2_1', 'c2_2', 'c2_3', 'c2_4', 'c2_5',
        'c3_1', 'c3_2', 'c3_3', 'c3_4', 'c3_5',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
