@extends('layouts.main')

@section('title', 'Web Crawler')

@section('container')
    <h1>AgencyAnalytics Crawler View</h1>

    <!-- New Result Card -->
    <h2 class="mt-5">Crawler Result</h2>

    <div class="container">
        <div class="card text-center" id="GeneralResult"> 
        </div>
        <div class="card table-responsive">
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

    </div>

    <div class="card-container" id="newResultCard">
        <!-- AJAX will populate this card body -->
    </div>

<script>
setTimeout(function() {
        $(document).ready(function () {
            const urls =['https://agencyanalytics.com',
                     'https://agencyanalytics.com/feature/google-analytics-dashboard',
                     'https://agencyanalytics.com/feature/white-label',
                     'https://agencyanalytics.com/help-center',
                     'https://agencyanalytics.com/report-templates',
                     'https://agencyanalytics.com/feature/instagram-analytics-dashboard'];

            AgencyanalyticsSubmit(urls);
        });


    }, 250);

        
</script>
@endsection
