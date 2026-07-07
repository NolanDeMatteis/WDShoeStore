<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Shoes</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-display-container w3-center">
            <h1>(Insert Store Name)</h1>
            <h2>Show Shoes</h2>
        </header>
        <?php include "mainMenu.php"; ?>

        <div class="w3-container w3-sand">
            <?php
            include "connectDatabase.php";

            //currently using order ascending by id, could also use "ORDER BY brand, model_name"
            $sql = "SELECT * FROM shoe ORDER BY shoe_id ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='w3-table w3-striped'>";
                echo "  <tr class='w3-teal'>";
                echo "      <th>ID</th>";
                echo "      <th>Brand</th>";
                echo "      <th>Model Name</th>";
                echo "      <th>Size</th>";
                echo "      <th>Color</th>";
                echo "      <th class='w3-right-align'>Price</th>";
                echo "  </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "  <td>" . $row['shoe_id'] . "</td>";
                    echo "  <td>" . htc($row['brand']) . "</td>";
                    echo "  <td>" . htc($row['model_name']) . "</td>";
                    echo "  <td>" . htc($row['shoe_size']) . "</td>";
                    echo "  <td>" . htc($row['color']) . "</td>";
                    echo "  <td class='w3-right-align'>$" . number_format($row['price'], 2) . "</td>";
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