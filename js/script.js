function searchMedicine() {

    let medicine = document.getElementById("medicineInput").value;

    let message = document.getElementById("searchMessage");


    if (medicine.trim() === "") {

        message.textContent = "⚠️ Please enter a medicine name.";

        message.className = "warning";

        return;
    }


    message.textContent = "🔍 Searching for " + medicine + "...";

    message.className = "searching";


setTimeout(function() {

        window.location.href =
            "http://localhost/Medifind1-1/search.php?medicine="
            + encodeURIComponent(medicine);

    }, 1000);
}

function registerUser(event) {

    event.preventDefault();

    let name = document.getElementById("fullName").value;
    let email = document.getElementById("registerEmail").value;
    let mobile = document.getElementById("mobile").value;
    let password = document.getElementById("registerPassword").value;
    let confirmPassword = document.getElementById("confirmPassword").value;

    let account = document.querySelector(
        'input[name="accountType"]:checked'
    );

    let message = document.getElementById("registerMessage");

    if (name.trim() === "") {
        message.textContent = "⚠️ Please enter your full name.";
        return;
    }

    if (email.trim() === "") {
        message.textContent = "⚠️ Please enter your email.";
        return;
    }

    if (mobile.trim() === "") {
        message.textContent = "⚠️ Please enter your mobile number.";
        return;
    }

    if (password === "") {
        message.textContent = "⚠️ Please create a password.";
        return;
    }

    if (password !== confirmPassword) {
        message.textContent = "⚠️ Passwords do not match.";
        return;
    }

    if (account === null) {
        message.textContent = "⚠️ Please choose an account type.";
        return;
    }

    // Send the form to register.php
    document.querySelector("form").submit();
}

function showPharmacyFields() {

    let pharmacyFields = document.getElementById("pharmacyFields");

    let pharmacyOption = document.querySelector(
        'input[name="accountType"]:checked'
    );

    if (pharmacyOption && pharmacyOption.value === "pharmacy") {
        pharmacyFields.style.display = "block";
    } else {
        pharmacyFields.style.display = "none";
    }
}

function loginUser(event) {

    event.preventDefault();

    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let message = document.getElementById("loginMessage");

    if (email.trim() === "") {

        message.textContent = "⚠️ Please enter your email address.";
        message.className = "login-warning";
        return;
    }

    if (password.trim() === "") {

        message.textContent = "⚠️ Please enter your password.";
        message.className = "login-warning";
        return;
    }

    message.textContent = "✓ Checking login details...";
    message.className = "login-success";

    // Submit the form to login.php
    event.target.submit();
}

function showMedicineResults() {

    let urlData =
        new URLSearchParams(window.location.search);

    let medicine =
        urlData.get("medicine");

    let medicineTitle =
        document.getElementById("searchedMedicine");


    if (medicine) {

        medicineTitle.textContent =
            '"' + medicine + '"';

    } else {

        medicineTitle.textContent =
            "Medicine";

    }
}


if (document.getElementById("searchedMedicine")) {

    showMedicineResults();

}