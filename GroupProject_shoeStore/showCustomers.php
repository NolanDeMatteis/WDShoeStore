<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Customers</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="w3-container w3-gray w3-center w3-card-4 w3-margin w3-round-xlarge w3-padding-64 w3-display-container">
        <header class="w3-container w3-center w3-padding-32 w3-blue">
            <h1 class="w3-xxxlarge w3-text-white w3-bold">Velocity Footwear</h1>
            <h2>Show Customers</h2>
        </header><br>
        <?php include "mainMenu.php"; ?><br>

        <div class="w3-container w3-white">
            <?php
            include "connectDatabase.php";
            
            //currently using order ascending by id, could also use "ORDER BY lastName, firstName"
            $sql = "SELECT * FROM customer ORDER BY customer_id ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='w3-table w3-striped'>";
                echo "  <tr class='w3-blue'>";
                echo "      <th>ID</th>";
                echo "      <th>First Name</th>";
                echo "      <th>Last Name</th>";
                echo "      <th>Email</th>";
                echo "      <th>Phone</th>";
                echo "      <th>Address</th>";
                echo "      <th>City</th>";
                echo "      <th>State</th>";
                echo "      <th>Zip</th>";
                echo "  </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "  <td>" . $row['customer_id'] . "</td>";
                    echo "  <td>" . htc($row['firstName']) . "</td>";
                    echo "  <td>" . htc($row['lastName']) . "</td>";
                    echo "  <td>" . htc($row['email']) . "</td>";
                    echo "  <td>" . htc($row['phone_number']) . "</td>";
                    echo "  <td>" . htc($row['address']) . "</td>";
                    echo "  <td>" . htc($row['city']) . "</td>";
                    echo "  <td>" . htc($row['state']) . "</td>";
                    echo "  <td>" . htc($row['zip']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "0 results<br>";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>

</html>