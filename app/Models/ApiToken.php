<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(ApiToken::class,"user_token","token_id","user_id","id","id");
    }
}
