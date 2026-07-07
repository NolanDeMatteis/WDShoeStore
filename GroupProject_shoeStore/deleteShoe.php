<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Shoe</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-display-container w3-center">
            <h1>(Insert Store Name)</h1>
            <h2>Delete Shoe</h2>
        </header>
        <?php include "mainMenu.php"; ?>

        <form class="w3-container w3-sand" method="POST">
            <fieldset>
                <label>Shoe</label>
                <select name="shoe" class="w3-select">
                    <option value="" disabled selected>Choose Shoe</option>
                    <?php
                    include "connectDatabase.php";

                    $sql = "SELECT s.shoe_id, s.brand, s.model_name, s.shoe_size ";
                    $sql .= "FROM shoe s LEFT JOIN orders o ";
                    $sql .= "ON s.shoe_id = o.shoe_id ";
                    $sql .= "WHERE o.order_id IS NULL";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['shoe_id'] . "'>" . $row['shoe_id'] . "-" . $row['brand'] . " " . $row['model_name'] . " (Size: " . $row['shoe_size'] . ")</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select><br>
                <b>NOTE</b>: Only shoes with no orders can be deleted
            </fieldset>
            <br><input type="submit" name="submit" value="Delete Shoe" class="w3-btn w3-blue-grey" />
        </form>
        <div class="w3-container w3-sand">
            <?php
            if (isset($_POST["submit"])) {
                if (!isset($_POST["shoe"]) || empty($_POST["shoe"])) {
                    echo "You have not selected a shoe.<br> Please go back and try again";
                    exit;
                }
                include "connectDatabase.php";

                $shoe_id = mysqli_real_escape_string($conn, $_POST["shoe"]);

                $sql = "DELETE FROM shoe WHERE shoe_id = '$shoe_id'";

                if ($conn->query($sql) === TRUE) {
                    echo "Shoe $shoe_id successfully deleted!";
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