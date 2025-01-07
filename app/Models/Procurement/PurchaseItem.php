<?php

namespace App\Models\Procurement;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseItem extends Model
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

            if (empty($model->purchase_id)) {
                $model->purchase_id = static::generateUniquePurchaseId(); // Generate unique 6-digit purchase_id
            }
        });
    }

    /**
     * Generate a unique 6-digit purchase ID starting with "44".
     */
    protected static function generateUniquePurchaseId(): int
    {
        do {
            $randomPurchaseId = (int) ('44' . random_int(1000, 9999)); // Generate ID like 44XXXX
        } while (static::query()->where('purchase_id', $randomPurchaseId)->exists());

        return $randomPurchaseId;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'purchase_id',
        'requisition_id',
        'product_id',
        'quantity',
        'cost',
        'price',
    ];

    /**
     * Relationship: Belongs to purchase requisition.
     */
    public function requisition()
    {
        return $this->belongsTo(PurchaseRequisition::class, 'requisition_id', 'id');
    }

    /**
     * Relationship: Belongs to product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
