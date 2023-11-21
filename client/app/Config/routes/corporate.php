<?php 
$checkAuth = ['filter' => 'authGuard'];
$dir = ['Corporate','corporate'];
$routes->get($dir[1],$dir[0].'\Dashboard::index',$checkAuth);