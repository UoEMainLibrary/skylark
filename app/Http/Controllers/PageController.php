<?php

namespace App\Http\Controllers;

use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;
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
     * Display the Guardbook homepage
     */
    public function guardbookHome()
    {

        $repository = $this->repositoryFactory->current();
        $facets = [];
        $baseSearch = CollectionUrl::url('search/*:*');
        $configFilters = config('skylight.filters', []);

        try {
            $results = $repository->searchWithHighlighting('*:*', [], 0, '', 0);
            // dd($results);
            $facets = $results['facets'] ?? [];
        } catch (\Exception $e) {
            dd($e->getMessage(), $e);
        }

        return view('guardbook.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
    }

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
     * Display the EERC Overview/Browse Collections page
     */
    public function overview()
    {
        $repository = $this->repositoryFactory->current();

        // Fetch the collection tree from ArchivesSpace
        $tree = method_exists($repository, 'getCollectionTree')
            ? $repository->getCollectionTree()
            : ['children' => []];

        // The old site only displays the first 5 top-level branches
        if (! empty($tree['children'])) {
            $tree['children'] = array_slice($tree['children'], 0, 5);
        }

        // Fetch subject and person facets for sidebar
        $subjectFacet = ['terms' => []];
        $personFacet = ['terms' => []];

        if (method_exists($repository, 'browseTerms')) {
            $subjectFacet = $repository->browseTerms('Subject', 10);
            $personFacet = $repository->browseTerms('Person', 10);
        }

        return view(static::eercViewName('eerc.pages.overview'), [
            'tree' => $tree,
            'subjectFacet' => $subjectFacet,
            'personFacet' => $personFacet,
        ]);
    }

    /**
     * Display the EERC People page
     */
    public function people()
    {
        return $this->eercPageWithSidebar('eerc.pages.people');
    }

    /**
     * Display the EERC RESP Archive Project page
     */
    public function resp()
    {
        return $this->eercPageWithSidebar('eerc.pages.resp');
    }

    /**
     * Display the EERC Searching and Using page
     */
    public function using()
    {
        return $this->eercPageWithSidebar('eerc.pages.using');
    }

    /**
     * Display the EERC Exhibition Gallery page
     */
    public function exhibitionGallery()
    {
        return $this->eercPageWithSidebar('eerc.pages.exhibition_gallery');
    }

    /**
     * Display the EERC Kids Only page
     */
    public function kidsOnly()
    {
        return $this->eercPageWithSidebar('eerc.pages.kids_only');
    }

    /**
     * Display the EERC Contact page
     */
    public function contact()
    {
        return $this->eercPageWithSidebar('eerc.pages.contact');
    }

    /**
     * Display the EERC Map page
     */
    public function map()
    {
        return $this->eercPageWithSidebar('eerc.pages.map');
    }

    /**
     * Display the EERC Project History page (v2 replacement for People)
     */
    public function projectHistory()
    {
        return $this->eercPageWithSidebar('eerc.pages.project_history');
    }

    /**
     * Display the EERC Creative Engagement and Research page
     */
    public function creativeEngagement()
    {
        return $this->eercPageWithSidebar('eerc.pages.creative_engagement');
    }

    /**
     * Display the EERC BSL landing page
     */
    public function bsl()
    {
        return $this->eercPageWithSidebar('eerc.pages.bsl');
    }

    /**
     * Browse all Subject or Person facet terms (sidebar “View all” target).
     */
    public function eercBrowse(string $facet)
    {
        $filters = config('skylight.filters', []);

        if (! isset($filters[$facet])) {
            abort(404);
        }

        $repository = $this->repositoryFactory->current();

        if (! method_exists($repository, 'browseTerms')) {
            abort(404);
        }

        $browseData = $repository->browseTerms($facet, 500);

        return $this->eercPageWithSidebar('eerc.pages.browse', [
            'browseFacet' => $facet,
            'browseData' => $browseData,
        ]);
    }

    /**
     * Helper method to render EERC pages with sidebar facets.
     * Automatically resolves the view based on active skin version.
     */
    protected function eercPageWithSidebar(string $view, array $extraData = [])
    {
        $repository = $this->repositoryFactory->current();

        $subjectFacet = ['terms' => []];
        $personFacet = ['terms' => []];

        if (method_exists($repository, 'browseTerms')) {
            $subjectFacet = $repository->browseTerms('Subject', 10);
            $personFacet = $repository->browseTerms('Person', 10);
        }

        return view(static::eercViewName($view), array_merge([
            'subjectFacet' => $subjectFacet,
            'personFacet' => $personFacet,
        ], $extraData));
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
