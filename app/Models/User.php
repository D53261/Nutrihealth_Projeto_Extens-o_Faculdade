<?php
namespace App\Models;
class User {
    public ?int $id;
    public string $name;
    public string $email;
    public string $passwordHash; // armazena hash na coluna `password`
    public string $typeUser;     // A, N, U
    public function __construct(?int $id,string $name,string $email,string $passwordHash,string $typeUser='U'){
        $this->id=$id; $this->name=$name; $this->email=$email; $this->passwordHash=$passwordHash; $this->typeUser=$typeUser;
    }
    public static function fromArray(array $d): self {
        return new self($d['id']??null,$d['name'],$d['email'],$d['password']??($d['passwordHash']??''),$d['typeUser']??'U');
    }
}
