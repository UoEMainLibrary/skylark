<?php

namespace App\Http\Controllers;

use App\Services\RepositoryFactory;
use App\Support\CollectionViewResolver;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        protected RepositoryFactory $repositoryFactory
    ) {}

    /**
     * Resolve an EERC view name based on the active skin version.
     * e.g. 'eerc.home' becomes 'eerc-v2.home' when skin version is 2.
     */
    public static function eercViewName(string $view): string
    {
        return CollectionViewResolver::eerc($view);
    }

    /**
     * Resolve a Public Art view name based on the active skin version.
     * e.g. 'public-art.home' becomes 'public-art-v2.home' when skin version is 2.
     */
    public static function publicArtViewName(string $view): string
    {
        return CollectionViewResolver::publicArt($view);
    }

    /**
     * Display the About page
     */
    public function about()
    {
        $collection = config('app.current_collection', 'clds');
        $collectionView = "{$collection}.pages.about";

        if ($collection === 'public-art') {
            $collectionView = static::publicArtViewName($collectionView);
        }

        return view()->exists($collectionView)
            ? view($collectionView)
            : view('pages.about');
    }
    /*
    public function about()
    {
        $collection = config('app.current_collection', 'clds');

        if ($collection === 'eerc') {
            return $this->eercPageWithSidebar('eerc.pages.about');
        }

        if ($collection === 'mimed') {
            return view('mimed.pages.about');
        }

        if ($collection === 'openbooks') {
            return view('openbooks.pages.about');
        }

        if ($collection === 'art') {
            return view('art.pages.about');
        }

        if ($collection === 'guardbook') {
            return view('guardbook.pages.about');
        }

        if ($collection === 'coimbra-colls') {
            return view('coimbra-colls.pages.about');
        }

        if ($collection === 'coimbra') {
            return view('coimbra.pages.about');
        }

        if ($collection === 'lhsacasenotes') {
            return view('lhsacasenotes.pages.about');
        }

        return view('pages.about');
    }
    */

    /**
     * Display the Feedback page
     */
    public function feedback()
    {
        $collection = config('app.current_collection', 'clds');
        $collectionView = "{$collection}.pages.feedback";

        if ($collection === 'public-art') {
            $collectionView = static::publicArtViewName($collectionView);
        }

        return view()->exists($collectionView)
            ? view($collectionView)
            : view('pages.feedback');
    }

    /**
     * Display the Feedback page
     */
    /*
    public function feedback()
    {
       $collection = config('app.current_collection', 'clds');

       if ($collection === 'mimed') {
           return view('mimed.pages.feedback');
       }

       if ($collection === 'openbooks') {
           return view('openbooks.pages.feedback');
       }

       if ($collection === 'guardbook') {
           return view('guardbook.pages.feedback');
       }

       if ($collection === 'coimbra-colls') {
           return view('coimbra-colls.pages.feedback');
       }

       if ($collection === 'coimbra') {
           return view('coimbra.pages.feedback');
       }

       return view('pages.feedback');
    }
    */

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
        $collection = config('app.current_collection', 'clds');
        $collectionView = "{$collection}.pages.licensing";

        if ($collection === 'public-art') {
            $collectionView = static::publicArtViewName($collectionView);
        }

        return view()->exists($collectionView)
            ? view($collectionView)
            : view('pages.licensing');
    }

    /*
    public function licensing()
    {
        $collection = config('app.current_collection', 'clds');

        if ($collection === 'mimed') {
            return view('mimed.pages.licensing');
        }

        if ($collection === 'openbooks') {
            return view('openbooks.pages.licensing');
        }

        if ($collection === 'art') {
            return view('art.pages.licensing');
        }

        if ($collection === 'guardbook') {
            return view('guardbook.pages.licensing');
        }

        if ($collection === 'coimbra') {
            return view('coimbra.pages.licensing');
        }

        if ($collection === 'lhsacasenotes') {
            return view('coimbra.pages.licensing');
        }
        return view('pages.licensing');
    }
    */

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

    /**
     * Display the Takedown page
     */
    public function takedown()
    {
        $collection = config('app.current_collection', 'clds');
        $collectionView = "{$collection}.pages.takedown";

        if ($collection === 'public-art') {
            $collectionView = static::publicArtViewName($collectionView);
        }

        return view()->exists($collectionView)
            ? view($collectionView)
            : view('pages.takedown');
    }
    /*
    public function takedown()
    {
        $collection = config('app.current_collection', 'clds');

        if ($collection === 'mimed') {
            return view('mimed.pages.takedown');
        }

        if ($collection === 'openbooks') {
            return view('openbooks.pages.takedown');
        }

        if ($collection === 'art') {
            return view('art.pages.takedown');
        }

        if ($collection === 'guardbook') {
            return view('guardbook.pages.takedown');
        }

        if ($collection === 'coimbra') {
            return view('coimbra.pages.takedown');
        }

        if ($collection === 'lhsacasenotes') {
            return view('lhsacasenotes.pages.takedown');
        }


        return view('pages.takedown');
    }
        */

    /**
     * Display the Accessibility Statement page
     */
    public function accessibility()
    {
        $collection = config('app.current_collection', 'clds');
        $collectionView = "{$collection}.pages.accessibility";

        if ($collection === 'public-art') {
            $collectionView = static::publicArtViewName($collectionView);
        }

        return view()->exists($collectionView)
            ? view($collectionView)
            : view('pages.accessibility');
    }
    /*
    public function accessibility()
    {
        $collection = config('app.current_collection', 'clds');

        if ($collection === 'eerc') {
            return $this->eercPageWithSidebar('eerc.pages.accessibility');
        }

        if ($collection === 'mimed') {
            return view('mimed.pages.accessibility');
        }

        if ($collection === 'openbooks') {
            return view('openbooks.pages.accessibility');
        }

        if ($collection === 'art') {
            return view('art.pages.accessibility');
        }

        if ($collection === 'coimbra-colls') {
            return view('coimbra-colls.pages.accessibility');
        }

        if ($collection === 'coimbra') {
            return view('coimbra.pages.accessibility');
        }

        if ($collection === 'guardbook') {
            return view('guardbook.pages.accessibility');
        }

        if ($collection === 'lhsacasenotes') {
            return view('guardbook.pages.accessibility');
        }

        return view('pages.accessibility');
    }
        */

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
