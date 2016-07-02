<?php include ROOT_PATH.'/app/public/header.php'; ?>
<div id="wrapper">

    <?php include ROOT_PATH.'/app/public/nav.php'; ?>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">密钥管理</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        密钥列表
                    </div>
                    <!-- /.panel-heading -->
                    <?php
                        $keys = cookie('keys');
                        $keys = $keys == null ? array() : $keys;
                        $defaultKeyId = cookie('default_key');
                    ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>名称</th>
                                    <th>AccessKey</th>
                                    <th>SecretKey</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (empty($keys)): ?>
                                    <tr>
                                        <td colspan="5">暂无</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($keys as $id => $key): ?>
                                        <tr>
                                            <td><?=$id+1?></td>
                                            <td><?=$key['name']?><?php if ($defaultKeyId == $id) { echo ' [默认]'; } ?></td>
                                            <td><?=$key['access_key']?></td>
                                            <td><?=$key['secret_key']?></td>
                                            <td>
                                                <a href="/key/<?=$id?>">修改</a>&nbsp;&nbsp;
                                                <a href="/key/do/default/<?=$id?>">设置默认</a>&nbsp;&nbsp;
                                                <a href="/key/do/del/<?=$id?>">删除</a>&nbsp;&nbsp;
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
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        添加/修改
                    </div>
                    <!-- /.panel-heading -->
                    <?php
                        $id = fnGet($vars, 'id', -1);
                        $key = getKeys($id);
                    ?>
                    <div class="panel-body">
                        <form role="form" method="POST" action="/key/do/add">
                            <input type="hidden" name="id" value="<?=!is_null($key)?$id:-1?>" />
                            <div class="form-group">
                                <label>名称</label>
                                <input title="bucket name" class="form-control" type="text" name="name" value="<?=fnGet($key, 'name', '')?>">
                            </div>
                            <div class="form-group">
                                <label>AccessKey</label>
                                <input title="bucket name" class="form-control" type="text" name="access_key" value="<?=fnGet($key, 'access_key', '')?>">
                            </div>
                            <div class="form-group">
                                <label>SecretKey</label>
                                <input title="bucket url" class="form-control" type="text" name="secret_key" value="<?=fnGet($key, 'secret_key', '')?>">
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
