<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DirectMessage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function scopeWhereCorrespondent(Builder $query, int $target_user_id): void
    {
        $query->where(function ($q) use ($target_user_id) {
            $q->where('user_id', auth()->id())->where('target_user_id', $target_user_id);
        })
            ->orWhere(function ($q) use ($target_user_id) {
                $q->where('user_id', $target_user_id)->where('target_user_id', auth()->id());
            });
    }
}
