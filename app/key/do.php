<?php
$type = fnGet($vars, 'type');

$keys = getKeys();

if ($type == 'add') {
    $key = [];
    if (($name = fnGet($_POST, 'name')) != null) {
        $key['name'] = $name;
    }
    if (!is_null($accessKey = fnGet($_POST, 'access_key'))) {
        $key['access_key'] = $accessKey;
    }
    if (!is_null($secretKey = fnGet($_POST, 'secret_key'))) {
        $key['secret_key'] = $secretKey;
    }
    if (($id = fnGet($_POST, 'id')) != -1) {
        $keys[$id] = $key;
    } else {
        $keys[] = $key;
    }
} elseif ($type == 'del') {
    $id = fnGet($vars, 'id');
    if ($keys[$id] == cookie('default_key')) {
        $re = cookie('default_key', null);
    }
    unset($keys[$id]);
    $keys = array_values($keys);
} elseif ($type == 'default') {
    $id = fnGet($vars, 'id');
    cookie('default_key', $id);
}

//设置默认的bucket
if (cookie('default_key') == null && !empty($keys)) {
    cookie('default_key', 0);
}

cookie('keys', $keys);
redirect('/key');
