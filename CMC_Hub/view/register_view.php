<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-wrapper {
            display: flex;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 800px;
        }

        .image {
            flex: 1;
            overflow: hidden;
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }

        .image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .registration-form {
            flex: 1;
            padding: 2rem;
        }

        .registration-form .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .registration-form label {
            display: block;
            font-size: 1rem;
            color: #1f2937;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .registration-form input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            box-sizing: border-box;
            font-size: 0.875rem;
            transition: border-color 0.3s ease;
        }

        .registration-form input:focus {
            border-color: #4b5563;
            outline: none;
        }

        .registration-form .error-message {
            color: #dc2626;
            font-size: 0.75rem;
            display: block;
            margin-top: 0.25rem;
            height: 15px;
        }

        .tooltip {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .tooltip input {
            margin-right: 160px; 
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #f1f5f9;
            color: #333;
            text-align: left;
            border-radius: 0.375rem;
            padding: 10px;
            border: 1px solid #d1d5db;
            position: absolute;
            left: 100%; 
            margin-left: 10px; 
            font-size: 1rem;
        }

        .tooltip .tooltiptext.show {
            visibility: visible;
            opacity: 1;
        }

        .tooltip .valid {
            color: green;
        }

        .tooltip .invalid {
            color: red;
        }

        .tooltip .tooltiptext ul {
            list-style: none;
            padding: 0;
        }

        .tooltip .tooltiptext ul li {
            margin-bottom: 5px;
        }

        .registration-form button {
            width: 100%;
            padding: 0.75rem;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 0.350rem;
            cursor: pointer;
            font-size: 1rem;
        }

        .registration-form button:hover {
            background-color: darkblue;
            color: white;
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }

        .login-link a {
            color: #0ea5e9;
            text-decoration: underline;
        }

        .success-message {
            display: none;
            padding: 1rem;
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #d1fae5;
            border-radius: 0.375rem;
            margin-top: 1rem;
            font-size: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <div class="image">
                <img src="../view/src/Sign up-rafiki.png" alt="Register Image">
            </div>
            <form class="registration-form" id="registerForm" action="../controller/registerForm.php" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Your name">
                    <span class="error-message" id="error-name"></span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="name@mail.com">
                    <span class="error-message" id="error-email"></span>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="tooltip">
                        <input type="password" id="password" name="password" placeholder="Password" oninput="validatePassword()">
                        <span class="tooltiptext" id="password-tooltip">
                            <ul>
                                <li id="length" class="invalid">8-20 Characters</li>
                                <li id="uppercase" class="invalid"> At least one capital letter</li>
                                <li id="number" class="invalid">At least one number</li>
                                <li id="special" class="invalid"> At least one special character</li>
                             
                            </ul>
                        </span>
                    </div>
                    <span class="error-message" id="error-password"></span>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
                    <span class="error-message" id="error-confirm-password"></span>
                </div>
                <div class="form-group">
                    <button type="submit">Register</button>
                </div>
                <p class="login-link">Already have an account? <a href="../login.php">Login</a></p>
            </form>
        </div>
    </div>

    <script>
        function validatePassword() {
            const password = document.getElementById('password').value;
            const tooltip = document.getElementById('password-tooltip');
            tooltip.classList.add('show');

            const length = document.getElementById('length');
            if (password.length >= 8 && password.length <= 20) {
                length.classList.remove('invalid');
                length.classList.add('valid');
            } else {
                length.classList.remove('valid');
                length.classList.add('invalid');
            }

            const uppercase = document.getElementById('uppercase');
            if (/[A-Z]/.test(password)) {
                uppercase.classList.remove('invalid');
                uppercase.classList.add('valid');
            } else {
                uppercase.classList.remove('valid');
                uppercase.classList.add('invalid');
            }

            const number = document.getElementById('number');
            if (/\d/.test(password)) {
                number.classList.remove('invalid');
                number.classList.add('valid');
            } else {
                number.classList.remove('valid');
                number.classList.add('invalid');
            }


            const special = document.getElementById('special');
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                special.classList.remove('invalid');
                special.classList.add('valid');
            } else {
                special.classList.remove('valid');
                special.classList.add('invalid');
            }
        }

        function validateForm() {
            let valid = true;

            const name = document.getElementById('name').value;
            const nameError = document.getElementById('error-name');
            if (name.trim() === '') {
                nameError.textContent = 'Name is required.';
                valid = false;
            } else {
                nameError.textContent = '';
            }

            const email = document.getElementById('email').value;
            const emailError = document.getElementById('error-email');
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                emailError.textContent = 'Please enter a valid email address.';
                valid = false;
            } else {
                emailError.textContent = '';
            }

            const password = document.getElementById('password').value;
            const passwordError = document.getElementById('error-password');
            const passwordPattern = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,20}$/;
            if (!passwordPattern.test(password)) {
                passwordError.textContent = 'Please enter a valid password ';
                valid = false;
            } else {
                passwordError.textContent = '';
            }

            const confirmPassword = document.getElementById('confirm-password').value;
            const confirmPasswordError = document.getElementById('error-confirm-password');
            if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Passwords do not match.';
                valid = false;
            } else {
                confirmPasswordError.textContent = '';
            }

            return valid;
        }
    </script>
</body>
</html>
