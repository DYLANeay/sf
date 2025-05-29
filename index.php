<?php include("includes/header.php"); ?>

<?php include("includes/navbar.php"); ?>

<?php

//connect to the database
include("config.php");

//try to connect to the database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// 2. Prepare and execute the query
$sql = "SELECT pseudo FROM users LIMIT 1";
$stmt = $conn->query($sql);

// 3. Fetch the result
$userPseudo = null;
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $userPseudo = $row['pseudo'];
}

?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Accueil - <?php echo $userPseudo ?></h1>
                <p class="text-center">Utilisez le menu pour naviguer entre les différentes sections.</p>
            </div>
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>