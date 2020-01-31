<?php

define('db_host', 'localhost');
define('db_user', 'root');
define('db_pass','motdepasse');
define('db_name', 'admin');

$bdd = mysqli_connect(db_host, db_user, db_pass, db_name);

if ($bdd === false){
    die('Erreur : Impossible de se connecter à la base de données' . mysqli_connect_error());
}

