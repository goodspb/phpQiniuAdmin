<?php

if ($adminUsername != fnGet($_POST, 'username') || $adminPassword != fnGet($_POST, 'password')) {
    redirect('/login/error/账号密码错误');
}

session('username', $adminUsername);
redirect('/index');
