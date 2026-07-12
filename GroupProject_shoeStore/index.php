<?php include "utilFunctions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="styles.css">
</head>
<style>

    /* p{text-align: center} */
</style>

<body class="w3-light-grey">
    <div class="w3-container w3-gray w3-center w3-card-4 w3-margin w3-round-xlarge w3-padding-64 w3-display-container">
        <img src="shoe.png" alt="Shoe Logo" class="w3-image w3-round w3-display-topright" style="width:120px ">
        <header class="w3-container w3-center w3-padding-32 w3-blue">
            <h1 class="w3-xxxlarge w3-text-white w3-bold">Velocity Footwear</h1>
            <h2>Home Page</h2>
        </header><br>

        <?php include "mainMenu.php"; ?>
        <!-- Intro Section -->
        <div class="w3-container w3-light-grey w3-card w3-round-xlarge w3-margin w3-padding-32 w3-hover-shadow">
            <br>
            <h2>Welcome to Velocity Footwear!</h2><br>
            <h3>Find Your Perfect Pair</h3>
            <p> Premium shoes for sport, casual wear, and everyday comfort. Grab your style now!</p>

        </div>

        <!--About Section-->
        <div class="w3-container w3-light-grey w3-card w3-round-xlarge w3-margin w3-padding-32 w3-hover-shadow">
            <div class="w3-center">
                <h2> About Our Store</h2>
                <?php
                echo "We provide high-quality shoes with comfort,
                style, and durability. 
                Our goal is to help customers find shoes
                that match their lifestyle.<br> <br>";

                echo "From running shoes to casual sneakers,
                    we offer choices for every occasion." ?>
            </div>
        </div>

        <!-- Categories -->
        <div class="w3-row-padding w3-margin">
            <div class="w3-third">
                <div class="w3-light-grey w3-card w3-round-xlarge w3-padding">
                    <h3>Running</h3>
                    <p><?php echo "Comfortable shoes for athletes."; ?></p>
                </div>
            </div>

            <div class="w3-third">
                <div class="w3-light-grey w3-card w3-round-xlarge w3-padding">
                    <h3>Casual</h3>
                    <p><?php echo "Everyday shoes with style"; ?></p>
                </div>
            </div>

            <div class="w3-third">
                <div class="w3-light-grey w3-card w3-round-xlarge w3-padding">
                    <h3>Sports</h3>
                    <p><?php echo "Performance footwear"; ?></p>
                </div>
            </div>
        </div>

    </div>

    <?php include "footer.php"; ?>

</body>

</html>