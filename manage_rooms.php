<?php
session_start();
require '../config/db.php';

// Allow only logged-in owners or admins
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'owner') {
    header("Location: ../auth/login.php"); // Change path as per your folder structure
    exit();
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

// Handle Add Room
if (isset($_POST['add_room'])) {
    $room_name = mysqli_real_escape_string($conn, $_POST['room_name']);
    $price = $_POST['price'];
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        $target = "../uploads/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $owner_id = ($user_role === 'owner') ? $user_id : null;

    $query = "INSERT INTO rooms (owner_id, title, price, description, location, image) 
              VALUES ('$owner_id', '$room_name', '$price', '$description', '$location', '$image')";
    mysqli_query($conn, $query);
}

// Handle Delete Room
if (isset($_GET['delete'])) {
    $room_id = $_GET['delete'];
    if ($user_role === 'owner') {
        mysqli_query($conn, "DELETE FROM rooms WHERE room_id='$room_id' AND owner_id='$user_id'");
    } else {
        mysqli_query($conn, "DELETE FROM rooms WHERE id='$room_id'");
    }
}

// Fetch Rooms (owner sees own rooms, admin sees all)
if ($user_role === 'owner') {
    $rooms = mysqli_query($conn, "SELECT * FROM rooms WHERE owner_id='$user_id'");
} else {
    $rooms = mysqli_query($conn, "SELECT * FROM rooms");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Header -->
<div class="bg-blue-600 p-4 text-white flex justify-between">
    <h1 class="text-xl font-bold">
        <?php echo ucfirst($user_role); ?> - Manage Rooms
    </h1>
    <a href="../auth/logout.php" class="bg-red-500 px-3 py-1 rounded">Logout</a>
</div>

<!-- Main Content -->
<div class="max-w-6xl mx-auto p-6">

    <!-- Add Room Form -->
    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow mb-6">
        <h2 class="text-xl font-bold mb-4">Add New Room</h2>
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
                                <img src="../uploads/<?php echo $room['image']; ?>" width="80">
                            <?php } else { ?>
                                No Image
                            <?php } ?>
                        </td>
                        <td class="p-2 border"><?php echo htmlspecialchars($room['title']); ?></td>
                        <td class="p-2 border"><?php echo htmlspecialchars($room['price']); ?></td>
                        <td class="p-2 border"><?php echo htmlspecialchars($room['location']); ?></td>
                        <td class="p-2 border"><?php echo htmlspecialchars($room['description']); ?></td>
                        <td class="p-2 border">
                            <a href="?delete=<?php echo $room['room_id']; ?>" onclick="return confirm('Delete this room?')" class="bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
