<?php
namespace App\Repositories;

use App\Models\Anotation;
use PDO;

class AnotationRepository {
    public function __construct(private PDO $pdo){}

    public function all(): array {
    $st = $this->pdo->query("
        SELECT 
            a.id, 
            a.texto, 
            a.created_at, 
            a.user_id, 
            u.name AS user_nome
        FROM anotacoes a
        LEFT JOIN user u ON a.user_id = u.id
        ORDER BY a.id DESC
    ");

    return array_map(fn($r) => (object)[
        'id' => (int)$r['id'],
        'texto' => (string)$r['texto'],
        'user_id' => (int)$r['user_id'],
        'created_at' => $r['created_at'],
        'user_nome' => $r['user_nome'] ?? 'Desconhecido'
    ], $st->fetchAll(\PDO::FETCH_ASSOC));
}


    public function find(int $id): ?Anotation {
        $st = $this->pdo->prepare("SELECT id,texto,created_at,user_id FROM `anotacoes` WHERE id=?");
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ? new Anotation(
            (int)$r['id'],
            (string)$r['texto'],
            (int)$r['user_id'],
            $r['created_at']
        ) : null;
    }

    public function findByUserId(int $userId): array {
        $st = $this->pdo->prepare("SELECT id,texto,created_at,user_id FROM `anotacoes` WHERE user_id=? ORDER BY id DESC");
        $st->execute([$userId]);
        return array_map(fn($r) => new Anotation(
            (int)$r['id'],
            (string)$r['texto'],
            (int)$r['user_id'],
            $r['created_at']
        ), $st->fetchAll());
    }

    public function create(Anotation $a): int {
        $st = $this->pdo->prepare("INSERT INTO `anotacoes` (texto,user_id) VALUES (?,?)");
        $st->execute([$a->texto,$a->user_id]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(Anotation $a): void {
        $st = $this->pdo->prepare("UPDATE `anotacoes` SET texto=?, user_id=? WHERE id=?");
        $st->execute([$a->texto,$a->user_id,$a->id]);
    }

    public function delete(int $id): void {
        $st = $this->pdo->prepare("DELETE FROM `anotacoes` WHERE id=?");
        $st->execute([$id]);
    }
}
