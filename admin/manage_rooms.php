<?php
session_start();
require 'db.php';
 
// Check if owner is logged in 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: login.php");
    exit();
}



$owner_id = $_SESSION['user_id'];

// Add Room
if (isset($_POST['add_room'])) {
    $room_name = mysqli_real_escape_string($conn, $_POST['room_name']);
    $price = $_POST['price'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    // Image Upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        $target = "uploads/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $query = "INSERT INTO rooms (owner_id, room_name, price, description, location, image) 
              VALUES ('$owner_id', '$room_name', '$price', '$description', '$location', '$image')";
    mysqli_query($conn, $query);
}

// Delete Room
if (isset($_GET['delete'])) {
    $room_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM rooms WHERE id='$room_id' AND owner_id='$owner_id'");
}

// Fetch Rooms
$rooms = mysqli_query($conn, "SELECT * FROM rooms WHERE owner_id='$owner_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Manage Rooms</h1>

    <!-- Add Room Form -->
    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow mb-6">
        <div class="grid grid-cols-2 gap-4">
            <input type="text" name="room_name" placeholder="Room Name" required class="border p-2 rounded w-full">
            <input type="number" name="price" placeholder="Price per night" required class="border p-2 rounded w-full">
            <input type="text" name="location" placeholder="Location" required class="border p-2 rounded w-full">
            <input type="file" name="image" accept="image/*" class="border p-2 rounded w-full">
            <textarea name="description" placeholder="Description" required class="border p-2 rounded col-span-2"></textarea>
        </div>
        <button type="submit" name="add_room" class="bg-blue-600 text-white px-4 py-2 mt-4 rounded hover:bg-blue-700">Add Room</button>
    </form>

    <!-- Rooms List -->
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Your Rooms</h2>
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Image</th>
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">Price</th>
                    <th class="p-2 border">Location</th>
                    <th class="p-2 border">Description</th>
                    <th class="p-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($room = mysqli_fetch_assoc($rooms)) { ?>
                    <tr>
                        <td class="p-2 border">
                            <?php if ($room['image']) { ?>
                                <img src="uploads/<?php echo $room['image']; ?>" width="80">
                            <?php } else { ?>
                                No Image
                            <?php } ?>
                        </td>
                        <td class="p-2 border"><?php echo $room['room_name']; ?></td>
                        <td class="p-2 border"><?php echo $room['price']; ?></td>
                        <td class="p-2 border"><?php echo $room['location']; ?></td>
                        <td class="p-2 border"><?php echo $room['description']; ?></td>
                        <td class="p-2 border">
                            <a href="?delete=<?php echo $room['id']; ?>" onclick="return confirm('Delete this room?')" class="bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
