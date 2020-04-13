<?php

namespace FaithGen\SDK\Models;

use FaithGen\SDK\Traits\ExcludesColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UuidModel extends Model
{
    use ExcludesColumns;

    public $incrementing = false;
    protected $guarded = [
        'id',
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            $user->id = str_shuffle((string) Str::uuid());
        });
    }
}
