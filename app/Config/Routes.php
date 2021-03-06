<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */



// Admin Routes
$routes->group('', ['filter' => 'authenticateUsers:1'], function ($routes) {

$routes->get('/admin', 'AdminView::home');
$routes->get('/admin/info', 'AdminView::info');
$routes->get('/admin/slider', 'AdminView::slider');
$routes->get('/admin/filter', 'AdminView::filter');

$routes->get('/admin/ticket', 'AdminView::ticket');
$routes->get('/admin/parent', 'AdminView::parent');
$routes->get('/admin/partner', 'AdminView::partner');
$routes->get('/admin/schooledit/(:num)', 'AdminView::schooledit/$1');
$routes->get('/admin/adminemail', 'AdminView::adminemail');
$routes->get('/admin/user', 'AdminView::user');
$routes->get('/admin/partners', 'AdminView::partners');
$routes->get('/admin/parents', 'AdminView::parents');
$routes->get('/admin/mangeschool', 'AdminView::mangeschool');
$routes->get('/admin/callus', 'AdminView::callus');
$routes->get('/admin/gets', 'AdminView::gets');
$routes->get('/admin/viewticketschool/(:num)', 'AdminView::viewticketschool/$1');
$routes->get('/admin/problem/(:num)', 'AdminView::problem/$1');
$routes->get('/admin/viewticketparther/(:num)', 'AdminView::viewticketparther/$1');
$routes->get('/admin/viewticketparent/(:num)', 'AdminView::viewticketparent/$1');
$routes->get('/admin/editgets/(:num)', 'AdminView::editgets/$1');
$routes->get('/admin/addgets', 'AdminView::addgets');
$routes->get('/admin/classes', 'AdminView::classes');

});





// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');





//Home routes
$routes->get('login', 'Home::showLoginForm', ['as' => 'login']);

$routes->post('login', 'Authentication::login');

$routes->get('register', 'Home::showRegisterForm');

$routes->post('logout', 'Authentication::logout');

$routes->post('password/forget', 'Authentication::sendResetPassword');

$routes->get('password/forget', 'Home::showSendResetPasswordForm', ['as' => 'forgetPassword']);

$routes->get('password/reset', 'Authentication::checkAndShowResetPasswordForm');

$routes->post('password/reset', 'Authentication::resetPassword');

$routes->get('mail', function(){
return view('mail/resetPasswordEmail', ['link' => 'http://localhost/codeigniter/CodeSchoolSystem/password/reset?token=252f4b1a6e6e577bbd7306eca71b8b004d1a957ed9b85400e9f68862bae2&email=admin%40admin.com']);
});


$routes->group('', ['filter' => 'authenticateUsers:2'], function ($routes) {

	// school routes
	$routes->get('/school', 'SchoolView::messageForms');
	$routes->get('/school/messageForms/global', 'SchoolView::messageForms');
	$routes->get('/school/exams/tables', 'SchoolView::examsTables');
	$routes->get('/school/global/table', 'SchoolView::globalTable');
	$routes->get('/school/gates/link', 'SchoolView::linkGates');
	$routes->get('school/students/info', 'SchoolView::studentsInfo');
	$routes->get('school/teachers/info', 'SchoolView::teachersInfo');
	$routes->get('school/employees/info', 'SchoolView::employeesInfo');
	$routes->get('school/subjects/info', 'SchoolView::subjectsInfo');
	$routes->get('school/notifications/absence-tardiness', 'SchoolView::absenceAndTardiness');
	$routes->get('school/notifications/public-messages', 'SchoolView::publicMesssages');
	$routes->get('school/archive/absence-tardiness', 'SchoolView::absenceAndTardinessArchive');
	$routes->get('school/archive/public-messages', 'SchoolView::publicMesssagesArchive');
	$routes->get('school/parents-responce/responce-archive', 'SchoolView::parentsResponceArchive');
	$routes->get('school/support/technical/tickets/sys-managers', 'SchoolView::systemManagersTichnicalSupportTickets');
	$routes->get('school/support/technical/tickets/parents', 'SchoolView::parentsTichnicalSupportTickets');
	$routes->get('school/support/technical/ticket/(:num)', 'SchoolView::viewTicket/$1');
	$routes->get('school/services/questionnaires', 'SchoolView::questionnaires');
	$routes->get('school/services/questionnaires/add', 'SchoolView::addQuestionnaires');
	$routes->get('school/services/forms', 'SchoolView::forms');
	$routes->get('school/partners/offers', 'SchoolView::partnersOffers');
	$routes->get('school/partners/support', 'SchoolView::partnersSupport');
	$routes->get('school/partner/support/technical/ticket/(:num)', 'SchoolView::viewPartnerTicket/$1');
	$routes->get('school/services/tinyLinks', 'SchoolView::tinyLinks');
	$routes->get('school/services/gallery', 'SchoolView::gallery');
	$routes->get('school/courses/division-levels', 'SchoolView::levelsAndDivisions');
});

$routes->get('school/notifications/reply/(:num)', 'SchoolView::showReplyNotificationForm/$1');
$routes->post('school/notifications/reply', 'Schools::replyToNotificationMessage');

$routes->get('school/course/notifications/reply/(:num)', 'SchoolView::showReplyCourseNotificationForm/$1');
$routes->post('school/course/notifications/reply', 'Schools::replyToCourseNotificationMessage');

$routes->get('courses/updateStudent', 'SchoolView::showUpdateCoursesStudentForm');

$routes->group('', ['filter' => 'authenticateUsers:3'], function ($routes) {
	// parents routes

	$routes->get('/parent', 'ParentsView::examsTables');

	$routes->get('/parent/school/exams/tables', 'ParentsView::examsTables');
	$routes->get('/parent/school/global/table', 'ParentsView::globalTable');
	$routes->get('parent/school/questionnaires', 'ParentsView::questionnaires');
	$routes->get('parent/school/forms', 'ParentsView::forms');
	$routes->get('parent/school/notification', 'ParentsView::schoolNotifications');

	$routes->get('parent/support/technical/sys-managers/messaging', 'ParentsView::messagingSystemManagers');
	$routes->get('parent/support/technical/school-management/messaging', 'ParentsView::messagingSchoolManagement');
	$routes->get('parent/support/technical/ticket/(:num)', 'ParentsView::viewTicket/$1');

	$routes->get('parent/partners/offers', 'ParentsView::partnersOffers');
	$routes->get('parent/partners/support', 'ParentsView::partnersSupport');
	$routes->get('parent/partner/support/technical/ticket/(:num)', 'ParentsView::viewPartnerTicket/$1');
});


$routes->group('', ['filter' => 'authenticateUsers:4'], function ($routes) {

	// partner routes

	$routes->get('/partner', 'PartnerView::partnersOffers');
	$routes->get('partner/offers', 'PartnerView::partnersOffers');

	$routes->get('partner/support/technical/sys-managers/messaging', 'PartnerView::messagingSystemManagers');
	$routes->get('partner/support/technical/schools/messaging', 'PartnerView::messagingSchoolManagement');
	$routes->get('partner/support/technical/parents/messaging', 'PartnerView::messagingParents');
	$routes->get('partner/support/technical/parent-tickets/(:num)', 'PartnerView::viewTicket/$1');
	$routes->get('partner/support/technical/school-tickets/(:num)', 'PartnerView::viewSchoolTicket/$1');

	$routes->get('partner/school/exams/tables', 'PartnerView::examsTables');
	$routes->get('partner/school/global/table', 'PartnerView::globalTable');
	$routes->get('partner/school/questionnaires', 'PartnerView::questionnaires');
	$routes->get('partner/school/forms', 'PartnerView::forms');
	$routes->get('partner/school/notification', 'PartnerView::schoolNotifications');

	$routes->get('partner/partners/support', 'PartnerView::partnersSupport');
	$routes->get('partner/partner/support/technical/ticket/(:num)', 'PartnerView::viewPartnerTicket/$1');
});



$routes->get('excelForm', function (){
	return view('excel');
});
$routes->post('excel', 'ExcelReader::index');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
