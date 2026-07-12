<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Customer</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="w3-container w3-gray w3-center w3-card-4 w3-margin w3-round-xlarge w3-padding-64 w3-display-container">
        <header class="w3-container w3-center w3-padding-32 w3-blue">
            <h1 class="w3-xxxlarge w3-text-white w3-bold">Velocity Footwear</h1>
            <h2>Delete Customer</h2>
        </header><br>
        <?php include "mainMenu.php"; ?><br>

        <form class="w3-container" method="POST">
            <fieldset>
                <label>Customer</label>
                <select name="customer" class="w3-select">
                    <option value="" disabled selected>Choose Customer</option>
                    <?php
                    include "connectDatabase.php";

                    $sql = "SELECT c.customer_id, c.firstName, c.lastName ";
                    $sql .= "FROM customer c LEFT JOIN orders o ";
                    $sql .= "ON c.customer_id = o.customer_id ";
                    $sql .= "WHERE o.order_id IS NULL";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $customerId = $row["customer_id"];
                            $customerFirstName = $row["firstName"];
                            $customerLastName = $row["lastName"];

                            echo "<option value='$customerId'>$customerId-$customerLastName, $customerFirstName</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select><br>
                <b>NOTE</b>: Only customers with no orders can be deleted
            </fieldset>
            <br><input type="submit" name="submit" value="Delete Customer" class="w3-btn w3-black" />
        </form>
        <div class="w3-container w3-blue">
            <?php
            if (isset($_POST["submit"])) {
                if (!isset($_POST["customer"]) || empty($_POST["customer"])) {
                    echo "You have not selected a customer.<br> Please go back and try again";
                    exit;
                }
                include "connectDatabase.php";

                $customer_id = mysqli_real_escape_string($conn, $_POST["customer"]);

                $sql = "DELETE FROM customer WHERE customer_id = '$customer_id'";

                if ($conn->query($sql) === TRUE) {
                    echo "Customer $customer_id successfully deleted!";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
                header("Refresh:1");
            }
            ?>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>

</html>