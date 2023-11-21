<?php
$Guard = ["filter" => "adminGuard"];
$base = "admin";
// $base Routes
$routes->get("/$base","$base\Dashboard::index", $Guard); 


// $base Settings
$routes->get("/$base/settings","$base\Settings::index", $Guard);
$routes->get("/$base/settings/add","$base\Settings::create",$Guard);
$routes->post("/$base/settings/add","$base\Settings::create",$Guard);
$routes->get("/$base/settings/(:num)","$base\Settings::edit/$1",$Guard);
$routes->post("/$base/settings/(:num)","$base\Settings::edit/$1",$Guard);
$routes->get("/$base/settings/del/(:num)","$base\Settings::del/$1",$Guard);

// $base Employees
$routes->get("/$base/employees","$base\Employees::index", $Guard);
$routes->get("/$base/employees/(:any)","$base\Employees::manage/$1", $Guard);
$routes->post("/$base/employees/(:num)","$base\Employees::manage/$1", $Guard);
$routes->post("/$base/employees/new","$base\Employees::manage/new", $Guard);
$routes->post("/$base/employees/upload","$base\Employees::upload", $Guard);

$routes->post("/$base/employees/import","$base\Employees::import",$Guard);

$routes->get("/$base/compliance","$base\Compliance::index", $Guard);
$routes->post("/$base/compliance/import","$base\Compliance::import", $Guard);
$routes->get("/$base/compliance/find","$base\Compliance::find", $Guard);
$routes->get("/$base/compliance/(:any)","$base\Compliance::manage/$1", $Guard);

$routes->get("/$base/card","$base\Cards::index", $Guard);
$routes->get("/$base/card/(:any)","$base\Cards::$1", $Guard);
$routes->post("/$base/card/(:any)","$base\Cards::$1", $Guard);

$routes->get("/$base/news/","$base\News::index", $Guard);
$routes->post("/$base/news/","$base\News::index", $Guard);
$routes->get("/$base/news/(:any)","$base\News::manage/$1", $Guard);

$routes->get("/$base/form-builder","$base\FormBuilder::index", $Guard);
$routes->get("/$base/form-builder/m/(:any)","$base\FormBuilder::manage/$1", $Guard);
$routes->post("/$base/form-builder/m/(:any)","$base\FormBuilder::manage/$1", $Guard);
$routes->get("/$base/form-builder/(:any)","$base\FormBuilder::$1", $Guard);
$routes->post("/$base/form-builder/(:any)","$base\FormBuilder::$1", $Guard);

/* ScoreCard routed to emailSync Routes -- Dt: 04/06/2023
$routes->get("/$base/scorecards","$base\Scorecards::index", $Guard);
$routes->get("/$base/scorecards/(:any)","$base\Scorecards::$1", $Guard);
$routes->post("/$base/scorecards/(:any)","$base\Scorecards::$1", $Guard);
*/

$routes->get("/$base/scorecards","$base\Emailsync::index", $Guard);
$routes->get("/$base/scorecards/(:any)","$base\Emailsync::$1", $Guard);
$routes->post("/$base/scorecards/(:any)","$base\Emailsync::$1", $Guard);


$routes->get("/$base/emailsync","$base\Emailsync::index", $Guard);
$routes->get("/$base/emailsync/(:any)","$base\Emailsync::$1", $Guard);
$routes->post("/$base/emailsync/(:any)","$base\Emailsync::$1", $Guard);

//$routes->get("/$base/scorecards","$base\Scorecards::index", $Guard);
//$routes->get("/$base/scorecards/(:any)","$base\Scorecards::$1", $Guard);
//$routes->post("/$base/scorecards/(:any)","$base\Scorecards::$1", $Guard);



$routes->get("/$base/connections","$base\Connections::index", $Guard);
$routes->get("/$base/connections/form","$base\Connections::form", $Guard);
$routes->post("/$base/connections/form","$base\Connections::form", $Guard);
$routes->get("/$base/connections/find","$base\Connections::find", $Guard);
$routes->get("/$base/connections/(:any)","$base\Connections::manage/$1", $Guard);
$routes->post("/$base/connections/(:any)","$base\Connections::manage/$1", $Guard);


$routes->get("/$base/sso-connections","$base\SsoConnections::index", $Guard);
$routes->get("/$base/sso-connections/(:any)","$base\SsoConnections::manage/$1", $Guard);

$routes->get("/$base/observations","$base\Observations::index", $Guard);
$routes->get("/$base/observations/form","$base\Observations::form", $Guard);
$routes->post("/$base/observations/form","$base\Observations::form", $Guard);
$routes->get("/$base/observations/find","$base\Observations::find", $Guard);
$routes->get("/$base/observations/(:any)","$base\Observations::manage/$1", $Guard);
$routes->post("/$base/observations/(:any)","$base\Observations::manage/$1", $Guard);

$routes->get("/$base/stores", "$base\Stores::index",$Guard);
$routes->get("/$base/stores/(:any)", "$base\Stores::manage/$1",$Guard);
$routes->get("/$base/stores/export", "$base\Stores::export",$Guard);

$routes->post("/$base/stores/import","$base\Stores::import",$Guard);
$routes->post("/$base/stores/(:any)","$base\Stores::update/$1",$Guard);


$routes->get("/$base/hubs","$base\Hubs::index",$Guard);
$routes->get("/$base/hubs/(:any)","$base\Hubs::$1",$Guard);
$routes->post("/$base/hubs/(:any)","$base\Hubs::$1",$Guard);

$routes->get("/$base/pulse/(:any)","$base\Pulse::$1",$Guard);
$routes->post("/$base/pulse/(:any)", "$base\Pulse::$1", $Guard);



// apis
$routes->get("/$base/api/employees", "$base\Apis::employees",$Guard);
$routes->get("/$base/api/employees/(:any)", "$base\Apis::employees/$1",$Guard);

$routes->get("/$base/api/stores", "$base\Apis::stores",$Guard);
$routes->get("/$base/api/(:any)", "$base\Apis::$1",$Guard);
$routes->get("/$base/api/(:any)/(:any)", "$base\Apis::$1/$2",$Guard);


$routes->get("/$base/articles", "$base\Articles::index",$Guard);
$routes->get("/$base/articles/(:any)", "$base\Articles::$1",$Guard);
$routes->post("/$base/articles/(:any)", "$base\Articles::$1",$Guard);


$routes->get("/$base/urgent", "$base\Urgents::index",$Guard);
$routes->get("/$base/urgent/(:any)", "$base\Urgents::$1",$Guard);
$routes->post("/$base/urgent/(:any)", "$base\Urgents::$1",$Guard);


// Reports
$routes->get("/$base/reports/department", "$base\Reports\Departments::index");
$routes->get("/$base/reports/department/(:any)", "$base\Reports\Departments::index/$1");


$routes->get("/$base/reports/obsolete", "$base\Reports\Obsolete::index", $Guard);
$routes->get("/$base/reports/obsolete/(:any)", "$base\Reports\Obsolete::$1", $Guard);
$routes->post("/$base/reports/obsolete/(:any)", "$base\Reports\Obsolete::$1", $Guard);

$routes->get("/$base/reports/eol", "$base\Reports\EOL::index", $Guard);
$routes->get("/$base/reports/eol/(:any)", "$base\Reports\EOL::$1", $Guard);
$routes->post("/$base/reports/eol/(:any)", "$base\Reports\EOL::$1", $Guard);


$routes->get("/$base/reports/non-sellable", "$base\Reports\NonSellables::index", $Guard);
$routes->get("/$base/reports/non-sellable/(:any)", "$base\Reports\NonSellables::$1", $Guard);
$routes->post("/$base/reports/non-sellable/(:any)", "$base\Reports\NonSellables::$1", $Guard);


$routes->get("/$base/reports/rlo", "$base\Reports\RLO::index", $Guard);
$routes->get("/$base/reports/rlo/(:any)", "$base\Reports\RLO::$1", $Guard);
$routes->post("/$base/reports/rlo/(:any)", "$base\Reports\RLO::$1", $Guard);

$routes->get("/$base/reports/product-note", "$base\Reports\ProductNote::index", $Guard);
$routes->get("/$base/reports/product-note/(:any)", "$base\Reports\ProductNote::$1", $Guard);
$routes->post("/$base/reports/product-note/(:any)", "$base\Reports\ProductNote::$1", $Guard);

$routes->get("/$base/reports/hyla", "$base\Reports\Hyla::index", $Guard);
$routes->get("/$base/reports/hyla/(:any)", "$base\Reports\Hyla::$1", $Guard);
$routes->post("/$base/reports/hyla/(:any)", "$base\Reports\Hyla::$1", $Guard);

$routes->get("/$base/reports/doors", "$base\Reports\Doors::index", $Guard);
$routes->get("/$base/reports/doors/(:any)", "$base\Reports\Doors::$1", $Guard);
$routes->post("/$base/reports/doors/(:any)", "$base\Reports\Doors::$1", $Guard);

$routes->get("/$base/reports/cash-deposits", "$base\Reports\CashDeposits::index", $Guard);
$routes->get("/$base/reports/cash-deposits/(:any)", "$base\Reports\CashDeposits::$1", $Guard);
$routes->post("/$base/reports/cash-deposits/(:any)", "$base\Reports\CashDeposits::$1", $Guard);

$routes->get("/$base/reports/reconciliation", "$base\Reports\Reconciliation::index", $Guard);
$routes->get("/$base/reports/reconciliation/(:any)", "$base\Reports\Reconciliation::$1", $Guard);
$routes->post("/$base/reports/reconciliation/(:any)", "$base\Reports\Reconciliation::$1", $Guard);

$routes->get("/$base/reports/bi", "$base\Reports\BiReports::index", $Guard);
$routes->get("/$base/reports/bi/(:any)", "$base\Reports\BiReports::$1", $Guard);
$routes->post("/$base/reports/bi/(:any)", "$base\Reports\BiReports::$1", $Guard);

$routes->get("/$base/reports/surveillance", "$base\Reports\Surveillance::index", $Guard);
$routes->get("/$base/reports/surveillance/(:any)", "$base\Reports\Surveillance::$1", $Guard);
$routes->post("/$base/reports/surveillance/(:any)", "$base\Reports\Surveillance::$1", $Guard);

$routes->get("/$base/pulse", "$base\Pulse::index", $Guard);
$routes->get("/$base/pulse/(:any)", "$base\Pulse::$1", $Guard);