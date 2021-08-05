<?php

namespace jon\dao\dao;

use jon\dao\models\Usuario;
use jon\dao\dao\GenericDAOInterface;

class UsuarioDAO implements GenericDAOInterface
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = $this->connect();
    }

    private function connect()
    {
        return new \PDO(
            'sqlite:' . __DIR__ . DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db.sqlite3', 
            null, 
            null, 
            [
                \PDO::ATTR_PERSISTENT => true
            ]
        );
    }

    public function insert($usuario){
        $ps = $this->pdo->prepare('insert into usuarios(nome, cpf) values (:nome, :cpf)');
        return $ps->execute([
            ':nome' => $usuario->getNome(),
            ':cpf' => $usuario->getCpf()
        ]);
    }

    public function findAll(){
        $ps = $this->pdo->prepare('select * from usuarios');
        $ps->execute();
        return $ps->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findOne($cpf){
        $ps = $this->pdo->prepare('select * from usuarios where cpf = :cpf');
        $ps->execute([
            ':cpf' => $cpf
        ]);
        $usuarioArray = $ps->fetch(\PDO::FETCH_ASSOC);

        $usuario = new Usuario($usuarioArray['nome'], $usuarioArray['cpf']);

        return $usuario;
    } 

    public function delete($cpf){
        $ps = $this->pdo->prepare('delete from usuarios where cpf = :cpf');
        return $ps->execute([
            ':cpf' => $cpf
        ]);
    }

    public function update($usuario){
        $ps = $this->pdo->prepare('update usuarios set nome = :nome where cpf = :cpf');
        return $ps->execute([
            ':nome' => $usuario->getNome(),
            ':cpf' => $usuario->getCpf()
        ]);
    } 
}