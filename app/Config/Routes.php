<?php

namespace Config;

use CodeIgniter\Router\RouteCollection as RouterRouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Survey');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

$routes->get('/', 'Survey::index');
$routes->get('test', 'Auth::test');

// Authentication routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

// Admin routes
$routes->group('admin', function(RouterRouteCollection $routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('survey-results', 'Admin::surveyResults');
    $routes->get('survey-management', 'Admin::surveyManagement');
    $routes->get('user-management', 'Admin::userManagement');
    
    // API routes for user management
    $routes->group('api', function(RouterRouteCollection $routes) {
        $routes->get('users', 'Admin::getUsers');
        $routes->post('users', 'Admin::createUser');
        $routes->put('users/(:num)', 'Admin::updateUser/$1');
        $routes->delete('users/(:num)', 'Admin::deleteUser/$1');
        $routes->get('roles', 'Admin::getRoles');
        $routes->get('education-areas', 'Admin::getEducationAreas');
        $routes->get('check-question-responses/(:num)', 'Admin::checkQuestionResponses');
        
        // Survey management API
        $routes->get('periods', 'Admin::getPeriods');
        $routes->post('periods', 'Admin::createPeriod');
        $routes->put('periods/(:num)', 'Admin::updatePeriod/$1');
        $routes->delete('periods/(:num)', 'Admin::deletePeriod/$1');
        
        // ในส่วนของ admin/api group ให้เพิ่ม routes ต่อไปนี้:
        $routes->get('categories', 'Admin::getCategories');
        $routes->post('categories', 'Admin::createCategory');
        $routes->put('categories/(:num)', 'Admin::updateCategory/$1');
        $routes->delete('categories/(:num)', 'Admin::deleteCategory/$1');

        $routes->get('questions', 'Admin::getQuestions');
        $routes->post('questions', 'Admin::createQuestion');
        $routes->put('questions/(:num)', 'Admin::updateQuestion/$1');
        $routes->delete('questions/(:num)', 'Admin::deleteQuestion/$1');

        $routes->get('work-statuses', 'Admin::getWorkStatuses');
        $routes->post('work-statuses', 'Admin::createWorkStatus');
        $routes->put('work-statuses/(:num)', 'Admin::updateWorkStatus/$1');
        $routes->delete('work-statuses/(:num)', 'Admin::deleteWorkStatus/$1');

        $routes->post('get-survey-results', 'Admin::getSurveyResults');
        $routes->post('get-survey-summary', 'Admin::getSurveySummary');
        $routes->post('get-category-detail', 'Admin::getCategoryDetail');
        $routes->post('compare-periods', 'Admin::comparePeriods');
        $routes->get('export-results', 'Admin::exportResults');

        $routes->post('get-statistics', 'Admin::getStatistics'); // สำหรับ dashboard
        
        $routes->post('get-questions-by-period', 'Admin::getQuestionsByPeriod');
        $routes->post('get-question-stats', 'Admin::getQuestionStats');
        $routes->post('get-all-questions-stats', 'Admin::getAllQuestionsStats');
        
        $routes->post('get-calculation-data', 'Admin::getCalculationData');
        $routes->post('get-category-comments', 'Admin::getCategoryComments');
    });
});

// Area manager routes
$routes->group('area', function(RouterRouteCollection $routes) {
    $routes->get('dashboard', 'Area::dashboard');
    $routes->get('results', 'Area::results');
    
    // API routes for area manager
    $routes->group('api', function(RouterRouteCollection $routes) {
        $routes->post('get-questions', 'Area::getQuestions');
        $routes->post('get-question-stats', 'Area::getQuestionStats');
        $routes->post('get-area-results', 'Area::getAreaResults');
        $routes->post('get-area-summary', 'Area::getAreaSummary');
        $routes->get('get-area-info', 'Area::getAreaInfo');
        $routes->post('compare-area-periods', 'Area::compareAreaPeriods');
        $routes->post('get-area-question-detail', 'Area::getAreaQuestionDetail');
        $routes->post('get-area-category-detail', 'Area::getAreaCategoryDetail');
        $routes->get('export-area-results', 'Area::exportAreaResults');
        $routes->post('get-area-calculation-data', 'Area::getAreaCalculationData');
        $routes->post('get-category-comments', 'Area::getCategoryComments');
    });
});

// Survey form for public
$routes->group('survey', function(RouterRouteCollection $routes) {
    
    // หน้าหลักแบบสอบถาม
    $routes->get('/', 'Survey::index');
    
    // ดูแบบสอบถามที่เปิดอยู่
    $routes->get('active', 'Survey::activePeriods');
    
    // ฟอร์มแบบสอบถาม (ใช้ route เดียว)
    $routes->get('form/(:num)', 'Survey::form/$1');
    
    // ตรวจสอบสถานะช่วงเวลา
    $routes->get('check/(:num)', 'Survey::checkPeriodStatus/$1');
    
    // ดึงข้อมูลแบบสอบถาม (API)
    $routes->get('data/(:num)', 'Survey::getSurveyData/$1');
    
    // ส่งแบบสอบถาม (ป้องกัน CSRF)
    $routes->post('submit', 'Survey::submit', ['filter' => 'csrf']);
    
    // หน้าแสดงขอบคุณ
    $routes->get('thankyou', 'Survey::thankyou');
    
    // หน้าแสดงข้อผิดพลาด
    $routes->get('error', 'Survey::errorPage');
});

// เพิ่มเส้นทางสำหรับ landing page แบบสอบถามสาธารณะ
$routes->get('surveys', 'Survey::index');
$routes->get('public-survey/(:num)', 'Survey::publicForm/$1');

// เพิ่มเส้นทางสำหรับ 404 page สำหรับแบบสอบถาม
$routes->set404Override(function() {
    return view('survey/error', [
        'title' => 'ไม่พบหน้า',
        'message' => 'ไม่พบหน้าที่คุณต้องการ กรุณาตรวจสอบ URL หรือกลับสู่หน้าหลัก'
    ]);
});

// Enable auto-routing if needed (for development)
if (ENVIRONMENT === 'development') {
    $routes->setAutoRoute(true);
}

/*
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}