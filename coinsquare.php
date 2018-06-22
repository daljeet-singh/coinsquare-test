<?php
error_reporting(E_ERROR | E_PARSE);

function fetch( $url ) {
    $content = file_get_contents( $url );
    return json_decode( $content, true );
}

function getMovieNamesFromData( $arr ) {
    $data = [];
    $movieTitleKeyName = 'Title';
    $dataKeyName = 'data';
    foreach( $arr[$dataKeyName] as $movieName ) {
        $data[] = $movieName[$movieTitleKeyName];
    }
    return $data;
}

function getMovieTitles( $substr ) {
    $pageNum = 1;
    $total = [];
    $initial = [];
    $baseUrl = "https://jsonmock.hackerrank.com/api/movies/search/?Title=" . $substr;
    $pageSlug =  "&page=" . $pageNum;
    $initial = fetch( $baseUrl . $pageSlug );
    $totalPages = $initial['total_pages'];
    $total = array_merge( $total, getMovieNamesFromData( $initial ) );
    for( $i = $pageNum+1 ; $i <= $totalPages; $i++ ) {
        $url = $baseUrl . "&page=" . $i;
        $nextPageData = fetch( $url );
        $total = array_merge( $total, getMovieNamesFromData( $nextPageData ) );
    }
    asort( $total );
    return $total;
}

// print_r( getMovieTitles( 'Spiderman' ) );