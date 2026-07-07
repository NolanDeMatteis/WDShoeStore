<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Order</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-display-container w3-center">
            <h1>(Insert Store Name)</h1>
            <h2>Delete Order</h2>
        </header>
        <?php include "mainMenu.php"; ?>

        <form class="w3-container w3-sand" method="POST">
            <fieldset>
                <label>Order to Delete</label>
                <select name="order" class="w3-select" required>
                    <option value="" disabled selected>Choose Order</option>
                    <?php
                    include "connectDatabase.php";

                    $sql = "SELECT o.order_id, o.order_date, c.lastName, s.brand, s.model_name 
                            FROM orders o 
                            JOIN customer c ON o.customer_id = c.customer_id 
                            JOIN shoe s ON o.shoe_id = s.shoe_id 
                            ORDER BY o.order_id ASC";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['order_id'] . "'>Order #" . $row['order_id'] . " - " . $row['lastName'] . " (" . $row['brand'] . " " . $row['model_name'] . ") Placed: [" . $row['order_date'] . "]</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>
            </fieldset>
            <br><input type="submit" name="submit" value="Delete Order" class="w3-btn w3-blue-grey" />
        </form>
        <div class="w3-container w3-sand">
            <?php
            if (isset($_POST["submit"])) {
                if (empty($_POST["order"])) {
                    echo "You have not selected an order.";
                    exit;
                }
                include "connectDatabase.php";

                $order_id = mysqli_real_escape_string($conn, $_POST["order"]);

                $sql = "DELETE FROM orders WHERE order_id = '$order_id'";

                if ($conn->query($sql) === TRUE) {
                    echo "Order $order_id successfully deleted!";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
                header("Refresh:1");
            }
            ?>
        </div>
    </div>
</body>

</html>