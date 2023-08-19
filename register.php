<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
        body {
            margin: 0;
            background: url('image.jpg') center/cover no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #fff;
        }

        .popup-content {
            background-color: white;
            width: 500px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative; /* To position the close button */
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-input {
            width: 100%;
            padding: 5px 5px 5px 5px;
            margin-bottom: 10px;
        }

        .centered-button {
            text-align: center;
        }

        .success-message {
            text-align: center;
            color: black;
            background-color: #C5DFF8;
            padding: 5px;
            border-radius: 5px;
        }

        .error-message {
            color: black;
        }

        .hidden {
            display: none;
        }

        .custom-button {
            background-color: #1F6E8C; /* Tortoise color */
            color: white;
            padding: 10px 20px; /* Increased button size */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #titol {
            text-align: center;
        }

        #backButton {
            cursor: pointer;
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 24px;
        }

        #backButton:hover {
            color: red; /* Emphasize the button on hover */
        }
    </style>
    <script>
        function hideMessage() {
            var messageElement = document.getElementById('message');
            messageElement.classList.add('hidden');
        }

        setTimeout(hideMessage, 20000);

        function goToIndex() {
            window.location.href = 'index.html';
        }
    </script>
</head>
<body>
    <div class="popup-background" id="registrationPopup">
        <div class="popup-content">
            <span id="backButton" onclick="goToIndex()">&#10006;</span>
            <h2 id="titol">Registration Form</h2>
            <?php if (isset($_GET['message'])): ?>
                <?php
                $messageText = $_GET['message'];
                $messageClass = (strpos($messageText, 'successful') !== false) ? 'success-message' : 'error-message';
                ?>
                <p id="message" class="<?php echo $messageClass; ?>"><?php echo $messageText; ?></p>
            <?php endif; ?>
            <form method="POST" action="process_registration.php">
                <label class="form-label" for="username">Username:</label>
                <input class="form-input" type="text" id="username" name="username" required>

                <label class="form-label" for="password">Password:</label>
                <input class="form-input" type="password" id="password" name="password" required>

                <label class="form-label" for="email">Email:</label>
                <input class="form-input" type="email" id="email" name="email" required>

                <div class="centered-button">
                    <button class="custom-button" type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
