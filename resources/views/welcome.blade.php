@extends('layouts.main')
@section('title', 'Welcome to Web Crawler')
@section('container')
<div class="container">
    <div class="card text-center">
        <div class="welcome-text">Welcome to the Web Crawler Challenge!</div>
        <div class="icon"><i class="fas fa-code"></i></div>
        <div class="intro-text">
            The Web Crawler Challenge is a PHP/Laravel-based project that allows you to crawl a website and gather useful information about it.
        </div>
        <div class="intro-text">
            The challenge consists of building a web crawler that can crawl 4-6 pages of a given website and display the following results:
        </div>
        <ul class="list-group text-left">
            <li class="list-group-item">Number of pages crawled</li>
            <li class="list-group-item">Number of unique images</li>
            <li class="list-group-item">Number of unique internal links</li>
            <li class="list-group-item">Number of unique external links</li>
            <li class="list-group-item">Average page load time in seconds</li>
            <li class="list-group-item">Average word count</li>
            <li class="list-group-item">Average title length</li>
        </ul>
  
    </div>

    <div class="card-container">
        <div class="card col-md-12">
            <a href="/web-crawler" class="btn btn-primary">Crawling Form</a>
        </div>
        <div class="card col-md-12">
            <a href="/web-crawler/agencyanalytics" class="btn btn-primary">Crawling AgencyAnalytics</a>
        </div>            
    </div>  
</div>

@endsection