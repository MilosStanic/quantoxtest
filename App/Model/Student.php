<?php namespace App\Model;

use App\Lib\Config;
use Aura\Sql\ExtendedPdo;


class Student {

    private $db_config = [];
    private $pdo;
    private $student;
    private $grades;

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

    public function findById(int $id) {
        $this->student = $this->pdo->fetchOne('SELECT * FROM students JOIN grades as grades ON grades.student_id=students.id WHERE students.id=' . $id );

        $this->grades = $this->gradesToArray();

        // decide which type of report to generate based on student board membership
        if($this->student['board'] === 'CSM') {
            $result = $this->getCSMreport();
        } else {
            $result = $this->getCSMBreport();
        }
        return $result;
    }

    /** 
     * CSM considers pass if the average is bigger or equal to 7 and fail otherwise.
    */
    private function getCSMreport() {
        $average = array_sum($this->grades)/count($this->grades);
        $final = $average >= 7 ? 'Pass' : 'Fail';
        return $this->constructResult($average, $final);
    }

    /** 
     * CSMB discards the lowest grade, if you have more than 2 grades, and considers pass if his biggest grade is bigger than 8.
     * This is a bit unclear. I don't understand what "discards" means in this context. Does it discard the lowest grade from the calculation
     * but only if there are more than two grades?
     * I will presume the CSMB discards the lowest grade from the calculation if there are more than two grades. But in this case if there is only one 
     * grade or two grades and even if it is bigger than 8 - the student will fail. So the first condition is that student has to have at least 3 grades in total
     * to pass, and the biggest one has to be 9 or more (bigger than 8).
    */
    private function getCSMBreport() {        
        /* In the database grade 0 is considered "no grade"
            I will have to manually count the $this->grades array elements
        */
        $grades_count = 0;
        foreach($this->grades as $grade) {
            if ($grade > 0) {
                $grades_count++;
            }
        }

        /** 
         * Algorithm, if I understood correctly: 
         * 1. count all grades
         * 2. decrease count by 1
         * 3. see if count now bigger than 2
         * 3. find biggest grade
         * 4. pass if biggest grade > 8
         * 
         * Decreasing number of grades by 1 amounts to eliminating the lowest grade since the condition is to have more than 2 grades and find the biggest one
        */

        if($grades_count - 1 > 2) {
            if (max($this->grades) > 8) {
                $final = 'Pass';
            } else {
                $final = 'Fail';
            }
        } else {
            $final = 'Fail';
        }

        // average takes all the grades into account, wasn't stated explicitly to exclude lowest grade from average
        // what if there are two lowest grades? do I discard them both? What if grades are 5, 5, 5, 9? Lots of unanswered questions
        $average = array_sum($this->grades)/$grades_count;

        return $this->constructResult($average, $final);
    }

    /** 
     * Puts all grades into an array, for simpler calculation
    */
    private function gradesToArray() {
        return [ $this->student['math'], $this->student['history'], $this->student['physics'], $this->student['arts']];
    }

    /** 
     * Construct return dataset
    */
    private function constructResult($average, $final) {
        return [
            'id' => $this->student['id'],
            'name' => $this->student['name'],
            'board' => $this->student['board'],
            'grades' => [
                'math' => $this->student['math'] ,
                'history' => $this->student['history'],
                'physics' => $this->student['physics'],                
                'arts' => $this->student['arts'],
            ],
            'average' => $average,
            'final' => $final 
        ];
    }
}