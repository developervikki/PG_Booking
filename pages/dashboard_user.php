<?php
session_start();
include 'db.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;  
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_sql = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);

// Fetch user's bookings
$booking_sql = "SELECT b.*, p.name AS pg_name, p.location 
                FROM bookings b
                JOIN properties p ON b.property_id = p.id
                WHERE b.user_id = $user_id
                ORDER BY b.created_at DESC";
$bookings = mysqli_query($conn, $booking_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - PG Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

    <!-- Header -->
    <header class="bg-indigo-600 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">PG Booking</h1>
        <nav>
            <a href="index.php" class="px-3 hover:underline">Home</a>
            <a href="logout.php" class="px-3 hover:underline">Logout</a>
        </nav>
    </header>

    <!-- Welcome -->
    <section class="max-w-6xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-2">Welcome, <?php echo htmlspecialchars($user['name']); ?> 👋</h2>
        <p class="text-gray-600 mb-6">Here are your recent bookings and account details.</p>

        <!-- Profile Info -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h3 class="text-lg font-semibold mb-3">Your Profile</h3>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Joined:</strong> <?php echo date('d M Y', strtotime($user['created_at'])); ?></p>
        </div>

        <!-- Booking History -->
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-3">Your Bookings</h3>
            <?php if (mysqli_num_rows($bookings) > 0) { ?>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 p-2">PG Name</th>
                            <th class="border border-gray-300 p-2">Location</th>
                            <th class="border border-gray-300 p-2">Booking Date</th>
                            <th class="border border-gray-300 p-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($bookings)) { ?>
                        <tr>
                            <td class="border border-gray-300 p-2"><?php echo htmlspecialchars($row['pg_name']); ?></td>
                            <td class="border border-gray-300 p-2"><?php echo htmlspecialchars($row['location']); ?></td>
                            <td class="border border-gray-300 p-2"><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                            <td class="border border-gray-300 p-2">
                                <?php
                                    if ($row['status'] == 'pending') {
                                        echo "<span class='text-yellow-600 font-semibold'>Pending</span>";
                                    } elseif ($row['status'] == 'confirmed') {
                                        echo "<span class='text-green-600 font-semibold'>Confirmed</span>";
                                    } else {
                                        echo "<span class='text-red-600 font-semibold'>Cancelled</span>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p class="text-gray-500">No bookings found.</p>
            <?php } ?>
        </div>
    </section>

</body>
</html>
