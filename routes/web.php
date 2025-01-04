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
use App\Http\Controllers\Frontend\StudentController;
use App\Http\Controllers\Frontend\TeacherController;
use Illuminate\Support\Facades\Artisan;

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

Route::group(['middleware' => ['admin'], 'prefix'=>'admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('profile/update', [ProfileController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::prefix('password')->group(function () {
        Route::get('/', [ProfileController::class, 'password'])->name('admin.password'); // password change
        Route::post('/update', [ProfileController::class, 'passwordUpdate'])->name('admin.password.update'); // password update
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
    Route::post('/get-cities', [CustomerController::class, 'getCities'])->name('get.cities');


    Route::resources([
        'faculty' => FacultyController::class,
    ]);
    //  Student Routes
    Route::prefix('faculty')->group(function () {
        Route::get('/faculty-delete/{id}', [FacultyController::class, 'delete'])->name('faculty.delete');
    });
    Route::get('/changeFacultyStatus', [FacultyController::class, 'changeFacultyStatus'])->name('faculty.change-status');
    Route::get('/faculty-fetch-data', [FacultyController::class, 'fetchData'])->name('faculty.fetch-data');


});




Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'index')->name('front.home');

    Route::prefix('registration')->group(function(){
        Route::get('school', 'school_registration')->name('front.school_registration');
        Route::get('college', 'college_registration')->name('front.college_registration');
        Route::get('faculty', 'faculty_registration')->name('front.faculty_registration');
        Route::post('faculty', 'faculty_registration_success')->name('front.faculty_registration_success');

        Route::post('success', "registrationSuccess")->name('front.registration_success');
        Route::post('studentRegisterSubmit', "studentRegisterSubmit")->name('front.student_register_submit');

        Route::get('student-personal-details', "studentPersonalDetails")->name('front.student_personal_details');
        Route::get('email-confirmation', 'emailConfirmation')->name('front.email_confirmation');
        Route::get('subscription', 'subscription')->name('front.subscriptions');
        Route::get('payment', 'payment')->name('front.payment');

    });

    Route::get('email-verification', 'emailVerification')->name('email_verification');

    Route::prefix('login')->group(function(){
        Route::get('student', 'student_login')->name('front.student_login');
        Route::post('student', 'student_login_success')->name('front.student_login_success');
        Route::get('faculty', 'faculty_login')->name('front.faculty_login');
        Route::post('faculty', 'faculty_login_success')->name('front.faculty_login_success');
    });

});

Route::controller(StudentController::class)->middleware('student.auth')->group(function(){
    Route::prefix('student')->group(function(){
        Route::get('dashboard', 'dashboard')->name('front.student_dashboard');
        Route::get('book-now', 'bookTeacher')->name('student.book_now');
        Route::get('get-slot', 'getAvailableSlot')->name('student.available_slot');
        Route::get('live-class', 'liveClass')->name('front.live_class');
        Route::post('logout', 'logout')->name('student.logout');

        Route::prefix('booking')->group(function(){
            Route::post('/', 'facultyBooking')->name('student.faculity_booking');

        });

    });
});

Route::controller(TeacherController::class)->middleware('teacher.auth')->group(function(){
    Route::prefix('teacher')->group(function(){
        Route::get('dashboard', 'dashboard')->name('auth_teacher_dashboard');
        Route::get('session', 'session')->name('auth_teacher_session');
        Route::post('session', 'addsession')->name('add_teacher_session');
        Route::get('delete-session', 'deletesession')->name('delete_teacher_session');
        Route::get('live-class', 'liveClass')->name('teacher_live_class');
        Route::post('logout', 'logout')->name('teacher.logout');
        Route::get('create-meeting', 'createMeeting')->name('start_new_meeting');
        Route::post('/end-meeting', 'endMeeting')->name('end_new_meeting');
    });
});


Route::get('/zoom/callback', [MeetingController::class, 'handleCallback']);
