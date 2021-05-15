<?php
require_once '../core/init.php';
$u->logout();
Redirect::to($config['base_url'].'index.php');