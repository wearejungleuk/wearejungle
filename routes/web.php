<?php

use App\Http\Controllers\AuditLeadController;
use Illuminate\Support\Facades\Route;

// Free website audit lead magnet.
Route::get('/free-website-audit', [AuditLeadController::class, 'show'])
    ->name('audit-lead.show');

Route::post('/free-website-audit', [AuditLeadController::class, 'submit'])
    ->name('audit-lead.submit');

Route::get('/free-website-audit/status/{submission}', [AuditLeadController::class, 'pollStatus'])
    ->name('audit-lead.status');
