<?php 

$checkAuth = ['filter' => 'authGuard'];

$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::index');
$routes->post('/sso', 'Auth::sso');
$routes->get('/cronjob', 'Cronjob::index');

$routes->get('/forgot', 'Auth::forgot');
$routes->post('/login', 'Auth::index');
$routes->post('/forgot', 'Auth::forgot');
$routes->get('/logout', 'Auth::logout');
$routes->get('/sso','Auth::sso');
$routes->get('/verification', 'Auth::verification');
$routes->post('/verification', 'Auth::verification');


$routes->get('/under-construction', 'Home::under_construction',$checkAuth);


// General pages
$routes->get('/profile','Home::profile',$checkAuth);
$routes->post('/save_image','Home::update_profile',$checkAuth);

$routes->post('/check/(:any)','Home::check/$1');


// Form Builder
$routes->get('/form/(:any)','Home::form/$1');
$routes->post('/form/(:any)','Home::form/$1');
$routes->post('/upload','Home::upload');
$routes->get('/forms', 'admin\FormBuilder::forms');

// pulse
$routes->post('/pulse','admin\Pulse::add',$checkAuth);

// Ticket conversation
$routes->get('/tickets/conversation','Tickets::conversation', $checkAuth);
$routes->post('/tickets/conversation','Tickets::conversation', $checkAuth);
$routes->post('/tickets/status','Tickets::status', $checkAuth);
$routes->get('/tickets/find','Tickets::find', $checkAuth);
$routes->get('/tickets/view/(:any)','Tickets::view/$1', $checkAuth);
$routes->get('/tickets','Tickets::index', $checkAuth);
$routes->get('/tickets/(:any)','Tickets::manage/$1', $checkAuth);
$routes->post('/tickets/(:any)','Tickets::manage/$1', $checkAuth);

$routes->get('/api/employees', 'admin\Apis::employees');
$routes->get('/api/stores', 'admin\Apis::stores');

$routes->get('/articles', 'Articles::index',$checkAuth);
$routes->get('/articles/(:any)', 'Articles::show/$1',$checkAuth);

$routes->get('/hubs', 'Hubs::index', $checkAuth);
$routes->get('/hubs/(:any)', 'Hubs::$1', $checkAuth);

$routes->get('/news/', 'News::index', $checkAuth);
$routes->get('/news/(:any)', 'News::manage/$1', $checkAuth);


$routes->get('/card','Cards::index', $checkAuth);
$routes->get('/card/(:any)','Cards::index/$1', $checkAuth);
$routes->post('/card','Cards::index', $checkAuth);

$routes->post('/urgent','admin\Urgents::acknowledge', $checkAuth);

// APIs
$routes->get('api/(:any)','API::$1', $checkAuth);

$routes->get('/compliance','admin\Compliance::session_user', $checkAuth);


$routes->get('/notification','Notifications::index', $checkAuth);
$routes->post('/notification/read','Notifications::set_notification_meta', $checkAuth);
$routes->post('/notification/updatenotifications','Notifications::updatenotifications', $checkAuth);
$routes->post('/notification/updateallnotifications','Notifications::updateallnotifications', $checkAuth);

// sign
$routes->get('/sign/(:any)','admin\FormBuilder::sign/$1');