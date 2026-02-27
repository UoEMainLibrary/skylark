<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    /**
     * Display the About page
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Display the Feedback page
     */
    public function feedback()
    {
        return view('pages.feedback');
    }

    /**
     * Display the Mahabharata Scroll page
     */
    public function mahabharata()
    {
        return view('pages.mahabharata');
    }

    /**
     * Display the Collections as Data page
     */
    public function collectionsAsData()
    {
        return view('pages.collections-as-data');
    }

    /**
     * Display the Argyle Meeting Room page
     */
    public function argyleMeeting()
    {
        return view('pages.argyle-meeting');
    }

    /**
     * Display the Court of Session Papers page
     */
    public function csp()
    {
        return view('pages.csp');
    }

    /**
     * Display the Directory of Collections page
     */
    public function directory()
    {
        return view('pages.directory');
    }

    /**
     * Display the Licensing page
     */
    public function licensing()
    {
        return view('pages.licensing');
    }

    /**
     * Display the Participate page
     */
    public function participate()
    {
        return view('pages.participate');
    }

    /**
     * Display the Takedown Policy page
     */
    public function takedown()
    {
        return view('pages.takedown');
    }

    /**
     * Display the Accessibility Statement page
     */
    public function accessibility()
    {
        return view('pages.accessibility');
    }

    /**
     * Display the Blog page with RSS feed
     */
    public function blog()
    {
        $posts = $this->fetchRssFeed('http://libraryblogs.is.ed.ac.uk/feed/', 10);

        return view('pages.blog', compact('posts'));
    }

    /**
     * Fetch and parse RSS feed
     */
    protected function fetchRssFeed(string $feedUrl, int $limit = 10): array
    {
        try {
            $response = Http::timeout(10)->get($feedUrl);

            if (! $response->successful()) {
                return [];
            }

            $rss = new \DOMDocument;
            $rss->loadXML($response->body());

            $feed = [];
            foreach ($rss->getElementsByTagName('item') as $node) {
                if (count($feed) >= $limit) {
                    break;
                }

                $title = $node->getElementsByTagName('title')->item(0)?->nodeValue ?? '';
                $desc = $node->getElementsByTagName('description')->item(0)?->nodeValue ?? '';
                $link = $node->getElementsByTagName('link')->item(0)?->nodeValue ?? '';
                $date = $node->getElementsByTagName('pubDate')->item(0)?->nodeValue ?? '';

                $feed[] = [
                    'title' => str_replace(' & ', ' &amp; ', $title),
                    'description' => $this->truncateWords($desc, 100),
                    'link' => $link,
                    'date' => date('l F d, Y', strtotime($date)),
                ];
            }

            return $feed;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Truncate text to a maximum number of characters
     */
    protected function truncateWords(string $text, int $maxChar, string $end = '...'): string
    {
        if (strlen($text) <= $maxChar || $text === '') {
            return $text;
        }

        $words = preg_split('/\s/', $text);
        $output = '';
        $i = 0;

        while (isset($words[$i])) {
            $length = strlen($output) + strlen($words[$i]);
            if ($length > $maxChar) {
                break;
            }
            $output .= ' '.$words[$i];
            $i++;
        }

        return trim($output).$end;
    }
}
