<?php
use Qiniu\Auth;

$defaultKey = getDefaultKey();
$accessKey = fnGet($defaultKey, 'access_key');
$secretKey = fnGet($defaultKey, 'secret_key');
$qiniuAuth = new Auth($accessKey, $secretKey);
