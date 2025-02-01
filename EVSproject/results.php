<?php
// Include your database connection file
include('connection.php');

// Query to fetch results
$sql = "
    SELECT c.position, c.faculty, c.name AS candidate_name, COUNT(v.id) AS vote_count
    FROM candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    GROUP BY c.position, c.faculty, c.name
    ORDER BY 
        CASE
            WHEN c.position = 'president' THEN 1
            WHEN c.position = 'deputy' THEN 2
            WHEN c.position = 'faculty-rep' THEN 3
            WHEN c.position = 'residence-rep' THEN 4
            WHEN c.position = 'non-resident-rep' THEN 5
            WHEN c.position = 'environment-rep' THEN 6
            WHEN c.position = 'sports-rep' THEN 7
            ELSE 8
        END, c.faculty, vote_count DESC;
";

$result = $conn->query($sql);

// Initialize array to store results by position and faculty
$results_by_position_and_faculty = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $results_by_position_and_faculty[$row['position']][$row['faculty']][] = [
            'candidate_name' => $row['candidate_name'],
            'vote_count' => $row['vote_count']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Results</title>
    <link rel="stylesheet" href="results.css"> <!-- Link to your CSS file -->
</head>
<body>
<div class="overlay"></div>

<div class="results-container">
    <?php foreach ($results_by_position_and_faculty as $position => $faculties): ?>
        <div class="position-section">
            <h2><?php echo ucfirst($position); ?></h2>
            <div class="faculty-container">
                <?php
                $total_votes_position = 0;
                foreach ($faculties as $faculty => $candidates): ?>
                    <div class="faculty-section">
                        <h3><?php echo htmlspecialchars($faculty); ?></h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Candidate</th>
                                    <th>Votes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_votes_faculty = 0;
                                foreach ($candidates as $candidate): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($candidate['candidate_name']); ?></td>
                                        <td><?php echo htmlspecialchars($candidate['vote_count']); ?></td>
                                    </tr>
                                    <?php
                                    $total_votes_faculty += $candidate['vote_count'];
                                    $total_votes_position += $candidate['vote_count'];
                                    ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if ($position === 'faculty-rep'): ?>
                            <div class="total-votes-faculty">
                                <strong>Total Votes for <?php echo htmlspecialchars($faculty); ?> Faculty: <?php echo $total_votes_faculty; ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="total-votes-position">
                <strong>Total Votes for <?php echo ucfirst($position); ?>: <?php echo $total_votes_position; ?></strong>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>