<?php 
$checkAuth = ['filter' => 'authGuard'];
$dir = ['FullAccess','full-access'];
$routes->get($dir[1],$dir[0].'\Dashboard::index',$checkAuth);