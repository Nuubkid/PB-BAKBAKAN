<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include 'config.php'; // Include the database configuration

    $login = $_POST["username"];
    $rawPassword = $_POST["password"];
    $email = $_POST["email"];

    // Check minimum login length
    if (strlen($login) < 5) {
        $message = " Minimum Usernamelength is 5 characters.";
        header("Location: register.php?message=" . urlencode($message));
        exit;
    }

    // Check minimum password length
    if (strlen($rawPassword) < 8) {
        $message = "Minimum password length is 8 characters.";
        header("Location: register.php?message=" . urlencode($message));
        exit;
    }

    // Check if login already exists
    $checkLoginSql = "SELECT COUNT(*) AS count FROM accounts WHERE login = :login";
    $checkLoginStmt = $conn->prepare($checkLoginSql);
    $checkLoginStmt->bindParam(':login', $login);
    $checkLoginStmt->execute();
    $loginCount = $checkLoginStmt->fetch(PDO::FETCH_ASSOC)['count'];
    if ($loginCount > 0) {
        $message = "Username already exists.";
        header("Location: register.php?message=" . urlencode($message));
        exit;
    }

    // Check if email already exists
    $checkEmailSql = "SELECT COUNT(*) AS count FROM accounts WHERE email = :email";
    $checkEmailStmt = $conn->prepare($checkEmailSql);
    $checkEmailStmt->bindParam(':email', $email);
    $checkEmailStmt->execute();
    $emailCount = $checkEmailStmt->fetch(PDO::FETCH_ASSOC)['count'];
    if ($emailCount > 0) {
        $message = "Email is already registered.";
        header("Location: register.php?message=" . urlencode($message));
        exit;
    }

    // Include your gerar_hash function here
    function gerar_hash($senha){
        $salt = '/x!a@r-$r%an¨.&e&+f*f(f(a)';
        $output = hash_hmac('md5', $senha, $salt);
        return $output;
    }

    $hashedPassword = gerar_hash($rawPassword);

    $sql = "INSERT INTO accounts (login, password, email) VALUES (:login, :password, :email)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        $message = "Data inserted successfully!";
    } else {
        $message = "Error: Data insertion failed.";
    }

    // Redirect back to register.php with a message
    header("Location: register.php?message=" . urlencode($message));
    exit;
}
?>
