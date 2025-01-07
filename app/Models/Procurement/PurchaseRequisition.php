<?php

namespace App\Models\Procurement;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseRequisition extends Model
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

            if (empty($model->requisition_id)) {
                $model->requisition_id = static::generateUniqueRequisitionId(); // Generate unique 6-digit requisition_id
            }
        });
    }

    /**
     * Generate a unique 6-digit requisition ID starting with "33".
     */
    protected static function generateUniqueRequisitionId(): int
    {
        do {
            $randomRequisitionId = (int) ('33' . random_int(1000, 9999)); // Generate ID like 33XXXX
        } while (static::query()->where('requisition_id', $randomRequisitionId)->exists());

        return $randomRequisitionId;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'requisition_id',
        'vendor_id',
        'created_by',
        'total_quantity',
        'total_cost',
        'total_price',
        'priority',
        'request_date',
        'status',
    ];

    /**
     * Relationships
     */

    // Relationship: Belongs to a vendor
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }

    // Relationship: Has many purchase items
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, 'requisition_id', 'id');
    }

    // Relationship: Has one budget approval
    public function budgetApproval()
    {
        return $this->hasOne(BudgetApproval::class, 'requisition_id', 'id');
    }

    // Relationship: Belongs to the creator (user who created this requisition)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
