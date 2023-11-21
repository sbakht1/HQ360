<?php 
$HRGuard = ['filter' => 'HRGuard'];
$slug = 'human-resource';
$dir = 'HumanResource';

// $routes->get($slug,$dir.'\Dashboard::index',$HRGuard);
$routes->get("/$slug","admin\Dashboard::index", $HRGuard); 

$routes->get("/$slug/stores", 'admin\Stores::index',$HRGuard);
$routes->get("/$slug/stores/(:any)", 'admin\Stores::manage/$1',$HRGuard);


$routes->get("/$slug/employees","admin\Employees::index", $HRGuard);
$routes->get("/$slug/employees/(:any)","admin\Employees::manage/$1", $HRGuard);
$routes->post("/$slug/employees/(:num)","admin\Employees::manage/$1", $HRGuard);
$routes->post("/$slug/employees/new","admin\Employees::manage/new", $HRGuard);
$routes->post("/$slug/employees/upload","admin\Employees::upload", $HRGuard);

$routes->post("/$slug/stores/import",'admin\Stores::import',$HRGuard);
$routes->post("/$slug/stores/(:any)",'admin\Stores::update/$1',$HRGuard);


$routes->get("/$slug/compliance","admin\Compliance::index", $HRGuard);
$routes->get("/$slug/compliance/(:any)","admin\Compliance::manage/$1", $HRGuard);
$routes->post("/$slug/compliance/import","admin\compliance::import", $HRGuard);

$routes->get("/$slug/observations","admin\Observations::index", $HRGuard);
$routes->get("/$slug/observations/(:any)","admin\Observations::manage/$1", $HRGuard);
$routes->post("/$slug/observations/(:any)","admin\Observations::manage/$1", $HRGuard);

$routes->get("/$slug/connections","admin\Connections::index", $HRGuard);
$routes->get("/$slug/connections/(:any)","admin\Connections::manage/$1", $HRGuard);
$routes->post("/$slug/connections/(:any)","admin\Connections::manage/$1", $HRGuard);

$routes->get("/$slug/card","admin\Cards::index", $HRGuard);
$routes->get("/$slug/card/(:any)","admin\Cards::$1", $HRGuard);
$routes->post("/$slug/card/(:any)","admin\Cards::$1", $HRGuard);

$routes->get("/$slug/news/","admin\News::index", $HRGuard);
$routes->post("/$slug/news/","admin\News::index", $HRGuard);
$routes->get("/$slug/news/(:any)","admin\News::manage/$1", $HRGuard);

$routes->get("/$slug/form-builder","admin\FormBuilder::index", $HRGuard);
$routes->get("/$slug/form-builder/m/(:any)","admin\FormBuilder::manage/$1", $HRGuard);
$routes->post("/$slug/form-builder/m/(:any)","admin\FormBuilder::manage/$1", $HRGuard);
$routes->get("/$slug/form-builder/(:any)","admin\FormBuilder::$1", $HRGuard);
$routes->post("/$slug/form-builder/(:any)","admin\FormBuilder::$1", $HRGuard);

$routes->get("/$slug/hubs","admin\Hubs::index",$HRGuard);
$routes->get("/$slug/hubs/(:any)","admin\Hubs::$1",$HRGuard);
$routes->post("/$slug/hubs/(:any)","admin\Hubs::$1",$HRGuard);

$routes->get("/$slug/scorecards","admin\Scorecards::index", $HRGuard);
$routes->get("/$slug/scorecards/(:any)","admin\Scorecards::$1", $HRGuard);


// Reports
$routes->get("/$slug/reports/department", "admin\Reports\Departments::index",$HRGuard);
$routes->get("/$slug/reports/department/(:any)", "admin\Reports\Departments::index/$1",$HRGuard);


$routes->get("/$slug/reports/obsolete", "admin\Reports\Obsolete::index", $HRGuard);
$routes->get("/$slug/reports/obsolete/(:any)", "admin\Reports\Obsolete::$1", $HRGuard);

$routes->get("/$slug/reports/eol", "admin\Reports\EOL::index", $HRGuard);
$routes->get("/$slug/reports/eol/(:any)", "admin\Reports\EOL::$1", $HRGuard);


$routes->get("/$slug/reports/non-sellable", "admin\Reports\NonSellables::index", $HRGuard);
$routes->get("/$slug/reports/non-sellable/(:any)", "admin\Reports\NonSellables::$1", $HRGuard);


$routes->get("/$slug/reports/rlo", "admin\Reports\RLO::index", $HRGuard);
$routes->get("/$slug/reports/rlo/(:any)", "admin\Reports\RLO::$1", $HRGuard);

$routes->get("/$slug/reports/product-note", "admin\Reports\ProductNote::index", $HRGuard);
$routes->get("/$slug/reports/product-note/(:any)", "admin\Reports\ProductNote::$1", $HRGuard);

$routes->get("/$slug/reports/hyla", "admin\Reports\Hyla::index", $HRGuard);
$routes->get("/$slug/reports/hyla/(:any)", "admin\Reports\Hyla::$1", $HRGuard);

$routes->get("/$slug/reports/doors", "admin\Reports\Doors::index", $HRGuard);
$routes->get("/$slug/reports/doors/(:any)", "admin\Reports\Doors::$1", $HRGuard);

$routes->get("/$slug/reports/cash-deposits", "admin\Reports\CashDeposits::index", $HRGuard);
$routes->get("/$slug/reports/cash-deposits/(:any)", "admin\Reports\CashDeposits::$1", $HRGuard);

$routes->get("/$slug/reports/bi", "admin\Reports\BiReports::index", $HRGuard);
$routes->get("/$slug/reports/bi/(:any)", "admin\Reports\BiReports::$1", $HRGuard);

$routes->get("/$slug/reports/surveillance", "admin\Reports\Surveillance::index", $HRGuard);
$routes->get("/$slug/reports/surveillance/(:any)", "admin\Reports\Surveillance::$1", $HRGuard);

// reports end

$routes->get("/$slug/articles", "admin\Articles::index",$HRGuard);
$routes->get("/$slug/articles/(:any)", "admin\Articles::$1",$HRGuard);
$routes->post("/$slug/articles/(:any)", "admin\Articles::$1",$HRGuard);

$routes->get("/$slug/urgent", "admin\Urgents::index",$HRGuard);
$routes->get("/$slug/urgent/(:any)", "admin\Urgents::$1",$HRGuard);
$routes->post("/$slug/urgent/(:any)", "admin\Urgents::$1",$HRGuard);

// apis
$routes->get("/$slug/api/employees", "admin\Apis::employees",$HRGuard);
$routes->get("/$slug/api/employees/(:any)", "admin\Apis::employees/$1",$HRGuard);

$routes->get("/$slug/api/stores", "admin\Apis::stores",$HRGuard);
$routes->get("/$slug/api/(:any)", "admin\Apis::$1",$HRGuard);
$routes->get("/$slug/api/(:any)/(:any)", "admin\Apis::$1/$2",$HRGuard);