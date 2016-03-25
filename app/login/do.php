<?php

$adminUsername = fnGet($config,'admin_username');
$adminPassword = fnGet($config,'admin_password');

if ($adminUsername === null || $adminUsername != fnGet($_POST, 'username')
    || $adminPassword === null || $adminPassword != fnGet($_POST, 'password')
) {
    redirect('/login');
}

session('username', $adminUsername);
redirect('/index');
