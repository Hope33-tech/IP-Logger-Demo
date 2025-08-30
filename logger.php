<?php
require 'vendor/autoload.php';

use PHPSupabase\PHPSupabase;

// إعدادات Supabase
$projectUrl = 'https://rjqbbeyzyvynlapmwpiy.supabase.co';
$apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InJqcWJiZXl6eXZ5bmxhcG13cGl5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTY1Mzg1NTAsImV4cCI6MjA3MjExNDU1MH0.h1MdgTuxhfYHme6DzX5P6FZDs7q6Ec3WfnXL5mDRZCY';

$supabase = new PHPSupabase($projectUrl, $apiKey);

// الحصول على البيانات من المتصفح
$inputData = json_decode(file_get_contents('php://input'), true);

// جمع IP الزائر
$ip = $_SERVER['REMOTE_ADDR'];

// إعداد البيانات للإرسال
$data = [
    'ip' => $ip,
    'user_agent' => $inputData['userAgent'] ?? '',
    'language' => $inputData['language'] ?? '',
    'platform' => $inputData['platform'] ?? '',
    'screen' => $inputData['screen'] ?? '',
    'timezone' => $inputData['timezone'] ?? '',
    'memory' => $inputData['memory'] ?? '',
    'cores' => $inputData['cores'] ?? '',
    'timestamp' => date('Y-m-d H:i:s')
];

// إرسال البيانات لجدول "visitors" في Supabase
$response = $supabase->from('visitors')->insert($data);

if ($response->status() === 201) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'details' => $response->body()]);
}
