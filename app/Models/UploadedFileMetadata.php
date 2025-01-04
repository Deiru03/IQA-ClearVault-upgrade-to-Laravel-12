<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UploadedFileMetadata extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shared_clearance_id',
        'requirement_id',
        'file_name',
        'file_content'
];
   
}
