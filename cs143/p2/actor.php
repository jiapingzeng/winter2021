<!doctype html>
<html>

<?php
# establish connection
$db = new mysqli('localhost', 'cs143', '', 'cs143');
if ($db->connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}

$id = $_GET['id'];
$page = $_GET['page'] ? $_GET['page'] : 0;
$entriesPerPage = 50;
$offset = 0;

if ($page) {
    $offset = $page * $entriesPerPage;
}

if ($id) {
    # get specific actor
    $rs = $db->query("SELECT * FROM Actor WHERE id=$id;");
} else {
    # get all actors
    $rs = $db->query("SELECT * FROM Actor LIMIT $entriesPerPage OFFSET $offset");
}
?>

<head>
    <title>Actor | CS 143 Project 2</title>
</head>


<body>
    <?php include 'header.php'; ?>
    <main class="container">
        <table class="table">
            <thead>
                <th>Name</th>
                <th>Sex</th>
                <th>Date of birth</th>
                <th>Date of death</th>
            </thead>
            <tbody>
                <?php

                while ($row = $rs->fetch_assoc()) {
                    $aid = $row['id'];
                    $name = $row['first'] . ' ' . $row['last'];
                    $sex = $row['sex'];
                    $dob = $row['dob'];
                    $dod = $row['dod'] ? $row['dod'] : "Alive";
                    print "<tr><td><a href='actor.php?id=$aid'>$name</a></td><td>$sex</td><td>$dob</td><td>$dod</td></tr>";
                }

                if ($id) {
                    # change page title if showing specific actor
                    print "<script>document.title='$name | CS 143  Project 2'</script>";
                }
                ?>
            </tbody>
        </table>

        <table class="table">
            <thead>
                <th>Role</th>
                <th>Title</th>
            </thead>
            <tbody>
                <?php
                if ($id) {
                    # get related movies
                    $roles = $db->query("SELECT role, title, mid FROM Actor, Movie, MovieActor WHERE Actor.id=$id AND Actor.id=aid AND Movie.id=mid;");

                    if ($roles->num_rows) {
                        while ($row = $roles->fetch_assoc()) {
                            $role = $row['role'];
                            $title = $row['title'];
                            $mid = $row['mid'];
                            print "<tr><td>$role</td><td><a href='movie.php?id=$mid'>$title</a></td></tr>";
                        }
                    } else {
                        print "<tr><td colspan='2'>No role found</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <?php
        if ($id) {
            print "<a href='actor.php'>Show all actors</a>";
        } else {
            $prevPage = $page - 1;
            $nextPage = $page + 1;
            $count = $db->query("SELECT Count(*) AS count FROM Actor;")->fetch_assoc()['count'];

            if ($prevPage >= 0) {
                # has previous page
                print "<a href='actor.php?page=$prevPage'>Previous page</a>";
            }

            if ($nextPage < $count / 50) {
                # has next page
                print "<a href='actor.php?page=$nextPage'>Next page</a>";
            }
        }
        ?>
    </main>
    <?php
    $rs->free();
    ?>
</body>

</html>