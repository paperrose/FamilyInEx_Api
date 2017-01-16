<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/Controller.php';

class ExpenseController extends Controller
{
    public function __construct(){
        parent::__contruct();
    }

    public function getExpenses(Request $request, Application $app) {
        $case = 0;
        $id = $request->get('id');
        if ($request->get('current') == 1) {
            $case += 1;
        }
        if (!empty($request->get('user_id'))) {
            $case += 2;
        }
        if (!empty($request->get('expense_type_id'))) {
            $case += 4;
        }
        if (!empty($id)) {
            $case = -1;
        }
        switch ($case) {
            case -1:
                $que = "SELECT * FROM expenses WHERE id = $id";
                $db_sql = $this->db->query($que);
                $response = ["result" => $db_sql];
                return $app->json($response);
            case 0:
                $que = "SELECT * FROM expenses";
                $db_sql = $this->db->query($que);
                $response = ["result" => $db_sql];
                return $app->json($response);
            case 1:
                return $this->getAllCurrentExpenses($request, $app);
            case 2:
                return $this->getAllUserExpenses($request, $app);
            case 3:
                return $this->getAllUserCurrentExpenses($request, $app);
            case 4:
                return $this->getAllETypeExpenses($request, $app);
            case 5:
                return $this->getAllETypeCurrentExpenses($request, $app);
            case 6:
                return $this->getAllUserETypeExpenses($request, $app);
            case 7:
                return $this->getAllUserCurrentETypeExpenses($request, $app);
        }
    }

    private function getAllCurrentExpenses(Request $request, Application $app) {
        $start = strtotime(date('01-m-Y'));
        $que = "SELECT * FROM expenses WHERE created_at BETWEEN $start AND CURRENT_TIMESTAMP ";
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    private function getAllETypeExpenses(Request $request, Application $app) {
        $que = "SELECT * FROM expenses WHERE expense_type_id = ".$request->get('expense_type_id');
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    private function getAllETypeCurrentExpenses(Request $request, Application $app) {
        $start = strtotime(date('01-m-Y'));
        $que = "SELECT * FROM expenses WHERE expense_type_id = ".$request->get('expense_type_id')." AND created_at BETWEEN $start AND CURRENT_TIMESTAMP ";
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    private function getAllUserExpenses(Request $request, Application $app) {
        $que = "SELECT * FROM expenses WHERE user_id = ".$request->get('user_id');
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    private function getAllUserCurrentExpenses(Request $request, Application $app) {
        $start = strtotime(date('01-m-Y'));
        $que = "SELECT * FROM expenses WHERE user_id = ".$request->get('user_id')." AND created_at BETWEEN $start AND CURRENT_TIMESTAMP ";
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    private function getAllUserETypeExpenses(Request $request, Application $app) {
        $que = "SELECT * FROM expenses WHERE user_id = ".$request->get('user_id')." AND expense_type_id = ".$request->get('expense_type_id');
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    private function getAllUserCurrentETypeExpenses(Request $request, Application $app) {
        $start = strtotime(date('01-m-Y'));
        $que = "SELECT * FROM expenses WHERE user_id = ".$request->get('user_id')." AND expense_type_id = ".$request->get('expense_type_id')." AND created_at BETWEEN $start AND CURRENT_TIMESTAMP ";
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    public function addExpense(Request $request, Application $app) {
        $sum = $request->get('sum');
        $pay_type_id = $request->get('pay_type_id');
        $user_id = $request->get('user_id');
        $comment = $request->get('comment');
        $expense_type_id = $request->get('expense_type_id');
        $created_at = $request->get('created_at');
        $que = "INSERT INTO expenses (operation_sum, pay_type_id, user_id, created_at, comment, expense_type_id) VALUES ($sum, $pay_type_id, $user_id, $created_at, '$comment', $expense_type_id)";
        $this->db->query($que);
        $response = ["result" => 1];
        return $app->json($response);
    }

    public function updateExpense(Request $request, Application $app) {
        $sum = $request->get('sum');
        $pay_type_id = $request->get('pay_type_id');
        $user_id = $request->get('user_id');
        $expense_type_id = $request->get('expense_type_id');
        $created_at = $request->get('created_at');
        $comment = $request->get('comment');
        $expense_id = $request->get('id');
        $que = "UPDATE expenses 
            SET operation_sum = $sum, 
            pay_type_id = $pay_type_id, 
            user_id = $user_id, 
            expense_type_id = $expense_type_id, 
            comment = '$comment', 
            created_at = $created_at 
            WHERE id = $expense_id";
        $this->db->query($que);
        $response = ["result" => 1];
        return $app->json($response);
    }

    public function removeExpense(Request $request, Application $app) {
        $expense_id = $request->get('id');
        $que = "DELETE FROM expenses WHERE id = $expense_id";
        $this->db->query($que);
        $response = ["result" => 1];
        return $app->json($response);
    }

    /*
   TODO get expenses:
       by PayTypes
       by Users
       by Month
       by ExpenseTypes
   TODO insert expense
   TODO update expense
   TODO remove expense
   */
}	