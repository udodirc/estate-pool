<?php
namespace app\controllers;

use core\Controller;
use core\Validation;
use app\models\BalanceModel;

class BalanceController extends Controller 
{
    private BalanceModel $balance;

    public function __construct() {
        $this->balance = new BalanceModel();
    }

    #[NoReturn] public function store(): void
    {   
        $response['status'] = 'fail';
        $validationRules = [
            'title' => [],
            'paysystem' => [],
            'currency' => [],
            'status' => ['required', 'is_numeric'],
            'type' => ['required', 'is_numeric']
        ];
        
        $data = Validation::validate($validationRules);
        
        if (empty($data['errors'])) {
            if ($this->balance->save($this->balance->tableName, $data['data'])) {
                $response['status'] = 'success';
            }
        } else {
            $response['errors'] = $data['errors'];
        }

        $this->json($response);
    }
}