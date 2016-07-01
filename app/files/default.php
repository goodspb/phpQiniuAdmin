<?php include ROOT_PATH.'/app/public/header.php'; ?>
<div id="wrapper">

    <?php include ROOT_PATH.'/app/public/nav.php'; ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12" style="margin-top: 10px">
                <form class="input-group custom-search-form" action="" method="get">
                    <input  type="text" name="prefix" value="<?php echo fnGet($_GET, 'prefix', ''); ?>" class="form-control" placeholder="请输入前缀...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </form>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12" style="margin-top: 10px">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        七牛资源列表
                        <button class="btn-danger pull-right" onclick="location.href='/files/refresh';">刷新全部</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <?php
                            use Qiniu\Storage\BucketManager;
                            $bucketMgr = new BucketManager($qiniuAuth);
                            // 要列取的空间名称
                            $bucket = cookie('default_bucket');
                            // 要列取文件的公共前缀
                            $prefix = fnGet($_REQUEST, 'prefix', '');
                            $marker = ($newMarker = fnGet($vars,'marker')) !== null ? $newMarker :  '';
                            $limit = 20;

                            list($iterms, $marker, $err) = $bucketMgr->listFiles($bucket, $prefix, $marker, $limit);
                            if ($err !== null) {
                                echo "<div class=\"alert alert-danger\">".$err->message()."</div>";
                            } else {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>key</th>
                                    <th>hash</th>
                                    <th>fsize</th>
                                    <th>mimeType</th>
                                    <th>putTime</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if($iterms):
                                        foreach($iterms as $key => $value): ?>
                                    <tr class="odd gradeA">
                                        <td><?=$key+1?></td>
                                        <td><?=$value['key']?></td>
                                        <td><?=$value['hash']?></td>
                                        <td><?=$value['fsize']?></td>
                                        <td class="center"><?=$value['mimeType']?></td>
                                        <td class="center"><?=date('Y-m-d H:i',intval($value['putTime']/10000000))?></td>
                                        <td class="center">
                                            <a href="/files/show/<?=base64_encode($value['key'])?>">查看</a>&nbsp;&nbsp;
                                            <a href="/files/action/refresh/<?=base64_encode($value['key'])?>">刷新</a>&nbsp;&nbsp;
                                            <a href="/files/action/del/<?=base64_encode($value['key'])?>">删除</a>&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else:?>
                                    <tr>
                                        <td colspan="7">暂无资源</td>
                                    </tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                            <?php if($iterms && !empty($marker) ): ?>
                            <div class="well">
                                <a class="btn btn-default btn-lg btn-block" href="/files/<?=$marker?>">下一页</a>
                            </div>
                            <?php endif; ?>
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
