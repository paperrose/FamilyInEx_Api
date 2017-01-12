<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
date_default_timezone_set('Europe/Moscow');

require_once __DIR__.'/silex/vendor/autoload.php';
require_once __DIR__.'/app/controllers/UserController.php';

$app = new Silex\Application();
$app->register(new Silex\Provider\SessionServiceProvider());

$app->get('/hello', function () {
    return 'Hello!';
});

$app->get('/api/users_text', function () {
    return 'Users!';
});

$app->get('/api/users', 'UserController::getAllUsers');

$app->get('/api/expenses/get', 'ExpenseController::getExpenses');

$app->get('/api/expenses/add', 'ExpenseController::addExpense');

$app->get('/api/expenses/update', 'ExpenseController::updateExpense');

$app->get('/api/expenses/remove', 'ExpenseController::removeExpense');

$app->run();
