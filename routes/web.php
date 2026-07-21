<?php

use App\Http\Controllers\AuditLeadController;
use Illuminate\Support\Facades\Route;

// Free website audit lead magnet.
// GET is served via Route::statamic so the template renders inside
// the site layout (vite assets, header, footer, Turnstile init).
Route::statamic('/free-website-audit', 'audit-lead.index', [
    'title' => 'Free Website Audit',
]);

Route::post('/free-website-audit', [AuditLeadController::class, 'submit'])
    ->name('audit-lead.submit');

Route::get('/free-website-audit/status/{submission}', [AuditLeadController::class, 'pollStatus'])
    ->name('audit-lead.status');
