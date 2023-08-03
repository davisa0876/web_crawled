<!-- resources/views/web_crawler.blade.php -->

@extends('layouts.main')

@section('title', 'Web Crawler')
@section('container')

    <h1>Web Crawler View</h1>

    <!-- Form to input the link -->
    <form id="crawlForm" class="mt-4">
        <div class="form-group">
            <label for="crawlLinks">Enter website links (1 to 6):</label>
            @for ($i = 0; $i < 6; $i++)
                @if ($i==0)
                  <input type="text" class="form-control mb-2" id="crawlLinks" name="url[]" value='https://agencyanalytics.com' placeholder="Enter a website link...">
                @else
                  <input type="text" class="form-control mb-2" id="crawlLinks" name="url[]" placeholder="Enter a website link...">
                @endif
                
            @endfor
            <button type="submit" class="btn btn-primary">Crawl</button>
        </div>
        <!-- Display the validation error message for the 'url' input -->
        @error('url.*')
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
        @enderror
    </form>
    <!-- New Result Card -->
    <h2 class="mt-5">Crawler Result</h2> 
    <div class="card text-center" id="GeneralResult"> 
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0 text-md-nowrap">
            <thead>
                <tr>
                    <th>URL</th>
                    <th>Status Code</th>
                </tr>
            </thead>
            <tbody id="status-container"></tbody>
        </table>
    </div>    
    
    <div class="card-container" id="newResultCard">
        <!-- AJAX will populate this card body -->
    </div>
    




@endsection
