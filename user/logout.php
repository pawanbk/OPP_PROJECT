<?php
require_once '../core/init.php';
$u->logout();
Redirect::to($config['path']['p1']);