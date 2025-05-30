<?php

include("../includes/header.php");
include("../includes/navbar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        include("../config.php");
        $conn = connectDB();

        if ($conn) {
            try {
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Check if user exists
                if ($user) {
                    // Verify hashed password
                    if (password_verify($password, $user['password'])) {
                        // User authenticated successfully
                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];

                        // Redirect to dashboard or home page
                        header("Location: ../index.php");
                        exit();
                    } else {
                        $errors[] = "Invalid username or password.";
                    }
                } else {
                    $errors[] = "Invalid username or password.";
                }
            } catch (PDOException $e) {
                $errors[] = "Database error: " . $e->getMessage();
            }
        } else {
            $errors[] = "Failed to connect to the database.";
        }
    }

    // Display errors if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>" . htmlspecialchars($error) . "</p>";
        }
    }
}
?>



<div class="container">
    <h1 class="title">Login Page</h1>
    <form class="form" action="login.php" method="POST">
        <div class="field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                placeholder="Enter your username" required>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                placeholder="Enter your password" required>
        </div>

        <div class="field">
            <button type="submit" class="btn-login">Login</button>
        </div>

        <div class="register">
            <p>Don't have an account?</p>
            <a href="register.php"><button type="button" class="btn-register">Register</button></a>
        </div>
    </form>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
    }

    .container {
        max-width: 400px;
        margin: 0 auto;
        background-color: white;
        padding: 40px;
        border: 1px solid #ddd;
    }

    .title {
        text-align: center;
        margin-bottom: 30px;
        font-size: 24px;
        color: #333;
        font-weight: normal;
    }

    .form {
        width: 100%;
    }

    .field {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #333;
        font-size: 14px;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        font-size: 14px;
        background-color: white;
    }

    input:focus {
        outline: none;
        border-color: #333;
    }

    .btn-login {
        width: 100%;
        padding: 12px;
        background-color: #333;
        color: white;
        border: none;
        font-size: 16px;
        cursor: pointer;
    }

    .btn-login:hover {
        background-color: #000;
    }

    .register {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .register p {
        margin-bottom: 10px;
        color: #666;
        font-size: 14px;
    }

    .btn-register {
        background-color: white;
        color: #333;
        border: 1px solid #333;
        padding: 8px 16px;
        font-size: 14px;
        cursor: pointer;
    }

    .btn-register:hover {
        background-color: #333;
        color: white;
    }

    @media (max-width: 480px) {
        .container {
            padding: 30px 20px;
        }
    }
</style>

<?php include("../includes/footer.php"); ?>