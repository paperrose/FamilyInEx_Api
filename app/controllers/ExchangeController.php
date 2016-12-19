<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/Controller.php';

class ExchangeController extends Controller
{
    public function __construct()
    {
        parent::__contruct();
    }

    public function getExchanges(Request $request, Application $app)
    {
        $que = "SELECT * FROM exchanges WHERE 1 = 1 ";
        $source_user = $request->get('source_user');
        $dest_user = $request->get('dest_user');
        $source_pay_type = $request->get('source_pay_type');
        $dest_pay_type = $request->get('dest_pay_type');
        $current = $request->get('current');
        $id = $request->get('id');
        if (!empty($id))
            $que = $que . "AND id = $id ";
        if (!empty($source_user))
            $que = $que . "AND user_id = $source_user ";
        if (!empty($dest_user))
            $que = $que . "AND destination_user_id = $dest_user ";
        if (!empty($source_pay_type))
            $que = $que . "AND pay_type_id = $source_pay_type ";
        if (!empty($dest_pay_type))
            $que = $que . "AND destination_id = $dest_pay_type ";
        if ($current == 1) {
            $start = strtotime(date('01-m-Y'));
            $que = $que . "AND created_at BETWEEN $start AND CURRENT_TIMESTAMP ";
        }
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }


    public function addExchange(Request $request, Application $app) {
        $source_user = $request->get('source_user');
        $dest_user = $request->get('dest_user');
        $source_pay_type = $request->get('source_pay_type');
        $dest_pay_type = $request->get('dest_pay_type');
        $sum = $request->get('sum');
        $created_at = $request->get('created_at');
        $que = "INSERT INTO exchanges (operation_sum, pay_type_id, user_id, created_at, destination_id, destination_user_id) 
            VALUES ($sum, $source_pay_type, $source_user, $created_at, $dest_pay_type, $dest_user)";
        $this->db->query($que);
        $response = ["result" => 1];
        return $app->json($response);
    }

    public function updateExchange(Request $request, Application $app) {
        $source_user = $request->get('source_user');
        $expense_id = $request->get('id');
        $dest_user = $request->get('dest_user');
        $source_pay_type = $request->get('source_pay_type');
        $dest_pay_type = $request->get('dest_pay_type');
        $sum = $request->get('sum');
        $created_at = $request->get('created_at');
        $que = "UPDATE expenses 
            SET operation_sum = $sum, 
            pay_type_id = $source_pay_type, 
            user_id = $source_user, 
            destination_id = $dest_pay_type, 
            destination_user_id = $dest_user, 
            created_at = $created_at 
            WHERE id = $expense_id";
        $this->db->query($que);
        $response = ["result" => 1];
        return $app->json($response);
    }

    public function removeExchange(Request $request, Application $app) {
        $expense_id = $request->get('id');
        $que = "DELETE FROM expenses WHERE id = $expense_id";
        $this->db->query($que);
        $response = ["result" => 1];
        return $app->json($response);
    }

}	