<?php
session_start();
include 'config.php';

// Fetch vote counts for each candidate
$stmt = $conn->query("
    SELECT candidates.name, COUNT(votes.id) AS vote_count 
    FROM candidates 
    LEFT JOIN votes ON candidates.id = votes.candidate_id 
    GROUP BY candidates.id
");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Voting Results</h1>
        <table>
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th>Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['name']); ?></td>
                        <td><?php echo $result['vote_count']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
