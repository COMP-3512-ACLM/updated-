const api = "https://salty-oasis-67120.herokuapp.com/api-movies-brief.php";

let originalResults = JSON.parse(localStorage.getItem("movies"));
let searchResults;

document.addEventListener("DOMContentLoaded", function () {
    const filterPanel = document.querySelector("#filters");
    const resultsPanel = document.querySelector("#results-panel");
    
    // Generate initial search results
    let searchString = new URLSearchParams(location.search).get("search");
    if (!searchString) {
        searchString = "";
    }
    search(searchString);
    
    
    //Updates the range outputs
    filterPanel.addEventListener("input", e => {
        if (e.target.nodeName == "INPUT" && e.target.getAttribute("type") == "range") {
            document.querySelector(`output[for="${e.target.name}"]`).textContent = e.target.value;
        }
    });
    
    //Sorting search results
    const sortButtons = document.querySelectorAll("#sortbar span");
    
    document.querySelector("#sortbar").addEventListener("click", e => {
        if (e.target.nodeName == "SPAN") {
            for (let btn of sortButtons) {
                if (btn == e.target) {
                    // Reverse the sort direction if the same button is pressed twice
                    if (btn.classList.contains("selected")) {
                        btn.dataset.sortdir = btn.dataset.sortdir * -1;
                    }
                    
                    btn.classList.add("selected");
                } else {
                    // Unselect all other buttons
                    btn.classList.remove("selected");
                }
            }
            
            sortResults();
            generateSearchResults();
        }
    });
    
    // Toggling the filter panel
    document.querySelector("#hide").addEventListener("click", e => {
        filterPanel.classList.toggle("hidden");
        resultsPanel.classList.toggle("open");
    });
    
    
    document.querySelector("#filter").addEventListener("click" , function () 
    {
        searchResults = originalResults;
        getTitleFilter();
        getYearFilter();
        getRatingFilter();
        generateSearchResults();
    });
    
    
    
    
});















function searchMoviesByTitle(searchString)
    {
        const search = new RegExp(searchString, 'i');
        //alert("GG");
        searchResults = searchResults.filter(movie => movie.title.match(search));
    }
    //use this by after year
    function filterMoviesByAfterYear()
    {
        const filterYear = document.querySelector("#afterYear").value;
        searchResults = searchResults.filter(movie => movie.release_date.substring(0, 4) >= filterYear);
        //alert("after");
    }
    //use this to filter for after year
    function filterMoviesByBeforeYear()
    {
        const filterYear = document.querySelector("#beforeYear").value;
        searchResults = searchResults.filter(movie => movie.release_date <= filterYear);
        //alert("before");
    }
    
    //use this for bwtween ratings
    function filterMoviesByBetweenYear()
    {
        const filterYearStart = document.querySelector("#betweenStart").value;
        const filterYearEnd = document.querySelector("#betweenEnd").value;
        searchResults = searchResults.filter(movie => movie.release_date.substring(0, 4) >= filterYearStart && movie.release_date.substring(0, 4) <= filterYearEnd );
        //alert("B");
    }
    
    //use this for after rating
    function filterMovieByAboveRating()
    {
        //alert("GGG");
        const rating = document.querySelector("#aboveRate").value;
        searchResults = searchResults.filter(movie => movie.vote_average >= rating);
        //alert(t);
    }
    
    //use this for below rating
    function filterMovieByBelowRating()
    {
        const rating = document.querySelector("#belowRate").value;
        console.log(rating);
        searchResults = searchResults.filter(movie => movie.vote_average <= rating);
    }
    
    //use this for between ratings
    function filterMovieByBetweenRating()
    {
        const startRate = document.querySelector("#rateStart").value;
        const endRate = document.querySelector("#rateEnd").value;
        searchResults = searchResults.filter(movie => movie.vote_average >= startRate && movie.vote_average <= endRate);
        
    }
    
    function getTitleFilter()
    {
        const title = document.querySelector("#title").value;
        //console.log(title);
        if(title)
        {
            //alert(title);
            searchMoviesByTitle(title);
        }
    }
    
    function getYearFilter()
    {
        const yearRadios = document.querySelectorAll(".year");
        let selectedYear = null;
        for (let yR of yearRadios)
        {
            if(yR.checked){
                selectedYear = yR.value;
            }
        }
        //alert(selectedYear);
        switch(selectedYear)
        {
            case "beforeYear":
                filterMoviesByBeforeYear();
                break;
            case "afterYear":
                filterMoviesByAfterYear();
                break;
            case "between":
                filterMoviesByBetweenYear();
                break;
            default:
                break;
        }//end of switch
        
    }//end of function for getYearFilter
    
    function getRatingFilter()
    {
        const ratingRadios = document.querySelectorAll(".rate");
        let selectedRating = null;
        for (let rR of ratingRadios)
        {
            if(rR.checked){
                selectedRating = rR.value;
            }
        }
        //alert("FF" + selectedRating);
        switch(selectedRating)
        {
            case "belowRate":
                filterMovieByBelowRating();
                break;
            case "aboveRate":
                filterMovieByAboveRating();
                break;
            case "rate":
                filterMovieByBetweenRating();
                break;
            default:
                break;
        }//end of switch
        
    }


























async function search(searchString) {
    try {
        const movies = await fetchMovies();
        
        const regex = new RegExp(searchString, "gi");
        searchResults = movies.filter(movie => movie.title.match(regex));
        sortResults();
        
        generateSearchResults();
    } catch (error) {
        console.error(error);
    }
    
    async function fetchMovies() {
        let movies = JSON.parse(localStorage.getItem("movies"));

        // Fetch the data and store it in local storage if nothing was found
        if (!movies) {
            console.log("fetching movies");
            const response = await fetch(api);
            movies = await response.json();
            localStorage.setItem("movies", JSON.stringify(movies));
        } else {
            console.log("movies retrieved");
            console.log(movies.length);
        }

        return movies;
    }
}

function generateSearchResults() {
    const list = document.querySelector("#results");
    list.innerHTML = "";
    
    for (let movie of searchResults) {        
        
        let item = document.createElement("li");
        
        // Poster
        let poster = createLink(movie.id);
        let img = document.createElement("img");
        img.setAttribute("src", getPoster(movie, 92));
        poster.appendChild(img);
        
        // Movie information container
        let info = document.createElement("div");
        
        // Title
        let title = createLink(movie.id);
        let h2 = document.createElement("h2");
        h2.textContent = movie.title;
        title.appendChild(h2);
        
        // Rating
        let rating = document.createElement("span");
        rating.classList.add("rating");
        rating.textContent = movie.vote_average;
        
        let star = document.createElement("span");
        star.classList.add("star");
        star.classList.add("filled");
        star.classList.add("icon");
        star.textContent = "★";
        
        rating.appendChild(star);
        
        // Year
        let year = document.createElement("span");
        year.classList.add("year");
        year.textContent = movie.release_date.substring(0,4);
        
        // Overview
        let overview = document.createElement("p");
        overview.textContent = movie.overview;
        
        // View button
        let button = createLink(movie.id);
        button.classList.add("button");
        button.textContent = "View";
        
        info.appendChild(title);
        info.appendChild(rating);
        info.appendChild(year);
        info.appendChild(overview);
        info.appendChild(button);
        
        item.appendChild(poster);
        item.appendChild(info);

        list.appendChild(item);
    }
    
    function createLink(id) {
        let link = document.createElement("a");
        link.setAttribute("href", `single-movie.php?id=${id}`);
        return link;
    }
}

/* Sorts search results depending on the selected "sort" button, or by ascending title if none selected. */
function sortResults() {
    const sortButtons = document.querySelectorAll("#sortbar span");
    
    let parameter = "title"; // Sort by title by default
    let direction = 1; // Sort ascending by default
    
    for (let btn of sortButtons) {
        if (btn.classList.contains("selected")) {
            parameter = btn.dataset.sortid;
            direction = btn.dataset.sortdir;
        }
    }
    
    searchResults = searchResults.sort( (a, b) => (a[parameter] > b[parameter] ? 1 : -1) * direction );
}

/* Returns the image source (an url) for the given movie. */
function getPoster(movie, width) {
    return "https://image.tmdb.org/t/p/w" + width + movie.poster_path;
}