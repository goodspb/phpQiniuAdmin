<?php

$permissionExclude = array(
    'login'
);

$adminUsername = fnGet($config,'admin_username');
$adminPassword = fnGet($config,'admin_password');

if (!in_array($dir,$permissionExclude) && session('username') == null) {

    //配置为空时
    if ($adminUsername == '' && $adminPassword == '') {
        session('username', true);
    }
    redirect('/login');

}
