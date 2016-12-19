<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/Controller.php';

class IncomeController extends Controller
{
    public function __construct(){
        parent::__contruct();
    }

    public function getIncomes(Request $request, Application $app) {
        $case = 0;
        $id = $request->get('id');
        if ($request->get('current') == 1) {
            $case += 1;
        }
        if ($request->get('user_id') != null) {
            $case += 2;
        }
        if (!empty($id)) {
            $case = -1;
        }
        switch ($case) {
            case -1:
                $que = "SELECT * FROM incomes WHERE id = $id";
                $db_sql = $this->db->query($que);
                $response = ["result" => $db_sql];
                return $app->json($response);
            case 0:
                $que = "SELECT * FROM incomes";
                $db_sql = $this->db->query($que);
                $response = ["result" => $db_sql];
                return $app->json($response);
            case 1:
                return $this->getCurrentIncomes($request, $app);
            case 2:
                return $this->getUserIncomes($request, $app);
            case 3:
                return $this->getUserCurrentIncomes($request, $app);
        }
    }

    private function getCurrentIncomes(Request $request, Application $app) {
        $start = strtotime(date('01-m-Y'));
        $que = "SELECT * FROM incomes WHERE created_at BETWEEN $start AND CURRENT_TIMESTAMP";
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    private function getUserIncomes(Request $request, Application $app) {
        $que = "SELECT * FROM incomes WHERE user_id = ".$request->get('user_id');
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }


    private function getUserCurrentIncomes(Request $request, Application $app) {
        $start = strtotime(date('01-m-Y'));
        $que = "SELECT * FROM incomes WHERE user_id = ".$request->get('user_id')." AND created_at BETWEEN $start AND CURRENT_TIMESTAMP";
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    public function addIncome(Request $request, Application $app) {
        $sum = $request->get('sum');
        $pay_type_id = $request->get('pay_type_id');
        $user_id = $request->get('user_id');
        $created_at = $request->get('created_at');
        $que = "INSERT INTO incomes (operation_sum, pay_type_id, user_id, created_at) VALUES ($sum, $pay_type_id, $user_id, $created_at)";
        $this->db->query($que);
        $response = ["result" => 1];
        return $app->json($response);
    }

    public function updateIncome(Request $request, Application $app) {
        $sum = $request->get('sum');
        $pay_type_id = $request->get('pay_type_id');
        $user_id = $request->get('user_id');
        $created_at = $request->get('created_at');
        $income_id = $request->get('id');
        $que = "UPDATE incomes SET operation_sum = $sum, pay_type_id = $pay_type_id, user_id = $user_id, created_at = $created_at WHERE id = $income_id";
        $this->db->query($que);
        $response = ["result" => 1];
        return $app->json($response);
    }

    public function removeIncome(Request $request, Application $app) {
        $income_id = $request->get('id');
        $que = "DELETE FROM incomes WHERE id = $income_id";
        $this->db->query($que);
        $response = ["result" => 1];
        return $app->json($response);
    }
    /*
    TODO get incomes:
        by PayTypes
        by FinanceGroups
        by Users
        by Month
    TODO insert income
    TODO update income
    TODO remove income
    */
}	