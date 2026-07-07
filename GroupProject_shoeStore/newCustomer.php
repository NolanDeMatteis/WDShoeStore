<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Customer</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="w3-container w3-blue-grey">
        <header class="w3-display-container w3-center">
            <h1>(Insert Store Name)</h1>
            <h2>New Customer</h2>
        </header>
        <?php include "mainMenu.php"; ?>

        <form class="w3-container w3-sand" method="POST">
            <fieldset>
                <label>First Name</label>
                <input type="text" class="w3-input w3-border" name="fName">

                <label>Last Name</label>
                <input type="text" class="w3-input w3-border" name="lName">

                <label>Email</label>
                <input type="email" class="w3-input w3-border" name="email">

                <label>Phone Number</label>
                <input type="text" class="w3-input w3-border" name="phone">

                <label>Address</label>
                <input type="text" class="w3-input w3-border" name="address">

                <label>City</label>
                <input type="text" class="w3-input w3-border" name="city">

                <label>State</label>
                <input type="text" class="w3-input w3-border" name="state" maxlength="2">

                <label>Zip</label>
                <input type="text" class="w3-input w3-border" name="zip">
            </fieldset>
            <br><input type="submit" name="submit" value="Add new Customer" class="w3-btn w3-blue-grey" />
        </form>
        <div class="w3-container w3-sand">
            <?php
            function areFieldsMissing(array $requiredFields): bool
            {
                foreach ($requiredFields as $field) {
                    if (!isset($_POST[$field]) || empty(trim($_POST[$field])))
                        return true;
                }
                return false;
            }

            if (isset($_POST["submit"])) {
                $fieldsToCheck = ['fName', 'lName', 'email', 'phone', 'address', 'city', 'state', 'zip'];
                if (areFieldsMissing($fieldsToCheck)) {
                    echo "You have not entered all the required details.<br> Please go back and try again";
                } else {
                    include "connectDatabase.php";

                    $fName = mysqli_real_escape_string($conn, $_POST["fName"]);
                    $lName = mysqli_real_escape_string($conn, $_POST["lName"]);
                    $email = mysqli_real_escape_string($conn, $_POST["email"]);
                    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
                    $address = mysqli_real_escape_string($conn, $_POST["address"]);
                    $city = mysqli_real_escape_string($conn, $_POST["city"]);
                    $state = mysqli_real_escape_string($conn, $_POST["state"]);
                    $zip = mysqli_real_escape_string($conn, $_POST["zip"]);

                    $sql = "INSERT INTO customer (firstName, lastName, email, phone_number, address, city, state, zip) VALUES ('$fName', '$lName', '$email', '$phone', '$address', '$city', '$state', '$zip')";

                    if ($conn->query($sql) === TRUE) {
                        $customer_id = $conn->insert_id;
                        echo "<strong>Customer created successfully!</strong><br><br>";
                        echo "<b>Customer ID:</b> " . $customer_id . "<br>";
                        echo "<b>First Name:</b> " . htc($fName) . "<br>";
                        echo "<b>Last Name:</b> " . htc($lName) . "<br>";
                        echo "<b>Email:</b> " . htc($email) . "<br>";
                        echo "<b>Phone Number:</b> " . htc($phone) . "<br>";
                        echo "<b>Address:</b> " . htc($address) . "<br>";
                        echo "<b>City:</b> " . htc($city) . "<br>";
                        echo "<b>State:</b> " . htc($state) . "<br>";
                        echo "<b>Zip:</b> " . htc($zip) . "<br><br>";
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