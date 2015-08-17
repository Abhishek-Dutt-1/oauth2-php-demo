<?php
 /* App configs
 */
 
return array(
    "connections" => array(
        "mysql" => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'oauth2demo',
			'username'  => 'root',
			'password'  => 'root',
        ),
        "otherDB" => array(
            "driver"   => "database2",
            "host"     => "localhost",
            "database" => "database",
            "username" => "dbUser",
            "password" => "pa$$",

        )
    )
);