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
?>