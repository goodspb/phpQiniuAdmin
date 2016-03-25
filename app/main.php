<?php
if (session('username') == null) {
    redirect('/login');
}
redirect('/index');
