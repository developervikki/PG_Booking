<?php
session_start();
include '../config/db.php'; // Your DB connection file
 
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if user exists
    $stmt = $conn->prepare("SELECT user_id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed_password, $role);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Store session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = $role;

            // Redirect based on role
            if ($role == 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } elseif ($role == 'owner') {
                header("Location: ../pages/owner_dashboard.php");
                exit();
            } elseif ($role == 'user') {
                header("Location: user_dashboard.php");
                exit();
            } else {
                $message = "Invalid role.";
            }
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "User not found.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
<div class="bg-white p-8 rounded-lg shadow-md w-96">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    <?php if ($message): ?>
        <p class="text-red-500 text-center mb-4"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" required class="w-full p-2 border border-gray-300 rounded mt-1">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Password</label>
            <input type="password" name="password" required class="w-full p-2 border border-gray-300 rounded mt-1">
        </div>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white p-2 rounded">Login</button>
    </form>
</div>
</body>
</html>
