<?php

include "config/database.php";


/* Check search */

if (!isset($_GET["medicine"])) {

    echo "Please enter a medicine name.";

    exit();

}


$medicine = trim($_GET["medicine"]);
$category = isset($_GET["category"])
    ? trim($_GET["category"])
    : "";


/* Check empty search */

if ($medicine === "") {

    echo "Please enter a medicine name.";

    exit();

}


/* Prevent special characters from affecting SQL */

$medicine = mysqli_real_escape_string($conn, $medicine);


/* Search medicines and pharmacies */

$sql = "
    SELECT
        medicines.medicine_name,
        medicines.category,
        medicines.description,
        medicine_availability.status,
        pharmacies.pharmacy_name,
        pharmacies.address,
        pharmacies.phone

    FROM medicine_availability

    INNER JOIN medicines
        ON medicine_availability.medicine_id = medicines.id

    INNER JOIN pharmacies
        ON medicine_availability.pharmacy_id = pharmacies.id

    WHERE LOWER(medicines.medicine_name)
          LIKE LOWER('%$medicine%')

    ORDER BY pharmacies.pharmacy_name, medicines.medicine_name
";


$result = mysqli_query($conn, $sql);


if (!$result) {

    echo "Database error: " . mysqli_error($conn);

    exit();

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Medicine Search - MediFind</title>

    <link rel="stylesheet"
          href="css/style.css">

</head>


<body>


<!-- Navigation -->

<nav class="navbar">

    <div class="logo">
        💊 MediFind
    </div>


    <div class="nav-links">

        <a href="index.html">
            Home
        </a>

        <a href="how-it-works.html">
            How it works
        </a>

        <a href="login.html">
            Login
        </a>

        <a href="register.html">
            Register
        </a>

    </div>

</nav>



<!-- Search Results -->

<section class="results-section">


    <h1>
        Medicine Search Results
    </h1>


    <p class="results-subtitle">

        Search results for:

        <strong>
            <?php echo htmlspecialchars($medicine); ?>
        </strong>

    </p>

    <form action="search.php" method="get" class="result-search-box">

    <input
        type="text"
        name="medicine"
        placeholder="Search another medicine..."
        required
    >

    <button type="submit">
        🔍 Search
    </button>

</form>



    <div id="medicineResults">


        <?php


        if (mysqli_num_rows($result) > 0) {


            while ($row = mysqli_fetch_assoc($result)) {


        ?>


                <!-- Pharmacy Card -->

                <div class="pharmacy-card">


                    <h2>

                        🏪

                        <?php

                        echo htmlspecialchars(
                            $row["pharmacy_name"]
                        );

                        ?>

                    </h2>


                    <h3>

                        💊

                        <?php

                        echo htmlspecialchars(
                            $row["medicine_name"]
                        );

                        ?>

                    </h3>


                    <p>

                        <strong>
                            Category:
                        </strong>

                        <?php

                        echo htmlspecialchars(
                            $row["category"]
                        );

                        ?>

                    </p>


                    <p>

                        <strong>
                            Availability:
                        </strong>

                        <span class="status
    <?php

    if ($row["status"] == "Available") {

        echo "available";

    } elseif ($row["status"] == "Limited Stock") {

        echo "limited";

    } else {

        echo "out";

    }

    ?>
">

    <?php

    echo htmlspecialchars(
        $row["status"]
    );

    ?>

</span>
                    </p>


                    <p>

                        📍

                        <?php

                        echo htmlspecialchars(
                            $row["address"]
                        );

                        ?>

                    </p>
                    <?php
                        $mapAddress = urlencode($row['address']);
                    ?>

                    <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $mapAddress; ?>"
                    target="_blank"
                    class="map-button">
                    📍 View on Google Maps
                    </a>

                    <p>

                        📞

                        <?php

                        echo htmlspecialchars(
                            $row["phone"]
                        );

                        ?>

                    </p>


                </div>


        <?php


            }


        } else {


        ?>


            <!-- No Results -->

            <div class="empty-medicine">


            <h2>
            🔍 Medicine Not Found
            </h2>

            <p>
                We couldn't find
                <strong>
                    <?php echo htmlspecialchars($medicine); ?>
                </strong>
                    in any registered pharmacy.
                </p>

<p>
    Please check the spelling or try another medicine name.
</p>


                <a
                    href="index.html"
                    class="add-medicine-btn"
                >

                    ← Search Again

                </a>


            </div>


        <?php

        }


        ?>


    </div>


</section>



<!-- Footer -->

<footer>

    <p>
        © 2026 MediFind. All rights reserved.
    </p>

</footer>


</body>

</html>