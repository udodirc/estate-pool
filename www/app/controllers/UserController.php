<?php
namespace app\controllers;

use core\Controller;
use core\Validation;
use app\models\UserModel;

class UserController extends Controller 
{
    private UserModel $user;

    public function __construct() {
        $this->user = new UserModel();
    }

    #[NoReturn] public function store(): void
    {   
        $response['status'] = 'fail';
        $validationRules = [
            'email' => ['required'],
            'id_ref' => ['required', 'is_numeric']
        ];
        
        $data = Validation::validate($validationRules);
        
        if (empty($data['errors'])) {
            if ($this->user->save($this->user->tableName, $data['data'])) {
                $response['status'] = 'success';
            }
        } else {
            $response['errors'] = $data['errors'];
        }

        $this->json($response);
    }
}