<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F0F4F8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 90%;
            max-width: 800px;
        }

        .img {
            flex: 1;
            background-color: #F7FAFC;
        }

        .img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        form {
            flex: 1;
            padding: 40px;
            box-sizing: border-box;
        }

        h6 {
            font-size: 1rem;
            margin-bottom: 8px;
            color: #2D3748;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 24px;
        }

        .input-group.success input {
            border-color: #48BB78;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #CBD5E0;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus {
            border-color: #3182CE;
            outline: none;
            box-shadow: 0 0 8px rgba(49, 130, 206, 0.5);
        }

        button {
            width: 100%;
            background-color: #3182CE;
            padding: 14px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            color: #FFFFFF;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2B6CB0;
        }

        .text-center {
            text-align: center;
            margin-top: 24px; 
        }

        .text-center a {
            color: #3182CE;
            text-decoration: none;
            font-weight: 600;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .error, .success {
            color: #E53E3E; 
            font-size: 0.875rem;
            margin-top: 8px;
            height: 15px;
        }

        .success {
            color: #48BB78;
        }

        .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #E53E3E;
            color: #FFFFFF;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 0.875rem;
            display: none;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .notification.show {
            display: block;
        }

        .success-message-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #48BB78;
            color: #fff;
            padding: 20px 40px;
            border-radius: 8px;
            font-size: 1.25rem;
            text-align: center;
            display: none;

        }

        .success-message-popup.show {
            display: block;
        }

        .notification-center {
            position: fixed;
            top: 20px;
            left: 50%;
            background-color: #E53E3E;
            color: #FFFFFF;
            padding: 15px 30px;
            border-radius: 6px;
            font-size: 1rem;
            display: none;

        }

        .notification-center.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="img">
            <img src="../view/src/Privacy policy-rafiki.png" alt="Login Image">
        </div>
        <form id="loginForm" method="post" action="../controller/loginForm.php">
            <div class="input-group" id="emailGroup">
                <h6>Email</h6>
                <input type="email" name="email" id="email" placeholder="name@mail.com" />
                <div id="emailError" class="error" aria-live="assertive"></div>
            </div>
            <div class="input-group" id="passwordGroup">
                <h6>Password</h6>
                <input type="password" name="password" id="password" placeholder="Password" />
                <div id="passwordError" class="error" aria-live="assertive"></div>
            </div>
            <button type="submit">Login</button>
            <div class="text-center">
                <h6>Don't have an account? <a href="./register.php">Register</a></h6>
            </div>
            <div id="successMessage" class="success" aria-live="assertive"></div>
        </form>
    </div>

    <div id="successPopup" class="success-message-popup">
        Login successfull
    </div>

    <div id="centeredNotification" class="notification-center">
        User not registered. Please register first.
    </div>

    <div id="notification" class="notification"></div>

    <script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        let valid = true;

        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        const successPopup = document.getElementById('successPopup');
        const notification = document.getElementById('notification');
        const centeredNotification = document.getElementById('centeredNotification');

        emailError.textContent = '';
        passwordError.textContent = '';
        notification.textContent = '';
        centeredNotification.textContent = '';

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value)) {
            emailError.textContent = 'Please enter a valid email address.';
            valid = false;
        }

        if (passwordInput.value.trim() === '') {
            passwordError.textContent = 'Please enter a password.';
            valid = false;
        } else if (passwordInput.value.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters.';
            valid = false;
        }

        if (valid) {
            const formData = new FormData(document.getElementById('loginForm'));

            fetch('../controller/loginForm.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    successPopup.classList.add('show'); 

                    if (data.role === 'admin') {
                        setTimeout(() => {
                            window.location.href = './home.php'; 
                        }, 3000);
                    } else {
                        setTimeout(() => {
                            window.location.href = './register.php'; 
                        }, 3000);
                    }
                } else {
                    notification.textContent = data.message;
                    notification.classList.add('show');
                    setTimeout(() => {
                        notification.classList.remove('show');
                    }, 3000);
                }
            })
            .catch(error => {
                notification.textContent = 'An error occurred, please try again.';
                notification.classList.add('show');
                setTimeout(() => {
                    notification.classList.remove('show');
                }, 3000);
            });
        }
    });
    </script>

</body>
</html>
