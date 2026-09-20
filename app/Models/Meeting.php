<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    use HasFactory;

    public const TYPES = [
        'in_person' => 'In Person',
        'online' => 'Online',
        'phone' => 'Phone',
    ];

    public const STATUSES = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    protected $fillable = [
        'user_id',
        'client_id',
        'name',
        'email',
        'phone',
        'title',
        'meeting_date',
        'start_time',
        'end_time',
        'type',
        'location',
        'status',
        'notes',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst((string) $this->type);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('meeting_date')->orderBy('start_time');
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->whereDate('meeting_date', '>=', today())
            ->whereNotIn('status', ['cancelled', 'completed']);
    }
}
