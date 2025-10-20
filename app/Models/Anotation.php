<?php
namespace App\Models;

class Anotation {
    public ?int $id;
    public string $texto;
    public ?string $created_at;
    public int $user_id;

    public function __construct(?int $id, string $texto, int $user_id, ?string $created_at = null) {
        $this->id = $id;
        $this->texto = $texto;
        $this->user_id = $user_id;
        $this->created_at = $created_at;
    }

    public static function fromArray(array $data): self {
        $id = isset($data['id']) && $data['id'] !== '' ? (int)$data['id'] : null;
        $texto = isset($data['texto']) ? (string)$data['texto'] : (isset($data['text']) ? (string)$data['text'] : '');
        if (isset($data['user_id'])) {
            $user_id = (int)$data['user_id'];
        } elseif (isset($data['userId'])) {
            $user_id = (int)$data['userId'];
        } else {
            throw new \InvalidArgumentException('user_id é obrigatório para criar Anotation');
        }
        $created_at = isset($data['created_at']) ? (string)$data['created_at'] : (isset($data['createdAt']) ? (string)$data['createdAt'] : null);

        return new self($id, $texto, $user_id, $created_at);
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'texto' => $this->texto,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ];
    }
}