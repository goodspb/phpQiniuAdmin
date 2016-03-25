<?php
$do = fnGet($vars, 'do');

$buckets = cookie('buckets');
$buckets = $buckets == null ? array() : unserialize($buckets);

if ($do == 'add') {
    if (($bucketname = fnGet($_POST, 'bucketname')) != null) {
        $buckets[] = $bucketname;
    }
} elseif ($do == 'del') {
    $id = fnGet($vars, 'id');
    if ($buckets[$id] == cookie('default_bucket')) {
        $re = cookie('default_bucket', null);
    }
    unset($buckets[$id]);
    $buckets = array_values($buckets);
} elseif ($do == 'default') {
    $id = fnGet($vars, 'id');
    cookie('default_bucket', $buckets[$id]);
}

//设置默认的bucket
if (cookie('default_bucket') == null && !empty($buckets)) {
    cookie('default_bucket', $buckets[0]);
}

cookie('buckets', serialize($buckets));
redirect('/index');
