<?php
include "includes/helpers.inc.php";
include "includes/db-movies.inc.php";

$connection = null;
$movie = null;

if (isset($_GET["id"])) {
    $connection = getConnection();
    $movie = getSingleMovie($connection, $_GET["id"]);
}

// Abort if there is no movie to display
if ($movie == null) {
    header("Location: index.php");
}

$release = strtotime($movie["release_date"]); // This variable is used in two places, so it is declared here

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style/reset.css" />
        <link rel="stylesheet" href="style/style.css" />
        <link rel="stylesheet" href="style/single-movie.css" />
        <script src="script/single-movie.js"></script>
    </head>
    <body>
        <?php outputHeader(); ?>
        <main>
            <div id="card">
                <figure id="poster">
                    <img src="https://image.tmdb.org/t/p/w185/<?=$movie["poster_path"]; ?>" />
                    <div><span class=icon>🔍</span></div>
                </figure>
                <div id="info">
                    <h1><?=$movie["title"]; ?></h1>
                    <p><?=$movie["tagline"]; ?></p>
                    <hr />
                    <small>
                        <!-- 5-star rating -->
                        <span>
                            <?php
                            $stars = round($movie["vote_average"] / 2);

                            for ($i = 0; $i < 5; $i++) {
                                echo "<span class='star";

                                // Fill in the appropriate number of stars
                                if ($i < $stars) {
                                    echo " filled";
                                }

                                echo "'>★</span>";
                            }
                            ?>
                        </span>
                        <!-- Genres -->
                        <span id="genres">
                            <?php
                            $genres = json_decode($movie["genres"], true);
                            foreach ($genres as $g) {
                                echo "<span>" . $g["name"] . "</span>";
                            }
                            ?>
                        </span>
                        <!-- Runtime -->
                        <span>
                            <span class="icon">🕒</span>
                            <?php
                            $hours = floor($movie["runtime"] / 60);
                            $minutes = $movie["runtime"] % 60;

                            echo $hours . "h " . $minutes . "min";
                            ?>
                        </span>
                        <!-- Release Year -->
                        <span><?=date("Y", $release); ?></span>
                    </small>
                    <hr />
                    <h2>Overview</h2>
                    <p id="synopsis"><?=$movie["overview"]; ?></p>
                </div>
                <div id="links">
                    <a href="https://www.imdb.com/title/<?=$movie["imdb_id"]; ?>">IMDb</a>
                    <a href="https://www.themoviedb.org/movie/<?=$movie["tmdb_id"]; ?>">TMDD</a>
                    <button>Favourite</button>
                </div>
            </div>
             <!-- Score -->
                <div id="score">
                    <h2>Score</h2>
                    <h3>Rating</h3>
                    <dl>
                        <dt>Average</dt>
                        <dd><?=$movie["vote_average"]; ?></dd>
                        <dt>Reviews</dt>
                        <dd><?=number_format($movie["vote_count"]); ?></dd>
                    </dl>
                    <h3>Popularity</h3>
                    <div><?=number_format($movie["popularity"], 1); ?></div>
                </div>
            
            
                <!-- IMPORTANT, Moved details and keywords out of their div containers. -->
                <!-- Details -->
                <div id="details">
                    <h2>Movie Details</h2>
                    <dl>
                        <dt>Release Date</dt>
                        <dd><?=date("F j, Y", $release); ?></dd>
                        <dt>Revenue</dt>
                        <dd>$<?=number_format($movie["revenue"], 2); ?></dd>
                        <dt>Companies</dt>
                        <dd>
                            <?php
                            $companies = json_decode($movie["production_companies"], true);
                            foreach ($companies as $c) {
                                echo "<div>" . $c["name"] . "</div>";
                            }
                            ?>
                        </dd>
                        <dt>Countries</dt>
                        <dd>
                            <?php
                            $countries = json_decode($movie["production_countries"], true);
                            foreach ($countries as $c) {
                                echo "<div>" . $c["name"] . "</div>";
                            }
                            ?>
                        </dd>
                    </dl>
                </div>
                <!-- Keywords -->
                <div id="keywords">
                    <h2>Keywords</h2>
                    <div>
                        <?php
                        $keywords = json_decode($movie["keywords"], true);

                        foreach ($keywords as $k) {
                            echo "<span>" . $k["name"] . "</span>";
                        }
                        ?>
                    </div>
                </div>
            
            
            
            <div>
                <!-- Production -->
                <div id="production">
                    <h2>Production</h2>
                    <div id="tabs">
                        <button id="tab-cast">Cast</button>
                        <button id="tab-crew">Crew</button>
                    </div>
                    <table id="cast">
                        <thead>
                            <tr>
                                <th>Actor/Actress</th>
                                <th>Character</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cast = json_decode($movie["cast"], true);
                            usort($cast, fn($a, $b) => $a["order"] <=> $b["order"]);

                            foreach ($cast as $c) {
                                echo "<tr>";

                                echo "<td>" . $c["name"] . "</td>";
                                echo "<td>" . $c["character"] . "</td>";

                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <table id="crew">
                        <thead>
                            <tr>
                                <th>Crew Member</th>
                                <th>Department</th>
                                <th>Job</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $crew = json_decode($movie["crew"], true);
                            usort($crew, fn($a, $b) => $a["department"] <=> $b["department"]);

                            foreach ($crew as $c) {
                                echo "<tr>";

                                echo "<td>" . $c["name"] . "</td>";
                                echo "<td>" . $c["department"] . "</td>";
                                echo "<td>" . $c["job"] . "</td>";

                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <div id="lightbox">
            <div></div><!-- Overlay -->
            <img src="https://image.tmdb.org/t/p/w500/<?=$movie["poster_path"]; ?>" />
        </div>
    </body>
</html>