<?php
// Base directory
$baseDir = __DIR__ . '/pg_booking';

// Folder structure array
$folders = [
    'assets/css',
    'assets/js',
    'assets/images',
    'config',
    'includes',
    'pages',
    'auth',
    'admin',
    'uploads'
];

// Files to create with initial content
$files = [
    'config/db.php' => "<?php\n// Database connection\n?>",
    'includes/header.php' => "<!-- Header -->\n",
    'includes/footer.php' => "<!-- Footer -->\n",
    'includes/navbar.php' => "<!-- Navbar -->\n",
    'pages/home.php' => "<!-- Home Page -->\n",
    'pages/room_details.php' => "<!-- Room Details -->\n",
    'pages/search.php' => "<!-- Search Page -->\n",
    'pages/booking.php' => "<!-- Booking Page -->\n",
    'pages/dashboard_user.php' => "<!-- User Dashboard -->\n",
    'pages/dashboard_owner.php' => "<!-- Owner Dashboard -->\n",
    'pages/dashboard_admin.php' => "<!-- Admin Dashboard -->\n",
    'auth/login.php' => "<!-- Login Page -->\n",
    'auth/register.php' => "<!-- Register Page -->\n",
    'auth/logout.php' => "<!-- Logout Script -->\n",
    'admin/manage_users.php' => "<!-- Manage Users -->\n",
    'admin/manage_rooms.php' => "<!-- Manage Rooms -->\n",
    'admin/manage_bookings.php' => "<!-- Manage Bookings -->\n",
    'index.php' => "<!-- Landing Page -->\n",
    '.htaccess' => "RewriteEngine On\nRewriteRule ^([^/]+)/?$ index.php?page=$1 [L]"
];

// Create folders
foreach ($folders as $folder) {
    $path = $baseDir . '/' . $folder;
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
}

// Create files
foreach ($files as $file => $content) {
    $filePath = $baseDir . '/' . $file;
    if (!file_exists($filePath)) {
        file_put_contents($filePath, $content);
    }
}

echo "✅ Folder structure for PG Booking created successfully in 'pg_booking/'!";
?>
