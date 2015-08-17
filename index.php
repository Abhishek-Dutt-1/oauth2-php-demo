<?php
$config = require 'config.php';
require 'vendor/autoload.php';
require 'oauth2/database.php';

//	OAuth2-server implementations
require 'oauth2/Storage/SessionStorage.php';
require 'oauth2/Storage/AccessTokenStorage.php';
require 'oauth2/Storage/ClientStorage.php';
require 'oauth2/Storage/ScopeStorage.php';
require 'oauth2/Storage/AuthCodeStorage.php';
require 'oauth2/Storage/RefreshTokenStorage.php';

$db = new \AbhishekDutt\oauth2\Database($config["connections"]["mysql"]);
$app = new \Slim\Slim();


////////// OAUTH2 SERVER
//		Resource server
$sessionStorage = new RelationalExample\Storage\SessionStorage();
$accessTokenStorage = new RelationalExample\Storage\AccessTokenStorage();
$clientStorage = new RelationalExample\Storage\ClientStorage();
$scopeStorage = new RelationalExample\Storage\ScopeStorage();
$resourceServer = new League\OAuth2\Server\ResourceServer(
    $sessionStorage,
    $accessTokenStorage,
    $clientStorage,
    $scopeStorage
);
// Authorization server
$server = new League\OAuth2\Server\AuthorizationServer;
$server->setSessionStorage(new RelationalExample\Storage\SessionStorage);
$server->setAccessTokenStorage(new RelationalExample\Storage\AccessTokenStorage);
$server->setRefreshTokenStorage(new RelationalExample\Storage\RefreshTokenStorage);
$server->setClientStorage(new RelationalExample\Storage\ClientStorage);
$server->setScopeStorage(new RelationalExample\Storage\ScopeStorage);
$server->setAuthCodeStorage(new RelationalExample\Storage\AuthCodeStorage);
$authCodeGrant = new \League\OAuth2\Server\Grant\AuthCodeGrant();
$server->addGrantType($authCodeGrant);
/////////// End OAuth Config ////////////

//	User CRUD
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

/////////// OAuth Routes
$app->get('/access_token', function () use ($server) {
	return $response = $server->issueAccessToken();
});



$app->run();
