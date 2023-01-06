<?php

namespace _Modules\Chat\Services;

use _Modules\Chat\Events\NewMessageEvent;
use _Modules\Chat\Models\Conversation;
use _Modules\Chat\Models\Message;
use _Modules\Chat\Resources\NewMessageResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NewMessageService
{
    protected Collection $validated_message;

    protected ?Message $messageModel = null;

    protected Conversation $conversation;

    public function consume(Request|array $data, Conversation $conversation): array
    {
        $this->conversation = $conversation;

        $this->validated_message = collect($this->validate(
            $data instanceof Request ? $data->all() : $data
        ));

        // ==================

        return $this
            ->store()
            ->broadcast()
            ->getResource();
    }

    public function getMessageModel(): Message
    {
        return $this->messageModel;
    }

    public function validate(array $data): array
    {
        return validator($data, $this->getRules())->validate();
    }

    public function store(): static
    {
        if ($this->messageModel) {
            throw new Exception('The message entity is already stored');
        }

        $this->messageModel = $this->conversation->messages()->create(
            $this->validated_message->only('content')->toArray()
                + ['user_id' => auth()->id()]
        );

        $this->messageModel->load('user');
        $this->messageModel->load('conversation.otherUsers');

        $this->messageModel->conversation->touch();

        return $this;
    }

    public function broadcast(): static
    {
        NewMessageEvent::broadcast($this->getResource());

        return $this;
    }

    protected function getRules(): array
    {
        return [
            'content' => ['required', 'string'],
        ];
    }

    public function getResource()
    {
        return json_decode((new NewMessageResource($this->messageModel))->toJson(), true);
    }
}
