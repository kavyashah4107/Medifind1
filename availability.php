<?php

session_start();

if (!isset($_SESSION["pharmacy_id"])) {
    echo "Please login first.";
    exit();
}

$pharmacyId = $_SESSION["pharmacy_id"];
$pharmacyName = $_SESSION["pharmacy_name"];

include "config/database.php";


$query = "
    SELECT
        medicines.medicine_name,
        medicines.category,
        medicine_availability.status
    FROM medicine_availability
    INNER JOIN medicines
        ON medicine_availability.medicine_id = medicines.id
    WHERE medicine_availability.pharmacy_id = $pharmacyId
";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Availability - MediFind</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- Navigation -->

    <nav class="dashboard-navbar">

        <div class="dashboard-logo">
            💊 MediFind
        </div>

        <div class="pharmacy-user">
            🏪 <?php echo htmlspecialchars($pharmacyName); ?>
        </div>

    </nav>


    <div class="dashboard-container">

        <!-- Sidebar -->

        <aside class="dashboard-sidebar">

            <h3>Pharmacy Panel</h3>

            <a href="pharmacy-dashboard.php">
                🏠 Dashboard
            </a>

            <a href="medicines.php">
                💊 Medicines
            </a>

            <a href="availability.php" class="active">
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

            <div class="welcome-box">

                <h1>📦 Medicine Availability</h1>

                <p>
                    Check the current availability of your medicines.
                </p>

            </div>


            <div class="availability-section">

                <div class="availability-header">

                    <div>
                        <h2>Medicine Stock Status</h2>

                        <p>
                            Current availability in your pharmacy.
                        </p>
                    </div>

                    <a href="add-medicine.php"
                       class="add-medicine-btn">
                        + Add Medicine
                    </a>

                </div>


                <div class="availability-list">

                    <?php

                    if (mysqli_num_rows($result) > 0) {

                        while ($medicine = mysqli_fetch_assoc($result)) {

                    ?>

                        <div class="availability-card">

                            <div class="availability-icon">
                                💊
                            </div>

                            <div class="availability-info">

                                <h2>
                                    <?php
                                    echo htmlspecialchars(
                                        $medicine["medicine_name"]
                                    );
                                    ?>
                                </h2>

                                <p>
                                    Category:
                                    <?php
                                    echo htmlspecialchars(
                                        $medicine["category"]
                                    );
                                    ?>
                                </p>

                            </div>


                            <div class="availability-status">

                                <?php

                                if ($medicine["status"] == "Available") {

                                    echo '<span class="status-available">
                                            ✅ Available
                                          </span>';

                                } elseif (
                                    $medicine["status"] == "Limited Stock"
                                ) {

                                    echo '<span class="status-limited">
                                            ⚠️ Limited Stock
                                          </span>';

                                } else {

                                    echo '<span class="status-out">
                                            ❌ Out of Stock
                                          </span>';

                                }

                                ?>

                            </div>

                        </div>

                    <?php

                        }

                    } else {

                    ?>

                        <div class="empty-medicine">

                            <div class="empty-icon">
                                📦
                            </div>

                            <h2>No medicines available</h2>

                            <p>
                                Add medicines to manage their availability.
                            </p>

                            <a href="add-medicine.php"
                               class="add-medicine-btn">
                                + Add Medicine
                            </a>

                        </div>

                    <?php

                    }

                    ?>

                </div>

            </div>

        </main>

    </div>


    <footer>

        <p>
            © 2026 MediFind. All rights reserved.
        </p>

    </footer>

</body>

</html>