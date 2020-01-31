<?php
// Initialize the session
session_start();
require 'vendor/autoload.php';
require_once 'database.php';
use \nizarii\ARC;

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


$result = mysqli_query($bdd, 'SELECT * FROM `servers` WHERE serverid=1;');
$server = mysqli_fetch_array($result);

$edit_address = "";
$edit_password = "";
$edit_ports = "";
$edit_error = "";

try { 
    $rcon2 = new ARC('127.0.0.1', 'RConPassword', 2302);
}
catch (Exception $e) {
    echo 'error';
}

if (isset($_POST['modifier'])) {
    $edit_address = $_POST['addressip'];
    $edit_password = $_POST['passwords'];
    $edit_ports = $_POST['ports'];
    try {
        $rcon = new ARC("$edit_address", "$edit_password", (int)$edit_ports, ['timeoutSec' => 2]);
        mysqli_query($bdd, "UPDATE servers SET address='$edit_address', passwords='$edit_password', ports='$edit_ports' WHERE serverid=1");
        $edit_success = "La configuration RCON à bien été appliqué !";
        header('location: configuration.php');
    } 
    catch (Exception $e) {
        $edit_error = "Une erreur est survenue : {$e->getMessage()}";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Configuration | Administration ARMA</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Administration ARMA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarNavDropdown" class="navbar-collapse collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Serveurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Commande</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="configuration.php">Configuration</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item sm-6">
                    <form class="form-inline" action="logout.php">
                        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Se déconnecter</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row m-5">
            <div class="col align-self-center">
            <div class="border p-2 m-2">
                <?php
                if(!empty($edit_error)) { ?>
                <div class="alert alert-danger" role="alert"> <?php echo $edit_error; ?></div>
                <?php }
                elseif(!empty($edit_success)){ ?>
                <div class="alert alert-success" role="alert"> <?php echo $edit_success; ?></div>
                <?php } ?>
                <p class="lead p-1"> Configuration RCON</p>
                <div class="p-3"
                    <p class="strong"> Serveur : <?= $server['address']; ?></p>
                    <p class="strong"> Ports : <?= $server['ports']; ?></p>
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target=".bd-example-modal-lg">Modifier</button>
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content p-4">
                            <h5>Modification des informations RCon :</h5>
                            <form method='POST' action="configuration.php">
                                <div class="form-group">
                                    <label for="addressip">Adresse IP </label>
                                    <input <input type="text" minlength="7" maxlength="15" size="15" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" class="form-control" name="addressip" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="ports">Ports</label>
                                    <input <input type="number" name="ports" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="passwords">Mot de passe</label>
                                    <input <input type="password" class="form-control" name="passwords" placeholder="">
                                </div>
                                <button type="submit" name="modifier" class="btn btn-lg btn-success mb-2">Sauvegarder</button> 
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>