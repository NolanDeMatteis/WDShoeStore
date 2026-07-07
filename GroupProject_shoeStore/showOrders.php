<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Orders</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-display-container w3-center">
            <h1>(Insert Store Name)</h1>
            <h2>Show Orders</h2>
        </header>
        <?php include "mainMenu.php"; ?>

        <div class="w3-container w3-sand">
            <?php
            include "connectDatabase.php";

            $sql = "SELECT o.order_id, o.order_date, c.firstName, c.lastName, s.brand, s.model_name, s.shoe_size, o.quantity, (s.price * o.quantity) AS total_price 
                        FROM orders o 
                        JOIN customer c ON o.customer_id = c.customer_id 
                        JOIN shoe s ON o.shoe_id = s.shoe_id 
                        ORDER BY o.order_id ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='w3-table w3-striped'>";
                echo "  <tr class='w3-teal'>";
                echo "      <th>Order ID</th>";
                echo "      <th>Order Date/Time</th>";
                echo "      <th>Customer Name</th>";
                echo "      <th>Shoe Item</th>";
                echo "      <th>Size</th>";
                echo "      <th>Qty</th>";
                echo "      <th class='w3-right-align'>Total Price</th>";
                echo "  </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "  <td>" . $row['order_id'] . "</td>";
                    echo "  <td>" . htc($row['order_date']) . "</td>";
                    echo "  <td>" . htc($row['lastName']) . ", " . htc($row['firstName']) . "</td>";
                    echo "  <td>" . htc($row['brand']) . " " . htc($row['model_name']) . "</td>";
                    echo "  <td>" . htc($row['shoe_size']) . "</td>";
                    echo "  <td>" . htc($row['quantity']) . "</td>";
                    echo "  <td class='w3-right-align'>$" . number_format($row['total_price'], 2) . "</td>";
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
</body>

</html>