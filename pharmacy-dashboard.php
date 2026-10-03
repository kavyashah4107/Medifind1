<?php

session_start();

include "config/database.php";


/* Check Pharmacy Login */

if (!isset($_SESSION["pharmacy_id"])) {

    echo "Please login first.";

    exit();

}


$pharmacyId = $_SESSION["pharmacy_id"];

$pharmacyName = $_SESSION["pharmacy_name"];



/* Count Total Medicines */

$sql = "SELECT COUNT(DISTINCT medicine_id) AS total

        FROM medicine_availability

        WHERE pharmacy_id = '$pharmacyId'";


$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

$totalMedicines = $row["total"];



/* Count Available Medicines */

$sql = "SELECT COUNT(*) AS total

        FROM medicine_availability

        WHERE pharmacy_id = '$pharmacyId'

        AND status = 'Available'";


$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

$available = $row["total"];



/* Count Limited Stock Medicines */

$sql = "SELECT COUNT(*) AS total

        FROM medicine_availability

        WHERE pharmacy_id = '$pharmacyId'

        AND status = 'Limited Stock'";


$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

$limitedStock = $row["total"];



/* Count Out of Stock Medicines */

$sql = "SELECT COUNT(*) AS total

        FROM medicine_availability

        WHERE pharmacy_id = '$pharmacyId'

        AND status = 'Out of Stock'";


$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

$outOfStock = $row["total"];



/* Get Medicines of This Pharmacy */

$medicineQuery = "

    SELECT

        medicine_availability.id AS availability_id,

        medicines.medicine_name,

        medicines.category,

        medicines.description,

        medicine_availability.status


    FROM medicine_availability


    INNER JOIN medicines

        ON medicine_availability.medicine_id = medicines.id


    WHERE medicine_availability.pharmacy_id = '$pharmacyId'


    ORDER BY medicine_availability.id DESC

";


$medicineResult = mysqli_query(
    $conn,
    $medicineQuery
);


/* Check Medicine Query */

if (!$medicineResult) {

    echo "Medicine query error: "
         . mysqli_error($conn);

    exit();

}

?>


<!DOCTYPE html>

<html lang="en">


<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Pharmacy Dashboard - MediFind
    </title>

    <link rel="stylesheet"
          href="css/style.css">

</head>


<body>


    <!-- Top Navigation -->

    <nav class="dashboard-navbar">


        <div class="dashboard-logo">

            💊 MediFind

        </div>


        <div class="pharmacy-user">

            🏪

            <?php

            echo htmlspecialchars(
                $pharmacyName
            );

            ?>

        </div>


    </nav>



    <div class="dashboard-container">


        <!-- Sidebar -->

        <aside class="dashboard-sidebar">


            <h3>

                Pharmacy Panel

            </h3>


            <a href="pharmacy-dashboard.php"
               class="active">

                🏠 Dashboard

            </a>


            <a href="medicines.php">

                💊 Medicines

            </a>


            <a href="availability.php">

                📦 Availability

            </a>


            <a href="pharmacy-profile.php">

                👤 Pharmacy Profile

            </a>


            <a href="login.html">

                🚪 Logout

            </a>


        </aside>



        <!-- Main Content -->

        <main class="dashboard-main">


            <!-- Welcome -->

            <div class="welcome-box">


                <h1>

                    Welcome,

                    <?php

                    echo htmlspecialchars(
                        $pharmacyName
                    );

                    ?>

                    ! 🏪

                </h1>


                <p>

                    Manage your pharmacy and medicine
                    availability from here.

                </p>


            </div>



            <!-- Statistics -->

            <div class="dashboard-stats">


                <!-- Total -->

                <div class="stat-card">


                    <div class="stat-icon">

                        💊

                    </div>


                    <div>


                        <h3>

                            Total Medicines

                        </h3>


                        <p>

                            <?php

                            echo $totalMedicines;

                            ?>

                        </p>


                    </div>


                </div>



                <!-- Available -->

                <div class="stat-card">


                    <div class="stat-icon">

                        ✅

                    </div>


                    <div>


                        <h3>

                            Available

                        </h3>


                        <p>

                            <?php

                            echo $available;

                            ?>

                        </p>


                    </div>


                </div>



                <!-- Limited Stock -->

                <div class="stat-card">


                    <div class="stat-icon">

                        ⚠️

                    </div>


                    <div>


                        <h3>

                            Limited Stock

                        </h3>


                        <p>

                            <?php

                            echo $limitedStock;

                            ?>

                        </p>


                    </div>


                </div>



                <!-- Out of Stock -->

                <div class="stat-card">


                    <div class="stat-icon">

                        ❌

                    </div>


                    <div>


                        <h3>

                            Out of Stock

                        </h3>


                        <p>

                            <?php

                            echo $outOfStock;

                            ?>

                        </p>


                    </div>


                </div>


            </div>



            <!-- Medicine Management -->

            <div class="medicine-management">


                <div>


                    <h2>

                        💊 Medicine Availability

                    </h2>


                    <p>

                        Add medicines and update their
                        availability for customers.

                    </p>


                </div>


                <a href="add-medicine.php"
                   class="add-medicine-btn">

                    + Add Medicine

                </a>


            </div>



            <!-- Medicine List -->

            <div class="medicine-list">


                <h2>

                    💊 Your Medicines

                </h2>


                <?php


                if (mysqli_num_rows($medicineResult) > 0) {


                    while (
                        $medicine =
                        mysqli_fetch_assoc(
                            $medicineResult
                        )
                    ) {


                ?>


                        <!-- Medicine Item -->

                        <div class="medicine-item">


                            <!-- Medicine Information -->

                            <div>


                                <h3>

                                    💊

                                    <?php

                                    echo htmlspecialchars(
                                        $medicine["medicine_name"]
                                    );

                                    ?>

                                </h3>


                                <p>

                                    Category:

                                    <?php

                                    echo htmlspecialchars(
                                        $medicine["category"]
                                    );

                                    ?>

                                </p>


                                <p>

                                    <?php

                                    echo htmlspecialchars(
                                        $medicine["description"]
                                    );

                                    ?>

                                </p>


                            </div>



                            <!-- Status + Edit -->

                            <div>


                                <div class="medicine-status">


                                    <?php

                                    echo htmlspecialchars(
                                        $medicine["status"]
                                    );

                                    ?>


                                </div>



                                <a

                                    href="edit-medicine.php?id=<?php echo $medicine["availability_id"]; ?>"

                                    class="edit-medicine-btn"

                                >

                                    ✏️ Edit

                                </a>

                                <a
                                 href="delete-medicine.php?id=<?php echo $medicine["availability_id"]; ?>"
                                class="delete-medicine-btn"
                                onclick="return confirm('Are you sure you want to delete this medicine?');"
                                >
                                    🗑️ Delete
                                </a>


                            </div>
                            



                        </div>


                <?php


                    }


                } else {


                ?>


                    <!-- Empty State -->

                    <div class="empty-medicine">


                        <div class="empty-icon">

                            💊

                        </div>


                        <h2>

                            No medicines added yet

                        </h2>


                        <p>

                            Start adding medicines available
                            at your pharmacy.

                        </p>


                        <a href="add-medicine.php"
                           class="add-medicine-btn">

                            + Add Your First Medicine

                        </a>


                    </div>


                <?php


                }


                ?>


            </div>


        </main>


    </div>



    <!-- Footer -->

    <footer>


        <p>

            © 2026 MediFind.
            All rights reserved.

        </p>


    </footer>


</body>

</html>