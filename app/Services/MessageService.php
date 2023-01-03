<?php

namespace App\Services;

use App\Events\MessageEvent;
use App\Models\Conversation;
use App\Models\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MessageService
{
    protected Collection $validated_message;

    protected ?Message $messageModel = null;

    public function __construct(
        Request|array $data,
        protected Conversation $conversation
    ) {
        if ($data instanceof Request) {
            $data = $data->all();
        }

        $this->validated_message = collect($this->validate($data));
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
        MessageEvent::broadcast($this->messageModel);

        return $this;
    }

    protected function getRules(): array
    {
        return [
            'content' => ['required', 'string'],
        ];
    }
}
