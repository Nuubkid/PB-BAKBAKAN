<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <style>
        body {
            background: url('image.jpg') center/cover no-repeat;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 500px;
            position: relative;
        }

        .close-link {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #ccc;
            cursor: pointer;
            text-decoration: none;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 87%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php
    include 'config.php'; // Include the database configuration

    $loginError = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $inputUsername = $_POST["username"];
        $inputPassword = $_POST["password"];

        try {
            $stmt = $conn->prepare("SELECT * FROM accounts WHERE login = :username");
            $stmt->bindParam(':username', $inputUsername);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData && gerar_hash($inputPassword) === $userData['password']) {
                // Successful login
                session_start();
                $_SESSION['username'] = $userData['login'];
                header("Location: dashboard.php"); // Redirect to the dashboard page
                exit(); // Ensure that the script stops execution after redirect
            } else {
                $loginError = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $loginError = "An error occurred while processing your request.";
            // Uncomment the line below to see detailed error information during debugging
            // echo "Error: " . $e->getMessage();
        }
    }

    function gerar_hash($senha){
        $salt = '/x!a@r-$r%an¨.&e&+f*f(f(a)';
        $output = hash_hmac('md5', $senha, $salt);
        return $output;
    }
    ?>
    
    <div class="login-form">
        <a href="index.html" class="close-link">&times;</a>
        <h2>Login Form</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button class="login-button" type="submit">Login</button>
            <div class="error-message"><?php echo $loginError; ?></div>
        </form>
    </div>
</body>
</html>
