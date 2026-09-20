<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'professional_title',
        'short_intro',
        'about_me',
        'career_objective',
        'years_of_experience',
        'clients_count',
        'profile_photo',
        'resume_path',
        'phone',
        'location',
        'linkedin_username',
        'instagram_url',
        'facebook_url',
        'twitter_url',
        'telegram_url',
        'github_url',
        'whatsapp_number',
        'social_links',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_image',
    ];

    protected $casts = [
        'social_links' => 'array',
        'years_of_experience' => 'integer',
        'clients_count' => 'integer',
    ];

    public function getYearsLabelAttribute(): string
    {
        $years = $this->years_of_experience;

        if ($years === null) {
            return '—';
        }

        return $years.'+';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->profile_photo) {
            return null;
        }

        return asset('storage/'.$this->profile_photo);
    }

    public function getResumeUrlAttribute(): ?string
    {
        if (! $this->resume_path) {
            return null;
        }

        return asset('storage/'.$this->resume_path);
    }

    public function socialHandles(): array
    {
        return array_filter([
            'instagram' => $this->instagram_url,
            'facebook' => $this->facebook_url,
            'twitter' => $this->twitter_url,
            'telegram' => $this->telegram_url,
            'linkedin' => $this->linkedin_username ? "https://www.linkedin.com/in/{$this->linkedin_username}" : null,
            'github' => $this->github_url,
            'whatsapp' => $this->whatsapp_number ? 'https://wa.me/'.preg_replace('/[^0-9]/', '', $this->whatsapp_number) : null,
        ]);
    }
}
