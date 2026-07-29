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
Route::permanentRedirect('/work-type/hosting', '/services/support-hosting');
