<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonModel extends Model
{
    protected $table = 'person';

    protected $fillable = [
        'fullname',
        'lastname',
        'dni',
        'city',
        'phone',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
