<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "church";

#Check for Database Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn-> connect_error) {
    die("Connection Failed" . $conn -> connect_error);
}

#Display the contents from the members table
$sql = "SELECT * FROM members";
$result = $conn-> query($sql);
if ($result -> num_rows > 0) {
    echo "<table border='1'>
        <tr>
            <th>Name</th>
            <th>Tithe Number</th>
            <th>Registration Number</th>
        </tr>";
while ($row = $result -> fetch_assoc()) {
    echo "<tr>
    <td>" . $row["name"]. "</td>
    <td>" . $row["tithe_number"] . "</td>
    <td>" . $row["registration_number"] . "</td>
    </tr>";
}
echo "</table>";
} else {
    echo "No Members Found";
}

#Processing form data and add to the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['name'])) {
    $name = $_POST['name'];
    $tithe_number = $_POST['tithe_number'];
    $registration_number = $_POST['registration_number'];
    $stmt = $conn-> prepare("INSERT INTO members (name, tithe_number, registration_number) VALUES(?, ?, ?)"); #prepare the statement
    $stmt -> bind_param("sss", $name, $tithe_number, $registration_number); #binding the parameters
    if($stmt-> execute()) {
    $stmt -> close();
    $conn-> close();
    header("Location: " . $_SERVER['PHP_SELF'] . "?status=success");
    exit();
    } else {
        echo "<p>Error adding member: " . $conn -> error ."</p>";
    }
    $stmt -> close();
}
$conn ->close();
?>

<!-- Html Form to the member details -->
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Members</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        color: #333;
        padding: 20px;
        line-height: 1.6;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #2c3e50;
    }
    form {
        max-width: 500px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #34495e;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

input[type="text"]:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #3498db;
    border: none;
    border-radius: 4px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #2980b9;
}

/* Style the table */
table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #2c3e50;
    color: #fff;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Style success/error messages */
p {
    text-align: center;
    margin-top: 10px;
    padding: 10px;
    border-radius: 4px;
}

p:contains("successfully") {
    background-color: #e7f3e7;
    color: #2e7d32;
}

p:contains("Error") {
    background-color: #fdeded;
    color: #d32f2f;
}
    </style>
 </head>
 <body>
    <h2>Add a Member</h2>
    <form action="" method="POST">
        <label for="name">Member's Name:</label>
        <input type="text" name="name" required><br><br>

        <label for="tithe_number">Tithe Number:</label>
        <input type="text" name="tithe_number" required><br><br>

        <label for="registration_number">Registration Number:</label>
        <input type="text" name="registration_number" required><br><br>

        <input type="submit" value="Add Member">
    </form>
 </body>
 </html>