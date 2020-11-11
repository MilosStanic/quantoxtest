<?php require __DIR__ . '/vendor/autoload.php';

use App\Lib\Config;
use App\Lib\App;
use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;
use App\Model\Student;

Router::get('/', function () {
    echo 'Hello Quantox World';
});

Router::get('/students/([0-9]*)', function (Request $req, Response $res) {
    $students = new Student;
    $student = $students->findById($req->params[0]);
    if ($student['board'] === 'CSM') {
        return $res->toJson($student);
    } else {
        return $res->toXML($student);
    }
    
});

// bootstrap School Boards App
App::run();