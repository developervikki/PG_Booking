<?php
include '../config/db.php';
include '../includes/header.php';

// Get room ID from URL
if (!isset($_GET['id'])) {
    echo "<p class='text-center text-red-500 mt-5'>Invalid Room ID</p>";
    exit;
}

$room_id = intval($_GET['id']);

// Fetch room details (join with users table for owner info)
$sql = "SELECT rooms.*, users.name AS owner_name, users.phone AS owner_phone
        FROM rooms 
        JOIN users ON rooms.owner_id = users.user_id
        WHERE rooms.room_id = $room_id";
$result = mysqli_query($conn, $sql);
$room = mysqli_fetch_assoc($result);

if (!$room) {
    echo "<p class='text-center text-red-500 mt-5'>Room not found</p>";
    exit;
}

// Correct image path (assuming uploads folder is inside project root)
$imagePath = "../uploads/" . htmlspecialchars($room['image']);
?>

<div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Room Image -->
        <div>
            <img src="<?php echo $imagePath; ?>" 
                 alt="<?php echo htmlspecialchars($room['title']); ?>" 
                 class="w-full h-80 object-cover rounded-lg">
        </div>

        <!-- Room Details -->
        <div>
            <h1 class="text-3xl font-bold mb-2"><?php echo htmlspecialchars($room['title']); ?></h1>
            <p class="text-gray-600 mb-4"><?php echo nl2br(htmlspecialchars($room['description'])); ?></p>

            <p class="text-lg font-semibold text-green-600 mb-2">₹<?php echo number_format($room['price']); ?> / month</p>
            <p class="mb-1"><strong>Location:</strong> <?php echo htmlspecialchars($room['location']); ?></p>
            <p class="mb-1"><strong>Capacity:</strong> <?php echo htmlspecialchars($room['capacity']); ?></p>
            <p class="mb-1"><strong>Available:</strong> <?php echo htmlspecialchars($room['available']); ?></p>

            <!-- Owner Info -->
            <div class="mt-4 bg-gray-100 p-3 rounded-lg">
                <p><strong>Owner:</strong> <?php echo htmlspecialchars($room['owner_name']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($room['owner_phone']); ?></p>
            </div>

            <!-- Book Now Button -->
            <form action="booking.php" method="POST" class="mt-5">
                <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Book Now
                </button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
