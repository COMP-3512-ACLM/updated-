<?php
session_start();
include "includes/helpers.inc.php";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style/reset.css" />
        <link rel="stylesheet" href="style/style.css" />
        <link rel="stylesheet" href="style/browse.css" />
        <script src="script/header.js"></script>
        <script src="script/browse.js"></script>
    </head>
    <body>
        <?php outputHeader(); ?>
        <main class="browse">
            <!--Filters-->
            <div id="filters" class="container">
                <h1>Movie Filters</h1>
                <form>
                    <!--Title-->
                    <fieldset>
                        <legend>Title</legend>
                        <input type="text" id="title"/>
                    </fieldset>
                    <!--Year-->
                    <fieldset>
                        <legend>Year</legend>
                        <!--Before-->
                        <div>
                            <input type="radio" id="beforeYearRadio" name="years" value="beforeYear" class="year">
                                <label>Before</label>
                            <input type="text" id="beforeYear" min="0" max="2020"  class="yearIn"><br/>
                        </div>
                        <!--After-->
                        <div>
                            <input type="radio" id="afterYearRadio" name="years" value="afterYear" class="year">
                                <label>After</label>
                            <input type="text" id="afterYear" min="0" max="2019" class="yearIn">
                        </div>
                        <!--Between-->
                        <div>
                            <input type="radio" id="between" name="years" value="between" class="year">
                                    <label>Between</label>
                            <input type="text" id="betweenStart" min="0" max="2020" placeholder="1900" class="yearIn">
                            <input type="text" id="betweenEnd" min="0" max="2020" placeholder="2019" class="yearIn">
                        </div>
                    </fieldset>
                    <!--Rating-->
                    <fieldset>
                        <legend>Rating</legend>
                        <!--Below-->
                        <div>
                            <input type="radio" id="belowRateRadio" name="rating" value="belowRate" class="rate">
                                <label>Below</label>
                            
                            <input name="below" type="range" min="1" max="10" value="5" id="belowRate" class="rateIn"/>
                            <output for="below">5</output>
                        </div>
                        <!--Above-->
                        <div>
                            <input type="radio" id="aboveRateRadio" name="rating" value="aboveRate" class="rate">
                                <label>Above</label>
                            
                            <input name="above" type="range" min="1" max="10" value="5" id="aboveRate"  class="rateIn"/>
                            <output for="above">5</output>
                        </div>
                        <!--Between-->
                        <div>
                            <input type="radio" id="betweenRating" name="rating" value="rate" class="rate">
                                <label>Between</label>
                            
                            <input name="between-lower" type="range" min="1" max="10" value="5" id="rateStart" class="rateIn"/>
                            <output for="between-lower">5</output>
                            <input name="between-upper" type="range" min="1" max="10" value="5" id="rateEnd" class="rateIn"/>
                            <output for="between-upper">5</output>
                        </div>
                    </fieldset>
                    <div>
                        <button id="filter" type="button">Filter</button>
                        <button>Clear</button>
                    </div>
                </form>
            </div>
            <!--Results-->
            <div id="results-panel" class="container"><!-- This could have a better ID -->
                <button id="hide"></button>
                <div id="sort-headers"> <!-- This div was added in -->
                    <h1>Search Results</h1>
                    <div id="sortbar">
                        <h2>Sort by:</h2>
                        <span data-sortid="title" data-sortdir="1">Title</span>
                        <span data-sortid="vote_average" data-sortdir="1">Rating</span>
                        <span data-sortid="release_date" data-sortdir="1">Year</span>
                    </div>
                </div>
                
                <ul id="results"></ul>
            </div>
        </main>
    </body>
</html>