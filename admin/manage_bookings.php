<?php
session_start();
require 'db.php';

// Check if user is logged in and has admin or owner role
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'owner')) {
    header('Location: login.php');
    exit;
}

// Handle booking status update
if (isset($_GET['action']) && isset($_GET['id'])) {
    $booking_id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Approved' WHERE id = ?");
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Rejected' WHERE id = ?");
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
    }
    header('Location: manage_bookings.php');
    exit;
}

// Fetch bookings
if ($_SESSION['role'] === 'owner') {
    // Show only bookings for rooms owned by this owner
    $stmt = $conn->prepare("
        SELECT b.id, u.name AS user_name, r.title AS room_title, b.check_in, b.check_out, b.status
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN rooms r ON b.room_id = r.id
        WHERE r.owner_id = ?
        ORDER BY b.id DESC
    ");
    $stmt->bind_param("i", $_SESSION['user_id']);
} else {
    // Admin sees all bookings
    $stmt = $conn->prepare("
        SELECT b.id, u.name AS user_name, r.title AS room_title, b.check_in, b.check_out, b.status
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN rooms r ON b.room_id = r.id
        ORDER BY b.id DESC
    ");
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-bold mb-4">Manage Bookings</h2>
        <table class="w-full border-collapse bg-white shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-3">ID</th>
                    <th class="border p-3">User</th>
                    <th class="border p-3">Room</th>
                    <th class="border p-3">Check-In</th>
                    <th class="border p-3">Check-Out</th>
                    <th class="border p-3">Status</th>
                    <th class="border p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr class="hover:bg-gray-100">
                    <td class="border p-3"><?= $row['id'] ?></td>
                    <td class="border p-3"><?= htmlspecialchars($row['user_name']) ?></td>
                    <td class="border p-3"><?= htmlspecialchars($row['room_title']) ?></td>
                    <td class="border p-3"><?= $row['check_in'] ?></td>
                    <td class="border p-3"><?= $row['check_out'] ?></td>
                    <td class="border p-3 font-semibold 
                        <?= $row['status'] === 'Approved' ? 'text-green-600' : ($row['status'] === 'Rejected' ? 'text-red-600' : 'text-yellow-600') ?>">
                        <?= $row['status'] ?>
                    </td>
                    <td class="border p-3">
                        <?php if ($row['status'] === 'Pending'): ?>
                            <a href="?action=approve&id=<?= $row['id'] ?>" class="px-3 py-1 bg-green-500 text-white rounded">Approve</a>
                            <a href="?action=reject&id=<?= $row['id'] ?>" class="px-3 py-1 bg-red-500 text-white rounded">Reject</a>
                        <?php endif; ?>
                        <a href="?action=delete&id=<?= $row['id'] ?>" class="px-3 py-1 bg-gray-700 text-white rounded" onclick="return confirm('Delete booking?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mt-4">
            <a href="dashboard_admin.php" class="px-4 py-2 bg-blue-500 text-white rounded">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
