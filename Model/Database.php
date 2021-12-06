<?php

class Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "school");
    }


    public function getTableColumns($table){
        $sql = "DESCRIBE $table";
        $result = $this->conn->query($sql);
        $columns = [];

        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
        return $columns;
    }

    public function getStudents($id = null)
    {
        if ($id == null) {
            $sql = "select s.id, s.name, s.email, s.class,  s.teacher , t.name as tname from students as s
            left join teachers t on s.teacher = t.id ";
        } else {
            $sql = "select s.id, s.name, s.email, s.class,  s.teacher , t.name as tname from students as s
            left join teachers t on s.teacher = t.id where s.id = $id";
        }

        $result = $this->conn->query($sql);
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = array("id" => $row['id'], "name" => $row['name'], "email" => $row['email'], "class" => $row['class'], "teacherId" => $row['teacher'], "teacherName" => $row['tname']);
        }

        return $students;
    }


    public function getTeachers($id)
    {
        if ($id == null) {
            $sql = "select * from teachers";
        } else {
            $sql = "select * from teachers where id = $id";
        }
        $result = $this->conn->query($sql);
        $teachers = [];

        while ($row = $result->fetch_assoc()) {
            $teachers[] = array("id" => $row['id'], "name" => $row['name'], "email" => $row['email']);
        }
        return $teachers;
    }

    public function getClasses($id = null)
    {
        if ($id == null) {
            $sql = "select c.id, c.name, c.location, c.teacher, t.name as tname from classes c left join teachers t on c.teacher = t.id ";
        } else {
            $sql = "select c.id, c.name, c.location, c.teacher, t.name as tname from classes c left join teachers t on c.teacher = t.id where c.id = $id";
        }
        $result = $this->conn->query($sql);
        $classes = [];
        while ($row = $result->fetch_assoc()) {
            $classes[] = array("id" => $row['id'], "name" => $row['name'], "location" => $row['location'], "teacherId" => $row['teacher'], "teacherName" => $row['tname']);
        }
        return $classes;
    }

<<<<<<< HEAD
    public function deleteById($table, $id)
    {
        $sql = "delete from $table where id = $id";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function insertStudent($student)
    {
        $name=$student->getName();
        $email=$student->getEmail();
        $class=$student->getClass();
        $teacher=$student->getTeacher();

        $sql = "INSERT INTO students (name, email, class, teacher)
        VALUES ('$name', '$email', '$class', '$teacher');";

        $result = $this->conn->query($sql);
        return $result;
    }


    public function insertClass($class)
    {
        $name=$class->getName();
        $location=$class->getLocation();
        $teacher=$class->getTeacher();

        $sql = "INSERT INTO classes (name, location, teacher)
        VALUES ('$name', '$location', '$teacher');";

        $result = $this->conn->query($sql);
        return $result;
    }
=======
    
>>>>>>> shreejan


    public function insertTeacher($teacher)
    {
        $name=$teacher->getName();
        $email=$teacher->getEmail();

        $sql = "INSERT INTO teachers (name, email)
        VALUES ('$name', '$email');";

        $result = $this->conn->query($sql);
        return $result;
    }

    public function update($table,$id,$values){
        $columns = $this->getTableColumns($table);

        $columnsString = "";
        for ($i=0; $i < count($columns); $i++) { 
            $columnsString .= $columns[$i] . "=" . $values[$i];
        }
        
        

        $sql="UPDATE $table SET $columnsString WHERE id = $id";
        var_dump($sql);

        // $result = $this->mysqli->query($sql);
    }

    
}

?>





<!-- $conn = new mysqli(getenv('DATABASE_HOST'), getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'), getenv('DATABASE_DBNAME'));

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    // echo "Connected successfully";
    return $conn;
} -->