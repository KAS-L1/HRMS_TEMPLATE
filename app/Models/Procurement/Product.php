<?php

namespace App\Models\Procurement;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
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

            if (empty($model->product_id)) {
                $model->product_id = static::generateUniqueProductId(); // Generate unique 6-digit product_id
            }
        });
    }

    /**
     * Generate a unique 6-digit product ID starting with "22".
     */
    protected static function generateUniqueProductId(): int
    {
        do {
            $randomProductId = (int) ('22' . random_int(1000, 9999)); // Generate ID like 22XXXX
        } while (static::query()->where('product_id', $randomProductId)->exists());

        return $randomProductId;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'product_id',
        'name',
        'description',
        'image',
        'status',
        'unit_price',
        'stock',
    ];

    /**
     * Relationship: Has many purchase items.
     */
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, 'product_id', 'id');
    }

    /**
     * Relationship: Has many request quotations.
     */
    public function requestQuotations()
    {
        return $this->hasMany(RequestQuotation::class, 'product_id', 'id');
    }
}
