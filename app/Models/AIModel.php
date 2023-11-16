<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AIModel extends Model
{
    use HasFactory;
    protected $table = 'ai_models';

    protected $fillable = [
        'name',
        'input',
        'output',
        'price',
        'params',
        'description'
    ];
}
