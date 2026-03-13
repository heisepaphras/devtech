<?php

use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ScoutingProgramController as AdminScoutingProgramController;
use App\Http\Controllers\Admin\TransferMarketController as AdminTransferMarketController;
use App\Http\Controllers\Admin\PlayerProfileController as AdminPlayerProfileController;
use App\Http\Controllers\Admin\VideoClipController as AdminVideoClipController;
use App\Http\Controllers\Admin\ManagementMemberController as AdminManagementMemberController;
use App\Http\Controllers\Admin\PlayerValueController as AdminPlayerValueController;
use App\Http\Controllers\Admin\LiveScoreController as AdminLiveScoreController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\PlayersManagementController;
use App\Http\Controllers\LiveScoreController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PlayerValueController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ScoutingProgramController;
use App\Http\Controllers\TransferMarketController;
use App\Http\Controllers\PlayerProfileController;
use App\Http\Controllers\VideoClipController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
Route::get('/install', InstallController::class)->name('install');

Route::view('/about', 'pages.about', [
    'pageTitle' => 'About',
])->name('about');

Route::view('/privacy-policy', 'pages.privacy', [
    'pageTitle' => 'Privacy Policy',
])->name('privacy');

Route::view('/terms-of-service', 'pages.terms', [
    'pageTitle' => 'Terms and Conditions',
])->name('terms');

Route::view('/support', 'pages.support', [
    'pageTitle' => 'Support',
])->name('support');

Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
Route::get('/transfer-market', [TransferMarketController::class, 'index'])->name('transfer.market');
Route::get('/transfer-market/{slug}', [TransferMarketController::class, 'show'])->name('transfer.market.show');
Route::get('/player-profiles', [PlayerProfileController::class, 'index'])->name('player.profiles');
Route::get('/player-profiles/{slug}', [PlayerProfileController::class, 'show'])->name('player.profiles.show');
Route::get('/academy-players-management', [PlayersManagementController::class, 'index'])->name('players.management');
Route::get('/players-value', [PlayerValueController::class, 'index'])->name('players.value');
Route::get('/players-value/{slug}', [PlayerValueController::class, 'show'])->name('players.value.show');
Route::get('/live-score', [LiveScoreController::class, 'index'])->name('live.score');
Route::get('/live-score/{slug}', [LiveScoreController::class, 'show'])->name('live.score.show');
Route::get('/video-clips', [VideoClipController::class, 'index'])->name('videos');
Route::get('/video-clips/{slug}', [VideoClipController::class, 'show'])->name('videos.show');
Route::get('/scouting-trials-programs', [ScoutingProgramController::class, 'index'])->name('scouting.trials');
Route::get('/scouting-trials-programs/{slug}', [ScoutingProgramController::class, 'show'])->name('scouting.trials.show');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');
    });

    Route::middleware('admin.auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
        Route::redirect('/', '/admin/news')->name('dashboard');

        Route::get('/news', [AdminNewsController::class, 'index'])->name('news.index');
        Route::get('/news/create', [AdminNewsController::class, 'create'])->name('news.create');
        Route::post('/news', [AdminNewsController::class, 'store'])->name('news.store');
        Route::get('/news/{news}/edit', [AdminNewsController::class, 'edit'])->name('news.edit');
        Route::put('/news/{news}', [AdminNewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{news}', [AdminNewsController::class, 'destroy'])->name('news.destroy');

        Route::get('/gallery', [AdminGalleryController::class, 'index'])->name('gallery.index');
        Route::get('/gallery/create', [AdminGalleryController::class, 'create'])->name('gallery.create');
        Route::post('/gallery', [AdminGalleryController::class, 'store'])->name('gallery.store');
        Route::get('/gallery/{galleryItem}/edit', [AdminGalleryController::class, 'edit'])->name('gallery.edit');
        Route::put('/gallery/{galleryItem}', [AdminGalleryController::class, 'update'])->name('gallery.update');
        Route::delete('/gallery/{galleryItem}', [AdminGalleryController::class, 'destroy'])->name('gallery.destroy');

        Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
        Route::get('/events/create', [AdminEventController::class, 'create'])->name('events.create');
        Route::post('/events', [AdminEventController::class, 'store'])->name('events.store');
        Route::get('/events/{eventItem}/edit', [AdminEventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{eventItem}', [AdminEventController::class, 'update'])->name('events.update');
        Route::delete('/events/{eventItem}', [AdminEventController::class, 'destroy'])->name('events.destroy');

        Route::get('/scouting-programs', [AdminScoutingProgramController::class, 'index'])->name('programs.index');
        Route::get('/scouting-programs/create', [AdminScoutingProgramController::class, 'create'])->name('programs.create');
        Route::post('/scouting-programs', [AdminScoutingProgramController::class, 'store'])->name('programs.store');
        Route::get('/scouting-programs/{scoutingProgram}/edit', [AdminScoutingProgramController::class, 'edit'])->name('programs.edit');
        Route::put('/scouting-programs/{scoutingProgram}', [AdminScoutingProgramController::class, 'update'])->name('programs.update');
        Route::delete('/scouting-programs/{scoutingProgram}', [AdminScoutingProgramController::class, 'destroy'])->name('programs.destroy');

        Route::get('/transfers', [AdminTransferMarketController::class, 'index'])->name('transfers.index');
        Route::get('/transfers/create', [AdminTransferMarketController::class, 'create'])->name('transfers.create');
        Route::post('/transfers', [AdminTransferMarketController::class, 'store'])->name('transfers.store');
        Route::get('/transfers/{transferItem}/edit', [AdminTransferMarketController::class, 'edit'])->name('transfers.edit');
        Route::put('/transfers/{transferItem}', [AdminTransferMarketController::class, 'update'])->name('transfers.update');
        Route::delete('/transfers/{transferItem}', [AdminTransferMarketController::class, 'destroy'])->name('transfers.destroy');

        Route::get('/player-profiles', [AdminPlayerProfileController::class, 'index'])->name('player-profiles.index');
        Route::get('/player-profiles/create', [AdminPlayerProfileController::class, 'create'])->name('player-profiles.create');
        Route::post('/player-profiles', [AdminPlayerProfileController::class, 'store'])->name('player-profiles.store');
        Route::get('/player-profiles/{playerProfile}/edit', [AdminPlayerProfileController::class, 'edit'])->name('player-profiles.edit');
        Route::put('/player-profiles/{playerProfile}', [AdminPlayerProfileController::class, 'update'])->name('player-profiles.update');
        Route::delete('/player-profiles/{playerProfile}', [AdminPlayerProfileController::class, 'destroy'])->name('player-profiles.destroy');

        Route::get('/videos', [AdminVideoClipController::class, 'index'])->name('videos.index');
        Route::get('/videos/create', [AdminVideoClipController::class, 'create'])->name('videos.create');
        Route::post('/videos', [AdminVideoClipController::class, 'store'])->name('videos.store');
        Route::get('/videos/{videoClip}/edit', [AdminVideoClipController::class, 'edit'])->name('videos.edit');
        Route::put('/videos/{videoClip}', [AdminVideoClipController::class, 'update'])->name('videos.update');
        Route::delete('/videos/{videoClip}', [AdminVideoClipController::class, 'destroy'])->name('videos.destroy');

        Route::get('/management', [AdminManagementMemberController::class, 'index'])->name('management.index');
        Route::get('/management/create', [AdminManagementMemberController::class, 'create'])->name('management.create');
        Route::post('/management', [AdminManagementMemberController::class, 'store'])->name('management.store');
        Route::get('/management/{managementMember}/edit', [AdminManagementMemberController::class, 'edit'])->name('management.edit');
        Route::put('/management/{managementMember}', [AdminManagementMemberController::class, 'update'])->name('management.update');
        Route::delete('/management/{managementMember}', [AdminManagementMemberController::class, 'destroy'])->name('management.destroy');

        Route::get('/player-values', [AdminPlayerValueController::class, 'index'])->name('player-values.index');
        Route::get('/player-values/create', [AdminPlayerValueController::class, 'create'])->name('player-values.create');
        Route::post('/player-values', [AdminPlayerValueController::class, 'store'])->name('player-values.store');
        Route::get('/player-values/{playerValue}/edit', [AdminPlayerValueController::class, 'edit'])->name('player-values.edit');
        Route::put('/player-values/{playerValue}', [AdminPlayerValueController::class, 'update'])->name('player-values.update');
        Route::delete('/player-values/{playerValue}', [AdminPlayerValueController::class, 'destroy'])->name('player-values.destroy');

        Route::get('/live-scores', [AdminLiveScoreController::class, 'index'])->name('live-scores.index');
        Route::get('/live-scores/create', [AdminLiveScoreController::class, 'create'])->name('live-scores.create');
        Route::post('/live-scores', [AdminLiveScoreController::class, 'store'])->name('live-scores.store');
        Route::get('/live-scores/{liveScore}/edit', [AdminLiveScoreController::class, 'edit'])->name('live-scores.edit');
        Route::put('/live-scores/{liveScore}', [AdminLiveScoreController::class, 'update'])->name('live-scores.update');
        Route::delete('/live-scores/{liveScore}', [AdminLiveScoreController::class, 'destroy'])->name('live-scores.destroy');

        Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
        Route::get('/registrations/{registrationApplication}/edit', [AdminRegistrationController::class, 'edit'])->name('registrations.edit');
        Route::put('/registrations/{registrationApplication}', [AdminRegistrationController::class, 'update'])->name('registrations.update');
        Route::delete('/registrations/{registrationApplication}', [AdminRegistrationController::class, 'destroy'])->name('registrations.destroy');
    });
});
