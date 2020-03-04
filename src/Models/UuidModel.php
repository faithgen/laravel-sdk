<?php


namespace FaithGen\SDK\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UuidModel extends Model
{
    public $incrementing = false;
    protected $guarded = [
        'id'
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            $user->id = str_shuffle((string) Str::uuid());
        });
    }
}
