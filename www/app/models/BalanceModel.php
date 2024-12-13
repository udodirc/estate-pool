<?php
namespace app\models;

use core\Model;

class BalanceModel extends Model
{
    public string $tableName = 'balances';

    public function checkBalance(int $id): bool
    {
        $query = "SELECT `id`
        FROM `".$this->tableName."`
        WHERE `id`=".$id;
        $result = $this->fetchOne($query);

        return (bool)$result;
    }
}