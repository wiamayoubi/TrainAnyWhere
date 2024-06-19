<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        /* Your existing CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        header a {
            color: #fff;
            text-decoration: none;
            margin: 0 5px;
        }
        header a:hover {
            color: #ccc;
        }
        main {
            padding: 20px;
            background-color: #fff;
            margin: 20px auto;
            width: 80%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            margin-top: 0;
        }
        p {
            margin-bottom: 20px;
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
  
    <main>
        <h1>Sign Up</h1>
        <div class="form-container">
            <form action="SignUp.php" method="post">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required>
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required>
                <label for="mobile">Mobile:</label>
                <input type="text" id="mobile" name="mobile" required>
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
                <label for="bod">Date of Birth:</label>
                <input type="date" id="bod" name="bod" required>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <input type="submit" value="Sign Up">
            </form>
        </div>
    </main>

    <a href="login.php">Go Back </a>    
    <footer>
        03030303<br/>
        ot
    </footer>
</body>
</html>
