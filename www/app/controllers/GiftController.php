<?php
namespace app\controllers;

use core\Controller;
use core\Validation;
use app\models\GiftModel;

class GiftController extends Controller 
{
    private GiftModel $gift;

    public function __construct() {
        $this->gift = new GiftModel();
    }

    #[NoReturn] public function store(): void
    {   
        $response['status'] = 'fail';
        $validationRules = [
            'id_pool' => ['required', 'is_numeric'],
            'priority' => ['required', 'is_numeric'],
            'general' => ['required', 'is_numeric'],
            'name' => ['required'],
            'date_close' => ['required'],
        ];
        
        $data = Validation::validate($validationRules);
        
        if (empty($data['errors'])) {
            if ($this->gift->save($this->gift->tableName, $data['data'])) {
                $response['status'] = 'success';
            }
        } else {
            $response['errors'] = $data['errors'];
        }

        $this->json($response);
    }
}