<?php

require('../Model/Database.php');
require('../Model/Class.php');
require('../Model/Connection.php');
require('../Model/Env.php');

session_start();

$connection = new Connection;
$conn = $connection->connectDB();

$db = new Database($conn);


if (isset($_SESSION['action'])) {
    if ($_SESSION['action'] == 'update') {
        if (isset($_POST['name']) && isset($_POST['location']) && isset($_POST['teachers']) && isset($_POST['id'])) {
            $values = [$_POST['name'], $_POST['location'], $_POST['teachers']];
            $db->update('classes', $_POST['id'], $values);
            $classes = $db->getClasses();
        }
        unset($_SESSION['action']);
    } else if ($_SESSION['action'] == 'create') {
        if (isset($_POST['name']) && isset($_POST['location']) && isset($_POST['teachers']) && isset($_POST['id'])) {
            $class = new SchoolClass($_POST['name'], $_POST['location'], $_POST['teachers']);
            $db->insertClass($class);
        }
        unset($_SESSION['action']);
    }
}


$classes = $db->getClasses();


function displayClasses($classes)
{
    for ($i = 0; $i < count($classes); $i++) {
        echo "
        <tr>
            <td><a href='/View/details.php?table=classes&id=" . $classes[$i]['id'] . "'>" . $classes[$i]['name'] . "</a></td>
            <td>" . $classes[$i]['location'] . "</td>".
            ($classes[$i]['teacherName'] == null ? "<td>None</td>" :"<td><a href='/View/details.php?table=teachers&id=" . $classes[$i]['teacherId']. "'>" . $classes[$i]['teacherName'] . "</a></td>").
            "<td><a class='btn btn-primary' href='/View/classForm.php?id=" . $classes[$i]['id'] . "'>Edit</a></td>
            <td>
                <form action='delete.php' method='post'>
                <input type='hidden' name='id' value=" . $classes[$i]['id'] . ">
                <input type='hidden' name='name' value=" . $classes[$i]['name'] . ">
                <input type='hidden' name='table' value='classes'>
                <input class='btn btn-primary' type='submit' name='submit' value='Delete'>
                </form>
            </td>
        </tr>";

    }
}
