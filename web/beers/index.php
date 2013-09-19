<?php

ini_set('display_errors', 0);

require __DIR__.'/../../src/user.class.php';
require __DIR__.'/../../src/jsonUserPersister.class.php';

use Beervana\JsonUserPersister;
use Beervana\User;

if($_GET['username'] && $_GET['email']) {

    $beers = file_get_contents(__DIR__.'/../../storage/beers/beers.json');
    $beers = json_decode($beers);

    $attributes = array(
        "username" => $_GET['username'],
        "email" => $_GET['email'],
        "beers" => $beers
    );
    $user = new User($attributes);

    $persister = new JsonUserPersister(__DIR__.'/../../storage/users');
    $persister->persist($user);

    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri?username=".$attributes['username']);
}

if($_GET['username']) {
    $userData = file_get_contents(__DIR__."/../../storage/users/".$_GET['username'].".json");
    $userData = json_decode($userData, true);
    //print_r($userData);

?>
    <html>
    <head>
        <title>Beervana Tracker 2013</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="../../assets/css/style.css" rel="stylesheet" media="screen">

    </head>
    <body>

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
        echo "<div class='beer-location panel-heading'>" . $beerLocation . "</div>";
        echo "<ul class='beer-list list-group'>";
        foreach($beers as $beer) {
            $checked = "";
            if($beer['checked']) {
                $checked = "checked";
            }

            echo "<li class='list-group-item'>";

            echo "<div class='row'>";
            echo "<div class='container'>";
            echo "<div class='checkbox pull-left'><label><input type='checkbox' value='".$beer."' name='checked_".$beer."' ".$checked."/><strong>Drank this</strong></label></div>";
            echo "<label class='pull-right'><strong>Rating: </strong><select class='form-control' name='rating_".$beer."'>";
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
            echo "<textarea class='form-control' rows='2' name='notes_'".$beer."' placeholder='My thoughts...'>";
            if($beer['notes']) {
                echo $beer['notes'];
            }
            echo "</textarea>";

            echo "</li>";
        }
        echo "</ul>";
        echo '</div>';
    }
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
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../../assets/js/bootstrap.min.js"></script>
    </body>
    </html>