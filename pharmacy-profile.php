<?php

session_start();

include "config/database.php";


/* Check pharmacy login */

if (!isset($_SESSION["pharmacy_id"])) {

    echo "Please login first.";
    exit();

}


$pharmacyId = $_SESSION["pharmacy_id"];


/* Get pharmacy information */

$sql = "SELECT
            pharmacy_name,
            address,
            phone,
            owner_name,
            email
        FROM pharmacies
        WHERE id = '$pharmacyId'";


$result = mysqli_query($conn, $sql);


if (!$result) {

    echo "Database error: " . mysqli_error($conn);
    exit();

}


if (mysqli_num_rows($result) == 0) {

    echo "Pharmacy not found.";
    exit();

}


$pharmacy = mysqli_fetch_assoc($result);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Pharmacy Profile - MediFind</title>

    <link rel="stylesheet"
          href="css/style.css">

</head>


<body>


<!-- Navigation -->

<nav class="dashboard-navbar">

    <div class="dashboard-logo">
        💊 MediFind
    </div>

    <div class="pharmacy-user">

        🏪

        <?php

        echo htmlspecialchars(
            $pharmacy["pharmacy_name"]
        );

        ?>

    </div>

</nav>



<!-- Profile -->

<section class="register-section">


    <div class="register-card">


        <h1>
            👤 Pharmacy Profile
        </h1>


        <p class="register-subtitle">

            View and update your pharmacy information

        </p>



        <form
            action="update-pharmacy-profile.php"
            method="post"
        >


            <!-- Pharmacy Name -->

            <label for="pharmacyName">

                Pharmacy Name

            </label>


            <input
                type="text"
                id="pharmacyName"
                name="pharmacyName"
                value="<?php

                echo htmlspecialchars(
                    $pharmacy["pharmacy_name"]
                );

                ?>"
                required
            >



            <!-- Owner Name -->

            <label for="ownerName">

                Owner Name

            </label>


            <input
                type="text"
                id="ownerName"
                name="ownerName"
                value="<?php

                echo htmlspecialchars(
                    $pharmacy["owner_name"] ?? ""
                );

                ?>"
            >



            <!-- Email -->

            <label for="email">

                Email Address

            </label>


            <input
                type="email"
                id="email"
                name="email"
                value="<?php

                echo htmlspecialchars(
                    $pharmacy["email"] ?? ""
                );

                ?>"
            >



            <!-- Phone -->

            <label for="phone">

                Phone Number

            </label>


            <input
                type="tel"
                id="phone"
                name="phone"
                value="<?php

                echo htmlspecialchars(
                    $pharmacy["phone"] ?? ""
                );

                ?>"
            >



            <!-- Address -->

            <label for="address">

                Pharmacy Address

            </label>


            <textarea
                id="address"
                name="address"
                rows="4"
                required
            ><?php

            echo htmlspecialchars(
                $pharmacy["address"]
            );

            ?></textarea>



            <!-- Update -->

            <button type="submit">

                💾 Update Profile

            </button>


        </form>


        <p class="login-text">

            <a href="pharmacy-dashboard.php">

                ← Back to Dashboard

            </a>

        </p>


    </div>


</section>



<footer>

    <p>

        © 2026 MediFind.
        All rights reserved.

    </p>

</footer>


</body>

</html>