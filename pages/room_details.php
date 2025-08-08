<?php
include 'db.php';
include 'header.php';

// Get room ID from URL
if (!isset($_GET['id'])) {
    echo "<p class='text-center text-red-500 mt-5'>Invalid Room ID</p>";
    exit;
}

$room_id = intval($_GET['id']);

// Fetch room details
$sql = "SELECT rooms.*, owners.name AS owner_name, owners.phone AS owner_phone
        FROM rooms 
        JOIN owners ON rooms.owner_id = owners.id
        WHERE rooms.id = $room_id";
$result = mysqli_query($conn, $sql);
$room = mysqli_fetch_assoc($result);

if (!$room) {
    echo "<p class='text-center text-red-500 mt-5'>Room not found</p>";
    exit;
}
?>

<div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Room Image -->
        <div>
            <img src="uploads/<?php echo $room['image']; ?>" 
                 alt="<?php echo $room['title']; ?>" 
                 class="w-full h-80 object-cover rounded-lg">
        </div>

        <!-- Room Details -->
        <div>
            <h1 class="text-3xl font-bold mb-2"><?php echo $room['title']; ?></h1>
            <p class="text-gray-600 mb-4"><?php echo $room['description']; ?></p>

            <p class="text-lg font-semibold text-green-600 mb-2">₹<?php echo $room['price']; ?> / month</p>
            <p class="mb-1"><strong>Location:</strong> <?php echo $room['location']; ?></p>
            <p class="mb-1"><strong>Type:</strong> <?php echo $room['type']; ?></p>
            <p class="mb-1"><strong>Available From:</strong> <?php echo $room['available_from']; ?></p>

            <!-- Owner Info -->
            <div class="mt-4 bg-gray-100 p-3 rounded-lg">
                <p><strong>Owner:</strong> <?php echo $room['owner_name']; ?></p>
                <p><strong>Phone:</strong> <?php echo $room['owner_phone']; ?></p>
            </div>

            <!-- Book Now Button -->
            <form action="booking.php" method="POST" class="mt-5">
                <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Book Now
                </button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
