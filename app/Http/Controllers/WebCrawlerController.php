<?php
namespace App\Http\Controllers;
use App\Services\WebCrawlerService;
use App\Http\Requests\CrawlRequest;

class WebCrawlerController extends Controller
{
    protected $crawlerService;

    public function __construct(WebCrawlerService $crawlerService)
    {
        $this->crawlerService = $crawlerService;

    }

    public function crawl(CrawlRequest $request)
    {
        $urls = array_filter($request->input('urls', [])); // Remove empty values from the array
        $crawlResults = [];
        $crawlResults =  $this->crawlerService->crawlWebsite($urls, 6); // Change the crawl limit as needed
         // Return the crawl results as JSON
        return response()->json($crawlResults);
    }
}
