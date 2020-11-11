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
    $res->toJson($students->all());
    /* $res->toJSON([
        'students' =>  [
            'id' => $req->params[0],
            'name' => 'John Doe',
            'grades' => [
                ['subject' => 'math', 'grade' => 6],
                ['subject' => 'science', 'grade' => 6],
                ['subject' => 'history', 'grade' => 7],
                ['subject' => 'physics', 'grade' => 7],
                ['subject' => 'chemistry', 'grade' => 8],
                ['subject' => 'arts', 'grade' => 8],
            ],
            'average' => 7,
            'final' => 'Pass'    
        ],
        'status' => 'ok'
    ]); */
});

// bootstrap School Boards App
App::run();