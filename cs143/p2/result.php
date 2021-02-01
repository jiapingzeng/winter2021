<!doctype html>
<html>

<?php
# establish connection
$db = new mysqli("localhost", "cs143", "", "cs143");
if ($db->connect_errno > 0) {
    die("Unable to connect to database [" . $db->connect_error . "]");
}

# get query and cast to array
$searchQuery = $_GET["search"];
$queryArray = explode(" ", $searchQuery);

# actor results
$actors = $db->query("SELECT * FROM Actor WHERE CONCAT(first, ' ', last) LIKE '%" . implode("%' AND CONCAT(first, ' ', last) LIKE '%", $queryArray) . "%';");

# movie results
$movies = $db->query("SELECT * FROM Movie WHERE title LIKE '%" . implode("%' AND title LIKE '%", $queryArray) . "%';");

if ($searchQuery) {
    print "<script>document.onload = () => document.getElementById('search').value='$searchQuery'</script>";
}
?>

<head>
    <title>Search result | CS 143 Project 2</title>
</head>


<body>
    <?php include 'header.php'; ?>

    <main class="container">
        <p><?php print "Found $actors->num_rows actors and $movies->num_rows movies"; ?></p>
        <table class="table">
            <thead>
                <th>Name</th>
                <th>Date of birth</th>
            </thead>
            <tbody>

                <?php
                if ($actors->num_rows) {
                    while ($row = $actors->fetch_assoc()) {
                        $aid = $row['id'];
                        $first = $row["first"];
                        $last = $row["last"];
                        $dob = $row["dob"];
                        print "<tr><td><a href='actor.php?id=$aid'>$first $last</a></td><td>$dob</td></tr>";
                    }
                } else {
                    print "<tr><td colspan='2'>None found</td></tr>";
                }
                ?>

            </tbody>
        </table>
        <table class="table">
            <thead>
                <th>Title</th>
                <th>Year</th>
                <th>Rating</th>
            </thead>
            <tbody>

                <?php
                if ($movies->num_rows) {
                    while ($row = $movies->fetch_assoc()) {
                        $mid = $row['id'];
                        $title = $row["title"];
                        $year = $row["year"];
                        $rating = $row["rating"];
                        print "<tr><td><a href='movie.php?id=$mid'>$title</a></td><td>$year</td><td>$rating</td></tr>";
                    }
                } else {
                    print "<tr><td colspan='3'>None found</td></tr>";
                }
                ?>

            </tbody>
        </table>
    </main>
    <?php
    $rs->free();
    ?>
</body>

</html>