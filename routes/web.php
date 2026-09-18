<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CancellationController;
use App\Http\Controllers\ClassInstanceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\MoniterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SecheduleController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainerDashboardController;
use App\Models\ClassInstance;
use App\Models\Plan;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // we will send data here instead of create controller for this fucntion only 
    $trainers = Trainer::with('courses')->orderBy('rate', 'desc')->where('status', 1)
        ->take(3)
        ->get();
    foreach ($trainers as $trainer) {
        $trainer['course_names_string'] = $trainer->courses->pluck('name')->implode(', ');
    }
    return view('welcome', ['trainers' => $trainers]);
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout (accessible when authenticated)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {

    // Role-based dashboard routing
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::user()->role === 'user') {
            return redirect()->route('user.dashboard');
        }
        if (Auth::user()->role === 'trainer') {
            return redirect()->route('trainer.dashboard');
        }
        return redirect()->route('member.dashboard');
    })->name('dashboard');

    // User dashboard
    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])
        ->name('user.dashboard')
        ->middleware('role:user');

    // Member dashboard
    Route::middleware(['auth'])->prefix('member')->name('member.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [MemberDashboardController::class, 'memberDashboard'])->name('dashboard');

        // Profile
        Route::get('/profile', [MemberDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [MemberDashboardController::class, 'updateProfile'])->name('profile.update');

        // Attendance
        Route::get('/attendance', [MemberDashboardController::class, 'attendance'])->name('attendance');
        Route::post('/checkin/{classInstanceId}', [MemberDashboardController::class, 'checkIn'])->name('checkin');

        // Schedule
        Route::get('/schedule', [MemberDashboardController::class, 'schedule'])->name('schedule');
    });

    // Admin dashboard and management
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::get('/users', [DashboardController::class, 'manageUsers'])->name('users.index');

        /* Route::get('/moniter', [MoniterController::class, 'index'])->name('moniter'); */
        Route::get('/monitor', [AdminController::class, 'monitor'])->name('monitor');

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminController::class, 'usersIndex'])->name('index');
            Route::get('/create', [AdminController::class, 'usersCreate'])->name('create');
            Route::post('/', [AdminController::class, 'usersStore'])->name('store');
            Route::get('/{id}/edit', [AdminController::class, 'usersEdit'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'usersUpdate'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'usersDestroy'])->name('destroy');
            Route::post('/{id}/toggle-status', [AdminController::class, 'usersToggleStatus'])->name('toggle-status');
        });

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');
        // Inactive Users Management
        Route::get('/inactive-users', [AdminController::class, 'inactiveUsers'])->name('inactive.users');
        Route::post('/user/activate/{id}', [AdminController::class, 'activateUser'])->name('user.activate');

        // More admin routes here...
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



    Route::get('/member', [MemberController::class, 'index'])->name('member.index');
    Route::get('/member/details', [MemberController::class, 'get_details'])->name('member.get_details');
    Route::post('/member/search', [MemberController::class, 'search'])->name('member.search');

    Route::get('member/Show/{id}', [MemberController::class, 'show'])->name('member.show');
    Route::get('member/edit/{id}', [MemberController::class, 'edit'])->name('member.edit');


    Route::post('member/create/{id}', [MemberController::class, 'create'])->name('member.create');


    Route::post('member/{id}/book-class', [MemberController::class, 'bookClass'])->name('member.book-class');
    Route::delete('member/{memberId}/cancel-class/{scheduleId}', [MemberController::class, 'cancelClass'])->name('member.cancel-class');
    Route::post('member/{id}/update-progress', [MemberController::class, 'updateProgress'])->name('member.update-progress');


    Route::post('member/schedule', [MemberController::class, 'findOrCreateSchedule'])->name('schedule.available');

    Route::post('member/CheckExistsFirst', [MemberController::class, 'CheckExistsFirst'])->name('member.CheckExistsFirst');

    Route::post('member/store', [MemberController::class, 'store'])->name('member.store');

    Route::post('member/load_edit_row', [MemberController::class, 'load_edit_row'])->name('member.load_edit_row');

    Route::post('member/update', [MemberController::class, 'update'])->name('member.update');

    Route::post('member/destroy', [MemberController::class, 'destroy'])->name('member.destroy');

    // subscibe
    Route::get('member/subscibe/{id}', [MemberController::class, 'subscibe'])->name('member.subscibe');
    Route::get('member/membercourses', [MemberController::class, 'get_member_courses'])->name('member.MemberCourses');



    /* ------------------------- trainerse------------------------------------------- */
    Route::get('/trainers', [TrainerController::class, 'index'])->name('trainer.index');
    Route::get('/trainers/create', [TrainerController::class, 'create'])->name('trainer.create');
    Route::post('trainers/store', [TrainerController::class, 'store'])->name('trainer.store');
    Route::post('trainers/load-assign-form', [TrainerController::class, 'loadAssignForm'])->name('trainer.load_assign_form');
    Route::post('trainers/assign-courses', [TrainerController::class, 'assignCourses'])->name('trainer.assign_courses');
    Route::get('trainers/trainerClases/{id}', [TrainerController::class, 'specific_trainer_courss'])->name('trainer.trainerClases');
    Route::get('/trainers/{id}', [TrainerController::class, 'show'])->name('trainer.show');
    Route::get('/trainers/{id}/edit', [TrainerController::class, 'edit'])->name('trainer.edit');
    Route::put('/trainers/{id}', [TrainerController::class, 'update'])->name('trainer.update');
    Route::delete('/trainers/{id}', [TrainerController::class, 'destroy'])->name('trainer.destroy');


    /* ------------------------- Course------------------------------------------- */
    Route::get('/Course', [CourseController::class, 'index'])->name('Course.index');
    Route::get('/Course/create', [CourseController::class, 'create'])->name('Course.create');
    Route::post('Course/store', [CourseController::class, 'store'])->name('Course.store');



    /* ------------------------- Schedule------------------------------------------- */
    Route::get('Schedule/{course_id}/{trainerId?}/{memberId?}', [ScheduleController::class, 'member_schedule'])->name('Schedule.MemberSchedule');
    Route::get('/classInstance/createSchedule', [ScheduleController::class, 'create'])->name('classInstance.createSchedule');
    Route::get('/classInstance/createClassInstance', [ScheduleController::class, 'createClassInstance'])->name('classInstance.createClassInstance');
    Route::post('/classInstance/store', [ScheduleController::class, 'store'])->name('classInstance.store');
    Route::get('/classInstance/showToAdd/{scheduleId}', [ScheduleController::class, 'showToAdd'])->name('classInstance.showToAdd');

    Route::post('/classInstance/addMemberToExistingSchedule/{scheduleId}', [ScheduleController::class, 'addMemberToExistingSchedule'])->name('classInstance.addMemberToExistingSchedule');

    /* ------------------------- class Instance------------------------------------------- */

    // Attendance Routes
    Route::prefix('attendance')->name('attendance.')->group(function () {
        // Today's attendance
        Route::get('/today', [AttendanceController::class, 'today'])->name('today');

        // Calendar view
        Route::get('/calendar', [AttendanceController::class, 'calendar'])->name('calendar');

        // Member attendance history
        Route::get('/member/{memberId}', [AttendanceController::class, 'memberHistory'])->name('member');

        // Class instance attendance
        Route::get('/class/{classInstanceId}', [AttendanceController::class, 'classAttendance'])->name('class');

        // Mark attendance
        Route::post('/mark/{classInstanceId}', [AttendanceController::class, 'markAttendance'])->name('mark');

        // Bulk mark attendance
        Route::post('/bulk-mark', [AttendanceController::class, 'bulkMarkAttendance'])->name('bulk-mark');

        // Export attendance report
        Route::get('/export', [AttendanceController::class, 'export'])->name('export');

        // Attendance statistics
        Route::get('/statistics', [AttendanceController::class, 'statistics'])->name('statistics');

        // Check-in/Check-out API
        Route::post('/check-in/{classInstanceId}/{memberId}', [AttendanceController::class, 'checkIn'])->name('check-in');
        Route::post('/check-out/{classInstanceId}/{memberId}', [AttendanceController::class, 'checkOut'])->name('check-out');
    });

    // Equipment Management Routes
    Route::prefix('equipment')->name('equipment.')->group(function () {
        // Main equipment routes
        Route::get('/', [EquipmentController::class, 'index'])->name('index');
        Route::get('/create', [EquipmentController::class, 'create'])->name('create');
        Route::post('/', [EquipmentController::class, 'store'])->name('store');
        Route::get('/{id}', [EquipmentController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [EquipmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [EquipmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [EquipmentController::class, 'destroy'])->name('destroy');

        // Export
        Route::get('/export/csv', [EquipmentController::class, 'export'])->name('export');

        // Maintenance routes
        Route::get('/{id}/maintenance', [EquipmentController::class, 'maintenanceForm'])->name('maintenance.form');
        Route::post('/{id}/maintenance', [EquipmentController::class, 'scheduleMaintenance'])->name('maintenance.schedule');
        Route::put('/maintenance/{maintenanceId}/complete', [EquipmentController::class, 'completeMaintenance'])->name('maintenance.complete');
        Route::get('/maintenance/dashboard', [EquipmentController::class, 'maintenanceDashboard'])->name('maintenance.dashboard');

        // Assignment routes
        Route::get('/{id}/assign', [EquipmentController::class, 'assignForm'])->name('assign.form');
        Route::post('/{id}/assign', [EquipmentController::class, 'assign'])->name('assign');
        Route::post('/assignments/{assignmentId}/return', [EquipmentController::class, 'returnEquipment'])->name('return');

        // Category routes
        Route::get('/categories/list', [EquipmentController::class, 'categories'])->name('categories');
        Route::post('/categories', [EquipmentController::class, 'storeCategory'])->name('categories.store');
        Route::put('/categories/{id}', [EquipmentController::class, 'updateCategory'])->name('categories.update');
    });


    // ===========================================
    // REPORTS ROUTES
    // ===========================================
    Route::prefix('reports')->name('reports.')->group(function () {

        // Reports Dashboard
        Route::get('/', [ReportController::class, 'index'])->name('index');
        // =======================================
        // Member Reports
        // =======================================
        Route::prefix('member')->name('member.')->group(function () {
            Route::get('/attendance', [ReportController::class, 'memberAttendance'])->name('attendance');
            Route::get('/progress', [ReportController::class, 'memberProgress'])->name('progress');
            Route::get('/enrollment', [ReportController::class, 'memberEnrollment'])->name('enrollment');
        });

        // =======================================
        // Trainer Reports
        // =======================================
        Route::prefix('trainer')->name('trainer.')->group(function () {
            Route::get('/performance', [ReportController::class, 'trainerPerformance'])->name('performance');
            Route::get('/schedule', [ReportController::class, 'trainerSchedule'])->name('schedule');
            Route::get('/utilization', [ReportController::class, 'trainerUtilization'])->name('utilization');
        });

        // =======================================
        // Financial Reports
        // =======================================
        Route::prefix('financial')->name('financial.')->group(function () {
            Route::get('/revenue', [ReportController::class, 'financialRevenue'])->name('revenue');
            Route::get('/membership', [ReportController::class, 'financialMembership'])->name('membership');
            Route::get('/expenses', [ReportController::class, 'financialExpenses'])->name('expenses');
            Route::get('/profit-loss', [ReportController::class, 'financialProfitLoss'])->name('profit-loss');
        });

        // =======================================
        // Equipment Reports
        // =======================================
        Route::prefix('equipment')->name('equipment.')->group(function () {
            Route::get('/utilization', [ReportController::class, 'equipmentUtilization'])->name('utilization');
            Route::get('/maintenance', [ReportController::class, 'equipmentMaintenance'])->name('maintenance');
            Route::get('/inventory', [ReportController::class, 'equipmentInventory'])->name('inventory');
            Route::get('/cost-analysis', [ReportController::class, 'equipmentCostAnalysis'])->name('cost-analysis');
        });

        // =======================================
        // Operations Reports
        // =======================================
        Route::prefix('operations')->name('operations.')->group(function () {
            Route::get('/daily', [ReportController::class, 'dailyOperations'])->name('daily');
            Route::get('/occupancy', [ReportController::class, 'operationsOccupancy'])->name('occupancy');
            Route::get('/peak-hours', [ReportController::class, 'operationsPeakHours'])->name('peak-hours');
            Route::get('/utilization', [ReportController::class, 'operationsUtilization'])->name('utilization');
        });

        // =======================================
        // Analytics Reports
        // =======================================
        Route::prefix('analytics')->name('analytics.')->group(function () {
            Route::get('/retention', [ReportController::class, 'memberRetention'])->name('retention');
            Route::get('/popularity', [ReportController::class, 'classPopularity'])->name('popularity');
            Route::get('/trends', [ReportController::class, 'analyticsTrends'])->name('trends');
            Route::get('/forecast', [ReportController::class, 'analyticsForecast'])->name('forecast');
        });

        // =======================================
        // Export Routes
        // =======================================
        Route::post('/export', [ReportController::class, 'export'])->name('export');
        Route::get('/export/{type}/{format}', [ReportController::class, 'exportDirect'])->name('export.direct');

        // =======================================
        // Scheduled Reports
        // =======================================
        Route::get('/scheduled', [ReportController::class, 'scheduledReports'])->name('scheduled');
        Route::post('/schedule', [ReportController::class, 'scheduleReport'])->name('schedule');
        Route::delete('/schedule/{id}', [ReportController::class, 'deleteScheduledReport'])->name('schedule.delete');
    });


    Route::prefix('trainer')->name('trainer.')->middleware(['auth'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [TrainerDashboardController::class, 'dashboard'])->name('dashboard');

        // Schedule
        Route::get('/schedule', [TrainerDashboardController::class, 'schedule'])->name('schedule');

        // Classes
        Route::get('/class/{classId}', [TrainerDashboardController::class, 'classDetails'])->name('class.details');
        Route::post('/class/{classId}/attendance', [TrainerDashboardController::class, 'markAttendance'])->name('class.attendance');

        // Members
        Route::get('/members', [TrainerDashboardController::class, 'members'])->name('members');

        // Statistics
        Route::get('/statistics', [TrainerDashboardController::class, 'statistics'])->name('statistics');
    });

    // ===========================================
    // PAYMENT ROUTES
    // ===========================================
    Route::prefix('payments')->name('payments.')->middleware(['auth'])->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/create', [PaymentController::class, 'create'])->name('create');
        Route::get('/payment_list', [PaymentController::class, 'payment_list'])->name('payment_list');
        Route::get('/create_payment/{memberId}/{paymentId}', [PaymentController::class, 'create_payment'])->name('create_payment');
        Route::post('/store-for-course/{memberScheduleId}', [PaymentController::class, 'storeForCourse'])->name('storeForCourse');
        Route::get('/{id}', [PaymentController::class, 'show'])->name('show');
        Route::get('/receipt/{id}/download', [PaymentController::class, 'generateReceipt'])->name('receipt.download');
        Route::get('/receipt/{id}/view', [PaymentController::class, 'viewReceipt'])->name('receipt.view');
    });
    // ===========================================
    // CANCELLATION ROUTES
    // ===========================================
    Route::prefix('cancellation')->name('cancellation.')->middleware(['auth'])->group(function () {
        Route::get('/manage', [CancellationController::class, 'manage'])->name('manage');
        Route::get('/preview/{enrollmentId}', [CancellationController::class, 'refundPreview'])->name('refund.preview');
        Route::get('/form/{enrollmentId}', [CancellationController::class, 'showCancelForm'])->name('form');
        Route::post('/process/{enrollmentId}', [CancellationController::class, 'processCancellation'])->name('process');
        Route::get('/history', [CancellationController::class, 'history'])->name('history');
        Route::get('/refund/{refundId}', [CancellationController::class, 'refundDetails'])->name('refund.details');
    });
});
