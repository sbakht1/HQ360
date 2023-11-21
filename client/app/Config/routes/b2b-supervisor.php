<?php 
$checkAuth = ['filter' => 'authGuard'];
$dir = ['B2bSupervisor','b2b-supervisor'];
$routes->get($dir[1],$dir[0].'\Dashboard::index',$checkAuth);