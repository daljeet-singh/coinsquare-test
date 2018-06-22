<?php

function getMovieTitles($searchQuery) {
    $searchResults = array();
    $searchQuery = trim($searchQuery);
    if(!empty($searchQuery)) {
        $totalPage = getTotalPageNo($searchQuery);
        getResultsFromApi($searchResults, $searchQuery, $totalPage);
    }
    asort($searchResults);
    return $searchResults;
}

function getTotalPageNo($searchQuery) {
    $results = getApi($searchQuery);
    $totalPages = 0;
    if(isset($results['total_pages'])){
        $totalPages = $results['total_pages'];
    }
    return $totalPages;
}

function getResultsFromApi(&$searchResults, $searchQuery, $pageNo) {
    if($pageNo < 1) {
        return;
    }
    $results = getApi($searchQuery, $pageNo);
    if(isset($results['data'])) {
        $searchResults = array_merge($searchResults, fetchTitles($results['data']));
    }
    $pageNo -= 1;
    getResultsFromApi($searchResults, $searchQuery, $pageNo);
    return;
}

function getApi($searchQuery, $pageNo=1) {
    $baseEndpoint = "https://jsonmock.hackerrank.com/api/movies/search/";
    $endpoint = $baseEndpoint. "?Title=" . $searchQuery . "&page=". $pageNo;
    $results = file_get_contents($endpoint); 
    return json_decode( $results, true );
}

function fetchTitles($data) {
    $retArray = array();
    foreach($data as $key=>$value) {
        $retArray[] = $value['Title'];
    }
    return $retArray;
}

// print_r( getMovieTitles('Spiderman') );