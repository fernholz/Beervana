<?php

$username = $_POST['username'];
$updated = $_POST['updated'];
$value = $_POST['value'];
$beerLocation = $_POST['beerLocation'];

$user = file_get_contents(__DIR__.'/../storage/users/'.$username.'.json');
if($user) {
    $user = json_decode($user, true);
    foreach($user['beers'] as $location => $beers) {
        if($location !== $beerLocation) {
            continue;
        }

        $parts = explode('_', $updated);
        $attribute = $parts[0];
        $id = $parts[1];

        foreach($beers as $i => $beer) {
            if($beer['id'] != $id){
                continue;
            }
            $user['beers'][$location][$i][$attribute] = $value;
            break;
        }
        break;
    }

    $user = json_encode($user);
    $filename = __DIR__.'/../storage/users/'.$username.'.json';
    file_put_contents($filename, $user, LOCK_EX);

    echo 'true';
}

echo 'false';