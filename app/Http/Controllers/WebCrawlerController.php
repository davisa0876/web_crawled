<?php
namespace App\Http\Controllers;
use App\Services\WebCrawlerService;
use App\Http\Requests\CrawlRequest;

class WebCrawlerController extends Controller
{
    public function crawl(CrawlRequest $request, WebCrawlerService $crawlerService)
    {
        $urls = array_filter($request->input('urls', [])); // Remove empty values from the array
        $crawlResults = [];
        $crawlResults = $crawlerService->crawlWebsite($urls, 6); // Change the crawl limit as needed
         // Return the crawl results as JSON
        return response()->json($crawlResults);
    }
}
