<?php

namespace app\controllers;

use app\models\GiftModel;
use app\models\PoolModel;
use app\models\TicketModel;
use app\models\UserBalanceModel;
use app\models\UserModel;
use app\models\UserTicketModel;
use core\Controller;
use core\Validation;
use JetBrains\PhpStorm\NoReturn;

class UserTicketController extends Controller
{
    private UserTicketModel $userTicketModel;
    private UserBalanceModel $userBalance;
    private UserModel $user;
    private TicketModel $ticket;
    private PoolModel $pool;
    private GiftModel $gift;

    public function __construct() {
        $this->userTicketModel = new UserTicketModel();
        $this->userBalance = new UserBalanceModel();
        $this->user = new UserModel();
        $this->ticket = new TicketModel();
        $this->pool = new PoolModel();
        $this->gift = new GiftModel();
    }

    #[NoReturn] public function store(): void
    {
        $response['status'] = 'fail';
        $validationRules = [
            'id_user' => ['required', 'is_numeric'],
            'ticket' => ['required', 'is_numeric'],
            'id_ticket' => ['required', 'is_numeric'],
            'id_pool' => ['required', 'is_numeric'],
            'id_gift' => ['required', 'is_numeric'],
            'win' => ['required', 'is_numeric'],
        ];

        $data = Validation::validate($validationRules);

        if (empty($data['errors'])) {
            if($this->user->checkIfExist($this->user->tableName, ['id'=>$data['data']['id_user']])){
                if($this->ticket->checkIfExist($this->ticket->tableName, ['id'=>$data['data']['id_ticket']])){
                    if($this->pool->checkIfExist($this->pool->tableName, ['id'=>$data['data']['id_pool']])){
                        if($this->gift->checkIfExist($this->gift->tableName, ['id'=>$data['data']['id_gift']])){
                            $ticketSum = $this->userBalance->checkUserSum($data['data']['id_ticket'], $data['data']['id_user']);

                            if($ticketSum > 0)
                            {
                                $data['data']['ticket_sum'] = $ticketSum;

                                if($this->userTicketModel->createTicket($data['data'])){
                                    $response['status'] = 'success';
                                }
                            } else {
                                $response['errors'] = 'Not enough balance';
                            }
                        } else {
                            $response['errors'] = "Gift not found";
                        }
                    } else {
                        $response['errors'] = "Pool not found";
                    }
                } else {
                    $response['errors'] = "Ticket not found";
                }
            } else {
                $response['errors'] = "User not found";
            }
        } else {
            $response['errors'] = $data['errors'];
        }

        $this->json($response);
    }

    #[NoReturn] public function inform(): void
    {
        $validationRules = [
            'id_pool' => ['required', 'is_numeric'],
            'id_user' => ['required', 'is_numeric']
        ];

        $data = Validation::validate($validationRules);

        if (empty($data['errors'])) {
            $response['success'] = true;
            $response['data'] = $this->userTicketModel->inform($data['data']['id_user'], $data['data']['id_pool']);
        } else {
            $response['errors'] = $data['errors'];
        }

        $this->json($response);
    }
}