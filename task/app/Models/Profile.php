<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Profile extends Model
{
    protected $table = 'profiles';
    // protected $guarded = [];
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'dob',
        'bio',
        'img_profile'
    ];
public function user()
{
    return $this->belongsTo(User::class);
}

}
