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
$result - $conn-> query($sql);
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $tithe_number = $_POST['tithe_number'];
    $registration_number = $_POST['registration_number'];
    $stmt = $conn-> prepare("INSERT INTO members (name, tithe_number, registration_number) VALUES(?, ?, ?)"); #prepare the statement
    $stmt -> bind_param("sss", $name, $tithe_number, $registration_number); #binding the parameters
    if($stmt-> execute()) {
    echo "<p>New Member Added Succesfully.</p>";
    } else {
        echo "<p>Error adding member: " . $conn -> error ."</p>";
    }
    $stmt -> close();
}
$conn ->close();
?>