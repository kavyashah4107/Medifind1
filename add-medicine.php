<?php

session_start();

if (!isset($_SESSION["pharmacy_id"])) {
    echo "Please login first.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Medicine - MediFind</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <nav class="dashboard-navbar">

        <div class="dashboard-logo">
            💊 MediFind
        </div>

        <div class="pharmacy-user">
            🏪 Pharmacy
        </div>

    </nav>


    <section class="register-section">

        <div class="register-card">

            <h1>💊 Add Medicine</h1>

            <p class="register-subtitle">
                Add medicine available in your pharmacy
            </p>


            <form action="save-medicine.php"
                  method="post">

                <label for="medicineName">
                    Medicine Name
                </label>

                <input
                    type="text"
                    id="medicineName"
                    name="medicineName"
                    placeholder="Enter medicine name"
                    required
                >


                <label for="category">
                    Category
                </label>

                <select
                    id="category"
                    name="category"
                    required
                >

                    <option value="">
                        Select category
                    </option>

                    <option value="Tablet">
                        Tablet
                    </option>

                    <option value="Syrup">
                        Syrup
                    </option>

                    <option value="Injection">
                        Injection
                    </option>

                    <option value="First Aid">
                        First Aid
                    </option>

                </select>


                <label for="status">
                    Availability
                </label>

                <select
                    id="status"
                    name="status"
                    required
                >

                    <option value="">
                        Select availability
                    </option>

                    <option value="Available">
                        Available
                    </option>

                    <option value="Limited Stock">
                        Limited Stock
                    </option>

                    <option value="Out of Stock">
                        Out of Stock
                    </option>

                </select>


                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Enter medicine description"
                    rows="4"
                ></textarea>


                <button type="submit">
                    Add Medicine
                </button>

            </form>

        </div>

    </section>


</body>

</html>