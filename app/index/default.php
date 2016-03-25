<?php include ROOT_PATH.'/app/public/header.php'; ?>
<div id="wrapper">

    <?php include ROOT_PATH.'/app/public/nav.php'; ?>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">仓库管理</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        仓库列表
                    </div>
                    <!-- /.panel-heading -->
                    <?php
                        $buckets = cookie('buckets');
                        $buckets = $buckets == null ? array() : unserialize($buckets);
                    ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>仓库名</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (empty($buckets)): ?>
                                    <tr>
                                        <td colspan="3">暂无</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($buckets as $key => $bucket): ?>
                                        <tr>
                                            <td><?=$key+1?></td>
                                            <td><?=$bucket?><?php if (cookie('default_bucket') == $bucket) { echo ' [默认]'; } ?></td>
                                            <td>
                                                <a href="/bucket/del/<?=$key?>">删除</a>&nbsp;&nbsp;
                                                <a href="/bucket/default/<?=$key?>">设置默认</a>&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Basic Table
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <form role="form" method="POST" action="/bucket/add">
                            <div class="form-group">
                                <label>仓库名</label>
                                <input class="form-control" type="text" name="bucketname">
                                <p class="help-block">填写七牛后台的 bucket name</p>
                            </div>
                            <button type="submit" class="btn btn-default">提交</button>
                            <button type="reset" class="btn btn-default">重置</button>
                        </form>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include ROOT_PATH.'/app/public/footer.php'; ?>
