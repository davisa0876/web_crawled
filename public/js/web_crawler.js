// public/js/web_crawler.js

// Function to show the loading GIF while the request is being processed
function showLoading() {
    $('#loading').removeClass('d-none');
}

// Function to hide the loading GIF after the request is complete
function hideLoading() {
    $('#loading').addClass('d-none');
}

// Function to display the new result in a card
function displayNewResults(results) {
    let newResultCards = '';
    let GeneralResult = '';

    console.log(results);
    console.log(results.urls);
    let urls = results.urls;
    let UiUrls = '<ul class="left-align">';
    for (i = 0; i < urls.length; i++) {
        UiUrls    += '<li>'+urls[i]+'</li>';
    }
    UiUrls += '</ul>';

    let table = '';
    let StatusURL = results.StatusURL;
    for (i = 0; i < StatusURL.length; i++) {
        table    += '<tr>';
        table    += '<td>'+StatusURL[i].url+'</td>';
        table    += '<td>'+StatusURL[i].statusCode+'</td>';
        table    += '</tr>';
    }
    $('#status-container').html(table);


    var generalAverageLoadTime = (results.generalAverageLoadTime/1000);
    GeneralResult = `
        <div class="col-md-20 mb-4">
            <div class="card mt-4">
                <div class="card-body">
                    <p class="card-text card-text left-align"><strong>Pages Crawled:</strong></p><p >${UiUrls}</p>
                    <p class="card-text card-text left-align"><strong>Total Pages Crawled:</strong> ${results.totalURLs}</p>
                    <p class="card-text card-text left-align"><strong>Average Pages Load Time:</strong> ${generalAverageLoadTime.toFixed(4)} seconds</p>
                    <p class="card-text card-text left-align"><strong>Average Word Count:</strong> ${results.generalAverageWordCount.toFixed(2)} </p>
                    <p class="card-text card-text left-align"><strong>Average Title Length:</strong> ${results.generalTitleLength.toFixed(2)} </p>

                </div>
            </div>
        </div>
    `;
    results = results.data;
    results.forEach((result,index) => {
        var LoadTime = (result.LoadTime/1000);
        let newResultCard = `
        <div class="col-md-6 mb-4">
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">${result.url}</h5>
                    <hr>
                    <p class="card-text"><strong>Page Load Time:</strong> ${LoadTime.toFixed(4)} seconds</p>
                    <p class="card-text"><strong>Word Count:</strong> ${result.WordCount.toFixed(2)}</p>
                    <p class="card-text"><strong>Title Length:</strong> ${result.TitleLength.toFixed(2)}</p>
                    <hr>

                    <div class="accordion" id="accordionUniqueData${index}"> <!-- Add 'index' to make unique IDs -->
                        <div class="card col-md-12">
                            <div class="card-header" id="headingUniqueImages">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseUniqueImages${index}" aria-expanded="true" aria-controls="collapseUniqueImages${index}">
                                        Unique Images <i class="fas fa-chevron-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseUniqueImages${index}" class="collapse" aria-labelledby="headingUniqueImages" data-parent="#accordionUniqueData${index}">
                                <div class="card-body">
                                    <ul>
                                        ${result.uniqueImages.map(image => `<li>${image}</li>`).join('')}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card col-md-12">
                            <div class="card-header" id="headingUniqueInternalLinks">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseUniqueInternalLinks${index}" aria-expanded="true" aria-controls="collapseUniqueInternalLinks${index}">
                                        Unique Internal Links <i class="fas fa-chevron-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseUniqueInternalLinks${index}" class="collapse" aria-labelledby="headingUniqueInternalLinks" data-parent="#accordionUniqueData${index}">
                                <div class="card-body">
                                    <ul>
                                        ${result.uniqueInternalLinks.map(link => `<li>${link}</li>`).join('')}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card col-md-12">
                            <div class="card-header" id="headingUniqueExternalLinks">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseUniqueExternalLinks${index}" aria-expanded="true" aria-controls="collapseUniqueExternalLinks${index}">
                                        Unique External Links <i class="fas fa-chevron-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseUniqueExternalLinks${index}" class="collapse" aria-labelledby="headingUniqueExternalLinks" data-parent="#accordionUniqueData${index}">
                                <div class="card-body">
                                    <ul>
                                        ${result.uniqueExternalLinks.map(link => `<li>${link}</li>`).join('')}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    `;
        newResultCards += newResultCard;
    });

    document.getElementById('newResultCard').innerHTML = newResultCards;
    document.getElementById('GeneralResult').innerHTML = GeneralResult;
}

// Function to handle the form submission and initiate the crawl
function handleSubmit(event) {
    event.preventDefault();

    // Get all input field values as an array
    let urls = $('input[name="url[]"]').map(function() {
        return $(this).val().trim();
    }).get();

    // Remove empty values from the array
    urls = urls.filter(url => url !== '');

    console.log(urls);
    if (urls.length === 0) {
        alert('Please enter at least one website link.');
        return;
    }

    // AJAX request to the server to initiate the crawl
    $.ajax({
        type: 'POST',
        url: '/crawl',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            urls: urls ,
        },
        dataType: 'json',
        beforeSend: function () {
            $('#GeneralResult').empty();
            $('#newResultCard').empty();
            $('#status-container').empty();
            $('#GeneralResult').html('<center><img src="https://media.tenor.com/wpSo-8CrXqUAAAAi/loading-loading-forever.gif" style="width: 30px; hight: 30px;" alt="Loading..." class="loading-image"></div>');
        },
        success: function (response) {
            $('#GeneralResult').empty();
            $('#newResultCard').empty();
            $('#status-container').empty();
            // Display the new results in separate cards
            displayNewResults(response);
        },
        error: function (error) {
            $('#GeneralResult').empty();
            $('#newResultCard').empty();
            $('#status-container').empty();
            alert('Failed to crawl the website. Please try again.');
        }
    });
}


function AgencyanalyticsSubmit(urls) {
    // Remove empty values from the array
    urls = urls.filter(url => url !== '');
    console.log(urls);
    if (urls.length === 0) {
        alert('Please enter at least one website link.');
        return;
    }

    // Make an AJAX request to the server to initiate the crawl
    $.ajax({
        type: 'POST',
        url: '/crawl',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            urls: urls ,
        },
        dataType: 'json',
        beforeSend: function () {
            $('#GeneralResult').empty();
            $('#newResultCard').empty();
            $('#status-container').empty();
            $('#GeneralResult').html('<center><img src="https://media.tenor.com/wpSo-8CrXqUAAAAi/loading-loading-forever.gif" style="width: 30px; hight: 30px;" alt="Loading..." class="loading-image"></div>');
        },
        success: function (response) {
            $('#GeneralResult').empty();
            $('#newResultCard').empty();
            $('#status-container').empty();
            // Display the new results in separate cards
            displayNewResults(response);
        },
        error: function (error) {
            $('#GeneralResult').empty();
            $('#newResultCard').empty();
            $('#status-container').empty();
            alert('Failed to crawl the website. Please try again.');
        }
    });
}


// Attach event listener to the form submit button
$('#crawlForm').submit(handleSubmit);


function triggerFormSubmit() {
    $('#crawlForm').submit();
}

$(document).ready(function () {
    triggerFormSubmit();
});


$(document).ready(function() {
    // Capture the keypress event on the input field
    $('#crawlLinks').on('keypress', function(event) {
        // Check if the pressed key is the enter key (key code 13)
        if (event.which === 13) {
            event.preventDefault(); // Prevent form submission on pressing enter

            // Get the value from the input field
            let newUrl = $(this).val().trim();

            // Check if the URL is not empty
            if (newUrl !== '') {
                // Add the new URL to the list of URLs
                let urlsList = $('#urlsList');
                urlsList.append(`<li>${newUrl}</li>`);

                // Clear the input field
                $(this).val('');
            }
        }
    });
});