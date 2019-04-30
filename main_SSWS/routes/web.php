<?php

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

Route::group([ 'domain' => 'admin.localhost' ], function () {
    Route::group(['middleware' => ['checkadmin']], function () {

        Route::get('layout', function () {
            return view('admin.admin_layout');
        });

        Route::get('AdminHome','AdminLeaveController@DisplayPendingLeave');

        Route::get('adminLogout','AdminLogin@userLogout');

        Route::get('display','AdminLeaveController@DisplayPendingLeave');

        Route::post('show','AdminLeaveController@Show');

        Route::post('approve','AdminLeaveController@Approve');

        Route::post('reject','AdminLeaveController@Reject');

        Route::get('search', 'SearchController@index');
        Route::get('/search/action', 'SearchController@action')->name('search.action');

        Route::post('/getinfo', 'SearchController@getInfo');

        Route::post('/edit', 'SearchController@edit');

        Route::post('/update', 'SearchController@update');

        Route::post('/delete', 'SearchController@delete');

        Route::get('manage', function () {
            return view('admin.manage');
        });

        Route::get('/manageStudent', function () {
            return view('admin.manage_student');
        });

        Route::get('/manageFaculty', function () {
            return view('admin.manage_faculty');
        });

        Route::post('addStudent','AdminLogin@addStudent');

        Route::post('addFaculty','AdminLogin@addFaculty');

        Route::get('report', 'ReportController@index');

        Route::post('getReport', 'ReportController@report');

        Route::get('pdf', 'ReportController@pdf');
    });

    Route::get('/', function () {
        return view('admin.login');
    });

    Route::post('AdminLogin','AdminLogin@login');

});

// .....................USER..............................................................
Route::group([ 'domain' => 'student.localhost' ], function () {
    Route::group(['middleware' => ['checkuser']], function () {

        Route::get('home','SLeaveController@home');

        Route::post('SubmitLeave','SLeaveController@submit');

        Route::get('profile','SLeaveController@profile');

        Route::get('userLogout','UserLogin@userLogout');

        Route::get('leave', function () {
            return view('user.leave_application');
        });

        Route::get('setting', function () {
            return view('user.setting');
        });

        Route::post('changePassword','StudentController@changePassword');

        Route::post('notification','NotificationController@studentNotification');


        Route::post('leaveinfo','SLeaveController@DisplayLeaveInfo');

    });

    Route::get('/', function () {
        return view('user.welcomepage');
    });

    Route::get('register', function () {
        return view('user.registration');
    });

    Route::post('submitted','StudentController@registeration');

    Route::post('otp','StudentController@otp');

	Route::post('resendotp','StudentController@resendotp');

    Route::post('UserLogin','StudentController@login');

    Route::post('forgotpassword','StudentController@forgotpassword');

});
//________________________________________________________________________________________


// .....................GATEKEEPER..............................................................

Route::group([ 'domain' => 'gatekeeper.localhost' ], function () {
    Route::group(['middleware' => ['gatekeeper']], function () {

        Route::get('home',function () {
            return view('gatekeeper.home');
        });

        Route::get('logout','GateKeeperController@logout');

        Route::post('checkStudent','GateKeeperController@checkStudent');

        Route::get('result',function () {
            return view('gatekeeper.result');
        });


    });

    Route::get('/', function () {
        return view('gatekeeper.login');
    });

    Route::post('Glogin','GateKeeperController@login');

});


//________________________FACULTY__________________________________________________

Route::group([ 'domain' => 'faculty.localhost' ], function () {
    Route::group(['middleware' => ['faculty']], function () {


    Route::get('register', function () {
        return view('faculty.register');
    });

    Route::post('doRegister','FacultyController@register');


    Route::get('home','FacultyController@home');

    Route::get('profile','FacultyController@profile');

    Route::post('forgotpassword','FacultyController@forgotpassword');

    Route::get('getmsg','FacultyLeaveController@getTypeofLeaveResult');

    Route::post('leavedetails','FacultyLeaveController@LeaveDetails');


    Route::get('hello1', function () {
        return view('faculty.testing');
    });

    Route::get('leave', function () {
        return view('faculty.leaveApplication');
    });

    Route::get('setting', function () {
        return view('faculty.setting');
    });

    Route::post('changePassword','FacultyController@changePassword');

    Route::get('adjustlec','FacultyLeaveController@getLeaveResult');

    Route::post('submitleave','FacultyLeaveController@SubmitLeave');

    Route::post('acceptLeave','FacultyLeaveController@acceptLeave');

    Route::post('rejectLeave','FacultyLeaveController@rejectLeave');

    Route::get('proof','HodLeaveController@proof');


    });

    Route::get('/', function () {
        return view('faculty.login');
    });

    Route::post('doLogin','FacultyController@login');

    Route::post('facultyotp','FacultyController@facultyotp');

    Route::post('facultyresendotp','FacultyController@facultyresendotp');

    Route::post('fp','FacultyController@fp');

    Route::post('change','FacultyController@change');

    Route::post('frotp','FacultyController@frotp');

    Route::get('userLogout','FacultyController@userLogout');

});




//________________________HOD start__________________________________________________
Route::group([ 'domain' => 'hod.localhost' ], function () {

    Route::group(['middleware' => ['hod']], function () {


        Route::get('layout', function () {
            return view('hod.hod_layout');
        });

        Route::get('home','HodLeaveController@DisplayPendingLeave');

        Route::get('HodLogout','HodLogin@userLogout');

        Route::get('display','HodLeaveController@DisplayPendingLeave');

        Route::post('show','HodLeaveController@Show');

        Route::post('approve','HodLeaveController@Approve');

        Route::post('reject','HodLeaveController@Reject');

        Route::get('search', 'HodSearchController@index');
        Route::get('/search/action', 'HodSearchController@action')->name('search.action');

        Route::post('/getinfo', 'HodSearchController@getInfo');

        Route::post('/getfacultyinfo', 'HodSearchController@getFacultyInfo');

        Route::post('/edit', 'HodSearchController@edit');

        Route::post('/update', 'HodSearchController@update');

        Route::post('/delete', 'HodSearchController@delete');

        Route::get('manage', function () {
            return view('hod.manage');
        });


        Route::get('leave', function () {
            return view('hod.leaveApplication');
        });

        Route::get('getmsg','HodLeaveController@getTypeofLeaveResult');

        Route::get('adjustlec','HodLeaveController@getLeaveResult');

        Route::post('submitleave','HodLeaveController@SubmitLeave');

        Route::get('report', 'HodReportController@index');

        Route::post('getReport', 'HodReportController@report');

        Route::get('pdf', 'HodReportController@pdf');

        Route::post('acceptLeave','FacultyLeaveController@acceptLeave');

        Route::post('rejectLeave','FacultyLeaveController@rejectLeave');

        Route::post('showFacultyLeave','HodLeaveController@ShowFacultyLeave');

        Route::post('accpetFacultyLeave','HodLeaveController@accpetFacultyLeave');

        Route::post('rejectFacultyLeave','HodLeaveController@rejectFacultyLeave');

        Route::get('proof','HodLeaveController@proof');

    });

    Route::get('/', function() {
        return view('hod.login');
     });

    Route::post('HodLogin','HodLogin@login');

});


//________________________HOD end__________________________________________________


//________________________Director start__________________________________________________
Route::group([ 'domain' => 'director.localhost' ], function () {

    Route::group(['middleware' => ['director']], function () {

    Route::get('home','DirectorController@home');

    Route::get('DirectorLogout','DirectorController@logout');

    Route::post('show','DirectorController@show');

    Route::post('accpetFacultyLeave','DirectorController@accpetFacultyLeave');

    Route::post('rejectFacultyLeave','DirectorController@rejectFacultyLeave');

    Route::get('search', 'DirectorSearchController@index');
    Route::get('/search/action', 'DirectorSearchController@action')->name('search.action');

    Route::post('/getinfo', 'DirectorSearchController@getInfo');

    Route::post('/getfacultyinfo', 'DirectorSearchController@getFacultyInfo');

    Route::post('showFacultyLeave','DirectorSearchController@ShowFacultyLeave');

    Route::get('proof','HodLeaveController@proof');


    });

    Route::get('/', function() {
        return view('director.login');
     });

     Route::post('DirectorLogin','DirectorController@login');

});



//________________________Director end__________________________________________________
