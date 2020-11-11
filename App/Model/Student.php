<?php namespace App\Model;

use App\Lib\Config;
use Aura\Sql\ExtendedPdo;


class Student {
    
    private $db_config = [];
    private $pdo;

    function __construct() {
        $this->db_config = Config::get('DATABASE');
        $this->pdo = new ExtendedPdo(
            'mysql:host='. $this->db_config['db_server'] . ';dbname=' . $this->db_config['db_name'],
            $this->db_config['db_user'],
            $this->db_config['db_pass']
        );
    }

    public function all() {
        $result = $this->pdo->fetchAll('SELECT * from students');
        // print_r($result);
        return $result;
    }

    public static function findById(int $id) {

    }
}