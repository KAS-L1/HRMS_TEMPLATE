<?php

namespace App\Models\Procurement;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestQuotation extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Use the UUID column as the primary key
    public $incrementing = false; // Disable auto-incrementing for the primary key
    protected $keyType = 'string'; // Indicate the primary key is a string (UUID)

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Generate UUID for primary key
            }

            if (empty($model->rfq_id)) {
                $model->rfq_id = static::generateUniqueRfqId(); // Generate unique 6-digit rfq_id
            }
        });
    }

    /**
     * Generate a unique 6-digit RFQ ID starting with "66".
     */
    protected static function generateUniqueRfqId(): int
    {
        do {
            $randomRfqId = (int) ('66' . random_int(1000, 9999)); // Generate ID like 66XXXX
        } while (static::query()->where('rfq_id', $randomRfqId)->exists());

        return $randomRfqId;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'rfq_id',
        'product_id',
        'vendor_id',
        'requested_qty',
        'status',
        'response_date',
        'remarks',
    ];

    /**
     * Relationships
     */

    // Relationship: Belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // Relationship: Belongs to a vendor
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }
}
