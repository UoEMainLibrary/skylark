<?php

namespace App\Http\Controllers;

use App\Services\DSpaceService;
use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;
use Illuminate\Http\Request;
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
        $collectionView = "{$collection}.pages.about";

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
     * Display the Cockburn homepage with browse facets
     */
    public function cockburnHome()
    {
        $repository = $this->repositoryFactory->current();

        $facets = [];
        $baseSearch = CollectionUrl::url('search/*:*');
        $configFilters = config('skylight.filters', []);

        try {
            //$results = $repository->search('*:*', [], 0, '', 0);
            $results = $repository->searchWithHighlighting('*:*', [], 0, '', 0);
            //$results = $repository->searchWithFacets('*:*');
            $facets = $results['facets'] ?? [];
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        try {
            $recentResults = $repository->searchWithHighlighting('*:*', [], 0, 'system_create_dt desc', 5);
            $docs = $recentResults['docs'] ?? [];
            //dd($docs);
        } catch (\Exception $e) {
            // Solr unreachable — render without recent docs
        }
    


        //dd($results);

        return view('cockburn.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
            'docs' => $docs,
            'query' => '',
        ]);
    }

    /**
     * Display the MIMEd homepage with browse facets
     */
    public function mimedHome()
    {
        $repository = $this->repositoryFactory->current();

        $facets = [];
        $baseSearch = CollectionUrl::url('search/*:*');
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
     * Display the Open Books homepage with browse facets
     */
    public function openbooksHome()
    {
        $repository = $this->repositoryFactory->current();

        $facets = [];
        $baseSearch = CollectionUrl::url('search/*:*');
        $configFilters = config('skylight.filters', []);

        try {
            $results = $repository->searchWithHighlighting('*:*', [], 0, '', 0, []);
            $facets = $results['facets'] ?? [];
        } catch (\Exception $e) {
            report($e);
        }

        return view('openbooks.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
    }

    /**
     * Display the Open Books IIIF page
     */
    public function openbooksIiif()
    {
        return view('openbooks.pages.iiif');
    }

    /**
     * Browse all values for a facet (Skylight /browse/{facet}).
     */
    public function openbooksBrowse(Request $request, string $facet): View
    {
        $facet = urldecode($facet);
        $allowed = array_merge(
            array_keys(config('skylight.filters', [])),
            array_keys(config('skylight.date_filters', []))
        );
        if (! in_array($facet, $allowed, true)) {
            abort(404);
        }

        $repository = $this->repositoryFactory->current();
        if (! $repository instanceof DSpaceService) {
            abort(404);
        }

        $rows = 30;
        $offset = max(0, (int) $request->query('offset', 0));
        $prefix = (string) $request->query('prefix', '');

        $browseData = $repository->browseTerms($facet, $rows, $offset, $prefix);
        $collectionTotal = (int) ($browseData['rows'] ?? 0);
        $facetBlock = $browseData['facet'] ?? ['name' => $facet, 'terms' => [], 'termcount' => 0];
        $termsOnPage = $facetBlock['terms'] ?? [];

        $totalFacetValues = $repository->countBrowseTerms($facet, $prefix);
        $browseUrl = $prefix !== ''
            ? CollectionUrl::url('browse/'.$facet).'?prefix='.urlencode($prefix)
            : CollectionUrl::url('browse/'.$facet);

        $prevOffset = max(0, $offset - $rows);
        $nextOffset = $offset + $rows;
        $hasPrev = $offset > 0;
        $hasNext = $nextOffset < $totalFacetValues;
        $queryJoin = str_contains($browseUrl, '?') ? '&' : '?';

        return view('openbooks.browse', [
            'browseFacet' => $facet,
            'facet' => $facetBlock,
            'collectionTotal' => $collectionTotal,
            'browseUrl' => $browseUrl,
            'offset' => $offset,
            'rows' => $rows,
            'prefix' => $prefix,
            'totalFacetValues' => $totalFacetValues,
            'startRow' => $totalFacetValues > 0 ? $offset + 1 : 0,
            'endRow' => min($offset + count($termsOnPage), $totalFacetValues),
            'hasPrev' => $hasPrev,
            'hasNext' => $hasNext,
            'prevUrl' => $hasPrev ? $browseUrl.$queryJoin.'offset='.$prevOffset : '',
            'nextUrl' => $hasNext ? $browseUrl.$queryJoin.'offset='.$nextOffset : '',
            'base_search' => CollectionUrl::url('search/*'),
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
    }

    /**
     * Display the Coimbra Colls Collection homepage
     */
    public function coimbraCollsHome()
    {
        return view('coimbra-colls.home');
    }


    /**
    * Display the Alumni homepage
    */
    public function alumniHome()
    {
        /*
        dd([
            'container_id' => config('skylight.container_id'),
            'container_field' => config('skylight.container_field'),
        ]);
        */


        $repository = $this->repositoryFactory->current();
        $facets = [];
        $baseSearch = CollectionUrl::url('search/*:*');
        $configFilters = config('skylight.filters', []);

        try {
            $results = $repository->searchWithHighlighting('*:*', [], 0, '', 0);
            //dd($repository);
            //dd($results);
            $facets = $results['facets'] ?? [];
        } catch (\Exception $e) {
            dd($e->getMessage(), $e);
        }

        return view('alumni.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
    }

    /**
    * Display the Coimbra Collection homepage
    */
    public function coimbraHome()
    {
        return view('coimbra.home');
    }

    /**
    * Display the Coimbra Collection intro page
    */
    public function coimbraIntro()
    {
        return view('coimbra.pages.intro');
    }

    /**
     * Display the Coimbra Colls Virtual Exhibition page
     */
    public function coimbraCollsVirtualExhibition()
    {
        return view('coimbra-colls.pages.virtual-exhibition');
    }


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
            //dd($results);
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
    * Display the LHSA Case Notes homepage
    */
    public function lhsacasenotesHome()
    {

        $repository = $this->repositoryFactory->current();
        $facets = [];
        $baseSearch = CollectionUrl::url('search/*:*');
        $configFilters = config('skylight.filters', []);

        try {
            $results = $repository->searchWithHighlighting('*:*', [], 0, '', 0);
            //dd($results);
            $facets = $results['facets'] ?? [];
        } catch (\Exception $e) {
            dd($e->getMessage(), $e);
        }

        return view('lhsacasenotes.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
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

    /** - ALUMNI Static Pages
     * Display the Art Loans page
     */
    public function alumniExtraAc()
    {
        return view('alumni.pages.extraac');
    }
    public function alumniEarlyVet()
    {
        return view('alumni.pages.earlyvet');
    }
    public function alumniFemaleGrad()
    {
        return view('alumni.pages.femalegrad');
    }
    public function alumniFirstMat()
    {
        return view('alumni.pages.firstmat');
    }
    public function alumniMedSample()
    {
        return view('alumni.pages.medsample');
    }
    public function alumniNewColl()
    {
        return view('alumni.pages.newcoll');
    }
    public function alumniRoll()
    {
        return view('alumni.pages.roll');
    }
    public function alumniRosner()
    {
        return view('alumni.pages.rosner');
    }
    public function alumniVetGrad()
    {
        return view('alumni.pages.vetgrad');
    }
    public function alumniWomen()
    {
        return view('alumni.pages.women');
    }
    public function alumniWW1Roll()
    {
        return view('alumni.pages.ww1roll');
    }

    /**
     * Display the Accessibility Statement page
     */
    public function accessibility()
    {
        $collection = config('app.current_collection', 'clds');
        $collectionView = "{$collection}.pages.accessibility";

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
