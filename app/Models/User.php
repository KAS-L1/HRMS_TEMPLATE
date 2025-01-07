<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Procurement\PurchaseRequisition;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, HasApiTokens;

    public $incrementing = false; // Disable auto-incrementing for the primary key
    protected $keyType = 'string'; // Indicate the primary key is a string (UUID)

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Generate UUID for primary key
            }

            if (empty($model->user_id)) {
                $model->user_id = static::generateUniqueUserId(); // Generate unique 6-digit user_id
            }
        });
    }

    /**
     * Perform pre-authorization checks on the model.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return null; // see the note above in Gate::before about why null must be returned here.
    }

    /**
     * Generate a unique 6-digit user ID starting at 11XXXX.
     */
    protected static function generateUniqueUserId(): int
    {
        do {
            // Generate a 6-digit number starting with "11" followed by 4 random digits
            $randomUserId = (int) ('11' . random_int(1000, 9999));
        } while (static::query()->where('user_id', $randomUserId)->exists()); // Ensure uniqueness

        return $randomUserId;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'address',
        'contact',
        'profile_picture',
        'status',
        'company',
    ];

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
     * Accessor to get the full name of the user.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Relationship: Vendor's purchase requisitions.
     */
    public function purchaseRequisitions()
    {
        return $this->hasMany(PurchaseRequisition::class, 'vendor_id');
    }

    /**
     * Relationship: Requisitions created by this user.
     */
    public function createdRequisitions()
    {
        return $this->hasMany(PurchaseRequisition::class, 'created_by');
    }
}
