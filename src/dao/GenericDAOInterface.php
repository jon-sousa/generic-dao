<?php

namespace jon\dao\dao;

interface GenericDAOInterface
{
    public function insert($item);
    public function findAll();
    public function findOne($item);
    public function delete($item);
    public function update($item);
}