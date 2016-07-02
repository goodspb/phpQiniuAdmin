<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="/key"><i class="fa fa-table fa-fw"></i>密钥管理</a>
            </li>
            <li>
                <a href="/index"><i class="fa fa-table fa-fw"></i>仓库管理</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-table fa-fw"></i>资源列表 <span class="fa arrow"></span></a>
                <?php
                    $buckets = getBuckets();
                ?>
                <ul class="nav nav-second-level in">
                    <?php foreach ($buckets as $id => $bucket): ?>
                    <li>
                        <a href="/files/id/<?=$id?>"><?=$bucket['name']?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
