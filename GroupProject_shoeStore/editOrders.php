<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Orders</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="w3-container w3-gray w3-center w3-card-4 w3-margin w3-round-xlarge w3-padding-64 w3-display-container">
        <header class="w3-container w3-center w3-padding-32 w3-blue">
            <h1 class="w3-xxxlarge w3-text-white w3-bold">Velocity Footwear</h1>
            <h2>Edit Invoiced Orders</h2>
        </header><br>
        <?php include "mainMenu.php"; ?><br>

        <div class="w3-container w3-white w3-padding-24 w3-round-xlarge">
            <?php
            include "connectDatabase.php";

            //Process Update Form Submission
            if (isset($_POST['update_order'])) {
                $id = intval($_POST['order_id']);
                $orderDate = mysqli_real_escape_string($conn, $_POST['order_date']);
                $customerId = intval($_POST['customer_id']);
                $shoeId = intval($_POST['shoe_id']);
                $quantity = intval($_POST['quantity']);

                $updateSql = "UPDATE orders SET order_date='$orderDate', customer_id=$customerId, shoe_id=$shoeId, quantity=$quantity WHERE order_id=$id";
                if ($conn->query($updateSql) === TRUE) {
                    echo "<div class='w3-panel w3-green w3-padding'>Invoice manifest updated successfully!</div>";
                } else {
                    echo "<div class='w3-panel w3-red w3-padding'>Error updating record: " . $conn->error . "</div>";
                }
            }

            //Render Edit Form View if an ID is active
            if (isset($_REQUEST['edit_id'])) {
                $id = intval($_REQUEST['edit_id']);
                $fetchSql = "SELECT * FROM orders WHERE order_id = $id";
                $res = $conn->query($fetchSql);
                
                if ($res->num_rows > 0) {
                    $row = $res->fetch_assoc();
                    ?>
                    <h3>Modify Order Invoice (ID: <?php echo $id; ?>)</h3>
                    <form method="POST" action="editOrders.php">
                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                        <fieldset style="text-align: left; border: none;">
                            <label class="w3-text-blue"><b>Order Date/Time</b></label>
                            <input type="text" class="w3-input w3-border w3-margin-bottom" name="order_date" value="<?php echo htc($row['order_date']); ?>" required>
                            
                            <label class="w3-text-blue"><b>Customer ID</b></label>
                            <input type="number" class="w3-input w3-border w3-margin-bottom" name="customer_id" value="<?php echo $row['customer_id']; ?>" required>
                            
                            <label class="w3-text-blue"><b>Shoe ID</b></label>
                            <input type="number" class="w3-input w3-border w3-margin-bottom" name="shoe_id" value="<?php echo $row['shoe_id']; ?>" required>
                            
                            <label class="w3-text-blue"><b>Quantity</b></label>
                            <input type="number" class="w3-input w3-border w3-margin-bottom" name="quantity" value="<?php echo $row['quantity']; ?>" required>
                        </fieldset>
                        <br>
                        <input type="submit" name="update_order" value="Save Changes" class="w3-btn w3-blue">
                        <a href="editOrders.php" class="w3-btn w3-gray">Cancel / Return</a>
                    </form>
                    <?php
                } else {
                    echo "<p class='w3-text-red'>Order record not found.</p>";
                }
            } else {
                $searchCriteria = isset($_POST['criteria']) ? $_POST['criteria'] : 'lastName';
                $searchTerm = isset($_POST['search_term']) ? mysqli_real_escape_string($conn, trim($_POST['search_term'])) : '';

                $allowedColumns = ['lastName', 'brand', 'order_id'];
                if (!in_array($searchCriteria, $allowedColumns)) { $searchCriteria = 'lastName'; }

                $querySql = "SELECT o.order_id, o.order_date, c.firstName, c.lastName, s.brand, s.model_name, s.shoe_size, o.quantity, (s.price * o.quantity) AS total_price 
                             FROM orders o 
                             JOIN customer c ON o.customer_id = c.customer_id 
                             JOIN shoe s ON o.shoe_id = s.shoe_id";
                
                if (!empty($searchTerm)) {
                    if ($searchCriteria == 'order_id') {
                        $querySql .= " WHERE o.order_id = " . intval($searchTerm);
                    } elseif ($searchCriteria == 'brand') {
                        $querySql .= " WHERE s.brand LIKE '%$searchTerm%'";
                    } else {
                        $querySql .= " WHERE c.lastName LIKE '%$searchTerm%'";
                    }
                }
                $querySql .= " ORDER BY o.order_id ASC";
                $result = $conn->query($querySql);
                ?>

                <form method="POST" action="editOrders.php" class="w3-margin-bottom">
                    <div class="w3-row-padding" style="text-align: left;">
                        <div class="w3-half">
                            <label><b>Search By Criteria</b></label>
                            <select class="w3-select w3-border" name="criteria">
                                <option value="lastName" <?php if($searchCriteria == 'lastName') echo 'selected'; ?>>Customer Last Name</option>
                                <option value="brand" <?php if($searchCriteria == 'brand') echo 'selected'; ?>>Shoe Brand</option>
                                <option value="order_id" <?php if($searchCriteria == 'order_id') echo 'selected'; ?>>Order ID</option>
                            </select>
                        </div>
                        <div class="w3-half">
                            <label><b>Keyword Search Term</b></label>
                            <input type="text" class="w3-input w3-border" name="search_term" value="<?php echo htc($searchTerm); ?>" placeholder="Type to filter rows...">
                        </div>
                    </div>
                    <input type="submit" value="Filter Elements" class="w3-btn w3-blue w3-margin-top">
                </form>

                <hr>

                <h3>Select an Invoice to Edit</h3>
                <?php
                if ($result->num_rows > 0) {
                    echo "<table class='w3-table w3-striped w3-bordered'>";
                    echo "<tr class='w3-blue'><th>Order ID</th><th>Order Date/Time</th><th>Customer Name</th><th>Shoe Item</th><th>Size</th><th>Qty</th><th class='w3-right-align'>Total Price</th><th>Action</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . htc($row['order_date']) . "</td>";
                        echo "<td>" . htc($row['lastName']) . ", " . htc($row['firstName']) . "</td>";
                        echo "<td>" . htc($row['brand']) . " " . htc($row['model_name']) . "</td>";
                        echo "<td>" . htc($row['shoe_size']) . "</td>";
                        echo "<td>" . htc($row['quantity']) . "</td>";
                        echo "<td class='w3-right-align'>$" . number_format($row['total_price'], 2) . "</td>";
                        echo "<td><a href='editOrders.php?edit_id=" . $row['order_id'] . "' class='w3-button w3-amber w3-round w3-small'>Modify</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No matching purchase order records found.</p>";
                }
            }
            $conn->close();
            ?>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>