<?php
namespace app\models;

use core\Model;

class TicketModel extends Model
{
    public string $tableName = 'estatepool_tickets';

    public function sum(int $id): object|false
    {
        $query = "SELECT `sum`
        FROM `".$this->tableName."`
        WHERE `id`=".$id;

        return $this->fetchOne($query);
    }
}