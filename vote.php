<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$voter_id = $_SESSION['voter_id'];

// Check if the voter has already voted
$stmt = $conn->prepare("SELECT has_voted FROM voters WHERE id = :voter_id");
$stmt->execute(['voter_id' => $voter_id]);
$voter = $stmt->fetch(PDO::FETCH_ASSOC);

if ($voter['has_voted']) {
    die("You have already voted.");
}

// Fetch candidates
$stmt = $conn->query("SELECT * FROM candidates");
$candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle voting
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['candidate_id'])) {
    $candidate_id = $_POST['candidate_id'];

    // Insert the vote into the database
    $stmt = $conn->prepare("INSERT INTO votes (voter_id, candidate_id) VALUES (:voter_id, :candidate_id)");
    $stmt->execute(['voter_id' => $voter_id, 'candidate_id' => $candidate_id]);

    // Mark the voter as having voted
    $stmt = $conn->prepare("UPDATE voters SET has_voted = 1 WHERE id = :voter_id");
    $stmt->execute(['voter_id' => $voter_id]);

    echo "Thank you for voting!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Vote</h1>
        <form method="POST" action="vote.php">
            <?php foreach ($candidates as $candidate): ?>
                <div class="candidate">
                    <input type="radio" id="candidate<?php echo $candidate['id']; ?>" name="candidate_id" value="<?php echo $candidate['id']; ?>" required>
                    <label for="candidate<?php echo $candidate['id']; ?>">
                        <h3><?php echo htmlspecialchars($candidate['name']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($candidate['description'])); ?></p>
                    </label>
                </div>
            <?php endforeach; ?>
            <button type="submit">Submit Vote</button>
        </form>
    </div>
</body>
</html>
