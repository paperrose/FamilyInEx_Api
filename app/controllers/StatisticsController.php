<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/Controller.php';

class StatisticsController extends Controller
{
    public function __construct(){
        parent::__contruct();
    }
    //TODO корректный рассчет текущих сумм
    //возможно стоит ввести таблицу текущих остатков
}	