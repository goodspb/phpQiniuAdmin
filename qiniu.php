<?php
use Qiniu\Auth;

$accessKey = fnGet($config, 'access_key');
$secretKey = fnGet($config, 'secret_key');
$qiniuAuth = new Auth($accessKey, $secretKey);
