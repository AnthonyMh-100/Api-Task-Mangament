<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

     public function getStatusAttribute($value)
     {
         return TaskStatusEnum::from($value);
     }
 
     public function setStatusAttribute($value)
     {
         $this->attributes['status'] = TaskStatusEnum::from($value)->value; 
     }

    
}
