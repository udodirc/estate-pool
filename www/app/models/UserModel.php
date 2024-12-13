<?php
namespace app\models;

use core\Model;

class UserModel extends Model
{
    public string $tableName = 'users';

    public function checkUser(int $id): bool
    {
        $query = "SELECT `id`
        FROM `".$this->tableName."`
        WHERE `id`=".$id;
        $result = $this->fetchOne($query);

        return (bool)$result;
    }
}