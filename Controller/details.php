<?php

require('../Model/Database.php');
$db = new Database();

function deleteBtn($table, $name){
    echo "
    <form action='delete.php' method='post'>
    <input type='hidden' name='id' value=" . $table['id'] . ">
    <input type='hidden' name='name' value=" . $table['name'] . ">
    <input type='hidden' name='table' value=" . $name . ">
    <input class='btn btn-primary' type='submit' name='submit' value='Delete'>
    </form>
    ";
}

//render class
if ((isset($_GET['table']) && $_GET['table'] == 'classes') && (isset($_GET['id']))) {
    function renderPage($db)
    {
        echo "<h1> Class information</h1>";
        $class = $db->getClasses($_GET['id'])[0];
        $students = $db->getStudentsOfClass($_GET['id']);
        echo "
        <h1>" . $class['name'] . "</h1>
        <h3>Location: " . $class['location'] . "</h3>
        <h3>Assigned Teacher:" .  "<a href='details.php?table=teachers&id=" . $class['teacherId'] . "'> " . $class['teacherName'] . "</a><br>" . "</h3>
        <h4>Students: </h4>
        <ul>";
        for ($i = 0; $i < count($students); $i++) {
            echo "<a href='details.php?table=students&id=" . $students[$i]['id'] . "'> " . $students[$i]['name'] . "</a><br>";
        }
        echo "</ul>";
        deleteBtn( $class, 'classes');
    }
} //render student
else if ((isset($_GET['table']) && $_GET['table'] == 'students') && (isset($_GET['id']))) {
    function renderPage($db)
    {
        echo "<h1> Student information</h1>";
        $student = $db->getStudents($_GET['id'])[0];
        $classInfo = $db->getClasses($student['class'])[0];
        echo "<h1>" . $student['name'] . "</h1>
        <h3>Email: " . $student['email'] . "</h3>
        <h3>Class:" .  "<a href='details.php?table=classes&id=" . $student['class'] . "'> " . $classInfo['name'] . "</a><br>" . "</h3>
        <h3>Teacher:" .  "<a href='details.php?table=teachers&id=" . $student['teacherId'] . "'> " . $student['teacherName'] . "</a><br>" . "</h3>";
        deleteBtn( $student, 'students');
    }
} //render teacher
else if((isset($_GET['table']) && $_GET['table'] == 'teachers') && (isset($_GET['id']))){
    function renderPage($db)
    {
        echo "<h1> Teacher information</h1>";
        $teacher = $db->getTeachers($_GET['id'])[0];
        $students = $db->getStudentsOfTeacher($_GET['id']);
        echo "
        <h1>" . $teacher['name'] . "</h1>
        <h3>E-mail: " . $teacher['email'] . "</h3>
        <h4>Students: </h4>
        <ul>";
        for ($i = 0; $i < count($students); $i++) {
            echo "<a href='details.php?table=students&id=" . $students[$i]['id'] . "'> " . $students[$i]['name'] . "</a><br>";
        }
        echo "</ul>";
        deleteBtn( $teacher, 'teachers');

    }
}else{
    function renderPage($db){
        return;
    }
}
