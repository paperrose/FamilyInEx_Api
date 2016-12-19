<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/Controller.php';

class ExpenseTypeController extends Controller
{
    public function __construct(){
        parent::__contruct();
    }

    public function getAllExpenseTypes(Request $request, Application $app) {
        $que = "SELECT * FROM expense_types";
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }
}	