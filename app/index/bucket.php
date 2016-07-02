<?php
$do = fnGet($vars, 'do');

$buckets = getBuckets();

if ($do == 'add') {
    $bucket = [];
    if (($bucketname = fnGet($_POST, 'bucketname')) != null) {
        $bucket['name'] = $bucketname;
    }
    if (!is_null($bucketUrl = fnGet($_POST, 'bucketurl'))) {
        $bucket['url'] = $bucketUrl;
    }
    if (($key = fnGet($_POST, 'key')) != -1) {
        $buckets[$key] = $bucket;
    } else {
        $buckets[] = $bucket;
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
    cookie('default_bucket', $id);
}

//设置默认的bucket
if (cookie('default_bucket') == null && !empty($buckets)) {
    cookie('default_bucket', 0);
}

cookie('buckets', $buckets);
redirect('/index');
