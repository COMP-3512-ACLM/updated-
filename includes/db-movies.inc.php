<?php

require_once "db-common.inc.php";

define("FIELDS_BRIEF", "id, tmdb_id, imdb_id, release_date, title, runtime, revenue, tagline, poster_path, vote_average, vote_count, popularity, overview");

// Returns brief information on all movies.
function getAllMoviesBrief($connection) {
    try {
        $sql = "SELECT " . FIELDS_BRIEF . " FROM movie";
        return runQuery($connection, $sql, null);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

// Returns brief information on a single movie.
function getSingleMovieBrief($connection, $id) {
    try {
        $sql = "SELECT " . FIELDS_BRIEF . " FROM movie WHERE id=?";
        return runQuery($connection, $sql, $id);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

// Returns all information on a single movie.
function getSingleMovie($connection, $id) {
    try {
        $sql = "SELECT * FROM movie WHERE id=?";
        return runQuery($connection, $sql, $id)->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

?>