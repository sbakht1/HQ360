<?php 
$Guard = ['filter' => 'ITGuard'];
$slug = 'it';
$dir = 'IT';

// $routes->get($slug,$dir.'\Dashboard::index',$Guard);
$routes->get("/$slug","admin\Dashboard::index", $Guard); 

$routes->get("/$slug/stores", 'admin\Stores::index',$Guard);
$routes->get("/$slug/stores/(:any)", 'admin\Stores::manage/$1',$Guard);


$routes->get("/$slug/employees","admin\Employees::index", $Guard);
$routes->get("/$slug/employees/(:any)","admin\Employees::manage/$1", $Guard);


$routes->get("/$slug/compliance","admin\Compliance::index", $Guard);
$routes->get("/$slug/compliance/(:any)","admin\Compliance::manage/$1", $Guard);

$routes->get("/$slug/observations","admin\Observations::index", $Guard);
$routes->get("/$slug/observations/(:any)","admin\Observations::manage/$1", $Guard);

$routes->get("/$slug/connections","admin\Connections::index", $Guard);
$routes->get("/$slug/connections/(:any)","admin\Connections::manage/$1", $Guard);

$routes->get("/$slug/form-builder","admin\FormBuilder::index", $Guard);
$routes->get("/$slug/form-builder/m/(:any)","admin\FormBuilder::manage/$1", $Guard);
$routes->post("/$slug/form-builder/m/(:any)","admin\FormBuilder::manage/$1", $Guard);
$routes->get("/$slug/form-builder/(:any)","admin\FormBuilder::$1", $Guard);
$routes->post("/$slug/form-builder/(:any)","admin\FormBuilder::$1", $Guard);

$routes->get("/$slug/scorecards","admin\Scorecards::index", $Guard);
$routes->get("/$slug/scorecards/(:any)","admin\Scorecards::$1", $Guard);

// Reports
$routes->get("/$slug/reports/department", "admin\Reports\Departments::index",$Guard);
$routes->get("/$slug/reports/department/(:any)", "admin\Reports\Departments::index/$1",$Guard);


$routes->get("/$slug/reports/obsolete", "admin\Reports\Obsolete::index", $Guard);
$routes->get("/$slug/reports/obsolete/(:any)", "admin\Reports\Obsolete::$1", $Guard);

$routes->get("/$slug/reports/eol", "admin\Reports\EOL::index", $Guard);
$routes->get("/$slug/reports/eol/(:any)", "admin\Reports\EOL::$1", $Guard);


$routes->get("/$slug/reports/non-sellable", "admin\Reports\NonSellables::index", $Guard);
$routes->get("/$slug/reports/non-sellable/(:any)", "admin\Reports\NonSellables::$1", $Guard);


$routes->get("/$slug/reports/rlo", "admin\Reports\RLO::index", $Guard);
$routes->get("/$slug/reports/rlo/(:any)", "admin\Reports\RLO::$1", $Guard);

$routes->get("/$slug/reports/product-note", "admin\Reports\ProductNote::index", $Guard);
$routes->get("/$slug/reports/product-note/(:any)", "admin\Reports\ProductNote::$1", $Guard);

$routes->get("/$slug/reports/hyla", "admin\Reports\Hyla::index", $Guard);
$routes->get("/$slug/reports/hyla/(:any)", "admin\Reports\Hyla::$1", $Guard);

$routes->get("/$slug/reports/doors", "admin\Reports\Doors::index", $Guard);
$routes->get("/$slug/reports/doors/(:any)", "admin\Reports\Doors::$1", $Guard);

$routes->get("/$slug/reports/cash-deposits", "admin\Reports\CashDeposits::index", $Guard);
$routes->get("/$slug/reports/cash-deposits/(:any)", "admin\Reports\CashDeposits::$1", $Guard);

$routes->get("/$slug/reports/bi", "admin\Reports\BiReports::index", $Guard);
$routes->get("/$slug/reports/bi/(:any)", "admin\Reports\BiReports::$1", $Guard);

$routes->get("/$slug/reports/surveillance", "admin\Reports\Surveillance::index", $Guard);
$routes->get("/$slug/reports/surveillance/(:any)", "admin\Reports\Surveillance::$1", $Guard);

$routes->get("/$slug/articles", "admin\Articles::index",$Guard);
$routes->get("/$slug/articles/(:any)", "admin\Articles::$1",$Guard);
$routes->post("/$slug/articles/(:any)", "admin\Articles::$1",$Guard);

$routes->get("/$slug/urgent", "admin\Urgents::index",$Guard);
$routes->get("/$slug/urgent/(:any)", "admin\Urgents::$1",$Guard);
$routes->post("/$slug/urgent/(:any)", "admin\Urgents::$1",$Guard);

// apis
$routes->get("/$slug/api/employees", "admin\Apis::employees",$Guard);
$routes->get("/$slug/api/employees/(:any)", "admin\Apis::employees/$1",$Guard);

$routes->get("/$slug/api/stores", "admin\Apis::stores",$Guard);
$routes->get("/$slug/api/(:any)", "admin\Apis::$1",$Guard);
$routes->get("/$slug/api/(:any)/(:any)", "admin\Apis::$1/$2",$Guard);