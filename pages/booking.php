<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit; 
}
 
// Get room ID from URL
if (!isset($_GET['room_id'])) {
    die("Room ID not specified.");
}
$room_id = intval($_GET['room_id']);

// Fetch room details
$stmt = $conn->prepare("SELECT * FROM rooms WHERE room_id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$room = $stmt->get_result()->fetch_assoc();

if (!$room) {
    die("Room not found.");
}

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (room_id, user_id, check_in, check_out, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("iiss", $room_id, $_SESSION['user_id'], $check_in, $check_out);
    
    if ($stmt->execute()) {
        $success_message = "Booking request submitted successfully!";
    } else {
        $error_message = "Error booking room.";
    }
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Book: <?php echo htmlspecialchars($room['title']); ?></h1>

    <?php if (!empty($success_message)): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            <?php echo $success_message; ?>
        </div>
    <?php elseif (!empty($error_message)): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-6 rounded shadow-md">
        <img src="../<?php echo $room['image'] ?? 'assets/images/default-room.jpg'; ?>" alt="Room Image" class="w-full h-64 object-cover rounded mb-4">
        <p class="mb-2"><strong>Location:</strong> <?php echo htmlspecialchars($room['location']); ?></p>
        <p class="mb-2"><strong>Price:</strong> ₹<?php echo number_format($room['price']); ?> / month</p>
        <p class="mb-4"><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($room['description'])); ?></p>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block font-semibold mb-1">Check-in Date</label>
                <input type="date" name="check_in" required class="border border-gray-300 rounded px-3 py-2 w-full">
            </div>
            <div>
                <label class="block font-semibold mb-1">Check-out Date</label>
                <input type="date" name="check_out" required class="border border-gray-300 rounded px-3 py-2 w-full">
            </div>
            <button type="submit" class="bg-indigo-500 text-white px-6 py-2 rounded hover:bg-indigo-600">Confirm Booking</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
