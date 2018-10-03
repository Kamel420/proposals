<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Proposal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'value', 'user_id',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class); 
    }
}
