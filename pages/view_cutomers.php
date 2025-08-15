
<?php
require '../config/db.php';
session_start();

// Ensure only admin or owner can access
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['admin', 'owner'])) { 
    header("Location: ../auth/login.php");
    exit();
}

// Prepare query to get customers (role = 'user')
$stmt = $conn->prepare("
    SELECT user_id, name, email, phone, created_at
    FROM users
    WHERE role = 'user'
    ORDER BY user_id DESC
");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Registered Customers</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 border text-left">Customer ID</th>
                        <th class="p-3 border text-left">Name</th>
                        <th class="p-3 border text-left">Email</th>
                        <th class="p-3 border text-left">Phone</th>
                        <th class="p-3 border text-left">Joined On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="p-3 border"><?php echo $row['user_id']; ?></td>
                            <td class="p-3 border"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="p-3 border"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="p-3 border"><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td class="p-3 border"><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-600">No customers found.</p>
    <?php endif; ?>

    <div class="mt-6">
        <a href="../dashboard.php" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
