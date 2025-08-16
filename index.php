<?php
// index.php - Main Landing Page
require 'config/db.php'; // connect to database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title>PG Booking - Find Your Perfect Stay</title>
    <meta name="description" content="Find & book affordable PGs and rooms easily. Explore categories, featured rooms, customer testimonials, and start your booking today!" />
    <link href="assets/css/tailwind.min.css" rel="stylesheet" />
    <link rel="canonical" href="https://yourdomain.com/" />
    <style>
      /* Back to top button style */
      #backToTop {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background-color: #4F46E5; /* Indigo-600 */
        color: white;
        padding: 0.75rem 1rem;
        border-radius: 9999px;
        cursor: pointer;
        display: none;
        z-index: 100;
        box-shadow: 0 4px 8px rgba(79,70,229,0.4);
        transition: background-color 0.3s ease;
      }
      #backToTop:hover {
        background-color: #4338CA; /* Indigo-700 */
      }
    </style>

    <!-- Structured Data JSON-LD for SEO -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "PG Booking",
      "url": "https://yourdomain.com/",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://yourdomain.com/pages/search.php?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>

</head>
<body class="bg-gray-50 font-sans">

    <!-- Header & Navbar -->
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/navbar.php'; ?>

    <!-- Sticky Navbar Enhancement -->
    <script>
      window.addEventListener('scroll', function () {
        const nav = document.querySelector('nav');
        if (window.scrollY > 60) {
          nav.classList.add('fixed', 'top-0', 'left-0', 'right-0', 'shadow-lg', 'bg-white', 'z-50');
        } else {
          nav.classList.remove('fixed', 'top-0', 'left-0', 'right-0', 'shadow-lg', 'bg-white', 'z-50');
        }
      });
    </script>

    <!-- Hero Section with Search -->
    <section class="relative bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-500 text-white">
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        <div class="container mx-auto px-6 py-28 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4" tabindex="0">Find Your Perfect PG or Room</h1>
            <p class="text-lg md:text-xl mb-8 opacity-90" aria-live="polite">Book the best accommodations with ease & confidence</p>

            <!-- Search Form -->
            <form action="pages/search.php" method="GET" class="bg-white rounded-xl shadow-lg flex flex-wrap md:flex-nowrap max-w-4xl mx-auto overflow-hidden" role="search" aria-label="Search PG or rooms">
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Search by location..." 
                    class="flex-grow px-4 py-3 text-gray-700 focus:outline-none w-full md:w-auto"
                    title="Enter location"
                    aria-required="false" 
                    aria-label="Search by location"
                    pattern="[a-zA-Z\s]+" 
                    oninvalid="this.setCustomValidity('Please enter a valid location')" 
                    oninput="setCustomValidity('')"
                >
                <select name="type" class="px-4 py-3 border-l focus:outline-none text-gray-700 w-full md:w-auto" aria-label="Select room type">
                    <option value="">All Types</option>
                    <option value="single">Single Room</option>
                    <option value="double">Double Sharing</option>
                    <option value="triple">Triple Sharing</option>
                </select>
                <select name="price" class="px-4 py-3 border-l focus:outline-none text-gray-700 w-full md:w-auto" aria-label="Select maximum price">
                    <option value="">Any Price</option>
                    <option value="5000">Under ₹5,000</option>
                    <option value="10000">Under ₹10,000</option>
                    <option value="15000">Under ₹15,000</option>
                </select>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 font-semibold transition" aria-label="Search PG or rooms">Search</button>
            </form>
        </div>
    </section>

    <!-- Categories Section -->
    <?php
    // Fetch categories from DB
    $categories_result = $conn->query("SELECT title, description, image FROM rooms ORDER BY room_id ASC");
    ?>
    <section class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-12" tabindex="0">Explore by Category</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php while ($category = $categories_result->fetch_assoc()) : ?>
                    <div tabindex="0" class="bg-white rounded-lg shadow hover:shadow-xl transition p-6 text-center cursor-pointer focus:outline-none focus:ring-4 focus:ring-indigo-300" aria-label="<?= htmlspecialchars($category['title']) ?> category">
                        <img loading="lazy" src="./uploads/<?= htmlspecialchars($category['image']) ?>" 
                             alt="<?= htmlspecialchars($category['title']) ?>" 
                             class="w-full h-48 object-cover rounded mb-4">
                        <h3 class="font-semibold text-xl mb-2"><?= htmlspecialchars($category['title']) ?></h3>
                        <p class="text-gray-600"><?= htmlspecialchars($category['description']) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Featured Rooms -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-10" tabindex="0">Featured Rooms</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                <?php
                $query = "SELECT room_id, title, price, image, created_at FROM rooms ORDER BY created_at DESC LIMIT 6";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($room = mysqli_fetch_assoc($result)) {
                        $imagePath = "uploads/" . htmlspecialchars($room['image']);
                        $created_at = strtotime($room['created_at']);
                        $isNew = (time() - $created_at) < 30*24*60*60; // 30 days
                        ?>
                        <div tabindex="0" class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 relative">
                            <?php if ($isNew): ?>
                                <div class="absolute top-3 left-3 bg-indigo-600 text-white text-xs font-bold px-2 py-1 rounded">New</div>
                            <?php endif; ?>
                            <img loading="lazy" src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($room['title']); ?>" class="w-full h-52 object-cover" />
                            <div class="p-5">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($room['title']); ?></h3>
                                <p class="text-indigo-600 font-bold text-lg">₹<?php echo number_format($room['price']); ?>/month</p>
                                <a href="pages/room_details.php?id=<?php echo $room['room_id']; ?>" class="mt-4 inline-block bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2 rounded-lg transition" aria-label="View details for <?php echo htmlspecialchars($room['title']); ?>">View Details</a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="col-span-3 text-center text-gray-500">No rooms available at the moment.</p>';
                }
                ?>

            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-12" tabindex="0">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php 
                $steps = [
                    ['1', 'Search', 'Find PGs & rooms by location, price, or amenities.'],
                    ['2', 'Compare', 'Compare rooms and choose the one that fits your needs.'],
                    ['3', 'Book', 'Reserve your room instantly with secure payment.']
                ];
                foreach($steps as $step): ?>
                    <div tabindex="0" class="focus:outline-none focus:ring-4 focus:ring-indigo-300">
                        <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-indigo-600 text-2xl font-bold"><?= $step[0] ?></span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2"><?= $step[1] ?></h3>
                        <p class="text-gray-600"><?= $step[2] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-10" tabindex="0">What Our Customers Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <?php 
                $testimonials = [
                    ['"Booking my PG was so easy! I found the perfect place in just minutes."', "Priya Sharma", 5],
                    ['"Affordable and trustworthy listings. Highly recommended!"', "Rahul Mehta", 4],
                    ['"I loved how smooth the booking process was."', "Ananya Verma", 5]
                ];
                foreach($testimonials as $t): ?>
                    <div tabindex="0" class="bg-white p-6 rounded-lg shadow hover:shadow-xl transition">
                        <p class="text-gray-600 italic mb-4"><?= $t[0] ?></p>
                        <div class="mb-2">
                            <?php for($i=0; $i < 5; $i++): ?>
                                <svg aria-hidden="true" class="inline w-5 h-5 <?= ($i < $t[2]) ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                  <title><?= ($i < $t[2]) ? 'Filled star' : 'Empty star' ?></title>
                                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.966a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.39 2.46a1 1 0 00-.364 1.118l1.287 3.967c.3.921-.755 1.688-1.538 1.118l-3.39-2.46a1 1 0 00-1.175 0l-3.39 2.46c-.783.57-1.838-.197-1.538-1.118l1.287-3.967a1 1 0 00-.364-1.118L2.045 9.393c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.966z"></path>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <h4 class="mt-4 font-semibold"><?= $t[1] ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-indigo-600 text-white py-12 text-center">
        <h2 class="text-2xl md:text-3xl font-semibold mb-4 animate-pulse" tabindex="0">Ready to Book Your Stay?</h2>
        <p class="mb-6 opacity-90">Start exploring the best PG options today.</p>
        <a href="pages/search.php" class="bg-white text-indigo-600 font-medium px-6 py-3 rounded-lg shadow hover:bg-gray-200 transition" aria-label="Start searching for PGs">Search Now</a>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Back to Top Button -->
    <button id="backToTop" aria-label="Back to top" title="Back to top">↑</button>

    <script>
      // Back to top button behavior
      const backToTopButton = document.getElementById('backToTop');
      window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
          backToTopButton.style.display = 'block';
        } else {
          backToTopButton.style.display = 'none';
        }
      });
      backToTopButton.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });

      // Smooth scroll for internal anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
          anchor.addEventListener('click', function (e) {
              e.preventDefault();
              document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
          });
      });
    </script>

</body>
</html>
