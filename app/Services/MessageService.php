<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;
use Exception;
use Illuminate\Http\Request;

class MessageService
{
    protected readonly array $validated_message;

    protected ?Message $messageModel = null;

    public function __construct(
        Request|array $data,
        protected Conversation $conversation
    ) {
        if ($data instanceof Request) {
            $data = $data->all();
        }

        $this->validated_message = $this->validate($data);
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

        $this->messageModel = $this->conversation->messages()->create($this->validated_message + ['user_id' => auth()->id()]);

        $this->messageModel->setRelation('user', auth()->user());

        return $this;
    }

    protected function getRules(): array
    {
        return [
            'content' => ['required', 'string'],
        ];
    }
}
