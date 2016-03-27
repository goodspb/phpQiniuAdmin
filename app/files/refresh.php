<?php
include  ROOT_PATH.'/app/public/header.php';
set_time_limit(1000);
use Qiniu\Storage\BucketManager;
$bucketMgr = new BucketManager($qiniuAuth);
$bucket = cookie('default_bucket');
$prefix = '';
$marker = ($varMarker = fnGet($vars,'marker')) == null ? '' : $varMarker;
?>

<div id=\"wrapper\">
    <?php include ROOT_PATH.'/app/public/nav.php';?>

    <div id="wrapper">
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                        <?php

                        if ($marker == 'end') {
                            echo '<h2 class="page-header">end refreshing!</h2>';
                        } else {
                            echo '<h2 class="page-header">refreshing, please wait...</h2>';

                            list($iterms, $marker, $err) = $bucketMgr->listFiles($bucket, $prefix, $marker,20);
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
                            echo '<script>location.href="/files/refresh/'.($marker==''?'end':$marker).'";</script>';
                        }

                        ?>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>

<?php include  ROOT_PATH.'/app/public/footer.php'; ?>
