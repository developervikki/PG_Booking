<?php
include '../includes/header.php';
include '../includes/navbar.php';
include '../config/db.php';

// Get search inputs
$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 999999;
$room_type = isset($_GET['room_type']) ? trim($_GET['room_type']) : '';

// Build SQL query
$sql = "SELECT * FROM rooms WHERE price BETWEEN $min_price AND $max_price";

if ($location != '') {
    $sql .= " AND location LIKE '%" . mysqli_real_escape_string($conn, $location) . "%'";
}
if ($room_type != '') {
    $sql .= " AND room_type = '" . mysqli_real_escape_string($conn, $room_type) . "'";
}

$result = mysqli_query($conn, $sql);
?>

<div class="container mx-auto mt-6 px-4">
    <h1 class="text-3xl font-bold mb-4">Search Rooms</h1>

    <!-- Search Form -->
    <form method="GET" class="bg-white shadow-md rounded-lg p-4 mb-6 flex flex-wrap gap-4">
        <input type="text" name="location" placeholder="Enter location" value="<?php echo htmlspecialchars($location); ?>" class="border p-2 rounded w-full md:w-1/4">

        <input type="number" name="min_price" placeholder="Min Price" value="<?php echo $min_price; ?>" class="border p-2 rounded w-full md:w-1/6">
        <input type="number" name="max_price" placeholder="Max Price" value="<?php echo $max_price; ?>" class="border p-2 rounded w-full md:w-1/6">

        <select name="room_type" class="border p-2 rounded w-full md:w-1/4">
            <option value="">All Types</option>
            <option value="Single" <?php if ($room_type == 'Single') echo 'selected'; ?>>Single</option>
            <option value="Double" <?php if ($room_type == 'Double') echo 'selected'; ?>>Double</option>
            <option value="PG" <?php if ($room_type == 'PG') echo 'selected'; ?>>PG</option>
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button>
    </form>

    <!-- Search Results -->
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <div class="grid md:grid-cols-3 gap-6">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    
                    <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Room Image" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold"><?php echo $row['title']; ?></h2>
                        <p class="text-gray-600"><?php echo $row['location']; ?></p>
                        <p class="text-green-600 font-bold">₹<?php echo $row['price']; ?> / month</p>
                        <p class="text-sm text-gray-500">Capacity: <?php echo $row['capacity']; ?></p>
                        <a href="room_details.php?id=<?php echo $row['room_id']; ?>" class="mt-3 inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">View Details</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="text-red-500">No rooms found for your search criteria.</p>
    <?php } ?>
</div>

<?php include '../includes/footer.php'; ?>
