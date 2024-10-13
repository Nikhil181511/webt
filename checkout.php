<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default username
$password = ""; // Default password
$dbname = "hotel_management"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch bookings
$sql = "SELECT name, hotel_no, room_type,num_days, num_people, booking_date, comments, total_cost FROM bookings";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Bookings</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    background-image: url("9.jpg");
    background-size: cover;
    background-repeat:no-repeat;
    padding-top:10px;
}

.container {
    padding-top:20%;
    width: 80%;
    margin: auto;
    background: white;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8); /* White with 80% opacity */
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    padding-bottom:20px;
}

h1 {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #f1f1f1;
}
footer {
            width:100%;
            padding-top: 30%;
            text-align: center;
            position: relative;
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
<body>
    <div class="container">
        <h1>Table Bookings</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Hotel Number</th>
                    <th>Room Type</th>
                    <th>Number of Days</th>
                    <th>Number of People</th>
                    <th>Booking Date</th>
                    <th>Comments</th>
                    <th>Total Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        $comments = empty($row['comments']) ? '   ---  ' : $row['comments'];
                        echo "<tr>
                                <td>{$row['name']}</td>
                                <td>{$row['hotel_no']}</td>
                                <td>{$row['room_type']}</td>
                                <td>{$row['num_days']}</td>
                                <td>{$row['num_people']}</td>
                                <td>{$row['booking_date']}</td>
                                <td>{$comments}</td>
                                <td>{$row['total_cost']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No bookings found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <a href="staff.php">
    <button style="padding:5px 20px; font-size: 16px; background-color:#00BFFF; color: black; border: none; border-radius: 5px; cursor: pointer;">
    Go Back
    </button>
    </a>
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
