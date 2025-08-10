<?php
// index.php - Main Landing Page
require 'config/db.php'; // connect to database
?>
<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PG Booking - Find Your Perfect Stay</title>
    <link href="assets/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Include Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-500 to-pink-500 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Find Your Perfect PG or Room</h1>
            <p class="text-lg mb-6">Search and book the best PG accommodations easily</p>
            <a href="pages/search.php" class="bg-white text-indigo-600 px-6 py-3 rounded-lg shadow-lg hover:bg-gray-200 transition">Start Searching</a>
        </div>
    </section>

    <!-- Featured Rooms -->
    <section class="py-12">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold mb-8 text-center">Featured Rooms</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                // Fetch latest rooms from database
                $query = "SELECT room_id, title, price, image FROM rooms ORDER BY created_at DESC LIMIT 6";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($room = mysqli_fetch_assoc($result)) {
                        $imagePath = "uploads/" . htmlspecialchars($room['image']);
                        echo '<div class="bg-white shadow-lg rounded-lg overflow-hidden">';
                        echo '<img src="'.$imagePath.'" alt="'.htmlspecialchars($room['title']).'" class="w-full h-48 object-cover">';
                        echo '<div class="p-4">';
                        echo '<h3 class="text-xl font-semibold mb-2">'.htmlspecialchars($room['title']).'</h3>';
                        echo '<p class="text-indigo-600 font-bold">₹'.number_format($room['price']).'/month</p>';
                        echo '<a href="pages/room_details.php?id='.$room['room_id'].'" class="mt-3 inline-block text-white bg-indigo-500 px-4 py-2 rounded hover:bg-indigo-600">View Details</a>';
                        echo '</div></div>';
                    }
                } else {
                    echo '<p class="col-span-3 text-center text-gray-500">No rooms available right now.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

</body>
</html>
