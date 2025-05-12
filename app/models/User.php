<?php
namespace App\Models;

class User
{
    private $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    public function findByEmail($email)
    {
        return $this->collection->findOne(['email' => $email]);
    }

    public function create(array $data)
    {
        $hash = password_hash($data['senha'], PASSWORD_BCRYPT);
        $this->collection->insertOne([
            'email' => $data['email'],
            'senha' => $hash,
        ]);
    }

    public function authenticate($email, $senha)
    {
        $user = $this->findByEmail($email);
        if ($user && password_verify($senha, $user['senha'])) {
            return $user;
        }
        return null;
    }
}
