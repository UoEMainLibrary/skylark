# Skylark - Laravel Rebuild of Skylight

A modern Laravel 12 rebuild of the University of Edinburgh's Skylight digital collections discovery interface.

## Project Overview

**Original Application**: [Skylight](../skylight) - A CodeIgniter-based discovery interface for DSpace repositories

**Goal**: Rebuild Skylight in Laravel 12 with modern architecture and best practices

**Timeline**: 9 weeks

**Current Status**: ✅ Solr integration POC complete and tested

## What's Been Implemented

### Phase 1: Solr Integration Proof-of-Concept ✅

Successfully implemented and tested Solr integration with the live DSpace repository.

**Key Achievements:**
- ✅ Connects to production Solr instance at `collectionsinternal.is.ed.ac.uk`
- ✅ Retrieves data from **66,585+ documents** in the repository
- ✅ Implements search, faceting, and record retrieval
- ✅ Created reusable `SolrService` class
- ✅ Built demonstration Artisan command

**Implementation Approach:**
- Uses Laravel's HTTP Client for direct Solr communication
- Clean, maintainable service layer architecture
- Compatible with DSpace's non-standard Solr configuration

### Phase 2: Homepage Implementation ✅

Converted the original CodeIgniter homepage to modern Laravel Blade templates.

**Key Achievements:**
- ✅ Master Blade layout with template inheritance
- ✅ Reusable partials (navigation, search bar, footer)
- ✅ All 40+ collection boxes and links converted
- ✅ Complete asset migration (CSS, images, JavaScript)
- ✅ Responsive Bootstrap 3 layout preserved
- ✅ Collapsible sections functional

**Structure:**
- `resources/views/layouts/app.blade.php` - Master layout
- `resources/views/home.blade.php` - Homepage content
- `resources/views/partials/` - Reusable components
- `public/css/` - Theme stylesheets
- `public/images/` - All collection images and assets

## Getting Started

### Prerequisites

- PHP 8.3+
- Composer
- Laravel Herd (or similar local PHP server)
- Access to the University of Edinburgh network (for Solr access)

### Installation

1. **Clone and Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Configuration**
   
   The `.env` file is already configured with the Solr connection:
   ```env
   SOLR_BASE_URL=http://collectionsinternal.is.ed.ac.uk:8080/solr/search/
   SOLR_CONTAINER_ID=1
   SOLR_CONTAINER_FIELD=location.comm
   SOLR_RESULTS_PER_PAGE=10
   ```

3. **Generate Application Key** (if not already set)
   ```bash
   php artisan key:generate
   ```

### Viewing the Homepage

The homepage has been fully converted to Laravel Blade templates and is ready to view:

**Visit the site:**
- **Herd URL**: `http://skylark.test/`
- **Or run dev server**: `php artisan serve` then visit `http://127.0.0.1:8000/`

**What you'll see:**
- Complete University of Edinburgh Collections homepage
- 4 major online collection sections (Archives, Art, Musical Instruments, Iconics)
- 20+ digital image collection links
- Collapsible sections for "Visit Us" and "Participate"
- Fully functional navigation and search bar
- All original styling and images preserved

### Running the Solr POC

The proof-of-concept demonstrates three key Solr capabilities:

**Basic Test (all records):**
```bash
php artisan app:solr-poc
```

**Search with Specific Query:**
```bash
php artisan app:solr-poc --query="edinburgh"
php artisan app:solr-poc --query="music"
php artisan app:solr-poc --query="author:Smith"
```

**Expected Output:**
- 📊 Total results count (66,585+ documents)
- 📋 Table of search results with ID, Title, Author, Date
- 🏷️ Facet information
- 📄 Full record details with all metadata fields

### POC Output Example

```
╔══════════════════════════════════════════════════════════════╗
║           Solr Proof-of-Concept Demonstration               ║
╚══════════════════════════════════════════════════════════════╝

━━━ 1. Simple Search ━━━
Query: *:*

Total results found: 66585
Showing first 5 results:

+-----+--------------+-------------------------------------+----------+
| No. | ID           | Title                               | Date     |
+-----+--------------+-------------------------------------+----------+
| 1   | 10683/98434  | E to EARS                           | 2017-... |
| 2   | 10683/1383   | Levels of Reality Poster            | 2010-... |
...

✓ All demonstrations completed successfully!
```

## Project Structure

```
app/
├── Console/Commands/
│   └── SolrProofOfConcept.php    # POC demonstration command
├── Services/
│   └── SolrService.php            # Solr integration service
└── Providers/
    └── AppServiceProvider.php     # Service registrations

config/
├── services.php                   # Solr & Google Analytics config
└── theme.php                      # Theme configuration

resources/views/
├── layouts/
│   └── app.blade.php              # Master layout template
├── partials/
│   ├── nav.blade.php              # Navigation bar
│   ├── collection-search.blade.php # Search bar component
│   └── footer-content.blade.php   # Footer component
└── home.blade.php                 # Homepage view

public/
├── css/                           # Theme stylesheets
├── images/                        # Collection images & logos
│   └── clickboxes/                # Collection thumbnail images
└── js/                            # Custom JavaScript

routes/
└── web.php                        # Web routes (homepage, etc.)

SOLR_POC_README.md                # Detailed POC documentation
```

## Architecture

### SolrService

The `SolrService` class provides a clean interface to DSpace Solr:

```php
use App\Services\SolrService;

// Injected via Laravel's container
public function __construct(SolrService $solr) 
{
    $this->solr = $solr;
}

// Simple search
$results = $this->solr->search('edinburgh', [], ['rows' => 10]);

// Search with facets
$results = $this->solr->searchWithFacets('music');

// Get a single record
$record = $this->solr->getRecord('10683/98434');
```

**Available Methods:**
- `search($query, $filters, $options)` - Execute search queries
- `searchWithFacets($query, $filters, $facetFields)` - Search with faceting
- `getRecord($id, $includeHighlight)` - Retrieve single record
- `getFacets($query, $filters, $facetFields)` - Get facets without documents

## Documentation

- **[SOLR_POC_README.md](SOLR_POC_README.md)** - Detailed Solr POC documentation
  - Implementation details
  - Configuration guide
  - Troubleshooting
  - Next steps and future enhancements

## Technology Stack

- **Framework**: Laravel 12.x
- **PHP**: 8.3.30
- **Testing**: Pest 4
- **Code Style**: Laravel Pint
- **Local Server**: Laravel Herd
- **Search Engine**: Apache Solr (via DSpace)

## Original Skylight Application

The original application being rebuilt:
- **Location**: `/Users/chrisgibson/Herd/skylight`
- **Local Customizations**: `/Users/chrisgibson/Herd/skylight-local`
- **Framework**: CodeIgniter (forked version)
- **Current Status**: Production system serving multiple collections

## Next Steps

### Immediate Next Steps

1. **Search Functionality**
   - Create search controller connected to SolrService
   - Build search results view with faceting
   - Implement pagination
   - Add result sorting options

2. **Record Display**
   - Create record controller
   - Build record detail page template
   - Display metadata fields
   - Show digital objects/bitstreams
   - Implement related items

3. **Browse Features**
   - Browse by author/subject/type
   - Browse routes and views
   - Alphabetical navigation

### Phase 2: Core Features (In Progress)

- [x] Homepage with navigation ✅
- [ ] Search interface with results display
- [ ] Individual record pages
- [ ] Faceted navigation
- [ ] Browse by author/subject/type
- [ ] Pagination
- [ ] RSS feeds
- [ ] OAI-PMH endpoint

### Phase 3: Advanced Features

- [ ] Multiple collection support
- [ ] Theme system
- [ ] Static content pages
- [ ] Admin interface
- [ ] Caching layer
- [ ] Search highlighting
- [ ] Spellcheck/suggestions

### Phase 4: Migration & Deployment

- [ ] Migrate collection configurations
- [ ] Theme customizations
- [ ] Testing with all collections
- [ ] Performance optimization
- [ ] Deployment to production

## Development Commands

```bash
# Run tests
php artisan test

# Format code
vendor/bin/pint

# Run development server
php artisan serve

# Build frontend assets
npm run dev
npm run build

# Run Solr POC
php artisan app:solr-poc [--query=search_term]
```

## Environment Variables

Key environment variables for development:

```env
APP_NAME=Skylark
APP_ENV=local
APP_DEBUG=true
APP_URL=http://skylark.test

# Solr Configuration
SOLR_BASE_URL=http://collectionsinternal.is.ed.ac.uk:8080/solr/search/
SOLR_CONTAINER_ID=1
SOLR_CONTAINER_FIELD=location.comm
SOLR_RESULTS_PER_PAGE=10
```

## Contributing

This is a rebuild project with a 9-week timeline. Development follows Laravel best practices and the [Laravel Boost guidelines](.cursor/rules/laravel-boost.mdc).

## Resources

- **Laravel 12 Documentation**: https://laravel.com/docs/12.x
- **DSpace Documentation**: https://wiki.lyrasis.org/display/DSDOC/
- **Apache Solr**: https://solr.apache.org/guide/
- **Original Skylight**: https://github.com/UoEMainLibrary/skylight
- **University of Edinburgh Collections**: http://collections.ed.ac.uk/

## License

This project is developed for the University of Edinburgh. See original Skylight license for details.

---

**Project Start Date**: February 2026  
**Target Completion**: 9 weeks from start  
**Current Phase**: Phase 2 - Homepage Implementation ✅  
**Completed Phases**: 
- Phase 1: Solr Integration POC ✅
- Phase 2: Homepage Blade Templates ✅
