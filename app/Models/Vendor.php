<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Vendor extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [ 'vendor_code', 'business_name', 'first_name', 'last_name', 'mobile', 'image', 'license_image', 'address', 'city', 'email', 'password', 'verification_code', 'email_verified', 'admin_approved', 'status', 'account_type', 'device_id' ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id', 'id');
    }

    public function makes()
    {
        return $this->belongsToMany(Make::class, 'products', 'vendor_id', 'make_id');
    }

}
