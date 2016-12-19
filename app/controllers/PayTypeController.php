<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/Controller.php';

class PayTypeController extends Controller
{
    public function __construct(){
        parent::__contruct();
    }


    public function getAllPayTypes(Request $request, Application $app) {
        $que = "SELECT * FROM pay_types";
        $db_sql = $this->db->query($que);
        $response = ["result" => $db_sql];
        return $app->json($response);
    }

    /*
   TODO get pay types
   TODO insert pay type
   TODO update pay type
   TODO remove pay type
   */
}	