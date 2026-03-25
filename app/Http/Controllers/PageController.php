<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\RepositoryFactory;
use Illuminate\Support\Facades\Http;

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
        if (config('skylight.resp_skin_version') === 2) {
            return preg_replace('/^eerc\./', 'eerc-v2.', $view);
        }

        return $view;
    }

    /**
     * Display the About page
     */
    public function about()
    {
        $collection = config('app.current_collection', 'clds');

        if ($collection === 'eerc') {
            return $this->eercDynamicPage('eerc-about', 'eerc.pages.about');
        }

        if ($collection === 'mimed') {
            return view('mimed.pages.about');
        }

        if ($collection === 'art') {
            return view('art.pages.about');
        }

        return view('pages.about');
    }

    /**
     * Display the Feedback page
     */
    public function feedback()
    {
        $collection = config('app.current_collection', 'clds');

        if ($collection === 'mimed') {
            return view('mimed.pages.feedback');
        }

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
        $collection = config('app.current_collection', 'clds');

        if ($collection === 'mimed') {
            return view('mimed.pages.licensing');
        }

        if ($collection === 'art') {
            return view('art.pages.licensing');
        }

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
        $collection = config('app.current_collection', 'clds');

        if ($collection === 'mimed') {
            return view('mimed.pages.takedown');
        }

        if ($collection === 'art') {
            return view('art.pages.takedown');
        }

        return view('pages.takedown');
    }

    /**
     * Display the MIMEd homepage with browse facets
     */
    public function mimedHome()
    {
        $repository = $this->repositoryFactory->current();

        $facets = [];
        $baseSearch = url('/mimed/search/*:*');
        $configFilters = config('skylight.filters', []);

        try {
            $results = $repository->searchWithHighlighting('*:*', [], 0, '', 0);
            $facets = $results['facets'] ?? [];
        } catch (\Exception $e) {
            // Solr unreachable — render without facets
        }

        return view('mimed.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
    }

    /**
     * Display the MIMEd IIIF page
     */
    public function mimedIiif()
    {
        return view('mimed.pages.iiif');
    }

    /**
     * Display the Art Collection homepage
     */
    public function artHome()
    {
        return view('art.home');
    }

    /**
     * Display the Art IIIF page
     */
    public function artIiif()
    {
        return view('art.pages.iiif');
    }

    /**
     * Display the Art Focus page
     */
    public function artFocus()
    {
        return view('art.pages.focus');
    }

    /**
     * Display the Art Commissioning page
     */
    public function artComissioning()
    {
        return view('art.pages.comissioning');
    }

    /**
     * Display the Art Loans page
     */
    public function artLoans()
    {
        return view('art.pages.loans');
    }

    /**
     * Display the Accessibility Statement page
     */
    public function accessibility()
    {
        $collection = config('app.current_collection', 'clds');

        if ($collection === 'eerc') {
            return $this->eercDynamicPage('eerc-accessibility', 'eerc.pages.accessibility');
        }

        if ($collection === 'mimed') {
            return view('mimed.pages.accessibility');
        }

        if ($collection === 'art') {
            return view('art.pages.accessibility');
        }

        return view('pages.accessibility');
    }

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
        return $this->eercDynamicPage('eerc-resp', 'eerc.pages.resp');
    }

    /**
     * Display the EERC Searching and Using page
     */
    public function using()
    {
        return $this->eercDynamicPage('eerc-using', 'eerc.pages.using');
    }

    /**
     * Display the EERC Exhibition Gallery page
     */
    public function exhibitionGallery()
    {
        return $this->eercDynamicPage('eerc-exhibition-gallery', 'eerc.pages.exhibition_gallery');
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
        return $this->eercDynamicPage('eerc-contact', 'eerc.pages.contact');
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
        return $this->eercDynamicPage('eerc-project-history', 'eerc.pages.project_history');
    }

    /**
     * Display the EERC Creative Engagement and Research page
     */
    public function creativeEngagement()
    {
        return $this->eercDynamicPage('eerc-creative-engagement', 'eerc.pages.creative_engagement');
    }

    /**
     * Display the EERC BSL landing page
     */
    public function bsl()
    {
        return $this->eercDynamicPage('eerc-bsl', 'eerc.pages.bsl');
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
     * Render an EERC page from the database, falling back to static Blade.
     */
    protected function eercDynamicPage(string $slug, string $fallbackView): mixed
    {
        if (config('skylight.resp_skin_version') === 2) {
            $page = Page::where('slug', $slug)->first();

            if ($page) {
                return $this->eercPageWithSidebar('eerc.pages.dynamic', ['page' => $page]);
            }
        }

        return $this->eercPageWithSidebar($fallbackView);
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
