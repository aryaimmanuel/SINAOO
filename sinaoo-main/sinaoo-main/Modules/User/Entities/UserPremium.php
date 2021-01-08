<?php

namespace Modules\User\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPremium extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "user_premia";

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
