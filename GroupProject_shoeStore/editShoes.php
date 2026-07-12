<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shoes</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="w3-container w3-gray w3-center w3-card-4 w3-margin w3-round-xlarge w3-padding-64 w3-display-container">
        <header class="w3-container w3-center w3-padding-32 w3-blue">
            <h1 class="w3-xxxlarge w3-text-white w3-bold">Velocity Footwear</h1>
            <h2>Edit Shoes Inventory</h2>
        </header><br>
        <?php include "mainMenu.php"; ?><br>

        <div class="w3-container w3-white w3-padding-24 w3-round-xlarge">
            <?php
            include "connectDatabase.php";

            //Process Update Form Submission
            if (isset($_POST['update_shoe'])) {
                $id = intval($_POST['shoe_id']);
                $brand = mysqli_real_escape_string($conn, $_POST['brand']);
                $model = mysqli_real_escape_string($conn, $_POST['model_name']);
                $size = mysqli_real_escape_string($conn, $_POST['shoe_size']);
                $color = mysqli_real_escape_string($conn, $_POST['color']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);

                $updateSql = "UPDATE shoe SET brand='$brand', model_name='$model', shoe_size='$size', color='$color', price='$price' WHERE shoe_id=$id";
                if ($conn->query($updateSql) === TRUE) {
                    echo "<div class='w3-panel w3-green w3-padding'>Shoe record updated successfully!</div>";
                } else {
                    echo "<div class='w3-panel w3-red w3-padding'>Error updating record: " . $conn->error . "</div>";
                }
            }

            //Render Edit Form View if an ID is active
            if (isset($_REQUEST['edit_id'])) {
                $id = intval($_REQUEST['edit_id']);
                $fetchSql = "SELECT * FROM shoe WHERE shoe_id = $id";
                $res = $conn->query($fetchSql);
                
                if ($res->num_rows > 0) {
                    $row = $res->fetch_assoc();
                    ?>
                    <h3>Modify Shoe Record (ID: <?php echo $id; ?>)</h3>
                    <form method="POST" action="editShoes.php">
                        <input type="hidden" name="shoe_id" value="<?php echo $row['shoe_id']; ?>">
                        <fieldset>
                            <label>Brand</label>
                            <input type="text" class="w3-input w3-border" name="brand" value="<?php echo htc($row['brand']); ?>" required>
                            
                            <label>Model Name</label>
                            <input type="text" class="w3-input w3-border" name="model_name" value="<?php echo htc($row['model_name']); ?>" required>
                            
                            <label>Shoe Size</label>
                            <input type="number" step="0.1" class="w3-input w3-border" name="shoe_size" value="<?php echo htc($row['shoe_size']); ?>" required>
                            
                            <label>Color</label>
                            <input type="text" class="w3-input w3-border" name="color" value="<?php echo htc($row['color']); ?>" required>
                            
                            <label>Price ($)</label>
                            <input type="number" step="0.01" class="w3-input w3-border" name="price" value="<?php echo htc($row['price']); ?>" required>
                        </fieldset>
                        <br>
                        <input type="submit" name="update_shoe" value="Save Changes" class="w3-btn w3-black">
                        <a href="editShoes.php" class="w3-btn w3-gray">Cancel / Return</a>
                    </form>
                    <?php
                } else {
                    echo "<p class='w3-text-red'>Shoe record not found.</p>";
                }
            } else {
                $searchCriteria = isset($_POST['criteria']) ? $_POST['criteria'] : 'brand';
                $searchTerm = isset($_POST['search_term']) ? mysqli_real_escape_string($conn, trim($_POST['search_term'])) : '';

                $allowedColumns = ['brand', 'color', 'model_name'];
                if (!in_array($searchCriteria, $allowedColumns)) { $searchCriteria = 'brand'; }

                $querySql = "SELECT * FROM shoe";
                if (!empty($searchTerm)) {
                    $querySql .= " WHERE $searchCriteria LIKE '%$searchTerm%'";
                }
                $querySql .= " ORDER BY shoe_id ASC";
                $result = $conn->query($querySql);
                ?>

                <form method="POST" action="editShoes.php" class="w3-margin-bottom">
                    <div class="w3-row-padding">
                        <div class="w3-half">
                            <label>Search By Criteria</label>
                            <select class="w3-select w3-border" name="criteria">
                                <option value="brand" <?php if($searchCriteria == 'brand') echo 'selected'; ?>>Brand</option>
                                <option value="color" <?php if($searchCriteria == 'color') echo 'selected'; ?>>Color</option>
                                <option value="model_name" <?php if($searchCriteria == 'model_name') echo 'selected'; ?>>Model Name</option>
                            </select>
                        </div>
                        <div class="w3-half">
                            <label>Keyword Search Term</label>
                            <input type="text" class="w3-input w3-border" name="search_term" value="<?php echo htc($searchTerm); ?>" placeholder="Type to filter rows...">
                        </div>
                    </div>
                    <input type="submit" value="Filter Elements" class="w3-btn w3-blue w3-margin-top">
                </form>

                <hr>

                <h3>Select a Record to Edit</h3>
                <?php
                if ($result->num_rows > 0) {
                    echo "<table class='w3-table w3-striped w3-bordered'>";
                    echo "<tr class='w3-blue'><th>ID</th><th>Brand</th><th>Model Name</th><th>Size</th><th>Color</th><th>Price</th><th>Action</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['shoe_id'] . "</td>";
                        echo "<td>" . htc($row['brand']) . "</td>";
                        echo "<td>" . htc($row['model_name']) . "</td>";
                        echo "<td>" . htc($row['shoe_size']) . "</td>";
                        echo "<td>" . htc($row['color']) . "</td>";
                        echo "<td>$" . number_format($row['price'], 2) . "</td>";
                        echo "<td><a href='editShoes.php?edit_id=" . $row['shoe_id'] . "' class='w3-button w3-amber w3-round w3-small'>Modify</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No matching inventory records found.</p>";
                }
            }
            $conn->close();
            ?>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>