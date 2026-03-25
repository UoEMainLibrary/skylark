# Migrating Skylight (CodeIgniter) collections into Skylark (Laravel)

This guide is for developers adding or porting a **collection** (themed Solr + DSpace or ArchivesSpace slice) from the legacy **Skylight** codebase into this Laravel application.

## Concepts

| Term | Meaning |
|------|--------|
| **Collection** | A logical site slice: its own Solr container/restriction, field mappings, filters, and usually its own Blade views and URL prefix. |
| **`current_collection`** | Set on every web request by middleware to the collection key (e.g. `clds`, `mimed`, `art`, `eerc`). Available as `config('app.current_collection')` and `$current_collection` in views. |
| **`skylight` config** | Runtime config namespace used by search/record services and many views (`config('skylight.*')`). It is the **merge** of [`config/skylight.php`](../config/skylight.php) with [`config/collections/{collection}.php`](../config/collections/). Per-collection values **override** the base file. |

## Request flow

1. [`CollectionMiddleware`](../app/Http/Middleware/CollectionMiddleware.php) runs on the web stack.
2. It **detects** the collection from the URL (default: first path segment vs [`config/collections.php`](../config/collections.php) `prefixes` / `available`).
3. It loads **`config/collections/{collection}.php`** and merges it into **`config('skylight')`**.
4. Controllers use [`RepositoryFactory`](../app/Services/RepositoryFactory.php) to pick **DSpace** or **ArchivesSpace** based on `repository_type` in that merged config.

## Checklist: add a new prefixed collection (e.g. `/foo`)

### 1. Register the collection

Edit [`config/collections.php`](../config/collections.php):

- Add `'foo'` to the **`available`** array.
- Add a **`prefixes`** entry: `'foo' => 'foo'` (prefix segment → collection key).

The **default** collection (`clds`) is used for the **site root** (`/`) when the first URL segment is not a registered prefix.

### 2. Create collection config

Add [`config/collections/foo.php`](../config/collections/).

- **DSpace (typical):** start from [`config/collections/clds.php`](../config/collections/clds.php) or a smaller sibling (e.g. [`art.php`](../config/collections/art.php)), or merge shared defaults:

```php
<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'foo',
    'fullname' => 'Human readable name',
    'theme' => 'foo',
    'url_prefix' => 'foo',
    'adminemail' => 'support@example.com',
    'container_id' => env('FOO_CONTAINER_ID'),
    // field_mappings, filters, recorddisplay, searchresult_display, etc.
]);
```

Shared DSpace baseline lives in [`config/collections/defaults/dspace.php`](../config/collections/defaults/dspace.php) (Solr URL, pagination defaults, lightbox flags, etc.). Override only what differs.

- **ArchivesSpace (unusual):** use [`eerc.php`](../config/collections/eerc.php) as the template (`repository_type` => `archivesspace`, API/Solr keys, etc.).

### 3. Environment variables

Set in `.env` (and document in [`.env.example`](../.env.example)):

- **`SOLR_URL`** – base Solr URL (DSpace collections).
- **`SKYLIGHT_HANDLE_PREFIX`**, **`SKYLIGHT_RESULTS_PER_PAGE`**, **`SKYLIGHT_FACET_LIMIT`** – global defaults; collection file can override.
- **Per-collection container** – e.g. `FOO_CONTAINER_ID`, `MIMED_CONTAINER_ID`, `ART_CONTAINER_ID`.
- **ArchivesSpace (EERC-style):** `ARCHIVESSPACE_SOLR_URL`, `ARCHIVESSPACE_API_URL`, `ARCHIVESSPACE_API_USER`, `ARCHIVESSPACE_API_PASSWORD`, etc.

Never commit real API passwords; use placeholders in `.env.example`.

### 4. Routes

- **Standard DSpace prefix** (home + search + record + mirador + advanced + about + iiif + licensing + takedown + accessibility, optional feedback): register via [`CollectionRouteRegistrar::registerDspacePrefixedCollection()`](../app/Routing/CollectionRouteRegistrar.php) in [`routes/web.php`](../routes/web.php). See existing **mimed** and **art** calls.
- **Custom behaviour** (extra GET routes, non-numeric record IDs, browse facets): keep a dedicated `Route::prefix('foo')->group(...)` block (see **eerc** in `web.php`).

Named routes must stay **`{collection}.*`** (e.g. `foo.search.index`) so `route()` and redirects stay consistent.

### 5. Views

Under **`resources/views/{collection}/`**:

| Area | Typical paths |
|------|----------------|
| Layout | `layouts/app.blade.php` or collection-specific layout (see `layouts/mimed.blade.php`, `layouts/art.blade.php`, `layouts/eerc-v2.blade.php`) |
| Search | `search/results.blade.php`, `search/advanced.blade.php`, `search/error.blade.php` as needed |
| Record | `record/show.blade.php` |
| Home | `home.blade.php` |
| Static pages | `pages/about.blade.php`, etc. |

Controllers resolve views with the pattern **`{collection}.{path}`** when that view exists (see [`SearchController::collectionView()`](../app/Http/Controllers/SearchController.php), [`RecordController::collectionView()`](../app/Http/Controllers/RecordController.php)). **EERC** also maps `eerc.*` → `eerc-v2.*` when `RESP_SKIN_VERSION=2` via [`PageController::eercViewName()`](../app/Http/Controllers/PageController.php).

Use `url('/foo/search/...')` or named routes so links stay prefix-safe.

### 6. Static assets

Optional: **`public/collections/{collection}/`** for CSS, images, JS. Reference with `asset('collections/foo/...')`.

### 7. Controller behaviour

[`PageController`](../app/Http/Controllers/PageController.php) branches on `config('app.current_collection')` for collection-specific home pages and static pages. For a new collection you may add:

- A dedicated `fooHome()` (or reuse a generic home view).
- Branches in `about()`, `licensing()`, etc., if the collection needs a different template.

Prefer thin controllers: collection-specific logic can move to small action classes later if branches grow.

### 8. Smoke tests

- Open `/foo` (home).
- Run a search and open one record.
- If enabled: advanced search, Mirador, IIIF links.

---

## Mapping legacy Skylight (CodeIgniter) → Laravel

Legacy app layout (sibling **skylight** CodeIgniter project, often next to this repo on disk):

- Sample global keys: `skylight/application/config/skylight-sample.php`
- Solr client expectations: `skylight/application/libraries/solr/solr_client_dspace_6.php`
- PHP views: `skylight/application/views/` (e.g. `search_results.php`, `record.php`, `header.php`)

| Legacy (CodeIgniter `skylight_*`) | Laravel merged key (`config('skylight.*')`) |
|-----------------------------------|---------------------------------------------|
| `skylight_solrbase` | `solr_base` |
| `skylight_repository_type` | `repository_type` (`dspace` / `archivesspace`) |
| `skylight_container_id` | `container_id` (string or array per collection) |
| `skylight_container_field` | `container_field` |
| Field / filter configuration | `field_mappings`, `filters`, `filter_delimiter` |
| `skylight_recorddisplay` | `recorddisplay` |
| `skylight_searchresult_display` | `searchresult_display` |
| `skylight_filters` | `filters` |
| `skylight_sort_fields` / default sort | `sort_fields`, `default_sort` |
| `skylight_results_per_page` | `results_per_page` |
| `skylight_facet_limit` | `facet_limit` |
| Bitstream / thumbnail field names | Often via `field_mappings` (`Bitstream`, `Thumbnail`) and `bitstream_field` / `thumbnail_field` |

Production Skylight instances often use **per-vhost** config; copy those values into the new `config/collections/foo.php` and `.env`.

---

## Reference implementations

| Collection | Prefix | Repository | Notes |
|------------|--------|------------|--------|
| **clds** | _(none – root)_ | DSpace | Default site; [`clds.php`](../config/collections/clds.php) merges [`defaults/dspace.php`](../config/collections/defaults/dspace.php). |
| **mimed** | `/mimed` | DSpace | LIDO-style fields; routes via `CollectionRouteRegistrar`. |
| **art** | `/art` | DSpace | Extra static routes (focus, loans, …) via `extra_routes` closure. |
| **eerc** | `/eerc` | ArchivesSpace | Custom route group; browse + static RESP pages; skin v2 optional. |

---

## Optional improvements for many collections

- **Route registration:** Extend [`CollectionRouteRegistrar`](../app/Routing/CollectionRouteRegistrar.php) or add metadata in `config/collections.php` so new DSpace collections only declare options, not copy-paste route groups.
- **View fallbacks:** For collections that share the same DSpace UI as CLDS, you could add a helper to fall back from `foo.search.results` to `clds.search.results` when a view is missing (not implemented by default—each collection currently ships its own views).
- **Dedicated controllers:** If `PageController` grows too many `if ($collection === 'foo')` branches, introduce `FooCollectionController` and point routes at it.

---

## Files touched most often

| Purpose | Location |
|---------|----------|
| Collection registry | `config/collections.php` |
| Per-collection Solr/UI config | `config/collections/{name}.php` |
| DSpace shared defaults | `config/collections/defaults/dspace.php` |
| Global Skylight defaults | `config/skylight.php` |
| Routes | `routes/web.php` |
| Collection middleware | `app/Http/Middleware/CollectionMiddleware.php` |
| DSpace / ASpace services | `app/Services/DSpaceService.php`, `ArchivesSpaceService.php` |
| Prefixed DSpace route helper | `app/Routing/CollectionRouteRegistrar.php` |
