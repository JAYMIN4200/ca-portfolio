<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function replies(): HasMany
    {
        return $this->hasMany(MessageReply::class)->orderBy('created_at');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('created_at');
    }
}
