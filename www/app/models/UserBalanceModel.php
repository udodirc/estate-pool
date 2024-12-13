<?php
namespace app\models;

use core\Model;

class UserBalanceModel extends Model
{
    public string $tableName = 'users_balances';

    public function saveBalance(array $data): bool
    {
        $balance = $this->checkUserBalance($data['data']);

        if($balance)
        {
            $params['sum'] = $data['data']['sum'];
            $query = "UPDATE `".$this->tableName."` SET `sum` = `sum` + :sum WHERE `id` = :update_id";
            $result = $this->store($query, $params, $balance->id);
        }
        else
        {
            $result = $this->save($this->tableName, $data['data']);
        }

        return $result;
    }

    public function checkUserBalance(array $data): object|false
    {
        $query = "SELECT `id`
        FROM `".$this->tableName."`
        WHERE `id_user`=".$data['id_user']." AND `id_balance`=".$data['id_balance'];

        return $this->fetchOne($query);
    }
}