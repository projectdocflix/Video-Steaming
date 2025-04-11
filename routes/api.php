<?php

use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Api\Admin\CouponController;
use App\Http\Controllers\Api\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Api\Admin\CourseLanguageController;
use App\Http\Controllers\Api\Admin\difficultyLevelController;
use App\Http\Controllers\Api\Admin\InstructorController;
use App\Http\Controllers\Api\Admin\LanguageController;
use App\Http\Controllers\Api\Admin\PayoutController;
use App\Http\Controllers\Api\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Api\Admin\PromotionController;
use App\Http\Controllers\Api\Admin\RankingLevelController;
use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Api\Admin\SubcategoryController;
use App\Http\Controllers\Api\Admin\TagController;
use App\Http\Controllers\Api\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Frontend\ConsultationController;
use App\Http\Controllers\Api\Frontend\CourseController;
use App\Http\Controllers\Api\Frontend\HomeController;
use App\Http\Controllers\Api\Frontend\PageController;
use App\Http\Controllers\Api\Instructor\ConsultationController as InstructorConsultationController;
use App\Http\Controllers\Api\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Api\Instructor\ExamController;
use App\Http\Controllers\Api\Instructor\ResourceController;
use App\Http\Controllers\Api\Instructor\StudentController;
use App\Http\Controllers\Api\Instructor\CertificateController;
use App\Http\Controllers\Api\Instructor\DashboardController;
use App\Http\Controllers\Api\Instructor\LessonController;
use App\Http\Controllers\Api\Instructor\ProfileController as InstructorProfileController;
use App\Http\Controllers\Api\PaymentConfirmController;
use App\Http\Controllers\Api\Student\MyCourseController;
use App\Http\Controllers\Api\Student\CartManagementController;
use App\Http\Controllers\Api\Student\PaymentController;
use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\Student\WishlistController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/settings', [HomeController::class, 'settings']);
Route::post('social-login', [AuthController::class, 'socialLogin']);

//home section start
Route::get('home/', [HomeController::class, 'index']);
Route::get('home/courses', [HomeController::class, 'courses']);
Route::get('home/upcoming-courses', [HomeController::class, 'upcomingCourses']);
Route::get('home/bundle-courses', [HomeController::class, 'bundleCourses']);
Route::get('home/instructors', [HomeController::class, 'instructors']);
Route::get('home/consultation-instructors', [HomeController::class, 'consultationInstructors']);
Route::get('home/faq-questions', [HomeController::class, 'faqQuestions']);
Route::get('home/clients', [HomeController::class, 'clients']);
Route::get('home/subscriptions', [HomeController::class, 'subscriptions']);
Route::get('home/saas', [HomeController::class, 'saas']);
Route::get('home/category-course', [HomeController::class, 'categoryList']);
Route::get('home/category-course/{slug}', [HomeController::class, 'categoryCourse']);
Route::get('get-instructor/{user_id}', [HomeController::class, 'instructorDetails']);
// End:: home section


//Consultation section start
Route::get('get-consultation-details/{user_id}', [ConsultationController::class, 'consultationDetails']);
Route::get('get-consultation-booking-times', [ConsultationController::class, 'getInstructorBookingTime']);
//End consultation section

//pages
Route::get('about-us', [PageController::class, 'aboutUs']);
Route::get('contact-us', [PageController::class, 'contactUs']);
Route::post('contact-store', [PageController::class, 'contactUsStore']);
Route::get('faq', [PageController::class, 'faq']);
Route::get('terms-conditions', [PageController::class, 'termConditions'])->withoutMiddleware('private.mode');
Route::get('privacy-policy', [PageController::class, 'privacyPolicy'])->withoutMiddleware('private.mode');
Route::get('cookie-policy', [PageController::class, 'cookiePolicy'])->withoutMiddleware('private.mode');
Route::get('refund-policy', [PageController::class, 'refundPolicy'])->withoutMiddleware('private.mode');
Route::get('support-ticket-faq', [PageController::class, 'supportTicketFAQ']);
//end pages

//currency

Route::get('/get-current-currency', [HomeController::class, 'getCurrentCurrency']);
Route::get('/languages', [HomeController::class, 'getLanguage']);
Route::get('/language-data/{code?}', [HomeController::class, 'getLanguageJson']);


Route::get('/get-country', [HomeController::class, 'getCountry']);
Route::get('/get-state/{country_id}', [HomeController::class, 'getState']);
Route::get('/get-city/{state_id}', [HomeController::class, 'getCity']);


// Start:: Course
Route::get('courses', [CourseController::class, 'allCourses']);
Route::get('courses-list', [CourseController::class, 'getCourse']);
Route::get('course-details/{slug}', [CourseController::class, 'courseDetails']);
Route::get('course-details/{slug}/{type?}', [CourseController::class, 'courseDetails']);

Route::get('bundle-list', [CourseController::class, 'getBundleCourseList']);
Route::get('bundle-details/{slug}', [CourseController::class, 'bundleDetails']);

Route::get('upcoming-list', [CourseController::class, 'getUpcomingCourseList']);

Route::get('instructor-list', [CourseController::class, 'getInstructorList']);

Route::get('consultation-instructor-list', [ConsultationController::class, 'consultationInstructorList']);

Route::get('category/courses/{slug}', [CourseController::class, 'categoryCourses']);
Route::get('subcategory/courses/{slug}', [CourseController::class, 'subCategoryCourses']);

Route::get('get-sub-category-courses/fetch-data', [CourseController::class, 'paginationFetchData']);
Route::get('get-filter-courses', [CourseController::class, 'getFilterCourse']);

Route::get('search-course-list', [CourseController::class, 'searchCourseList']);


Route::match(array('GET','POST'), '/payment-order-notify/{id}', [PaymentConfirmController::class, 'paymentOrderNotifier'])->name('api.payment-order-notify');
// End:: Course


Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'student', 'middleware' => ['student', 'local']], function () {
        Route::get('my-learning', [MyCourseController::class, 'myLearningCourseList']);
        Route::get('my-consultation', [MyCourseController::class, 'myConsultationList']);
        Route::get('my-course/{slug}/{type?}', [MyCourseController::class, 'myCourseShow'])->middleware('course.access');
        Route::post('review-store', [MyCourseController::class, 'reviewCreate']);
        Route::get('my-given-review/{course_id}', [MyCourseController::class, 'myGivenReview']);
        Route::get('profile', [ProfileController::class, 'profile']);
        Route::post('save-profile/{uuid}', [ProfileController::class, 'saveProfile']);
        Route::post('change-password', [ProfileController::class, 'changePasswordUpdate']);
        Route::get('cart-list', [CartManagementController::class, 'cartList']);
        Route::get('cart-count', [CartManagementController::class, 'cartCount']);
        Route::post('add-to-cart', [CartManagementController::class, 'addToCart']);
        Route::post('add-to-cart-consultation', [CartManagementController::class, 'addToCartConsultation']);
        Route::post('apply-coupon', [CartManagementController::class, 'applyCoupon']);
        Route::delete('cart-delete/{id}', [CartManagementController::class, 'cartDelete']);
        Route::get('wishlist', [WishlistController::class, 'wishlist']);
        Route::post('add-to-wishlist', [WishlistController::class, 'addToWishlist']);
        Route::delete('wishlist-delete/{id}', [WishlistController::class, 'wishlistDelete']);
        Route::get('become-an-instructor', [ProfileController::class, 'becomeAnInstructor']);
        Route::post('save-instructor-info', [ProfileController::class, 'saveInstructorInfo']);

        Route::get('checkout', [CartManagementController::class, 'checkout']);
        Route::post('pay', [CartManagementController::class, 'pay']);

        //live classes
        Route::get('live-class/{slug}', [MyCourseController::class, 'liveClass']);
        Route::get('progress/{slug}', [MyCourseController::class, 'courseProgress']);
        Route::get('done-lectures/{slug}', [MyCourseController::class, 'doneLectures']);
        Route::get('next-lecture/{slug}', [MyCourseController::class, 'nextLecture']);
        Route::post('complete-lecture', [MyCourseController::class, 'completeLecture']);

        Route::post('discussion-create', [MyCourseController::class, 'discussionCreate']);
        Route::post('discussion-reply/{discussionId}', [MyCourseController::class, 'discussionReply']);


        Route::get('get-payment-gateway-list', [PaymentController::class, 'gatewayList']);
        Route::get('get-active-bank', [PaymentController::class, 'getActiveBank']);

        //Quiz section start
        Route::post('save-quiz-answer', [MyCourseController::class, 'saveExamAnswer']);
        Route::get('quiz-leaderboard/{course_uuid}/{quiz_id}', [MyCourseController::class, 'getLeaderBoard']);
        Route::get('quiz-details/{course_uuid}/{quiz_id}', [MyCourseController::class, 'getDetails']);
        Route::get('quiz-result/{course_uuid}/{quiz_id}', [MyCourseController::class, 'getResult']);
        //End Quiz section

        //assignment
        Route::get('assignment-details', [MyCourseController::class, 'assignmentDetails']);
        Route::get('assignment-result', [MyCourseController::class, 'assignmentResult']);
        Route::post('assignment-submit/{course_id}/{assignment_id}', [MyCourseController::class, 'assignmentSubmitStore']);
        //End assignment

    });


    Route::group(['prefix' => 'instructor', 'middleware' => ['instructor', 'local']], function () {

        Route::post('save-profile', [InstructorProfileController::class, 'saveProfile']);
        Route::get('dashboard', [DashboardController::class, 'dashboard']);
        Route::group(['prefix' => 'certificates'], function () {
            Route::get('/', [CertificateController::class, 'index']);
            Route::get('add/{course_uuid}', [CertificateController::class, 'add']);
            Route::post('set-for-create/{course_uuid}', [CertificateController::class, 'setForCreate']);
            Route::post('store/{course_uuid}/{certificate_uuid}', [CertificateController::class, 'store']);
            Route::get('view/{uuid}', [CertificateController::class, 'view']);
        });

        Route::group(['prefix' => 'consultation'], function () {
            Route::get('/', [InstructorConsultationController::class, 'dashboard']);
            Route::post('instructor-availability-store-update', [InstructorConsultationController::class, 'instructorAvailabilityStoreUpdate']);
            Route::post('slotStore', [InstructorConsultationController::class, 'slotStore']);
            Route::get('slot-view/{day}', [InstructorConsultationController::class, 'slotView']);
            Route::delete('slot-delete/{id}', [InstructorConsultationController::class, 'slotDelete']);
            Route::get('day-available-status-change/{day}', [InstructorConsultationController::class, 'dayAvailableStatusChange']);
        });

        Route::get('booking-request', [InstructorConsultationController::class, 'bookingRequest']);
        Route::post('cancel-reason/{uuid}', [InstructorConsultationController::class, 'cancelReason']);
        Route::get('booking-history', [InstructorConsultationController::class, 'bookingHistory']);
        Route::get('booking-status/{uuid}/{status}', [InstructorConsultationController::class, 'bookingStatus']);
        Route::post('booking-meeting-create/{uuid}', [InstructorConsultationController::class, 'bookingMeetingStore']);

        Route::get('all-enroll', [StudentController::class, 'allStudentIndex']);

        Route::prefix('course')->group(function () {
            Route::get('/', [InstructorCourseController::class, 'index']);
            Route::post('store', [InstructorCourseController::class, 'store']);
            Route::post('update-category/{uuid}', [InstructorCourseController::class, 'updateCategory']);

            Route::prefix('lesson')->group(function () {
                Route::post('store/{course_uuid}', [LessonController::class, 'store']);
                Route::post('store-lecture/{course_uuid}/{lesson_uuid}', [LessonController::class, 'storeLecture']);
            });

            Route::post('store-instructor/{course_uuid}', [InstructorCourseController::class, 'storeInstructor']);
            Route::post('upload-finished/{uuid}', [InstructorCourseController::class, 'uploadFinished']);

            Route::group(['prefix' => 'resource'], function () {
                Route::get('index/{course_uuid}', [ResourceController::class, 'index']);
                Route::post('store/{course_uuid}', [ResourceController::class, 'store']);
            });

            Route::prefix('exam')->group(function () {
                Route::get('/{course_uuid}', [ExamController::class, 'index']);
                Route::post('store/{course_uuid}', [ExamController::class, 'store']);
                Route::post('save-mcq-question/{exam_uuid}', [ExamController::class, 'saveMcqQuestion']);
                Route::post('save-true-false-question/{exam_uuid}', [ExamController::class, 'saveTrueFalseQuestion']);
            });
        });
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'local']], function () {

        Route::get('dashboard', [DashboardController::class, 'dashboard']);

        Route::prefix('profile')->group(function () {
            Route::post('change-password', [AdminProfileController::class, 'changePasswordUpdate']);
            Route::post('update', [AdminProfileController::class, 'update']);
        });

        Route::prefix('course')->group(function () {
            Route::get('/', [AdminCourseController::class, 'index']);
            Route::get('approved', [AdminCourseController::class, 'approved']);
            Route::get('review-pending', [AdminCourseController::class, 'reviewPending']);
            Route::get('hold', [AdminCourseController::class, 'hold']);
            Route::get('enroll', [AdminCourseController::class, 'courseEnroll']);
            Route::post('enroll', [AdminCourseController::class, 'courseEnrollStore']);
        });

        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::post('store', [CategoryController::class, 'store']);
            Route::post('update/{uuid}', [CategoryController::class, 'update']);
        });

        Route::prefix('subcategory')->group(function () {
            Route::get('/', [SubcategoryController::class, 'index']);
            Route::post('store', [SubcategoryController::class, 'store']);
            Route::post('update/{uuid}', [SubcategoryController::class, 'update']);
        });

        Route::prefix('tag')->group(function () {
            Route::get('/', [TagController::class, 'index']);
            Route::post('store', [TagController::class, 'store']);
            Route::post('update/{uuid}', [TagController::class, 'update']);
        });

        Route::prefix('course-language')->group(function () {
            Route::get('/', [CourseLanguageController::class, 'index']);
            Route::post('store', [CourseLanguageController::class, 'store']);
            Route::post('update/{uuid}', [CourseLanguageController::class, 'update']);
        });

        Route::prefix('difficulty-level')->group(function () {
            Route::get('/', [difficultyLevelController::class, 'index']);
            Route::post('store', [difficultyLevelController::class, 'store']);
            Route::post('update/{uuid}', [difficultyLevelController::class, 'update']);
        });

        Route::prefix('instructor')->group(function () {
            Route::get('/', [InstructorController::class, 'index']);
            Route::get('pending', [InstructorController::class, 'pending']);
            Route::get('approved', [InstructorController::class, 'approved']);
            Route::get('blocked', [InstructorController::class, 'blocked']);
            Route::get('create', [InstructorController::class, 'create']);
            Route::post('store', [InstructorController::class, 'store']);
            Route::get('view/{uuid}', [InstructorController::class, 'view']);
            Route::post('update/{uuid}', [InstructorController::class, 'update']);
        });

        Route::prefix('student')->group(function () {
            Route::get('/', [AdminStudentController::class, 'index']);
            Route::post('store', [AdminStudentController::class, 'store']);
            Route::get('view/{uuid}', [AdminStudentController::class, 'view']);
            Route::post('update/{uuid}', [AdminStudentController::class, 'update']);
        });

        Route::group(['prefix' => 'promotions'], function () {
            Route::get('/', [PromotionController::class, 'index']);
            Route::post('store', [PromotionController::class, 'store']);
            Route::post('update/{uuid}', [PromotionController::class, 'update']);
            Route::get('edit-promotion-course/{uuid}', [PromotionController::class, 'editPromotionCourse']);
            Route::post('add-promotion-course-list', [PromotionController::class, 'addPromotionCourseList']);
            Route::post('remove-promotion-course-list', [PromotionController::class, 'removePromotionCourseList']);
        });

        Route::group(['prefix' => 'coupon'], function () {
            Route::get('/', [CouponController::class, 'index']);
            Route::post('store', [CouponController::class, 'store']);
            Route::post('update/{uuid}', [CouponController::class, 'update']);
        });

        Route::group(['prefix' => 'payout'], function () {
            Route::get('new-withdraw', [PayoutController::class, 'newWithdraw']);
            Route::get('complete-withdraw', [PayoutController::class, 'completeWithdraw']);
            Route::get('rejected-withdraw', [PayoutController::class, 'rejectedWithdraw']);
        });

        Route::prefix('report')->group(function () {
            Route::get('course-revenue-report', [ReportController::class, 'revenueReportCoursesIndex']);
            Route::get('order-report', [ReportController::class, 'orderReportIndex']);
            Route::get('order-pending', [ReportController::class, 'orderReportPending']);
            Route::get('order-cancelled', [ReportController::class, 'orderReportCancelled']);
            Route::get('consultation-revenue-report', [ReportController::class, 'revenueReportConsultationIndex']);
            Route::get('cancel-consultation-list', [ReportController::class, 'cancelConsultationList']);
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('store', [UserController::class, 'store']);
            Route::post('update/{id}', [UserController::class, 'update']);
        });

        Route::group(['prefix' => 'role'], function () {
            Route::get('/', [RoleController::class, 'index']);
            Route::get('create', [RoleController::class, 'create']);
            Route::post('store', [RoleController::class, 'store']);
            Route::get('edit/{id}', [RoleController::class, 'edit']);
            Route::post('update/{id}', [RoleController::class, 'update']);
        });

        Route::group(['prefix' => 'settings'], function () {
            Route::post('general-settings-update', [SettingController::class, 'GeneralSettingUpdate']);
            Route::post('storage-settings-update', [SettingController::class, 'storageSettingsUpdate']);
            Route::get('payment-method', [SettingController::class, 'paymentMethod']);
        });

        Route::prefix('language')->group(function () {
            Route::get('/', [LanguageController::class, 'index']);
            Route::post('store', [LanguageController::class, 'store']);
            Route::post('update/{id}', [LanguageController::class, 'update']);
            Route::post('import',[LanguageController::class, 'import']);
            Route::post('update-language/{id}',[LanguageController::class, 'updateLanguage']);
        });

        Route::group(['prefix' => 'badge'], function () {
            Route::get('index', [RankingLevelController::class, 'index']);
            Route::post('update/{badge:uuid}', [RankingLevelController::class, 'update']);
        });

        Route::group(['prefix' => 'certificate'], function () {
            Route::get('/', [AdminCertificateController::class, 'index']);
            Route::post('store', [AdminCertificateController::class, 'store']);
            Route::post('update/{uuid}', [AdminCertificateController::class, 'update']);
        });

    });
});

