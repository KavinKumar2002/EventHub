<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;

use App\Http\Controllers\studentcontroller;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|ph
*/

Route::get('/', function () {
    if (session('name1')) {
        echo '<script>window.location.href = "/Dashboard";</script>';
    } else {
        echo '<script>window.location.href = "/UserLogin";</script>';
    }
});
Route::view('/SLogin','slogin');
Route::post('slogged',[studentcontroller::class,'login']);
Route::view('/SRegister','sreg');
Route::post('stRegister',[studentcontroller::class,'register']);
Route::get('sprofile',[studentcontroller::class,'profile']);
Route::get('/sDashboard',[studentcontroller::class,'sDashboard']);
Route::get('sReg/{regno}',[studentcontroller::class,'sReg']);
Route::get('/UserRegister', function () {
    if (session('name1')) {
        return redirect('Dashboard');
    } else {
        return view('userRegister');
    }
});
Route::get('/UserLogin', function () {
    if (session('name1')) {
        echo '<script>window.location.href = "/Dashboard";</script>';
    } else {
        return view('userLogin');
    }
});
Route::get('/Logout',function(){
    Session::pull('role');
    Session::pull('collegecode');
    Session::pull('name1');
    return redirect('UserLogin');
});
Route::view('sidebar','sidebar');
Route::post('/URegister',[AuthController::class,'UserRegister']);
Route::post('/ULogin',[AuthController::class,'UserLogin']);
Route::get('/Dashboard', function () {
    if (session('name1')) {
        $eventController = new EventController();
        return $eventController->dashboard();
    } else {
        return view('userLogin');
    }
});



Route::view('/Sidebar','sidebar');
Route::get('/CompletedFest',[EventController::class,'completed']);

Route::get('CreateFest', function() {
    $role = session('role');

if ($role == 'Admin') {
    
    return view('createFest');
} else {
    return view('401');
}

});
Route::view('/ssidebar','studbar');
Route::get('/slogout', function(){
    Session::pull('email');
    Session::pull('collegecode');
    Session::pull('department');
    Session::pull('regno');
    Session::pull('name');
  
    return view('SLogin');
});

Route::post('AssignFest',[EventController::class,'Assign']);
Route::get('/AssignedFest',[EventController::class,'Assigned']);
Route::get('/Edit/Event/{fest}/{name}', [EventController::class, 'EditEvent']);
Route::get('/Delete/Event/{fest}/{id}/{name}',[EventController::class,'DeleteEvent']);
Route::get('/View/{fest}',[EventController::class,'Viewfest']);
Route::get('/fest/Event/{fest}',[EventController::class,'Festdata']);
Route::get('/certificate/{fest}', [EventController::class, 'download'])->name('certificate.download');

Route::post('/events',[EventController::class,'events']);
Route::post('/eventsedit',[EventController::class,'EventsEdit']);
Route::get('/fest/StudentGet/{fest}',[EventController::class,'StudentFest']);
Route::post('/fest/StudentPost',[EventController::class,'StudentFestPost']);
Route::get('/Mark/{fest}/{event}',[EventController::class,'Allocate']);
Route::view('404','404');
Route::get('/Result/Event/{fest}/{name}',[EventController::class,'result']);
Route::post('/allocatemarks',[EventController::class,'allocatemarks']);

//student side
Route::get('/sfest/details/{fest}/{department}',[studentcontroller::class,'festdetails']);
Route::get('/eventregister/{fest}/{department}',[studentcontroller::class,'geteventregister']);
Route::post('/registrations',[studentcontroller::class,'registrations']);
Route::get('/indreg/{fest}/{name}',[studentcontroller::class,'indreg']);
Route::post('/individualregistration',[studentcontroller::class,'individualregistration']);
Route::get('/grpreg/{fest}/{name}',[studentcontroller::class,'grpreg']);
Route::post('/group',[studentcontroller::class,'teams']);
Route::post('/teamupdate',[studentcontroller::class,'teamsupdate']);
Route::post('/groupregistration',[studentcontroller::class,'groupregistration']);
Route::get('/checkmarks',[EventController::class,'checkmarks'] );

Route::post('/generateCertificate',[EventController::class,'generateCertificate']);
Route::get('/plans/{fest}',[studentController::class,'plans']);
Route::post('/payverify/{fest}',[studentController::class,'pay']);
Route::get('/verify/{fest}',[EventController::class,'verify']);
Route::post('/verifyupdate/{fest}/{regno}/{package}',[EventController::class,'verifyupdate']);
Route::get('/indsearch',[EventController::class,'indsearch']);
Route::get('/teamsearch',[EventController::class,'teamsearch']);
Route::get('/viewfull',[EventController::class,'viewfull']);
Route::post('/addexieve',[EventController::class,'addexieve']);
Route::post('/removeexieve',[EventController::class,'removeexieve']);
Route::post('/addexiteameve',[EventController::class,'addexiteameve']);
Route::post('/removeexiteameve',[EventController::class,'removeexiteameve']);
