<?php
include 'db.php';
function generateUniqueHotelNo($conn) {
    $hotel_no = null;
    $existing_numbers = [];

    // Fetch existing hotel numbers
    $result = $conn->query("SELECT hotel_no FROM bookings WHERE hotel_no BETWEEN 0 AND 100");
    while ($row = $result->fetch_assoc()) {
        $existing_numbers[] = $row['hotel_no'];
    }

    // Generate a hotel_no that is not in the existing numbers
    do {
        $hotel_no = rand(0, 100); // Generate a number between 0 and 100
    } while (in_array($hotel_no, $existing_numbers)); // Repeat until a unique number is found

    return $hotel_no;
}

// Generate unique hotel number
$hotel_no = generateUniqueHotelNo($conn);

// Retrieve and sanitize form data
$name = htmlspecialchars($_POST['name']);
$room_type = htmlspecialchars($_POST['room']); // Correctly retrieve the selected room type
$numPeople = (int)$_POST['numPeople'];
$bookingDate = htmlspecialchars($_POST['bookingDate']);
$num_days = (int)$_POST['No_Date'];
$comments = htmlspecialchars($_POST['comments']);
$spaCost = isset($_POST['spa']) ? 1000 : 0;
$breakfastCost = isset($_POST['breakfast']) ? 500 : 0;

// Room cost mapping
$roomCosts = [
    1 => 2000, // Single Room
    2 => 4000, // Double Room
    3 => 6000  // Suite
];

if($room_type == 1) {
    $type = "Single Room";
} elseif($room_type == 2) {
    $type = 'Double Room';
} else {
    $type = 'Suite';
}
// Calculate the total cost for the stay based on the number of days
$roomCost = isset($roomCosts[$room_type]) ? $roomCosts[$room_type] : 0;
$breakfastCost = isset($_POST['breakfast']) ? 500 : 0;
$perPersonCost = ($spaCost + $breakfastCost) * $numPeople; 
$totalCost = ($roomCost * $num_days) + $perPersonCost;
$stmt = $conn->prepare("INSERT INTO bookings (name, hotel_no, room_type, num_people, booking_date, num_days, comments, total_cost) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

// Bind parameters (8 parameters)
$stmt->bind_param("sisissis", $name, $hotel_no, $type, $numPeople, $bookingDate, $num_days, $comments, $totalCost);

// Execute the statement
if ($stmt->execute()) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking Confirmation</title>
        <style>
            body {
                padding-top: 10%;
                font-family: Arial, sans-serif;
                display: flex;
                flex-direction: column; /* Allow vertical stacking */
                min-height: 100vh; /* Ensure body takes at least full viewport height */
                margin: 0;
                background-image: url("17.jpg");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                justify-content: center; /* Center content vertically */
                align-items: center; /* Center content horizontally */
            }
            .bill-container {
                background: rgba(255, 255, 255, 0.9); /* Slight transparency */
                padding: 20px;
                background-attachment: fixed;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                max-width: 50%;
                height: 60%;
                text-align: center;
            }
            h1 {
                font-size: 24px;
                margin-bottom: 20px;
            }
            .details {
                margin-bottom: 10px;
                font-size: 18px;
            }
            .total {
                font-weight: bold;
                font-size: 20px;
                color: #007bff;
            }
            footer {
                width: 100%;
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
            .btn {
            display: inline-block;
            background-color: #f92b06;
            color: rgb(16, 15, 15);
            padding: 10px 30px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-bottom: 20px; /* Space below button */
        }

        .btn:hover {
            background-color: #333;
            color: white;
        }
        }
        </style>
    </head>
    <body>
        <div class="bill-container">
            <h1 style="color:green;">Booking Successful</h1>
            <div class="details"><b>Name:</b> ' . htmlspecialchars($name) . '</div>
            <div class="details"><b>Hotel Number:</b> ' . $hotel_no . '</div>
            <div class="details"><b>Room Type:</b> ' . htmlspecialchars($type) . '</div>
            <div class="details"><b>Booking Date:</b> ' . $bookingDate . '</div>
            <div class="details"><b>Number of Days:</b> ' . $num_days . '</div>
            <div class="details"><b>Number of People:</b> ' . $numPeople . '</div>
            <div class="details"><b>Comments:</b> ' . $comments . '</div>
            <div class="total"><b>Total Cost: Rs.</b> ' . number_format($totalCost, 2) . '</div>
        </div>
        <div style="padding-top:20px;">
            <a href="index.html" class="btn">Home</a>
        </div>
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
                        Helpdesk websites, email, domains: <a class="footer-link" href="mailto:assist@Rajhotels.com">assist@Rajhotels.com</a>
                    </p>
                    <p class="footer-helpdesk">
                        Helpdesk booking engine: <a class="footer-link" href="mailto:helpdesk@Rajhotels.com">helpdesk@Rajhotels.com</a>
                    </p>
                </div>
            </div>
        </footer>
    </body>
    </html>
    ';
} else {
    echo "Error: " . htmlspecialchars($stmt->error);
}

// Close connections
$stmt->close();
$conn->close();
?>
