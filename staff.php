<?php
$servername = "localhost";
$username = "root"; // Default username
$password = ""; // Default password
$dbname = "hotel_management"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insert'])) {
        // Insert a new record
        $name = $_POST['name'];
        $gmail = $_POST['gmail'];
        $phoneno = $_POST['phoneno'];
        $salary = $_POST['salary'];
        $duty = $_POST['duty']; // New duty field
        $stmt = $conn->prepare("INSERT INTO staffmembers (name, gmail, phoneno, salary, duty) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $gmail, $phoneno, $salary, $duty);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Update an existing record
        $id = $_POST['id'];
        $name = $_POST['name'];
        $gmail = $_POST['gmail'];
        $phoneno = $_POST['phoneno'];
        $salary = $_POST['salary'];
        $duty = $_POST['duty']; // New duty field
        $stmt = $conn->prepare("UPDATE staffmembers SET name=?, gmail=?, phoneno=?, salary=?, duty=? WHERE id=?");
        $stmt->bind_param("sssssi", $name, $gmail, $phoneno, $salary, $duty, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        // Delete a record
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM staffmembers WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch records
$result = $conn->query("SELECT * FROM staffmembers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Members</title>
    <style>
       body {
    background-image: url('8.jpg'); /* Set your background image */
    background-size: cover; /* Cover the entire viewport */
    background-repeat: no-repeat;
    display: flex;
    background-size: cover;
    background-position: center;
    background-repeat:no-repeat;
    flex-direction: column;
    align-items: center; /* Center-align items horizontally */
    justify-content: flex-start; /* Align items at the top */
    min-height: 100vh; /* Full height with minimum */
    margin: 0; /* Remove default margin */
    color: black; /* Text color for visibility */
}

.container {
    background-color: rgba(255, 255, 255, 0.8); /* White with 80% opacity */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    width: 92%; /* Width of the form and table */
    margin: 40px 0; /* Space at the top, bottom for footer */
}
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Space between form and table */
            border: 2px solid black; /* Black border around the table */
        }
        th, td {
            border: 1px solid black; /* Black border for table cells */
            padding: 8px;
            text-align: left;
        }
        button {
            margin-top: 10px; /* Space above buttons */
        }
        
        footer {
            width:100%;
            padding-top: 20%;
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
        .btn:hover{
            background-color:black;
            color:white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Staff Members</h1>
        <form method="post">
            <h2>Add New Staff Member</h2>
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="gmail" placeholder="Email" required>
            <input type="text" name="phoneno" placeholder="Phone Number" required>
            <input type="text" name="duty" placeholder="Duty" required> 
            <input type="number" name="salary" placeholder="Salary" step="1000" required>
            <button type="submit" name="insert">Add Staff</button>
        </form>

        <h2>Current Staff Members</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Salary</th>
                <th>Duty</th> <!-- New column header -->
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['gmail']; ?></td>
                    <td><?php echo $row['phoneno']; ?></td>
                    <td><?php echo $row['salary']; ?></td>
                    <td><?php echo $row['duty']; ?></td> <!-- Display the duty -->
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                        <button onclick="editStaff(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES); ?>)">Edit</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h2>Edit Staff Member</h2>
        <form id="editForm" method="post" style="display:none;">
            <input type="hidden" name="id" id="editId">
            <input type="text" name="name" id="editName" required>
            <input type="email" name="gmail" id="editGmail" required>
            <input type="text" name="phoneno" id="editPhoneNo" required>
            <input type="text" name="duty" id="editDuty" required> 
            <input type="number" name="salary" id="editSalary" step="1000" required>
            <button type="submit" name="update">Update Staff</button>
        </form>
        <a href="index.html">
    <button class="btn" style="padding:5px 20px; font-size: 16px; background-color:red; color: white; border: none; border-radius: 5px; cursor: pointer;">
    Home
    </button>
     </a>
    </div>
    <div style="margin-top: 20px;">
    <a href="checkout.php">
    <button class="btn" style="padding: 10px 20px; font-size: 16px; background-color: red; color: white; border: none; border-radius: 5px; cursor: pointer;">
    View Booking Details
    </button>
</a>
        </div>
    <script>
        function editStaff(staff) {
            document.getElementById('editId').value = staff.id;
            document.getElementById('editName').value = staff.name;
            document.getElementById('editGmail').value = staff.gmail;
            document.getElementById('editPhoneNo').value = staff.phoneno;
            document.getElementById('editDuty').value = staff.duty;
            document.getElementById('editSalary').value = staff.salary;
            document.getElementById('editForm').style.display = 'block';
        }
    </script>
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

<?php
$conn->close();
?>
