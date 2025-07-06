<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Types\Relations\Role;

Route::get('/', function () {
    $topEvents = Event::whereDate('date', '>=', now()->toDateString())->orderBy('tickets_booked','desc')->take(3)->get();
    $buttons= ["Register",'Join',"Book Now"];
    $i=0;
    foreach ($topEvents as $event) {
        $event->button = $buttons[$i];
        $i++;
    }
    
    return view('welcome',compact('topEvents','buttons'));
})->name('home');
Route::get("/events/browse",[EventController::class,'browse'])->name('events.browse');
Route::get('/features',function(){return view('features');})->name('features');

//AdminController Routes
Route::get("/admin/login",[AdminController::class,'adminLogin'])->name('admin.login');
Route::post("/admin/login",[AdminController::class,'adminLoginPost'])->name('admin.loginPost');
Route::middleware('IsAdmin')->group(function(){
    Route::get('/admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/admin/upcomingEvents',[AdminController::class,'manageUpcomingEvents'])->name('admin.events.upcoming');
    Route::put('/admin/events/update/{id}',[AdminController::class,'update'])->name('admin.events.update');
    Route::delete('/admin/events/destroy/{id}',[AdminController::class,'destroy'])->name('admin.events.destroy');
    Route::get('admin/pastEvents',[AdminController::class,'pastEvents'])->name('admin.events.past');
    Route::get('admin/manageUsers',[AdminController::class,'manageUsers'])->name('admin.users.manage');
    Route::patch('admin/toggleUsers/{id}',[AdminController::class,'toggleUsers'])->name('admin.users.toggle');
    Route::get('/admin/viewBookings',[AdminController::class,'viewBookings'])->name('admin.bookings.view');
    Route::get('/admin/feedbackReports',[AdminController::class,'feedbackReports'])->name('admin.feedbacks.report');
    Route::post('/admin/logout',[AdminController::class,'logout'])->name('admin.logout');

    
    


});

//UserController Routes
Route::get("/login",[UserController::class,'login'])->name('login');
Route::get("/userLogin",[UserController::class,'userLogin'])->name('userLogin');
Route::get("/register",[UserController::class,'register'])->name('register');
Route::get("/forgotPassword",[UserController::class,'forgotPassword'])->name('forgotPassword');
Route::get("/verifyOtp/{token}",[UserController::class,'verifyOtp'])->name('verifyOtp');
Route::get("/setNewPassword/{email}",[UserController::class,'setNewPassword'])->name('setNewPassword');
Route::post("/register",[UserController::class,'registerPost'])->name('registerPost');
Route::post("/login",[UserController::class,'loginPost'])->name('loginPost');
Route::post("/forgotPassword",[UserController::class,'forgotPasswordPost'])->name('forgotPasswordPost');
Route::post("/verifyOtp",[UserController::class,'verifyOtpPost'])->name('verifyOtpPost');
Route::post("/setNewPassword",[UserController::class,'setNewPasswordPost'])->name('setNewPasswordPost');


Route::middleware('auth')->group(function(){
    Route::post("/logout",[UserController::class,'logout'])->name('logout');
    Route::get("/dashboard",[UserController::class,'dashboard'])->name('dashboard');
    Route::resource('profile',ProfileController::class);
    Route::get("/editProfile",[UserController::class,'editProfile'])->name('editProfile');
    Route::resource('feedbacks',FeedBackController::class)->middleware(['IsCustomer']);
});



Route::middleware(['IsCustomer','auth'])->group(function(){
    Route::resource("bookings",BookingController::class);
    Route::get('bookings/download/{booking}',[BookingController::class,'download'])->name('bookings.download');
    Route::get('/customer/dashboard',[CustomerController::class,'dashboard'])->name('customers.dashboard');
    Route::get('/customer/cancelBookings',[CustomerController::class,'cancelBookings'])->name('customers.cancelBookings');
    Route::get('/customer/giveEventFeedback',[CustomerController::class,'giveEventFeedback'])->name('customers.giveEventFeedback');
});

Route::middleware(['IsOrganizer','auth'])->group(function(){
    Route::resource('events',EventController::class)->withoutMiddlewareFor('show','IsOrganizer');
    Route::get('/organizer/dashboard',[OrganizerController::class,'dashboard'])->name('organizers.dashboard');
    Route::get('/organizer/createEvent',[OrganizerController::class,'createEvent'])->name('organizers.createEvent');
    Route::get('/organizer/manageEvent',[OrganizerController::class,'manageEvent'])->name('organizers.manageEvent');
    Route::get('/organizer/viewFeedback',[OrganizerController::class,'viewFeedback'])->name('organizers.viewFeedback');


});



