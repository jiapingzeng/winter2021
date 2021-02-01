<link href="bootstrap.min.css" rel="stylesheet">
<link href="font-awesome.min.css" rel="stylesheet">
<style>
    #header {
        display: grid;
        grid-template-columns: 1fr 5fr 4fr;
        grid-gap: 2rem;
        grid-auto-flow: column;
        align-items: flex-end;
        margin: 1rem auto 1.5rem auto;
    }

    #header h1 {
        font-size: 3rem;
        margin: 0;
    }

    #header h1 a {
        color: black;
        text-decoration: none;
    }
</style>

<header id="header" class="container">
    <h1><a href="/">Moogle</a></h1>
    <form action="result.php" method="get">
        <div class="input-group mb3">
            <input type="text" class="form-control" id="search" name="search" placeholder="Search for actors or movies" required>
            <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search"></i></button>
        </div>
    </form>
</header>
<hr>