<?php
namespace app\controllers;

use core\Controller;
use core\Validation;
use app\models\PoolModel;

class PoolController extends Controller
{
    private PoolModel $pool;

    public function __construct() {
        $this->pool = new PoolModel();
    }

    public function index(): void
    {
        var_dump(true);
    }

    #[NoReturn] public function store(): void
    {   
        $response['status'] = 'fail';
        $validationRules = [
            'sum_goal' => ['required', 'is_numeric'],
            'sum' => ['required', 'is_numeric'],
            'status' => ['required', 'is_numeric'],
            'date_start' => ['required'],
            'date_close' => ['required'],
        ];
        
        $data = Validation::validate($validationRules);
        
        if (empty($data['errors'])) {
            if ($this->pool->save($this->pool->tableName, $data['data'])) {
                $response['status'] = 'success';
            }
        } else {
            $response['errors'] = $data['errors'];
        }

        $this->json($response);
    }
}