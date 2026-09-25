<?php

use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CaseStudyController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ClientWorkController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\QualificationController;
use App\Http\Controllers\Admin\ResumeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkillCategoryController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AssignmentController as FrontendAssignmentController;
use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\Frontend\CaseStudyController as FrontendCaseStudyController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ExperienceController as FrontendExperienceController;
use App\Http\Controllers\Frontend\FaqController as FrontendFaqController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MeetingController as FrontendMeetingController;
use App\Http\Controllers\Frontend\QualificationController as FrontendQualificationController;
use App\Http\Controllers\Frontend\ResumeController as FrontendResumeController;
use App\Http\Controllers\Frontend\ServiceController as FrontendServiceController;
use App\Http\Controllers\Frontend\SkillController as FrontendSkillController;
use App\Http\Controllers\Frontend\TermController as FrontendTermController;
use App\Http\Controllers\Frontend\TestimonialController as FrontendTestimonialController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/clear-cache', function () {
    // Clear application cache
    Artisan::call('cache:clear');
    // Clear config cache
    Artisan::call('config:clear');
    // Clear view cache
    Artisan::call('view:clear');
    // Clear route cache
    Artisan::call('route:clear');
    // Clear compiled class files
    Artisan::call('clear-compiled');
    // Optimize the class loader
    Artisan::call('optimize:clear');

    return 'Cache cleared successfully!';
});

// ---------------------------------------------------------------------------
// Theme preference — shared by the frontend and the admin panel so a manual
// toggle is remembered per section (localStorage primary, session backup).
// ---------------------------------------------------------------------------
Route::post('/theme', [ThemeController::class, 'update'])->name('theme.update');

// ---------------------------------------------------------------------------
// Admin Authentication
// ---------------------------------------------------------------------------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');

        Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
        Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.submit');
        Route::get('reset-password', [AuthController::class, 'showResetPassword'])->name('reset-password');
        Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.submit');
    });

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('calendar', [DashboardController::class, 'calendar'])->name('dashboard.calendar');
        Route::get('financials', [DashboardController::class, 'financials'])->name('dashboard.financials');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('qualifications', QualificationController::class)
            ->except(['show']);
        Route::patch('qualifications/{qualification}/toggle', [QualificationController::class, 'toggle'])
            ->name('qualifications.toggle');

        Route::get('skill-categories', [SkillCategoryController::class, 'index'])->name('skill-categories.index');
        Route::get('skill-categories/create', [SkillCategoryController::class, 'create'])->name('skill-categories.create');
        Route::post('skill-categories', [SkillCategoryController::class, 'store'])->name('skill-categories.store');
        Route::get('skill-categories/{skillCategory}/edit', [SkillCategoryController::class, 'edit'])->name('skill-categories.edit');
        Route::put('skill-categories/{skillCategory}', [SkillCategoryController::class, 'update'])->name('skill-categories.update');
        Route::delete('skill-categories/{skillCategory}', [SkillCategoryController::class, 'destroy'])->name('skill-categories.destroy');

        Route::resource('skills', SkillController::class)->except(['show']);
        Route::patch('skills/{skill}/toggle', [SkillController::class, 'toggle'])->name('skills.toggle');

        Route::resource('experiences', ExperienceController::class)->except(['show']);
        Route::patch('experiences/{experience}/toggle', [ExperienceController::class, 'toggle'])->name('experiences.toggle');

        Route::resource('services', ServiceController::class)->except(['show']);
        Route::patch('services/{service}/toggle', [ServiceController::class, 'toggle'])->name('services.toggle');

        Route::resource('assignments', AssignmentController::class)->except(['show']);
        Route::patch('assignments/{assignment}/toggle', [AssignmentController::class, 'toggle'])->name('assignments.toggle');

        Route::resource('faqs', FaqController::class)->except(['show']);
        Route::patch('faqs/{faq}/toggle', [FaqController::class, 'toggle'])->name('faqs.toggle');

        Route::resource('terms', TermController::class)->except(['show']);
        Route::patch('terms/{term}/toggle', [TermController::class, 'toggle'])->name('terms.toggle');

        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::patch('testimonials/{testimonial}/toggle', [TestimonialController::class, 'toggle'])->name('testimonials.toggle');

        Route::resource('clients', ClientController::class)->except(['show']);
        Route::get('clients/export/{format}', [ClientController::class, 'export'])->name('clients.export');
        Route::get('clients/{client}/invoice', [ClientController::class, 'invoice'])->name('clients.invoice');
        Route::get('clients/{client}', [ClientController::class, 'show'])->name('clients.show');
        Route::patch('clients/{client}/toggle', [ClientController::class, 'toggle'])->name('clients.toggle');
        Route::post('clients/{client}/works', [ClientWorkController::class, 'store'])->name('clients.works.store');
        Route::put('clients/{client}/works/{work}', [ClientWorkController::class, 'update'])->name('clients.works.update');
        Route::delete('clients/{client}/works/{work}', [ClientWorkController::class, 'destroy'])->name('clients.works.destroy');

        Route::get('payments/export/{format}', [PaymentController::class, 'export'])->name('payments.export');
        Route::get('payments/load-summary', [PaymentController::class, 'summary'])->name('payments.summary');
        Route::resource('payments', PaymentController::class)->except(['show']);

        Route::get('expenses/export/{format}', [ExpenseController::class, 'export'])->name('expenses.export');
        Route::resource('expenses', ExpenseController::class)->except(['show']);

        Route::resource('case-studies', CaseStudyController::class)->except(['show'])->parameters(['case-studies' => 'caseStudy']);
        Route::patch('case-studies/{caseStudy}/toggle', [CaseStudyController::class, 'toggle'])->name('case-studies.toggle');

        Route::resource('blog-posts', BlogPostController::class)->except(['show'])->parameters(['blog-posts' => 'blogPost']);

        Route::resource('meetings', MeetingController::class)->except(['show']);
        Route::patch('meetings/{meeting}/status', [MeetingController::class, 'updateStatus'])->name('meetings.status');

        Route::get('tasks/calendar', [TaskController::class, 'calendar'])->name('tasks.calendar');
        Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
        Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
        Route::resource('tasks', TaskController::class)->except(['show']);

        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::patch('messages/{message}/toggle-read', [MessageController::class, 'toggleRead'])->name('messages.toggle-read');
        Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('resume', [ResumeController::class, 'index'])->name('resume.index');
        Route::post('resume', [ResumeController::class, 'upload'])->name('resume.upload');
        Route::delete('resume', [ResumeController::class, 'destroy'])->name('resume.destroy');
        Route::get('resume/download', [ResumeController::class, 'download'])->name('resume.download');
        Route::get('resume/view', [ResumeController::class, 'view'])->name('resume.view');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});

// ---------------------------------------------------------------------------
// Frontend
// ---------------------------------------------------------------------------
Route::middleware('track.visit')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/qualifications', [FrontendQualificationController::class, 'index'])->name('qualifications');
    Route::get('/skills', [FrontendSkillController::class, 'index'])->name('skills');
    Route::get('/experience', [FrontendExperienceController::class, 'index'])->name('experience');
    Route::get('/services', [FrontendServiceController::class, 'index'])->name('services');
    Route::get('/assignments', [FrontendAssignmentController::class, 'index'])->name('assignments');
    Route::get('/assignments/{assignment}', [FrontendAssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/faqs', [FrontendFaqController::class, 'index'])->name('faqs');
    Route::get('/terms', [FrontendTermController::class, 'index'])->name('terms');
    Route::get('/testimonials', [FrontendTestimonialController::class, 'index'])->name('testimonials');
    Route::get('/case-studies', [FrontendCaseStudyController::class, 'index'])->name('case-studies');
    Route::get('/case-studies/{caseStudy}', [FrontendCaseStudyController::class, 'show'])->name('case-studies.show');
    Route::get('/blog', [FrontendBlogController::class, 'index'])->name('blog');
    Route::get('/blog/{blogPost}', [FrontendBlogController::class, 'show'])->name('blog.show');
    Route::post('/meetings', [FrontendMeetingController::class, 'store'])->name('meetings.store');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/resume', [FrontendResumeController::class, 'view'])->name('resume');
    Route::get('/resume/download', [FrontendResumeController::class, 'download'])->name('resume.download');
    Route::get('/sitemap.xml', function () {
        $urls = [
            route('home'),
            route('about'),
            route('qualifications'),
            route('skills'),
            route('experience'),
            route('services'),
            route('assignments'),
            route('faqs'),
            route('terms'),
            route('testimonials'),
            route('case-studies'),
            route('blog'),
            route('contact'),
        ];

        return response()
            ->view('frontend.sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    })->name('sitemap');
});
