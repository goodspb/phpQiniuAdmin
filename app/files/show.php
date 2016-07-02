<?php include ROOT_PATH.'/app/public/header.php'; ?>
<div id="wrapper">

    <?php include ROOT_PATH.'/app/public/nav.php'; ?>

    <div id="page-wrapper">
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12" style="margin-top: 10px">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        文件详情
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <h4><?php echo $key = base64_decode(fnGet($vars, 'key')) ?></h4>
                            <?php
                            use Qiniu\Storage\BucketManager;
                            $bucketMgr = new BucketManager($qiniuAuth);
                            // 要列取的空间名称
                            $bucket = getDefaultBucket('name');

                            //获取文件的状态信息
                            list($ret, $err) = $bucketMgr->stat($bucket, $key);
                            if ($err !== null) {
                                echo "<div class=\"alert alert-danger\">".$err->message()."</div>";
                            } else {
                            ?>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Key</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <?php
                                            foreach ($ret as $key=>$value) {
                                                if ($key == 'putTime') {
                                                    $value = date('Y-m-d H:i',intval($value/10000000));
                                                }
                                                echo "<tr><td>$key</td><td>$value</td></tr>";
                                            }
                                        ?>
                                    </tr>
                                    </tbody>
                                </table>
                            <?php
                            }
                            ?>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include ROOT_PATH.'/app/public/footer.php'; ?>

