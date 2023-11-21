<?php

$Guard = ['filter' => 'authGuard'];
$dir = 'salespeople';

$routes->get("/$dir","admin\Dashboard::index", $Guard); 

$routes->get("/$dir/tickets","$dir\Tickets::index", $Guard);
$routes->get("/$dir/tickets/(:any)","$dir\Tickets::$1", $Guard);
$routes->post("/$dir/tickets/(:any)","$dir\Tickets::$1", $Guard);

$routes->get("/$dir/scorecards","$dir\Scorecards::index", $Guard);
$routes->get("/$dir/scorecards/card/(:any)","admin\Scorecards::card/$1", $Guard);
$routes->get("/$dir/scorecards/(:any)","$dir\Scorecards::$1", $Guard);

$routes->get("/observations","admin\Observations::index", $Guard);
$routes->get("/$dir/observations/find","admin\Observations::find", $Guard);
$routes->get("/$dir/observations/(:any)","admin\Observations::manage/$1", $Guard);

$routes->get("/connections","admin\Connections::index", $Guard);
$routes->get("/$dir/connections/find","admin\Connections::find", $Guard);
$routes->get("/$dir/connections/(:any)","admin\Connections::manage/$1", $Guard);

$routes->get("/corrective-actions", "admin\FormBuilder::collection/21", $Guard);
$routes->get("/corrective-actions/collect", "admin\FormBuilder::collect/21", $Guard);
$routes->get("/corrective-actions/(:any)", "admin\FormBuilder::view/$1", $Guard);

$routes->get("/performance-improvement-plan", "admin\FormBuilder::collection/25", $Guard);
$routes->get("/performance-improvement-plan/collect", "admin\FormBuilder::collect/25", $Guard);
$routes->get("/performance-improvement-plan/(:any)", "admin\FormBuilder::view/$1", $Guard);