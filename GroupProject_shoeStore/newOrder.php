<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="w3-container w3-gray w3-center w3-card-4 w3-margin w3-round-xlarge w3-padding-64 w3-display-container">
        <header class="w3-container w3-center w3-padding-32 w3-blue">
            <h1 class="w3-xxxlarge w3-text-white w3-bold">Velocity Footwear</h1>
            <h2>New Order</h2>
        </header><br>
        <?php include "mainMenu.php"; ?><br>

        <form class="w3-container" method="POST">
            <fieldset>
                <label>Customer</label>
                <select name="customer" class="w3-select" required>
                    <option value="" disabled selected>Choose Customer</option>
                    <?php
                    include "connectDatabase.php";
                    //currently using order ascending by id, could also use "ORDER BY lastName, firstName"
                    $cSql = "SELECT customer_id, firstName, lastName FROM customer ORDER BY customer_id ASC";
                    $cResult = $conn->query($cSql);
                    while ($cRow = $cResult->fetch_assoc()) {
                        echo "<option value='" . $cRow['customer_id'] . "'>" . $cRow['customer_id'] . "-" . $cRow['lastName'] . ", " . $cRow['firstName'] . "</option>";
                    }
                    $conn->close();
                    ?>
                </select>

                <label>Shoe</label>
                <select name="shoe" class="w3-select" required>
                    <option value="" disabled selected>Choose Shoe</option>
                    <?php
                    include "connectDatabase.php";
                    //currently using order ascending by id, could also use "ORDER BY brand, model_name"
                    $sSql = "SELECT shoe_id, brand, model_name, shoe_size, price FROM shoe ORDER BY shoe_id ASC";
                    $sResult = $conn->query($sSql);
                    while ($sRow = $sResult->fetch_assoc()) {
                        echo "<option value='" . $sRow['shoe_id'] . "'>" . $sRow['shoe_id'] . "-" . $sRow['brand'] . " " . $sRow['model_name'] . " (Size: " . $sRow['shoe_size'] . ") - $" . $sRow['price'] . "</option>";
                    }
                    $conn->close();
                    ?>
                </select>

                <label>Quantity</label>
                <input type="number" class="w3-input w3-border" name="quantity" min="1" value="1" required>
            </fieldset>
            <br><input type="submit" name="submit" value="Add new Order" class="w3-btn w3-black" />
        </form>
        <div class="w3-container w3-blue">
            <?php
            if (isset($_POST["submit"])) {
                if (empty($_POST["customer"]) || empty($_POST["shoe"]) || empty($_POST["quantity"])) {
                    echo "Please complete all fields.";
                } else {
                    include "connectDatabase.php";

                    $customer_id = mysqli_real_escape_string($conn, $_POST["customer"]);
                    $shoe_id = mysqli_real_escape_string($conn, $_POST["shoe"]);
                    $quantity = mysqli_real_escape_string($conn, $_POST["quantity"]);

                    // Uses NOW() to insert current system timestamp directly into SQL
                    $sql = "INSERT INTO orders (customer_id, shoe_id, quantity, order_date) VALUES ('$customer_id', '$shoe_id', '$quantity', NOW())";

                    if ($conn->query($sql) === TRUE) {
                        $order_id = $conn->insert_id;

                        $infoSql = "SELECT o.order_date, c.firstName, c.lastName, s.brand, s.model_name, s.shoe_size, s.price 
                                    FROM orders o 
                                    JOIN customer c ON o.customer_id = c.customer_id 
                                    JOIN shoe s ON o.shoe_id = s.shoe_id 
                                    WHERE o.order_id = '$order_id'";
                        $infoResult = $conn->query($infoSql);
                        $infoRow = $infoResult->fetch_assoc();

                        echo "<strong>Order placed successfully!</strong><br><br>";
                        echo "<b>Order ID:</b> " . $order_id . "<br>";
                        echo "<b>Customer Name:</b> " . htc($infoRow['lastName']) . ", " . htc($infoRow['firstName']) . " (ID: " . $customer_id . ")<br>";
                        echo "<b>Shoe Item:</b> " . htc($infoRow['brand']) . " " . htc($infoRow['model_name']) . " (Size: " . htc($infoRow['shoe_size']) . ") (ID: " . $shoe_id . ")<br>";
                        echo "<b>Quantity Ordered:</b> " . htc($quantity) . "<br>";
                        echo "<b>Total Price:</b> $" . number_format(($infoRow['price'] * $quantity), 2) . "<br>";
                        echo "<b>Order Date/Time:</b> " . htc($infoRow['order_date']) . "<br><br>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                    $conn->close();
                }
            }
            ?>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>

</html>