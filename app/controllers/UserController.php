<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/Controller.php';

class UserController extends Controller
{
    public function __construct(){
        parent::__contruct();
    }

    public function getAllUsers(Request $request, Application $app) {
        $que = "SELECT * FROM users";
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    public function getFinanceGroupUsers(Request $request, Application $app) {
        $que = "SELECT * FROM users WHERE users.id in (select apiusers_id from finance_groups_participants where apifinancegroups_id = $request->get('id'))";
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    //TODO register, add info, set password, login in future
}