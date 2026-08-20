<?php

use App\Http\Controllers\AuditLeadController;
use Illuminate\Support\Facades\Route;

// Free website audit lead magnet.
// GET is served by the Statamic page entry at
// content/collections/pages/free-website-audit.md (template
// audit-lead/index) so aardvark-seo picks up the meta tags.
Route::post('/free-website-audit', [AuditLeadController::class, 'submit'])
    ->name('audit-lead.submit');

Route::get('/free-website-audit/status/{submission}', [AuditLeadController::class, 'pollStatus'])
    ->name('audit-lead.status');

// Trakd → wearejungle callback when a lead-magnet audit completes.
// Origin verified by the shared X-Callback-Secret header.
Route::post('/api/audits/callback', [AuditLeadController::class, 'receiveCallback'])
    ->name('audits.callback');

// The `work_type` taxonomy is display-only (tag pills on case studies),
// so its default Statamic term URLs (/work-type/{slug}) should not be
// public. Google indexed them, so 301 each to the matching service page.
Route::permanentRedirect('/work-type/branding', '/services');
Route::permanentRedirect('/work-type/web-design', '/services/web-design');
Route::permanentRedirect('/work-type/web-development', '/services/web-development');
Route::permanentRedirect('/work-type/e-commerce', '/services/e-commerce');
Route::permanentRedirect('/work-type/hosting', '/services/hosting');

// Split of the original combined /services/support-hosting into two
// distinct service pages (/services/website-maintenance-support and
// /services/hosting). URL for the support page follows the Mountex
// Digital SEO brief spec.
Route::permanentRedirect('/services/support-hosting', '/services/website-maintenance-support');
Route::permanentRedirect('/services/support', '/services/website-maintenance-support');

// Legacy WordPress blog URLs.
// Old site published posts at the root (e.g. /how-much-does-a-website-cost/)
// and had a /blogs/ index. Aggregating everything to the current /blog
// listing recovers Google's crawl signal on the old URLs without a per-post
// mapping into the new Statamic collection. Slugs pulled from the Wayback
// Machine CDX index (http://web.archive.org/cdx/search/cdx?url=wearejungle.co.uk/*).
Route::permanentRedirect('/blogs', '/blog');
Route::permanentRedirect('/16-strategies-to-enhance-your-e-commerce-conversion-efficiency', '/blog');
Route::permanentRedirect('/50-years-of-hip-hop-my-top-5-albums', '/blog');
Route::permanentRedirect('/a-culinary-tour-of-portsmouth-my-favourite-haunts', '/blog');
Route::permanentRedirect('/choosing-the-ideal-web-design-agency', '/blog');
Route::permanentRedirect('/damira-dental-we-are-jungle-triumphs-at-dentistry-2023-awards', '/blog');
Route::permanentRedirect('/embrace-spring-cleaning-for-your-website-even-in-autumn', '/blog');
Route::permanentRedirect('/free-website-health-check-and-review', '/blog');
Route::permanentRedirect('/how-much-does-a-website-cost', '/blog');
Route::permanentRedirect('/how-to-attract-patients-with-your-dental-website-design', '/blog');
Route::permanentRedirect('/how-to-install-wordpress-on-a-server', '/blog');
Route::permanentRedirect('/integrating-your-wordpress-or-shopify-website-into-your-crm', '/blog');
Route::permanentRedirect('/introducing-we-are-jungle', '/blog');
Route::permanentRedirect('/meet-our-new-star-intern-a-qa-with-augie', '/blog');
Route::permanentRedirect('/my-favourite-things-to-do-in-portsmouth', '/blog');
Route::permanentRedirect('/why-estate-agents-need-a-new-website', '/blog');
Route::permanentRedirect('/wordpress-or-wix-website', '/blog');

// Old WordPress taxonomy archives (categories and author pages) all
// funnel to the current blog listing.
Route::get('/category/{slug}', fn () => redirect('/blog', 301))->where('slug', '.*');
Route::get('/author/{slug}', fn () => redirect('/blog', 301))->where('slug', '.*');

// Legacy sector URLs from the old WordPress site.
//
// Construction is being rebuilt at the same URL, so it needs no
// redirect - Statamic will serve the new entry once it exists. Listed
// here as a comment so the full historical set is documented in one place.
//
// - /sectors/web-design-for-construction -> rebuilt in place
//
// Mortgage advisors, estate agents and the old /sectors/ index have no
// replacement sector page in the current plan, so they fall back to
// /services/web-design. Dentists is being rebuilt under the new
// dental-practices slug.
Route::permanentRedirect('/sectors', '/services/web-design');
Route::permanentRedirect('/sectors/web-design-for-mortgage-advisors', '/services/web-design');
Route::permanentRedirect('/sectors/web-design-for-estate-agents', '/services/web-design');
Route::permanentRedirect('/sectors/websites-for-dentists', '/sectors/web-design-for-dental-practices');
Route::permanentRedirect('/sectors/web-design-for-recruitment-consultants', '/services/web-design');
