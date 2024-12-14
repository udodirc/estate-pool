<?php
namespace app\controllers;

use core\Controller;
use core\Validation;
use app\models\TicketModel;
use JetBrains\PhpStorm\NoReturn;

class TicketController extends Controller 
{
    private TicketModel $ticket;

    public function __construct() {
        $this->ticket = new TicketModel();
    }

    #[NoReturn] public function store(): void
    {   
        $response['status'] = 'fail';
        $validationRules = [
            'count' => ['required', 'is_numeric'],
            'sum' => ['required', 'is_numeric'],
            'status' => ['required', 'is_numeric'],
        ];
        
        $data = Validation::validate($validationRules);
        
        if (empty($data['errors'])) {
            if ($this->ticket->save($this->ticket->tableName, $data['data'])) {
                $response['status'] = 'success';
            }
        } else {
            $response['errors'] = $data['errors'];
        }

        $this->json($response);
    }
}