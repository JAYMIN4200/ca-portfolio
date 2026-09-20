<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'travel' => 'Travel & Conveyance',
        'office' => 'Office & Infrastructure',
        'software' => 'Software & Tools',
        'salary' => 'Salary & Professional Fees',
        'marketing' => 'Marketing & Ads',
        'utilities' => 'Utilities & Bills',
        'professional' => 'Institute / Membership',
        'other' => 'Other',
    ];

    protected $fillable = [
        'client_id',
        'category',
        'custom_category',
        'description',
        'amount',
        'expense_date',
        'method',
        'reference',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        if ($this->category === 'other' && filled($this->custom_category)) {
            return (string) $this->custom_category;
        }

        return self::CATEGORIES[$this->category] ?? ucfirst((string) $this->category);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('expense_date')->orderByDesc('id');
    }
}