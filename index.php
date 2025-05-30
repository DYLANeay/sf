<?php include("includes/header.php"); ?>

<?php include("includes/navbar.php"); ?>

<?php


//connect to the database
include("config.php");
$conn = connectDB();

// Check if the user is logged in
include("pages/database-check/auth_check.php");
checkAuth();

// Get the user's pseudo from the session
$userPseudo = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Invité';

?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Accueil - <?php echo $userPseudo ?></h1>
                <p class="text-center">Utilisez le menu pour naviguer entre les différentes sections.</p>
                <p class="text-center">Dernière vidéo full-value :</p>
                <div class="video-container align-items-center d-flex justify-content-center">
                    <iframe width="860" height="415" src="https://www.youtube.com/embed/3dFkXZ5myYk?si=657kAfZgevgNP8IR" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    iframe {
        margin-top: 1rem;
    }
</style>

<?php include("includes/footer.php"); ?>