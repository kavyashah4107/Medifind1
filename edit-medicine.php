<?php

session_start();

include "config/database.php";


/* Check pharmacy login */

if (!isset($_SESSION["pharmacy_id"])) {

    echo "Please login first.";

    exit();

}


$pharmacyId = $_SESSION["pharmacy_id"];


/* Check availability ID */

if (!isset($_GET["id"])) {

    echo "Medicine ID not found.";

    exit();

}


$availabilityId = $_GET["id"];


/* Get medicine information */

$sql = "SELECT
            medicine_availability.id AS availability_id,
            medicine_availability.status,
            medicines.id AS medicine_id,
            medicines.medicine_name,
            medicines.category,
            medicines.description

        FROM medicine_availability

        INNER JOIN medicines
        ON medicine_availability.medicine_id = medicines.id

        WHERE medicine_availability.id = '$availabilityId'

        AND medicine_availability.pharmacy_id = '$pharmacyId'";


$result = mysqli_query($conn, $sql);


if (!$result) {

    echo "Database error: " . mysqli_error($conn);

    exit();

}


/* Check whether medicine exists */

if (mysqli_num_rows($result) == 0) {

    echo "Medicine not found.";

    exit();

}


$medicine = mysqli_fetch_assoc($result);

?>


<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Medicine - MediFind</title>

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
                $_SESSION["pharmacy_name"]
            );

            ?>

        </div>


    </nav>



    <!-- Edit Medicine -->

    <section class="register-section">


        <div class="register-card">


            <h1>

                ✏️ Edit Medicine

            </h1>


            <p class="register-subtitle">

                Update medicine information

            </p>



            <form action="update-medicine.php"
                  method="post">


                <!-- Availability ID -->

                <input
                    type="hidden"
                    name="availabilityId"
                    value="<?php

                    echo htmlspecialchars(
                        $medicine["availability_id"]
                    );

                    ?>"
                >


                <!-- Medicine ID -->

                <input
                    type="hidden"
                    name="medicineId"
                    value="<?php

                    echo htmlspecialchars(
                        $medicine["medicine_id"]
                    );

                    ?>"
                >



                <!-- Medicine Name -->

                <label for="medicineName">

                    Medicine Name

                </label>


                <input
                    type="text"
                    id="medicineName"
                    name="medicineName"
                    value="<?php

                    echo htmlspecialchars(
                        $medicine["medicine_name"]
                    );

                    ?>"
                    required
                >



                <!-- Category -->

                <label for="category">

                    Category

                </label>


                <select
                    id="category"
                    name="category"
                    required
                >


                    <option value="Tablet"
                    <?php

                    if ($medicine["category"] == "Tablet") {

                        echo "selected";

                    }

                    ?>>

                        Tablet

                    </option>


                    <option value="Syrup"
                    <?php

                    if ($medicine["category"] == "Syrup") {

                        echo "selected";

                    }

                    ?>>

                        Syrup

                    </option>


                    <option value="Injection"
                    <?php

                    if ($medicine["category"] == "Injection") {

                        echo "selected";

                    }

                    ?>>

                        Injection

                    </option>


                    <option value="First Aid"
                    <?php

                    if ($medicine["category"] == "First Aid") {

                        echo "selected";

                    }

                    ?>>

                        First Aid

                    </option>


                </select>



                <!-- Availability -->

                <label for="status">

                    Availability

                </label>


                <select
                    id="status"
                    name="status"
                    required
                >


                    <option value="Available"
                    <?php

                    if ($medicine["status"] == "Available") {

                        echo "selected";

                    }

                    ?>>

                        Available

                    </option>


                    <option value="Limited Stock"
                    <?php

                    if ($medicine["status"] == "Limited Stock") {

                        echo "selected";

                    }

                    ?>>

                        Limited Stock

                    </option>


                    <option value="Out of Stock"
                    <?php

                    if ($medicine["status"] == "Out of Stock") {

                        echo "selected";

                    }

                    ?>>

                        Out of Stock

                    </option>


                </select>



                <!-- Description -->

                <label for="description">

                    Description

                </label>


                <textarea
                    id="description"
                    name="description"
                    rows="4"
                ><?php

                echo htmlspecialchars(
                    $medicine["description"]
                );

                ?></textarea>



                <!-- Update Button -->

                <button type="submit">

                    Update Medicine

                </button>


            </form>


        </div>


    </section>


</body>

</html>