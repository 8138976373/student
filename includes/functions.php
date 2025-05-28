
<?php

/**
 * Initialize data directories and files
 */
function initializeData()
{
    $dataDir = __DIR__ . '/../data';

    // Create data directory if it doesn't exist
    if (!is_dir($dataDir)) {
        mkdir($dataDir, 0755, true);
    }

    // Initialize users file with default admin user
    $usersFile = $dataDir . '/users.json';
    if (!file_exists($usersFile)) {
        $defaultUsers = [
            [
                'id' => 'admin1',
                'username' => 'admin',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'administrator',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        file_put_contents($usersFile, json_encode($defaultUsers, JSON_PRETTY_PRINT));
    }

    // Initialize students file
    $studentsFile = $dataDir . '/students.json';
    if (!file_exists($studentsFile)) {
        file_put_contents($studentsFile, json_encode([], JSON_PRETTY_PRINT));
    }

    // Initialize marks file
    $marksFile = $dataDir . '/marks.json';
    if (!file_exists($marksFile)) {
        file_put_contents($marksFile, json_encode([], JSON_PRETTY_PRINT));
    }
}

/**
 * Load users from JSON file
 */
function loadUsers()
{
    initializeData();
    $usersFile = __DIR__ . '/../data/users.json';

    if (file_exists($usersFile)) {
        $content = file_get_contents($usersFile);
        return json_decode($content, true) ?: [];
    }

    return [];
}

/**
 * Load students from JSON file
 */
function loadStudents()
{
    initializeData();
    $studentsFile = __DIR__ . '/../data/students.json';

    if (file_exists($studentsFile)) {
        $content = file_get_contents($studentsFile);
        return json_decode($content, true) ?: [];
    }

    return [];
}

/**
 * Save students to JSON file
 */
function saveStudents($students)
{
    $studentsFile = __DIR__ . '/../data/students.json';
    return file_put_contents($studentsFile, json_encode($students, JSON_PRETTY_PRINT)) !== false;
}

/**
 * Load marks from JSON file
 */
function loadMarks()
{
    initializeData();
    $marksFile = __DIR__ . '/../data/marks.json';

    if (file_exists($marksFile)) {
        $content = file_get_contents($marksFile);
        return json_decode($content, true) ?: [];
    }

    return [];
}

/**
 * Save marks to JSON file
 */
function saveMarks($marks)
{
    $marksFile = __DIR__ . '/../data/marks.json';
    return file_put_contents($marksFile, json_encode($marks, JSON_PRETTY_PRINT)) !== false;
}

/**
 * Get Bootstrap badge class based on grade percentage
 */
function getGradeBadgeClass($grade, $maxMarks)
{
    $percentage = ($grade / $maxMarks) * 100;

    if ($percentage >= 90) return 'success';
    if ($percentage >= 80) return 'primary';
    if ($percentage >= 70) return 'info';
    if ($percentage >= 60) return 'warning';
    return 'danger';
}

/**
 * Sanitize output for HTML
 */
function h($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate a secure random string
 */
function generateToken($length = 32)
{
    return bin2hex(random_bytes($length / 2));
}

/**
 * Validate email address
 */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Get current user information
 */
function getCurrentUser()
{
    if (!isset($_SESSION['user_id'])) {
        return null;
    }

    $users = loadUsers();
    foreach ($users as $user) {
        if ($user['id'] === $_SESSION['user_id']) {
            return $user;
        }
    }

    return null;
}
?>