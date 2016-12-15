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
}	