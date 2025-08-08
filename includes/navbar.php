<?php
// includes/navbar.php
?>
<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <ul class="flex space-x-6 text-gray-700 font-medium">
            <li><a href="index.php" class="hover:text-indigo-600">Home</a></li>
            <li><a href="pages/search.php" class="hover:text-indigo-600">Search Rooms</a></li>
            <li><a href="pages/booking.php" class="hover:text-indigo-600">My Bookings</a></li>
            <li><a href="pages/dashboard_user.php" class="hover:text-indigo-600">Dashboard</a></li>
        </ul>
        <div>
            <a href="auth/login.php" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition">Login</a>
            <a href="auth/register.php" class="ml-2 border border-indigo-500 text-indigo-500 px-4 py-2 rounded hover:bg-indigo-500 hover:text-white transition">Register</a>
        </div>
    </div>
</nav>
