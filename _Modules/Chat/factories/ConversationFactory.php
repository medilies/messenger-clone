<?php

namespace _Modules\Chat\Factories;

use _Modules\Chat\Models\Conversation;
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
