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

// Wildcard legacy WordPress taxonomy archives. Kept as Laravel routes because
// aardvark-seo's redirect manager only supports exact source URLs, not
// patterns, and any /category/{slug} or /author/{slug} the crawler still
// finds should 301 rather than 404. Every exact-match redirect lives in
// aardvark's redirect manager (storage/statamic/addons/aardvark-seo/
// aardvark_redirects/manual.yaml, editable in the CP under SEO → Redirects).
Route::get('/category/{slug}', fn () => redirect('/blog', 301))->where('slug', '.*');
Route::get('/author/{slug}', fn () => redirect('/blog', 301))->where('slug', '.*');
