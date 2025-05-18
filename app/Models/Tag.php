<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',    // Stores the tag name with # (e.g., "#nature")
        'slug'     // URL-friendly version without # (e.g., "nature")
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically generate slug when creating tag
        static::creating(function ($tag) {
            // Ensure name starts with #
            $tag->name = '#' . ltrim($tag->name, '#');
            // Generate slug without #
            $tag->slug = Str::slug(str_replace('#', '', $tag->name));
        });

        static::updating(function ($tag) {
            // Keep name consistent with #
            $tag->name = '#' . ltrim($tag->name, '#');
            // Update slug without #
            $tag->slug = Str::slug(str_replace('#', '', $tag->name));
        });
    }

    /**
     * Relationship: Tags belong to many Posts
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Create tags from hashtag string while preserving #
     */
    public static function createFromHashtags(string $hashtags)
    {
        // Match all hashtags including adjacent ones like #cool#nature
        preg_match_all('/#\w+/', $hashtags, $matches);

        return collect($matches[0] ?? [])
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->unique()
            ->map(function ($hashtag) {
                return static::firstOrCreate([
                    'name' => strtolower($hashtag)
                ], [
                    'slug' => Str::slug(str_replace('#', '', $hashtag))
                ]);
            });
    }

    /**
     * Get the display name (with #)
     */
    public function getDisplayNameAttribute()
    {
        return $this->name;
    }

    /**
     * Get the searchable name (without #)
     */
    public function getSearchableNameAttribute()
    {
        return str_replace('#', '', $this->name);
    }
}
