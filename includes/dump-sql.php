<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

define('__ROOT__', dirname(__FILE__));


require_once(__ROOT__.'/db-config.php');
require_once(__ROOT__.'/mysql-db.php');

//For now we assumes that there is only one user with id 1
$user_id = 1;

$db = MySqlDatabase::getInstance();

// connect
try {
    // $db->connect('localhost', 'username', 'password', 'database_name');
    $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
catch (Exception $e) {
  die($e->getMessage());
}

echo '<h3>SQL Logs</h3>';

// create table user
$query = "CREATE TABLE user(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    email VARCHAR(320) NOT NULL
)";
$db->query($query);

echo '<p>Table `user` created</p>';


// create table todo
$query = "CREATE TABLE todo(
    id VARCHAR(100) NOT NULL PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    completed TINYINT(1) NOT NULL DEFAULT 0,
    date_time DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id)
)";

$db->query($query);

echo '<p>Table `todo` created</p>';

$query = "INSERT INTO user (id, first_name, last_name, email) VALUES (1, 'Sagar', 'Dere', 'deresagar01@gmail.com')";
$rows = $db->insert($query, MySqlDatabase::INSERT_GET_AFFECTED_ROWS);

echo '<p>'. $rows . ' records inserted into `user` table.</p>';



$query = "INSERT INTO todo (id, user_id, title, completed, date_time) VALUES
('e2c710ac-d06d-4a10-afa5-d0793951581e', $user_id, 'Buy vegetables', 0, '13-4-2017 10:34:09 AM'),
('e2c710ac-d06d-4a10-afa5-d0793951582e', $user_id, 'Complete todo project', 0, '11-4-2017 10:34:09 AM'),
('e2c710ac-d06d-4a10-afa5-d0793951583e', $user_id, 'Give presentation', 1, '14-4-2017 10:34:09 AM')";

$rows = $db->insert($query, MySqlDatabase::INSERT_GET_AFFECTED_ROWS);

echo '<p>' . $rows . ' records inserted into `todo` table.</p>';


// Update Query
//$query = "UPDATE todo SET completed = {$todo['completed']}, title = '{$todo['title']}', date_time = '$datetime' WHERE id = '{$todo['id']}'";

echo '<h4>Success, dump completed.</h4>';

?>