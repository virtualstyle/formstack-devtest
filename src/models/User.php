<?php

namespace Virtualstyle\FormstackDevtest;

interface User
{
    public function getId();

    public function setUsername(String $username);
    public function getUsername();

    public function setFirstname(String $firstname);
    public function getFirstname();

    public function setLastname(String $lastname);
    public function getLastname();

    public function setEmail(String $email);
    public function getEmail();

    public function setPassword(String $password);
}
