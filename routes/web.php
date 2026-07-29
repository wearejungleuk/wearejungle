<?php

use App\Http\Controllers\AuditLeadController;
use Illuminate\Support\Facades\Route;
use Statamic\Exceptions\NotFoundHttpException;

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
// public. Throw Statamic's NotFoundHttpException (not Laravel's abort)
// so the 404 view is wrapped in the site layout, matching a normal 404.
Route::get('/work-type/{any?}', fn () => throw new NotFoundHttpException)->where('any', '.*');
