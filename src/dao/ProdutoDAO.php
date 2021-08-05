<?php

namespace jon\dao\dao;

use jon\dao\models\Produto;
use jon\dao\dao\GenericDAOInterface;

class ProdutoDAO implements GenericDAOInterface
{
    private \PDO $pdo;

    public function __construct(){
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

    public function insert($produto){
        $ps = $this->pdo->prepare('insert into produtos(nome, valor) values (:nome, :valor)');
        return $ps->execute([
            ':nome' => $produto->getNome(),
            ':valor' => $produto->getValor()
        ]);
    }

    public function findAll(){
        $ps = $this->pdo->prepare('select * from produtos');
        $ps->execute();
        return $ps->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findOne($id){
        $ps = $this->pdo->prepare('select * from produtos where id = :id');
        $ps->execute([
            ':id' => $id
        ]);
        $produtoArray =  $ps->fetch(\PDO::FETCH_ASSOC);

        $produto = new Produto(
            $produtoArray['nome'],
            $produtoArray['valor']
        );
        $produto->setId($produtoArray['id']);
        return $produto;
    } 

    public function delete($id){
        $ps = $this->pdo->prepare('delete from produtos where id = :id');
        return $ps->execute([
            ':id' => $id
        ]);
    }

    public function update($produto){
        $ps = $this->pdo->prepare('update produtos set nome = :nome, valor = :valor where id = :id');
        return $ps->execute([
            ':nome' => $produto->getNome(),
            ':valor' => $produto->getValor(),
            ':id' => $produto->getId(),
        ]);
    } 
}