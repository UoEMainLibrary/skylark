<?php

namespace App\Http\Controllers;

use App\Support\CollectionViewResolver;
use Illuminate\Support\Facades\Http;

/**
 * Root-domain pages and the small set of static pages that every collection
 * shares (about / feedback / licensing / takedown / accessibility). Those
 * shared actions auto-resolve to `{collection}.pages.<name>` when the
 * matching view exists, otherwise fall back to the generic `pages.<name>`
 * Blade. Per-collection logic lives under
 * `App\Http\Controllers\Collections\{Name}\PageController`.
 */
class PageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Shared static pages.
    |
    | Each one resolves to `{collection}.pages.<name>` when that view exists,
    | with `pages.<name>` as the cross-collection fallback. Public Art has
    | the additional skin-version dance for v1 vs v2 templates.
    |--------------------------------------------------------------------------
    */

    public function about()
    {
        return $this->resolveSharedPage('about');
    }

    public function feedback()
    {
        return $this->resolveSharedPage('feedback');
    }

    public function licensing()
    {
        return $this->resolveSharedPage('licensing');
    }

    public function takedown()
    {
        return $this->resolveSharedPage('takedown');
    }

    public function accessibility()
    {
        return $this->resolveSharedPage('accessibility');
    }

    /**
     * Resolve a shared static page name (e.g. "about") to a collection-aware
     * Blade view, falling back to the generic `pages.<name>` template.
     */
    protected function resolveSharedPage(string $name)
    {
        $collection = config('app.current_collection', 'clds');
        $collectionView = "{$collection}.pages.{$name}";

        if ($collection === 'public-art') {
            $collectionView = CollectionViewResolver::publicArt($collectionView);
        }

        return view()->exists($collectionView)
            ? view($collectionView)
            : view("pages.{$name}");
    }

    /*
    |--------------------------------------------------------------------------
    | Root-domain-only pages (collection-agnostic).
    |--------------------------------------------------------------------------
    */

    public function mahabharata()
    {
        return view('pages.mahabharata');
    }

    public function collectionsAsData()
    {
        return view('pages.collections-as-data');
    }

    public function argyleMeeting()
    {
        return view('pages.argyle-meeting');
    }

    public function csp()
    {
        return view('pages.csp');
    }

    public function directory()
    {
        return view('pages.directory');
    }

    public function participate()
    {
        return view('pages.participate');
    }

    /**
     * Display the Blog page, with the latest 10 posts pulled from the
     * Library Blogs RSS feed.
     */
    public function blog()
    {
        $posts = $this->fetchRssFeed('http://libraryblogs.is.ed.ac.uk/feed/', 10);

        return view('pages.blog', compact('posts'));
    }

    /**
     * Fetch and parse an RSS feed.
     *
     * @return array<int, array{title: string, description: string, link: string, date: string}>
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
     * Truncate text to a maximum number of characters, ending on a word
     * boundary and appending the supplied suffix.
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
