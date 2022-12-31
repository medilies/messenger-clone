<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // --------------------------------------------
    // Relations
    // --------------------------------------------

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function otherUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->whereNot('user_id', auth()->id())->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // --------------------------------------------
    // Scopes
    // --------------------------------------------

    public function scopeDirect(Builder|EloquentBuilder $query): void
    {
        $query->where('type', 'direct');
    }
}
