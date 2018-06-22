#!/bin/python

import sys
import os
import urllib2
import json

# Complete the function below.

def build_query(base_url, params) :
    for p in params:
        base_url += "&{}"

def get_json_from_url(url) :
    request = urllib2.urlopen(url)
    response = request.read()
    json_data = json.loads(response)
    return json_data

def get_all_movie_titles( search ):
    url_base = "https://jsonmock.hackerrank.com/api/movies/search/?Title=" + search + "&page="
    page_num = 1
    is_max_pages = False
    titles = []
    while not is_max_pages:
        url = url_base + str(page_num)
        data = get_json_from_url(url)
        max_pages = data["total_pages"]

        if page_num == max_pages:
            is_max_pages = True
        else:
            for movie_object in data["data"]:
                titles.append(movie_object["Title"])
        page_num += 1
    return sorted( titles )

def  getMovieTitles(substr):
    print( get_all_movie_titles(substr) )