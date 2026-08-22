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
Route::permanentRedirect('/free-website-health-check-and-review', '/free-website-audit');
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
// /sectors and /sectors/web-design-for-construction are both live entries
// now (sectors collection index + construction sector page), so no
// redirects. The remaining legacy slugs below have no replacement sector
// page in the current plan and still fall back to /services/web-design.
// Dentists is rebuilt under the new dental-practices slug.
Route::permanentRedirect('/sectors/web-design-for-mortgage-advisors', '/services/web-design');
Route::permanentRedirect('/sectors/web-design-for-estate-agents', '/services/web-design');
Route::permanentRedirect('/sectors/websites-for-dentists', '/sectors/web-design-for-dental-practices');
Route::permanentRedirect('/sectors/web-design-for-recruitment-consultants', '/services/web-design');

// Sourced from the Mountex Digital SEO redirect map (August 2026 audit of
// legacy WordPress URLs). Every destination is a live 200 rather than a
// chain, even where the SEO brief suggested a page still to be restored.

// Info pages that changed slug in the rebrand.
Route::permanentRedirect('/about-us', '/about');
Route::permanentRedirect('/contact-us', '/contact');

// Legacy service pages.
// /services/wordpress-support-hosting was a combined page that is now split
// between /services/website-maintenance-support and /services/hosting; point
// it at support since that carries the maintenance intent.
Route::permanentRedirect('/services/wordpress-support-hosting', '/services/website-maintenance-support');
// White-label was aimed at other agencies; closest current match is
// web-development. Marked as a restore candidate longer-term.
Route::permanentRedirect('/services/white-label-services-for-digital-marketing-agencies', '/services/web-development');
// Subscription websites was dropped before the rebrand; pricing is the
// closest match for the intent.
Route::permanentRedirect('/services/subscription-websites', '/pricing');

// Root-level pages from the old site with no direct equivalent.
Route::permanentRedirect('/seo', '/');
Route::permanentRedirect('/sectors', '/');

// Legacy /case-studies/ URLs now live under /work/{slug} in the work
// collection.
Route::permanentRedirect('/case-studies/mrg-effitas', '/work/mrg-effitas');
Route::permanentRedirect('/case-studies/my-learning-cloud', '/work/my-learning-cloud');
Route::permanentRedirect('/case-studies/mash-gang-2025', '/work/mash-gang');
// Seafarer Social has no equivalent on the new site; fall back to the
// work index rather than an unrelated case study.
Route::permanentRedirect('/case-studies/seafarer-social', '/work');

// Two blog posts named in the SEO map. E-commerce tips has no equivalent
// yet; the CMS-choice post maps cleanly onto the Statamic vs WordPress
// article.
Route::permanentRedirect('/growing-your-e-commerce-site-7-tips-tricks', '/blog');
Route::permanentRedirect('/choosing-the-right-cms-for-your-website', '/blog/why-we-choose-statamic-over-wordpress');
