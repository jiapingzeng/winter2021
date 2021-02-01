<!doctype html>
<html>

<head>
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome.min.css" rel="stylesheet">
    <title>CS 143 Project 2</title>
    <style>
        body {
            height: 100vh;
            display: grid;
            place-items: center;
        }

        #main {
            width: 70%;
            max-width: 960px;
            text-align: center;
            place-items: center;
        }

        #main h1 {
            font-size: 7rem;
            margin: 0 auto 2rem auto;
        }

        #main h1 span {
            font-size: 0.8rem;
        }

        #links {
            width: 40%;
            margin: 2rem auto 4rem auto;
            display: grid;
            grid-auto-flow: column;
            grid-gap: 2rem;
        }
    </style>
</head>


<body>
    <main id="main">
        <h1>Moogle <span>for moovies</span></h1>
        <form action="result.php" method="get">
            <div class="input-group mb3">
                <span class="input-group-text">
                    <i class="fa fa-search"></i>
                </span>
                <input type="text" class="form-control" id="search" name="search" placeholder="Search for actors or movies" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
        <div id="links">
            <a href="actor.php" class="btn btn-light">Show all actors</a>
            <a href="movie.php" class="btn btn-light">Show all movies</a>
        </div>

    </main>
</body>

</html>