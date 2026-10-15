<?php
$pageTitle = "Home";
require_once "includes/header.php";
?>

<section class="hero">
    <div class="hero-copy">
        <span class="eyebrow">YOUR VOICE MATTERS</span>

        <h1>
            A better campus<br>
            <span>starts with being heard.</span>
        </h1>

        <p>
            Submit college complaints, track their progress,
            and receive updates from the administration.
        </p>

        <div class="hero-actions">
            <?php if (isset($_SESSION['user'])): ?>
                <a class="btn btn-primary" href="dashboard.php">
                    Open Dashboard →
                </a>
            <?php else: ?>
                <a class="btn btn-primary" href="register.php">
                    Get Started →
                </a>

                <a class="btn btn-light" href="login.php">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="hero-art">
        <div class="art-card">
            <div class="mini-icon">✓</div>
            <span class="status status-in-progress">
                In Progress
            </span>

            <h3>Complaint Tracking</h3>
            <p>Library facilities</p>

            <div class="progress">
                <span></span>
            </div>

            <p class="art-note">
                Your complaint is being reviewed.
            </p>
        </div>
    </div>
</section>

<section class="features">
    <div class="section-heading">
        <span class="eyebrow">HOW IT WORKS</span>
        <h2>From concern to solution</h2>
        <p>Three simple steps to improve your campus.</p>
    </div>

    <div class="feature-grid">
        <article class="feature-card">
            <div class="feature-icon purple">✎</div>
            <h3>1. Submit</h3>
            <p>Send your complaint to the administration.</p>
        </article>

        <article class="feature-card">
            <div class="feature-icon mint">◷</div>
            <h3>2. Track</h3>
            <p>Check the current status of your complaint.</p>
        </article>

        <article class="feature-card">
            <div class="feature-icon peach">✓</div>
            <h3>3. Resolve</h3>
            <p>View the response from the administration.</p>
        </article>
    </div>
</section>

<?php require_once "includes/footer.php"; ?>
