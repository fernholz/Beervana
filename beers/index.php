<?php

ini_set('display_errors', 0);

require __DIR__.'/../src/user.class.php';
require __DIR__.'/../src/jsonUserPersister.class.php';

use Beervana\JsonUserPersister;
use Beervana\User;

$host  = $_SERVER['HTTP_HOST'];

if($_GET['username'] && $_GET['email'] && $_GET['password']) {

    $beers = file_get_contents(__DIR__.'/../storage/beers/beers.json');
    $beers = json_decode($beers);

    $attributes = array(
        "username" => strtolower($_GET['username']),
        "password" => $_GET['password'],
        "email" => $_GET['email'],
        "beers" => $beers
    );
    $user = new User($attributes);

    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

    $persister = new JsonUserPersister(__DIR__.'/../storage/users');
    if($persister->checkUserUnique($attributes['username'])) {
        $persister->persist($user);
        header("Location: http://$host$uri?username=".$attributes['username'].'&loggedin=true');
    }
    else if($persister->checkUserExists($attributes['username'], $attributes['password'])) {
        header("Location: http://$host$uri?username=".$attributes['username'].'&loggedin=true');
    }
    else {
        header("Location: http://$host?error=User Exists");
    }
}
else if($_GET['username'] && $_GET['loggedin']) {
    $userData = file_get_contents(__DIR__."/../storage/users/".strtolower($_GET['username']).".json");
    $userData = json_decode($userData, true);

?>
    <html>
    <head>
        <title>Beervana Tracker 2013</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />

        <!-- Bootstrap -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="../assets/css/style.css" rel="stylesheet" media="screen">
        <link href="../assets/css/add2home.css" rel="stylesheet" media="screen">

        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="../assets/img/apple-icon-57x57-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/img/apple-icon-72x72-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/img/apple-icon-114x114-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/img/apple-icon-144x144-precomposed.png" />
        <!-- iPhone -->
        <link href="../assets/img/apple-touch-startup-image-320x460.png"
              media="(device-width: 320px) and (device-height: 480px)
                 and (-webkit-device-pixel-ratio: 1)"
              rel="apple-touch-startup-image">

        <!-- iPhone (Retina) -->
        <link href="../assets/img/apple-touch-startup-image-640x920.png"
              media="(device-width: 320px) and (device-height: 480px)
                 and (-webkit-device-pixel-ratio: 2)"
              rel="apple-touch-startup-image">

        <!-- iPhone 5 -->
        <link href="../assets/img/apple-touch-startup-image-640x1096.png"
              media="(device-width: 320px) and (device-height: 568px)
                 and (-webkit-device-pixel-ratio: 2)"
              rel="apple-touch-startup-image">

    </head>
    <body>
        <div id="statusbar-shim"></div>
        <div id="wrap">
            <div id="header">
                <div class="container">
                    <h1 class="site-title">Beervana 2013</h1>
                </div>
            </div>
            <div class="container">
<?php

    foreach($userData['beers'] as $beerLocation => $beers) {
        echo '<div class="panel panel-primary">';
        echo "<div class='beer-location panel-heading'>" . $beerLocation . "<span class='glyphicon glyphicon-circle-arrow-down toggle-beer-location pull-right'></span></div>";
        echo "<ul class='beer-list list-group' style='display:none'>";
        foreach($beers as $beer) {
            $checked = "";
            if($beer['checked']) {
                $checked = "checked";
            }

            echo "<li class='list-group-item'>";

            echo "<div class='row'>";
            echo "<div class='container'>";
            echo "<div class='pull-left'><label><input type='checkbox' value='".$beer['id']."' name='checked_".$beer['id']."' ".$checked."/><strong>Drank this</strong></label></div>";
            echo "<label class='pull-right'><strong>Rating: </strong><select class='form-control input-sm' name='rating_".$beer['id']."'>";
            $rating = false;
            if($beer['rating']) {
                $rating = $beer['rating'];
            }
            for($i = 1; $i < 6; $i++) {
                $selected = '';
                if($i == $rating){
                    $selected = "selected='selected'";
                }
                echo "<option value='".$i."'". $selected.">".$i."</option>";
            }
            echo "</select></label>";
            echo "</div>";
            echo "</div>";
            echo "<h3 class='clearfix'>" . $beer['info'] . "</h3>";
            echo "<textarea class='form-control' rows='2' name='notes_".$beer['id']."' placeholder='My thoughts...'>";
            if($beer['notes']) {
                echo $beer['notes'];
            }
            echo "</textarea>";

            echo "</li>";
        }
        echo "</ul>";
        echo '</div>';
    }
?>
            </div>
        </div>

        <div id="footer">
            <div class="container">
                <p class="text-muted credit">
                    Site brewed up by <a href="http://twitter.com/fernholz" target="_blank">Derek Fernholz</a>.
                </p>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//code.jquery.com/jquery.js"></script>
        <script src="../assets/js/main.js"></script>
        <script src="../assets/js/add2home.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
<!--        <script src="../../assets/js/bootstrap.min.js"></script>-->
    </body>
    </html>
<?php
}
else {
    header("Location: http://$host?error=Required Fields");
}

