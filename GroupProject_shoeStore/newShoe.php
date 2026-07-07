<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Shoe</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-display-container w3-center">
            <h1>(Insert Store Name)</h1>
            <h2>New Shoe</h2>
        </header>
        <?php include "mainMenu.php"; ?>

        <form class="w3-container w3-sand" method="POST">
            <fieldset>
                <label>Brand</label>
                <input type="text" class="w3-input w3-border" name="brand">

                <label>Model Name</label>
                <input type="text" class="w3-input w3-border" name="modelName">

                <label>Shoe Size</label>
                <input type="number" step="0.1" class="w3-input w3-border" name="shoeSize">

                <label>Color</label>
                <input type="text" class="w3-input w3-border" name="color">

                <label>Price</label>
                <input type="number" step="0.01" class="w3-input w3-border" name="price">
            </fieldset>
            <br><input type="submit" name="submit" value="Add new Shoe" class="w3-btn w3-blue-grey" />
        </form>
        <div class="w3-container w3-sand">
            <?php
            if (isset($_POST["submit"])) {
                $fieldsToCheck = ['brand', 'modelName', 'shoeSize', 'color', 'price'];
                $missing = false;
                foreach ($fieldsToCheck as $field) {
                    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) $missing = true;
                }

                if ($missing) {
                    echo "You have not entered all the required details.<br> Please go back and try again";
                } else {
                    include "connectDatabase.php";

                    $brand = mysqli_real_escape_string($conn, $_POST["brand"]);
                    $modelName = mysqli_real_escape_string($conn, $_POST["modelName"]);
                    $shoeSize = mysqli_real_escape_string($conn, $_POST["shoeSize"]);
                    $color = mysqli_real_escape_string($conn, $_POST["color"]);
                    $price = mysqli_real_escape_string($conn, $_POST["price"]);

                    $sql = "INSERT INTO shoe (brand, model_name, shoe_size, color, price) VALUES ('$brand', '$modelName', '$shoeSize', '$color', '$price')";

                    if ($conn->query($sql) === TRUE) {
                        $shoe_id = $conn->insert_id;
                        echo "<strong>Shoe added successfully!</strong><br><br>";
                        echo "<b>Shoe ID:</b> " . $shoe_id . "<br>";
                        echo "<b>Brand:</b> " . htc($brand) . "<br>";
                        echo "<b>Model Name:</b> " . htc($modelName) . "<br>";
                        echo "<b>Shoe Size:</b> " . htc($shoeSize) . "<br>";
                        echo "<b>Color:</b> " . htc($color) . "<br>";
                        echo "<b>Price:</b> $" . number_format($price, 2) . "<br><br>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                    $conn->close();
                }
            }
            ?>
        </div>
    </div>
</body>

</html>