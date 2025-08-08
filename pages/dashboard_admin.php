<?php
session_start();
require_once '../config/db.php';

// Only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Fetch Users
$users = $conn->query("SELECT user_id, name, email, role, created_at FROM users ORDER BY created_at DESC");

// Fetch Rooms
$rooms = $conn->query("SELECT rooms.room_id, rooms.title, rooms.location, rooms.price, users.name AS owner_name 
                       FROM rooms 
                       JOIN users ON rooms.owner_id = users.user_id 
                       ORDER BY rooms.created_at DESC");

// Fetch Bookings
$bookings = $conn->query("SELECT bookings.booking_id, users.name AS user_name, rooms.title AS room_title, bookings.check_in, bookings.check_out, bookings.status
                          FROM bookings
                          JOIN users ON bookings.user_id = users.user_id
                          JOIN rooms ON bookings.room_id = rooms.room_id
                          ORDER BY bookings.created_at DESC");

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

    <!-- USERS TABLE -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Manage Users</h2>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">Role</th>
                        <th class="py-3 px-4 text-left">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users->fetch_assoc()): ?>
                        <tr class="border-b">
                            <td class="py-2 px-4"><?php echo $user['user_id']; ?></td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($user['name']); ?></td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="py-2 px-4"><?php echo ucfirst($user['role']); ?></td>
                            <td class="py-2 px-4"><?php echo $user['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ROOMS TABLE -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Manage Rooms</h2>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Title</th>
