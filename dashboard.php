<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .dashboard {
            display: flex;
            justify-content: space-between;
            width: 600px;     
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .section {
          
            margin-bottom: 10px;
            text-align: left; /* Align text to the left */
        }

        .section-title {
            font-weight: bold;
            font-size: 24px; /* Increased font size */
            text-align: center; /* Center the title */
        }
       
        .section-content {
            font-size: 18px;
        }

        .section-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
         .logout-button {
            margin-top: 20px; /* Add some space */
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .logout-container {
    
            justify-content: center;
            align-items: center;
            margin-top: 210px;
        
        }

        .logout-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
          margin-left: -350px;
        }

        .logout-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    include 'config.php'; // Include the database configuration

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php"); // Redirect to login if not logged in
        exit();
    }

    $username = $_SESSION['username'];

    try {
        $stmt = $conn->prepare("SELECT * FROM accounts WHERE login = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $playerData = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
  
    <div class="dashboard">    
 
        <div class="profile">     
    
            <div class="section">
                <div class="section-content">IGN: <?php echo $playerData['player_name']; ?></div>
            </div>
            <div class="section">
                <div class="section-content">Username: <?php echo $playerData['login']; ?></div>
            </div>
            <div class="section">
                <div class="section-content">Points: <?php echo $playerData['gp']; ?></div>
            </div>
            <div class="section">
                <div class="section-content">Cash: $<?php echo $playerData['money']; ?></div>
            </div>
        </div>
       <div class="record">
           
            <div class="section-container">
                <div class="section">
                    <div class="section-content">Exp: <?php echo $playerData['exp']; ?></div>
                </div>
                <div class="section">
                    <div class="section-content">Win: <?php echo $playerData['fights_win']; ?></div>
                </div>
                <div class="section">
                    <div class="section-content">Loss: <?php echo $playerData['fights_lost']; ?></div>
                </div>
                <div class="section">
                    <div class="section-content">Kills: <?php echo $playerData['kills_count']; ?></div>
                </div>
                <div class="section">
                    <div class="section-content">Death: <?php echo $playerData['deaths_count']; ?></div>
                </div>
            </div>
        </div>
    </div>
 

<!-- Footer section with the logout button -->
<div class="logout-container">
        <button class="logout-button" onclick="location.href='logout.php'">Logout</button>
    </div>
</body>
</html>
