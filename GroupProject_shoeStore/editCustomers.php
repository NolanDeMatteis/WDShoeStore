<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customers</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="w3-container w3-gray w3-center w3-card-4 w3-margin w3-round-xlarge w3-padding-64 w3-display-container">
        <header class="w3-container w3-center w3-padding-32 w3-blue">
            <h1 class="w3-xxxlarge w3-text-white w3-bold">Velocity Footwear</h1>
            <h2>Edit Customer Records</h2>
        </header><br>
        <?php include "mainMenu.php"; ?><br>

        <div class="w3-container w3-white w3-padding-24 w3-round-xlarge">
            <?php
            include "connectDatabase.php";

            //Process Update Form Submission
            if (isset($_POST['update_customer'])) {
                $id = intval($_POST['customer_id']);
                $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
                $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $phoneNumber = mysqli_real_escape_string($conn, $_POST['phone_number']);
                $address = mysqli_real_escape_string($conn, $_POST['address']);
                $city = mysqli_real_escape_string($conn, $_POST['city']);
                $state = mysqli_real_escape_string($conn, $_POST['state']);
                $zip = mysqli_real_escape_string($conn, $_POST['zip']);

                $updateSql = "UPDATE customer SET firstName='$firstName', lastName='$lastName', email='$email', phone_number='$phoneNumber', address='$address', city='$city', state='$state', zip='$zip' WHERE customer_id=$id";
                if ($conn->query($updateSql) === TRUE) {
                    echo "<div class='w3-panel w3-green w3-padding'>Customer details updated successfully!</div>";
                } else {
                    echo "<div class='w3-panel w3-red w3-padding'>Error updating record: " . $conn->error . "</div>";
                }
            }

            //Render Edit Form View if an ID is active
            if (isset($_REQUEST['edit_id'])) {
                $id = intval($_REQUEST['edit_id']);
                $fetchSql = "SELECT * FROM customer WHERE customer_id = $id";
                $res = $conn->query($fetchSql);
                
                if ($res->num_rows > 0) {
                    $row = $res->fetch_assoc();
                    ?>
                    <h3>Modify Customer Profile (ID: <?php echo $id; ?>)</h3>
                    <form method="POST" action="editCustomers.php">
                        <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
                        <fieldset style="text-align: left; border: none;">
                            <label class="w3-text-blue"><b>First Name</b></label>
                            <input type="text" class="w3-input w3-border w3-margin-bottom" name="firstName" value="<?php echo htc($row['firstName']); ?>" required>
                            
                            <label class="w3-text-blue"><b>Last Name</b></label>
                            <input type="text" class="w3-input w3-border w3-margin-bottom" name="lastName" value="<?php echo htc($row['lastName']); ?>" required>
                            
                            <label class="w3-text-blue"><b>Email Address</b></label>
                            <input type="email" class="w3-input w3-border w3-margin-bottom" name="email" value="<?php echo htc($row['email']); ?>" required>
                            
                            <label class="w3-text-blue"><b>Phone Number</b></label>
                            <input type="text" class="w3-input w3-border w3-margin-bottom" name="phone_number" value="<?php echo htc($row['phone_number']); ?>" required>

                            <label class="w3-text-blue"><b>Address</b></label>
                            <input type="text" class="w3-input w3-border w3-margin-bottom" name="address" value="<?php echo htc($row['address']); ?>" required>

                            <label class="w3-text-blue"><b>City</b></label>
                            <input type="text" class="w3-input w3-border w3-margin-bottom" name="city" value="<?php echo htc($row['city']); ?>" required>

                            <label class="w3-text-blue"><b>State</b></label>
                            <input type="text" class="w3-input w3-border w3-margin-bottom" name="state" value="<?php echo htc($row['state']); ?>" required>

                            <label class="w3-text-blue"><b>Zip Code</b></label>
                            <input type="text" class="w3-input w3-border w3-margin-bottom" name="zip" value="<?php echo htc($row['zip']); ?>" required>
                        </fieldset>
                        <br>
                        <input type="submit" name="update_customer" value="Save Changes" class="w3-btn w3-blue">
                        <a href="editCustomers.php" class="w3-btn w3-gray">Cancel / Return</a>
                    </form>
                    <?php
                } else {
                    echo "<p class='w3-text-red'>Customer record not found.</p>";
                }
            } else {
                $searchCriteria = isset($_POST['criteria']) ? $_POST['criteria'] : 'lastName';
                $searchTerm = isset($_POST['search_term']) ? mysqli_real_escape_string($conn, trim($_POST['search_term'])) : '';

                $allowedColumns = ['firstName', 'lastName', 'email', 'city'];
                if (!in_array($searchCriteria, $allowedColumns)) { $searchCriteria = 'lastName'; }

                $querySql = "SELECT * FROM customer";
                if (!empty($searchTerm)) {
                    $querySql .= " WHERE $searchCriteria LIKE '%$searchTerm%'";
                }
                $querySql .= " ORDER BY customer_id ASC";
                $result = $conn->query($querySql);
                ?>

                <form method="POST" action="editCustomers.php" class="w3-margin-bottom">
                    <div class="w3-row-padding" style="text-align: left;">
                        <div class="w3-half">
                            <label><b>Search By Criteria</b></label>
                            <select class="w3-select w3-border" name="criteria">
                                <option value="lastName" <?php if($searchCriteria == 'lastName') echo 'selected'; ?>>Last Name</option>
                                <option value="firstName" <?php if($searchCriteria == 'firstName') echo 'selected'; ?>>First Name</option>
                                <option value="email" <?php if($searchCriteria == 'email') echo 'selected'; ?>>Email Address</option>
                                <option value="city" <?php if($searchCriteria == 'city') echo 'selected'; ?>>City</option>
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

                <h3>Select a Profile to Edit</h3>
                <?php
                if ($result->num_rows > 0) {
                    echo "<table class='w3-table w3-striped w3-bordered'>";
                    echo "<tr class='w3-blue'><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Action</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['customer_id'] . "</td>";
                        echo "<td>" . htc($row['firstName']) . "</td>";
                        echo "<td>" . htc($row['lastName']) . "</td>";
                        echo "<td>" . htc($row['email']) . "</td>";
                        echo "<td>" . htc($row['phone_number']) . "</td>";
                        echo "<td>" . htc($row['address']) . "</td>";
                        echo "<td>" . htc($row['city']) . "</td>";
                        echo "<td>" . htc($row['state']) . "</td>";
                        echo "<td>" . htc($row['zip']) . "</td>";
                        echo "<td><a href='editCustomers.php?edit_id=" . $row['customer_id'] . "' class='w3-button w3-amber w3-round w3-small'>Modify</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No matching customer profiles found.</p>";
                }
            }
            $conn->close();
            ?>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>