<?php

$id = fnGet($vars, 'id');
cookie('default_bucket', $id);
redirect('/files');
