<?php
require 'vendor/autoload.php';

use PHPSupabase\PHPSupabase;

$projectUrl = 'https://rjqbbeyzyvynlapmwpiy.supabase.co';
$apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InJqcWJiZXl6eXZ5bmxhcG13cGl5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTY1Mzg1NTAsImV4cCI6MjA3MjExNDU1MH0.h1MdgTuxhfYHme6DzX5P6FZDs7q6Ec3WfnXL5mDRZCY';

$supabase = new PHPSupabase($projectUrl, $apiKey);

// البيانات المستلمة من العميل
$data = json_decode(file_get_contents('php://input'), true);

// الحصول على IP الزائر
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

// إضافة البيانات إلى جدول "visitors"
$response = $supabase->from('visitors')->insert([
    'ip_address' => $ip,
    'user_agent' => $data['userAgent'] ?? '',
    'language' => $data['language'] ?? '',
    'platform' => $data['platform'] ?? '',
    'screen' => $data['screen'] ?? '',
    'timezone' => $data['timezone'] ?? '',
    'memory' => $data['memory'] ?? '',
    'cores' => $data['cores'] ?? '',
]);

if ($response->status() === 201) {
    echo 'Data logged successfully';
} else {
    echo 'Error logging data';
}
