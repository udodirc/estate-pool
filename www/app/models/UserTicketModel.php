<?php

namespace app\models;

use core\Model;

class UserTicketModel extends Model
{
    public string $tableName = 'estatepool_usertickets';

    public function createTicket(array $data): bool
    {
        return $this->callProcedure($data, 'create_ticket', true);
    }

    public function inform(int $userID, int $poolID): array
    {
        $query = "SELECT `ticket`, `id_pool`, `win`
        FROM `".$this->tableName."`
        WHERE `id_user`=".$userID." AND `id_pool`=".$poolID;

        return $this->fetch($query);
    }
}