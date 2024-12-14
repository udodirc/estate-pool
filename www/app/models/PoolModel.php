<?php
namespace app\models;

use core\Model;

class PoolModel extends Model
{
    public string $tableName = 'estatepool';

    public function inform(int $id): array
    {
        $result = [];
        $query = "select `estatepool`.`sum`, `estatepool`.`sum_goal`, `estatepool`.`status`, `estatepool_gifts`.`name`, `estatepool_gifts`.`date_close`,
       `estatepool_gifts`.`id_winner`, `estatepool_gifts`.`general`
        from `estatepool`
        left join estatepool_gifts on estatepool.id = estatepool_gifts.id_pool
        where `estatepool`.`id` = ".$id;
        $data = $this->fetch($query);

        if(!empty($data))
        {
            $result['success'] = true;
            $result['id_pool'] = $id;
            $result['status'] = $data[0]->status;
            $result['sum'] = $data[0]->sum;
            $result['sum_goal'] = $data[0]->sum_goal;

            foreach($data as $key=>$value)
            {
                $result['gifts'][] = [
                    'name' => $data[$key]->name,
                    'date_close' => $data[$key]->date_close,
                    'id_winner' => $data[$key]->id_winner,
                    'general' => $data[$key]->general
                ];
            }
        }

        return $result;
    }
}