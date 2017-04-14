<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

define('__ROOT__', dirname(__FILE__));

//For now we assumes that there is only one user with id 1
$user_id = 1;

// Default response
$response = array(
	'message' => 'SUCCESS',
	'data' => []
);


@header( 'Content-Type: text/html; charset=utf-8');
@header( 'X-Robots-Tag: noindex' );

// Require an action parameter
if ( empty( $_REQUEST['action'] ) ){
  die(json_encode($response));
}



require_once(__ROOT__.'/includes/db-config.php');
require_once(__ROOT__.'/includes/mysqlresultset.php');
require_once(__ROOT__.'/includes/mysql-db.php');

global $db;
$db = MySqlDatabase::getInstance();

// connect
try {
		// $db->connect('localhost', 'username', 'password', 'database_name');
    $db->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
catch (Exception $e) {

	$response['message'] = 'ERROR';
	$response['data'] = $e->getMessage();
  die(json_encode($response));
}

// Get all todos from  DB
// return $todo {Array}
function get_todos( $user_id ){

	global $db;

	$todo = [];
	$query = "SELECT * FROM ". DB_NAME .".todo";
	// iterate as objects
	foreach ($db->iterate($query) as $row) {
		array_push( $todo, array(
			'id' => $row->id,
			'completed' => $row->completed,
			'title' => $row->title,
		));
	}

	return $todo;

}

// Delete all old todos
// save all todos from  DB
// return $count {Int}
function save_todos( $user_id ){

	global $db;

	if ( !isset( $_POST['todos'] ) && empty( $_POST['action'] ) ){
		return 0;
	}

	// Delete all old records first
	$query = "TRUNCATE ". DB_NAME .".todo";
	$db->delete($query);

	foreach ( $_POST['todos'] as $key => $todo ) {

		$datetime = date('Y-m-d H:i:s');

		$query = "INSERT INTO todo (id, user_id, title, completed, date_time) VALUES
		('{$todo['id']}', $user_id, '{$todo['title']}', {$todo['completed']}, '$datetime')";

		$db->insert( $query );

	}

	return count($_POST['todos']);

}


// Register core Ajax calls.
// Handle get operations
if ( ! empty( $_GET['action'] ) ){
	$response['data'] = get_todos( $user_id );
}

// Handle add/update operations
if ( ! empty( $_POST['action'] ) ){
	$response['data'] = save_todos( $user_id );
}

// Default status
die(json_encode($response));

?>