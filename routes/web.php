<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ForgetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Frontend\CmsController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MeetingController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\StudentController;
use App\Http\Controllers\Frontend\TeacherController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\FacultyTutorialController;
use App\Http\Controllers\Frontend\SubscriptionController;
use App\Models\Plan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Clear cache
Route::get('clear', function () {
    Artisan::call('optimize:clear');
    return "Optimize clear has been successfully";
});

Route::get('/admin', [AuthController::class, 'redirectAdminLogin']);
Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/login-check', [AuthController::class, 'loginCheck'])->name('admin.login.check');  //login check
Route::post('forget-password', [ForgetPasswordController::class, 'forgetPassword'])->name('admin.forget.password');
Route::post('change-password', [ForgetPasswordController::class, 'changePassword'])->name('admin.change.password');
Route::get('forget-password/show', [ForgetPasswordController::class, 'forgetPasswordShow'])->name('admin.forget.password.show');
Route::get('reset-password/{id}/{token}', [ForgetPasswordController::class, 'resetPassword'])->name('admin.reset.password');
Route::post('change-password', [ForgetPasswordController::class, 'changePassword'])->name('admin.change.password');
Route::post('/get-cities', [CustomerController::class, 'getCities'])->name('get.cities');

Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('profile/update', [ProfileController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::prefix('password')->group(function () {
        Route::get('/', [ProfileController::class, 'password'])->name('admin.password'); // password change
        Route::post('/update', [ProfileController::class, 'passwordUpdate'])->name('admin.password.update'); // password update
    });

    Route::prefix('state')->group(function () {
        Route::get('/', [StateController::class, 'index'])->name('state.index');
        Route::post('/store', [StateController::class, 'store'])->name('state.store');
        Route::post('/edit/{id}', [StateController::class, 'edit'])->name('state.edit');
        Route::get('/delete/{id}', [StateController::class, 'delete'])->name('state.delete');
        Route::post('/update', [StateController::class, 'update'])->name('state.update');
    });

    Route::prefix('country')->group(function () {
        Route::get('/', [CountryController::class, 'index'])->name('country.index');
        Route::post('/store', [CountryController::class, 'store'])->name('country.store');
        Route::post('/edit/{id}', [CountryController::class, 'edit'])->name('country.edit');
        Route::get('/delete/{id}', [CountryController::class, 'delete'])->name('country.delete');
        Route::post('/update', [CountryController::class, 'update'])->name('country.update');
    });

    Route::resources([
        'students' => CustomerController::class,
    ]);
    //  Student Routes
    Route::prefix('students')->group(function () {
        Route::get('/student-delete/{id}', [CustomerController::class, 'delete'])->name('students.delete');
    });
    Route::get('/changeCustomerStatus', [CustomerController::class, 'changeCustomersStatus'])->name('students.change-status');
    Route::get('/student-fetch-data', [CustomerController::class, 'fetchData'])->name('students.fetch-data');
    Route::post('/get-classes', [CustomerController::class, 'getClasses'])->name('get.classes');
    // Route::get('/get-cities/{country_id}', [CustomerController::class, 'getCities'])->name('get.cities');



    Route::resources([
        'faculty' => FacultyController::class,
        'plans' => PlanController::class
    ]);
    //  Student Routes
    Route::prefix('faculty')->group(function () {
        Route::get('/faculty-delete/{id}', [FacultyController::class, 'delete'])->name('faculty.delete');
    });
    Route::get('/changeFacultyStatus', [FacultyController::class, 'changeFacultyStatus'])->name('faculty.change-status');
    Route::get('/faculty-fetch-data', [FacultyController::class, 'fetchData'])->name('faculty.fetch-data');

    Route::prefix('plans')->group(function () {
        Route::get('/plans-delete/{id}', [FacultyController::class, 'delete'])->name('plans.delete');
    });

    // payments
    Route::get('/payments', [PaymentController::class, 'payments'])->name('admin.payments');
    Route::get('/payment-fetch-data', [PaymentController::class, 'paymentFetchData'])->name('admin.payment-fetch-data');
});




Route::get('/about-us', [PageController::class, 'aboutUs'])->name('about.us');
Route::get('/articles', [PageController::class, 'articles'])->name('articles');
Route::get('/career', [PageController::class, 'career'])->name('career');
Route::get('/help', [PageController::class, 'help'])->name('help');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('contact.us');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/subscriptions', [PageController::class, 'subscriptions'])->name('subscriptions');
Route::get('/terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms.conditions');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy.policy');


Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('front.home');

    Route::prefix('registration')->group(function () {
        Route::get('school', 'school_registration')->name('front.school_registration');
        Route::get('college', 'college_registration')->name('front.college_registration');
        Route::get('faculty', 'faculty_registration')->name('front.faculty_registration');
        Route::post('faculty', 'faculty_registration_success')->name('front.faculty_registration_success');

        Route::post('success', "registrationSuccess")->name('front.registration_success');
        Route::post('studentRegisterSubmit', "studentRegisterSubmit")->name('front.student_register_submit');

        Route::get('student-personal-details', "studentPersonalDetails")->name('front.student_personal_details');
        Route::get('email-confirmation', 'emailConfirmation')->name('front.email_confirmation');
        // Route::get('payment', 'payment')->name('front.payment');
    });

    Route::get('email-verification', 'emailVerification')->name('email_verification');

    Route::prefix('login')->group(function () {
        Route::get('student', 'student_login')->name('front.student_login');
        Route::post('student', 'student_login_success')->name('front.student_login_success');
        Route::get('faculty', 'faculty_login')->name('front.faculty_login');
        Route::post('faculty', 'faculty_login_success')->name('front.faculty_login_success');

        //student forget password
        Route::get('student/forget-password/show', 'forget_password')->name('front.forget_password');
        Route::post('student/forget-password',  'forgetPassword')->name('front.forget.password');
        Route::get('student/reset-password/{id}/{token}', 'resetPassword')->name('front.reset.password');
        Route::post('student/change-password', 'changePassword')->name('front.change.password');

        //faculty forget password
        Route::get('faculty/forget-password/show', 'faculty_forget_password')->name('front.faculty.forget_password');
        Route::post('faculty/forget-password',  'faculty_forgetPassword')->name('front.faculty.forget.password');
        Route::get('faculty/reset-password/{id}/{token}', 'faculty_resetPassword')->name('front.faculty.reset.password');
        Route::post('faculty/change-password', 'faculty_changePassword')->name('front.faculty.change.password');
        // Route::post('change-password', 'changePassword')->name('front.change.password');
    });
});

// subscription
Route::middleware('student.auth')->group(function () {
    Route::get('/subscription', [SubscriptionController::class, 'subscription'])->name('subscription');
    Route::get('/subscription/{id}', [SubscriptionController::class, 'payment'])->name('student.subscription.payment');
    Route::get('/paypal-checkout-success', [SubscriptionController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('/paypal-checkout-cancel', [SubscriptionController::class, 'paypalCancel'])->name('paypal.cancel');
});


Route::controller(StudentController::class)->middleware('student.auth')->group(function () {
    Route::prefix('student')->group(function () {
        Route::get('dashboard', 'dashboard')->name('front.student_dashboard');
        Route::get('book-now', 'bookTeacher')->name('student.book_now');
        Route::get('get-slot', 'getAvailableSlot')->name('student.available_slot');
        Route::get('live-class', 'liveClass')->name('front.live_class');
        Route::get('logout', 'logout')->name('student.logout');
        Route::get('check-meeting', 'checkMeeting')->name('student.start_new_meeting');
        Route::prefix('booking')->group(function () {
            Route::post('/', 'facultyBooking')->name('student.faculity_booking');
        });
    });
});

Route::controller(TeacherController::class)->middleware('teacher.auth')->group(function () {
    Route::prefix('teacher')->group(function () {
        Route::get('dashboard', 'dashboard')->name('auth_teacher_dashboard');
        Route::get('session', 'session')->name('auth_teacher_session');
        Route::post('session', 'addsession')->name('add_teacher_session');
        Route::get('delete-session', 'deletesession')->name('delete_teacher_session');
        Route::get('live-class', 'liveClass')->name('teacher_live_class');
        Route::get('logout', 'logout')->name('teacher.logout');
        Route::get('create-meeting', 'createMeeting')->name('start_new_meeting');
        Route::post('/end-meeting', 'endMeeting')->name('end_new_meeting');
        Route::get('profile', 'profile')->name('teacher.profile');
        Route::post('profile', 'updateProfile')->name('teacher.update_profile');
    });
});

Route::controller(FacultyTutorialController::class)
    ->middleware('teacher.auth')
    ->prefix('teacher')
    ->group(function () {

        // List all tutorials
        Route::get('/tutorials', 'index')->name('teacher.tutorials.index');


        // Store a new tutorial
        Route::post('/tutorials', 'store')->name('teacher.tutorials.store');

        // Show edit form for a specific tutorial
        Route::get('/tutorials/{id}/edit', 'edit')->name('teacher.tutorials.edit');

        // Update an existing tutorial
        Route::put('/tutorials/{id}', 'update')->name('teacher.tutorials.update');

        // Delete a tutorial
        Route::delete('/tutorials/{id}', 'destroy')->name('teacher.tutorials.destroy');

    });


Route::get('/zoom/callback', [MeetingController::class, 'handleCallback']);
