<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    public const STATUSES = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'done' => 'Done',
        'hold' => 'On Hold',
    ];

    public const PRIORITIES = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
    ];

    public const CATEGORIES = [
        'Audit',
        'GST',
        'Income Tax',
        'Accounting',
        'Bookkeeping',
        'ROC / MCA',
        'TDS',
        'Advisory',
        'Documentation',
        'Other',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'priority',
        'status',
        'due_date',
        'completed_at',
        'is_active',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeStatus($query, ?string $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }

        return $query;
    }

    public function scopePriority($query, ?string $priority)
    {
        if ($priority) {
            return $query->where('priority', $priority);
        }

        return $query;
    }

    public function scopeCategory($query, ?string $category)
    {
        if ($category) {
            return $query->where('category', $category);
        }

        return $query;
    }

    public function scopeDueOn($query, ?string $date)
    {
        if ($date) {
            return $query->whereDate('due_date', $date);
        }

        return $query;
    }

    public function scopeOrdered($query)
    {
        return $query
            ->orderByRaw('due_date IS NULL')
            ->orderBy('due_date')
            ->orderByRaw("CASE priority WHEN 'high' THEN 0 WHEN 'medium' THEN 1 ELSE 2 END")
            ->orderByDesc('id');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::PRIORITIES[$this->priority] ?? ucfirst((string) $this->priority);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'done' => 'green',
            'in_progress' => 'blue',
            'hold' => 'amber',
            default => 'slate',
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'high' => 'red',
            'low' => 'slate',
            default => 'amber',
        };
    }

    public function getIsOverdueAttribute(): bool
    {
        return (bool) (
            $this->due_date
            && $this->status !== 'done'
            && $this->due_date->isPast()
            && ! $this->due_date->isToday()
        );
    }

    public function getDaysRemainingAttribute(): ?int
    {
        if (! $this->due_date) {
            return null;
        }

        return (int) Carbon::today()->diffInDays($this->due_date, false);
    }
}
