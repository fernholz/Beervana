<?php

namespace Beervana;

class User
{
    public $username;
    public $attributes = array(
        "username",
        "password",
        "email",
        "beers"
    );

    public function __construct ($attributes) {
        $this->username = $attributes['username'];
        $this->setAttributes($attributes);
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function setAttributes($attributes) {
        $this->attributes = $attributes;
    }
}