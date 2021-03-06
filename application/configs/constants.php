<?php
if(APPLICATION_ENV == 'production'){
    define('STATIC_SERVER', '');
}else{
    define('STATIC_SERVER', '');
}

/************************* Domain *******************************/
if (APPLICATION_ENV == 'local') {
	define('FRONTEND_DOMAIN_NAME', 'http://giasu.com');
	define('BACKEND_DOMAIN_NAME', 'http://admin.giasu.com');

} elseif (APPLICATION_ENV == 'dev') {
	define('FRONTEND_DOMAIN_NAME', 'http://giasu-tam.com');
	define('BACKEND_DOMAIN_NAME', 'http://admin.giasu-tam.com');

}elseif (APPLICATION_ENV == 'test') {
	define('FRONTEND_DOMAIN_NAME', 'http://giasu-tam.com');
	define('BACKEND_DOMAIN_NAME', 'http://admin.giasu-tam.com');

} elseif (APPLICATION_ENV == 'showcase') {
	define('FRONTEND_DOMAIN_NAME', 'http://giasu-tam.com');
	define('BACKEND_DOMAIN_NAME', 'http://admin.giasu-tam.com');

} else {
	define('FRONTEND_DOMAIN_NAME', 'http://giasu-tam.com');
	define('BACKEND_DOMAIN_NAME', 'http://admin.giasu-tam.com');
}

define('NUMBER_OF_ITEM_PER_PAGE', 20);

/************************* Date Format *******************************/
define('DATE_FORMAT_PHP_MIXED_FULL', 'Y M d H:i:s');
define('DATE_FORMAT_ZEND', 'dd-MM-yyyy');
define('DATE_FORMAT_DATABASE', 'yyyy-MM-dd HH:mm:ss');
define('DATE_FORMAT_TO_MINUTE', 'yyyy-MM-dd HH:mm');
define('DATE_FORMAT_FULL', 'EEE dd MMM yyyy, hh:mm a');
define('DATE_FORMAT_NORMAL', 'MMM dd, yyyy');
define('DATE_FORMAT', 'EEE dd MMM yyyy, ');

define('SESSION_LIFE_TIME_REMEMBER', 7 * 24 * 60 * 60);

/************************* Files *******************************/
define('UPLOAD_PATH_TMP', '/tmp');
define('DATA_PATH', '/home/gia53c14/public_html');
//define('DATA_PATH',  'C:/wamp/www/admin.giasu-tam.com');//test local
define('UPLOAD_PATH', DATA_PATH . '/uploads');

define('IMAGE_UPLOAD_PATH', UPLOAD_PATH . '/images/');
define('IMAGE_UPLOAD_PATH_TMP', IMAGE_UPLOAD_PATH .'tmp/');
define('IMAGE_UPLOAD_PATH_BACKUP', IMAGE_UPLOAD_PATH .'backup/');

define('IMAGE_CAROUSEL_UPLOAD_PATH', IMAGE_UPLOAD_PATH . 'carousel/');
define('IMAGE_CAROUSEL_UPLOAD_TMP', IMAGE_CAROUSEL_UPLOAD_PATH . 'tmp/');
define('IMAGE_CAROUSEL_UPLOAD_BACKUP', IMAGE_CAROUSEL_UPLOAD_PATH . 'backup/');

define('IMAGE_UPLOAD_URI', '/uploads/images/');
define('IMAGE_UPLOAD_URI_TMP', IMAGE_UPLOAD_URI . 'tmp/');

define('IMAGE_CAROUSEL_UPLOAD_URI', '/uploads/images/carousel/');
define('IMAGE_CAROUSEL_UPLOAD_URI_TMP', IMAGE_CAROUSEL_UPLOAD_URI . 'tmp/');

define('IMAGE_UPLOAD_URL', FRONTEND_DOMAIN_NAME.'/uploads/images/');
define('IMAGE_UPLOAD_URL_TMP', IMAGE_UPLOAD_URL .'tmp/');

define('IMAGE_CAROUSEL_UPLOAD_URL', FRONTEND_DOMAIN_NAME.'/uploads/images/carousel/');
define('IMAGE_CAROUSEL_UPLOAD_URL_TMP', IMAGE_CAROUSEL_UPLOAD_URL .'tmp/');

define('IMAGE_SIZE_LIMIT', 500);
$allowedExt = array('jpeg', 'jpg', 'png', 'gif');
define('IMAGE_ALLOWED_EXT', serialize($allowedExt));


/************************* Tutors *******************************/
$levels = array('- Chọn trình độ -', 'Cao Đẳng', 'Đại Học', 'Thạc Sỹ', 'Bằng cấp khác');
define('TUTOR_LEVELS', serialize($levels));

$exYears = array('Chưa có', 'Dưới 1 năm', '1 năm', '2 năm', '3 năm', '4 năm', '5 năm', '5-10 năm', '10-20 năm', 'trên 20');
define('EXPERIENCE_YEAR', serialize($exYears));

$careers = array('Sinh Viên Năm 1', 'Sinh Viên Năm 2', 'Sinh Viên Năm 3', 'Sinh Viên Năm 4', 'Đã Tốt Nghiệp', 'Giáo Viên', 'Giảng Viên');
define('TUTOR_CAREERS' , serialize($careers));


/************************* Configs *******************************/
$sectionOtp = array('None-bg' => 'None', 'violet-bg' => 'Violet', 'brone-bg' => 'Copper', 'two-bg' => 'Mixed Gray-Purple', 'orange-bg' => 'Orange', 'red-bg' => 'Red');
define('CONFIG_SECTION' , serialize($sectionOtp));