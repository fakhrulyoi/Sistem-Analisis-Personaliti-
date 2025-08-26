<?php
// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'your_username');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'personality_analysis_system');

// Attempt to connect to MySQL database
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default charset to utf8mb4 for full Unicode support
    $pdo->exec("SET NAMES utf8mb4");
    $pdo->exec("SET CHARACTER SET utf8mb4");
    
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to calculate numerology code
function calculate_numerology_code($birth_date) {
    $date = new DateTime($birth_date);
    $day = $date->format('d');
    $month = $date->format('m');
    $year = $date->format('Y');
    
    $day_sum = array_sum(str_split($day));
    $month_sum = array_sum(str_split($month));
    $year_sum = array_sum(str_split($year));
    
    $total_sum = $day_sum + $month_sum + $year_sum;
    
    // Reduce to single digit
    while ($total_sum >= 10) {
        $total_sum = array_sum(str_split($total_sum));
    }
    
    return $total_sum;
}

// Function to get numerology data
function get_numerology_data($code) {
    $numerology_data = [
        1 => [
            'title' => 'KETULENAN',
            'element' => 'METAL',
            'strengths' => 'Berkemampuan untuk menjadi pemimpin dan suka menyendiri. Berani membuat keputusan dan seorang yang cekal. Mampu membuat banyak kerja dalam satu masa.',
            'weaknesses' => 'Suka memaksa, tiada tolak ansur, dan suka memendam rasa. Degil, tidak sabar dan emosi tidak stabil.',
            'suggestions' => 'Berikan peluang kepada orang lain, belajar menerima kegagalan dan cuba melatih diri untuk lebih bersabar.',
            'compatibility' => '3, 5, 7',
            'lucky_numbers' => '1, 10, 19, 28',
            'lucky_colors' => 'Putih, Kuning, Emas',
            'lucky_days' => 'Ahad, Isnin',
            'careers' => 'Pemimpin, Pengurus, Usahawan, Jurutera'
        ],
        // Add data for other numbers (2-9) following the same structure
    ];
    
    return isset($numerology_data[$code]) ? $numerology_data[$code] : null;
}

// Function to get MBTI data
function get_mbti_data($type) {
    $mbti_data = [
        'ISTJ' => [
            'name' => 'The Inspector',
            'description' => 'Praktikal dan berorientasikan fakta. Bertanggungjawab dan setia.',
            'strengths' => 'Bertanggungjawab,Berorientasikan fakta,Teratur,Setia',
            'weaknesses' => 'Keras kepala,Tidak fleksibel,Sukar menerima perubahan'
        ],
        // Add data for other MBTI types following the same structure
    ];
    
    return isset($mbti_data[$type]) ? $mbti_data[$type] : null;
}
?>