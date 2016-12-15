<?php

require_once __DIR__ . '/../config/Config.php';

class DB
{
    private $connection;

    public function __construct()
    {

        $db = Config::$db;
        $this->connection = mysqli_connect(
            $db['host'],
            $db['user'],
            $db['password'],
            $db['database']
        );

    }


    /**
     * @return bool
     */
    public function isConnected()
    {
        return (bool)$this->connection;
    }

    public function query($query, $assoc = true, $isEncoding = true){
        mysqli_set_charset($this->connection, "utf8");
        $res =  mysqli_query($this->connection, $query);
        if(!$res){
            return ["success"=>false, "error"=>mysqli_error(), "query"=>$query];
        }

        $rows = [];

        $fetch_func = ($assoc ? 'mysqli_fetch_assoc':'mysqli_fetch_row');

        while($row = mysqli_fetch_assoc($res)){

            foreach($row as $k=>$v){
                if ($isEncoding) {
                    $row[$k] = iconv("CP1251", "UTF-8", $v);
                }
            }
            $rows[] = $row;
        }

        return $rows;
    }


}	