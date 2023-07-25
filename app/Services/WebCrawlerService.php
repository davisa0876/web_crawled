<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\Stopwatch\Stopwatch;
use Illuminate\Support\Facades\Log; 

class WebCrawlerService
{
    private $client;
    private $stopwatch;

    public function __construct()
    {
        $this->client = new Client();
        $this->stopwatch = new Stopwatch();
    }

    public function crawlWebsite(array $urls, $crawlLimit)
    {
        $results = [];
        $totalLoadTimeForAllUrls = 0;
        $totalWordCounForAllUrls = 0;
        $totalTitleLengthAllUrls = 0;
        $crawlCount = 0; // Initialize a counter variable

        foreach ($urls as $url) {
            if ($crawlCount >= $crawlLimit) {
                break; // Stop the loop if the number of processed URLs reached the limit
            }            
            $result = $this->crawlSingleWebsite($url, 1);
            $results[] = $result;
            $totalLoadTimeForAllUrls += $result['LoadTime'];
            $totalWordCounForAllUrls += $result['WordCount'];
            $totalTitleLengthAllUrls += $result['TitleLength'];
            $response = $this->fetchHtmlContent($url);
            $statusCode = $response['statusCode'];  // Get the status code
            $StatusURL[]=['url'=>$url , 'statusCode' => $statusCode];
            $crawlCount++; // Increase the counter after each processed URL
        }

        // Calculate the general average load time for all URLs crawled
        $generalAverageLoadTime  = count($urls) > 0 ? ($totalLoadTimeForAllUrls / count($urls)) : 0;
        $generalAverageWordCount = count($urls) > 0 ? ($totalWordCounForAllUrls / count($urls)) : 0;
        $generalTitleLength      = count($urls) > 0 ? ($totalTitleLengthAllUrls / count($urls)) : 0;

        $array = [
            'urls' => $urls,
            'totalURLs' => count($urls),
            'StatusURL' => $StatusURL,
            'generalAverageLoadTime' => $generalAverageLoadTime ,
            'generalAverageWordCount' => $generalAverageWordCount ,
            'generalTitleLength' => $generalTitleLength ,
            'data' => $results,
        ];

        // Return the results array containing separate results for each URL
        return $array;
    }

    private function crawlSingleWebsite($url, $crawlLimit)
    {
        $uniqueImages = [];
        $uniqueInternalLinks = [];
        $uniqueExternalLinks = [];
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            // Add "https://" to the URL
            $url = "https://" . $url;
        }
 
        $response = $this->fetchHtmlContent($url);
        $html = $response['html'];
    
        // Stop the stopwatch and get the event duration
        $event = $this->stopwatch->stop('page_load_time');
        $pageLoadTime = $event->getDuration(); 
        
        $uniqueImages   = array_merge($uniqueImages, $this->extractImages($html));
        $extractedLinks = $this->extractLinks($html);
        
        $uniqueInternalLinks = array_merge($uniqueInternalLinks, $extractedLinks['internal']);
        $uniqueExternalLinks = array_merge($uniqueExternalLinks, $extractedLinks['external']);
        
        $content    = strip_tags($html);
        $wordCount   = str_word_count($content);
        $titleLength = strlen($this->extractTitle($html));
        
        
        $this->stopwatch->reset();
        return [
            'url' => $url,
            'uniqueImages' => $uniqueImages,
            'uniqueInternalLinks' => $uniqueInternalLinks,
            'uniqueExternalLinks' => $uniqueExternalLinks,
            'LoadTime' => $pageLoadTime ,
            'WordCount' => $wordCount,
            'TitleLength' => $titleLength,
        ];
    }

    private function fetchHtmlContent($url)
    {
        try {
            // Start the stopwatch before making the HTTP request
            $this->stopwatch->start('page_load_time');
    
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
            $html = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
            curl_close($ch);
    
            return [
                'html' => $html,
                'statusCode' => $statusCode,
            ];
    
        } catch (\Exception $e) {
            Log::error('Error fetching HTML content for URL ' . $url . ': ' . $e->getMessage());
            return [
                'html' => '',
                'statusCode' => null, // No HTTP status code available
            ];
        }
    }


    private function extractImages($html)
    {
        // Here I am using regular expressions to find images
        preg_match_all('/<img[^>]+src="([^"]+)"[^>]*>/i', $html, $matches);
        return $matches[1];
    }

    private function extractLinks($html)
    {
        // Here I am using regular expressions to find links
        preg_match_all('/<a[^>]+href="([^"]+)"[^>]*>/i', $html, $matches);
        $internal = [];
        $external = [];
        foreach ($matches[1] as $link) {
            if (strpos($link, '#') === 0) {
                continue; // Skip anchor links 
            }

            if (strpos($link, 'http') === 0) {
                $external[] = $link;
            } else {
                $internal[] = $link;
            }
        }

        return ['internal' => $internal, 'external' => $external];
    }

    private function extractTitle($html)
    {
        preg_match('/<title>(.*?)<\/title>/i', $html, $titleMatches);
        return $titleMatches[1] ?? '';
    }


    

}
