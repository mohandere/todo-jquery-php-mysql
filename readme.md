# ToDo app using jQuery, php, Mysql

Mysql db stores todos of user, using ajax for GET/POST. Mysql needs connected before runing this app.

### DB Schema -

#### Tables

1. user (id, first_name, last_name, email)
2. todo (id, user_id, title, completed, date_time)

#### DB connection

- Edit file <code>localhost/todo-jquery-php-mysql/includes/db-config.php</code> file and change constant DB_NAME, DB_USER, DB_PASSWORD, DB_HOST

####  To create dummy db -

After successful connection you can use follwing file to create a dummy database using follwing steps

- Edit file <code>/includes/dump-sql.php</code> and change sql quries as you want.
- Type in browser <code>localhost/todo-jquery-php-mysql/includes/dump-sql.php</code>
- Hit enter


### To run app

To run on local try with mamp/xampp/wamp/lamp...etc software

- Start php server
- Start mysql server
- Place downloaded <code>todo-jquery-php-mysql</code> folder in <code>www/htdocs</code> web directory
- Type in browser <code>localhost/todo-jquery-php-mysql</code>
- Hit enter


### Credit

Thanks to [TodoMVC](todomvc.com) for creating jquery version of Todo.

