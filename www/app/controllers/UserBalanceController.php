<?php
namespace app\controllers;

use app\models\BalanceModel;
use app\models\UserModel;
use core\Controller;
use core\Validation;
use app\models\UserBalanceModel;
use JetBrains\PhpStorm\NoReturn;

class UserBalanceController extends Controller 
{
    private UserBalanceModel $userBalance;
    private UserModel $user;

    private BalanceModel $balance;

    public function __construct() {
        $this->userBalance = new UserBalanceModel();
        $this->user = new UserModel();
        $this->balance = new BalanceModel();
    }

    #[NoReturn] public function store(): void
    {   
        $response['status'] = 'fail';
        $validationRules = [
            'id_user' => ['required', 'is_numeric'],
            'id_balance' => ['required', 'is_numeric'],
            'sum' => ['required', 'is_numeric'],
            'status' => ['required', 'is_numeric'],
            'show_balance' => ['required', 'is_numeric']
        ];
        
        $data = Validation::validate($validationRules);

        if (empty($data['errors'])) {
            if($this->user->checkUser($data['data']['id_user'])){
                if($this->balance->checkBalance($data['data']['id_balance'])) {
                    if ($this->userBalance->saveBalance($data)) {
                        $response['status'] = 'success';
                    }
                } else {
                    $response['errors'] = "Balance not found";
                }
            } else {
                $response['errors'] = "User not found";
            }
        } else {
            $response['errors'] = $data['errors'];
        }

        $this->json($response);
    }
}