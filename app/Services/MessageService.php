<?php

namespace App\Services;

use App\Models\DirectMessage;
use Exception;
use Illuminate\Http\Request;

class MessageService
{
    protected array $message;

    protected ?DirectMessage $messageModel = null;

    public function __construct(Request|array $data)
    {
        if ($data instanceof Request) {
            $data = $data->all();
        }

        $this->message = $this->validate($data);
    }

    public function getMessageModel(): DirectMessage
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

        $this->messageModel = DirectMessage::create($this->message + ['user_id' => auth()->id()]);

        $this->messageModel->setRelation('user', auth()->user());

        return $this;
    }

    protected function getRules(): array
    {
        return [
            'content' => ['required', 'string'],
            'target_user_id' => ['integer'],
        ];
    }
}
