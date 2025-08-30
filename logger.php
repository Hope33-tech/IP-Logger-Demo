<?php
// logger.php - يسجل المعلومات القانونية فقط

// نقرأ بيانات JSON من الـ POST
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// نتحقق إذا في بيانات
if($data) {
    // نجهز معلومات الـ visitor
    $ip = $_SERVER['REMOTE_ADDR'];
    $ts = date('Y-m-d H:i:s');

    // المعلومات القانونية فقط
    $userAgent = isset($data['userAgent']) ? $data['userAgent'] : 'N/A';
    $platform  = isset($data['platform']) ? $data['platform'] : 'N/A';
    $screen    = isset($data['screen']) ? $data['screen'] : 'N/A';
    $timezone  = isset($data['timezone']) ? $data['timezone'] : 'N/A';
    $language  = isset($data['language']) ? $data['language'] : 'N/A';

    // نص السجل
    $log = "$ts | $ip | $userAgent | $platform | $screen | $timezone | $language\n";

    // نكتبها بملف visitors.log
    file_put_contents('visitors.log', $log, FILE_APPEND);
}
?>
