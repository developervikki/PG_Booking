<?php
session_start();
include 'db.php';

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    
    exit();
}

// Delete User
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM users WHERE id = $id";
    mysqli_query($conn, $delete_sql);
    header('Location: manage_users.php');
    exit();
}

// Fetch Users
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<?php include 'navbar.php'; ?>

<div class="max-w-6xl mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-2xl font-bold mb-4">Manage Users</h1>

    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-3 border">ID</th>
                <th class="p-3 border">Name</th>
                <th class="p-3 border">Email</th>
                <th class="p-3 border">Role</th>
                <th class="p-3 border">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border"><?php echo $row['id']; ?></td>
                    <td class="p-3 border"><?php echo $row['name']; ?></td>
                    <td class="p-3 border"><?php echo $row['email']; ?></td>
                    <td class="p-3 border capitalize"><?php echo $row['role']; ?></td>
                    <td class="p-3 border text-center">
                        <a href="?delete=<?php echo $row['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this user?')"
                           class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
