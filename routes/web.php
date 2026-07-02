<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\MemberLibraryController;
use App\Http\Controllers\MemberQuizController;
use App\Http\Controllers\MemberDiscussionController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\MemberInspiraController;
use App\Http\Controllers\MemberMengajarController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/learn-more/gurubelajar', [PublicController::class, 'learnMoreGuruBelajar'])->name('learn-more.gurubelajar');
Route::get('/learn-more/guruinspira', [PublicController::class, 'learnMoreGuruInspira'])->name('learn-more.guruinspira');
Route::get('/learn-more', [PublicController::class, 'learnMore'])->name('learn-more');
Route::get('/products', [PublicController::class, 'products'])->name('public.products');
Route::get('/artikel', [PublicController::class, 'artikel'])->name('artikel');
Route::get('/program', [PublicController::class, 'program'])->name('program');

Route::get('/info-guruinspira', [PublicController::class, 'infoGuruInspira'])->name('info.guruinspira');
Route::get('/gurubelajar', [PublicController::class, 'guruBelajar'])->name('guru-belajar');
Route::get('/gurumengajar', [PublicController::class, 'guruMengajar'])->name('guru-mengajar');
Route::get('/guruinspira', [PublicController::class, 'guruInspira'])->name('guru-inspira');

// Public Pages
Route::get('/card', [PublicController::class, 'card'])->name('public.card');
Route::get('/api/get_member', [\App\Http\Controllers\PublicController::class, 'getMember'])->name('api.get_member');


// Member Auth Routes
Route::middleware('guest:web')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// Shop Routes (Public & Member)
Route::get('/cart', [\App\Http\Controllers\ShopController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/add', [\App\Http\Controllers\ShopController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update-quantity', [\App\Http\Controllers\ShopController::class, 'updateQuantity'])->name('cart.update_quantity');
Route::delete('/cart/remove/{id}', [\App\Http\Controllers\ShopController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/checkout', [\App\Http\Controllers\ShopController::class, 'checkout'])->name('checkout.process');
Route::post('/cart/buy-now', [\App\Http\Controllers\ShopController::class, 'buyNow'])->name('cart.buy_now');

// Logout: di luar session.validate agar selalu bisa diakses walau session expired
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth:web', 'session.validate'])->group(function () {

    // Member Dashboard & Pages
    Route::get('/dashboard', [MemberDashboardController::class, 'portal'])->name('member.portal');
    Route::get('/belajar', [MemberDashboardController::class, 'index'])->name('member.dashboard');
    Route::get('/kelas', [\App\Http\Controllers\MemberCourseController::class, 'kelas'])->name('member.kelas');
    Route::get('/modul', [\App\Http\Controllers\MemberCourseController::class, 'modul'])->name('member.modul');
    Route::get('/sertifikat', [\App\Http\Controllers\MemberCourseController::class, 'sertifikat'])->name('member.sertifikat');
    Route::get('/pelatihan', [\App\Http\Controllers\MemberCourseController::class, 'pelatihan'])->name('member.pelatihan');
    Route::post('/pelatihan/daftar', [\App\Http\Controllers\MemberCourseController::class, 'daftarPelatihan'])->name('member.pelatihan.daftar');
    Route::post('/pelatihan/konfirmasi', [\App\Http\Controllers\MemberCourseController::class, 'konfirmasiPembayaran'])->name('member.pelatihan.konfirmasi');


    Route::get('/diskusi', [MemberDiscussionController::class, 'index'])->name('member.diskusi');
    Route::get('/diskusi/api/{id}', [MemberDiscussionController::class, 'show'])->name('member.diskusi.show');
    Route::post('/diskusi/api/store', [MemberDiscussionController::class, 'store'])->name('member.diskusi.store');
    Route::post('/diskusi/api/reply', [MemberDiscussionController::class, 'storeReply'])->name('member.diskusi.reply');
    Route::post('/diskusi/api/delete/{id}', [MemberDiscussionController::class, 'destroy'])->name('member.diskusi.delete');

    Route::get('/quiz', [MemberQuizController::class, 'index'])->name('member.quiz');
    Route::get('/quiz-take', [MemberQuizController::class, 'take'])->name('member.quiz.take');
    Route::get('/perpustakaan', [MemberLibraryController::class, 'index'])->name('member.perpustakaan');
    Route::get('/pengaturan', [MemberDashboardController::class, 'pengaturan'])->name('member.pengaturan');
    Route::get('/portal/profil', [MemberDashboardController::class, 'profilPortal'])->name('member.profil_portal');
    Route::post('/pengaturan', [MemberDashboardController::class, 'updateProfile'])->name('member.profile.update');
    Route::get('/member/cart', function() {
        return view('member.cart');
    })->name('member.cart');

    // API Helper routes for LMS Player & Quizzes
    Route::get('/api/get-course-modules', [\App\Http\Controllers\MemberCourseController::class, 'getCourseModules']);
    Route::get('/api/get-all-quizzes', [\App\Http\Controllers\MemberCourseController::class, 'getAllQuizzes']);
    Route::get('/api/get-quiz-result', [\App\Http\Controllers\MemberCourseController::class, 'getQuizResult']);
    Route::post('/api/complete-module', [\App\Http\Controllers\MemberCourseController::class, 'completeModule']);

    // Notifications API
    Route::get('/notifications', [MemberDashboardController::class, 'getNotificationsJson'])->name('member.notifications');
    Route::post('/notifications/read', [MemberDashboardController::class, 'markNotificationRead'])->name('member.notifications.read');

    // Guru Inspira Routes
    Route::get('/member/inspira', [MemberInspiraController::class, 'index'])->name('member.inspira.dashboard');
    Route::get('/member/inspira/forum', [MemberInspiraController::class, 'forum'])->name('member.inspira.forum');
    Route::get('/member/inspira/forum/thread/{id}', [MemberInspiraController::class, 'forumThread'])->name('member.inspira.forum.thread');
    Route::post('/member/inspira/forum/thread/create', [MemberInspiraController::class, 'createThread'])->name('member.inspira.forum.thread.create');
    Route::post('/member/inspira/forum/reply/create', [MemberInspiraController::class, 'createReply'])->name('member.inspira.forum.reply.create');
    Route::get('/member/inspira/proyek', [MemberInspiraController::class, 'proyek'])->name('member.inspira.proyek');
    Route::get('/member/inspira/proyek/{id}', [MemberInspiraController::class, 'proyekDetail'])->name('member.inspira.proyek.detail');
    Route::post('/member/inspira/proyek/create', [MemberInspiraController::class, 'createProyek'])->name('member.inspira.proyek.create');
    Route::post('/member/inspira/proyek/join', [MemberInspiraController::class, 'joinProyek'])->name('member.inspira.proyek.join');
    Route::post('/member/inspira/proyek/applicant/manage', [MemberInspiraController::class, 'manageApplicant'])->name('member.inspira.proyek.applicant.manage');
    Route::get('/member/inspira/cerita', [MemberInspiraController::class, 'cerita'])->name('member.inspira.cerita');
    Route::get('/member/inspira/cerita/{id}', [MemberInspiraController::class, 'ceritaDetail'])->name('member.inspira.cerita.detail');
    Route::post('/member/inspira/cerita/create', [MemberInspiraController::class, 'createCerita'])->name('member.inspira.cerita.create');
    Route::get('/member/inspira/agenda', [MemberInspiraController::class, 'agenda'])->name('member.inspira.agenda');
    Route::post('/member/inspira/agenda/create', [MemberInspiraController::class, 'createEvent'])->name('member.inspira.agenda.create');
    Route::post('/member/inspira/agenda/rsvp', [MemberInspiraController::class, 'rsvpEvent'])->name('member.inspira.agenda.rsvp');
    Route::get('/member/inspira/jendela', [MemberInspiraController::class, 'jendela'])->name('member.inspira.jendela');
    Route::get('/member/inspira/jendela/{id}', [MemberInspiraController::class, 'jendelaDetail'])->name('member.inspira.jendela.detail');
    Route::post('/member/inspira/jendela/create', [MemberInspiraController::class, 'createJendela'])->name('member.inspira.jendela.create');
    Route::get('/member/inspira/diskusi', [MemberInspiraController::class, 'diskusi'])->name('member.inspira.diskusi');
    Route::post('/member/inspira/diskusi/register', [MemberInspiraController::class, 'registerRekan'])->name('member.inspira.diskusi.register');

    // Guru Mengajar Routes
    Route::get('/member/mengajar', [MemberMengajarController::class, 'index'])->name('member.mengajar.dashboard');
    Route::get('/member/mengajar/gamifikasi', [MemberMengajarController::class, 'gamifikasi'])->name('member.mengajar.gamifikasi');
    Route::get('/member/mengajar/gamifikasi/play', [MemberMengajarController::class, 'play'])->name('member.mengajar.gamifikasi.play');
    Route::post('/member/mengajar/gamifikasi/karya/vote', [MemberMengajarController::class, 'voteKarya'])->name('member.mengajar.gamifikasi.karya.vote');
    Route::post('/member/mengajar/gamifikasi/karya/submit', [MemberMengajarController::class, 'submitKarya'])->name('member.mengajar.gamifikasi.karya.submit');
    Route::post('/member/mengajar/gamifikasi/checkout', [MemberMengajarController::class, 'checkoutCart'])->name('member.mengajar.gamifikasi.checkout');
    Route::post('/member/mengajar/gamifikasi/upgrade', [MemberMengajarController::class, 'upgradePremium'])->name('member.mengajar.gamifikasi.upgrade');
    Route::post('/member/mengajar/gamifikasi/use-free-play', [MemberMengajarController::class, 'useFreePlay'])->name('member.mengajar.gamifikasi.use-free-play');
    Route::post('/member/mengajar/gamifikasi/save-score', [MemberMengajarController::class, 'saveScore'])->name('member.mengajar.gamifikasi.save-score');
    Route::get('/member/mengajar/gamifikasi/owned', [MemberMengajarController::class, 'getOwnedGames'])->name('member.mengajar.gamifikasi.owned');
    Route::get('/member/mengajar/gamifikasi/kirim-karya', [MemberMengajarController::class, 'kirimKarya'])->name('member.mengajar.gamifikasi.kirim-karya');
    Route::get('/member/mengajar/impact', [MemberMengajarController::class, 'impact'])->name('member.mengajar.impact');
    Route::post('/member/mengajar/impact/feedback', [MemberMengajarController::class, 'submitFeedback'])->name('member.mengajar.impact.feedback');
    Route::get('/member/mengajar/pelatihan', [MemberMengajarController::class, 'pelatihan'])->name('member.mengajar.pelatihan');
    Route::get('/member/mengajar/pelatihan/batches/{id}', [MemberMengajarController::class, 'getBatches'])->name('member.mengajar.pelatihan.batches');
    Route::post('/member/mengajar/pelatihan/register', [MemberMengajarController::class, 'registerPelatihan'])->name('member.mengajar.pelatihan.register');
    Route::get('/member/mengajar/pelatihan/ticket/{id}', [MemberMengajarController::class, 'getTicket'])->name('member.mengajar.pelatihan.ticket');
    Route::get('/member/mengajar/pelatihan/sertifikat/{id}/unduh', [MemberMengajarController::class, 'unduhSertifikat'])->name('member.mengajar.pelatihan.sertifikat.unduh');
    Route::get('/member/mengajar/cart', [MemberMengajarController::class, 'cart'])->name('member.mengajar.cart');
    Route::get('/member/mengajar/referral', [MemberMengajarController::class, 'referral'])->name('member.mengajar.referral');
    Route::get('/member/mengajar/referral/data', [MemberMengajarController::class, 'getReferralData'])->name('member.mengajar.referral.data');
});

// Admin Auth & Dashboard Routes
Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::get('/logout', [AdminAuthController::class, 'logout']); // Fallback GET logout

        // Admin Dashboard and Member CRUD
        Route::get('/dashboard', [AdminPanelController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/members', [\App\Http\Controllers\AdminPanelController::class, 'members'])->name('admin.members');
        Route::post('/members', [\App\Http\Controllers\AdminPanelController::class, 'storeMember'])->name('admin.members.store');
        Route::delete('/members/{id}', [\App\Http\Controllers\AdminPanelController::class, 'destroyMember'])->name('admin.members.destroy');
        
        // Admin Diskusi
        Route::get('/diskusi', [\App\Http\Controllers\AdminDiskusiController::class, 'index'])->name('admin.diskusi');
        Route::post('/diskusi', [\App\Http\Controllers\AdminDiskusiController::class, 'store'])->name('admin.diskusi.store');

        // Admin Kelas
        Route::get('/kelas', [\App\Http\Controllers\AdminKelasController::class, 'index'])->name('admin.kelas');
        Route::post('/kelas', [\App\Http\Controllers\AdminKelasController::class, 'store'])->name('admin.kelas.store');

        // Admin Modul
        Route::get('/modul', [\App\Http\Controllers\AdminModulController::class, 'index'])->name('admin.modul');
        Route::post('/modul', [\App\Http\Controllers\AdminModulController::class, 'store'])->name('admin.modul.store');

        // Admin Inspira
        Route::get('/inspira_cerita', [\App\Http\Controllers\AdminInspiraController::class, 'cerita'])->name('admin.inspira_cerita');
        Route::post('/inspira_cerita', [\App\Http\Controllers\AdminInspiraController::class, 'storeCerita'])->name('admin.inspira_cerita.store');
        Route::get('/inspira_agenda', [\App\Http\Controllers\AdminInspiraController::class, 'agenda'])->name('admin.inspira_agenda');
        Route::post('/inspira_agenda', [\App\Http\Controllers\AdminInspiraController::class, 'storeAgenda'])->name('admin.inspira_agenda.store');

        // Admin Mengajar
        Route::get('/mengajar_jadwal', [\App\Http\Controllers\AdminMengajarController::class, 'jadwal'])->name('admin.mengajar_jadwal');
        Route::get('/mengajar_gamifikasi', [\App\Http\Controllers\AdminMengajarController::class, 'gamifikasi'])->name('admin.mengajar_gamifikasi');
        Route::post('/mengajar_gamifikasi', [\App\Http\Controllers\AdminMengajarController::class, 'storeGamifikasi'])->name('admin.mengajar_gamifikasi.store');

        // Admin Notifikasi
        Route::get('/notifikasi', [\App\Http\Controllers\AdminNotifikasiController::class, 'index'])->name('admin.notifikasi');
        Route::post('/notifikasi', [\App\Http\Controllers\AdminNotifikasiController::class, 'store'])->name('admin.notifikasi.store');

        // General Module Route (fallback)
        Route::match(['get', 'post'], '/module/{module}', [\App\Http\Controllers\AdminPanelController::class, 'showModule'])->name('admin.module');
    });
});


