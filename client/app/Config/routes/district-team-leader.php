<?php 
$Guard = ['filter' => 'DTLGuard'];
$dir = 'DistrictTeamLeader';
$base = '/district-team-leader';

$routes->get($base,'admin\Dashboard::index',$Guard);
$routes->get("/$base/scorecards","admin\Scorecards::index", $Guard);
$routes->get("/$base/scorecards/(:any)","admin\Scorecards::$1", $Guard);

$routes->get("$base/employees","$dir\Employees::index", $Guard);
$routes->get("$base/employees/find","$dir\Employees::find", $Guard);
$routes->get("$base/employees/(:any)","$dir\Employees::manage/$1", $Guard);

$routes->get("/$base/scorecards","$dir\Scorecards::index", $Guard);
$routes->get("/$base/scorecards/(:any)","$dir\Scorecards::$1", $Guard);


$routes->get("/$base/reports/department", "admin\Reports\Departments::index");
$routes->get("/$base/reports/department/(:any)", "admin\Reports\Departments::index/$1");


$routes->get("/$base/reports/obsolete", "admin\Reports\Obsolete::index", $Guard);
$routes->get("/$base/reports/obsolete/(:any)", "admin\Reports\Obsolete::$1", $Guard);

$routes->get("/$base/reports/eol", "admin\Reports\EOL::index", $Guard);
$routes->get("/$base/reports/eol/(:any)", "admin\Reports\EOL::$1", $Guard);


$routes->get("/$base/reports/non-sellable", "admin\Reports\NonSellables::index", $Guard);
$routes->get("/$base/reports/non-sellable/(:any)", "admin\Reports\NonSellables::$1", $Guard);

$routes->get("/$base/reports/rlo", "admin\Reports\RLO::index", $Guard);
$routes->get("/$base/reports/rlo/(:any)", "admin\Reports\RLO::$1", $Guard);

$routes->get("/$base/reports/product-note", "admin\Reports\ProductNote::index", $Guard);
$routes->get("/$base/reports/product-note/(:any)", "admin\Reports\ProductNote::$1", $Guard);

$routes->get("/$base/reports/hyla", "admin\Reports\Hyla::index", $Guard);
$routes->get("/$base/reports/hyla/(:any)", "admin\Reports\Hyla::$1", $Guard);

$routes->get("/$base/reports/doors", "admin\Reports\Doors::index", $Guard);
$routes->get("/$base/reports/doors/(:any)", "admin\Reports\Doors::$1", $Guard);

$routes->get("/$base/reports/cash-deposits", "admin\Reports\CashDeposits::index", $Guard);
$routes->get("/$base/reports/cash-deposits/(:any)", "admin\Reports\CashDeposits::$1", $Guard);

$routes->get("/$base/reports/bi", "admin\Reports\BiReports::index", $Guard);
$routes->get("/$base/reports/bi/(:any)", "admin\Reports\BiReports::$1", $Guard);

$routes->get("/$base/reports/surveillance", "admin\Reports\Surveillance::index", $Guard);
$routes->get("/$base/reports/surveillance/(:any)", "admin\Reports\Surveillance::$1", $Guard);


$routes->get("/$base/observations","admin\Observations::index", $Guard);
$routes->get("/$base/observations/find","admin\Observations::find", $Guard);
$routes->get("/$base/observations/(:any)","admin\Observations::manage/$1", $Guard);
$routes->post("/$base/observations/(:any)","admin\Observations::manage/$1", $Guard);

$routes->get("/$base/connections","admin\Connections::index", $Guard);
$routes->get("/$base/connections/find","admin\Connections::find", $Guard);
$routes->get("/$base/connections/(:any)","admin\Connections::manage/$1", $Guard);
$routes->post("/$base/connections/(:any)","admin\Connections::manage/$1", $Guard);

$routes->get("/$base/api/question/observation", "admin\Apis::question/observation",$Guard);
$routes->get("/$base/api/question/connections", "admin\Apis::question/connections",$Guard);

$routes->get("/$base/corrective-actions", "admin\FormBuilder::collection/21", $Guard);
$routes->get("/$base/corrective-actions/collect", "admin\FormBuilder::collect/21", $Guard);
$routes->get("/$base/corrective-actions/(:any)", "admin\FormBuilder::view/$1", $Guard);

$routes->get("/$base/performance-improvement-plan", "admin\FormBuilder::collection/25", $Guard);
$routes->get("/$base/performance-improvement-plan/collect", "admin\FormBuilder::collect/25", $Guard);
$routes->get("/$base/performance-improvement-plan/(:any)", "admin\FormBuilder::view/$1", $Guard);