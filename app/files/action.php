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

} elseif ($do == 'refresh') {

    $err = $bucketMgr->prefetch($bucket, $key);
    if ($err !== null) {
        alert($err->message(),'/files');
    } else {
        alert('刷新成功!','/files');
    }

} elseif ($do == 'all_refresh') {

    include  ROOT_PATH.'/app/public/header.php';

    echo "<div id=\"wrapper\">";
    include ROOT_PATH.'/app/public/nav.php';
    echo <<<EOF
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
EOF;

    set_time_limit(3600);

    $prefix = '';
    $marker = '';
    echo "<h2 class=\"page-header\">Start refresh</h2>";
    do {
        list($iterms, $marker, $err) = $bucketMgr->listFiles($bucket, $prefix, $marker);
        if ($err !== null) {
            echo 'error :'.$err->message();
            exit();
        } else {
            foreach($iterms as $key => $value ) {
                echo 'refresh file '.$value['key'].' : ';
                $delErr = $bucketMgr->prefetch($bucket, $value['key']);
                if ($delErr !== null) {
                    echo ' fail , error : '.$delErr->message();
                } else {
                    echo ' success ';
                }
                echo "<br>";
            }
        }
    } while($marker!='');
    echo "<h2 class=\"page-header\">end refresh</h2>";

    echo <<<EOF
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
EOF;
    include  ROOT_PATH.'/app/public/footer.php';

}
