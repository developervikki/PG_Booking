<?php
session_start();

// Allow only logged-in owners
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'owner') {
    header("Location: ../auth/login.php"); // Change path as per your folder structure
    exit();
}

$owner_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-blue-600 p-4 text-white flex justify-between">
        <h1 class="text-xl font-bold">Welcome, <?php echo htmlspecialchars($owner_name); ?></h1>
        <a href="../auth/logout.php" class="bg-red-500 px-3 py-1 rounded">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="p-6">
        <h2 class="text-2xl font-semibold mb-4">Owner Dashboard</h2>
        <p class="mb-6">Manage your properties, view bookings, and check customer details here.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Manage Rooms -->
            <a href="manage_rooms.php" class="bg-white p-4 rounded shadow hover:shadow-lg">
                <h3 class="text-lg font-bold">Manage Rooms</h3>
                <p>Add, edit, or delete your property details.</p>
            </a>

            <!-- Manage Bookings -->
            <a href="../admin/manage_bookings.php" class="bg-white p-4 rounded shadow hover:shadow-lg">
                <h3 class="text-lg font-bold">Manage Bookings</h3>
                <p>View and update your booking records.</p>
            </a>

            <!-- View Customers -->
            <a href="view_customers.php" class="bg-white p-4 rounded shadow hover:shadow-lg">
                <h3 class="text-lg font-bold">View Customers</h3>
                <p>See details of customers who booked your rooms.</p>
            </a>
        </div>
    </div>
</body>
</html>
