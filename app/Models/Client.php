<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'company',
        'email',
        'phone',
        'location',
        'notes',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function works(): HasMany
    {
        return $this->hasMany(ClientWork::class)->orderByDesc('work_date');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class)->orderByDesc('payment_date');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    public function getReceivedTotalAttribute(): float
    {
        if (array_key_exists('received_total', $this->attributes)) {
            return (float) $this->attributes['received_total'];
        }

        return (float) $this->payments->where('status', 'received')->sum('amount');
    }

    public function getPendingTotalAttribute(): float
    {
        if (array_key_exists('pending_total', $this->attributes)) {
            return (float) $this->attributes['pending_total'];
        }

        return (float) $this->payments->where('status', 'pending')->sum('amount');
    }

    public function getTotalBilledAttribute(): float
    {
        if (array_key_exists('total_billed', $this->attributes)) {
            return (float) $this->attributes['total_billed'];
        }

        return (float) $this->works->where('status', '!=', 'cancelled')->sum('amount');
    }

    public function getBalanceAttribute(): float
    {
        return max(0, $this->total_billed - $this->received_total);
    }

    public function getPendingAmountAttribute(): float
    {
        return $this->balance;
    }

    public function getHasBalanceAttribute(): bool
    {
        return $this->balance > 0;
    }
}
