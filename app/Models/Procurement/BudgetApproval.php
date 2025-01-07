<?php

namespace App\Models\Procurement;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetApproval extends Model
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

            if (empty($model->approval_id)) {
                $model->approval_id = static::generateUniqueApprovalId(); // Generate unique 6-digit approval_id
            }
        });
    }

    /**
     * Generate a unique 6-digit approval ID starting with "55".
     */
    protected static function generateUniqueApprovalId(): int
    {
        do {
            $randomApprovalId = (int) ('55' . random_int(1000, 9999)); // Generate ID like 55XXXX
        } while (static::query()->where('approval_id', $randomApprovalId)->exists());

        return $randomApprovalId;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'approval_id',
        'requisition_id',
        'amount',
        'status',
        'approved_by',
        'approval_date',
        'remarks',
    ];

    /**
     * Relationship: Belongs to a Purchase Requisition.
     */
    public function requisition()
    {
        return $this->belongsTo(PurchaseRequisition::class, 'requisition_id', 'id');
    }
}
