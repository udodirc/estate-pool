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
}