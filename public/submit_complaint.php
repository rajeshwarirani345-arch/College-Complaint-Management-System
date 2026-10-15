<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["user"]["role"] !== "student") {
    header("Location: admin/dashboard.php");
    exit;
}

$pageTitle = "Submit Complaint";
require_once "includes/header.php";
?>

<div class="page-heading">
    <div>
        <span class="eyebrow">WE ARE LISTENING</span>
        <h1>Submit a Complaint</h1>
        <p>Tell us about the issue you want to report.</p>
    </div>

    <a href="dashboard.php" class="btn btn-light">
        ← Dashboard
    </a>
</div>

<section class="content-card complaint-form-card">
    <div class="form-heading">
        <h2>Complaint Details</h2>
        <p>Please fill in all the required fields.</p>
    </div>

    <form action="submit_complaint.php"
          method="post"
          class="form-stack"
          data-validate="complaint">

        <label>Category
            <select name="category" required>
                <option value="">Select category</option>
                <option>Classroom</option>
                <option>Library</option>
                <option>Hostel</option>
                <option>Transport</option>
                <option>Canteen</option>
                <option>Cleanliness</option>
                <option>Internet / Wi-Fi</option>
                <option>Other</option>
            </select>
        </label>

        <label>Complaint Subject
            <input type="text" name="subject"
                   maxlength="150"
                   placeholder="Enter complaint subject" required>
        </label>

        <label>Complaint Description
            <textarea name="description" rows="6"
                      placeholder="Explain your complaint clearly..."
                      required></textarea>
        </label>

        <div class="form-actions">
            <a href="dashboard.php" class="text-link">Cancel</a>

            <button type="submit" class="btn btn-primary">
                Submit Complaint →
            </button>
        </div>
    </form>
</section>

<?php require_once "includes/footer.php"; ?>