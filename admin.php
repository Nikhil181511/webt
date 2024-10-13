<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            display: flex;
            flex-direction: column; 
            min-height: 100vh; 
            margin: 0;
            background-image: url("2.jpg");
            background-size: cover; 
        }
        .container {
            flex: 1; 
            display: flex;
            justify-content: center; 
            align-items: center;
            padding: 30px;
        }

        .form-wrapper {
            background: rgba(255, 255, 255, 0.9); 
            padding: 40px; 
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 100%; 
            max-width: 400px; 
            text-align: center; 
        }

        h1 {
            margin-bottom: 30px; 
        }

        label {
            margin-bottom: 10px; 
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            margin-bottom: 20px; 
            width: calc(100% - 20px); 
            padding: 10px; 
            border-radius: 4px;
            border: 1px solid #ccc; 
        }

        input[type="submit"],
        input[type="reset"] {
            margin-top: 10px; 
            padding: 10px 15px; 
            border-radius: 4px; 
            border: none; 
            cursor: pointer; 
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white; 
        }
        input[type="reset"] {
            background-color: #f44336; 
            color: white; 
        }
        
        footer {
            padding-top: 20%;
            text-align: center;
        }

        .footer-box {
            padding-top: 20px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .footer-header h3 {
            margin-top: 0;
            color: #000;
        }

        .footer-content {
            margin: 20px 0;
        }

        .footer-info,
        .footer-helpdesk {
            margin: 10px 0;
        }

        .footer-link {
            color: #007bff;
            text-decoration: none;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        .footer-cta {
            margin-top: 20px;
        }

        .footer-cta h4 {
            margin: 10px 0;
            color: #000;
        }

        .footer-cta a {
            color: #007bff;
            text-decoration: none;
        }

        .footer-cta a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h1 id="lpg">Admin Login</h1>
            <form action="login.php" method="post">
                <label id="aduser">Enter Email:</label>
                <input type="text" name="email" required>
                <label>Enter Password:</label>
                <input type="password" name="password" required>
                <input type="submit" value="Confirm">
                <input type="reset" value="Clear">
            </form>
        </div>
    </div>
</body>
<footer>
        <div class="footer-box">
            <div class="footer-header">
                <h3>Write to Us</h3>
            </div>
            <div class="footer-content">
                <p class="footer-info">
                    INFO: <a class="footer-link" href="mailto:RajHotel123@gmail.com">RajHotel123@gmail.com</a> / 
                    <a class="footer-link" href="tel:9018759973">9018759973</a>
                </p>
                <p class="footer-helpdesk">
                    Helpdesk websites, email, domains: <a class="footer-link" href="mailto:assist@Rajhotels.com">mailto:assist@Rajhotels.com</a>
                </p>
                <p class="footer-helpdesk">
                    Helpdesk booking engine: <a class="footer-link" href="mailto:helpdesk@Rajhotels..com">helpdesk@Rajhotels..com</a>
                </p>
            </div>
        </div>
    </footer>
</html>
