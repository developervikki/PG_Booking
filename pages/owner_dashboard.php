<?php
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'owner') {
    header("Location: ../pages/owner_dashboard.php");
    exit();
}

// Check if user is logged in and role is owner


$owner_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-blue-600 p-4 text-white flex justify-between">
        <h1 class="text-xl font-bold">Welcome, <?php echo htmlspecialchars($owner_name); ?></h1>
        <a href="logout.php" class="bg-red-500 px-3 py-1 rounded">Logout</a>
    </div>

    <div class="p-6">
        <h2 class="text-2xl font-semibold mb-4">Owner Dashboard</h2>
        <p class="mb-6">Here you can manage your rooms, bookings, and view user activities.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="manage_rooms.php" class="bg-white p-4 rounded shadow hover:shadow-lg">
                <h3 class="text-lg font-bold">Manage Rooms</h3>
                <p>Add, edit, or delete room details.</p>
            </a>
            <a href="manage_bookings.php" class="bg-white p-4 rounded shadow hover:shadow-lg">
                <h3 class="text-lg font-bold">Manage Bookings</h3>
                <p>View and update booking information.</p>
            </a>
            <a href="manage_users.php" class="bg-white p-4 rounded shadow hover:shadow-lg">
                <h3 class="text-lg font-bold">Manage Users</h3>
                <p>View and manage registered users.</p>
            </a>
        </div>
    </div>
</body>
</html>
