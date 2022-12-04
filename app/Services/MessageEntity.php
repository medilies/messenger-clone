<?php

namespace App\Services;

use App\Events\DirectMessageEvent;
use App\Models\DirectMessage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

    protected function validate(array $data): array
    {
        return validator($data, [
            'content' => ['required', 'string'],
            'target_user_id' => ['integer'],
        ])->validate();
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

    public function broadcast(): static
    {
        DirectMessageEvent::broadcast($this->resource())->toOthers();

        return $this;
    }

    public function resource(): Collection
    {
        if (empty($this->messageModel)) {
            throw new Exception("The message entity isn't stored yet");
        }

        return collect([
            'id' => $this->messageModel->id,
            'content' => $this->messageModel->content,
            'created_at' => $this->messageModel->created_at,
            'user_id' => $this->messageModel->user_id,
            'target_user_id' => $this->messageModel->target_user_id,
            'user' => [
                'id' => $this->messageModel->user->id,
                'name' => $this->messageModel->user->name,
            ],
        ]);
    }
}
