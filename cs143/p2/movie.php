<!doctype html>
<html>

<?php
# establish connection
$db = new mysqli('localhost', 'cs143', '', 'cs143');
if ($db->connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}

# check for GET data
$id = $_GET['id'];
$page = $_GET['page'] ? $_GET['page'] : 0;
$entriesPerPage = 50;
$offset = 0;

# check for POST data
$name = $_POST['name'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

if ($name && $rating && $comment) {
    # handle comment form
    $db->query("INSERT INTO Review VALUES('$name', NOW(), $id, $rating, '$comment');");
    if ($db->errno > 0) {
        print $db->error;
    }
}

if (!$id && $page) {
    # pagination
    $offset = $page * $entriesPerPage;
}

if ($id) {
    # get specific actor
    $rs = $db->query("SELECT Movie.*, AVG(Review.rating) as avgreview FROM Movie, Review WHERE id=$id AND mid=$id;");
} else {
    # get all actors
    $rs = $db->query("SELECT * FROM Movie LIMIT $entriesPerPage OFFSET $offset;");
}
?>

<head>
    <title>Movie | CS 143 Project 2</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <main class="container">
        <table class="table">
            <thead>
                <th>Title</th>
                <th>Year</th>
                <th>Rating</th>
                <th>Company</th>
                <?php
                if ($id) {
                    print "<th>Average review</th>";
                }
                ?>
            </thead>
            <tbody>
                <?php
                # get movies
                while ($row = $rs->fetch_assoc()) {
                    $mid = $row['id'];
                    $title = $row['title'];
                    $year = $row['year'];
                    $rating = $row['rating'];
                    $company = $row['company'];
                    $avgreview = $row['avgreview'] ? $row['avgreview'] : "No review yet";
                    print "<tr><td><a href='movie.php?id=$mid'>$title</a></td><td>$year</td><td>$rating</td><td>$company</td>";

                    if ($id) {
                        print "<td>$avgreview</td>";
                    }

                    print "</tr>";
                }

                if ($id) {
                    # change page title if showing specific movie
                    print "<script>document.title='$title | CS 143  Project 2'</script>";
                }
                ?>
            </tbody>
        </table>

        <table class="table">
            <thead>
                <th>Actor</th>
                <th>Role</th>
            </thead>
            <tbody>
                <?php
                if ($id) {
                    # get actors
                    $rs = $db->query("SELECT first, last, role, aid FROM Actor, Movie, MovieActor WHERE Actor.id=aid AND Movie.id=$id AND Movie.id=mid;");
                    while ($row = $rs->fetch_assoc()) {
                        $name = $row['first'] . ' ' . $row['last'];
                        $role = $row['role'];
                        $aid = $row['aid'];
                        print "<tr><td><a href='actor.php?id=$aid'>$name</a></td><td>$role</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <table class="table">
            <thead>
                <th>Name</th>
                <th>Time</th>
                <th>Rating</th>
                <th>Comment</th>
            </thead>
            <tbody>
                <?php

                $reviews = $db->query("SELECT * FROM Review WHERE mid=$id");

                if ($reviews->num_rows) {
                    while ($row = $reviews->fetch_assoc()) {
                        $name = $row['name'];
                        $time = $row['time'];
                        $rating = $row['rating'];
                        $comment = $row['comment'];
                        print "<tr><td>$name</td><td>$time</td><td>$rating</td><td>$comment</td></tr>";
                    }
                } else {
                    print "<tr><td colspan='4'>No reviews yet. Add one below!</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <form action="movie.php?id=<?= $id ?>" method="post">
            <div>
                <label for="name" class="form-label">Name</label>
                <input type="text" maxlength="20" id="name" name="name">
            </div>
            <div>
                <label for="rating" class="form-label">Rating</label>
                <input type="range" min="0" max="5" id="rating" name="rating">
            </div>
            <div>
                <label for="comment" class="form-label">Comment</label>
                <textarea id="comment" maxlength="500" name="comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>

</body>

<?php
$rs->free();
?>

</html>