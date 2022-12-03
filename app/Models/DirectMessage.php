<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhereCorrespondent(Builder $query, int $target_user_id)
    {
        $query->where(function ($q) use ($target_user_id) {
            $q->where('user_id', auth()->id())->where('target_user_id', $target_user_id);
        })
            ->orWhere(function ($q) use ($target_user_id) {
                $q->where('user_id', $target_user_id)->where('target_user_id', auth()->id());
            });
    }
}
