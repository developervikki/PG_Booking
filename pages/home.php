<?php
session_start();
include 'db.php'; // Database connection
include 'header.php';
?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Find Your Perfect PG or Hostel</h1>
        <p class="text-lg mb-6">Search from thousands of verified PGs, hostels, and rental rooms across India.</p>
        
        <!-- Search Form -->
        <form action="search.php" method="GET" class="flex flex-col md:flex-row items-center justify-center gap-2">
            <input type="text" name="location" placeholder="Enter location" class="px-4 py-2 rounded-lg text-black w-full md:w-1/3" required>
            <select name="type" class="px-4 py-2 rounded-lg text-black w-full md:w-1/4">
                <option value="">Any Type</option>
                <option value="PG">PG</option>
                <option value="Hostel">Hostel</option>
                <option value="Room">Room</option>
            </select>
            <button type="submit" class="bg-yellow-400 text-black px-6 py-2 rounded-lg hover:bg-yellow-500 transition">Search</button>
        </form>
    </div>
</section>

<!-- Featured PGs -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Featured Listings</h2>

        <div class="grid md:grid-cols-3 gap-6">
            <?php
            $query = "SELECT * FROM properties ORDER BY id DESC LIMIT 6";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                        <img src="uploads/' . $row['image'] . '" alt="' . $row['title'] . '" class="h-48 w-full object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">' . $row['title'] . '</h3>
                            <p class="text-gray-600">' . $row['location'] . '</p>
                            <p class="text-blue-600 font-bold">₹' . $row['price'] . '/month</p>
                            <a href="view_property.php?id=' . $row['id'] . '" class="block mt-4 text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">View Details</a>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>No properties found.</p>';
            }
            ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
