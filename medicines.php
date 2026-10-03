<?php

session_start();

if (!isset($_SESSION["pharmacy_id"])) {
    echo "Please login first.";
    exit();
}

$pharmacyId = $_SESSION["pharmacy_id"];
$pharmacyName = $_SESSION["pharmacy_name"];

include "config/database.php";


// Get medicines added by this pharmacy
$query = "
    SELECT 
        medicines.id,
        medicines.medicine_name,
        medicines.category,
        medicines.description,
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

    <title>My Medicines - MediFind</title>

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

            <a href="medicines.php" class="active">
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

            <div class="welcome-box">

                <h1>💊 My Medicines</h1>

                <p>
                    Manage the medicines available at your pharmacy.
                </p>

            </div>


            <!-- Add Medicine -->

            <div class="medicine-management">

                <div>

                    <h2>Medicine List</h2>

                    <p>
                        Medicines added by your pharmacy.
                    </p>

                </div>

                <a href="add-medicine.php"
                   class="add-medicine-btn">

                    + Add Medicine

                </a>

            </div>


            <!-- Medicine Cards -->

            <div class="medicine-list-dashboard">

                <?php

                if (mysqli_num_rows($result) > 0) {

                    while ($medicine = mysqli_fetch_assoc($result)) {

                ?>

                    <div class="dashboard-medicine-card">

                        <div class="medicine-card-icon">
                            💊
                        </div>

                        <div class="medicine-card-info">

                            <h2>
                                <?php echo htmlspecialchars($medicine["medicine_name"]); ?>
                            </h2>

                            <p>
                                <strong>Category:</strong>
                                <?php echo htmlspecialchars($medicine["category"]); ?>
                            </p>

                            <p>
                                <?php echo htmlspecialchars($medicine["description"]); ?>
                            </p>

                            <p>

                                <strong>Status:</strong>

                                <?php

                                if ($medicine["status"] == "Available") {

                                    echo '<span class="status-available">
                                            ✅ Available
                                          </span>';

                                } elseif ($medicine["status"] == "Limited Stock") {

                                    echo '<span class="status-limited">
                                            ⚠️ Limited Stock
                                          </span>';

                                } else {

                                    echo '<span class="status-out">
                                            ❌ Out of Stock
                                          </span>';

                                }

                                ?>

                            </p>

                        </div>

                    </div>

                <?php

                    }

                } else {

                ?>

                    <div class="empty-medicine">

                        <div class="empty-icon">
                            💊
                        </div>

                        <h2>No medicines added yet</h2>

                        <p>
                            Add your first medicine to your pharmacy.
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

        </main>

    </div>


    <footer>

        <p>
            © 2026 MediFind. All rights reserved.
        </p>

    </footer>

</body>

</html>