<?php

namespace App\Modules\Chat\Factories;

use App\Modules\Chat\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    protected $model = Conversation::class;

    /**
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [];
    }
}
