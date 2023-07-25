<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebCrawlerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('welcome'); });

Route::get('/web-crawler', function () {  return view('crawlers.web_crawler'); });
Route::get('/web-crawler/agencyanalytics', function () {  return view('crawlers.agencyanalytics_crawler'); });



// Route to handle AJAX request for crawling
Route::post('/crawl', [WebCrawlerController::class, 'crawl']);
