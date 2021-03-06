<?php

namespace FaithGen\SDK\Models;

use FaithGen\SDK\Models\Ministry\Account;
use FaithGen\SDK\Models\Ministry\Activation;
use FaithGen\SDK\Models\Ministry\APIKey;
use FaithGen\SDK\Models\Ministry\DailyService;
use FaithGen\SDK\Models\Ministry\Profile;
use FaithGen\SDK\Models\Ministry\Review;
use FaithGen\SDK\Traits\Relationships\Has\ManyMinistryUsers;
use FaithGen\SDK\Traits\Relationships\Morphs\CreatableTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\ImageableTrait;
use FaithGen\SDK\Traits\StorageTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Ministry extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use ImageableTrait;
    use StorageTrait;
    use ManyMinistryUsers;
    use CreatableTrait;

    protected $table = 'fg_ministries';
    protected $guarded = ['id'];
    public $incrementing = false;
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    public const ACCOUNT_LEVELS = ['Free', 'Premium', 'PremiumPlus'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * MODEL ATTRIBUTES.
     */
    public function getNameAttribute($val)
    {
        return ucwords($val);
    }

    /**
     * Links the profile to a ministry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    /**
     * MODEL RELATIONSHIPS.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Links the account to the ministry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account()
    {
        return $this->hasOne(Account::class);
    }

    /**
     * Links the activation to this ministry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activation()
    {
        return $this->hasOne(Activation::class);
    }

    public function apiKey()
    {
        return $this->hasOne(APIKey::class);
    }

    public function services()
    {
        return $this->hasMany(DailyService::class);
    }

    public function getPhonesAttribute()
    {
        if ($this->profile->phones) {
            $phones = $this->profile->phones;
            array_unshift($phones, $this->phone);

            return $phones;
        } else {
            return [$this->phone];
        }
    }

    public function getEmailsAttribute()
    {
        if ($this->profile->emails) {
            $emails = $this->profile->emails;
            array_unshift($emails, $this->email);

            return $emails;
        } else {
            return [$this->email];
        }
    }

    /**
     * The name of the directory in storage that has files for this model.
     *
     * @return mixed
     */
    public function filesDir()
    {
        return 'profile';
    }

    /**
     * The file name fo this model.
     *
     * @return mixed
     */
    public function getFileName()
    {
        return $this->image->name;
    }

    public function getUsersAttribute()
    {
        return $this->ministryUsers()
            ->map(fn ($minUser) => $minUser->user)
            ->flatten();
    }
}
