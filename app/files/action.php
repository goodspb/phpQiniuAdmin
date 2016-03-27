<?php
use Qiniu\Storage\BucketManager;

$bucketMgr = new BucketManager($qiniuAuth);

$do = fnGet($vars, 'do');
$key = base64_decode(fnGet($vars, 'key'));
$bucket = cookie('default_bucket');

//删除单个
if ($do == 'del') {

    $err = $bucketMgr->delete($bucket, $key);
    if ($err !== null) {
        alert($err->message(),'/files');
    } else {
        alert('删除成功!','/files');
    }

//更新单个文件
} elseif ($do == 'refresh') {

    $err = $bucketMgr->prefetch($bucket, $key);
    if ($err !== null) {
        alert($err->message(),'/files');
    } else {
        alert('刷新成功!','/files');
    }

}
