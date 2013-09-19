<?php

namespace Beervana;

use Beervana\User;

class JsonUserPersister
{
    private $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function persist(User $user)
    {
        $data = $user->getAttributes();
        $json = json_encode($data);
        $filename = $this->basePath.'/'.$user->username.'.json';
        file_put_contents($filename, $json, LOCK_EX);
        return true;
    }

    public function checkUserUnique($username) {
        $filename = $this->basePath.'/'.$username.'.json';
        if(file_exists($filename)) {
            return false;
        }
        return true;
    }

    public function checkUserExists($username, $password) {
        $filename = $this->basePath.'/'.$username.'.json';
        $user = file_get_contents($filename);
        $user = json_decode($user, true);

        if($user && $user['password'] == $password) {
            return true;
        }
        return false;
    }
}