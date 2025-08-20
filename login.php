<?php
$host = "localhost";
$dbname = "user_system";
$username = "root"; // your MySQL username
$password = "";     // your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        session_start();
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["name"] = $user["name"];
        echo "Login successful. Welcome, " . htmlspecialchars($user["name"]);
        // header("Location: dashboard.php"); // redirect if needed
    } else {
        echo "Invalid email or password.";
    }
}
?>
