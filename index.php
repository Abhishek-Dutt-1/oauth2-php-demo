<?php
require 'vendor/autoload.php';
require 'database.php';

$db = new Database();
$app = new \Slim\Slim();


$app->group("/users", function() use ($app, $db) {

    $app->get("/", function() use ($db) {
        $users = $db->pdo->query("SELECT * FROM users");
        $html = "<h2>All Users</h2>";
        $html .= "<table>";
        foreach($users as $row)
        {
            $html .= "<tr><td> $row[id] </td><td> $row[email] </td><td> $row[password] </td></tr>";
        }
        $html .= "</table>";

        echo $html;
    });

    $app->get("/:id", function($id) use ($db) {
        $users = $db->pdo->query("SELECT * FROM users WHERE id = $id");
        $html = "<h3>User Id: $id </h3>";
        $html .= "<table>";
        foreach($users as $row)
        {
            $html .= "<tr><td> $row[id] </td><td> $row[email] </td><td> $row[password] </td></tr>";
        }
        $html .= "</table>";

        echo $html;
    });

    $app->post("/", function() use ($app, $db) {
        $db->pdo->query( "INSERT INTO users (email, password) values ( '" . $app->request->post('email') . "', '" . $app->request->post('password') ."' )" ) ;
        $html = "New User Created." ;

        echo $html;
    });

    $app->post("/:id", function($id) use ($app, $db) {
        $db->pdo->query( "UPDATE users SET email = '". $app->request->post('email') . "', password = '" . $app->request->post('password') . "' WHERE id = $id " );
        $html = "User Id $id Updated." ;

        echo $html;
    });

    $app->delete('/:id', function($id) use ($app, $db) {
        $db->pdo->query("DELETE FROM users WHERE id = $id");
        $html = "User Id $id Deleted";

        echo $html;
    });

});


$app->run();
