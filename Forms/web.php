<?php
//  Admission
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use Illuminate\Contracts\Session\Session;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DueReportController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\UserManualController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\AccountsSetupController;
use App\Http\Controllers\Notice\NoticeController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\HOSApprovalMatrixController;
use App\Http\Controllers\HRM\ConveyanceBillController;
use App\Http\Controllers\HRM\EmployeePhoneBookController;
use App\Http\Controllers\HRM\HRMIncreamentPolicyController;
use App\Http\Controllers\Admin\Construction\ConstructionController;
use App\Http\Controllers\FinancialReportControllerV1;
use App\Http\Controllers\InvestigationCancelController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PatientRegistrationController;
use App\Http\Controllers\ReportController;
// use PatientAppointmentController;
use App\Http\Controllers\PabxAppointmentController;
use App\Http\Controllers\IPDFinancialReportController;
use App\Http\Controllers\DietNutritionController;
use App\Http\Controllers\DoctorReportController;
use App\Http\Controllers\BinCardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UniformController;
use App\Http\Controllers\FormTemplateController;
use App\Http\Controllers\DynamicFormController;
use App\Http\Controllers\FormFieldController;
use App\Http\Controllers\SurgicalChecklistController;
Auth::routes();
//online appointment
Route::get('/', 'SiteController@coverpage')->name('/');
Route::get('appointment-book', 'SiteController@app_page')->name('appointment-book');
Route::post('get-doctors-list-by-specl-for-online', 'SiteController@get_doctors_list_by_specl')->name('get-doctors-list-by-specl-for-online');
Route::post('get-doctor-appointment-info-online-form', 'SiteController@get_doctor_appointment_info')->name('get-doctor-appointment-info-online-form');
Route::post('get-doctor-appointment-info-online-form-cover', 'SiteController@get_doctor_appointment_info_cover')->name('get-doctor-appointment-info-online-form-cover');
Route::post('patient-info-autocomplete-online-form', 'SiteController@patientInfoAutocomplete')->name('patient-info-autocomplete-online-form');
Route::post('lookup-pres-data-autocomplete-for-online', 'SiteController@lookupPresDataAutocomplete')->name('lookup-pres-data-autocomplete-for-online');
Route::post('lookup-pres-data-autocomplete', 'LookupController@lookupPresDataAutocomplete')->name('lookup-pres-data-autocomplete');
Route::post('appointments-store', 'SiteController@appointments_store')->name('appointments-store');
Route::get('patient-appointment-print/{appointment_no_pk}', 'PatientAppointmentController@printPatientAppointment')->name('patient-appointment-print');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('billing/service-billing-v3/{id?}', 'BillingController@createServiceBillingV3')->name('billing.service-billing-v3');
Route::get('/emp-card-back-print', 'EmployeeController@empCardBackPrint')->name('emp-card-back-print');
Route::get('path/result-print-mail-delivery/{type?}', 'PathologyController@resultPrintSendMailDelivery')->name('path.result-print-mail-delivery');

Route::get('my-pc', function () {
    // return gethostname();
    // return php_uname('n');
    // $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    // return $hostname;
    // return request()->getClientIp();
    // return phpinfo();

    echo "Operating System: " . php_uname() . PHP_EOL . '<br>';
    echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . PHP_EOL . '<br>';
    echo "Memory Usage: " . (memory_get_usage(true) / 1024 / 1024) . " MB" . PHP_EOL . '<br>';

    // Disk Space
    echo "Total Disk Space: " . (disk_total_space("/") / 1024 / 1024 / 1024) . " GB" . PHP_EOL . '<br>';
    echo "Free Disk Space: " . (disk_free_space("/") / 1024 / 1024 / 1024) . " GB" . PHP_EOL . '<br>';

    // Loaded PHP Extensions
    echo "Loaded Extensions: " . implode(", ", get_loaded_extensions()) . PHP_EOL . '<br>';

    // Server IP Address
    // echo "Server IP Address: " . $_SERVER['SERVER_ADDR'] . PHP_EOL . '<br>';

    // Hostname
    echo "Hostname: " . gethostname() . PHP_EOL . '<br>';

    // CPU Info (Linux Systems Only)
    // if (PHP_OS_FAMILY === 'Linux') {
    //     $cpuInfo = file_get_contents('/proc/cpuinfo');
    //     echo "CPU Information: " . nl2br($cpuInfo) . PHP_EOL;
    // }
    return str_replace(array("\n", "\t", "\r", ' '), '', shell_exec('hostname-I2>&1'));
});

// end online appointment
Route::middleware(['auth', 'check_access'])->group(function () {

    Route::get('admission/{id?}', 'AdmissionController@index')->name('admission.index');
    Route::post('admission', 'AdmissionController@store')->name('admission.store');
    Route::get('admission/pdf/{admission_id}', 'AdmissionController@admissionPdf')->name('admission.pdf');

    Route::post('/pay', 'SslCommerzPaymentController@index')->name('pay');
    Route::post('/pay-via-ajax', 'SslCommerzPaymentController@payViaAjax');

    Route::post('/success', 'SslCommerzPaymentController@success');
    Route::post('/fail', 'SslCommerzPaymentController@fail');
    Route::post('/cancel', 'SslCommerzPaymentController@cancel');

    Route::post('/ipn', 'SslCommerzPaymentController@ipn');


    Route::get('cover-page', 'SiteController@coverPageV2')->name('cover-page-v2');
    Route::get('cover/doctor-list', 'SiteController@doctorList')->name('cover.doctor-list');
    Route::get('cover/hospital-list', 'SiteController@hospitalList')->name('cover.hospital-list');
    // Doctor List
    Route::post('cover/doctor-search-data-city', 'SiteController@doctorSearchDataCity')->name('cover.doctor-search-data-city');

    Route::post('cover/hospital-search-data-by-city', 'SiteController@hospitalSearchDataCity')->name('cover.hospital-search-data-by-city');
    Route::post('cover/doctor-search-data-dept', 'SiteController@doctorSearchDataDept')->name('cover.doctor-search-data-dept');

    Route::post('cover/hospital-search-dept', 'SiteController@hospitalSearchDataDept')->name('cover.hospital-search-dept');
    Route::post('cover/doctor-search-data-hospital', 'SiteController@doctorSearchDataHospital')->name('cover.doctor-search-data-hospital');

    Route::post('cover/hospital-search-hospital', 'SiteController@hospitalSearchDataHospital')->name('cover.hospital-search-hospital');
    Route::post('cover/doctor-search-data-city-checkbox', 'SiteController@doctorSearchDataCityCheckbox')->name('cover.doctor-search-data-city-checkbox');
    Route::post('cover/doctor-search-data-dept-checkbox', 'SiteController@doctorSearchDataDeptCheckbox')->name('cover.doctor-search-data-dept-checkbox');
    Route::post('cover/doctor-search-data-hospital-checkbox', 'SiteController@doctorSearchDataHospitalCheckbox')->name('cover.doctor-search-data-hospital-checkbox');
    Route::post('cover/doctor-search-data-country-checkbox', 'SiteController@doctorSearchDataCountryCheckbox')->name('cover.doctor-search-data-country-checkbox');

    Route::post('cover/hospital-search-data-country-checkbox', 'SiteController@hospitalSearchDataCountryCheckbox')->name('cover.hospital-search-data-country-checkbox');
    Route::post('cover/hospital-data-city-checkbox', 'SiteController@hospitalSearchDataCityCheckbox')->name('cover.hospital-data-city-checkbox');
    // Hospital List
    Route::post('cover/hospital-search-data-city', 'SiteController@hospitalSearchDataCity')->name('cover.hosptal-search-data-city');
    Route::post('cover/hospital-search-data-dept', 'SiteController@hospitalSearchDataDept')->name('cover.hosptal-search-data-dept');
    Route::post('cover/hospital-search-data-hospital', 'SiteController@hospitalSearchDataHospital')->name('cover.hosptal-search-data-hospital');
    Route::post('cover/hospital-search-data-city-checkbox', 'SiteController@hospitalSearchDataCityCheckbox')->name('cover.hosptal-search-data-city-checkbox');
    Route::post('cover/hospital-search-data-dept-checkbox', 'SiteController@hospitalSearchDataDeptCheckbox')->name('cover.hospital-data-dept-checkbox');
    Route::post('cover/hospital-data-hospital-checkbox', 'SiteController@hospitalSearchDataHospitalCheckbox')->name('cover.hospital-data-hospital-checkbox');
    Route::post('cover/hospital-search-data-country-checkbox', 'SiteController@hospitalSearchDataCountryCheckbox')->name('cover.hospital-search-data-country-checkbox');

    Route::get('cover-about-us', 'SiteController@aboutUs')->name('cover.about-us');
    Route::get('cover-specialist', 'SiteController@specialist')->name('cover.specialist');
    Route::get('cover-doctor', 'SiteController@coverDoctor')->name('cover.doctor');
    Route::get('contact-us', 'SiteController@contactUs')->name('contact-us');
    Route::get('cover/book-appointment', 'SiteController@coverBookAppointment')->name('cover.book-appointment');
    Route::get('cover/book-appointment-sign-doctor/{doctor_id?}', 'SiteController@coverBookAppointmentSignDoctor')->name('cover.book-appointment-sign-doctor');
    Route::get('cover/book-appointment/patient', 'SiteController@coverBookAppointmentPatient')->name('cover.book-appointment-patient');
    Route::get('cover/signup', 'SiteController@coverSignup')->name('cover.signup');
    Route::get('cover/signin', 'SiteController@coverSignin')->name('cover.signin');
    Route::post('cover/login', 'SiteController@coverLogin')->name('cover.login');
    Route::get('cover/signup/for/appointment/{id?}', 'SiteController@coverSignupForAppointment')->name('cover.signup-for-appointment');
    Route::post('cover/login/for/appointment/{id?}', 'SiteController@coverLoginForAppoitment')->name('cover.login-for-appoitment');
    Route::get('cover/sign-in-for-appointment/{id?}', 'SiteController@coverLoginForAppointment')->name('cover.sign-in-for-appointment');
    Route::post('cover/contact_us', 'SiteController@contactUsStore')->name('cover.contact_us');
    Route::get('cover/doctor/admin-panel', 'AdminPanelController@docAdminPanel')->name('cover.doctor-admin-panel');
    Route::get('cover/patient/admin-panel', 'AdminPanelController@patAdminPanel')->name('cover.patient-admin-panel');
    Route::post('admin/appointment-list', 'AdminPanelController@adminAppointmenList')->name('admin.appointment-list');
    Route::get('mcare/doctor-profile/{id?}', 'AdminPanelController@mcareDoctorProfile')->name('mcare.doctor-profile');
    Route::get('mcare/doctor/edit_profile/{doctor_id}', 'AdminPanelController@mcareDoctorEditProfile')->name('mcare.doctor.edit_profile');

    Route::post('cover/store-signup', 'SiteController@signUpStore')->name('cover.signup-store');
    Route::post('cover/store-signup/{id?}', 'SiteController@signUpStoreForAppointment')->name('cover.signup-store-for-appointment');
    //Route::post('cover/store-appointment', 'SiteController@appointmentStore')->name('cover.appointment-store');
    Route::get('/cover/logout', 'SiteController@CoverLogout')->name('cover.logout');
    //Doctor admin panel
    Route::get('doctor/admin-appointments', 'AdminPanelController@doctorAppointment')->name('doctor.admin-appointments');
    Route::get('doctor/prescription/create', 'AdminPanelController@doctorPrescreate')->name('doctor.prescription.create');
    Route::get('doctor/create-doctor-wise/new/{appointment_id?}', 'AdminPanelController@prescreateDoctorWise')->name('doctor-prescription.create-doctor-wise');


    Route::post('get-doctors-list-by-specialized', 'SiteController@specialized')->name('get-doctors-list-by-specialized');
    Route::post('get-doctors-by-specialized', 'SiteController@doctorSpecialized')->name('get-doctors-by-specialized');

    //Route::get('/', 'SiteController@index')->name('/');





    Route::post('supplier-info-autocomplete', "SupplierPaymentController@supplierInfoAutocomplete")->name('supplier-info-autocomplete');
    Route::post('corporate-info-autocomplete', "CorporateController@corporateInfoAutocomplete")->name('corporate-info-autocomplete');
    Route::post('patient-area-info-autocomplete', "SiteController@patientAreaInfoAutocomplete")->name('patient-area-info-autocomplete');



    //appointments-store
    // Route::get('/', function () {
    //     return view('layouts.app');
    // });
    // Route::get('/login', function () {
    //    dd(555);
    // });
    // Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/report/dummy', function () {
        return view('admin.reports.financial.report');
    });


    Route::get('/admin-dashboard', 'DashboardController@index')->name('admin-dashboard');
    Route::get('v2/dashboard', 'DashboardController@commonDashboard')->name('v2.dashboard');
    Route::get('db/v1', 'DashboardController@managementDashboard')->name('db.v1');
    Route::get('common/page', 'DashboardController@commonPage')->name('common.page');
    // Route::get('/home', 'HomeController@index')->name('home');

    // dashboard_detail popups accounts
    Route::get('dashboard/investigation-popup/{type?}', 'DashboardController@investigationPopup')->name('dashboard.investigation-popup');
    Route::get('dashboard/investigation-popup1/data', 'DashboardController@investigationPopupData')->name('dashboard.investigation-popup-data');
    Route::get('dashboard/ipd-popup', 'DashboardController@ipdPopup')->name('dashboard.ipd-popup');
    Route::get('dashboard/pharmacy-collection-popup', 'DashboardController@pharmacyCollectionPopup')->name('dashboard.pharmacy-collection-popup');
    Route::get('dashboard/ambulance-collection-popup', 'DashboardController@ambulanceCollectionPopup')->name('dashboard.ambulance-collection-popup');
    Route::get('dashboard/others-collection-popup', 'DashboardController@othersCollectionPopup')->name('dashboard.others-collection-popup');
    Route::get('dashboard/doctor-popup', 'DashboardController@doctorPopup')->name('dashboard.doctor-popup');

    Route::get('dashboard/hr_pie_chart', 'DashboardController@hr_pie_chart')->name('dashboard.hr_pie_chart');
    Route::get('dashboard/consultation_pie_chart', 'DashboardController@accountschart')->name('dashboard.consultaion_pie_chart');

    // dashboard_detail popups hr dashboard
    Route::get('dashboard/hrm-employees/{type?}', 'DashboardController@dashboardEmployees')->name('dashboard.hrm-employees');
    //Route::get('dashboard/late-employees', 'DashboardController@lateEmployees')->name('dashboard.late-employees');
    //Route::get('dashboard/absent-employees', 'DashboardController@absentEmployees')->name('dashboard.absent-employees');
    //Route::get('dashboard/leave-employees', 'DashboardController@leaveEmployees')->name('dashboard.leave-employees');
    //Route::get('dashboard/offday-employees', 'DashboardController@offdayEmployees')->name('dashboard.offday-employees');
    Route::get('dashboard/sick-employees', 'DashboardController@sickEmployees')->name('dashboard.sick-employees');
    Route::get('dashboard/date-data', 'DashboardController@date_factor')->name('dashboard.date-data');
    Route::get('dashboard/shift-data', 'DashboardController@shift_factor')->name('dashboard.shift-data');
    Route::get('dashboard/service-unit-data', 'DashboardController@service_factor')->name('dashboard.service-unit-data');

    Route::get('patient-registration-print/{id?}', 'PatientRegistrationController@printPatientRagistration')->name('patient-registration-print');
    Route::get('patient-registration-print-alied/{id?}', 'PatientRegistrationController@printPatientRagistrationAlied')->name('patient-registration-print-alied');

    Route::post('/registration/storequickregistration', 'PatientRegistrationController@storeQuickRegistration')->name('registration.storequickregistration');
    Route::get('/registration/quickcreate/{id?}', 'PatientRegistrationController@createQuickRegistration')->name('registration.quickcreate');
    Route::post('/registration/calculateage/{id?}', 'PatientRegistrationController@calculatePatientAge')->name('registration.calculateage');
    Route::post('/registration/calculateage-v2/{id?}', 'PatientRegistrationController@calculatePatientAgev2')->name('registration.calculateage-v2');
    Route::post('/registration/calculateage-bydate/{id?}', 'PatientRegistrationController@calculatePatientAgeByDate')->name('registration.calculateagebydate');

    Route::post('/registration/calculateage-bydate-v2/{id?}', 'PatientRegistrationController@calculatePatientAgeByDatev2')->name('registration.calculateagebydatev2');

    Route::get('/patient/statistics', 'PatientRegistrationController@patientStatistics')->name('patient.statistics');

    Route::get('/patient-card/{id}/{invoice_id?}', 'PatientRegistrationController@PatientCard')->name('patient-card');
    Route::get('/general-consent', 'PatientRegistrationController@GeneralConsent')->name('general-consent');
    Route::get('/patient-information-pdf/{id?}', 'PatientRegistrationController@PatientInformationPdf')->name('patient-information-pdf');
    Route::post('patient_info', 'PatientRegistrationController@getPatientInfoById')->name('patient-info');
    Route::post('patient-info-json', 'PatientRegistrationController@patientInfoJson')->name('patient-info-json');
    Route::post('patient-info-autocomplete', 'PatientRegistrationController@patientInfoAutocomplete')->name('patient-info-autocomplete');
    Route::post('donor-info-autocomplete', 'PatientRegistrationController@donorInfoAutocomplete')->name('donor-info-autocomplete');
    Route::post('patient-id-info-autocomplete', 'PatientRegistrationController@patientIdInfoAutocomplete')->name('patient-id-info-autocomplete');
    Route::post('patient-billing-info-autocomplete', 'PatientRegistrationController@patientInfoBillingAutocomplete')->name('patient-billing-info-autocomplete');
    Route::post('patient-id-billing-info-autocomplete', 'PatientRegistrationController@patientIdInfoBillingAutocomplete')->name('patient-id-billing-info-autocomplete');
    Route::post('patient-appointment-billing-info-autocomplete', 'PatientRegistrationController@patientAppointmentInfoBillingAutocomplete')->name('patient-appointment-billing-info-autocomplete');
    Route::post('patient-search', 'PatientRegistrationController@patientSearch')->name('patient-search');
    Route::post('patient-registration/filter', 'PatientRegistrationController@filter')->name('patientRegistration.filter');
    Route::post('patient-print/{id}', 'PatientRegistrationController@patientPrint')->name('patient-print');
    Route::post('patient-list', 'PatientRegistrationController@getAllPatients')->name('patient-list');
    Route::post('hospital-patient-list', 'PatientRegistrationController@getHospitalAllPatients')->name('hospital-patient-list');
    Route::post('hospital-patient-search', 'PatientRegistrationController@hospitalPatientSearch')->name('hospital-patient-search');

    Route::post('registration/loadList', 'PatientRegistrationController@loadList')->name('registration.loadList');

    Route::get('pat_all_division_pre', 'PatientRegistrationController@patAllDivisionPre')->name('pat_all_division_pre');
    Route::get('pat_all_district_pre', 'PatientRegistrationController@patAllDistrictPre')->name('pat_all_district_pre');

    Route::get('pat_all_thana_pre', 'PatientRegistrationController@patAllThanaPre')->name('pat_all_thana_pre');
    Route::get('pat_all_thana_per', 'PatientRegistrationController@patAllThanaPer')->name('pat_all_thana_per');
    Route::resource('registration', 'PatientRegistrationController');

    # v1
    Route::get('registration-v1', [PatientRegistrationController::class, 'indexV1'])->name('patientRegistration.indexV1');
    Route::post('patient-list-v1', [PatientRegistrationController::class, 'getAllPatientsV1'])->name('patient-list-v1');


    Route::post('patient/online-profile/update', 'PatientRegistrationController@createOrUpdatePatientOnlineProfile')->name('patient-online-profile.store');
    Route::post('/user-list', 'UserController@getAllUsers')->name('user-list');
    Route::get('user/create_form', 'UserController@create_form')->name('user.create_form');
    Route::resource('user', 'UserController');

    // hospital routes
    Route::post('company-list', 'HospitalController@getAllHospitals')->name('company-list');
    Route::get('company_popup', 'HospitalController@popUp')->name('hospital.popup');
    Route::resource('/company', 'HospitalController');


    // Hospital salary setup
    Route::get('hospital-salary-setup', 'HospitalController@hospitalSalarySetup')->name('hospital-salary-setup');
    Route::post('store-hospital-salary-setup', 'HospitalController@storeHospitalSalarySetup')->name('store-hospital-salary-setup');

    Route::get('increment-promotion-policy', [HRMIncreamentPolicyController::class, 'incrementPromotionPolicy'])->name('increment-promotion-policy');
    Route::post('store-increament-policy', [HRMIncreamentPolicyController::class, 'storeIncreamentPromotionPolicy'])->name('store-increament-policy');

    // Room Routes
    Route::post('room-list', 'RoomController@getAllRoom')->name('room-list');
    Route::get('room/create_form', 'RoomController@create_form')->name('room.create_form');

    // User Room Setup
    Route::get('room/user_room_setup', 'RoomController@userRoomSetup')->name('room.user-room-setup');
    Route::get('room/user-room-setup-list', 'RoomController@getAllUserRoomSetup')->name('room.user-room-setup-list');
    Route::get('room/user-room-setup-popup/', 'RoomController@userRoomSetupPopup')->name('room.user-room-setup-popup');
    Route::post('room/store-room', 'RoomController@storeRoom')->name('room.store-room');

    Route::post('room/store-user-room', 'RoomController@storeuserroom')->name('room.store-user-room');
    Route::get('room/edit-user-room-setup/{id}', 'RoomController@editUserRoomSetup')->name('room.edit-user-room-setup');
    Route::post('room/get_room_data', 'RoomController@getRoomData')->name('room.get_room_data');
    Route::get('room/asset-room-setup', 'RoomController@assetRoomSetup')->name('room.asset-room-setup');
    Route::resource('/room', 'RoomController');

    // Service Unit Routes
    Route::post('serviceunit-list', 'ServiceUnitController@getAllServiceUnits')->name('serviceunit-list');
    Route::get('serviceunit/create_form', 'ServiceUnitController@create_form')->name('serviceunit.create_form');
    Route::post("/grant-users-data", "ServiceUnitController@getUserData")->name("grant-users-data");
    Route::get('serviceunit/grant-service-unit-to-user', 'ServiceUnitController@grantServiceUnitToUser')->name('serviceunit.grant-service-unit-to-user');
    Route::get('serviceunit/grant-service-unit-to-user-popup-form', 'ServiceUnitController@grantServiceUnitToUserForm')->name('serviceunit.grant-service-unit-to-user-popup-Form');
    Route::get('grantServiceUnit-editData/{id}', 'ServiceUnitController@getServiceEditData')->name('grantServiceUnit-editData');
    Route::post('serviceunit/grant-service-unit-to-user-popup-form-store', 'ServiceUnitController@storeGrantServiceUnitToUser')->name('grant-service-unit-to-user-popup-form-store');

    Route::post('grantServiceUnit-list', 'ServiceUnitController@getAllGrantServiceUnit')->name('grantServiceUnit-list');

    Route::resource('serviceunit', 'ServiceUnitController');

    // Shift Unit Routes
    Route::post('shift-list', 'ShiftController@getAllShifts')->name('shift-list');
    Route::get('shift/create_form', 'ShiftController@create_form')->name('shift.create_form');
    Route::resource('shift', 'ShiftController');

    // Transection Type
    Route::post('tran-list', 'TransectionTypeController@getAllTransectionType')->name('tran-list');
    Route::get('tran-type/create_form', 'TransectionTypeController@create_form')->name('tran-type.create_form');

    Route::resource('tran-type', 'TransectionTypeController');

    // Module Route
    Route::post('module-menu', 'ModuleController@getUserModuleMenu')->name('module-menu');
    Route::post('module-list', 'ModuleController@getAllModule')->name('module-list');
    Route::get('module/create_form', 'ModuleController@create_form')->name('module.create_form');
    Route::resource('module', 'ModuleController');

    // Email Format Route
    Route::post('email-format-list', 'EmailFormatController@getAllModule')->name('email-format-list');
    Route::get('email-format/create_form', 'EmailFormatController@create_form')->name('email-format.create_form');
    Route::resource('email-format', 'EmailFormatController');

    Route::get('policy/comission/{policy_id?}', 'PolicyController@comission')->name('policy.comission');
    Route::post('policy-autocomplete', 'PolicyController@policyAutocomplete')->name('policy-autocomplete');
    Route::post('policy/store-comission', 'PolicyController@store_comission')->name('policy.store-comission');
    Route::post('policy/get-policy-details', 'PolicyController@policyDetails')->name('policy.get-policy-details');
    Route::post('policy/policy-list', 'PolicyController@policyList')->name('policy.policy-list');
    Route::resource('policy', 'PolicyController');

    // Hospitalchain Route
    Route::post('hospitalchain-list', 'HospitalChainController@getAllHospitalChain')->name('hospitalchain-list');
    Route::get('hospitalchain/create_form', 'HospitalChainController@create_form')->name('hospitalchain.create_form');
    Route::resource('hospitalchain', 'HospitalChainController');

    // Lookup routes
    Route::post('lookup-list', 'LookupController@getAllLookups')->name('lookup-list');
    Route::get('lookup/indexlookupitem', 'LookupController@indexLookupItem')->name('lookup.indexlookupitem');
    Route::get('editlookupitem/{id}', 'LookupController@editLookupItem')->name('editlookupitem');
    Route::post('storelookupitem', 'LookupController@storeLookupItem')->name('lookup.storelookupitem');
    Route::get('createlookupitem', 'LookupController@createLookupItem')->name('lookup.createlookupitem');
    Route::get('createlookupitem_form', 'LookupController@createLookupItem_form')->name('lookup.createlookupitem_form');
    Route::post('lookupitem-list', 'LookupController@getAllLookupitems')->name('lookupitem-list');

    Route::post('generic-item-data-autocomplete', 'LookupController@genericDataAutocomplete')->name('generic-item-data-autocomplete');
    Route::get('looup/create_form', 'LookupController@create_form')->name('lookup.create_form');
    Route::get('looup/create', 'LookupController@create')->name('lookup.create');
    Route::post('lookup-item-search', 'LookupController@lookupItemSearch')->name('lookup-item-search');
    Route::resource('lookup', 'LookupController');
    Route::post('get-item-with-stock', 'ItemController@getItemWithStock')->name('get-item-with-stock');
    Route::post('get-item-with-stock-sub-store-wise', 'ItemController@getItemWithStockSubstore')->name('get-item-with-stock-sub-store-wise');
    Route::post('get-item-with-stock-v2', 'ItemController@getItemWithStockV2')->name('get-item-with-stock-v2');
    Route::post('get-item-with-stock-prescription', 'ItemController@getItemWithStockPrescription')->name('get-item-with-stock-prescription');
    Route::post('get-item-with-stock-prescription-store-wise', 'ItemController@getItemWithStockPrescriptionStoreWise')->name('get-item-with-stock-prescription-store-wise');
    Route::post('get-cafe-item-with-stock', 'ItemController@getCafeItemWithStock')->name('get-cafe-item-with-stock');
    // Prescription Lookup
    Route::post('prescriptionlookupitem-list', 'PrescriptionLookupController@getAllPrescriptionLookupitems')->name('prescriptionlookupitem-list');
    Route::get('prescription-lookup/indexprescriptionlookupitem', 'PrescriptionLookupController@indexPrescriptionLookupItem')->name('prescription-lookup.indexprescriptionlookupitem');
    Route::get('editprescriptionlookupitem/{id}', 'PrescriptionLookupController@editPrescriptionLookupItem')->name('prescription-lookup.editprescriptionlookupitem');
    Route::post('prescription-lookup/storeprescriptionlookupitem', 'PrescriptionLookupController@storePrescriptionLookupItem')->name('prescription-lookup.storeprescriptionlookupitem');
    Route::post('prescription-lookup/storeprescriptionlookupitem-doctor', 'PrescriptionLookupController@storePrescriptionLookupItemDoctor')->name('prescription-lookup.storeprescriptionlookupitemdoctor');
    Route::post('prescription-lookup/storeprescriptionlookupitem-doctor-chiefcomplain', 'PrescriptionLookupController@storePrescriptionLookupItemDoctorChiefComplain')->name('prescription-lookup.storeprescriptionlookupitemdoctor-chiefcomplain');
    Route::get('prescription-lookupdata-form', 'PrescriptionLookupController@createLookupdataForm')->name('prescription-lookupdata-form');
    Route::get('createprescriptionlookupitem', 'PrescriptionLookupController@createPrescriptionLookupItem')->name('prescription-lookup.createprescriptionlookupitem');
    Route::post('prescriptionlookup-list', 'PrescriptionLookupController@getAllPrescriptionLookups')->name('prescriptionlookup-list');
    Route::get('prescription-lookup-form', 'PrescriptionLookupController@createLookupForm')->name('prescription-lookup-form');
    Route::post('prescription-lookup-data/store_prescription_lookup_item', 'PrescriptionLookupController@storePrescriptionLookupItemData')->name('prescription-lookup-data.store-prescription-lookup-item');
    Route::resource('prescription-lookup', 'PrescriptionLookupController');

    Route::get('appointments/appointment_consulation_confirm/{appointment_id}', 'PatientAppointmentController@appointment_consulation_confirm')->name('appointments.appointment_consulation_confirm');
    Route::get('appointments/appointment_consultation', 'PatientAppointmentController@appointment_consultation')->name('appointments.appointment_consultation');
    Route::get('/doctor-schedule/{doctor_id?}', 'PatientAppointmentController@doctor_schedule')->name('doctor-schedule');
    Route::post('store-doctor-schedule', 'PatientAppointmentController@store_doctor_schedule')->name('store-doctor-schedule');
    Route::get('change-appointment-date/{id}', 'PatientAppointmentController@changeAppDate')->name('change-appointment-date');
    Route::post('update-appointment-date-and-time', 'PatientAppointmentController@updateAppDateAndTime')->name('update-appointment-date-and-time');

    Route::get('get_doctor_slot/{id?}', 'PatientAppointmentController@get_slot')->name('get_doctor_slot');

    Route::post('appointments/appointments_list_print', 'PatientAppointmentController@appointment_list_pdf')->name('appointments.appointments_list_print');

    Route::post('create-appointment-form', 'PatientAppointmentController@create_appointment_form')->name('create-appointment-form');
    Route::post('get-appointment-list-by-doctor-date', 'PatientAppointmentController@get_appointment_list_by_doctor_date')->name('get-appointment-list-by-doctor-date');
    Route::post('get_doctor_schedule', 'PatientAppointmentController@get_doctor_schedule')->name('get_doctor_schedule');
    Route::post('delete_doctor_schedule', 'PatientAppointmentController@delete_doctor_schedule')->name('delete_doctor_schedule');
    Route::post('delete_doctor_schedule_all', 'PatientAppointmentController@delete_doctor_schedule_all')->name('delete_doctor_schedule_all');
    Route::post('get-doctor-schedule-dates', 'PatientAppointmentController@get_doctor_schedule_dates')->name('get-doctor-schedule-dates');
    Route::post('deleted-appointment-by-id', 'PatientAppointmentController@deleted_appointment_by_id')->name('deleted-appointment-by-id');
    Route::get('appointments/list-view', 'PatientAppointmentController@pat_appointment_list')->name('appointments.list-view');
    Route::post('appointments/search-app-list', 'PrescriptionController@searchAppList')->name('appointments.search-app-list');
    Route::get('appointments/list-view-dortor-wise', 'PatientAppointmentController@pat_appointment_list_doctor_wise')->name('appointments.list-view-dortor-wise');
    //Free Patient
    Route::get('appointments/free-patient-list-view', 'PatientAppointmentController@free_pat_appointment_list')->name('appointments.free-list-view');
    Route::post('/get-free-appointment-list', 'PatientAppointmentController@get_free_appointment_list_by_search')->name('get-free-appointment-list');
    Route::post('appointments/free-appointments_list_print', 'PatientAppointmentController@free_appointment_list_pdf')->name('free.appointments.appointments_list_print');
    Route::get('appointments/free-grid-view', 'PatientAppointmentController@free_appointmentList')->name('free.appointments.grid-view');

    Route::post('/get-appointment-list', 'PatientAppointmentController@get_appointment_list_by_search')->name('get-appointment-list');
    Route::post('/get-appointment-list-doctor-wise', 'PatientAppointmentController@get_appointment_list_by_search_doctor_wise')->name('get-appointment-list-doctor-wise');
    Route::get('/appointment-card-pat/{appoint_no_pk}', 'PatientAppointmentController@get_appointment_card')->name('appointment-card-pat');
    Route::get('appointments/grid-view', 'PatientAppointmentController@appointmentList')->name('appointments.grid-view');
    Route::get('/appointment-list-search', 'PatientAppointmentController@pat_appointment_list_search')->name('pat-appointment-list-search');
    Route::get('/delete-appointment-by-id/{appointment_id}', 'PatientAppointmentController@delete_appointment_by_id')->name('delete-appointment-by-id');
    Route::get('/cancel-appointment-form/{appointment_id}', 'PatientAppointmentController@cancel_appointment_form')->name('cancel-appointment-form');
    Route::post('cancel-appointment', 'PatientAppointmentController@cancel_appointment')->name('cancel-appointment');

    Route::post('get-doctor-appointment-info', 'PatientAppointmentController@get_doctor_appointment_info')->name('get-doctor-appointment-info');
    Route::post('get-doctor-slot', 'PatientAppointmentController@get_doctor_slot')->name('get-doctor-slot');

    Route::post('/visit_sales_price', 'PatientAppointmentController@get_sales_price')->name('visit_sales_price');
    Route::post('cover/appointment-store', 'PatientAppointmentController@coverStore')->name('cover.appointment-store');
    Route::resource('appointments', 'PatientAppointmentController');
    Route::get('appointments/create/{pabx_id?}', 'PatientAppointmentController@create')->name('appointments.create');

    Route::post('get-doctor-patient-appointment-info', 'PatientAppointmentController@get_doctor_patient_appointment_info')->name('get-doctor-patient-appointment-info');


    Route::get('/appointment', 'HomeController@pat_appointment')->name('pat-appointment');
    Route::get('/appointment-schedule', 'HomeController@pat_appointment_schedule')->name('pat-appointment-schedule');

    //Items Route
    // Route::get('/item-type-list', 'ItemController@item_type_list')->name('item-type-list');
    // Route::get('/item-type-create', 'ItemController@create_item_type')->name('item-type-create');
    // Route::get('/item-type-create-form', 'ItemController@create_item_type_form')->name('item-type-create-form');

    //Route::get('/item-list', 'ItemController@index')->name('item-list');
    // Route::get('/item-create', 'ItemController@create')->name('item-create');
    // Route::get('/item-create-form', 'ItemController@create_item_form')->name('item-create-form');

    // Route::post('itemtype-list', 'ItemController@getItemTypes')->name('itemtype-list');

    //item type
    // other item
    Route::get('item/other-item-setup', 'ItemController@otherItemSetup')->name('item.other-item-setup');
    Route::post('item/other-item-all-data', 'ItemController@otherItemGetAllData')->name('item.other-item-all-data');
    Route::get('item-other-item-edit/{id}', 'ItemController@otherItemEdit')->name('item.other-item-edit');
    Route::post('item/other-item-store', 'ItemController@OtherItemStore')->name('item.other-item-store');
    Route::get('item/other-item-worklist', 'ItemController@otherItemWorklist')->name('item.other-item-worklist');

    Route::post('/item-type-list', 'ItemController@getItemTypeList')->name('get-item-type-list');
    Route::get('/item-type-edit/{id}', 'ItemController@itemTypeEdit')->name('item-type-edit');
    Route::put('/item-type-update/{id}', 'ItemController@itemTypeUpdate')->name('item-type-update');
    Route::get('/item-type-create', 'ItemController@itemTypeCreate')->name('item-type-create');
    Route::get('/item-type-create-form', 'ItemController@itemTypeCreate_form')->name('item-type-create-form');
    Route::post('/item-type-store', 'ItemController@itemTypeStore')->name('item-type-store');
    Route::get('/item-type', 'ItemController@itemType')->name('item-type');
    Route::post('item/item_type_search', 'ItemController@itemTypeSearch')->name('item.item_type_search');

    // Item Type v1
    Route::get('/item-type/v1', 'ItemController@itemTypeV1')->name('item-type-v1');
    Route::get('/item-type/get-data', [ItemController::class, 'getData'])->name('itemType.getData');
    Route::post('/item-type/filter', [ItemController::class, 'filter'])->name('itemType.filter');

    Route::post('/item-list', 'ItemController@searchItemList')->name('item-list');
    Route::post('item/item-list', 'ItemController@getItemListAll')->name('item.item-list');
    Route::get('item/create_item_form', 'ItemController@create_item_form')->name('item.create_item_form');
    Route::get('item/create-quick-item', 'ItemController@create_quick_item_form')->name('item.create-quick-item');
    Route::get('item/create-quick-item-po', 'ItemController@create_quick_item_form_po')->name('item.create-quick-item-po');
    Route::get('item/edit-quick-item-po/{id}', 'ItemController@edit_quick_item_form_po')->name('item.edit-quick-item-po');
    Route::get('item/get-new-item-info', 'ItemController@getNewItemInfo')->name('item.get-new-item-info');
    Route::post('add-new-item', 'ItemController@addNewGenericItem')->name('add-new-item');
    Route::post('get-item-name', 'ItemController@getItemName')->name('get-item-name');
    Route::post('get-item-name-v1', 'ItemController@getItemNameV1')->name('get-item-name-v1');
    Route::post('get-auto-items-list', 'BillingController@getAutoItemName')->name('get-auto-items-list');
    Route::post('get-auto-items-list-v1', 'BillingController@getAutoItemNameV1')->name('get-auto-items-list-v1');
    Route::post('item/item-store', 'ItemController@itemStore')->name('item.item-store');
    Route::get('item/create', 'ItemController@create_item_form')->name('item.create');
    Route::get('get-category-wise-sub-category', 'ItemController@getCategoryWiseSubCategory')->name('get-category-wise-sub-category');


    Route::get('medicine/item', 'ItemController@medItem')->name('med.item-ist');
    Route::post('medicine/item-search-list', 'ItemController@medicineSearchItemList')->name('med.item-search-list');
    Route::get('medicine/create_item_form', 'ItemController@create_medicine_form')->name('med.create_item_form');
    Route::post('medicine/item-store', 'ItemController@MedicineitemStore')->name('medicine.item-store');
    Route::get('medicine/create', 'ItemController@create_medicine')->name('medicine.create');
    Route::get('med/create-quick-item', 'ItemController@create_quick_medi_item_form')->name('med.create-quick-item');

    //item setup
    Route::get('item/pathology-item-setup', 'ItemController@pathologyItemSetup')->name('item.pathology-item-setup');
    Route::get('item/pathology-item', 'ItemController@pathologyItemSetup')->name('item.pathology-item-setup');
    Route::post('item/pathology-item-store', 'ItemController@pathologyItemStore')->name('pathology-item-setup-store');
    Route::post('item/pathology-item-search', 'ItemController@pathologyItemSearch')->name('pathology-item-setup-search');
    Route::get('item/pathology-item-edit', 'ItemController@pathologyItemEdit')->name('pathology-item-setup-edit');

    route::get('pathology/attribute/value', 'ItemController@pathologyValue')->name('pathology.attribute/value');
    route::get('default/attribute/create', 'ItemController@pathologyDefaultCreate')->name('default-attribute.create');
    route::post('path/attribute-data', 'ItemController@pathologyAttData')->name('path.attribute-data');
    route::post('path/attribute-data-default-store', 'ItemController@PathologyAttributeDefaultStore')->name('path.attribute-data-default-store');

    Route::post('pathology/attribute-default-list', 'ItemController@pathologyAttributeAllData')->name('pathology.attribute-default-list');
    Route::get('pathology/attribute-list', 'ItemController@attList')->name('pathology/attribute-list');
    Route::get('attribute/value/edit/{id?}', 'ItemController@attValueEdit')->name('attribute-value.edit');

    // Billing Item Type Setup
    Route::get('item/billing-item-type', 'ItemController@billingItemType')->name('item.billing-item-type');
    Route::post('item/billing-item-type-list', 'ItemController@getAllItemType')->name('item.billing-item-type-list');
    Route::get('item/create-billing-item-type', 'ItemController@createBillingItemType')->name('item.create-billing-item-type');
    Route::post('item/store-billing-item-type', 'ItemController@storeBillingItemType')->name('item.store-billing-item-type');
    Route::get('item/edit-billing-item-type/{id?}', 'ItemController@editBillingItemType')->name('item.edit-billing-item-type');


    //attribute/group
    Route::get('attribute/group', 'ItemController@attindex')->name('att.index');
    Route::post('attribute/group', 'ItemController@attstore')->name('att.store');
    Route::get('attribute/group/{edit_id}', 'ItemController@editAtt')->name('att.editAtt');
    Route::put('attribute/group/{update_id}', 'ItemController@updatetAtt')->name('att.updateAtt');

    Route::get('medicine/create', 'ItemController@create_medicine')->name('medicine.create');
    Route::get('med/create-quick-item', 'ItemController@create_quick_medi_item_form')->name('med.create-quick-item');


    //Added By Nazmul startroo
    Route::get('path/pathology-test-wise-attr-entry', 'PathologyController@pathologyTestWiseAttrEntry')->name('path.pathology-test-wise-attr-entry');
    Route::post('path/pathology-test-wise-attr-entry', 'PathologyController@pathologyTestWiseAttrEntryExamList')->name('path.pathology-test-wise-attr-entry-exam-list');
    Route::post('path/pathology-test-wise-attr-list', 'PathologyController@pathologyTestWiseAttrList')->name('path.pathology-test-wise-attr-list');
    Route::post('path/pathology-test-wise-attr-analyzer-list', 'PathologyController@pathologyTestWiseAttrAnalyzerList')->name('path.pathology-test-wise-attr-analyzer-list');
    Route::post('path/store-pathology-test-attr-entry', 'PathologyController@storePathTestAttrEntry')->name('path.store-pathology-test-wise-attr-entry');
    Route::post('path/store-pathology-test-wise-attr-analyzer', 'PathologyController@storePathTestAttrAnalyser')->name('path.store-pathology-test-wise-attr-analyzer');
    Route::post('path/pathology-test-wise-attr-reference-value-list', 'PathologyController@PathTestAttrRefvalList')->name('path.pathology-test-wise-attr-reference-value-list');
    Route::post('path/store-pathology-test-wise-attr-reference-value-entry', 'PathologyController@storePathTestAttrRefvalEntry')->name('path.store-pathology-test-wise-attr-reference-value-entry');
    Route::post('path/pathology-test-wise-attrRefVal-remove', 'PathologyController@removePathTestAttrRefval')->name('path.pathology-test-wise-attrRefVal-remove');
    Route::post('pta/item-autocomplete', 'PathologyController@ptaItemAutocomplete')->name('pta.item-autocomplete');
    Route::get('pathology/print-form/{id?}', 'PathologyController@PatPrintForm')->name('pathology.print-form');
    Route::post('pathology/skip-verify-and-finalize', 'PathologyController@skipVerify')->name('pathology.skip-verify-and-finalize');
    Route::get('pathology/attrvalue/{id?}', 'PathologyController@addAttrValue')->name('add-attr-value');
    Route::post('pathology/store-default-value', 'PathologyController@storeDefaultValue')->name('pathology.store-default-value');

    //Added By Nazmul end

    Route::get('item/radiology-item-setup', 'ItemController@radiologyItemSetup')->name('item.radiology-item-setup');
    Route::post('item/radiology-item-store', 'ItemController@RadiologyItemStore')->name('item.radiology-item-store');
    Route::get('item/radiology-item/{id}', 'ItemController@radiologyItemEdit')->name('radiology.item-edit');

    Route::resource('item', 'ItemController');

    //FIXED ASSET
    Route::get('fixed-asset-item', 'ItemController@fixedAssetList')->name('fixed-asset-item');
    Route::post('fixed-asset-item-list', 'ItemController@fixedAssetListItem')->name('fixed-asset-item-list');

    Route::get('bill-invoice/{id}/{trx?}', 'BillingController@bill_invoice')->name('bill-invoice');
    Route::get('bill-invoice-v1/{id}/{trx?}', 'BillingController@bill_invoice_v1')->name('bill-invoice-v1');
    Route::get('bill-invoice-app/{id}/{trx?}', 'BillingController@bill_invoice_app')->name('bill-invoice-app');
    Route::get('bill-invoice-ipd/{id}', 'BillingController@bill_invoice_ipd')->name('bill-invoice-ipd');
    Route::get('bill-invoice-physio/{id}/{trx?}', 'BillingController@bill_invoice_physio')->name('bill-invoice-physio');
    Route::get('pos-invoice/{id}/{trx?}', 'BillingController@pos_invoice')->name('pos-invoice');
    Route::get('due-colletion-invoice/{id}/{trx?}', 'BillingController@due_collection_invoice')->name('due-colletion-invoice');
    Route::get('invoice-edit/{id}/{trx?}', 'BillingController@invoice_edit')->name('invoice-edit');
    Route::get('due-colletion-ipd-invoice/{id}/{trx?}', 'BillingController@due_collection_ipd_invoice')->name('due-colletion-ipd-invoice');
    Route::get('invoice-edit/{id}/{trx?}', 'BillingController@invoiceEdit')->name('invoice-edit');
    Route::post('invoice-update', 'BillingController@invoiceUpdate')->name('invoice-update');
    Route::get('pos-due-colletion-invoice/{id}/{trx?}', 'BillingController@pos_due_collection_invoice')->name('pos-due-colletion-invoice');
    Route::get('billing-cancelation-invoice/{id?}/{trx?} ', 'BillingController@billing_cancelation_invoice')->name('billing-cancelation-invoice');
    // Route::get('billing-cancelation-invoice/{id}/{idm?}/{trx?} ', 'BillingController@billing_cancelation_invoice')->name('billing-cancelation-invoice');
    Route::get('pos-cancelation-invoice/{id}/{trx?}', 'BillingController@pos_cancelation_invoice')->name('pos-cancelation-invoice');
    // Route::get('pos-cancelation-invoice/{id}/{idm?}', 'BillingController@pos_cancelation_invoice')->name('pos-cancelation-invoice');

    Route::get('pos-billing-list', 'BillingController@pos_billing_list')->name('pos-billing-list');
    Route::get('pos-bill-list', 'BillingController@posBillList')->name('pos-bill-list');
    Route::post('pos-search-bill-list', 'BillingController@posSearchBillList')->name('pos-search-bill-list');
    Route::post('post_billing_report_print', 'BillingController@posBillingReport')->name('post_billing_report_print');

    // cafeteria billing list
    Route::get('cafe-billing-list/{type?}', 'BillingController@cafe_billing_list')->name('cafe-billing-list');
    Route::get('cafe-bill-list/{type?}', 'BillingController@cafeBillList')->name('cafe-bill-list');
    Route::post('cafe-search-bill-list/{type?}', 'BillingController@cafeSearchBillList')->name('cafe-search-bill-list');

    // cafeteria ipd billing list
    Route::get('cafe-ipd-billing-list/{type?}', 'BillingController@cafe_ipd_billing_list')->name('cafe-ipd-billing-list');
    Route::get('cafe-ipd-bill-list/{type?}', 'BillingController@cafeIpdBillList')->name('cafe-ipd-bill-list');
    Route::post('cafe-ipd-search-bill-list/{type?}', 'BillingController@cafeIpdSearchBillList')->name('cafe-ipd-search-bill-list');

    //optical shop
    Route::get('optical-billing-list/{type?}', 'BillingController@optical_billing_list')->name('optical-billing-list');
    Route::get('coffee-billing-list/{type?}', 'BillingController@coffee_billing_list')->name('coffee-billing-list');
    Route::get('optical-ipd-billing-list/{type?}', 'BillingController@optical_ipd_billing_list')->name('optical-ipd-billing-list');
    Route::get('coffee-ipd-billing-list/{type?}', 'BillingController@coffee_ipd_billing_list')->name('coffee-ipd-billing-list');
    //pos billing for ipd
    Route::get('pos-billing-list-ipd', 'BillingController@pos_billing_list_ipd')->name('pos-billing-list-ipd');
    Route::get('pos-billing-list-ipd-payment', 'BillingController@pos_billing_list_ipd_payment')->name('pos-billing-list-ipd-payment');
    Route::post('pos-ipd-payment-store', 'BillingController@ipdPaymentStroe')->name('pos-ipd-payment-store');
    Route::get('pos-billing-ipd-payment-slip/{trn_id?}', 'BillingController@ipdPosPaymentSlip')->name('pos-billing-ipd-payment-slip');
    Route::get('pos-billing-ipd-payment-slip-print/{trn_id?}', 'BillingController@ipdPosPaymentSlipPrint')->name('pos-billing-ipd-payment-slip-print');
    Route::get('pos-billing-ipd-payment-slip-print-phr/{trn_id?}', 'BillingController@ipdPosPaymentSlipPrintPhr')->name('pos-billing-ipd-payment-slip-print-phr');
    Route::get('pos-bill-list-ipd', 'BillingController@posBillListIpd')->name('pos-bill-list-ipd');
    Route::post('pos-search-bill-list-ipd', 'BillingController@posSearchBillListIpd')->name('pos-search-bill-list-ipd');
    Route::post('pos-search-bill-list-ipd-payment', 'BillingController@posSearchBillListIpdPayment')->name('pos-search-bill-list-ipd-payment');
    Route::get('pos-pdf-bill-list-ipd', 'BillingController@posPdfBillListIpd')->name('pos-pdf-bill-list-ipd');

    //end

    Route::post('store_cancelation', 'BillingController@store_cancelation')->name('store_cancelation');
    Route::post('store_pos_cancelation', 'BillingController@store_pos_cancelation')->name('store_pos_cancelation');
    Route::post('store-due-colletion', 'BillingController@store_due_collection')->name('store-due-colletion');
    Route::post('store-invoice-edit', 'BillingController@store_invoice_edit')->name('store-invoice-edit');

    Route::get('bill-invoice-print-A4/{id}/{page?}', 'BillingController@bill_invoice_print_A4')->name('bill-invoice-print-A4');
    Route::get('bill-invoice-print-A5/{id}/{page?}/{trx?}', 'BillingController@bill_invoice_print_A5')->name('bill-invoice-print-A5');
    Route::get('bill-invoice-print-A5-v1/{id}/{page?}/{trx?}', 'BillingController@bill_invoice_print_A5_v1')->name('bill-invoice-print-A5-v1');
    Route::get('bill-invoice-print-A5-pkg/{id}/{page?}/{trx?}', 'BillingController@bill_invoice_print_A5_pkg')->name('bill-invoice-print-A5-pkg');

    Route::get('bill-invoice-app-print/{id}/{page?}/{trx?}', 'BillingController@bill_invoice_app_print')->name('bill-invoice-app-print');
    Route::get('bill-invoice-app-print-v2/{id}/{page?}/{trx?}', 'BillingController@bill_invoice_app_print_v2')->name('bill-invoice-app-print-v2');
    Route::get('bill-invoice-ipd-print/{id}/{page?}', 'BillingController@bill_invoice_ipd_print')->name('bill-invoice-ipd-print');
    Route::get('bill-invoice-ipd-print-v2/{id}/{page?}', 'BillingController@bill_invoice_ipd_print_v2')->name('bill-invoice-ipd-print-v2');
    Route::get('bill-invoice-pos-print/{id}/{page?}/{trx?}', 'BillingController@bill_invoice_pos_print')->name('bill-invoice-pos-print');
    Route::get('bill-invoice-pos-print-v2/{id}/{page?}/{trx?}', 'BillingController@bill_invoice_pos_printV2')->name('bill-invoice-pos-print-v2');
    Route::get('bill-invoice-pos-print-pos/{id}/{page?}/{trx?}', 'BillingController@bill_invoice_pos_print_pos')->name('bill-invoice-pos-print-pos');

    Route::get('due-invoice-pos-print-pos/{id}/{trx?}', 'BillingController@due_invoice_pos_print_pos')->name('due-invoice-pos-print-pos');
    // Route::get('due-invoice-pos-print-pos/{id}/{page?}/{trx?}', 'BillingController@due_invoice_pos_print_pos')->name('due-invoice-pos-print-pos');
    Route::get('cancel-invoice-pos-print-pos/{id}/{page?}/{trx?}', 'BillingController@cancel_invoice_pos_print_pos')->name('cancel-invoice-pos-print-pos');

    Route::get('bill-invoice-physio-print-a5/{id}/{page?}/{trx}', 'BillingController@bill_invoice_physio_print_a5')->name('bill-invoice-physio-print-a5');
    Route::get('bill-invoice-physio-print-a4/{id}/{page?}', 'BillingController@bill_invoice_physio_print_a4')->name('bill-invoice-physio-print-a4');

    Route::get('invoice-print-lab/{id}/{invoice?}/{type?}', 'BillingController@invoice_print_lab')->name('invoice-print-lab');
    Route::get('due-invoice-print/{id}/{trx?}', 'BillingController@due_invoice_print')->name('due-invoice-print');
    Route::get('due-invoice-print-v2/{id}/{trx?}', 'BillingController@due_invoice_print_v2')->name('due-invoice-print-v2');
    Route::get('due-invoice-print-v2-pkg/{id}/{trx?}', 'BillingController@due_invoice_print_v2_pkg')->name('due-invoice-print-v2-pkg');
    Route::get('car-parking-invoice-print/{id}/{trx?}', 'BillingController@carParkingInvoice')->name('car-parking-invoice-print');
    Route::get('due-invoice-ipd-print/{id}/{trx?}', 'BillingController@due_invoice_ipd_print')->name('due-invoice-ipd-print');
    Route::get('pos-due-invoice-print/{id}/{trx?}', 'BillingController@pos_due_invoice_print')->name('pos-due-invoice-print');
    Route::get('pos-due-invoice-print-v2/{id}/{trx?}', 'BillingController@pos_due_invoice_print_v2')->name('pos-due-invoice-print-v2');
    Route::get('bill-cancel-print/{id}/{trx?}', 'BillingController@bill_cancel_print')->name('bill-cancel-print');
    Route::get('bill-cancel-print-v2/{id}/{trx?}', 'BillingController@bill_cancel_print_v2')->name('bill-cancel-print-v2');
    Route::get('pos-cancel-print/{id}/{page?}/{trx?}', 'BillingController@pos_cancel_print')->name('pos-cancel-print');

    Route::get('bill-invoice-appointment/{appointment_id}', 'BillingController@appointment_invoice')->name('bill-invoice-appointment');

    Route::get('billing_appointment_invoice_pdf/{appointment_id}', 'BillingController@billing_invoice_print')->name('billing_appointment_invoice_pdf');

    Route::get('billing/service-billing/{id?}', 'BillingController@createServiceBilling')->name('billing.service-billing');
    // Route::get('billing/service-billing-v3/{id?}', 'BillingController@createServiceBillingV3')->name('billing.service-billing-v3');
    Route::get('billing/emergency-billing/{id?}', 'BillingController@emergencyBilling')->name('billing.emergency-billing');
    Route::get('billing/day-care-billing/{id?}', 'BillingController@dayCareBilling')->name('billing.day-care-billing');
    Route::get('billing/pharmacy-billing/{press_code?}/{press_id?}', 'BillingController@pharmacyPOS')->name('billing.pharmacy-billing');
    Route::get('billing/pharmacy-billing-v2/{press_code?}/{press_id?}', 'BillingController@pharmacyPOSV2')->name('billing.pharmacy-billing-v2');
    Route::get('billing/pos-expire-edit/{id}', 'BillingController@posExpireEdit')->name('billing.pos-expire-edit');
    Route::get('billing/pos-qty-edit/{id}', 'BillingController@posQtyEdit')->name('billing.pos-qty-edit');
    Route::post('billing/pos-expire-show', 'BillingController@posExpireShow')->name('billing.pos-expire-show');
    Route::post('billing/save-expire-date', 'BillingController@saveExpireDate')->name('billing.save-expire-date');
    Route::post('billing/show-batch-no-dropdown', 'BillingController@showBatchDropdown')->name('billing.show-batch-no-dropdown');


    // Only Pharmacy Bill Generate

    Route::get('billing/pharmacy-bill-generate/{admission_id?}/{moduleNo?}', 'BillingController@pharmacyPOSBillGenerate')->name('billing.pharmacy-bill-generate');
    Route::get('v2/billing/pharmacy-indent-bill-generate/{med_req_id?}', 'BillingController@indentBillGenerate')->name('v2.billing.pharmacy-indent-bill-generate');

    // Cafeterria module
    Route::get('billing/cafeteria-billing', 'BillingController@cafeterriaPOS')->name('billing.cafeteria-billing');
    // end Cafeterria

    Route::get('billing/billing-due-collection', 'BillingController@billingDueCollection')->name('billing.billing-due-collection');
    Route::get('billing/pos-billing-due-collection', 'BillingController@posBillingDueCollection')->name('billing.pos-billing-due-collection');
    Route::get('billing/cafe-billing-due-collection', 'BillingController@cafeBillingDueCollection')->name('billing.cafe-billing-due-collection');
    Route::get('billing/billing-cancelation', 'BillingController@billingCancelation')->name('billing.billing-cancelation');
    Route::get('billing/billing-cancelation-edit', 'BillingController@billingCancelationEdit')->name('billing.billing-cancelation-edit');
    Route::get('billing/pos-cancelation', 'BillingController@posCancelation')->name('billing.pos-cancelation');
    Route::post('billing/delete-invoice', 'BillingController@deleteInvoice')->name('billing.delete-invoice');
    Route::post('billing/delete-item-invoice', 'BillingController@deleteItemInvoice')->name('billing.delete-item-invoice');

    Route::get('billing/jakat-non-muslim', 'BillingController@jakatNonMuslim')->name('billing.jakat-non-muslim');
    Route::post('store-jakat-non-muslim-edit', 'BillingController@storeJakatNonMuslim')->name('store-jakat-non-muslim-edit');

    Route::post('billing/get-pos-items-list', 'BillingController@getPosItemsList')->name('billing.get-pos-items-list');
    Route::get('billing/get-billing-invoice-list', 'BillingController@get_billing_invoice_list')->name("billing.get_billing_invoice_list");
    Route::get('billing/get-pos-billing-invoice-list', 'BillingController@get_pos_billing_invoice_list')->name("billing.get_pos_billing_invoice_list");
    Route::get('billing/get-cafe-billing-invoice-list', 'BillingController@get_cafe_billing_invoice_list')->name("billing.get_cafe_billing_invoice_list");
    Route::get('billing/get-billing-cancel-invoice-list', 'BillingController@get_billing_cancel_invoice_list')->name("billing.get-billing-cancel-invoice-list");
    Route::get('billing/get-billing-cancel-invoice-list-edit', 'BillingController@get_billing_cancel_invoice_list_edit')->name("billing.get-billing-cancel-invoice-list-edit");
    Route::get('billing/get-billing-pos-cancel-invoice-list', 'BillingController@get_billing_pos_cancel_invoice_list')->name("billing.get-billing-pos-cancel-invoice-list");
    Route::get('/billing-invoice-print', 'BillingController@billingInvoicePrint')->name('billing-invoice-print');
    Route::get('/billing-invoice-print', 'BillingController@billingInvoicePrint')->name('billing-invoice-print');
    Route::get('/billing-invoice', 'BillingController@billingInvoice')->name('billing-invoice');

    Route::post('bill-list', 'BillingController@billList')->name('bill-list');
    Route::post('search-bill-list', 'BillingController@searchBillList')->name('search-bill-list');

    Route::get('emergency-bill-list-index', 'BillingController@emergencyBillingListIndex')->name('emergency-bill-list-index');
    Route::post('emergency-bill-list', 'BillingController@emergencyBillList')->name('emergency-bill-list');
    Route::post('search-emergency-bill-list', 'BillingController@searchEmergencyBillList')->name('search-emergency-bill-list');

    Route::get('day-care-bill-list-index', 'BillingController@dayCareBillingListIndex')->name('day-care-bill-list-index');
    Route::post('day-care-bill-list', 'BillingController@dayCareBillList')->name('day-care-bill-list');
    Route::post('search-day-care-bill-list', 'BillingController@searchDayCareBillList')->name('search-day-care-bill-list');



    Route::post("pharmacy-store", "BillingController@savePOS")->name("pharmacy.store");
    Route::post("pharmacy-indent-store", "BillingController@saveIndentPOS")->name("pharmacy-indent.store");
    Route::post("cafeteria-store", "BillingController@saveCafeteria")->name("cafeteria.store");

    Route::post('patient-total-due-calculcation', "BillingController@patientTotalDueCalculation")->name('billing.patient-total-due-calculcation');
    //ipd Billing list
    Route::get('ipd-billing-list', 'BillingController@ipd_billing_list')->name('ipd-billing-list');
    Route::post('ipd-bill-list', 'BillingController@ipdBillList')->name('ipd-bill-list');
    Route::post('search-ipd-bill-list', 'BillingController@searchIPDBillList')->name('search-ipd-bill-list');


    Route::resource('billing', 'BillingController');
    Route::post('emergency-billing-store', 'BillingController@emergencyBillingStore')->name('emergency-billing-store');
    Route::post('day-care-billing-store', 'BillingController@dayCareStore')->name('day-care-billing-store');
    // billing routes

    // user routes
    //Route::get('/create-user', 'UserController@create')->name('create-user');

    // lookup routes
    // Route::get('/lookup-create', 'LookupController@create')->name('lookup-create');
    // Route::get('/lookup-create-form', 'LookupController@create_form')->name('lookup-create-form');
    // Route::get('/lookup-create-item', 'LookupController@create_lookup_item')->name('lookup-create-item');
    // Route::get('/lookup-create-item-mapping', 'LookupController@create_lookup_item_mapping')->name('lookup-create-item-mapping');

    // menu routes
    Route::post('/menu-list', 'MenuController@getAllMenus')->name('menu-list');
    Route::get('/menu-create-form', 'MenuController@create_form')->name('menu-create-form');
    Route::get('/menu-feature-create-form', 'MenuController@create_feature_form')->name('menu-feature-create-form');

    Route::get('/menu-feature-table', 'MenuController@getTable')->name('menu-feature-table');
    Route::post('/menu-feature-list', 'MenuController@getAllMenuFeture')->name('menu-feature-list');
    Route::post('/menu-feature-store', 'MenuController@storeMenuFeature')->name('menu-feature-store');
    Route::get('/menu-feature-create-editForm/{id}', 'MenuController@create_feature_editForm')->name('menu-feature-create-editForm');

    Route::get('/menu-privilege-table', 'MenuController@getPrivilegeTable')->name('menu-privilege-table');
    Route::post('menu-privilege-emp-search', 'MenuController@menuPrivilegeEmpSearch')->name('menu-privilege-emp-search');
    Route::post('menu-privilege-emp-info', 'MenuController@menuPrivilegeEmpInfo')->name('menu-privilege-emp-info');

    Route::get('/menu-privilege-create-form', 'MenuController@create_privilege_form')->name('menu-privilege-create-form');
    Route::post('/menu-privilege-store', 'MenuController@storeMenuPrivilege')->name('menu-privilege-store');
    // Route::post('/menu-privilege-list', 'MenuController@getAllMenuPrivilege')->name('menu-privilege-list');
    Route::get('/menu-privilege-create-editForm/{id}', 'MenuController@create_privilege_editForm')->name('menu-privilege-create-editForm');
    Route::post('/menu-feature-dropdown', 'MenuController@featuresDropdown')->name('menu-feature-dropdown');

    Route::get('/role-edit/{id}', 'MenuController@create_role_editForm')->name('role-edit');
    Route::get('/role-list', 'MenuController@getRole')->name('role-list');
    Route::post('/role-list-get', 'MenuController@getAllRole')->name('role-list-get');
    Route::get('/create-role', 'MenuController@createRole')->name('role-create');
    Route::get('/role-create-form', 'MenuController@createRoleForm')->name('role-create-form');
    Route::get('/create-user-role-form/{id}', 'MenuController@createUserRoleForm')->name('create-user-role-form');
    Route::post('/user-role-feature-dropdown', 'MenuController@userRolefeaturesDropdown')->name('user-role-feature-dropdown');
    // Route::post('/user-role-feature-dropdown-edit', 'MenuController@userRolefeaturesDropdownEdit')->name('user-role-feature-dropdown-edit');
    Route::post('/user-role-privilege-dropdown', 'MenuController@userRolePrivisDropdown')->name('user-role-privilege-dropdown');
    Route::post('/role-store', 'MenuController@roleStore')->name('role-store');
    Route::post('/role-privilege-store', 'MenuController@storeRolePrivilege')->name('role-privilege-store');
    Route::resource('menu', 'MenuController');


    /* Role Permission */

    /*role crud*/
    Route::get('v1/settings/role', 'RolePermissionController@roleEntryV1')->name('v1.settings.role');
    Route::get('v1/settings/get-role', 'RolePermissionController@getRoleV1')->name('v1.settings.get-role');
    Route::post('v1/settings/save-role', 'RolePermissionController@saveRoleV1')->name('v1.settings.save-role');
    Route::get('v1/settings/edit-role/{id}', 'RolePermissionController@editRoleV1')->name('v1.settings.edit-role');
    Route::post('v1/settings/update-role', 'RolePermissionController@updateRoleV1')->name('v1.settings.update-role');
    /*close role crud */

    Route::get('v1/settings/role-permission', 'RolePermissionController@rolePermission')->name('v1.settings.role-permission');
    Route::get('v1/settings/get-role-permission/{id}', 'RolePermissionController@getrolePermission')->name('v1.settings.get-role-permission');
    Route::post('v1/settings/delete-user-roles', 'RolePermissionController@deleteUserRoles')->name('v1.settings.delete-user-roles');
    Route::post('v1/settings/get-multiple-role-permission', 'RolePermissionController@getMultipleRolePermission')->name('v1.settings.get-multiple-role-permission');
    Route::post('v1/settings/save-role-permission', 'RolePermissionController@saveRolePermission')->name('v1.settings.save-role-permission');
    Route::get('v1/settings/edit-role-permission/{id}', 'RolePermissionController@editAccountsSubGroup')->name('v1.settings.edit-role-permission');
    Route::post('v1/settings/update-role-permission', 'RolePermissionController@updateAccountsSubGroup')->name('v1.settings.update-role-permission');
    /* user role permission*/

    Route::get('v1/settings/user/role-permission', 'RolePermissionController@userRolePermission')->name('v1.settings.user.role-permission');
    Route::get('v1/settings/get-user-list/{id}', 'RolePermissionController@getUserList')->name('v1.settings.get-user-list');

    Route::get('v1/settings/get-user-role-permission/{id}', 'RolePermissionController@getUserRolePermission')->name('v1.settings.get-user-role-permission');

    Route::post('v1/settings/save-user-role-permission', 'RolePermissionController@saveUserRolePermission')->name('v1.settings.save-user-role-permission');
    Route::get('v1/settings/check-user-priviledge', 'RolePermissionController@checkUserPermission')->name('v1.settings.check-user-priviledge');

    Route::get('v1/settings/check-user-permission/{id}', 'RolePermissionController@checkUserPrivs')->name('v1.settings.check-user-role-permission');

    /* Role Permission */


    // Doctor routes
    Route::post('/doctor/storequickregistration', 'DoctorController@storeQuickRegistration')->name('doctor.storequickregistration');
    Route::get('/doctor/createquickregistration/{doc_type?}', 'DoctorController@createQuickRegistration')->name('doctor.createquickregistration');
    Route::get('/doctor/createquickregistration-pres/{doc_type?}', 'DoctorController@createQuickRegistrationPres')->name('doctor.createquickregistration-pres');
    Route::post('/doctor_fee_setup_store', 'DoctorController@doctorFeeSetupStore')->name('doctor-fee-setup-store');
    Route::post('/get-employee-list', 'DoctorController@getAllDoctors')->name('get-employee-list');
    Route::get('/get-employee-list-v1', 'DoctorController@getAllDoctorsv1')->name('get-employee-list-v1');
    Route::post('doctor/loadList', 'DoctorController@loadList')->name('doctor.loadList');
    Route::get('/employee-card/{id}', 'DoctorController@employeeCard')->name('employee-card');
    Route::get('/doctor_fee_setup/{doctor_id}', 'DoctorController@doctorFeeSetup')->name('doctor-fee-setup');
    Route::post('/doctor-degree', 'DoctorController@doctorDegreeAutocomplete')->name('doctor-degree');
    Route::post('get-doctors-by-specl', 'DoctorController@get_doctors_by_specl')->name('get-doctors-by-specl');
    Route::post('get-doctors-list-by-specl', 'DoctorController@get_doctors_list_by_specl')->name('get-doctors-list-by-specl');
    Route::post('get-doctors-list-by-specl-date', 'DoctorController@get_doctors_list_by_specl_date')->name('get-doctors-list-by-specl-date');

    Route::post('doctor-info-json', 'DoctorController@doctorInfoJson')->name('doctor-info-json');
    Route::post('doctor-info-autocomplete', 'DoctorController@doctorInfoAutocomplete')->name('doctor-info-autocomplete');
    Route::post('doctor-info-autocomplete-all', 'DoctorController@doctorInfoAutocompleteAll')->name('doctor-info-autocomplete-all');
    Route::post('doctor-info-autocomplete-v3', 'DoctorController@doctorInfoAutocompletev3')->name('doctor-info-autocomplete-v3');
    Route::get('doctor/create_form', 'DoctorController@create_form')->name('doctor.create_form');
    Route::get('doctor-list-v2', 'DoctorController@doctor_list')->name('doctor-list-v2');
    Route::post('doctor/grid_list', 'DoctorController@grid_list')->name('doctor.grid_list');
    Route::get('doctor-list-v3', 'DoctorController@doctor_list_v3')->name('doctor-list-v3');
    Route::post('employee/card-list-search', 'DoctorController@employeeCardSearch')->name('employee-card-search');
    Route::get('grade_factor', 'DoctorController@get_grade_amount')->name('grade_factor');
    Route::get('all_thana_pre', 'DoctorController@allThanaPre')->name('all_thana_pre');
    Route::get('all_thana_per', 'DoctorController@allThanaPer')->name('all_thana_per');
    Route::post('employee_search', 'DoctorController@employeeSearch')->name('employee_search');
    Route::post('emp_print', 'DoctorController@empPrint')->name('emp_print');
    Route::post('emp_print_v1', 'DoctorController@empPrintV1')->name('emp_print_v1');
    Route::post('doctor-index', 'DoctorController@index')->name('doctor-index');
    Route::resource('doctor', 'DoctorController');
    Route::get('/update_employeeV1/{id}', 'DoctorController@editV1')->name('update_employeeV1');
    Route::post('storeV1', 'DoctorController@storeV1')->name('storeV1');
    Route::post('get_last_card_number', 'DoctorController@LastCardNumberV1')->name('get_last_card_number');

    Route::resource('employees', 'EmployeeController');
    Route::post('get-doctor-list', 'EmployeeController@getAllDoctor')->name('get-doctor-list');
    Route::post('get-doctor-list-search', 'EmployeeController@getAllDoctorSearch')->name('get-doctor-list-search');
    Route::post('doc_print', 'EmployeeController@docPrint')->name('doc_print');
    Route::post('ref_print', 'EmployeeController@refPrint')->name('ref_print');
    Route::post('doctor-list', 'EmployeeController@index')->name('doctor-list');
    Route::get('/doctor-card/{id}', 'EmployeeController@DoctorCard')->name('doctor-card');
    Route::post('employee/store-information', 'DoctorController@employeeStoreInformation')->name('employee.store-information');


    Route::get('employee-machine-attendance', 'EmployeeController@empMachineAttendance')->name('employee-machine-attendance');
    Route::get('employee-machine-data', 'EmployeeController@empMachineData')->name('employee-machine-data');
    Route::post('store_attendance', 'EmployeeController@storeAttendance')->name('store_attendance');
    Route::post('attendance_image_save/{id?}', 'EmployeeController@saveImage')->name('attendance_image_save');
    Route::post('attendance_save_machine/{id?}', 'EmployeeController@saveMachineAtt')->name('attendance_save_machine');

    Route::get('create-referral', 'EmployeeController@createReferral')->name('create-referral');
    Route::get('referral_show/{id}', 'EmployeeController@referralShow')->name('referral_show');
    Route::get('referral_agent_show/{id}', 'EmployeeController@referralAgentShow')->name('referral_agent_show');
    Route::get('referral_agent_show_card/{id}', 'EmployeeController@referralAgentShowCard')->name('referral_agent_show_card');
    Route::get('create-referral-popup', 'EmployeeController@createReferralPopup')->name('create-referral-popup');
    Route::get('edit-referral/{id}', 'EmployeeController@editReferral')->name('edit-referral');
    Route::get('get-referral-list', 'EmployeeController@getAllReferral')->name('get-referral-list');
    Route::post('search-referral', 'EmployeeController@searchReferral')->name('search-referral');
    Route::get('/referral-card/{id}', 'EmployeeController@referralCard')->name('referral-card');
    Route::get('/referral-card-print/{id}', 'EmployeeController@referralCardPrint')->name('referral-card-print');
    // Route::get('/emp-card-back-print', 'EmployeeController@empCardBackPrint')->name('emp-card-back-print');
    Route::get('/referral-card-print-backside/{id}', 'EmployeeController@backside')->name('referral-card-print-backside');
    Route::get('referral-list', 'EmployeeController@getReferral')->name('referral-list');

    Route::get('referral-patient-list', 'EmployeeController@referralPatientList')->name('referral-patient-list');
    Route::post('search-referral-patient', 'EmployeeController@searchReferralPatientList')->name('search-referral-patient');

    Route::get('employee-card-print-uhl/{id}', 'EmployeeController@employeeCardPrintUHL')->name('employee-card-print-uhl');
    // Route::get('referral-list', 'EmployeeController@getReferral')->name('referral-list');

    //Employee Card
    Route::resource('employee', 'EmployeeCardController');
    Route::post('employee-card-list', 'EmployeeCardController@getAllCardNumber')->name('employee-card-list');
    Route::post('employee-list', 'EmployeeCardController@getAllEmployeeList')->name('employee-list');
    Route::get('employee-card-issue-popup/{id}', 'EmployeeCardController@employeeCardIssue')->name('employee-card-issue-popup');
    Route::post('issue-card-store', 'EmployeeCardController@issueCardStore')->name('issue-card-store');

    //Salary Information
    Route::resource('salary', 'SalaryAllowanceController');
    // Route::get('gat_salary', 'SalaryAllowanceController@getSalaey')->name('get_salary');
    Route::post('get_salary_list', 'SalaryAllowanceController@getSalaryList')->name('get_salary_list');
    Route::get('bonous_edit/{id}', 'SalaryAllowanceController@bonusEdit')->name('bonous_edit');
    Route::get('salary-locked-info', 'SalaryAllowanceController@salaryLockedInfo')->name('salary-locked-info');
    Route::post('salary-locked-search', 'SalaryAllowanceController@salaryLockedSearch')->name('salary-locked-search');
    Route::post('salary-locked-update', 'SalaryAllowanceController@salaryLockedUnlocked')->name('salary-locked-update');
    Route::post('journal-advise-locked', 'SalaryAllowanceController@journalAdviseLocked')->name('journal-advise-locked');
    Route::get('bank-wise-advise', 'BankWiseAdviseController@bankWiseAdvise')->name('bank-wise-advise');

    //Refarral Doctor Route
    Route::post('doctor-referral-list', 'DoctorReferralController@getAllReferralDoctor')->name('doctor-referral-list');
    Route::get('doctor-referral/create_form', 'DoctorReferralController@create_form')->name('doctor-referral.create_form');
    Route::resource('doctor-referral', 'DoctorReferralController');

    // Marketing Agent
    Route::post('marketing-agent-list', 'MarketingAgentController@getAllMarketingAgent')->name('marketing-agent-list');
    Route::get('marketing-agent/create_form', 'MarketingAgentController@create_form')->name('marketing-agent.create_form');
    Route::resource('marketing-agent', 'MarketingAgentController');

    // Marketing Area
    Route::post('marketing-area-list', 'MarketingAreaController@getAllMarketingArea')->name('marketing-area-list');
    Route::get('marketing-area/create_form', 'MarketingAreaController@create_form')->name('marketing-area.create_form');
    Route::resource('marketing-area', 'MarketingAreaController');

    // prescription routes
    // Route::get('get-prescription-mst/{appointment}/{prescription_id?}', 'PrescriptionController@getPrescriptionMst')->name('get-prescription-mst');
    Route::get('get-prescription-dtls/{prescription_id?}', 'PrescriptionController@getPrescriptionDtls')->name('get-prescription-dtls');
    Route::get('/prescription-entry/{id?}/{patient_id?}', 'PrescriptionController@prescriptionEntry')->name('prescription-entry');
    Route::get('/prescription-view', 'PrescriptionController@prescriptionView')->name('prescription-view');
    //Route::post('add-pres-favourit-list', 'PrescriptionController@presFavouritListSaveUpdate')->name('add-pres-favourit-list');
    //Route::post('physiotherapy/load-pres-favourit-list', 'PrescriptionController@loadPresFavouritList')->name('physiotherapy.load-pres-favourit-list');
    Route::post('pres-physio-save-update', 'PrescriptionController@presPhysiotherapySaveUpdate')->name('pres-physio-save-update');
    // Route::post('pres-opd-save-update', 'PrescriptionController@presOpdSaveUpdate')->name('pres-opd-save-update');
    Route::get('prescription-print/{id}', 'PrescriptionController@printPrescription')->name('prescription-print');
    Route::get('prescription-print-pdf/{id}', 'PrescriptionController@printPrescriptionPdf')->name('prescription-print-pdf');
    Route::get('blank-prescription-form/{id}', 'PrescriptionController@blankPrescriptionForm')->name('blank-prescription-form');
    Route::post('presc-autocomplete', 'PrescriptionController@prescAutocomplete')->name('presc-autocomplete');
    Route::resource('prescription', 'PrescriptionController');


    Route::post('pcrm/referral-payment-store', 'PcrmController@referralPaymentStore')->name('pcrm.referral-payment-store');
    Route::post('pcrm/referral-payment-list', 'PcrmController@referralPaymentList')->name('pcrm.referral-payment-list');
    Route::post('pcrm/referral-payment-process', 'PcrmController@referralPaymentProcess')->name('pcrm.referral-payment-process');
    Route::get('pcrm/referral-payment', 'PcrmController@referralPayment')->name('pcrm.referral-payment');
    Route::get('pcrm/pcrm-dashboard', 'PcrmController@pcrmDashboard')->name('pcrm.pcrm-dashboard');
    Route::get('mobileapp/mobileapp-dashboard', 'PcrmController@mobileappDashboard')->name('mobileapp.mobileapp-dashboard');
    Route::get('referral-policy-print-pdf/{id}', 'PcrmController@printReferralPolicy')->name('referral-policy-print-pdf');

    // Referral
    Route::get('referral-policy-payment-process', 'PcrmController@referralPaymentv2')->name('pcrm.referral-payment-v2');
    Route::post('pcrm/referral-policy-search', 'PcrmController@searchReferralPolicy')->name('pcrm.referral-policy-search');
    Route::post('pcrm/monthly-process-search', 'PcrmController@monthlyProcessPolicy')->name('pcrm.monthly-process-search');
    Route::post('referral-policy-process', 'PcrmController@referralPolicyProcess')->name('referral-policy-process');
    Route::get('pcrm/processed-list', 'PcrmController@processedList')->name('pcrm.processed-list');
    Route::get('pcrm/refferal-payment-edit/{invoice_id?}/{type?}', 'PcrmController@refferalPaymentEdit')->name('pcrm.refferal-payment-edit');
    Route::post('pcrm/refferal-payment-update', 'PcrmController@refferalPaymentUpdate')->name('pcrm.refferal-payment-update');
    Route::post('pcrm/adjusted-amount-admission', 'PcrmController@adjustingAmountAdmission')->name('pcrm/adjusted-amount-admission');
    // Route::post('pcrm/admission-refferal-payment-update', 'PcrmController@refferalPaymentUpdateAdm')->name('pcrm.admission-refferal-payment-update');
    Route::post('pcrm/referral-payment-search', 'PcrmController@searchReferralPayment')->name('pcrm.referral-payment-search');
    Route::get('pcrm/refferral_payment_pdf/{id}/{print_id?}', 'PcrmController@printReferralPayment')->name('pcrm.refferral_payment_pdf');
    Route::get('pcrm/refferral_payment_pdf-admission/{id}/{print_id?}', 'PcrmController@printReferralPaymentAdm')->name('pcrm.refferral_payment_pdf_adm');

    Route::post('pcrm/referral-payment-ind-update', 'PcrmController@referralPaymentIndUpdate')->name('pcrm.referral-payment-ind-update');
    //pcrm report
    Route::get('pcrm/referral-details-report', 'PcrmController@referralDetaislReport')->name('pcrm.referral-details-report');
    Route::post('pcrm/referral-details-report-search', 'PcrmController@referralDetaislReportSearch')->name('pcrm.referral-details-report-search');
    Route::post('pcrm/referral-details-report-pdf', 'PcrmController@referralDetaislReportPdf')->name('pcrm.referral-details-report-pdf');



    Route::get('pcrm/referral-payment-bill', 'PcrmController@referralPaymentBill')->name('pcrm.referral-payment-bill');
    Route::post('pcrm/referral-payment-bill-search', 'PcrmController@referralPaymentBillSearch')->name('pcrm.referral-payment-bill-search');
    Route::post('pcrm/referral-payment-bill-pdf', 'PcrmController@referralPaymentBillPdf')->name('pcrm.referral-payment-bill-pdf');


    Route::get('pcrm/referral-summary-report', 'PcrmController@referralSummarylReport')->name('pcrm.referral-summary-report');
    Route::post('pcrm/referral-summary-report-search', 'PcrmController@referralSummaryReportSearch')->name('pcrm.referral-summary-report-search');
    Route::post('pcrm/referral-summary-report-pdf', 'PcrmController@referralSummaryReportPdf')->name('pcrm.referral-summary-report-pdf');



    Route::get('cashier-summary-report', 'ReportController@CashierSummaryReport')->name('cashier.financial-summary-report');
    Route::post('cashier-summary-report-search', 'ReportController@CashierSummaryReportSearch')->name('cashier.financial-summary-report-search');
    Route::post('cashier-summary-report-pdf', 'ReportController@CashierSummaryReportPdf')->name('cashier.financial-summary-report-pdf');

    //due report
    Route::get('financial-due-report', 'ReportController@financialDueReport')->name('financial-due-report');
    Route::post('financial-due-report-search', 'ReportController@financialDueReportSearch')->name('financial-due-report-search');
    Route::post('financial-due-report-pdf', 'ReportController@financialDueReportPdf')->name('financial-due-report-pdf');

    //suplier payment requsition

    Route::get('suplier-payment-requsition', 'SupplierController@suplierPaymentRequsition')->name('suplier-payment-requsition');
    Route::post('supplier_payment_requ_po_list', 'SupplierController@suplierPaymentPoList')->name('supplier_payment_requ_po_list');
    Route::post('supplier_payment_requ_po_store', 'SupplierController@suplierPaymentPoStore')->name('supplier_payment_requ_po_store');
    Route::get('suplier-payment-invoice/{invoice_id}', 'SupplierController@suplierPaymentinvoice')->name('suplier-payment-invoice');
    Route::get('suplier-payment-invoice_print/{invoice_id}', 'SupplierController@suplierPaymentInvoicePrint')->name('suplier-payment-invoice_print');
    // Route::get('suplier-payment', 'SupplierController@supplierPayment')->name('suplier-payment');

    //Report Route
    Route::post('/reports/get-daily-report', 'ReportController@dailyReportData')->name('reports.get-daily-report');
    Route::get('/reports/daily-sales', 'ReportController@dailySalesReport')->name('reports.daily-sales');
    Route::get('/reports/daily-collection', 'ReportController@dailyCollectionReport')->name('reports.daily-collection');
    Route::get('/reports/daily-discount', 'ReportController@dailyDiscountReport')->name('reports.daily-discount');
    Route::get('report/invoice_view/{id}', 'ReportController@reportInvoiceView')->name('report.invoice_view');
    Route::post('report/invoice_print', 'ReportController@reportFinancialPrint')->name('report.invoice_print');
    Route::post('report/daily_report_print', 'ReportController@reportDailyPrint')->name('report.daily_report_print');
    Route::get('report/pharmacy_profit_loss', 'ReportController@pharmacy_profit_loss')->name('report.pharmacy-profit-loss');
    Route::post('report/pharmacy_profit_loss_html', 'ReportController@pharmacy_profit_loss_html')->name('report.profit_loss_rpt_html');
    Route::post('report/pharmacy_profit_loss_pdf', 'ReportController@pharmacy_profit_loss_pdf')->name('report.profit_loss_rpt_pdf');


    Route::post('invoice-info-autocomplete', 'ReportController@invoiceInfoAutocomplete')->name('invoice-info-autocomplete');
    Route::post('pos-invoice-info-autocomplete', 'ReportController@posInvoiceInfoAutocomplete')->name('pos-invoice-info-autocomplete');
    Route::post('cafe-invoice-info-autocomplete', 'ReportController@cafeInvoiceInfoAutocomplete')->name('cafe-invoice-info-autocomplete');
    Route::post('appoint-info-autocomplete', 'ReportController@appointmentInfoAutocomplete')->name('appoint-info-autocomplete');
    Route::post('/reports/get-financial', 'ReportController@financialSummaryReportData')->name('reports.get-financial');
    Route::get('/reports/financial-summary', 'ReportController@financialSummaryReport')->name('reports.financial-summary');
    Route::post('report/financial_summary_print', 'ReportController@reportFinancialSummaryPrint')->name('report.financial_summary_print');

    Route::post('financial-list', 'ReportController@financialReportData')->name('financial-list');
    Route::get('/reports/financial', 'ReportController@financialReport')->name('reports.financial');

    // due collection
    Route::post('due-collection-report-search', 'ReportController@dueCollectionReportSearch')->name('due-collection-report-search');
    Route::get('/reports/due-collection-report', 'ReportController@dueCollectionReport')->name('reports.due-collection-report');
    Route::post('reports/due-collection-report-print', 'ReportController@dueCollectionReportPrint')->name('reports.due-collection-report-print');

    // Item wise financial report
    Route::post('item-wise-financial-report-list', 'FinancialReportController@financialReportData')->name('item-wise-financial-report-list');
    Route::get('item-wise-financial-report', 'FinancialReportController@itemWiseFincReport')->name('item-wise-financial-report');
    Route::post('item-wise-financial-pdf', 'FinancialReportController@itemWiseFincReportPdf')->name('item-wise-financial-pdf');
    Route::get('item-wise-financial-item-dtl/{form_date?}/{to_date?}/{item_no?}', 'FinancialReportController@itemWiseFincReportDtl')->name('item-wise-financial-item-dtl');
    Route::get('item-wise-financial-item-dtl-pdf/{form_date?}/{to_date?}/{item_no?}', 'FinancialReportController@itemWiseFincReportDtlPdf')->name('item-wise-financial-item-dtl-pdf');

    /**
     * START::Item wise financial report (v1)
     */
    Route::post('item-wise-financial-report-list/v1', [FinancialReportControllerV1::class, 'financialReportData'])->name('item-wise-financial-report-list-v1');
    Route::get('item-wise-financial-report/v1', [FinancialReportControllerV1::class, 'itemWiseFincReport'])->name('item-wise-financial-report-v1');
    Route::post('item-wise-financial-pdf/v1', [FinancialReportControllerV1::class, 'itemWiseFincReportPdf'])->name('item-wise-financial-pdf-v1');
    Route::get('item-wise-financial-item-dtl/{form_date?}/{to_date?}/{item_no?}/v1', [FinancialReportControllerV1::class, 'itemWiseFincReportDtl'])->name('item-wise-financial-item-dtl-v1');
    Route::get('item-wise-financial-item-dtl-pdf/{form_date?}/{to_date?}/{item_no?}/v1', [FinancialReportControllerV1::class, 'itemWiseFincReportDtlPdf'])->name('item-wise-financial-item-dtl-pdf-v1');
    /**
     * END::Item wise financial report (v1)
     */

    Route::get('item-wise-financial-details-report', [FinancialReportControllerV1::class, 'itemWiseFincDetailsReport'])->name('item-wise-financial-details-report');
    Route::post('item-wise-financial-details-report-list', [FinancialReportControllerV1::class, 'financialDetailsReportData'])->name('item-wise-financial-details-report-list');
    Route::post('item-wise-financial-details-pdf', [FinancialReportControllerV1::class, 'itemWiseFincDetailsReportPdf'])->name('item-wise-financial-details-pdf');
    /**
     * START::Item Wise Financial Report => IPD
     */
    Route::post('item-wise-financial-report-list/ipd', [IPDFinancialReportController::class, 'financialReportData'])->name('item-wise-financial-report-list-ipd');
    Route::get('item-wise-financial-report/ipd', [IPDFinancialReportController::class, 'itemWiseFincReport'])->name('item-wise-financial-report-ipd');
    Route::post('item-wise-financial-pdf/ipd', [IPDFinancialReportController::class, 'itemWiseFincReportPdf'])->name('item-wise-financial-pdf-ipd');
    /**
     * END::Item Wise Financial Report => IPD
     */

    // Item wise financial count
    Route::get('item-wise-financial-count', 'FinancialReportController@itemWiseFincCount')->name('item-wise-financial-count');
    Route::post('item-wise-financial-count-list', 'FinancialReportController@financialCountData')->name('item-wise-financial-count-list');
    Route::post('item-wise-financial-count-pdf', 'FinancialReportController@itemWiseFincCountPdf')->name('item-wise-financial-count-pdf');
    Route::get('item-wise-financial-count-item-dtl/{form_date?}/{to_date?}/{item_no?}', 'FinancialReportController@itemWiseFincCountDtl')->name('item-wise-financial-count-item-dtl');
    Route::get('item-wise-financial-count-dtl-pdf/{form_date?}/{to_date?}/{item_no?}', 'FinancialReportController@itemWiseFincCountItemDtlPdf')->name('item-wise-financial-count-dtl-pdf');
    // medical examination report

    Route::get('medical-examination-report', 'FinancialReportController@medicalExaminationReport')->name('medical-examination-report');
    Route::get('medical-examination-report-list', 'FinancialReportController@medicalExaminationReportList')->name('medical-examination-report-list');
    Route::post('madical-examination-pat-info', 'FinancialReportController@madicalExaminationPatInfo')->name('madical-examination-pat-info');
    Route::post('medical-examination-report-store', 'FinancialReportController@madicalExaminationStore')->name('medical-examination-report-store');
    Route::get('medical-examination-report-print/{examID?}', 'FinancialReportController@medicalExaminationFormPdf')->name('medical-examination-report-print');
    // Route::post('item-wise-financial-pdf', 'FinancialReportController@itemWiseFincReportPdf')->name('item-wise-financial-pdf');

    Route::post('daily-appointed-list', 'ReportController@dailyPatientAppointmentReportData')->name('daily-appointed-list');
    Route::get('/reports/daily-appointed-patient', 'ReportController@dailyPatientAppointmentReport')->name('reports.daily-appointed-patient');
    Route::get('report/daily-appointed-print', 'ReportController@dailyPatientAppointmentPrint')->name('report.daily-appointed-print');
    Route::get('report/doctor-wise-patient-apoinment-print', 'ReportController@ReportDoctorWisePatientApoinment')->name('report.doctor-wise-patient-apoinment-print');


    Route::get('reports/doctor-wise-daily-consultation', 'ReportController@doctorWiseDailyConsultation')->name('reports.doctor-wise-daily-consultation');
    Route::post('reports/doctor-wise-daily-consultation-search', 'ReportController@doctorWiseDailyConsultationSearch')->name('reports.doctor-wise-daily-consultation-search');
    Route::get('report/doctor-wise-daily-consultation-popup/{appointment_data}', 'ReportController@doctorWiseDailyConsultationPopUp')->name('report.doctor-wise-daily-consultation-popup');
    Route::post('report/doctor-wise-daily-consultation-print', 'ReportController@doctorWiseDailyConsultationPrint')->name('report.doctor-wise-daily-consultation-print');

    Route::get('report/doctor-wise-daily-appointment', 'ReportController@doctorWiseDailyAppointment')->name('report.doctor-wise-daily-appointment');
    Route::get('report/doctor-wise-daily-appointment-popup/{appointment_data}', 'ReportController@doctorWiseDailyAppointmentPopUp')->name('report.doctor-wise-daily-appointment-popup');
    Route::post('reports/doctor-wise-daily-appointment-search', 'ReportController@doctorWiseDailyAppointmentSearch')->name('reports.doctor-wise-daily-Appointment-search');
    Route::post('reports/doctor-wise-daily-appointment-print', 'ReportController@doctorWiseDailyAppointmentPrint')->name('reports.doctor-wise-daily-Appointment-print');

    Route::get('report/cashier-wise-report', 'ReportController@cashierWiseReport')->name('report.cashier-wise-report');
    Route::get('report/date-wise-cashier-report', 'ReportController@dateWiseCashierReport')->name('report.date-wise-cashier-report');
    Route::get('report/date-wise-ipd-opd-report', 'ReportController@dateWiseIpdOpdReport')->name('report.date-wise-ipd-opd-report');
    Route::get('report/referral-report-detail', 'ReportController@referralReportDetail')->name('report.referral-report-detail');
    Route::get('report/referral-report-summary', 'ReportController@referralReportSummary')->name('report.referral-report-summary');
    Route::post('report/cashier-wise-report-search', 'ReportController@cashierWiseReportSearch')->name('report.cashier-wise-report-search');
    Route::post('report/cashier-wise-report-print', 'ReportController@cashierWiseReportPrint')->name('report.cashier-wise-report-print');
    Route::post('report/date-cashier-wise-report-search', 'ReportController@dateCashierWiseReportSearch')->name('report.date-cashier-wise-report-search');
    Route::post('report/date-cashier-wise-ipd-opd-report-search', 'ReportController@dateCashierWiseIpdOpdReportSearch')->name('report.date-cashier-wise-ipd-opd-report-search');
    Route::post('report/pharmacy-date-cashier-wise-report-search', 'ReportController@pharmacyDateCashierWiseReportSearch')->name('report.pharmacy-date-cashier-wise-report-search');

    Route::post('report/date-cashier-wise-report-print', 'ReportController@dateCashierWiseReportPrint')->name('report.date-cashier-wise-report-print');
    Route::post('report/date-cashier-wise-ipd-opd-report-print', 'ReportController@dateCashierWiseIpdOpdReportPrint')->name('report.date-cashier-wise-ipd-opd-report-print');
    Route::post('report/pharmacy-date-cashier-wise-report-print', 'ReportController@pharmacyDateCashierWiseReportPrint')->name('report.pharmacy-date-cashier-wise-report-print');

    Route::post('report/referral-wise-search-data', 'ReportController@referralWiseSearchDetail')->name('report.referral-wise-search-data');
    Route::post('report/referral-detail-print', 'ReportController@referralDetailPrint')->name('report.referral-detail-print');
    Route::post('report/referral-summary-wise-search-data', 'ReportController@referralSummaryWiseSearchDetail')->name('report.referral-summary-wise-search-data');
    Route::post('report/referral-summary-detail-print', 'ReportController@referralSummaryDetailPrint')->name('report.referral-summary-detail-print');

    Route::get('report/date-wise-complete-summary', 'ReportController@dateWiseCompleteSummary')->name('report.date-wise-complete-summary');

    Route::get('report/daily-sales-V02', 'ReportController@dailySalesV02')->name('report.daily-sales-V02');

    //Ipd All Financial Report

    Route::get('/reports/financial/ipd', 'ReportController@ipdFinancialReport')->name('reports.financial-ipd');
    Route::post('financial-list-ipd', 'ReportController@ipdFinancialReportData')->name('financial-list-ipd');
    Route::post('report/invoice_print/ipd', 'ReportController@ipdReportFinancialPrint')->name('report.invoice_print_ipd');
    Route::get('/reports/financial-summary/ipd', 'ReportController@ipdFinancialSummaryReport')->name('reports.financial-summary-ipd');
    Route::post('/reports/get-financial/ipd/summary', 'ReportController@ipdFinancialSummaryReportData')->name('reports.get-financial-ipd');
    Route::post('report/financial_summary_print/ipd', 'ReportController@ipdReportFinancialSummaryPrint')->name('report.financial_summary_print_ipd');

    Route::get('/reports/daily-sales/ipd/', 'ReportController@ipdDailySalesReport')->name('reports.daily-sales-ipd');
    Route::get('/reports/daily-collection/ipd/', 'ReportController@ipdDailyCollectionReport')->name('reports.daily-collection-ipd');
    Route::get('/reports/daily-discount/ipd/', 'ReportController@ipdDailyDiscountReport')->name('reports.daily-discount-ipd');
    Route::post('/reports/get-daily-report/ipd/', 'ReportController@ipdDailyReportData')->name('reports.get-daily-report-ipd');
    Route::get('report/invoice_view/ipd/{id}', 'ReportController@ipdReportInvoiceView')->name('report.invoice_view-ipd');
    Route::post('report/daily_report_print/ipd/', 'ReportController@ipdReportDailyPrint')->name('report.daily_report_print_ipd');

    //hrm report
    Route::get('new-daily-statement', 'ReportController@new_daily_statement')->name('new-daily-statement');
    Route::post('search-new-daily-statement', 'ReportController@search_new_daily_statement')->name('search-new-daily-statement');
    Route::get('daily-statement', 'ReportController@dailyStatement')->name('daily-statement');
    Route::post('daily-statement-search', 'ReportController@dailyStatementSearch')->name('daily-statement-search');
    Route::post('daily-statement-search-pdf', 'ReportController@pdfDailyStatementSearch')->name('daily-statement-search-pdf');

    Route::get('hrm/daily_attendance_report', 'ReportController@dailyAttendanceReport')->name('hrm.daily_attendance_report');
    Route::post('hrm/daily_attendance_report_search', 'ReportController@dailyAttendanceReportSearch')->name('hrm.daily_attendance_report_search');
    Route::post('hrm/daily_attendance_report_search_ewmch', 'ReportController@ewmchDailyAttendanceReportSearch')->name('hrm.daily_attendance_report_search_ewmch');
    Route::post('hrm/daily_attendance_report_night_shift', 'ReportController@dailyAttendanceReportNightPrint')->name('hrm.daily_attendance_report_night_shift');

    Route::post('hrm/daily_attendance_report_print', 'ReportController@dailyAttendanceReportPrint')->name('hrm.daily_attendance_report_print');
    Route::post('hrm/daily_attendance_report_excel', 'ReportController@dailyAttendanceReportexcel')->name('hrm.daily_attendance_report_excel');
    Route::post('hrm/daily_attendance_report_data_print', 'ReportController@dailyAttendanceReportDataPrint')->name('hrm.daily_attendance_report_data_print');

    Route::post('hrm/daily_attendance_report_printv1', 'ReportController@dailyAttendanceReportPrintV1')->name('hrm.daily_attendance_report_printv1');
    Route::get('hrm/individual_daily_attendance_report', 'ReportController@individualDailyAttendanceReport')->name('hrm.individual_daily_attendance_report');
    Route::post('hrm/daily_attendance_report_search_individual', 'ReportController@individualDailyAttendanceReportSearch')->name('hrm.daily_attendance_report_search_individual');
    Route::post('hrm/individual_daily_attendance_report_printv1', 'ReportController@individualDailyAttendanceReportPrintV1')->name('hrm.individual_daily_attendance_report_printv1');

    Route::post('hrm/daily_attendance_report_monthly_print', 'ReportController@dailyAttendanceReportMonthlyPrint')->name('hrm.daily_attendance_report_monthly_print');

    // new
    Route::get('hrm/daily_attendance_reportv1', 'LeaveEntryListController@dailyAttendanceReportV1')->name('hrm.daily_attendance_reportv1');
    Route::post('hrm/daily_attendance_report_searchV1', 'LeaveEntryListController@dailyAttendanceReportSearchV1')->name('hrm.daily_attendance_report_searchV1');

    Route::get('hrm/daily_machine_attendance_report', 'ReportController@dailyMachineAttendanceReport')->name('hrm.daily_machine_attendance_report');
    Route::post('hrm/daily_machine_attendance_report_search', 'ReportController@dailyMachineAttendanceReportSearch')->name('hrm.daily_machine_attendance_report_search');
    Route::post('hrm/daily_machine_attendance_report_print', 'ReportController@dailyMachineAttendanceReportPrint')->name('hrm.daily_machine_attendance_report_print');

    Route::get('hrm/job_card', 'ReportController@jobCard')->name('hrm.job_card');
    Route::post('hrm/job_card_search', 'ReportController@jobCardSearch')->name('hrm.job_card_search');
    Route::post('hrm/job_card_print', 'ReportController@jobCardPrint')->name('hrm.job_card_print');
    Route::post('hrm/job_card_excel', 'ReportController@jobCardexcel')->name('hrm.job_card_excel');

    Route::get('hrm/emp_att_rep', 'ReportController@emp_att_rep')->name('hrm.emp_att_rep');
    Route::post('hrm/emp_att_rep_search', 'ReportController@emp_att_rep_search')->name('hrm.emp_att_rep_search');
    Route::post('hrm/emp_att_rep_print', 'ReportController@emp_att_rep_print')->name('hrm.emp_att_rep_print');
    Route::post('hrm/emp_att_rep_excel', 'ReportController@emp_att_rep_excel')->name('hrm.emp_att_rep_excel');


    Route::get('hrm/daily_late_report', 'ReportController@dailyLateReport')->name('hrm.daily_late_report');
    Route::post('hrm/daily_late_report_search', 'ReportController@dailyLateReportSearch')->name('hrm.daily_late_report_search');
    Route::post('hrm/daily_late_report_print', 'ReportController@dailyLateReportPrint')->name('hrm.daily_late_report_print');
    Route::post('hrm/daily_late_report_excel', 'ReportController@dailyLateReportExcel')->name('hrm.daily_late_report_excel');
    Route::get('hrm/daily_absent_report', 'ReportController@dailyAbsentReport')->name('hrm.daily_absent_report');
    Route::post('hrm/daily_absent_report_search', 'ReportController@dailyAbsentReportSearch')->name('hrm.daily_absent_report_search');
    Route::post('hrm/daily_absent_report_print', 'ReportController@dailyAbsentReportPrint')->name('hrm.daily_absent_report_print');
    Route::post('hrm/daily_absent_report_excel', 'ReportController@dailyAbsentReportExcel')->name('hrm.daily_absent_report_excel');
    Route::get('hrm/attendance_report', 'ReportController@attendanceReport')->name('hrm.attendance_report');
    Route::post('hrm/attendance_report_search', 'ReportController@attendanceReportSearch')->name('hrm.attendance_report_search');
    Route::post('hrm/attendance_report_print', 'ReportController@attendanceReportPrint')->name('hrm.attendance_report_print');
    Route::post('hrm/attendance_report_excel', 'ReportController@attendanceReportexcel')->name('hrm.attendance_report_excel');
    Route::get('hrm/daily_leave_report', 'ReportController@dailyLeaveReport')->name('hrm.daily_leave_report');
    Route::post('hrm/daily_leave_report_search', 'ReportController@dailyLeaveReportSearch')->name('hrm.daily_leave_report_search');
    Route::post('hrm/daily_leave_report_print', 'ReportController@dailyLeaveReportPrint')->name('hrm.daily_leave_report_print');
    Route::get('hrm/daily_questionable_entry_report', 'ReportController@dailyQuestionableEntryReport')->name('hrm.daily_questionable_entry_report');
    Route::post('hrm/daily_questionable_entry_report_search', 'ReportController@dailyQuestionableEntryReportSearch')->name('hrm.daily_questionable_entry_report_search');
    Route::post('hrm/daily_questionable_entry_report_print', 'ReportController@dailyQuestionableEntryReportPrint')->name('hrm.daily_questionable_entry_report_print');
    Route::get('hrm/daily_attendance_summary_report', 'ReportController@dailyAttendanceSummaryReport')->name('hrm.daily_attendance_summary_report');
    Route::post('hrm/daily_attendance_summary_report_search', 'ReportController@dailyAttendanceSummaryReportSearch')->name('hrm.daily_attendance_summary_report_search');
    Route::post('hrm/daily_attendance_summary_report_print', 'ReportController@dailyAttendanceSummaryReportPrint')->name('hrm.daily_attendance_summary_report_print');
    Route::get('hrm/department_wise_daily_attendance_summary_report', 'ReportController@departmentWiseDailySummaryReport')->name('hrm.department_wise_daily_attendance_summary_report');
    Route::post('hrm/department_wise_daily_attendance_summary_report_search', 'ReportController@departmentWiseDailySummaryReportSearch')->name('hrm.department_wise_daily_attendance_summary_report_search');
    Route::post('hrm/department_wise_daily_attendance_summary_report_print', 'ReportController@departmentWiseDailySummaryReportPrint')->name('hrm.department_wise_daily_attendance_summary_report_print');

    Route::get('hrm/daily_manpower_summary_report', 'ReportController@dailyManpowerSummaryReport')->name('hrm.daily_manpower_summary_report');
    Route::post('hrm/daily_manpower_summary_report_search', 'ReportController@dailyManpowerSummaryReportSearch')->name('hrm.daily_manpower_summary_report_search');
    Route::post('hrm/daily_manpower_summary_report_print', 'ReportController@dailyManpowerSummaryReportPrint')->name('hrm.daily_manpower_summary_report_print');

    Route::get('hrm/daily_adjusted_entries_report', 'ReportController@dailyAdjustedEntriesReport')->name('hrm.daily_adjusted_entries_report');
    Route::post('hrm/daily_adjusted_entries_report_search', 'ReportController@dailyAdjustedEntriesReportSearch')->name('hrm.daily_adjusted_entries_report_search');
    Route::post('hrm/daily_adjusted_entries_report_print', 'ReportController@dailyAdjustedEntriesReportPrint')->name('hrm.daily_adjusted_entries_report_print');

    Route::get('hrm/monthly_attendance_details_report', 'ReportController@monthlyAttendanceDetails')->name('hrm.monthly_attendance_details_report');
    Route::post('hrm/monthly_attendance_details_report_search', 'ReportController@monthlyAttendanceDetailsSearch')->name('hrm.monthly_attendance_details_report_search');
    Route::post('hrm/monthly_attendance_details_report_print', 'ReportController@monthlyAttendanceDetailsPrint')->name('hrm.monthly_attendance_details_report_print');

    Route::get('hrm/detailed_job_card_summary_report', 'ReportController@detailedJobCardSummaryReport')->name('hrm.detailed_job_card_summary_report');
    Route::post('hrm/detailed_job_card_summary_search', 'ReportController@detailedJobCardSummarySearch')->name('hrm.detailed_job_card_summary_search');
    Route::post('hrm/detailed_job_card_summary_print', 'ReportController@detailedJobCardSummaryPrint')->name('hrm.detailed_job_card_summary_print');

    //monthly late report
    Route::get('hrm/monthly_late_report', 'ReportController@monthlyLateReport')->name('hrm.monthly_late_report');
    Route::post('hrm/monthly_late_search', 'ReportController@monthlyLateReportSearch')->name('hrm.monthly_late_search');
    Route::post('hrm/monthly_late_print', 'ReportController@monthlyLateReportPrint')->name('hrm.monthly_late_print');
    Route::get('hrm/employee-late-detail/{id}/{month_year?}/{department?}/{card_num?}', 'ReportController@employeeLateDetail')->name('hrm.employee_late_detail');

    //end monthly late report

    Route::get('hrm/leave_summary_report', 'ReportController@leaveSummaryReport')->name('hrm.leave_summary_report');
    Route::post('hrm/leave_summary_search', 'ReportController@leaveSummaryReportSearch')->name('hrm.leave_summary_search');
    Route::post('hrm/leave_summary_print', 'ReportController@leaveSummaryReportPrint')->name('hrm.leave_summary_print');
    Route::post('hrm/leave_summary_excel', 'ReportController@leaveSummaryReportexcel')->name('hrm.leave_summary_excel');

    Route::get('hrm/monthly_questionable_entry_report', 'ReportController@monthlyQuestionableEntryReport')->name('hrm.monthly_questionable_entry_report');
    Route::post('hrm/monthly_questionable_entry_report_search', 'ReportController@monthlyQuestionableEntryReportSearch')->name('hrm.monthly_questionable_entry_report_search');
    Route::post('hrm/monthly_questionable_entry_report_print', 'ReportController@monthlyQuestionableEntryReportPrint')->name('hrm.monthly_questionable_entry_report_print');

    Route::get('hrm/manually_adjusted_entries_monthly', 'ReportController@manuallyAdjustedEntriesMonthlyReport')->name('hrm.manually_adjusted_entries_monthly');
    Route::post('hrm/manually_adjusted_entries_monthly_search', 'ReportController@manuallyAdjustedEntriesMonthlySearch')->name('hrm.manually_adjusted_entries_monthly_search');
    Route::post('hrm/manually_adjusted_entries_monthly_print', 'ReportController@manuallyAdjustedEntriesMonthlyPrint')->name('hrm.manually_adjusted_entries_monthly_print');

    Route::get('hrm/overtime_sheet', 'ReportController@overTimeSheet')->name('hrm.overtime_sheet');
    Route::post('hrm/overtime_sheet_search', 'ReportController@overTimeSheetSearch')->name('hrm.overtime_sheet_search');
    Route::post('hrm/overtime_sheet_print', 'ReportController@overTimeSheetPrint')->name('hrm.overtime_sheet_print');

    Route::get('hrm/summary_wages_sheet', 'ReportController@summaryWagesSheet')->name('hrm.summary_wages_sheet');
    Route::post('hrm/summary_wages_search', 'ReportController@summaryWagesSearch')->name('hrm.summary_wages_search');
    Route::post('hrm/summary_wages_print', 'ReportController@summaryWagesPrint')->name('hrm.summary_wages_print');

    Route::get('hrm/punch_card_taker_list', 'ReportController@punchCardTakerList')->name('hrm.punch_card_taker_list');
    Route::get('hrm/punch_card_taker_search', 'ReportController@punchCardTakerSearch')->name('hrm.punch_card_taker_search');
    Route::post('hrm/punch_card_taker_print', 'ReportController@punchCardTakerPrint')->name('hrm.punch_card_taker_print');

    Route::get('hrm/yearly_late_report', 'ReportController@yearlyLateReport')->name('hrm.yearly_late_report');
    Route::post('hrm/yearly_late_report_search', 'ReportController@yearlyLateReportSearch')->name('hrm.yearly_late_report_search');
    Route::post('hrm/yearly_late_report_print', 'ReportController@yearlyLateReportPrint')->name('hrm.yearly_late_report_print');

    Route::get('hrm/yearly_absent_report', 'ReportController@yearlyAbsentReport')->name('hrm.yearly_absent_report');
    Route::post('hrm/yearly_absent_report_search', 'ReportController@yearlyAbsentReportSearch')->name('hrm.yearly_absent_report_search');
    Route::post('hrm/yearly_absent_report_print', 'ReportController@yearlyAbsentReportPrint')->name('hrm.yearly_absent_report_print');

    Route::get('hrm/monthly_absent_report', 'ReportController@monthlyAbsentReport')->name('hrm.monthly_absent_report');
    Route::post('hrm/monthly_absent_report_search', 'ReportController@monthlyAbsentReportSearch')->name('hrm.monthly_absent_report_search');
    Route::post('hrm/monthly_absent_report_print', 'ReportController@monthlyAbsentReportPrint')->name('hrm.monthly_absent_report_print');

    Route::get('hrm/employee_card', 'ReportController@employeeCard')->name('hrm.employee_card');
    Route::post('hrm/employee_card_search', 'ReportController@employeeCardSearch')->name('hrm.employee_card_search');
    Route::post('hrm/employee_id_card_print', 'ReportController@employeeCardPrint')->name('hrm.employee_id_card_print');
    // Route::get('hrm/monthly_absent_report_search', 'ReportController@monthlyAbsentReportSearch')->name('hrm.monthly_absent_report_search');
    // Route::post('hrm/monthly_absent_report_print', 'ReportController@monthlyAbsentReportPrint')->name('hrm.monthly_absent_report_print');

    Route::get('hrm/monthly_salary_sheet', 'ReportController@monthlySalarySheet')->name('hrm.monthly_salary_sheet');
    Route::get('hrm/monthly_salary_sheet_jk', 'ReportController@monthlySalarySheet2')->name('hrm.monthly_salary_sheet_jk');
    Route::get('hrm/delete-monthly_salary_sheet', 'ReportController@deleteMonthlySalarySheet')->name('hrm.delete-monthly_salary_sheet');
    Route::get('hrm/salary-process-edit-list/{id}', 'ReportController@salaryProcessEdit')->name('hrm.salary-process-edit-list');
    Route::get('hrm/attendence-edit-list/{id}', 'AttendenceController@attendenceEdit')->name('hrm.attendence-edit-list');
    Route::post('hrm/monthly_salary_search', 'ReportController@monthlySalarySearch')->name('hrm.monthly_salary_search');
    Route::post('hrm/monthly_salary_search2', 'ReportController@monthlySalarySearch2')->name('hrm.monthly_salary_search2');
    Route::post('hrm/monthly_salary_print', 'ReportController@monthlySalaryPrint')->name('hrm.monthly_salary_print');
    Route::post('hrm/monthly_salary_print_pk', 'ReportController@monthlySalaryPrintPk')->name('hrm.monthly_salary_print_pk');
    Route::post('hrm/monthly_salary_print_bank_wise', 'ReportController@monthlySalaryPrintBankWise')->name('hrm.monthly_salary_print_bank_wise');
    Route::post('hrm/monthly_salary_print_bank_wise_pk', 'ReportController@monthlySalaryPrintBankWisePk')->name('hrm.monthly_salary_print_bank_wise_pk');
    Route::get('hrm/monthly_salary_slip/{id}/{salary}', 'AttendenceController@monthlySalarySlipPrint')->name('hrm.monthly_salary_slip');
    Route::get('hrm/monthly_salary_slip_v1/{id}/{salary}', 'ReportController@monthlySalarySlipPrintV1')->name('hrm.monthly_salary_slip_v1');
    //salary sheet v1
    Route::get('v1/hrm/monthly-salary-sheet', 'ReportController@monthlySalarySheetV1')->name('hrm.monthly_salary_sheet_v1');
    Route::post('v1/hrm/monthly-salary-search', 'ReportController@monthlySalarySearchV1')->name('hrm.monthly_salary_search_v1');
    Route::post('v1/hrm/monthly-salary-print', 'ReportController@monthlySalaryPrintV1')->name('hrm.monthly_salary_print_v1');
    Route::post('hrm/specific_salary_sheet_data_update', 'ReportController@specificMonthlySalarySheetUpdate')->name('hrm.specific_salary_sheet_data_update');
    //employee salary setup
    Route::get('hrm/employee_salary', 'ReportController@employeeSalary')->name('hrm.employee_salary');
    Route::post('hrm/employee_salary_search', 'ReportController@employeeSalarySearch')->name('hrm.employee_salary_search');
    Route::post('hrm/employee_salary_print', 'ReportController@employeeSalaryPrint')->name('hrm.employee_salary_print');

    Route::get('report/doctor-income-details', 'ReportController@doctorIncomeDetails')->name('report.doctor-income-details');
    // patient-Card
    // Route::get('/patient-card', 'PatientRegistrationController@PatientCard')->name('patient-card');
    // alert Routes
    Route::get('/success-alert', 'AlertController@SuccessAlert')->name('success-alert');
    Route::get('/error-alert', 'AlertController@ErrorAlert')->name('error-alert');
    Route::get('/warning-alert', 'AlertController@WarningAlert')->name('warning-alert');
    Route::get('/confirmation-alert', 'AlertController@ConfirmationAlert')->name('confirmation-alert');

    // Radiology Routes
    // Route::post('/image-capture-update', 'RadiologyController@imagecapture_update')->name('image-capture-update');
    // Route::post('/get-image-capture-list', 'RadiologyController@get_imagecapture_list_by_search')->name('get-image-capture-list');
    // Route::post('/get-radiology-appointment-list', 'RadiologyController@get_appointment_list_by_search')->name('get-radiology-appointment-list');
    // Route::post('/radiology-list', 'RadiologyController@getAllRadiology')->name('radiology-list');
    // Route::post('invoice-info-json', 'RadiologyController@invoiceInfoJson')->name('invoice-info-json');
    Route::post('get-room', 'RadiologyController@getRoom')->name('get-room');
    // Route::get('/radiology-appointment-list', 'RadiologyController@index')->name('radiology-appointment-list');
    // Route::get('/create-radiology-appointment', 'RadiologyController@create')->name('create-radiology-appointment');
    // Route::get('/radiology-image-capture', 'RadiologyController@imageCapture')->name('radiology-image-capture');
    // Route::get('/radiology-result-entry', 'RadiologyController@resultEntry')->name('radiology-result-entry');
    // Route::post('/radiology/store','RadiologyController@store')->name('radiology.store');
    // //template part..
    Route::get('/report_template_build', 'RadiologyController@reportTemplateBuild')->name('report_template_build');
    Route::post('/report_template_store', 'RadiologyController@templateStore')->name('report_template_store');
    Route::get('/report_template', 'RadiologyController@reportRemplate')->name('report_template');
    Route::post('/report_template_list', 'RadiologyController@getAllReportTemplate')->name('report_template_list');
    Route::get('/report_template_edit/{id}', 'RadiologyController@templateEdit')->name('report_template_edit');
    Route::get('/report_template_del/{id}', 'RadiologyController@templateDel')->name('report_template_del');

    Route::get('/report_template_load', 'RadiologyController@reportRemplateLoad')->name('report_template_load');

    //Result Entry...
    Route::post('radiology/search-final-result-entry-list', 'RadiologyController@searchResultFinalizeEntryList')->name('radiology.search-final-result-entry-list');

    Route::get('radiology/rad-report-pdf/{report_id}', 'RadiologyController@resultEntryPdf')->name('radiology.rad-report-pdf');
    Route::get('v1/radiology/rad-report-pdf/{report_id}', 'RadiologyController@resultEntryPdfV1')->name('v1.radiology.rad-report-pdf');
    Route::get('radiology/rad-report-pdf-all/{report_id}', 'RadiologyController@resultEntryPdfAll')->name('radiology.rad-report-pdf-all');

    Route::get('radiology/result-finalize-wl', 'RadiologyController@radiologyResultFinalizeWorklist')->name('radiology.result-finalize-wl');

    Route::post('radiology/store-radiology-result-entry', 'RadiologyController@storeRadiologyResultEntry')->name('radiology.store-radiology-result-entry');

    Route::get('radiology/result-entry-wl', 'RadiologyController@radiologyResultEntryWorklist')->name('radiology.result-entry-wl');
    Route::get('radiology/result-entry-wl-direct', 'RadiologyController@radiologyResultEntryWorklistDirect')->name('radiology.result-entry-wl-direct');
    Route::post('radiology/appointment-search', 'RadiologyController@radiologySearchAppointment')->name('radiology.appointment-search');
    Route::post('radiology/search-result-entry-list', 'RadiologyController@searchResultEntryList')->name('radiology.search-result-entry-list');
    Route::post('radiology/search-result-entry-list-direct', 'RadiologyController@searchResultEntryListDirect')->name('radiology.search-result-entry-list-direct');
    Route::get('radiology/get-radiology-template-info', 'RadiologyController@getRadiologyTemplateInfo')->name('radiology.get-radiology-template-info');
    // Route::post('radiology/get-radiology-template-info', 'RadiologyController@getRadiologyTemplateInfo')->name('radiology.get-radiology-template-info');
    Route::get('radiology/appointment-card/{radinvoicedtl_no_pk}', 'RadiologyController@get_appointment_card')->name('radiology-appointment-card');

    Route::get('radiology/appointment-card-print/{radinvoicedtl_no_pk?}', 'RadiologyController@get_appointment_card_print')->name('radiology-appointment-card-print');
    Route::post('book.schedule-store-radt', 'RadiologyController@storeBookSchedule')->name('book.schedule-store-radt');

    Route::get('radiology/create-appointment', 'RadiologyController@radiologyCreateAppointment')->name('radiology.create-appointment');
    Route::post('radiology/search-appointment', 'RadiologyController@radiologySearchPatientInfo')->name('radiology.search-appointment');
    Route::post('radiology/search-appointment-investigation', 'RadiologyController@radiologySearchPatientInvestigation')->name('radiology.search-appointment-investigation');
    Route::post('radiology/save-radiology-appointment', 'RadiologyController@storeRadiologyAppointment')->name('radiology.save-radiology-appointment');
    Route::post('radiology/doctor/search/data', "RadiologyController@radiologyDoctorData")->name('radiology.doctor');
    Route::post('radiology/search-appointment-patient-data', 'RadiologyController@radiologySearchPatientAppData')->name('radiology.search-appointment-patient-data');
    Route::get('schedule-intervals', 'RadiologyController@generateIntervals')->name('schedule-intervals');
    Route::get('date-wise-schedule-intervals', 'RadiologyController@dateWiseGenerateIntervals')->name('date-wise-schedule-intervals');

    Route::get('radiology/create-radiology-item', 'RadiologyController@createRadiologyItem')->name('radiology.create-radiology-item');
    Route::get('radiology/appointment-list', 'RadiologyController@radiologyAppointmentList')->name('radiology.appointment-list');

    Route::get('radiology/result-entry/{radinvoicedtl_no_pk?}/{type?}', 'RadiologyController@radiologyResultEntry')->name('radiology.result-entry');
    Route::post('all_templete_name', 'RadiologyController@allRedTemp')->name('radiology.all_templete_name');
    Route::get('radiology/radiology-image-capture', 'RadiologyController@radiologyImageCapture')->name('radiology.radiology-image-capture');
    Route::get('radiology/radiology-image-capture-popup/{id}', 'RadiologyController@radiologyImageCapturePopup')->name('radiology.radiology-image-capture-popup');
    Route::get('radiology/radiology-image-capture-popupemr/{id}', 'RadiologyController@radiologyImageCapturePopupemr')->name('radiology.radiology-image-capture-popupemr');
    Route::post('radiology/radiology-image-capture-delete', 'RadiologyController@radiologyImageCaptureDelete')->name('radiology.radiology-image-capture-delete');
    Route::post('room/get_user_room_info', 'RoomController@getUserRoomInfo')->name('room.get_user_room_info');

    Route::get('radiology/update-image', 'RadiologyController@updateSearchImage')->name('radiology.update-image-capture');
    Route::post('radiology/get-room', 'RadiologyController@getRediologyRoom')->name('radiology.get-room');
    Route::get('radiology/create-image', 'RadiologyController@createSearchImage')->name('radiology.create-image-capture');
    Route::post('radiology/search-image-prescription', 'RadiologyController@searchImagePrescription')->name('radiology.search-image-prescription');
    Route::post('radiology/search-image-collected', 'RadiologyController@searchImageCollected')->name('radiology.search-image-collected');
    Route::post('radiology/search-image-pending', 'RadiologyController@searchImagePending')->name('radiology.search-image-pending');
    Route::post('radiology/update-apointment', 'RadiologyController@UpdateImageApointment')->name('radiology.update-image-apointment');
    Route::post('radiology/update-apointment-preview', 'RadiologyController@UpdateImageApointmentPreview')->name('radiology.update-image-apointment-preview');
    Route::get('doctor/apointment-shedule/{id}', 'PatientAppointmentController@viewDoctorSchedule')->name('doctor.apointment-shedule');
    Route::post('apointment.schedule_search_data', 'PatientAppointmentController@schedule_search_data')->name('apointment.schedule_search_data');

    Route::get('path/sample-collection-collect/{prescription_id?}', 'PathologyController@sampleCollectionCollect')->name('path.sample-collection-collect');
    Route::get('path/sample-collection-pending', 'PathologyController@sampleCollectionPending')->name('path.sample-collection-pending');
    Route::get('path/sample-collection-pending-ipd', 'PathologyController@sampleCollectionPendingIpd')->name('path.sample-collection-pending-ipd');
    Route::get('path/sample-collection-collected', 'PathologyController@sampleCollectionCollected')->name('path.sample-collection-collected');
    Route::get('path/sample-collection-collected-ipd', 'PathologyController@sampleCollectionCollectedIpd')->name('path.sample-collection-collected-ipd');
    Route::get('path/sample-collection-print/{lab_no}', 'PathologyController@sampleCollectionPrint')->name('path.sample-collection-print');
    Route::post('path/sample-collection-print-v2', 'PathologyController@sampleCollectionPrintV2')->name('path.sample-collection-print-v2');
    Route::post('path/sample-collection-print-all-v2', 'PathologyController@sampleCollectionPrintAllV2')->name('path.sample-collection-print-all-v2');
    Route::get('temporary-label-print/{lab_no}', 'PathologyController@temporaryLabelPrint')->name('temporary-label-print');
    Route::get('slide-label-print/{lab_no}', 'PathologyController@slideLabelPrint')->name('slide-label-print');
    Route::post('path/search-sample-collection', 'PathologyController@searchSampleCollection')->name('path.search-sample-collection');
    Route::post('path/store-sample-collection', 'PathologyController@storeSampleCollection')->name('path.store-sample-collection');
    Route::post('pathology-structure-split', 'PathologyController@pathStrucSplit')->name('pathology-structure-split');


    Route::get('sample-receive', 'PathologyController@sampleReceive')->name('sample-receive');
    Route::post('path/search-sample-receive', 'PathologyController@searchSampleReceive')->name('path.search-sample-receive');
    Route::post('path/get-pending-receive-sample', 'PathologyController@getPendingReceiveSample')->name('path.get-pending-receive-sample');
    Route::get('path/get-received-sample', 'PathologyController@getReceivedSample')->name('path.get-received-sample');
    Route::get('path/get-received-sample-list', 'PathologyController@getReceivedSampleList')->name('path.get-received-sample-list');
    Route::get('path/get-received-sample-v2', 'PathologyController@getReceivedSampleV2')->name('path.get-received-sample-v2');
    Route::post('path/store-sample-receive', 'PathologyController@storeSampleReceive')->name('path.store-sample-receive');
    Route::post('path/store-sample-receive-v2', 'PathologyController@storeSampleReceiveV2')->name('path.store-sample-receive-v2');

    Route::get('path/result-entry', 'PathologyController@resultEntry')->name('path.result-entry');
    Route::post('path/search-result-entry', 'PathologyController@resultSearch')->name('path.search-result-entry');
    Route::post('path/search-result-entry-print-delivery', 'PathologyController@resultPrintDeliverySearch')->name('path.search-result-entry-print-delivery');
    Route::post('radiology/search-result-entry-print-delivery', 'PathologyController@resultPrintDeliverySearchRad')->name('radiology.search-result-entry-print-delivery');
    Route::get('path/verified-results', 'PathologyController@verifiedResult')->name('path.verified-results');
    Route::get('result-entry-form/{report_id}/{type}/{lab_id}', 'PathologyController@resultEntryForm')->name('result-entry-form');
    Route::get('result-entry-form-cbc/{report_id}/{type}/{lab_id}', 'PathologyController@resultEntryFormCbc')->name('result-entry-form-cbc');
    Route::get('result-entry-form-elisa/{report_id}/{type}/{lab_id}', 'PathologyController@resultEntryFormElisa')->name('result-entry-form-elisa');

    Route::get('/documents/{id?}', 'PathologyController@show')->name('documents');
    Route::get('/documents-open/{id}', 'PathologyController@openWord')->name('documents-open');



    // microbiology report

    Route::get('path/result-entry-mic', 'PathologyController@resultEntryMic')->name('path.result-entry-mic');
    Route::post('path/search-result-entry-mic', 'PathologyController@resultSearchMic')->name('path.search-result-entry-mic');
    Route::get('path/verified-results-mic', 'PathologyController@verifiedResultMic')->name('path.verified-results-mic');
    //Route::get('result-entry-form/{report_id}/{type}/{item_id}', 'PathologyController@resultEntryForm')->name('result-entry-form');
    Route::post('path/store-result-entry', 'PathologyController@storeResultEntry')->name('path.store-result-entry');
    Route::post('path/store-result-entry-elisa', 'PathologyController@storeResultEntryElisa')->name('path.store-result-entry-elisa');
    // Route::get('path/bc-report-pdf/{report_id?}', 'PathologyController@resultEntryPdf')->name('path.bc-report-pdf');
    // Route::get('path/bc-report-pdf-v1/{report_id?}', 'PathologyController@resultEntryPdfV1')->name('path.bc-report-pdf-v1');
    // Route::get('path/bc-report-pdf-column-4/{report_id?}', 'PathologyController@resultEntryPdfUnireColumn4')->name('path.bc-report-pdf-column-4');
    // Route::get('path/bc-report-pdf/3column/{report_id?}', 'PathologyController@resultEntryPdf3Column')->name('path.bc-report-pdf-3column');
    // Route::get('path/bc-report-pdf-elisa/{report_id?}', 'PathologyController@resultEntryPdfElisa')->name('path.bc-report-pdf-elisa');
    Route::get('path/bc-draft-print-report-pdf/{report_id?}', 'PathologyController@resultEntryDraftPdf')->name('path.bc-draft-print-report-pdf');
    Route::get('path/result-finalize', 'PathologyController@resultFinalize')->name('path.result-finalize');
    Route::get('path/result-finalized', 'PathologyController@resultFinalized')->name('path.result-finalized');
    Route::get('path/result-finalized-mail/{type?}', 'PathologyController@resultFinalizedSendMail')->name('path.result-finalized-mail');
    // Route::get('path/result-print-mail-delivery/{type?}', 'PathologyController@resultPrintSendMailDelivery')->name('path.result-print-mail-delivery');
    Route::get('patient-path-test-history/{id}', 'PathologyController@patPathTestHistory')->name('patient-path-test-history');
    Route::get('patient-rad-test-history/{id}', 'PathologyController@patRadTestHistory')->name('patient-rad-test-history');
    Route::get('path/result-finalize-mic', 'PathologyController@resultFinalizeMic')->name('path.result-finalize-mic');
    Route::get('path/attr-report-pdf/{id?}', 'PathologyController@attrReportPdf')->name('path.attr-report-pdf');
    Route::post('path/item-wise-attr-report-pdf', 'PathologyController@itemWiseAttrReportPdf')->name('path.item-wise-attr-report-pdf');
    Route::get('path/rad-report-pdf/{report_id}', 'PathologyController@resultEntryPdf')->name('path.rad-report-pdf');
    Route::get('print-all-barcode/{prescription_id?}', 'PathologyController@printAllBarcode')->name('print-all-barcode');
    Route::get('print-all-report-admission/{admission_id?}', 'PathologyController@printAllReport')->name('print-all-report-admission');
    Route::get('receive-all-item/{lab_id?}', 'PathologyController@receiveAllItem')->name('receive-all-item');

    //Route::get('result-entry-form/{report_id}/{type}', 'PathologyController@resultEntryForm')->name('result-entry-form');
    // Route::get('result-entry-form/column-2/{report_id}/{type}/{lab_id?}', 'PathologyController@resultEntryFormColumn2')->name('result-entry-form-column2');
    // Route::get('medical-examination-report/{report_id?}/{type?}/{lab_id?}', 'PathologyController@medicalExaminationReport')->name('medical-examination-report');
    // Route::get('path/bc-report-pdf/{report_id}', 'PathologyController@resultEntryPdf')->name('path.bc-report-pdf');
    // Route::get('path/bc-report-pdf/column-2/{report_id}', 'PathologyController@resultEntryPdfColumn2')->name('path.bc-report-pdf-column-2');
    Route::get('path/bc-report-stool-pdf/column-2/{report_id}', 'PathologyController@resultEntryStoolPdfColumn2')->name('path.bc-report-stool-pdf-column-2');
    // Route::get('path/bc-report-pdf/column-2-pbf/{report_id}', 'PathologyController@resultEntryPdfPBFColumn2')->name('path.bc-report-pdf-column-2-pbf');
    Route::get('path/bc-special/column-2/{report_id}', 'PathologyController@specialReport')->name('path.bc-special-pdf-column-2');
    Route::get('path/bc-cbc/{report_id}', 'PathologyController@specialReportCbc')->name('path.bc-special-pdf-cbc');


    // Route::get('path/bc-report-pdf-pcr/{report_id}', 'PathologyController@resultEntryPdfPcr')->name('path.bc-report-pdf-pcr');

    Route::get('microbiology/result-entry-form/{report_id}/{type}/{lab_id}', 'PathologyController@resultEntryFormMic')->name('microbiology.result-entry-form');
    Route::post('path/store-result-entry-mic', 'PathologyController@storeResultEntryMic')->name('path.store-result-entry-mic');
    // Route::get('path/bc-report-pdf/mic/{report_id}', 'PathologyController@resultEntryPdfMic')->name('path.bc-report-pdf-mic');
    Route::get('histopathology/result-entry-form/{report_id}/{type}/{lab_id}', 'PathologyController@histopathResultEntryFormMic')->name('histopathology.result-entry-form');
    Route::post('histopathology/store-result-entry', 'PathologyController@histopathStoreResultEntry')->name('histopathology.store-result-entry');
    Route::get('histopathology/bc-report-pdf/{report_id}', 'PathologyController@histopathResultEntryPdf')->name('histopathology.bc-report-pdf-mic');

    Route::get('cross/result-entry-form/{report_id}/{type}/{lab_id}', 'PathologyController@resultEntryFormCm')->name('cr.result-entry-form');
    Route::post('path/store-result-entry-cross-maching', 'PathologyController@storeResultEntryCm')->name('path.store-result-entry-cross-maching');
    // Route::get('path/bc-report-pdf/cm/{report_id}', 'PathologyController@resultEntryPdfCm')->name('path.bc-report-pdf-cr');

    Route::get('gram-stain-form/{report_id}/{type}/{lab_id}', 'PathologyController@resultGramStain')->name('gram-stain-form');
    Route::post('path/gram-stain-store', 'PathologyController@storeResultGramStain')->name('path.gram-stain-store');
    Route::get('path/gram-stain-pdf/{report_id}', 'PathologyController@resultGramStainPdf')->name('path.gram-stain-pdf');

    Route::get('result-entry-afb/{report_id}/{type}/{lab_id}', 'PathologyController@resultAfbForm')->name('result-entry-afb');
    Route::post('path/result-entry-afb-store', 'PathologyController@storeResultAfb')->name('path.result-entry-afb-store');
    Route::get('path/result-entry-afb-pdf/{report_id}', 'PathologyController@resultAfbPdf')->name('path.afb-report');


    Route::get('result-entry-csf/{report_id}/{type}/{lab_id}', 'PathologyController@resultCsfForm')->name('result-entry-csf');
    Route::post('path/result-entry-csf-store', 'PathologyController@storeResultCsf')->name('path.result-entry-csf-store');
    Route::get('path/result-entry-csf-pdf/{report_id}', 'PathologyController@resultCsfPdf')->name('path.csf-report');

    // pharmacy Routes
    Route::get('pharmacy/pos', 'PharmacyController@pharmacyPOS')->name('pharmacy.pos');
    // Purchase Order Routes
    Route::get('purchase_order/pos', 'PurchaseOrderController@purchaseOrderPOS')->name('purchaseOrder.pos');
    Route::post('purchase_order/create', 'PurchaseOrderController@purchaseOrderCreate')->name('purchaseOrder.create');
    Route::post('purchase_order/Work_list', 'PurchaseOrderController@PoWorkList')->name('purchaseOrder.Work_list');
    Route::get('purchase_order/list', 'PurchaseOrderController@purchaseOrderList')->name('purchaseOrder.list');
    Route::post('purchase_order/search', 'PurchaseOrderController@purchaseOrderSearch')->name('purchaseOrder.search');
    Route::get('purchase_order/print/{id}', 'PurchaseOrderController@purchaseOrderPrint')->name('purchaseOrder.print');
    Route::get('purchase_order/receive', 'PurchaseOrderController@purchaseOrderReceive')->name('purchaseOrder.receive');



    // download purchase order
    Route::post('v2/inventory/download-purchase-order', 'PurchaseOrderController@downloadPurchaseOrderExcel')->name('v2.inventory.download-purchase-order');

    // Appontment card
    Route::get('/appointment-card', 'RadiologyController@createAppointmentCard')->name('appointment-card');
    Route::get('/appointment-card-print', 'RadiologyController@createAppointmentCardPrint')->name('appointment-card-print');

    // patient information
    Route::get('/patient-information', 'RadiologyController@patientIDCard')->name('patient-information');
    Route::post('/check-membership-no', 'PatientRegistrationController@checkMembershipNumber')->name('check-membership-no');

    // Physiotherapy information
    Route::get('/physiotherapy-schedule', 'PhysiotherapyController@physiotherapySchedule')->name('physiotherapy-schedule');
    Route::get('physiotherapy/schedule-viewer', 'PhysiotherapyController@physiotherapyScheduleViewer')->name('physiotherapy.schedule-viewer');
    Route::get('/get-service-schedule-calendar/{schedule_dt}', 'PhysiotherapyController@physiotherapyScheduleCalendar')->name('get-service-schedule-calendar');
    // Route::get('/physiotherapy/appointment-list', 'PhysiotherapyController@appointmentList')->name('physiotherapy.appointment-list');
    Route::get('physiotherapy/get-appointment-list-by-date/{appointment_date}', 'PhysiotherapyController@appointmentListByDate')->name('physiotherapy/get-appointment-list-by-date');

    Route::get('physiotherapy/service-schedule', 'PhysiotherapyController@serviceSchedule')->name('physiotherapy.service-schedule');
    Route::post('physiotherapy/service-schedule-list', 'PhysiotherapyController@serviceScheduleList')->name('physiotherapy.service-schedule-list');
    Route::get('physiotherapy-service-schedule-create/{prescription_id}', 'PhysiotherapyController@createServiceSchedule')->name('physiotherapy-service-schedule-create');
    Route::post('physiotherapy/store', 'PhysiotherapyController@store')->name('physiotherapy.store');
    Route::get('physiotherapy/patient-sc-details', 'PhysiotherapyController@patient_sc_details')->name('physiotherapy.patient-sc-details');
    Route::get('physiotherapy/service-consultation/{schedule_id}', 'PhysiotherapyController@service_consultation')->name('physiotherapy.service-consultation');
    Route::get('physiotherapy/service-consultation-invoice/{invoice_id}', 'PhysiotherapyController@service_consultation_invoice')->name('physiotherapy.service-consultation-invoice');

    Route::get('send-email', 'TestController@sendEMail');
    //Desgination Route
    Route::get('designation/create_form', 'DesignationController@create_form')->name('designation.create_form');
    Route::post('designation-list', 'DesignationController@getAllDesignation')->name('designation-list');

    Route::resource('designation', 'DesignationController');

    //Grade ...
    Route::resource("grade", "GradeController");
    Route::post('grade-list', 'GradeController@getAllGrades')->name('grade-list');
    Route::get('edit-grade-list/{id}', 'GradeController@editGradeList')->name('grade.edit-list');

    Route::get('create_grade_form', 'GradeController@create_grade_form')->name('grade.create-form');

    // Leave Setup ...
    Route::get('leave-setup-create', 'LeaveSetupController@popUpCreate')->name('crete-pop-up-leave-setup');
    Route::post('leave-setup-list', 'LeaveSetupController@getAllLeaveList')->name('leave-list');
    Route::get('edit-leave-list/{id}', 'LeaveSetupController@editGradeList')->name('leave.edit-list');
    Route::resource('leave_setup', 'LeaveSetupController');

    Route::post('check-leave-type', 'LeaveSetupController@checkLeaveType')->name('check-leave-type');
    //Holiday_entry...
    // Route::get('holiday-crete','')
    Route::resource('holiday_entry', 'HolidayEntryController');
    Route::get('holiday_entry/popup', 'HolidayEntryController@popUp')->name('holiday.popup');
    Route::post('holiday_entry_list', 'HolidayEntryController@getAllHolidaysEntry')->name('holiday-entry-list');
    Route::get('holiday_entry_list/{id}', 'HolidayEntryController@editHolidayList')->name('holiday.edit-list');

    //Leave Entry
    Route::post('leave/search-employee-leave-status', 'LeaveController@searchEmployeeLeaveStatus')->name('leave.search-employee-leave-status');
    Route::get('leave/leave-cancel/{id}', 'LeaveController@leaveCancel')->name('leave.leave-cancel');
    Route::get('leave/leave-delete', 'LeaveController@deleteLeave')->name('leave.leave-delete');
    Route::get('leave/leave-application', 'LeaveController@leaveApplication')->name('leave.leave-application');
    Route::resource('leave', 'LeaveController');

    Route::get('loan/create_form', 'LoanController@create_form')->name('loan.create_form');
    Route::post('loan-list', 'LoanController@getAllLoan')->name('loan-list');
    Route::resource('loan', 'LoanController');

    //provident fund ..

    Route::resource('provident_fund', 'ProvidentFundController');
    Route::get('provident_fund_create', 'ProvidentFundController@popUpCreate')->name('provident-fund-create');
    Route::post('provident_fund_list', 'ProvidentFundController@getAllProvidentFund')->name('provident-fund-list');
    Route::get('provident_fund_edit/{id}', 'ProvidentFundController@editProvidentFundList')->name('provident-fund.edit-list');

    //Advance Deduction..
    Route::resource('advance_deduction', 'AdvanceDeductionController');
    Route::get('advance_deduction_popup', 'AdvanceDeductionController@advance_deduction_popup')->name('advance-deduction-popup');
    Route::post('deduction/all/data', 'AdvanceDeductionController@getAllDeduction')->name('deduction.all-data');
    Route::get('advance_deduction/edit/{id}', 'AdvanceDeductionController@editAdvanceDeduction')->name('advance-deduction.edit-list');

    //HRM......
    Route::get('hrm/attendence-manual-attendence', 'AttendenceController@index')->name('hrm.attendence-manual-attendence');
    Route::get('manual_attendence_delete', 'AttendenceController@manualAttendenceDelete')->name('manual_attendence_delete');
    Route::post('hrm/attendence-manual-attendence-store', 'AttendenceController@store')->name('hrm.attendence-manual-attendence-store');

    Route::post('hrm/attendence-manual-attendence-search', 'AttendenceController@searchEmployee')->name('hrm.attendence-manual-attendence-search');
    route::post('hrm/attendence-manual-attendence-allData', 'AttendenceController@getAlldata')->name('hrm.attendence-manual-attendence-allData');
    Route::get('hrm/attendence-manual-attendence/edit/{id}', 'AttendenceController@manualAttendenceEdit')->name('hrm.attendence-manual-attendence.edit-list');

    //manual overtime
    Route::get('hrm/manual-overtime', 'AttendenceController@manualOvertime')->name('hrm.manual-overtime');
    Route::post('hrm/store-manual-overtime', 'AttendenceController@storeManualOvertime')->name('hrm.store-manual-overtime');
    Route::get('hrm/delete-manual-overtime', 'AttendenceController@deleteManualOvertime')->name('hrm.delete-manual-overtime');

    Route::post('hrm/search-manual-overtime', 'AttendenceController@searchManualOvertime')->name('hrm.search-manual-overtime');
    route::post('hrm/get-manual-overtime', 'AttendenceController@getManualOvertime')->name('hrm.get-manual-overtime');
    Route::get('hrm/edit-manual-overtime/{id}', 'AttendenceController@editManualOvertime')->name('hrm.edit-manual-overtime');

    route::post('hrm/check_in_out_process', 'AttendenceController@checkInOutProcess')->name('hrm.check_in_out_process');

    route::get('hrm/process_attendance', 'AttendenceController@process_attendance')->name('hrm.process_attendance');
    route::post('hrm/process-attendance-daily-store', 'AttendenceController@process_attendance_daily_store')->name('hrm.process-attendance-daily-store');
    route::post('hrm/process-attendance-daily-store-v1', 'AttendenceController@process_attendance_daily_store_v1')->name('hrm.process-attendance-daily-store-v1');
    Route::post('hrm-month-process-attendence-store', 'AttendenceController@monthlyAttendencestore')->name('hrm.month-process-attendence-store');
    Route::post('hrm/salary_sheet_update', 'ReportController@monthlySalarySheetUpdate')->name('hrm.salary_sheet_update');
    Route::post('hrm/salary_sheet_update_frm_attendance', 'ReportController@monthlySalarySheetUpdateFromAttendance')->name('hrm.salary_sheet_update_frm_attendance');

    Route::post('hrm/specific_salary_sheet_data_update2', 'ReportController@specificMonthlySalarySheetUpdate2')->name('hrm.specific_salary_sheet_data_update2');
    Route::post('hrm/process-attendence-search', 'AttendenceController@processAttendenceSearch')->name('hrm.process-attendence-search');
    Route::post('hrm/process-attendence-search-by-date', 'AttendenceController@processAttendenceSearchByDate')->name('hrm.process-attendence-search-by-date');
    Route::post('hrm/process-attendence-search-get-data', 'AttendenceController@getProcessAttendance')->name('hrm.process-attendence-search-get-data');
    //salary process
    Route::get('hrm/salary_process', 'AttendenceController@salaryProcessIndex')->name('hrm.salary_process');
    Route::post('hrm/salary_process_store', 'AttendenceController@salaryProcessStore')->name('hrm.salary_process_store');
    Route::post('hrm/salary_process_search', 'AttendenceController@salaryProcessSearch')->name('hrm.salary_process_search');
    Route::get('hrm/attendence-monthly', 'AttendenceController@attendenceMonthlyData')->name('hrm.attendence-monthly-data');
    Route::post('hrm/attendence-monthly-search', 'AttendenceController@attendenceMonthlySearch')->name('hrm.attendence-monthly-search');
    Route::post('hrm/attendence-monthly-pdf', 'AttendenceController@attendenceMonthlyPdf')->name('hrm.attendence-monthly-pdf');
    //cut off process attendance
    Route::get('hrm/process-attendance-cut-off', 'AttendenceController@processAttendanceCutoff')->name('hrm.process_attendance_cut_off');
    Route::post('hrm/process-attendance-cut-off-store', 'AttendenceController@attendenceCutoffStore')->name('hrm.process_attendance_cut_off_store');
    Route::post('hrm/attendence-cut-off-search', 'AttendenceController@attendenceCutOffSearch')->name('hrm.attendence-cut-off-search');

    //Overtime requisition
    Route::get('hrm/overtime-requisition', 'AttendenceController@overtimeRequisition')->name('hrm.overtime_requisition');
    Route::post('hrm/search-overtime-requisition', 'AttendenceController@searchOvertimeRequisition')->name('hrm.search_overtime_requisition');
    Route::get('hrm/all-overtime-requisition', 'AttendenceController@allOvertimeRequisition')->name('hrm.all_overtime_requisition');
    Route::post('hrm/search-all-overtime-requisition', 'AttendenceController@searchAllOvertimeRequisition')->name('hrm.search_all_overtime_requisition');

    Route::post('hrm/overtime-requisition-approve', 'AttendenceController@overtimeRequisitionApprove')->name('hrm.overtime_requisition_approve');
    Route::post('hrm/overtime-requisition-finalize', 'AttendenceController@overtimeRequisitionFinalize')->name('hrm.overtime_requisition_finalize');

    Route::get('hrm/overtime-requisition-approved-list', 'AttendenceController@overtimeRequisitionApproved')->name('hrm.overtime_requisition_approved_list');
    Route::post('hrm/search-overtime-requisition-approved-list', 'AttendenceController@searchOvertimeRequisitionApproved')->name('hrm.search_overtime_requisition_approved_list');
    Route::get('hrm/overtime-requisition-approved-detail/{id}/{att_yyyymm}', 'AttendenceController@overtimeRequisitionApprovedDetail')->name('hrm.overtime_requisition_approved_detail');

    //late list
    Route::get('hrm/late-list', 'AttendenceController@lateList')->name('hrm.late-list');
    Route::post('hrm/search-late-list', 'AttendenceController@searchLateList')->name('hrm.search-late-list');
    Route::get('hrm/late-detail/{id}/{att_yyyymm}', 'AttendenceController@lateDetail')->name('hrm.late-detail');
    Route::get('hrm/approved-late-detail/{id}/{att_yyyymm}', 'AttendenceController@approvedLateDetail')->name('hrm.approved-late-detail');
    Route::post('hrm/store-emp-late-deduction-info', 'AttendenceController@storeEmpLateDeductionInfo')->name('hrm.store-emp-late-deduction-info');

    // Roster
    Route::get('roster/create-roster-template', 'AttendenceController@createRosterTemplate')->name('roster.create-roster-template');
    Route::post('roster/store-roster-template', 'AttendenceController@storeRosterTemplate')->name('roster.store-roster-template');
    Route::get('roster/edit-roster-template/{id}', 'AttendenceController@editRosterTemplate')->name('roster.edit-roster-template');
    Route::get('roster/roster-template-list', 'AttendenceController@rosterTemplateList')->name('roster.roster-template-list');
    Route::get('roster/employee-roster', 'AttendenceController@employeeRoster')->name('roster.employee-roster');
    Route::get('roster/all-employee-roster/{type?}', 'AttendenceController@all_employeeRoster')
        ->name('roster.all.employee');
    Route::get('roster/all-employee-roster-hr', function () {
        return redirect()->route('roster.all.employee', ['type' => 'hr']);
    })->name('roster.all.employee.hr');
    Route::post('roster/search-all-employee-roster', 'AttendenceController@all_employee_roster_search')->name('roster.all.employee.search');
    Route::post('roster/search-all-employee-roster-print', 'AttendenceController@all_employee_roster_search_print')->name('roster.all.employee.search.print');

    Route::get('roster/set_roster_template', 'AttendenceController@setCreateRosterTemplate')->name('roster.set_roster_template');
    Route::get('roster/employee_roster_template', 'AttendenceController@employeeRosterTemplate')->name('roster.employee_roster_template');
    Route::post('roster/store-employee-roster', 'AttendenceController@storeEmployeeRoster')->name('roster.store-employee-roster');
    Route::post('roster/store-employee-roster-details', 'AttendenceController@storeEmployeeRosterDetails')->name('roster.store-employee-roster-details');


    Route::get('roster/emp/search/department', 'AttendenceController@autocomplete_search_dep')->name('roster.emp.search.dep');

    Route::post('roster/validate-roster', 'AttendenceController@validateRoster')->name('roster.validate-roster');
    Route::get('roster/validate-roster-edit/{id}', 'AttendenceController@validateRosterEdit')->name('roster.validate-roster-edit');
    Route::post('roster/validate-roster-delete', 'AttendenceController@validateRosterDelete')->name('roster.validate-roster-delete');
    Route::post('roster/all-roster-delete', 'AttendenceController@allRosterDelete')->name('roster.all-roster-delete');
    Route::post('roster/store-edit-roster', 'AttendenceController@storevalidateRosterEdit')->name('roster.store-edit-roster');
    Route::post('roster/employee-roster/pdf', 'AttendenceController@emp_roster_pdf')->name('roster.emp.pdf');

    //Saving Fund

    Route::get('hrm/add-saving-fund', 'AttendenceController@add_saving_fund')->name('hrm.add-saving-fund');
    Route::get('hrm/saving-fund', 'AttendenceController@saving_fund')->name('hrm.saving-fund');
    Route::post('hrm/saving-fund-store', 'AttendenceController@saving_fund_store')->name('hrm.saving-fund-store');
    Route::get('hrm/saving-fund-list', 'AttendenceController@saving_fund_list')->name('hrm.saving-fund-list');
    Route::post('hrm/saving-fund-search', 'AttendenceController@searchSavingFund')->name('hrm.saving-fund-search');
    Route::get('hrm/saving-fund-edit-list/{id}', 'AttendenceController@editSavingFund')->name('hrm.edit-saving-fund');
    Route::post('hrm/saving-fund-finalize-list', 'AttendenceController@updateSavingFinalizeInd')->name('hrm.update-saving-fund');
    Route::get('hrm/saving-fund-delete-list', 'AttendenceController@deleteSavingFund')->name('hrm.delete-saving-fund');
    Route::get('hrm/saving-fund-after-delete-list', 'AttendenceController@SavingFundList')->name('hrm.saving-fund-after-delete-list');
    // Ward Routes
    Route::post('ward/ward-setup-list', 'WardController@getAllWardSetup')->name('ward.ward-setup-list');
    Route::get('ward/create_form', 'WardController@create_form')->name('ward.create_form');
    Route::get('ward/create_form_popup', 'WardController@createwardPopup')->name('ward.create_form_popup');
    Route::post('ward/store-ward', 'WardController@storeWard')->name('ward.store-ward');
    Route::get('ward/edit-ward-setup/{id}', 'WardController@editWardSetup')->name('ward.edit-ward-setup');
    Route::get('ward/delete-ward/{id?}', 'WardController@deleteWard')->name('ward.delete-ward');
    Route::resource('ward', 'WardController');
    // Bed Routes
    Route::post('bed/bed-setup-list', 'BedController@getAllBedSetup')->name('bed.bed-setup-list');
    Route::post('bed/bed-search', 'BedController@searchStatus')->name('bed.bed-search');
    Route::get('bed/create_form', 'BedController@create_form')->name('bed.create_form');
    Route::post('bed/store-bed', 'BedController@storeBed')->name('bed.store-bed');
    Route::get('bed/edit-bed-setup/{id}', 'BedController@editBedSetup')->name('bed.edit-bed-setup');
    Route::get('bed/user_bed_setup', 'BedController@userBedSetup')->name('bed.user-bed-setup');
    Route::post('bed/ward-list', 'BedController@wardService')->name('bed.ward-list');
    Route::resource('bed', 'BedController');

    //Admission Auto Complete
    Route::post('admission-info-autocomplete', 'PatientRegistrationController@admissionInfoAutocomplete')->name('admission-info-autocomplete');
    Route::post('admission-info-get-data', 'PatientRegistrationController@admissionInfoGetData')->name('admission-info-get-data');
    Route::post('prescription-info-autocomplete', 'PatientRegistrationController@prescriptionInfoAutocomplete')->name('prescription-info-autocomplete');
    Route::post('prescription-info-get-data', 'PatientRegistrationController@prescriptionInfoGetData')->name('prescription-info-get-data');
    Route::post('item-info-autocomplete-prescription', 'PatientRegistrationController@prescriptionItemInfo')->name('item-info-autocomplete-prescription');
    Route::post('item-info-autocomplete-prescription-v1', 'PatientRegistrationController@prescriptionItemInfoV1')->name('item-info-autocomplete-prescription-v1');
    Route::post('item-info-autocomplete-admission', 'PatientRegistrationController@admissionItemInfo')->name('item-info-autocomplete-admission');
    Route::post('item-info-autocomplete-admission-v1', 'PatientRegistrationController@admissionItemInfoV1')->name('item-info-autocomplete-admission-v1');
    Route::post('item-info-autocomplete-prescription-pos', 'PatientRegistrationController@prescriptionItemInfoPos')->name('item-info-autocomplete-prescription-pos');
    Route::post('item-info-autocomplete-prescription-pos-indent', 'PatientRegistrationController@prescriptionItemInfoPosIndent')->name('item-info-autocomplete-prescription-pos-indent');
    Route::post('item-info-autocomplete-prescription-pos-v2', 'PatientRegistrationController@prescriptionItemInfoPosV2')->name('item-info-autocomplete-prescription-pos-v2');
    Route::get('get-generic-item/{generic_no?}/{service_no?}/{item_id?}', 'PatientRegistrationController@getGenericItem')->name('get-generic-item');
    Route::get('get-generic-item-v2/{generic_no?}/{service_no?}/{item_id?}', 'PatientRegistrationController@getGenericItemV2')->name('get-generic-item-v2');

    Route::post('item-info-autocomplete-admission-pos', 'PatientRegistrationController@admissionItemInfoPos')->name('item-info-autocomplete-admission-pos');
    Route::post('pathology-lab-id-autocomplete', 'PatientRegistrationController@labIdAutoComplete')->name('pathology-lab-id-autocomplete');
    Route::post('cheque-info-autocomplete', 'CorporateController@chequeInfoAutocomplete')->name('cheque-info-autocomplete');

    // Inventory Route ...

    // Route::get('inventory/item-received', 'StoreController@item_received')->name('inventory.item_receive');

    // Route::get('inventory/item-return-by_chalan', 'StoreController@item_return_by_chalan')->name('inventory.item_return');
    // Route::get('inventory/item-return-worklist', 'StoreController@item_return_worklist')->name('inventory.item_return_worklist');

    Route::get('inventory/opening-balence', 'StoreController@opening_balence')->name('inventory.opening_balence');

    // Route::post('item_receive/search', 'StoreController@search_receive')->name('serach_receive');
    //Route::get('inventory/new-item-receive-by-chalan', 'StoreController@new_receive_by_chalan')->name('inventory.new_item_receive_by_chalan');
    Route::get('inventory/new-item-receive-by-item', 'StoreController@new_receive_by_item')->name('inventory.new_item_receive_by_item');
    Route::get('inventory/show-popup-item-batch/{id?}', 'StoreController@showBatchPopup')->name('inventory.show-popup-item-batch');
    Route::get('inventory/item-batch-edit/{id?}', 'StoreController@itemBatchEditPopup')->name('inventory.item-batch-edit');
    Route::post('inventory/save-item-expiry-date', 'StoreController@saveItemExpireDate')->name('inventory.save-item-expiry-date');
    // Route::post('item_receive/autocomplete', 'StoreController@autocomplete_iteminfo')->name('item-info-autocomplete');
    // Route::post('inventory/new-item-receive', 'StoreController@storeReceive')->name('inventory.new-item-receive');

    // Route::get('pharmacy_stock_ledger', 'StoreController@pharmacy_stock_ledger')->name('pharmacy_stock_ledger');

    Route::get('idp/ipd-financial-assessment', 'IPDController@ipdFinancialAssessment')->name('idp.ipd-financial-assessment');
    Route::get('ipd/ipd-discharge-summary/{admissionID?}', 'IPDController@ipdDischargeSummary')->name('ipd.ipd-discharge-summary');
    Route::post('ipd/ipd-discharge-summary-temp', 'IPDController@ipdDischargeSummaryTemp')->name('ipd.ipd-discharge-summary-temp');
    Route::get('ipd/ipd-assessment-work-list', 'IPDController@ipdAssessmentWorkList')->name('idp.ipd-assessment-work-list');
    Route::get('ipd/ipd-business-office', 'IPDController@ipdBusinessOffice')->name('idp.ipd-business-office');
    Route::get('ipd/ipd-payment/{admission_id}', 'IPDController@ipdPayment')->name('ipd.ipd-payment');
    Route::get('ipd/ipd-pharamcy-payment/{admission_id}', 'IPDController@ipdPharmacyPayment')->name('ipd.ipd-pharmacy-payment');
    Route::get('ipd/ipd-pharamcy-cancel-data', 'IPDController@ipdPharmacyCancelData')->name('ipd.ipd-pharmacy-cancel-data');
    Route::post('ipd/ipd-pharamcy-cancel', 'IPDController@ipdPharmacyCancel')->name('ipd.ipd-pharmacy-cancel');
    Route::get('ipd/ipd-payment-discount/{admission_id}', 'IPDController@ipdPaymentDiscount')->name('ipd.ipd-payment-discount');
    Route::post('ipd/item-cancel', 'BillingController@ipdItemCancel')->name('ipd.item-cancel');

    Route::get('thirty-days-admited-patient-list', 'IPDController@thirtyDaysAdmitedPatient')->name('thirty-days-admited-patient-list');
    Route::get('today-discharge-list', 'IPDController@todayDischargeList')->name('today-discharge-list');

    // pharmacy clearance
    Route::get('ipd/pharmacy-clearance', 'IPDController@ipdPhrClearance')->name('idp.pharmacy-clearance');
    Route::get("ipd/financial-clearance2/{admissionID?}/{type?}", 'IPDController@ipdFinancialClearance2')->name('ipd.financial-clearance2');
    Route::post("ipd/update-financial-clearence2", 'IPDController@updateFinancialClearance')->name("ipd.update-financial-clearence2");
    Route::post("ipd/financial-clearance2-search", 'IPDController@ipdFinancialClearance2Search')->name('ipd.financial-clearance2-search');

    // Referral Policy Configarion

    Route::get('referral-policy-configaration', 'PcrmController@RefarralPolicyConfigaration')->name('referral-policy-configaration');
    Route::post('referral-doctor-store', 'PcrmController@refDoctorStore')->name('referral_doctor_store');
    Route::get('refferal-delete-list', 'PcrmController@deleteReflist')->name('referral-list-delete');
    Route::get('referral-policy-edit/{id}', 'PcrmController@RefPolicyEdit')->name('referral_policy_edit');
    Route::get('discount-policy-edit/{id}', 'PcrmController@disPolicyEdit')->name('discount_policy_edit');
    Route::get('item-type-policy/{id}', 'PcrmController@itemTypePolicy')->name('referral.item-type-policy');
    Route::get('item-type-policy-edit/{id}', 'PcrmController@itemWisePolicyEdit')->name('referral.item-type-policy-edit');
    Route::get('item-type-dis-policy-edit/{id}', 'PcrmController@itemWiseDisPolicyEdit')->name('item-type-dis-policy-edit');
    Route::post('referral-item-typ-store', 'PcrmController@refItemType')->name('referral-item-typ-store');

    // ipd pharmacy payment process settings
    Route::get('ipd-phr-payment-process-settings', 'PcrmController@ipdPhrPaymentProcessSettings')->name('ipd-phr-payment-process-settings');
    Route::post('ipd_medicine_inv_set_store', 'PcrmController@ipdPhrPaymentProcessSettingsStore')->name('ipd_medicine_inv_set_store');

    //end

    Route::get('department-type-policy/{id}', 'PcrmController@departmentWisePolicy')->name('department-type-policy');
    Route::post('referral-survice-unit-type-store', 'PcrmController@refUnitType')->name('referral-survice-unit-type-store');
    Route::get('dept-wise-policy-edit/{id}', 'PcrmController@DeptWisePolicyEdit')->name('dept-wise-policy-edit');
    Route::get('item-wise-policy/{id}', 'PcrmController@itemWisePolicy')->name('item-wise-policy');
    Route::post('referral-item-wise-data-store', 'PcrmController@itemWiseDataStore')->name('referral-item-wise-data-store');
    Route::get('item-policy-edit/{id}', 'PcrmController@itemTypePolicy')->name('referral.item-policy-edit');
    Route::get('item-wise-policy-edit/{id}', 'PcrmController@itemWisePolicyEditData')->name('referral.item-wise-policy-edit');
    Route::get('view-policy/{id}', 'PcrmController@policyView')->name('referral.view-policy');

    Route::post('referal-policy-autocomplete', 'PcrmController@referalPolicyAutocomplete')->name('referral.referal-policy-autocomplete');
    Route::post('discount-policy-autocomplete', 'PcrmController@discountPolicyAutocomplete')->name('referral.discount-policy-autocomplete');

    // Supplier Route

    Route::get('/supplieredit/{id}', 'SupplierController@edit_Supplier')->name('editSupplier');
    Route::get('/supplier-list', 'SupplierController@index')->name('supplier.index');
    Route::post("/supplier-alldata", "SupplierController@getAllSupplier");
    Route::get('supplier/supplierlist-popup', 'SupplierController@supplierListPopup')->name('supplier.supplierlist-popup');
    Route::get('supplier/create', 'SupplierController@supplierListCreate')->name('supplier.create');
    Route::post('supplier/supplier-list-store', 'SupplierController@supplierListStore')->name('supplier.supplier-list-store');
    Route::post('supplier/supplier-supplierlist-pdf', 'SupplierController@supplierListPDF')->name('supplier.supplierlist-pdf');

    // Prescription Interaction
    Route::get('Prescription-Interaction/drug-drug-interaction', 'PrescriptionInteractionSetupController@drugDrugInteraction')->name('Prescription-Interaction.drug-drug-interaction');
    Route::get('Prescription-Interaction/drug-drug-interaction-form', 'PrescriptionInteractionSetupController@drugDrugInteractionForm')->name('Prescription-Interaction.drug-drug-interaction-form');
    Route::get('prescription-interaction/drug-drug-interaction/edit/{id}', 'PrescriptionInteractionSetupController@prescriptionInteractionDrugDiseaseEdit')->name('prescription-interaction.drug-drug-interaction.edit');
    Route::post('prescription-interaction/drug-drug-interaction-store', 'PrescriptionInteractionSetupController@store')->name('prescription-interaction.drug-drug-interaction-store');
    Route::post('prescription-interaction/drug-drug-interaction-all-data', 'PrescriptionInteractionSetupController@drugDrugAllData')->name('prescription-interaction.drug-drug-interaction-all-data');
    Route::get('Prescription-Interaction/drug-disease-interaction', 'PrescriptionInteractionSetupController@drugDiseaseInteraction')->name('Prescription-Interaction.drug-disease-interaction');
    Route::get('Prescription-Interaction/drug-disease-interaction-form', 'PrescriptionInteractionSetupController@drugDiseaseInteractionForm')->name('Prescription-Interaction.drug-disease-interaction-form');

    Route::post('Prescription-Interaction/drug-disease-interaction-store', 'PrescriptionInteractionSetupController@storeDrugDisseaseInteract')->name('Prescription-Interaction.drug-disease-interaction-store');
    Route::post('Prescription-Interaction/drug-disease-interaction-list', 'PrescriptionInteractionSetupController@getAllDrugDiseaseInteract')->name('Prescription-Interaction.drug-disease-interaction-list');
    Route::get('Prescription-Interaction/drug-disease-interaction-edit/{id}', 'PrescriptionInteractionSetupController@editDrugDiseaseInteract')->name('Prescription-Interaction.drug-disease-interaction-edit');

    // PCRM Dashboard
    Route::post('pcrm/doctor-shedule-search', 'PcrmController@dashboardSearchData')->name('pcrm.doctor-shedule-search');
    Route::get('patient/app_info/{id}', 'PcrmController@patientAppInfo')->name('patient.app_info');
    Route::post("pcrm/call-person", "PcrmController@pcrmCallPerson")->name('pcrm.call-person');
    // EMR
    Route::get('emr/patient-emr/{invoice_id?}', 'EMRController@emr')->name('emr.patient-emr');
    Route::get('emr/patient-emr-uhl/{invoice_id?}', 'EMRController@emrUHL')->name('emr.patient-emr-uhl');
    Route::get('employee-data/{emp_id?}', 'DoctorController@employeeDt')->name('employee-data');
    Route::post('emr/all-data/{patient_id?}', 'EMRController@emrTabAllData')->name('emr.patient-current-emr-use');

    //send mail
    Route::post('send-mail-lab-report', 'EMRController@sendMailLabReport')->name('send-mail-lab-report');
    Route::post('send-sms-lab-report', 'EMRController@sendSmsLabReport')->name('send-sms-lab-report');

    Route::post('emr/all-data-uhl/{patient_id?}', 'EMRController@emrTabAllDataUHL')->name('emr.patient-current-emr-use-uhl');
    Route::get('cover/patient/emr/patient-emr-data/{patient_id?}', 'EMRController@patientEmr')->name('emr.patient-emr-data');
    Route::get('cover/doctor/emr/patient-emr-data/{patient_id?}', 'EMRController@doctorEmr')->name('emr.doctor-emr-data');
    route::post('emr/vitals-search', 'EMRController@vitalSearch')->name('emr.vitals-search');
    route::post('emr/current-medication-search', 'EMRController@currentMedicationSearch')->name('emr.current-medication-search');
    route::post('emr/current-patient', 'EMRController@currentPatientStore')->name('emr.current-patient-store');
    route::post('emr/family-disease', 'EMRController@familyDiseaseStore')->name('emr.family-disease-store');
    route::post('emr/lab-report-search', 'EMRController@labReportSearch')->name('emr.lab-report-search');
    route::post('emr/radiology-search', 'EMRController@emrRadiologySearch')->name('emr.radiology-search');
    route::post('emr/immunization-history-store', 'EMRController@immuzationHistoryStore')->name('emr.immuzation-history-store');
    Route::get('emr/immunization-delete/{id}', 'EMRController@immuzationDataDelete')->name('emr.immunization-data-delete');
    Route::get('emr/family-disease-delete/{id}', 'EMRController@familyDeseaseDataDelete')->name('emr.family-disease-data-delete');
    route::get('emr/report/{id?}', 'EMRController@emrReport')->name('emr.report');

    //referral Policy
    Route::post('referral-policy-search', 'PcrmController@searchReferralPolicy')->name('referral-policy-search');
    Route::post('referral-policy-process', 'PcrmController@referralPolicyProcess')->name('referral-policy-process');
    // discount Policy
    Route::get('pcrm/discount-policy-configation', 'PcrmController@discountPolicyConfigation')->name('pcrm.discount-policy');
    Route::post('pcrm/discount-policy-save', 'PcrmController@discountPolicyStore')->name('pcrm.discount-policy-save');
    Route::post('pcrm/get-all-data', 'PcrmController@discountGetAllData')->name('pcrm.get-all-data');
    Route::get('pcrm/edit-discount-policy', 'PcrmController@editDiscountPolicy')->name('pcrm.edit-discount-policy');
    Route::get('pcrm/item-type-wise-discount/{id}', 'PcrmController@discountItemTypeWisePolicy')->name('pcrm.item-type-wise-discount');

    Route::get('discount/department-type-policy/{id}', 'PcrmController@discountDepartmentWisePolicy')->name('discount.department-type-policy');
    Route::get('discount/department-type-policy/edit/{id}', 'PcrmController@discountDepartmentWisePolicyEdit')->name('discount.department-type-policy-edit');
    Route::post('discount/survice-unit-type-store', 'PcrmController@discountDeptStore')->name('discount.survice-unit-type-store');
    // salary Bonus
    Route::get('hrm/salary-bonus', 'AttendenceController@salaryBonus')->name('hrm.salary-bonus');
    Route::get('hrm/salary-bonus-edit/{id}', 'AttendenceController@salaryBonusEdit')->name('hrm.salary-bonus-edit');
    Route::post('hrm/salary-bonus-store', 'AttendenceController@salaryBonusStore')->name('hrm.salary-bonus-store');
    Route::post('hrm/salary-bonus-all-data', 'AttendenceController@getAllsalaryBonus')->name('hrm.salary-bonus-all-data');
    // Bank Wise Service Charge
    Route::get('bank-wise-service-charge', 'AttendenceController@bankWiseCharge')->name('hservice-charge');
    Route::get('bank-wise-service-charge-edit/{id}', 'AttendenceController@bankWiseChargeEdit')->name('service-charge-edit');
    Route::post('bank-wise-service-charge-store', 'AttendenceController@bankWiseChargeStore')->name('service-charge-store');
    Route::post('bank-wise-service-charge-all-data', 'AttendenceController@getAllbankWiseCharge')->name('service-charge-all-data');
    Route::get('bank-service-charge-list', 'AttendenceController@bankServiceChargeList')->name('bank-service-charge-list');

    // Inventory

    // Route::middleware(['auth'])->group(function () {

    // Added By Asif
    Route::get('inventory/item-received', [StoreController::class, 'item_received'])->name('inventory.item_receive');

    // search data form item receive list
    Route::post('item_receive/search', [StoreController::class, 'search_receive'])->name('inventory.serach_receive');
    Route::post('pharmacy/item_receive/search', 'StoreController@pharmacy_search_receive')->name('pharmacy.serach_receive');
    Route::post('pharmacy/item_receive_cafe_optical/search', 'StoreController@cafe_optical_search_receive')->name('pharmacy.serach_receive_cafe_optical');
    Route::post('item_receive_report_pdf_v1', 'StoreController@pharmacy_receive_report')->name('item_receive_report_pdf_v1');
    Route::post('optical_item_receive_report_pdf_v1', 'StoreController@opticalReceiveReport')->name('optical_item_receive_report_pdf_v1');
    Route::post('pharmacy/item_receive/search-report', 'StoreController@pharmacy_search_receive_report')->name('pharmacy.serach_receive_report');
    Route::get('inventory/new-item-receive-by-chalan', [StoreController::class, 'new_receive_by_chalan'])->name('inventory.new_item_receive_by_chalan');
    Route::get('pharmacy/new-item-receive-by-chalan', 'StoreController@pharmacy_new_receive_by_chalan')->name('pharmacy.new_item_receive_by_chalan');
    Route::get('pharmacy/new-item-receive-by-chalan-vat', 'StoreController@pharmacy_new_receive_by_chalan_vat')->name('pharmacy.new_item_receive_by_chalan_vat');
    Route::get('pharmacy/new-item-receive-by-chalan-cafe-optical-vat', 'StoreController@pharmacy_new_receive_by_chalan_cafe_optical_vat')->name('pharmacy.new-item-receive-by-chalan-cafe-optical-vat');
    Route::post('get-module-code', 'StoreController@getModuleCode')->name('get-module-code');
    Route::get('phamacy/medicine-barcode-print/{item_no}', 'PathologyController@phamacyBarcodePrint')->name('phamacy.barcode-print');
    Route::get('phamacy/medicine-barcode-print/all/{item_no}', 'PathologyController@phamacyBarcodePrintAll')->name('phamacy.barcode-print-all');

    Route::get('inventory/new-item-receive-by-chalan-edit/{id}', 'StoreController@new_receive_by_chalan_edit')->name('inventory.new-item-receive-by-chalan-edit');
    Route::get('inventory/new-item-receive-by-chalan-edit-inv-vat/{id}', 'StoreController@new_receive_by_chalan_edit_inv_vat')->name('inventory.new-item-receive-by-chalan-edit-inv-vat');
    Route::get('pharmacy/new-item-receive-by-chalan-edit/{id}', 'StoreController@pharmacy_new_receive_by_chalan_edit')->name('pharmacy.new-item-receive-by-chalan-edit');
    Route::get('pharmacy/new-item-receive-by-chalan-edit-vat/{id}', 'StoreController@pharmacy_new_receive_by_chalan_edit_vat')->name('pharmacy.new-item-receive-by-chalan-edit-vat');
    Route::get('pharmacy/new-item-receive-by-chalan-cafe-optical-edit-vat/{id}', 'StoreController@pharmacy_new_receive_by_chalan_cafe_optical_edit_vat')->name('pharmacy.new-item-receive-by-chalan-cafe-optical-edit-vat');
    Route::post('item_receive/autocomplete', [StoreController::class, 'autocomplete_iteminfo'])->name('item-info-autocomplete');
    Route::post('inventory/item_receive/autocomplete', 'StoreController@inventory_autocomplete_iteminfo')->name('inventory-item-info-autocomplete');
    Route::post('pharmacy/item_receive/autocomplete', 'StoreController@pharmacy_autocomplete_iteminfo')->name('pharmacy-item-info-autocomplete');
    Route::post('pharmacy/item_receive/autocomplete/indent', 'StoreController@pharmacy_autocomplete_iteminfo_indent')->name('pharmacy-item-info-autocomplete-indent');


    Route::post('item_receive/new-item-receive-issue', 'StoreController@storeReceiveCancel')->name('inventory.new-item-receive-issue');
    Route::get('inventory/item-received-worklist', 'StoreController@inventory_item_received_worklist')->name('inventory.item_received_worklist');
    Route::get('pharmacy/item-received-worklist', 'StoreController@item_received_worklist')->name('pharmacy.item_received_worklist');
    Route::get('item-received-cafe-optical-worklist', 'StoreController@item_received_cafe_optical_worklist')->name('item-received-cafe-optical-worklist');
    Route::post('inventory/item-received-show-popup', 'StoreController@item_received_show_popup')->name('inventory.item-received-show-popup');

    // start pharmacy stock ledger
    Route::get('inventory/main-store-stock', 'StoreController@inventory_main_store_stock')->name('inventory.main-store-stock');
    Route::get('inventory/grn-receive-report', 'StoreController@grnReceiveReport')->name('inventory.grn-receive-report');
    Route::get('inventory/stock-ledger', 'StoreController@inventory_stock_ledger')->name('inventory.stock-ledger');
    Route::get('inventory/stock-ledger-supplier-wish', 'StoreController@inventory_stock_ledger_supplier_wish')->name('inventory.stock-ledger-supplier-wise');
    Route::post('inventory/fetch-selected-stocks', [StoreController::class, 'fetchSelectedStocks'])->name('inventory.fetch-selected-stocks');

    //towhid

    # Stock Ledger (Imperial)
    Route::get('inventory/stock-ledger/v1', 'StoreController@inventory_stock_ledger_v1')->name('inventory.stock-ledger-v1');
    Route::post('inventory/search_stock_ledger_list/v1', 'StoreController@search_inv_stock_ledger_list_v1')->name('inventory.search_stock_ledger_list_v1');

    Route::post('inventory/search_bin_card_list', [StoreController::class, 'search_inv_bin_card_list'])->name('inventory.search_bin_card_list');

    Route::get('inventory/bin-card', 'StoreController@bin_card_main_store')->name('inventory.bin-card');
    Route::post('inventory/bin_card_stock_details', 'StoreController@bin_card_stock_details')->name('inventory.bin_card_stock_details');
    Route::post('inventory/print_bin_card_stkdt', 'StoreController@print_bin_card_stkdt');

    //towhidEnd

    //Sub Store Stock Ledger All Sub Store for Store dept.



    Route::get('inventory/stock-ledger-subStore', 'StoreController@inventory_stock_ledger_subStore')->name('inventory.stock-ledger-subStore');

    Route::get('pharmacy/stock-ledger', 'StoreController@pharmacy_stock_ledger')->name('pharmacy.stock-ledger');
    Route::get('stock-transfer-receive', 'StoreController@stockTransferReceive')->name('stock-transfer-receive');
    Route::post('stock-transfer-receive-list', 'StoreController@stockTransferReceiveList')->name('stock-transfer-receive-list');
    Route::get('stock-transfer-receive-pending-list', 'StoreController@stockTransferReceivePendingList')->name('stock-transfer-receive-pending-list');
    Route::post('stock-transfer-receive-full-received-list', 'StoreController@stockTransferReceiveFullReceivedList')->name('stock-transfer-receive-full-received-list');
    Route::post('stock-transfer-receive-full-received-pdf', 'StoreController@stockTransferReceiveFullReceivedPdf')->name('stock-transfer-receive-full-received-pdf');
    Route::post('receive-item-from-transfer', 'StoreController@receiveItemFromTransfer')->name('receive-item-from-transfer');
    Route::post('inventory/search_stock_ledger', [StoreController::class, 'search_stock'])->name('inventory.search_stock_ledger');
    Route::get('inventory/store_stock_ledger', 'StoreController@store_stock_ledger')->name('inventory.store_stock_ledger');
    Route::post('inventory/stock_details', [StoreController::class, 'stock_details'])->name('inventory.stock_details');
    Route::post('inventory/print_stock_details', [StoreController::class, 'print_stock_details'])->name('inventory.print_stock_details');
    Route::get('inventory/store_stock_ledger', 'StoreController@store_stock_ledger')->name('inventory.store_stock_ledger');

    // expire medicine return
    Route::get('pharmacy/expire-return', 'StoreController@expireReturn')->name('pharmacy.expire-return');
    Route::post('pharmacy/expire-return-search', 'StoreController@searchExpireReturn')->name('pharmacy.expire-return-search');
    Route::get('pharmacy/expire-return-pdf/{id}', 'StoreController@expMedicineReturnPdf')->name('pharmacy.expire-return-pdf');
    Route::get('pharmacy/expire-return-adj/{supplier_id}/{rec_id?}', 'StoreController@expireReturnAdj')->name('pharmacy.expire-return-adj');
    Route::get('pharmacy/expire-return-worklist', 'StoreController@expireReturnWorklist')->name('pharmacy.expire-return-worklist');
    Route::post('pharmacy/expire-return-worklist-search', 'StoreController@searchExpireReturnWorklist')->name('pharmacy.expire-return-worklist-search');

    Route::get('pharmacy/expired_medicine_disposal/{disposal_id?}', 'StoreController@expired_medicine_disposal')->name('pharmacy.expired_medicine_disposal');
    Route::post('pharmacy/expired_medicine_disposal_store/{type?}', 'StoreController@expired_medicine_disposal_store')->name('pharmacy.expired_medicine_disposal_store');
    Route::get('pharmacy/expired_medicine_disposal_report_print/{id?}', 'StoreController@expired_medicine_disposal_report_print')->name('pharmacy.expired_medicine_disposal_report_print');
    Route::get('pharmacy/expired_medicine_disposal_worklist', 'StoreController@expired_medicine_disposal_worklist')->name('pharmacy.expired_medicine_disposal_worklist');
    Route::post('pharmacy/expired_medicine_disposal_worklist_search', 'StoreController@expired_medicine_disposal_worklist_search')->name('pharmacy.expired_medicine_disposal_worklist_search');
    Route::post('pharmacy/expired_medicine_disposal_supplier_report_print', 'StoreController@disposal_supplier_report_print')->name('pharmacy.expired_medicine_disposal_supplier_report_print');

    Route::post('pharmacy/expire-return-store', 'StoreController@storeExpireReturn')->name('pharmacy.expire-return-store');
    // Item return Form
    Route::get('inventory/create-purchase-order', 'StoreController@create_inventory_purchase_order')->name('inventory.create-purhcase-order');
    Route::get('pharmacy/create-purchase-order', 'StoreController@create_pharmacy_purchase_order')->name('pharmacy.create-purhcase-order');
    Route::get('pharmacy/create-purchase-order-vat', 'StoreController@create_pharmacy_purchase_order_vat')->name('pharmacy.create-purhcase-order-vat');


    //Store item return form data
    Route::post('inventory/store-purchase-order', [StoreController::class, 'storePurchaseOrder'])->name('inventory.store_purchase_order');

    Route::get('pharmacy/item-po-worklist', 'StoreController@item_po_worklist')->name('pharmacy.item_po_worklist');
    Route::get('inventory/item-po-worklist', 'StoreController@inventory_item_po_worklist')->name('inventory.item_po_worklist');

    Route::get('inventory/purchase_order_edit/{id?}', 'StoreController@item_po_edit')->name('inventory.purchase_order_edit');
    Route::get('pharmacy/purchase_order_edit/{id?}', 'StoreController@pharmacy_item_po_edit')->name('pharmacy.purchase_order_edit');
    Route::get('pharmacy/purchase_order_edit_vat/{id?}', 'StoreController@pharmacy_item_po_edit_vat')->name('pharmacy.purchase_order_edit_vat');


    Route::get('inventory/item-reoder-level-worklist', 'StoreController@item_reorder_level_worklist')->name('inventory.item_reorder_level_worklist');


    Route::get('inventory/item-finalize-po-worklist', 'StoreController@inventory_item_finalize_po_worklist')->name('inventory.item_finalize_po_worklist');
    Route::get('pharmacy/item-finalize-po-worklist', 'StoreController@item_finalize_po_worklist')->name('pharmacy.item_finalize_po_worklist');
    Route::get('pharmacy/item-issue-po-worklist', 'StoreController@item_issue_po_worklist')->name('pharmacy.item_issue_po_worklist');
    Route::get('inventory/item-issue-po-worklist', 'StoreController@inventory_item_issue_po_worklist')->name('inventory.item_issue_po_worklist');

    Route::post('inventory/default-supplier-items', [StoreController::class, 'defaultSupplierItems'])->name('inventory.default_supplier_items');
    Route::post('pharmacy/default-supplier-items', 'StoreController@pharmacydefaultSupplierItems')->name('pharmacy.default_supplier_items');

    Route::post('inventory/last-supplier-purchase-order-items', [StoreController::class, 'lastSupplierPurchaseOrderItems'])->name('inventory.last_supplier_purchase_order_items');
    Route::post('pharmacy/last-supplier-purchase-order-items', 'StoreController@pharmacylastSupplierPurchaseOrderItems')->name('pharmacy.last_supplier_purchase_order_items');

    Route::get('inventory/purchase-order-worklist', [StoreController::class, 'purchaseOrderWorklist'])->name('inventory.purchase_order_worklist');

    Route::get('inventory/purchase-order-print/{purchase_order_id}', 'StoreController@invPurchaseOrderPrint')->name('inventory.purchase_order_print');
    Route::get('pharmacy/purchase-order-print/{purchase_order_id}', 'StoreController@purchaseOrderPrint')->name('pharmacy.purchase_order_print');
    Route::get('pharmacy/purchase-order-vat-print/{purchase_order_id}', 'StoreController@purchaseOrderPrintVat')->name('pharmacy.purchase_order_print_vat');
    Route::get('pharmacy/pharmacy-purchase-order-print/{purchase_order_id}', 'StoreController@pharmacyPurchaseOrderPrint')->name('pharmacy.purchase_order_print');


    Route::get('inventory/stock-in-out', [StoreController::class, 'stockInOut'])->name('inverut');
    Route::get('pharmacy/stock-in-out', 'StoreController@pharmacy_stockInOut')->name('pharmacy.inverut');
    Route::get('pharmacy/expired-stock-in-out', 'StoreController@pharmacy_expiredStockInOut')->name('pharmacy.expired-stock-in-out');

    Route::get('inventory/create-stock-in-out', [StoreController::class, 'createStockInOut'])->name('inventory.create_stock_in_out');

    Route::post('inventory/store-stock-in-out', [StoreController::class, 'storeStockInOut'])->name('inventory.store_stock_in_out');

    Route::get('inventory/stock-out-worklist', [StoreController::class, 'stockOutWorklist'])->name('inventory.stock_out_worklist');
    Route::get('pharmacy/stock-out-worklist', 'StoreController@pharmacy_stockOutWorklist')->name('pharmacy.stock_out_worklist');
    Route::get('pharmacy/expired-stock-out-worklist', 'StoreController@pharmacy_expiredStockOutWorklist')->name('pharmacy.expired-stock_out_worklist');

    Route::get('item_received_by_chalan', 'StoreController@inventory_item_received_by_chalan')->name('item_receive');
    Route::get('pharmacy-item-received-by-chalan', 'StoreController@pharmacy_item_received_by_chalan')->name('pharmacy.pharmacy_item_receive');

    Route::get('item_received_by_item', 'StoreController@item_received_by_item')->name('item_receive_by_item');
    Route::get('pharmacy-item-received-by-item', 'StoreController@pharmacy_item_received_by_item')->name('pharmacy.pharmacy_item_receive_by_item');

    Route::get('get_item_list_by_purchase_order', 'StoreController@get_item_list_by_purchase_order')->name('get_item_list_by_purchase_order');
    Route::get('pharmacy/get_item_list_by_purchase_order', 'StoreController@pharmacy_get_item_list_by_purchase_order')->name('pharmacy.get_item_list_by_purchase_order');

    Route::get('inventory/stock_adjustment', 'StoreController@stock_adjustment')->name('inventory.stock_adjustment');
    Route::get('inventory/stock_adjustment_sub_main', 'StoreController@stock_adjustment_sub_main')->name('inventory.stock_adjustment_sub_main');

    Route::get('pharmacy/stock_adjustment', 'StoreController@pharmacy_stock_adjustment')->name('pharmacy.stock_adjustment');

    Route::post('inventory/stock_ledger_list', 'StoreController@stock_ledger_list')->name('inventory.stock_ledger_list'); // store_stock_adjustment
    Route::post('inventory/search_stock_ledger_list', 'StoreController@search_inv_stock_ledger_list')->name('inventory.search_stock_ledger_list');
    Route::post('inventory/search_stock_ledger_list_subStore', 'StoreController@search_inv_stock_ledger_list_subStore')->name('inventory.search_stock_ledger_list_subStore');
    Route::post('pharmacy/search_stock_ledger_list', 'StoreController@search_stock_ledger_list')->name('pharmacy.search_stock_ledger_list');
    Route::post('inventory/filtter-stock-ledger-list', 'StoreController@filtter_stock_ledger_list')->name('inventory.filtter-stock-ledger-list');

    Route::get('inventory/item_return_worklist', 'StoreController@item_return_worklist')->name('inventory.item_return_worklist');

    Route::post('inventory/store_stock_adjustment', 'StoreController@store_stock_adjustment')->name('inventory.store_stock_adjustment');

    Route::get('item_return_by_challan_popup/{id}', 'StoreController@item_return_by_challan_popup')->name('inventory.item_return_by_challan_popup');

    Route::post('inventory/serach_return_item', 'StoreController@serach_return_item')->name('inventory.serach_return_item');

    Route::post('inventory/item_po_issue_finalize', 'StoreController@item_po_issue_finalize')->name('inventory.item_po_issue_finalize');

    Route::post("inventory/search_po_worklist", "StoreController@search_po_worklist")->name('inventory.search_po_worklist');
    Route::post("pharmacy/search_po_worklist", "StoreController@pharmacy_search_po_worklist")->name('pharmacy.search_po_worklist');
    Route::post("inventory/delete_po", "StoreController@deletePo")->name('inventory.delete_po');
    // });



    Route::post('inventory/searchStockInItem', "StoreController@searchStockInItem")->name('inventory.search_stock_in_item');
    Route::post('pharmacy/searchStockInItem', "StoreController@pharmacy_searchStockInItem")->name('pharmacy.search_stock_in_item');
    Route::post('pharmacy/searchExpiredStockInItem', "StoreController@pharmacy_searchExpiredStockInItem")->name('pharmacy.search_expired_stock_in_item');
    Route::post('inventory/searchStockOutItem', "StoreController@searchStockOutItem")->name('inventory.search_stock_out_item');
    Route::post('pharmacy/searchStockOutItem', "StoreController@pharmacy_searchStockOutItem")->name('pharmacy.search_stock_out_item');
    Route::post('pharmacy/searchExpiredStockOutItem', "StoreController@pharmacy_searchExpiredStockOutItem")->name('pharmacy.search_expired_stock_out_item');


    Route::get('hrm/leave-entry-report', 'ReportController@leaveEntryReport')->name('reports.leave-entry-report');
    Route::post('reports/leave-entry-report-search', 'ReportController@leaveEntryReportSearch')->name('reports.leave-report-search');
    Route::get('hrm/monthly-bonus-report', 'ReportController@MonthlyBonusReport')->name('hrm.monthly-bonus-report');
    Route::post('report/monthly-bonus-search', 'ReportController@bonusReportSearch')->name('report.monthly-bonus-report-search');
    Route::post('report/monthly-bonus-report-print', 'ReportController@bonusReportPrint')->name('report.monthly-bonus-report-print');
    Route::post('report/leave-entry-report-print', 'ReportController@leaveReportPrint')->name('report.leave-entry-report-print');
    Route::get('report/leave-entry-report/{id}', 'ReportController@leaveEntryReportData')->name('report.leave-entry-report-data');
    Route::get('hrm/bonus_salary_slip/{id}/{salary}', 'ReportController@BonusSalarySlipPrint')->name('hrm.bonus_salary_slip');

    Route::post('hrm/monthly_bonus_salary_print_bank_wise', 'ReportController@monthlyBonusSalaryPrintBankWise')->name('hrm.monthly_bonus_salary_print_bank_wise');

    Route::get('hrm/employee_performance', 'ReportController@employePerfermanceReport')->name('hrm.employee_performance');
    Route::post('hrm/employee_performance_search_data', 'ReportController@employeePerfermanceSearchData')->name('hrm.employee_performance_search_data');
    Route::post('hrm/employee_performance_search_data_print', 'ReportController@employeePerfermanceSearchDataPrint')->name('hrm.employee_performance_search_data_print');

    Route::get('hrm/daily_collection', 'ReportController@dailyhrmCollectionReport')->name('hrm.daily_collection');
    Route::post('hrm/daily_collection_search_data', 'ReportController@dailyCollectionSearchData')->name('hrm.daily_collection_search_data');
    Route::post('hrm/daily_collection_search_data_print', 'ReportController@dailyCollectionSearchDataPrint')->name('hrm.daily_collection_search_data_print');

    Route::get('cashier_wise_collection', 'ReportController@CashierWiseCollectionReport')->name('hrm.cashier_wise_collection');
    Route::post('hrm/cashier_wise_collection_search_data', 'ReportController@CashierWiseCollectionSearchData')->name('hrm.cashier_wise_collection_search_data');
    Route::post('hrm/cashier_wise_collection_search_data_print', 'ReportController@CashierWiseCollectionSearchDataPrint')->name('hrm.cashier_wise_collection_search_data_print');


    //cashier wise collection type report

    Route::get('cashier-wise-collection-type-report', 'ReportController@CashierWiseCollectionTypeReport')->name('cashier-wise-collection-type-report');
    Route::post('cashier-wise-collection-type-search-data', 'ReportController@CashierWiseCollectionTypeSearchData')->name('cashier-wise-collection-type-search-data');
    Route::post('cashier-wise-collection-type-print', 'ReportController@CashierWiseCollectionTypePrint')->name('cashier-wise-collection-type-print');
    //Search Item List Server Side
    Route::post('item/item-list-search', 'ItemController@searchItemList')->name('item.search_item');
    Route::post('item/item-list-print', 'ItemController@ItemListPrint')->name('item.item-list-print');
    Route::post('cashier-info-autocomplete', 'SiteController@cashierInfoAutocomplete')->name('cashier-info-autocomplete');
    Route::get('cashier-single-print-pdf/{id?}', 'ReportController@SingleCashierCollection')->name('cashier-single-print-pdf');
    //card details Report

    Route::get('report/card-payment-details', 'ReportController@cardPaymentReport')->name('report.card-payment-details');
    Route::get('report/card-payment-details-phr', 'ReportController@cardPaymentReportPhr')->name('report.card-payment-details-phr');
    Route::post('report/card-payment-details-search', 'ReportController@cardPaymentReportSearch')->name('report.card-payment-details-search');
    Route::post('report/card-payment-details-print', 'ReportController@cardPaymentReportPrint')->name('report.card-payment-details-print');
    Route::get('report/Item-Type-Wise-Financial-Report', 'ReportController@itemTypeWiseReport')->name('report.Item-Type-Wise-Financial-Report');
    Route::get('report.item_type_wise_report_data_print_item/{id?}', 'ReportController@itemTypeWiseReportPrintItem')->name('report.item_type_wise_report_data_print');
    Route::post('report/Item-Type-Wise-Financial-Report-search', 'ReportController@itemTypeWiseSearch')->name('report.Item-Type-Wise-Financial-Report-search');
    Route::post('report/Item-Type-Wise-Financial-Report-print', 'ReportController@itemTypeWisePrint')->name('report.Item-Type-Wise-Financial-Report-print');

    //pharmacy profit lose
    Route::get('report/phr-profit-lose-Financial-Report', 'ReportController@phrProfitLose')->name('report.phr-profit-lose-Financial-Report');
    Route::post('report/phr-profit-lose-Financial-Report-search', 'ReportController@phrProfitLoseSearch')->name('report.phr-profit-lose-Financial-Report-search');
    Route::post('report/phr-profit-lose-Financial-Report-print', 'ReportController@phrProfitLosePrint')->name('report.phr-profit-lose-Financial-Report-print');
    Route::post('report/phr-profit-lose-Financial-Report-excel', 'ReportController@phrProfitLosePrintExcel')->name('report.phr-profit-lose-Financial-Report-excel');

    //Anaesthetic Record
    Route::get('anaesthetic-recort-ot', 'IPDController@anaesthiticRecordOt')->name('anaesthetic-recort-ot');
    Route::post('ot-complete-store', 'IPDController@otCompleteStore')->name('ot-complete-store');

    //ipd
    Route::get('report/ipd/card-payment-details', 'ReportController@ipdCardPaymentReport')->name('report.ipd-card-payment-details');
    Route::post('report/ipd/card-payment-details-search', 'ReportController@ipdCardPaymentReportSearch')->name('report.ipd-card-payment-details-search');
    Route::post('report/ipd/card-payment-details-print', 'ReportController@ipdCardPaymentReportPrint')->name('report.ipd-card-payment-details-print');
    //Pharmacy
    Route::get('report/pharmacy/card-payment-details', 'ReportController@pharmacyCardPaymentReport')->name('report.pharmacy-card-payment-details');
    Route::post('report/pharmacy/card-payment-details-search', 'ReportController@pharmacyCardPaymentReportSearch')->name('report.pharmacy-card-payment-details-search');
    Route::post('report/pharmacy/card-payment-details-print', 'ReportController@pharmacyCardPaymentReportPrint')->name('report.pharmacy-card-payment-details-print');

    //Management Profile
    // Added By Nazmul hasan 10 May 2021
    Route::get('profile/manage/{id}', 'DoctorController@manageProfile')->name('manage-profile');
    Route::post('profile/manage/update', 'DoctorController@profileUpdate')->name('profile-update');

    Route::post('patient/get-patient-list', 'PatientController@getPatientList')->name("patient.get-patient-list");

    Route::post('doctor/check-if-email-exits', 'DoctorController@checkIfEmailExits')->name("doctor.check-if-email-exits");

    Route::post('doctor/check-if-username-exits', 'DoctorController@checkIfUsernameExits')->name("doctor.check-if-username-exits");

    //Guest Registration
    Route::post('/registration/store/guest/registration', 'PatientRegistrationController@storeguestRegistration')->name('registration.storeguestregistration');
    Route::get('/registration/guest/create', 'PatientRegistrationController@createguestRegistration')->name('registration.guestcreate');
    //Route::get('ipd/{id}', 'iPDController@show')->name('ipd.show');

    //Added By Nazmul 26 may 2021 Prescription doctors
    Route::get("prescription/list", "PrescriptionController@prescriptionReceptionDoctor")->name("prescription-reception-doctor");
    Route::post('prescription_doctors_search', 'PrescriptionController@doctor_list_search')->name('prescription-search-doctor');
    Route::resource('doctor', 'DoctorController');
    Route::get('prescription/list', 'PrescriptionController@prescription_list')->name('prescription.list');
    Route::post('prescription/list', 'PrescriptionController@search_prescription_list')->name('prescription-list-search');
    Route::get('prescription-by-reception', 'PrescriptionController@prescription_by_reception')->name('prescription_by_reception');
    Route::get('prescription-video-call', 'PrescriptionController@prescriptionEngineVideoCall')->name('prescription-video-call');

    //Added By Nazmul 30 May 2021
    Route::get("report/process-pathology", "RadiologyController@reportProcessPathology")->name("report-process-pathology");
    Route::get("report/process-radiology", "RadiologyController@reportProcessRadiology")->name("report-process-radiology");
    Route::post("path/result-process-search", "RadiologyController@pathResultProcessSearch")->name('path.result-process-search');
    Route::post("rad/result-process-search", "RadiologyController@radResultProcessSearch")->name('rad.result-process-search');
    Route::post("path/save-data", 'RadiologyController@savePathologyUpdate')->name('path.save-checkbox');
    Route::post("rad/save-data", 'RadiologyController@saveRadiologyUpdate')->name('rad.save-checkbox');
    //Delivery Route
    Route::get("report-delivery", "RadiologyController@reportDelivery")->name("report-delivery");
    Route::post("delivery/receive-data-search", "RadiologyController@receiveDataSearch")->name('delivery.receive-data-search');
    Route::post('delivery/report-data', 'RadiologyController@deliveryAllData')->name('delivery.report-data');
    Route::post("delivery/pathology-save-data", 'RadiologyController@savePatDeliveryData')->name('delivery.pathology-save-data');
    Route::post("report-delivery-from-list-rad", 'RadiologyController@reportDeliveryFromList')->name('report-delivery-from-list');
    Route::post("report-delivery-from-list", 'RadiologyController@reportDeliveryFromListRad')->name('report-delivery-from-list-rad');
    Route::post("delivery/radiology-save-data", 'RadiologyController@saveRadDeliveryData')->name('delivery.radiology-save-data');

    //IPD Patient Report Delivery
    Route::get("ipd-patient-report-delivery", "RadiologyController@ipdPatientReportDelivery")->name("ipd-patient-report-delivery");
    Route::post("delivery/ipd-patient-receive-data-search", "RadiologyController@ipdPatientreceiveDataSearch")->name('delivery.ipd-patient-receive-data-search');
    // Route::post('delivery/report-data', 'RadiologyController@deliveryAllData')->name('delivery.report-data');
    // Route::post("delivery/pathology-save-data", 'RadiologyController@savePatDeliveryData')->name('delivery.pathology-save-data');
    // Route::post("delivery/radiology-save-data", 'RadiologyController@saveRadDeliveryData')->name('delivery.radiology-save-data');

    Route::get('delivery/radiology-label-print/{invoice_no?}', 'RadiologyController@labelPrint')->name('delivery.radiology-label-print');
    Route::get('delivery/radiology-label-print-all/{report_id}', 'RadiologyController@labelPrintAll')->name('delivery.radiology-label-print-all');

    Route::get('delivery/pathology-label-print/{invoice_no}', 'RadiologyController@labelPathologyPrint')->name('delivery.pathology-label-print');
    Route::get('delivery.pathology-label-print-all/{report_id}', 'RadiologyController@labelPathologyPrintAll')->name('delivery.pathology-label-print-all');
    Route::post('patient-and-billing-autocomplete', 'PatientRegistrationController@patientAndBillingAutocomplete')->name('patient-and-billing-autocomplete');
    Route::post('radiology/rad-report-validate', 'PathologyController@reportPrintValidate')->name('radiology.rad-report-validate');


    //Dashboard Route
    Route::get('dashboard/refresh', 'DashboardController@refresh')->name('dashboard.refresh');
    Route::get('dashboard/pharmacy/refresh', 'DashboardController@pharmacyRefresh')->name('dashboard.pharmacy-refresh');
    Route::post('dashboard/search-data', 'DashboardController@searchData')->name('dashboard/search-data');
    Route::post('dashboard/hr-data-search', 'DashboardController@dashboardsearchData')->name('dashboard.hr-data-search');
    //Discharge Report
    route::get('discharge/certificate/{id?}', 'ReportController@dischargeReport')->name('report.discharge');

    //All pharmacy Route
    Route::post('pharmacy/financial-list', 'ReportController@financialReportPharmacyData')->name('pharmacy-financial-list');
    Route::get('pharmacy/reports/financial', 'ReportController@financialPharmacyReport')->name('pharmacy-reports.financial');
    Route::post('report/pharmacy-invoice-print', 'ReportController@reportPharmacyFinancialPrint')->name('report.pharmacy-invoice-print');
    Route::post('reports/pharmacy/financial-summary/data', 'ReportController@financialPharmacySummaryReport')->name('reports.pharmacy-financial-summary-data');
    Route::get('reports/pharmacy/get-financial', 'ReportController@financialPharmacySummaryReportData')->name('reports.pharmacy-get-financial');
    Route::post('report/pharmacy/financial_summary_print', 'ReportController@reportFinancialPharmacySummaryPrint')->name('report.pharmacy-financial_summary_print');
    Route::get('report/pharmacy/date-wise-cashier-report', 'ReportController@pharmacyDateWiseCashierReport')->name('report.pharmacy-date-wise-cashier-report');

    Route::post('/reports/pharmacy/get-daily-report', 'ReportController@dailyPharmacyReportData')->name('reports.pharmacy-get-daily-report');
    Route::post('/reports/pharmacy/get-daily-summary-report', 'ReportController@dailyPharmacySummaryReportData')->name('reports.pharmacy-get-daily-summary-report');
    Route::get('/reports/pharmacy/daily-sales', 'ReportController@dailyPharmacySalesReport')->name('reports.pharmacy-daily-sales');
    Route::get('/reports/pharmacy/daily-sales-summary', 'ReportController@dailyPharmacySalesSummaryReport')->name('reports.pharmacy-daily-sales-summary');
    Route::get('/reports/pharmacy/daily-collection', 'ReportController@dailyPharmacyCollectionReport')->name('reports.pharmacy-daily-collection');
    Route::get('/reports/pharmacy/daily-discount', 'ReportController@dailyPharmacyDiscountReport')->name('reports.pharmacy-daily-discount');
    Route::get('report/pharmacy/invoice_view/{id}', 'ReportController@reportPharmacyInvoiceView')->name('report.pharmacy-invoice_view');
    Route::post('report/pharmacy/invoice_print', 'ReportController@reportPharmacyFinancialPrint')->name('report.pharmacy-invoice_print');
    Route::post('report/pharmacy/daily_report_print', 'ReportController@reportPharmacyDailyPrint')->name('report.pharmacy-daily_report_print');
    Route::post('report/pharmacy/daily_summary_report_print', 'ReportController@reportPharmacyDailySummaryPrint')->name('report.pharmacy-daily_summary_report_print');
    Route::get('report/pharmacy/cashier-wise-report', 'ReportController@PharmacyCashierWiseReport')->name('report.pharmacy-cashier-wise-report');
    Route::post('report/pharmacy/cashier-wise-report-search', 'ReportController@PharmacyCashierWiseReportSearch')->name('report.pharmacy-cashier-wise-report-search');
    Route::post('report/pharmacy/cashier-wise-report-print', 'ReportController@PharmacyCashierWiseReportPrint')->name('report.pharmacy-cashier-wise-report-print');
    Route::get('pharmacy/cashier_wise_collection', 'ReportController@PharmacyCashierWiseCollectionReport')->name('pharmacy.cashier_wise_collection');
    Route::post('pharmacy/cashier_wise_collection_search_data', 'ReportController@PharmacyCashierWiseCollectionSearchData')->name('pharmacy.cashier_wise_collection_search_data');
    Route::post('pharmacy/cashier_wise_collection_search_data_print', 'ReportController@PharmacyCashierWiseCollectionSearchDataPrint')->name('pharmacy.cashier_wise_collection_search_data_print');
    Route::get('radiology/print-form/{id?}', 'RadiologyController@printForm')->name('radiology.print-form');
    Route::post('radiology/skip-verify-and-finalize', 'RadiologyController@skipVerify')->name('radiology.skip-verify-and-finalize');
    Route::post('patient-bill-info-json', 'RadiologyController@patientBillInfoJson')->name('patient-bill-info-json');

    Route::get('prescription/appointments/list', 'PrescriptionController@pat_appointment_list')->name('appointments.list');
    Route::get('emergency/prescription/list', 'PrescriptionController@emergency_prescription_list')->name('emergency.prescription.list');
    Route::get('prescription/appointments/opd-nurse-station', 'PrescriptionController@opd_nurse_station')->name('appointments.opd-nurse-station');
    Route::post('prescription/appointments/opd-nurse-station-appointed-list', 'PrescriptionController@opd_nurse_station_appointed_list')->name('appointments.opd-nurse-station-appointed-list');
    Route::post('prescription.all-patient-appointed-prescribed-list', 'PrescriptionController@all_patient_app_pres')->name('prescription.all-patient-appointed-prescribed-list');
    Route::post('prescription.all-patient-emergency-prescribed-list', 'PrescriptionController@all_emergency_patient_app_pres')->name('prescription.all-patient-emergency-prescribed-list');

    Route::get('/supplier_delivery_viewer', 'SupplierDeliveryScheduleController@supplier_delivery_viewer')->name('supplier_delivery_viewer');
    Route::get('pharmacy/supplier_delivery_viewer', 'SupplierDeliveryScheduleController@pharmacy_supplier_delivery_viewer')->name('pharmacy.supplier_delivery_viewer');


    Route::get('/show_supplier_schedule_viewer', 'SupplierDeliveryScheduleController@show_supplier_schedule_viewer')->name('show_supplier_schedule_viewer');
    Route::get('pharmacy/show_supplier_schedule_viewer', 'SupplierDeliveryScheduleController@pharmacy_show_supplier_schedule_viewer')->name('pharmacy.show_supplier_schedule_viewer');


    Route::resource('supplier_delivery_schedule', 'SupplierDeliveryScheduleController');

    //WareHouse Transfer
    Route::get('pharmacy_indent_worklist', 'PharmacyController@pharmacy_indent_worklist')->name('pharmacy_indent_worklist');
    Route::get('pharmacy_indent_worklist_v2/{indent?}/{store?}', 'PharmacyController@pharmacy_indent_worklist_v2')->name('pharmacy_indent_worklist_v2');
    Route::get('inventory_indent_worklist', 'PharmacyController@inventory_indent_worklist')->name('inventory_indent_worklist');
    Route::get('pharmacy_return_indent_worklist', 'PharmacyController@pharmacy_return_indent_worklist')->name('pharmacy_return_indent_worklist');

    Route::post('search_indent', 'PharmacyController@search_indent')->name('pharmacy_search_indent');
    Route::post('indent-search-pharmacy', 'PharmacyController@search_indent_new')->name('pharmacy_search_indent_new');

    Route::post('search_indent_item', 'PharmacyController@search_indent_item')->name('pharmacy_search_indent_item');
    Route::get('new_indent', 'PharmacyController@new_indent')->name('new_indent');
    Route::get('pharmacy/new_indent', 'PharmacyController@pharmacy_new_indent')->name('pharmacy.new_indent');
    Route::post('new_indent', 'PharmacyController@store')->name('store_new_indent');
    Route::post('nurse_station_indent', 'PharmacyController@storeNurseStationIndent')->name('nurse_station_indent');
    Route::post('update_indent', 'PharmacyController@update_indent')->name('update_indent');
    Route::post('update_indent_nurse_station', 'PharmacyController@update_indent_nurse_station')->name('update_indent_nurse_station');
    Route::get('indent_item_details/{indent_no?}', 'PharmacyController@indent_item_details')->name('indent_item_details');
    Route::get('return_indent_item_details/{indent_no?}', 'PharmacyController@return_indent_item_details')->name('return_indent_item_details');
    Route::post('indent_verify', 'PharmacyController@indent_verify')->name('indent_verify');


    Route::get('item_issue_worklist', 'PharmacyController@item_issue_worklist')->name('item_issue_worklist');

    Route::get('inventory_item_issue_worklist', 'PharmacyController@inventory_item_issue_worklist')->name('inventory_item_issue_worklist');

    Route::post('print_item_issue_worklist', 'PharmacyController@print_item_issue_worklist')->name('print_item_issue_worklist');
    Route::post('item_issu_worklist_search', 'PharmacyController@search_item_issue_worklist')->name('serach_worklist');

    Route::post('inventory_item_issu_worklist_search', 'PharmacyController@search_inventory_item_issue_worklist')->name('inventory_serach_worklist');

    Route::post('update_item_issue', 'PharmacyController@update_item_issue')->name('update_item_issue');
    // from nurse to pharmacy
    Route::get('item_issue_worklist_nurse_station', 'PharmacyController@item_issue_worklist_nurse_station')->name('item_issue_worklist_nurse_station');
    Route::get('set_transit_by/{indent?}/{item?}', 'PharmacyController@set_transit_by')->name('set_transit_by');
    // Route::post('print_item_issue_worklist', 'PharmacyController@print_item_issue_worklist')->name('print_item_issue_worklist');
    Route::post('item_issu_worklist_search_nurse_station', 'PharmacyController@search_item_issue_worklist_nurse_station')->name('serach_worklist_nurse_station');
    Route::post('update_item_issue_nurse_station', 'PharmacyController@update_item_issue_nurse_station')->name('update_item_issue_nurse_station');
    Route::post('update_item_issue_nurse_station_all', 'PharmacyController@update_item_issue_nurse_station_all')->name('update_item_issue_nurse_station_all');

    //  nurse status  pharmacy approval
    Route::get('item_issue_worklist_nurse_station_approval', 'PharmacyController@item_issue_worklist_nurse_station_approval')->name('item_issue_worklist_nurse_station_approval');
    Route::post('item_issu_worklist_search_nurse_station_approval', 'PharmacyController@search_item_issue_worklist_nurse_station_approval')->name('serach_worklist_nurse_station_approval');
    Route::post('phr_indent_approval_store', 'PharmacyController@phr_indent_approval_store')->name('phr_indent_approval_store');
    Route::post('cancel_approve', 'PharmacyController@cancel_approve')->name('cancel_approve');
    Route::get('show_indent_item_receive_pop_up_nurse_stations_all/{indent_id}', 'PharmacyController@ipd_phr_issue_all')->name('show_indent_item_receive_pop_up_nurse_stations_all');

    Route::get('show-indent-item-receive-pop-up/{item_details?}/{type?}', "PharmacyController@showIndentItemReceivePopup")->name('show_indent_item_receive_pop_up');
    Route::get('show-indent-item-receive-pop-up-nurse-station/{item_details?}/{type?}', "PharmacyController@showIndentItemReceivePopupNurseStation")->name('show_indent_item_receive_pop_up_nurse_station');
    Route::get('show-consum-item-receive-pop-up/{item_details?}/{type?}', "PharmacyController@showConsumItemReceivePopup")->name('show_consum_item_receive_pop_up');

    //NSDS Routes
    Route::post('nsds/nsds-setup-list', 'NSDSController@getAllNSDSSetup')->name('nsds.nsds-setup-list');
    Route::get('nsds/create_form', 'NSDSController@create_form')->name('nsds.create_form');
    Route::post('nsds/store-nsds', 'NSDSController@storeNSDS')->name('nsds.store-nsds');
    Route::get('nsds/edit-nsds-setup/{id}', 'NSDSController@editNSDSSetup')->name('nsds.edit-nsds-setup');
    Route::resource('nsds', 'NSDSController');
    // Ward Coverage NSDS Routes
    Route::post('ipd/wcnsds-setup-list', 'NSDSCoverageController@getAllWcnsdsSetup')->name('ipd.wcnsds-setup-list');
    Route::get('ipd/wcnsds_create_form', 'NSDSCoverageController@create_form')->name('ipd.wcnsds_create_form');
    Route::post('ipd/store-wcnsds', 'NSDSCoverageController@storeWcnsds')->name('ipd.store-wcnsds');
    Route::get('ipd/edit-wcnsds-setup/{id}', 'NSDSCoverageController@editWcnsdsSetup')->name('ipd.edit-wcnsds-setup');
    Route::resource('wcnsds', 'NSDSCoverageController');

    //IPDS_USER_NSDS
    Route::get('/ipds-user-nsds', 'IpdsUserNsdsController@index')->name('ipdsusernsds.index');
    Route::post('/ipds-user-nsds/', 'IpdsUserNsdsController@store')->name('ipdsusernsds.store');
    Route::get('/ipds-user-nsds/{edit_id}', 'IpdsUserNsdsController@edit')->name('ipdsusernsds.edit');
    Route::put('/ipds-user-nsds/{update_id}', 'IpdsUserNsdsController@update')->name('ipdsusernsds.update');

    //IPDS_WARDCOVERAGE_NSDS
    Route::get('/ipds-wardcoverage-nsds', 'IpdsWardcoverageNsdsController@index')->name('ipdswardcoveragensds.index');
    Route::post('/ipds-wardcoverage-nsds', 'IpdsWardcoverageNsdsController@store')->name('ipdswardcoveragensds.store');
    Route::get('/ipds-wardcoverage-nsds/{edit_id}', 'IpdsWardcoverageNsdsController@edit')->name('ipdswardcoveragensds.edit');
    Route::put('/ipds-wardcoverage-nsds/{update_id}', 'IpdsWardcoverageNsdsController@update')->name('ipdswardcoveragensds.update');
});
Route::middleware(['auth', 'check_access'])->group(function () {
    // Accounts Route v1
    //--Accounts Setup--//
    Route::get('v1/accounts/account-setup', 'AccountsController@accountsSetupV1')->name('v1.accounts.account-setup');
    Route::get('v1/tree-view', 'AccountsController@treeViewV1')->name('tree-view-v1');
    Route::get('v1/get-accounts-level', 'AccountsController@get_accounts_levelV1')->name('get-accounts-level-v1');
    Route::get('v1/get-accounts-type', 'AccountsController@get_accounts_typeV1')->name('get-acc-type-v1');

    Route::get('v1/accounts/edit-accounts-level/{acc_code}', 'AccountsController@editAccountsLevelV1')->name('v1.accounts.edit-accounts-level');
    Route::post('v1/accounts/update-accounts-level', 'AccountsController@updateAccountsLevelV1')->name('v1.update-accounts-level');
    Route::post('v1/accounts/save-chart-of-accounts', 'ChartOfAccountsController@save_chart_of_accounts_v1')->name('save-chart-of-accounts-v1');
    Route::post('v1/accounts/update-chart-of-accounts', 'ChartOfAccountsController@update_chart_of_accounts_v1')->name('update-chart-of-accounts-v1');
    Route::get('v1/accounts/get-chartof-account-byid', 'AccountsController@get_chart_of_account_by_id_v1')->name('accounts.get-chartof-account-byid-v1');

    // Journal Type
    Route::post('v1/add-vouchertype', 'VoucherTypeController@add_voucher_type_v1')->name('add-vouchertype-v1');
    Route::get('v1/get-vouchertype', 'VoucherTypeController@get_voucher_type_v1')->name('get-vouchertype-v1');
    Route::post('v1/set-vouchertype-status', 'VoucherTypeController@set_voucher_type_status_v1')->name('set-vouchertype-status-v1');

    //--Sub Ledger Type Setup--//
    Route::get('v1/accounts/sub-ledger-type-setup', 'AccountsController@accountsSubLedgerTypeV1')->name('v1.accounts.sub-ledger-type-setup');
    Route::get('v1/accounts/get-sub-ledger-type', 'AccountsController@accountsGetSubLedgerTypeV1')->name('v1.accounts.get-sub-ledger-type');
    Route::post('v1/accounts/save-sub-ledger-type', 'AccountsController@saveSubLedgerType')->name('v1.accounts.save-sub-ledger-type');
    Route::get('v1/accounts/edit-sub-ledger-type/{id}', 'AccountsController@editSubLedgerType')->name('v1.accounts.edit-sub-ledger-type-name');
    Route::post('v1/accounts/update-sub-ledger-type', 'AccountsController@updateSubLedgerType')->name('v1.accounts.update-sub-ledger-type');
    //-- Sub Ledger Name Setup --//
    Route::get('v1/accounts/sub-ledger-name-setup', 'AccountsController@accountsSubLedgerNameV1')->name('v1.accounts.sub-ledger-name-setup');
    Route::get('v1/accounts/get-sub-ledger-name', 'AccountsController@accountsGetSubLedgerNameV1')->name('v1.accounts.get-sub-ledger-name');
    Route::post('v1/accounts/save-sub-ledger-name', 'AccountsController@saveSubLedgerName')->name('v1.accounts.save-sub-ledger-name');
    Route::get('v1/accounts/edit-sub-ledger-name/{id}', 'AccountsController@editSubLedgerName')->name('v1.accounts.edit-sub-ledger-name');
    Route::post('v1/accounts/update-sub-ledger-name', 'AccountsController@updateSubLedgerName')->name('v1.accounts.update-sub-ledger-name');
    //-- Cost Center Setup --//
    Route::get('v1/accounts/cost-center-setup', 'AccountsController@accountsCostCenterSetupV1')->name('v1.accounts.cost-center-setup');
    Route::get('v1/accounts/get-cost-center', 'AccountsController@accountsGetCostCenterV1')->name('v1.accounts.get-cost-center');
    Route::post('v1/accounts/save-cost-center', 'AccountsController@saveCostCenter')->name('v1.accounts.save-cost-center');
    Route::get('v1/accounts/edit-cost-center/{id}', 'AccountsController@editCostCenter')->name('v1.accounts.edit-cost-center');
    Route::post('v1/accounts/update-cost-center', 'AccountsController@updateCostCenter')->name('v1.accounts.update-cost-center');
    //-- Fiscal Year --//
    Route::get('v1/accounts/fiscal-year', 'AccountsSetupController@fiscalYearV1')->name('v1.accounts.fiscal-year');
    Route::get('v1/accounts/get-fiscal-year', 'AccountsSetupController@getfiscalYearV1')->name('v1.accounts.get-fiscal-year');
    Route::post('v1/accounts/save-fiscal-year', 'AccountsSetupController@savefiscalYearV1')->name('v1.accounts.save-fiscal-year');
    Route::post('v1/accounts/update-fiscal-year', 'AccountsSetupController@updatefiscalYearV1')->name('v1.accounts.update-fiscal-year');
    Route::get('v1/accounts/edit-fiscal-year/{id}', 'AccountsSetupController@editFiscalYearV1')->name('v1.accounts.edit-fiscal-year');

    //-- Fiscal Month --//
    Route::get('v1/accounts/fiscal-month', 'AccountsSetupController@fiscalMonthV1')->name('v1.accounts.fiscal-month');
    Route::get('v1/accounts/get-fiscal-month', 'AccountsSetupController@getfiscalMonthV1')->name('v1.accounts.get-fiscal-month');
    Route::post('v1/accounts/save-fiscal-month', 'AccountsSetupController@savefiscalMonthV1')->name('v1.accounts.save-fiscal-month');
    Route::post('v1/accounts/update-fiscal-month', 'AccountsSetupController@updatefiscalMonthV1')->name('v1.accounts.update-fiscal-month');
    Route::get('v1/accounts/edit-fiscal-month/{id}', 'AccountsSetupController@editFiscalMonthV1')->name('v1.accounts.edit-fiscal-month');

    //-- Journal Posting --//
    Route::get('v1/accounts/journal-posting', 'AccountsController@accountsJournalPosting')->name('v1.accounts.journal-posting');
    Route::get('v1/accounts/get-sub-ledger-name-list/{id}', 'AccountsController@accountsGetSubLedgerNameList')->name('v1.accounts.get-sub-ledger-name-list');
    Route::post('v1/accounts/save-journal-posting', 'VoucherEntryController@accountsSaveJournal')->name('v1.accounts.save-journal-posting');
    Route::post('v1/accounts/update-journal-posting', 'VoucherEntryController@accountsUpdateJournal')->name('v1.accounts.update-journal-posting');
    Route::post('v1/accounts/get-patient-info', 'AccountsController@getPatientInfo')->name('v1.accounts.get-patient-info');

    //-- Journal Info//
    Route::get('v1/accounts/journal-info', 'AccountsController@accountsJournalInfo')->name('v1.accounts.journal-info');
    Route::post('v1/accounts/show-journals-info', 'AccountsController@show_journal_info')->name('v1.accounts.show-journals-info');
    Route::get('v1/journal', 'VoucherInformationController@journal')->name('journal');
    Route::get('v1/journal-excel', 'VoucherInformationController@journal_excel')->name('journal_excel');
    Route::get('v1/journal-show', 'VoucherInformationController@journalShow')->name('journal_show');
    Route::get('v1/set-active-inactive-journal', 'VoucherInformationController@set_active_inactive_journal')->name('v1.set-active-inactive-journal');
    Route::get('v1/view_journal', 'VoucherInformationController@view_journal')->name('view_journal');
    Route::get('v1/view_journal_details', 'VoucherInformationController@view_journal_details')->name('v1.view_journal');

    Route::get('v1/preview_journal/{journal}', 'VoucherInformationController@preview_journal')->name('v1.accounts.preview_journal');
    //--Finalized Journal --//
    Route::get('v1/accounts/journal-finalize', 'AccountsController@accountsJournalFinalize')->name('v1.accounts.journal-finalize');
    Route::post('v1/accounts/show-journals-finalize', 'AccountsController@show_journal_finalize')->name('accounts.show-journals-finalize');
    Route::get('v1/set-finalized-notfinalized-journal', 'VoucherInformationController@set_finalized_nofinalized_journal')->name('set-finalized-nofinalized-journal');
    // Journal List
    Route::get('v1/accounts/journal-list', 'AccountsController@accountsJournalList')->name('v1.accounts.journal-list');
    Route::post('v1/accounts/show-journals-list', 'AccountsController@show_journal_list')->name('v1.accounts.show-journals-list');
    Route::get('v1/edit-journal', 'AccountsController@edit_journal')->name('edit_journal');
    // Journal Unverified
    Route::get('v1/accounts/journal-info-modify', 'AccountsController@accountsJournalInfoModify')->name('v1.accounts.journal-info-modify');
    Route::post('v1/accounts/show-journals-info-modify', 'AccountsController@show_journal_info_modify')->name('v1.accounts.show-journals-info-modify');
    Route::get('v2/set-active-inactive-journal', 'VoucherInformationController@set_active_inactive_journal_v2')->name('v2.set-active-inactive-journal');

    //--Accounts Group Setup--//
    Route::get('v1/accounts/accounts-group', 'AccountsSetupController@accountsGroupV1')->name('v1.accounts.accounts-group');
    Route::get('v1/accounts/get-accounts-group', 'AccountsSetupController@getaccountsgroupv1')->name('v1.accounts.get-accounts-group');
    Route::post('v1/accounts/save-accounts-group', 'AccountsSetupController@saveAccountsGroup')->name('v1.accounts.save-accounts-group');
    Route::get('v1/accounts/edit-accounts-group/{id}', 'AccountsSetupController@editAccountsGroup')->name('v1.accounts.edit-accounts-group');
    Route::post('v1/accounts/update-accounts-group', 'AccountsSetupController@updateAccountsGroup')->name('v1.accounts.update-accounts-group');

    //--Accounts Sub Group Setup--//
    Route::get('v1/accounts/accounts-sub-group', 'AccountsSetupController@accountsSubGroupV1')->name('v1.accounts.accounts-sub-group');
    Route::get('v1/accounts/get-accounts-sub-group', 'AccountsSetupController@getAccountsSubGroupV1')->name('v1.accounts.get-accounts-sub-group');
    Route::post('v1/accounts/save-accounts-sub-group', 'AccountsSetupController@saveAccountsSubGroup')->name('v1.accounts.save-accounts-sub-group');
    Route::get('v1/accounts/edit-accounts-sub-group/{id}', 'AccountsSetupController@editAccountsSubGroup')->name('v1.accounts.edit-accounts-sub-group');
    Route::post('v1/accounts/update-accounts-sub-group', 'AccountsSetupController@updateAccountsSubGroup')->name('v1.accounts.update-accounts-sub-group');

    //--Accounts Group Type Setup--//
    Route::get('v1/accounts/accounts-group-type', 'AccountsSetupController@accountsGroupTypeV1')->name('v1.accounts.accounts-group-type');
    Route::get('v1/accounts/get-accounts-group-type', 'AccountsSetupController@getAccountsGroupTypeV1')->name('v1.accounts.get-accounts-group-type');
    Route::post('v1/accounts/save-accounts-group-type', 'AccountsSetupController@saveAccountsGroupType')->name('v1.accounts.save-accounts-group-type');
    Route::get('v1/accounts/edit-accounts-group-type/{id}', 'AccountsSetupController@editAccountsGroupType')->name('v1.accounts.edit-accounts-group-type');
    Route::post('v1/accounts/update-accounts-group-type', 'AccountsSetupController@updateAccountsGroupType')->name('v1.accounts.update-accounts-group-type');

    //--Accounts Type Setup--//
    Route::get('v1/accounts/accounts-type', 'AccountsSetupController@accountsTypeV1')->name('v1.accounts.accounts-type');
    Route::get('v1/accounts/get-accounts-type', 'AccountsSetupController@getAccountsTypeV1')->name('v1.accounts.get-accounts-type');
    Route::post('v1/accounts/save-accounts-type', 'AccountsSetupController@saveAccountsType')->name('v1.accounts.save-accounts-type');
    Route::get('v1/accounts/edit-accounts-type/{id}', 'AccountsSetupController@editAccountsType')->name('v1.accounts.edit-accounts-type');
    Route::post('v1/accounts/update-accounts-type', 'AccountsSetupController@updateAccountsType')->name('v1.accounts.update-accounts-type');

    //--Accounts Description Setup--//
    Route::get('v1/accounts/accounts-description', 'AccountsSetupController@accountsDescriptionV1')->name('v1.accounts.accounts-description');
    Route::get('v1/accounts/get-accounts-description', 'AccountsSetupController@getAccountsDescriptionV1')->name('v1.accounts.get-accounts-description');
    Route::post('v1/accounts/save-accounts-description', 'AccountsSetupController@saveAccountsDescription')->name('v1.accounts.save-accounts-description');
    Route::get('v1/accounts/edit-accounts-description/{id}', 'AccountsSetupController@editAccountsDescription')->name('v1.accounts.edit-accounts-description');
    Route::post('v1/accounts/update-accounts-description', 'AccountsSetupController@updateAccountsDescription')->name('v1.accounts.update-accounts-description');

    //--Opening Balance Setup--//
    Route::get('v1/accounts/accounts-opening-balance', 'AccountsSetupController@accountsOpeningBalanceV1')->name('v1.accounts.accounts-opening-balance');
    Route::get('v1/accounts/get-accounts-opening-balance', 'AccountsSetupController@getAccountsOpeningBalanceV1')->name('v1.accounts.get-accounts-opening-balance');
    Route::post('v1/accounts/save-accounts-opening-balance', 'AccountsSetupController@saveAccountsOpeningBalance')->name('v1.accounts.save-accounts-opening-balance');
    Route::get('v1/accounts/edit-accounts-opening-balance/{id}', 'AccountsSetupController@editAccountsOpeningBalance')->name('v1.accounts.edit-accounts-opening-balance');
    Route::post('v1/accounts/update-accounts-opening-balance', 'AccountsSetupController@updateAccountsOpeningBalance')->name('v1.accounts.update-accounts-opening-balance');

    //--General Ledger Setup--//
    Route::get('v1/accounts/general-ledger-list', 'ChartOfAccountsController@getGLListChartOfAccounts')->name('v1.accounts.general-ledger-list');
    Route::get('v1/accounts/accounts-general-ledgere-entry', 'AccountsSetupController@accountsGeneralLedgerEntryV1')->name('v1.accounts.accounts-general-ledger-entry');
    Route::get('v1/accounts/accounts-get-gl-code/{id}', 'AccountsSetupController@getGLCodeV1')->name('v1.accounts.get-gl-code');

    Route::get('v1/accounts/get-accounts-general-ledgere-entry', 'AccountsSetupController@getAccountsGeneralLedgerEntryV1')->name('v1.accounts.get-accounts-general-ledger-entry');
    Route::post('v1/accounts/save-accounts-general-ledgere-entry', 'AccountsSetupController@saveAccountsGeneralLedgerEntryV1')->name('v1.accounts.save-accounts-general-ledger-entry');



    //-- Journal Type --//
    Route::get('v1/accounts/journal-type', 'AccountsSetupController@journalTypeV1')->name('v1.accounts.journal-type');

    //--Accounts currency Setup--//
    Route::get('v1/accounts/accounts-currency-setup', 'AccountsSetupController@accountsCurrencySetupV1')->name('v1.accounts.accounts-currency-setup');
    Route::get('v1/accounts/get-accounts-currency-setup', 'AccountsSetupController@getAccountsCurrencySetupV1')->name('v1.accounts.get-accounts-currency-setup');
    Route::post('v1/accounts/save-accounts-currency-setup', 'AccountsSetupController@saveAccountsCurrencySetup')->name('v1.accounts.save-accounts-currency-setup');
    Route::get('v1/accounts/edit-accounts-currency-setup/{id}', 'AccountsSetupController@editAccountsCurrencySetup')->name('v1.accounts.edit-accounts-currency-setup');
    Route::post('v1/accounts/update-accounts-currency-setup', 'AccountsSetupController@updateAccountsCurrencySetup')->name('v1.accounts.update-accounts-currency-setup');


    // -- Chart of Account List --//
    Route::get('v1/accounts/chart-of-accounts-list', 'ChartOfAccountsController@accountsCOFListV1')->name('v1.accounts.chart-of-accounts-list');
    //Chart of Account List Export
    Route::get('v1/accounts/download-chart-of-account-excel', 'ChartOfAccountsController@downloadCOFListExcelV1')->name('v1.accounts.download-chart-of-account-excel');
    Route::get('v1/accounts/download-chart-of-account-pdf', 'ChartOfAccountsController@downloadCOFListPDFV1')->name('v1.accounts.download-chart-of-account-pdf');
    // Account Types Export
    Route::get('v1/accounts/download-chart-of-account-account-types-excel/{id}', 'ChartOfAccountsController@downloadCOFAccountTypeListExcelV1')->name('v1.accounts.download-chart-of-account-account-types-excel');
    Route::get('v1/accounts/download-chart-of-account-account-types-pdf/{id}', 'ChartOfAccountsController@downloadCOFAccountTypeListPDFV1')->name('v1.accounts.download-chart-of-account-account-types-pdf');
    // Account Description Export
    Route::get('v1/accounts/download-chart-of-account-description-excel/{id}', 'ChartOfAccountsController@downloadCOFAccountDescriptionListExcelV1')->name('v1.accounts.download-chart-of-account-description-excel');
    Route::get('v1/accounts/download-chart-of-account-description-pdf/{id}', 'ChartOfAccountsController@downloadCOFAccountDescriptionListPDFV1')->name('v1.accounts.download-chart-of-account-description-pdf');
    // General Ledger Export
    Route::get('v1/accounts/download-gl-list-excel/{id}', 'ChartOfAccountsController@downloadCOFGLListExcelV1')->name('v1.accounts.download-gl-list-excel');
    Route::get('v1/accounts/download-gl-list-pdf/{id}', 'ChartOfAccountsController@downloadCOFGLListPDFV1')->name('v1.accounts.download-gl-list-pdf');
    // General Ledger Report Export
    Route::post('v1/accounts/download-general-ledger-list-reort-excel', 'AccountsReportController@downloadGLListExcelV1')->name('v1.accounts.download-general-ledger-list-excel');
    Route::post('v1/accounts/download-general-ledger-list-report-pdf', 'AccountsReportController@downloadGLListPDFV1')->name('v1.accounts.download-general-ledger-list-pdf');

    // General Ledger Report Export
    Route::post('v1/accounts/download-auto-general-ledger-list-reort-excel', 'AccountsReportController@downloadAutoGLListExcelV1')->name('v1.accounts.download-auto-general-ledger-list-excel');
    Route::post('v1/accounts/download-auto-general-ledger-list-report-pdf', 'AccountsReportController@downloadAutoGLListPDFV1')->name('v1.accounts.download-auto-general-ledger-list-pdf');

    // Trial Balance Report Export
    Route::post('v1/accounts/download-trial-balance-excel', 'AccountsReportController@downloadTrialBalanceExcelV1')->name('v1.accounts.download-trial-balance-excel');
    Route::post('v1/accounts/download-trial-balance-pdf', 'AccountsReportController@downloadTrialBalancePDFV1')->name('v1.accounts.download-trial-balance-pdf');
    //v2
    Route::post('v2/accounts/download-trial-balance-excel', 'AccountsReportController@downloadTrialBalanceExcelV2')->name('v2.accounts.download-trial-balance-excel');
    Route::post('v2/accounts/download-trial-balance-pdf', 'AccountsReportController@downloadTrialBalancePDFV2')->name('v2.accounts.download-trial-balance-pdf');
    // Cash Flow Report Report Export
    Route::post('v1/accounts/download-cash-flow-statement-excel', 'AccountsReportController@downloadCashFlowExcelV1')->name('v1.accounts.download-cash-flow-statement-excel');
    Route::post('v1/accounts/download-cash-flow-statement-pdf', 'AccountsReportController@downloadCashFlowPDFV1')->name('v1.accounts.download-cash-flow-statement-pdf');
    // Voucher Report Export
    Route::post('v1/accounts/download-journal-report-excel', 'AccountsReportController@downloadJournalReportExcelV1')->name('v1.accounts.download-journal-report-excel');
    Route::post('v1/accounts/download-auto-journal-report-excel', 'AccountsReportController@downloadAutoJournalReportExcelV1')->name('v1.accounts.download-auto-journal-report-excel');
    // subledger Report Export
    Route::get('v1/accounts/subledger-report-by-id-date-excel', 'AccountsReportController@downloadSubLedgerExcelV1')->name('v1.accounts.subledger-report-by-id-date-excel');
    Route::get('v1/accounts/subledger-report-by-id-date-pdf', 'AccountsReportController@downloadSubLedgerPDFV1')->name('v1.accounts.subledger-report-by-id-date-pdf');
    // subledger Report Export
    Route::post('v1/accounts/subledger-report-excel', 'AccountsReportController@downloadSubLedgerExcelAllV1')->name('v1.accounts.subledger-report-excel');
    Route::post('v1/accounts/subledger-report-pdf', 'AccountsReportController@downloadSubLedgerPDFAllV1')->name('v1.accounts.subledger-report-pdf');

    Route::post('v1/accounts/subledger-report-type-excel', 'AccountsReportController@downloadSubLedgerExcelTypeV1')->name('v1.accounts.subledger-report-type-excel');
    Route::post('v1/accounts/subledger-report-type-pdf', 'AccountsReportController@downloadSubLedgerPDFTypeV1')->name('v1.accounts.subledger-report-type-pdf');


    // Trial Balance Report Export
    Route::post('v1/accounts/download-trial-balance-1-excel', 'AccountsReportController@downloadTrialBalance1ExcelV1')->name('v1.accounts.download-trial-balance-1-excel');
    Route::post('v1/accounts/download-trial-balance-1-pdf', 'AccountsReportController@downloadTrialBalance1PDFV1')->name('v1.accounts.download-trial-balance-1-pdf');
    // Balance Statement Report Export
    Route::post('v1/accounts/download-balance-statement-excel', 'AccountsReportController@downloadBalanceStatementExcelV1')->name('v1.accounts.download-balance-statement-excel');
    Route::post('v1/accounts/download-balance-statement-pdf', 'AccountsReportController@downloadBalanceStatementPDFV1')->name('v1.accounts.download-balance-statement-pdf');
    Route::post('v1/accounts/download-balance-statement-excel-nd', 'AccountsReportController@downloadBalanceStatementExcelNDV1')->name('v1.accounts.download-balance-statement-excel-nd');
    Route::post('v1/accounts/download-balance-statement-pdf-nd', 'AccountsReportController@downloadBalanceStatementPDFNDV1')->name('v1.accounts.download-balance-statement-pdf-nd');
    // v2
    Route::post('v2/accounts/download-balance-statement-excel-nd', 'AccountsReportController@downloadBalanceStatementExcelNDV2')->name('v2.accounts.download-balance-statement-excel-nd');
    Route::post('v2/accounts/download-balance-statement-pdf-nd', 'AccountsReportController@downloadBalanceStatementPDFNDV2')->name('v2.accounts.download-balance-statement-pdf-nd');

    Route::post('v2/accounts/download-balance-statement-excel', 'AccountsReportController@downloadBalanceStatementExcelV2')->name('v2.accounts.download-balance-statement-excel');


    // Comparison Balance Statement Report
    Route::post('v1/accounts/download-balance-statement-comparison-excel', 'AccountsReportController@downloadBalanceStatementComparisonExcelV1')->name('v1.accounts.download-balance-statement-comparison-excel');
    Route::post('v1/accounts/download-balance-statement-comparison-pdf', 'AccountsReportController@downloadBalanceStatementComparisonPDFV1')->name('v1.accounts.download-balance-statement-comparison-pdf');
    Route::post('v1/accounts/download-balance-statement-comparison-excel-nd', 'AccountsReportController@downloadBalanceStatementComparisonExcelNDV1')->name('v1.accounts.download-balance-statement-comparison-excel-nd');
    Route::post('v1/accounts/download-balance-statement-comparison-pdf-nd', 'AccountsReportController@downloadBalanceStatementComparisonPDFNDV1')->name('v1.accounts.download-balance-statement-comparison-pdf-nd');
    //v2
    Route::post('v2/accounts/download-balance-statement-comparison-excel-nd', 'AccountsReportController@downloadBalanceStatementComparisonExcelNDV2')->name('v2.accounts.download-balance-statement-comparison-excel-nd');
    Route::post('v2/accounts/download-balance-statement-comparison-pdf-nd', 'AccountsReportController@downloadBalanceStatementComparisonPDFNDV2')->name('v2.accounts.download-balance-statement-comparison-pdf-nd');
    Route::post('v2/accounts/download-balance-statement-comparison-excel', 'AccountsReportController@downloadBalanceStatementComparisonExcelV2')->name('v2.accounts.download-balance-statement-comparison-excel');




    Route::post('v1/accounts/download-profit-loss-statement-comparison-excel', 'AccountsReportController@downloadProfitLossStatementComparisonExcelV1')->name('v1.accounts.download-profit-loss-statement-comparison-excel');
    Route::post('v1/accounts/download-profit-loss-statement-comparison-excel-nd', 'AccountsReportController@downloadProfitLossStatementComparisonExcelNDV1')->name('v1.accounts.download-profit-loss-statement-comparison-excel-nd');
    Route::post('v1/accounts/download-profit-loss-statement-comparison-pdf-nd', 'AccountsReportController@downloadProfitLossStatementComparisonPDFNDV1')->name('v1.accounts.download-profit-loss-statement-comparison-pdf-nd');

    // income statement comparison
    Route::post('v1/accounts/download-income-statement-comparison-excel', 'AccountsReportController@downloadIncomeStatementComparisonExcelV1')->name('v1.accounts.download-income-statement-comparison-excel');
    Route::post('v1/accounts/download-income-statement-comparison-excel-nd', 'AccountsReportController@downloadIncomeStatementComparisonExcelNDV1')->name('v1.accounts.download-income-statement-comparison-excel-nd');
    Route::post('v1/accounts/download-income-statement-comparison-pdf-nd', 'AccountsReportController@downloadIncomeStatementComparisonPDFNDV1')->name('v1.accounts.download-income-statement-comparison-pdf-nd');




    // Profit Loss Report Export
    Route::post('v1/accounts/download-profit-loss-excel', 'AccountsReportController@downloadProfitLossExcelV1')->name('v1.accounts.download-profit-loss-excel');
    Route::post('v1/accounts/download-profit-loss-pdf', 'AccountsReportController@downloadProfitLossPDFV1')->name('v1.accounts.download-profit-loss-pdf');
    Route::post('v1/accounts/download-profit-loss-excel-nd', 'AccountsReportController@downloadProfitLossExcelNDV1')->name('v1.accounts.download-profit-loss-excel-nd');
    Route::post('v1/accounts/download-profit-loss-pdf-nd', 'AccountsReportController@downloadProfitLossPDFNDV1')->name('v1.accounts.download-profit-loss-pdf-nd');
    // v2
    Route::post('v2/accounts/download-profit-loss-excel', 'AccountsReportController@downloadProfitLossExcelV2')->name('v2.accounts.download-profit-loss-excel');
    Route::post('v2/accounts/download-profit-loss-description-wise-excel', 'AccountsReportController@downloadProfitLossExcelDescription')->name('v2.accounts.download-profit-loss-description-wise-excel');

    // Income Statement Report Export
    Route::post('v1/accounts/download-income-statement-excel', 'AccountsReportController@downloadIncomeStatementExcelV1')->name('v1.accounts.download-income-statement-excel');
    Route::post('v1/accounts/download-income-statement-pdf', 'AccountsReportController@downloadIncomeStatementPDFV1')->name('v1.accounts.download-income-statement-pdf');
    Route::post('v1/accounts/download-income-statement-excel-nd', 'AccountsReportController@downloadIncomeStatementExcelNDV1')->name('v1.accounts.download-income-statement-excel-nd');
    Route::post('v1/accounts/download-income-statement-pdf-nd', 'AccountsReportController@downloadIncomeStatementPDFNDV1')->name('v1.accounts.download-income-statement-pdf-nd');

    //chart of account Dril Down
    Route::get('v1/accounts/get-type-list-by-group-type/{id}', 'ChartOfAccountsController@getTypeListByGroupType')->name('v1.accounts.get-type-list-by-group-type');
    Route::get('v1/accounts/get-account-description-list-by-account-type/{id}', 'ChartOfAccountsController@getDescriptionListByType')->name('v1.accounts.get-account-description-list-by-account-type');
    Route::get('v1/accounts/get-gl-list-by-account-description/{id}', 'ChartOfAccountsController@getGLListByDescription')->name('v1.accounts.get-gl-list-by-account-description');

    //Reports-Day Book
    Route::get('v1/accounts/daybook', 'AccountsReportController@day_book_v1')->name('v1.accounts.day-book');
    // Route::post('accounts/daybook_search', 'AccountsReportController@day_book_search')->name('accounts.daybook_search');
    Route::post('v1/accounts/show_daybook', 'AccountsReportController@show_day_book_v1')->name('v1.accounts.show-day-book');
    Route::post('v1/accounts/show_excel_daybook', 'AccountsReportController@show_excel_day_book_v1')->name('v1.accounts.show-excel-day-book');

    //Reports-General Ledger
    Route::get('v1/accounts/gl', 'AccountsReportController@general_ledger_search_v1')->name('v1.accounts.gl');
    Route::post('v1/accounts/general-ledger', 'AccountsReportController@general_ledger_v1')->name('v1.accounts.general-ledger');
    Route::get('v1/accounts/show-subsidiary-ledger', 'AccountsReportController@show_subsidiary_ledger_v1')->name('v1.accounts.show-subsidiary-ledger');
    Route::get('v1/accounts/show-ledger-statement', 'AccountsReportController@show_bank_statement_v1')->name('v1.accounts.show-ledger-statement');
    Route::get('v1/accounts/show-ledger-statement-pdf', 'AccountsReportController@show_bank_statement_v1_pdf')->name('v1.accounts.show-ledger-statement-pdf');
    Route::get('v1/accounts/show-ledger-statement-excel', 'AccountsReportController@show_bank_statement_v1_excel')->name('v1.accounts.show-ledger-statement-excel');

    Route::get('v1/accounts/show-ledger-statement-summary-pdf', 'AccountsReportController@show_bank_statement_v1_summary_pdf')->name('v1.accounts.show-ledger-statement-summary-pdf');
    Route::get('v1/accounts/show-ledger-statement-summary-excel', 'AccountsReportController@show_bank_statement_v1_summary_excel')->name('v1.accounts.show-ledger-statement-summary-excel');
    Route::get('v1/accounts/sub-ledger-report-by-id-date', 'AccountsReportController@subLedgerReportV1')->name('v1.accounts.subledger-report-by-id-date');
    Route::get('v1/accounts/sub-ledger-report-by-id-date-individual', 'AccountsReportController@subLedgerReportIndividualV1')->name('v1.accounts.subledger-report-by-id-date-individual');

    // Auto GL Report

    //Reports Trial Balance
    Route::get('v1/accounts/trail-balance', 'AccountsReportController@trail_balanceV1')->name('v1.accounts.trail-balance');
    Route::post('v1/accounts/generate-trail-balance', 'AccountsReportController@generate_trial_balance_v1')->name('v1.accounts.generate-trail-balance');
    //v2
    Route::get('v2/accounts/trail-balance', 'AccountsReportController@trail_balanceV2')->name('v2.accounts.trail-balance');
    Route::post('v2/accounts/generate-trail-balance', 'AccountsReportController@generate_trial_balance_v2')->name('v2.accounts.generate-trail-balance');

    //Cash Flow Statement
    Route::get('v1/accounts/cashflow-statement', 'AccountsReportController@cash_flow_statement_v1')->name('v1.accounts.cashflow-statement');
    Route::post('v1/accounts/show-cashflow-statement', 'AccountsReportController@show_cashflow_statement_v1')->name('v1.accounts.show-cashflow-statement');

    //income Statement
    Route::get('v1/accounts/todays-income', 'AccountsReportController@todays_incomeV1')->name('v1.accounts.todays-income');
    Route::post('v1/accounts/show_daily_income', 'AccountsReportController@generate_income_statement')->name('v1.accounts.show-daily-income');

    // Voucher Report
    Route::get('v1/accounts/journal-report', 'AccountsReportController@journal_reportV1')->name('v1.accounts.journal-report');
    Route::post('v1/accounts/get-journal-report', 'AccountsReportController@get_journal_report')->name('v1.accounts.get-journal-report');


    //Reports Trial Balance 1
    Route::get('v1/accounts/trail-balance-1', 'AccountsReportController@trail_balance1')->name('v1.accounts.trail-balance-1');
    Route::post('v1/accounts/generate-trail-balance-1', 'AccountsReportController@generate_trial_balance_1')->name('v1.accounts.generate-trail-balance-1');

    // Sub Ledger Report
    Route::get('v1/accounts/sub-ledger-report-v1', 'AccountsReportController@subLedgerReportAllV1')->name('v1.accounts.sub-ledger-report-v1');
    Route::post('v1/accounts/generate-sub-ledger-report-v1', 'AccountsReportController@generate_subLedger_report_v1')->name('v1.accounts.generate-sub-ledger-report-v1');

    //Balance Sheet
    Route::get('v1/accounts/balance-statement', 'AccountsReportController@balanceSheetV1')->name('v1.accounts.balance-sheet');
    Route::post('v1/accounts/generate-balance-statement', 'AccountsReportController@generateBalanceStatementV1')->name('v1.accounts.generate-balance-sheet');

    // Balance Sheet v2
    Route::get('v2/accounts/balance-statement', 'AccountsReportController@balanceSheetV2')->name('v2.accounts.balance-sheet');
    Route::post('v2/accounts/generate-balance-statement', 'AccountsReportController@generateBalanceStatementV2')->name('v2.accounts.generate-balance-sheet');
    // Balance Sheet Notes Reports

    Route::get('v1/accounts/notes-reports', 'AccountsReportController@balanceSheetNotesReportsV1')->name('v1.accounts.notes-report');
    //Profit and Loss
    Route::get('v1/accounts/profit-loss', 'AccountsReportController@profitLossV1')->name('v1.accounts.profit-loss');
    Route::post('v1/accounts/generate-profit-loss', 'AccountsReportController@generateProfitLossV1')->name('v1.accounts.generate-profit-loss');

    //New Profit and Loss
    Route::get('v2/accounts/profit-loss', 'AccountsReportController@profitLossV2')->name('v2.accounts.profit-loss');
    Route::post('v2/accounts/generate-profit-loss', 'AccountsReportController@generateProfitLossV2')->name('v2.accounts.generate-profit-loss');

    //Description wise Profit and Loss
    Route::get('v1/accounts/description-wise-profit-loss', 'AccountsReportController@profitLossDescription')->name('v1.accounts.description-wise-profit-loss');
    Route::post('v1/accounts/generate-description-wise-profit-loss', 'AccountsReportController@generateProfitLossDescription')->name('v1.accounts.generate-description-wise-profit-loss');


    //Bank Report
    Route::get('accounts/bank-report', 'AccountsReportController@bank_report')->name('accounts.bank-report');
    Route::post('accounts/show-bank-report', 'AccountsReportController@show_bank_report')->name('accounts.show-bank-report');

    Route::post('accounts.download-bank-report-pdf', 'AccountsReportController@downloadBankReportPdf')->name('accounts.download-bank-report-pdf');
    Route::post('accounts.download-bank-report-excel', 'AccountsReportController@downloadBankReportExel')->name('accounts.download-bank-report-excel');


    //Accounts Ledger
    Route::get('v1/accounts/account-ledger', 'AccountsReportController@accountsLedger')->name('v1.accounts.account-ledger');

    //Accounts Integration
    Route::get('v1/accounts/account-integration', 'AccountsIntregrationController@accountIntegrationV1')->name('v1.accounts.account-integration');
    Route::post('v1/accounts/save-item-wise-account-integration', 'AccountsIntregrationController@saveAccountIntegrationV1')->name('v1.accounts.save-item-wise-account-integration');
    Route::post('v1/accounts/update-item-wise-account-integration', 'AccountsIntregrationController@updateAccountIntegrationV1')->name('v1.accounts.update-item-wise-account-integration');
    Route::get('v1/accounts/get-itemwise-account-integration', 'AccountsIntregrationController@getItemWiseIntegrationV1')->name('v1.accounts.get-itemwise-account-integration');
    Route::get('v1/accounts/edit-accounts-integration-grn/{id}', 'AccountsIntregrationController@editAccountsIntegrationV1')->name('v1.accounts.edit-accounts-integration-grn');
    Route::get('v1/accounts/accounts-grn-details/{id}', 'AccountsIntregrationController@accountsIntegrationDetailsV1')->name('v1.accounts.accounts-grn-details');

    //Accounts Integration Billing
    Route::get('v1/accounts/account-integration-billing', 'AccountsIntregrationController@accountIntegrationBillingV1')->name('v1.accounts.account-integration-billing');
    Route::post('v1/accounts/save-item-wise-account-integration-billing', 'AccountsIntregrationController@saveAccountIntegrationBillingV1')->name('v1.accounts.save-item-wise-account-integration-billing');
    Route::post('v1/accounts/update-item-wise-account-integration-billing', 'AccountsIntregrationController@updateAccountIntegrationBillingV1')->name('v1.accounts.update-item-wise-account-integration-billing');
    Route::get('v1/accounts/get-itemwise-account-integration-billing', 'AccountsIntregrationController@getItemWiseIntegrationBillingV1')->name('v1.accounts.get-itemwise-account-integration-billing');
    Route::get('v1/accounts/edit-accounts-integration-billing/{id}', 'AccountsIntregrationController@editAccountsIntegrationBillingV1')->name('v1.accounts.edit-accounts-integration-billing');
    Route::get('v1/accounts/accounts-billing-details/{id}', 'AccountsIntregrationController@accountsIntegrationDetailsBillingV1')->name('v1.accounts.accounts-billing-details');


    // General Ledger wise report

    //Reports-General Ledger wise
    Route::get('v1/accounts/gl-wise-report', 'AccountsReportController@general_ledger_wise_report')->name('v1.accounts.gl-wise-report');
    Route::post('v1/accounts/show-gl-wise-report', 'AccountsReportController@show_gl_wise_report')->name('v1.accounts.show-gl-wise-report');
    Route::post('v1/accounts/download-general-ledger-wise-reort-excel', 'AccountsReportController@downloadGLWiseExcelV1')->name('v1.accounts.download-general-ledger-wise-reort-excel');

    // Bank Reconciliation
    Route::get('v1/accounts/account-bank-reconciliation', 'AccountsReportController@accountBankReconciliationV1')->name('v1.accounts.account-bank-reconciliation');
    Route::post('v1/accounts/account-bank-reconciliation-data', 'AccountsReportController@accountBankReconciliationDataV1')->name('v1.accounts.bank-reconciliaton-data');
    Route::post('v1/accounts/bank-reconciliaton', 'AccountsReportController@accountBankReconciliationEntryV1')->name('v1.accounts.bank-reconciliaton');
    Route::post('v1/accounts/save-bank-reconciliation', 'AccountsReportController@accountBankReconciliationSaveV1')->name('v1.accounts.save-bank-reconciliation');
    // Bank Reconciliation Summary
    Route::get('v1/accounts/account-bank-reconciliation-summary', 'AccountsReportController@accountBankReconciliationSummaryV1')->name('v1.accounts.account-bank-reconciliation-summary');
    Route::post('v1/accounts/bank-reconciliaton-summery', 'AccountsReportController@accountBankReconciliationSummeryV1')->name('v1.accounts.bank-reconciliaton-summery');
    // Export
    Route::post('v1/accounts/download-bank-reconciled-report-excel', 'AccountsReportController@downloadBankReconciledExcelV1')->name('v1.accounts.download-bank-reconciled-report-excel');
    Route::post('v1/accounts/download-bank-reconciled-report-pdf', 'AccountsReportController@downloadBankReconciledPDFV1')->name('v1.accounts.download-bank-reconciled-report-pdf');

    // Manual Process Journal Entry
    Route::get('v1/accounts/accounts-manual-journal-entry', 'AccountsIntregrationController@manualJournalEntry')->name('v1.accounts.accounts-manual-journal-entry');



    // Close Accounts Route v1


    // Accounts Routes
    Route::get('accounts/autocomplete-transection-head', 'AccountsController@autocompelete_transection_head')->name('accounts.autocomplete-transection-head');
    Route::get('accounts/voucher-entry', 'AccountsController@accountsVoucherEntry')->name('accounts.voucher-entry');
    Route::get('accounts/voucher-employee-info', 'AccountsController@get_employee')->name('accounts.voucher-employee-info');
    Route::get('accounts/voucher-supplier-info', 'AccountsController@get_supplier')->name('accounts.voucher-supplier-info');
    Route::get('accounts/voucher-patient-info', 'AccountsController@get_patient')->name('accounts.voucher-patient-info');
    Route::post('accounts/get-account-balance', 'AccountsController@get_account_balance')->name('accounts.get-account-balance');
    Route::get('accounts/voucher-info', 'AccountsController@accountsVoucherInfo')->name('accounts.voucher-info');
    Route::post('accounts/voucher-edit', 'AccountsController@edit_voucher')->name('accounts.voucher-edit');
    Route::post('accounts/show-vouchers-info', 'AccountsController@show_voucher_info')->name('accounts.show-vouchers-info');
    Route::get('accounts/voucher-finalize', 'AccountsController@accountsVoucherFinalize')->name('accounts.voucher-finalize');
    Route::post('accounts/show-vouchers-finalize', 'AccountsController@show_voucher_finalize')->name('accounts.show-vouchers-finalize');

    Route::get('accounts-intregration', 'AccountsIntregrationController@index')->name('accounts.intregration.index');
    Route::post('accounts/acc-type-wise-data', 'AccountsIntregrationController@accTypeWiseData')->name('accounts.acc-type-wise-data');
    Route::post('accounts-intregration/store/itemwise', 'AccountsIntregrationController@storeItemWise')->name('accounts.intregration.store.itemwise');
    Route::post('accounts-intregration/store/itemtype', 'AccountsIntregrationController@storeItemType')->name('accounts.intregration.store.itemtype');
    Route::post('accounts-intregration/store/serviceunit', 'AccountsIntregrationController@storeserviceunit')->name('accounts.intregration.store.serviceunit');
    Route::post('accounts-intregration/store/acctype', 'AccountsIntregrationController@storeacctype')->name('accounts.intregration.store.acctype');
    Route::post('accounts-intregration/store/acctype-payroll', 'AccountsIntregrationController@storePayroll')->name('accounts.intregration.store.payroll');
    Route::post('accounts-intregration/store/costcenter', 'AccountsIntregrationController@storeacostcenter')->name('accounts.intregration.store.costcenter');
    Route::post('accounts-intregration/store/costcenterchild', 'AccountsIntregrationController@storeacostcenterchild')->name('accounts.intregration.store.costcenterchild');
    Route::get('accounts-intregration/search/item', 'AccountsIntregrationController@searchitem');
    Route::get('accounts-intregration/fetch-itemwise', 'AccountsIntregrationController@fetchItemwise')->name('accounts-intregration.fetch-itemwise');
    Route::get('accounts-intregration/fetch-itemtypewise', 'AccountsIntregrationController@fetchitemtypewise')->name('accounts-intregration.fetch-itemtypewise');
    Route::get('accounts-intregration/fetch-serviceunit', 'AccountsIntregrationController@fetchserviceunit')->name('accounts-intregration.fetch-serviceunit');
    Route::get('accounts-intregration/fetch-acctypewise', 'AccountsIntregrationController@fetchacctypewise')->name('accounts-intregration.fetch-acctypewise');
    Route::get('accounts-intregration/fetch-acctpayroll', 'AccountsIntregrationController@fetchPayrollwise')->name('accounts-intregration.fetch-accpayroll');
    Route::get('accounts-intregration/fetch-costcenter', 'AccountsIntregrationController@fetchcostcenter')->name('accounts-intregration.fetch-costcenter');
    Route::get('accounts-intregration/fetch-costcenterchild', 'AccountsIntregrationController@fetchcostcenterchild')->name('accounts-intregration.fetch-costcenterchild');
    Route::get('accounts-acc-type-integration-edit/{id}', 'AccountsIntregrationController@editAccountTypeWise')->name('accounts.acc-type-integration-edit');
    Route::get('accounts-acc-payroll-integration-edit/{id}', 'AccountsIntregrationController@editAccountPayroll')->name('accounts.acc-payroll-integration-edit');
    //Accounts Reports
    Route::get('accounts/accounts-summery', 'AccountsReportController@accounts_summery')->name('accounts.accounts-summery');
    Route::post('accounts/accounts-summery-print', 'AccountsReportController@accounts_summery_print')->name('accounts.accounts-summery-print');
    Route::post('accounts/accounts-summery-excel', 'AccountsReportController@accounts_summery_print_excel')->name('accounts.accounts-summery-excel');
    Route::get('accounts/todays-income', 'AccountsReportController@todays_income')->name('accounts.todays-income');
    Route::post('accounts/show_daily_income', 'AccountsReportController@daily_income_search')->name('accounts.show-daily-income');
    Route::get('accounts/daybook', 'AccountsReportController@day_book')->name('accounts.day-book');
    Route::post('accounts/daybook_search', 'AccountsReportController@day_book_search')->name('accounts.daybook_search');
    Route::post('accounts/show_daybook', 'AccountsReportController@show_day_book')->name('accounts.show-day-book');
    Route::post('accounts/show_excel_daybook', 'AccountsReportController@show_excel_day_book')->name('accounts.show-excel-day-book');
    Route::get('accounts/cashflow-statement', 'AccountsReportController@cash_flow_statement')->name('accounts.cashflow-statement');
    Route::post('accounts/show-cashflow-statement', 'AccountsReportController@show_cashflow_statement')->name('accounts.show-cashflow-statement');
    Route::get('accounts/receipt-payment-statement', 'AccountsReportController@receipt_payment_statement')->name('accounts.receipt-payment-statement');
    Route::post('accounts/show-receipt-payment-statement', 'AccountsReportController@show_receipt_payment_statement')->name('accounts.show-receipt-payment-statement');
    Route::get('accounts/account-ledger', 'AccountsReportController@bank_statement')->name('accounts.account-ledger');
    Route::get('accounts/bank-account-ledger', 'AccountsReportController@bank_ledger_statement')->name('accounts.bank-account-ledger');

    Route::get('accounts/gl', 'AccountsReportController@general_ledger_search')->name('accounts.gl');
    Route::post('accounts/general-ledger', 'AccountsReportController@general_ledger')->name('accounts.general-ledger');
    Route::get('accounts/show-subsidiary-ledger', 'AccountsReportController@show_subsidiary_ledger')->name('accounts.show-subsidiary-ledger');

    Route::post('accounts/show-bank-ledger-statement', 'AccountsReportController@show_ledger_bank_statement')->name('accounts.show-bank-ledger-statement');
    Route::get('accounts/show-ledger-statement', 'AccountsReportController@show_bank_statement')->name('accounts.show-ledger-statement');
    Route::post('accounts/show-ledger-statement', 'AccountsReportController@show_bank_statement')->name('accounts.show-ledger-statement');
    Route::post('accounts/show-excel-ledger-statement', 'AccountsReportController@show_excel_bank_statement')->name('accounts.show-excel-ledger-statement');
    Route::get('accounts/patient-ledger', 'AccountsReportController@patient_ledger')->name('accounts.patient-ledger');
    Route::post('accounts/show-patient-ledger-statement', 'AccountsReportController@show_patient_statement')->name('accounts.show-patient-ledger-statement');
    Route::get('accounts/show-patient-ledger-statement', 'AccountsReportController@show_patient_statement')->name('accounts.show-patient-ledger-statement');

    Route::get('accounts/employee-ledger', 'AccountsReportController@employee_ledger')->name('accounts.employee-ledger');
    Route::post('accounts/show-employee-ledger-statement', 'AccountsReportController@show_employee_statement')->name('accounts.show-employee-ledger-statement');
    Route::get('accounts/supplier-ledger', 'AccountsReportController@supplier_ledger')->name('accounts.supplier-ledger');
    Route::post('accounts/show-supplier-ledger-statement', 'AccountsReportController@show_supplier_statement')->name('accounts.show-supplier-ledger-statement');
    Route::get('accounts/trail-balance', 'AccountsReportController@trail_balance')->name('accounts.trail-balance');
    Route::post('accounts/generate-trail-balance', 'AccountsReportController@generate_trial_balance')->name('accounts.generate-trail-balance');
    Route::get('accounts/profit-loss', 'AccountsReportController@show_profit_loss')->name('accounts.profit-loss');
    Route::post('accounts/show-profit-loss', 'AccountsReportController@generate_profit_loss_statement')->name('accounts.show-profit-loss');
    Route::get('accounts/balance-sheet', 'AccountsReportController@show_balance_sheet')->name('accounts.balance-sheet');
    Route::post('accounts/generate-balance-sheet', 'AccountsReportController@generate_balance_sheet')->name('accounts.generate-balance-sheet');

    Route::get('accounts/ar-processing', 'AccountsController@arProcessing')->name('accounts.ar-processing');
    Route::get('accounts/voucher-verify', 'AccountsController@voucherVerify')->name('accounts.voucher-verify');
    Route::get('accounts/account-setup', 'AccountsController@accountsSetup')->name('accounts.account-setup');
    Route::get('accounts/get-chartof-account-byid', 'AccountsController@get_chart_of_account_by_id')->name('accounts.get-chartof-account-byid');
    Route::post('accounts/save-acc-type', 'AccountTypeController@save_account_type')->name('save-acc-type');
    Route::post('accounts/save-chart-of-accounts', 'ChartOfAccountsController@save_chart_of_accounts')->name('save-chart-of-accounts');
    Route::post('accounts/update-chart-of-accounts', 'ChartOfAccountsController@update_chart_of_accounts')->name('update-chart-of-accounts');
    Route::get('accounts/get-chart-of-accounts', 'ChartOfAccountsController@get_chart_of_account')->name('get-chart-of-accounts');
    Route::get('accounts/get-acc-type-chart-of-accounts', 'ChartOfAccountsController@ajax_account_level')->name('get-acc-type-chart-of-accounts');
    Route::get('accounts/get-root-accounts', 'ChartOfAccountsController@get_root_account')->name('get-root-accounts');
    Route::post('accounts/update-acc-type', 'AccountTypeController@update_account_type')->name('update-acc-type');
    Route::get('accounts/get-acc-type', 'AccountTypeController@account_type')->name('get-acc-type');
    Route::get('accounts/module-setup', 'AccountsController@moduleSetup')->name('accounts.module-setup');
    Route::get('accounts/stock-item-setup', 'AccountsController@stockItemSetup')->name('accounts.stock-item-setup');
    Route::get('accounts/fiscal-year', 'AccountsController@fiscalYear')->name('accounts.fiscal-year');
    Route::get('accounts/default-acc-head-mapping', 'AccountsController@defaultAccHeadMapping')->name('accounts.default-acc-head-mapping');
    Route::get('last-account-code', 'AccountsController@last_account_code')->name('last-account-code');
    Route::get('get-accounts-level', 'AccountsController@get_accounts_level')->name('get-accounts-level');
    Route::get('request-get-accounts-level/{acc_id}', 'AccountsController@request_get_accounts_level')->name('request-get-accounts-level');
    Route::post('set-vouchertype-status', 'AccountsController@set_voucher_type_status')->name('set-vouchertype-status');
    Route::post('add-vouchertype', 'VoucherTypeController@add_voucher_type')->name('add-vouchertype');
    Route::get('get-vouchertype', 'VoucherTypeController@get_voucher_type')->name('get-vouchertype');
    Route::post('cash-receipt-voucher', 'VoucherEntryController@cash_receipt_entry')->name('cash-receipt-voucher');
    Route::post('bank-receipt-voucher', 'VoucherEntryController@bank_receipt_entry')->name('bank-receipt-voucher');
    Route::post('cash-payment-voucher', 'VoucherEntryController@cash_payment')->name('cash-payment-voucher');
    Route::post('bank-payment-voucher', 'VoucherEntryController@bank_payment_entry')->name('bank-payment-voucher');
    Route::post('journal-voucher', 'VoucherEntryController@journal_voucher_entry')->name('journal-voucher');
    Route::post('active-inactive-voucher', 'VoucherInformationController@active_inactive_voucher')->name('active-inactive-voucher');
    Route::get('set-active-inactive-voucher', 'VoucherInformationController@set_active_inactive_voucher')->name('set-active-inactive-voucher');
    Route::get('set-finalized-notfinalized-voucher', 'VoucherInformationController@set_finalized_nofinalized_voucher')->name('set-finalized-nofinalized-voucher');
    Route::get('voucher', 'VoucherInformationController@voucher')->name('voucher');
    Route::get('voucher-ewmch', 'VoucherInformationController@voucherEwmch')->name('voucher-ewmch');
    Route::get('view_voucher', 'VoucherInformationController@view_voucher')->name('view_voucher');

    //Chart of Account Tree
    Route::get('tree-view', 'AccountsController@treeView')->name('tree-view');
});
Route::middleware(['auth', 'check_access'])->group(function () {

    // construction  Module
    Route::get('construction/work-order-entry', [ConstructionController::class, 'index'])->name('construction.work-order-entry');
    Route::post('construction/work-order-save', [ConstructionController::class, 'store'])->name('construction.save-work-order');
    Route::get('construction/work-order-list', [ConstructionController::class, 'worklist'])->name('construction.work-order-list');
    Route::post('construction/search-work-order-worklist', [ConstructionController::class, 'searchWorkOrder'])->name('construction.search-work-order-worklist');
    Route::get('construction/edit-work-order/{id}', [ConstructionController::class, 'edit'])->name('construction.edit-work-order');
    Route::get('construction/show-work-order/{id}', [ConstructionController::class, 'show'])->name('construction.show-work-order');
    Route::post('construction/post-work-order', [ConstructionController::class, 'postWorkOrder'])->name('construction.post-work-order');

    // approval status check
    Route::get('v1/my-approval-level-detail-work-order-list/{id}', [HOSApprovalMatrixController::class, 'myApprovalLevelDetailWorkOrderList'])->name('v1.my.approval.level.detail-work-order-list');
    Route::get('v1/my-approval-level-detail-po/{id}', [HOSApprovalMatrixController::class, 'myApprovalLevelDetailPOList'])->name('v1.my.approval.level.detail-po');
    Route::get('v1/my-approval-level-detail-work-order-bill-generate-list/{id}', [HOSApprovalMatrixController::class, 'myApprovalLevelDetailWorkOrderBillList'])->name('v1.my.approval.level.detail-work-order-bill-generate-list');

    Route::get('construction/work-order-bill-generate', [ConstructionController::class, 'billWorklist'])->name('construction.work-order-bill-generate');
    Route::post('construction/search-work-order-bill-generate-worklist', [ConstructionController::class, 'searchBillGenerateWorkOrder'])->name('construction.search-work-order-bill-generate-worklist');
    Route::get('construction/bill-generate/{id}', [ConstructionController::class, 'billGenerate'])->name('construction.bill-generate');
    Route::get('construction/show-bill/{id}', [ConstructionController::class, 'billGeneratePDF'])->name('construction.show-bill');

    // Bill Approved worklist
    Route::get('construction/work-order-bill-approved-worklist', [ConstructionController::class, 'billApprovedWorklist'])->name('construction.work-order-bill-approved-worklist');
    Route::post('construction/search-work-order-bill-approved-worklist', [ConstructionController::class, 'searchBillApprovedWorkOrder'])->name('construction.search-work-order-bill-approved-worklist');

    Route::get('construction/partial-payment/{id}', [ConstructionController::class, 'partialPayment'])->name('construction.partial-payment');
    Route::get('construction/partial-payment-history/{id}', [ConstructionController::class, 'partialPaymentHistory'])->name('construction.partial-payment-history');
    Route::post('construction/partial-payment-entry', [ConstructionController::class, 'partialPaymentEntry'])->name('construction.partial-payment-entry');


    // Partial Bill Generate
    Route::get('construction/partial-bill-generate/{id}', [ConstructionController::class, 'partialBillGenerate'])->name('construction.partial-bill-generate');
    Route::get('construction/partial-bill-history/{id}', [ConstructionController::class, 'partialBillHistory'])->name('construction.partial-bill-history');
    Route::post('construction/partial-bill-entry', [ConstructionController::class, 'partialBillEntry'])->name('construction.partial-bill-generate-entry');
    Route::post('construction/download-partial-bill-history-pdf', [ConstructionController::class, 'downloadBillHistory'])->name('construction.download-partial-bill-history-pdf');
    // pdf export
    Route::post('construction/download-payment-history-pdf', [ConstructionController::class, 'downloadPaymentHistory'])->name('construction.download-payment-history-pdf');
    Route::post('construction/download-approved-work-order', [ConstructionController::class, 'downloadApprovedWorkOrder'])->name('construction.download-approved-work-order');



    // SMS Routes
    Route::get('sms-modal/{param}', 'SMSController@smsModal')->name('sms-modal');
    Route::get('ipd-sms-modal/{param}', 'SMSController@ipdSmsModal')->name('ipd-sms-modal');
    Route::post('send-custom-sms', 'SMSController@sendSms')->name('send-custom-sms');
    Route::post('send-ipd-custom-sms', 'SMSController@sendIPDSms')->name('send-ipd-custom-sms');

    Route::get('mail-modal/{patient_id}', 'MailController@mailModal')->name('mail-modal');
    Route::post('send-mail', 'MailController@sendMail')->name('send-mail');

    Route::resource('pacs', 'PACSController');

    //added By Nazmul
    Route::get('/tv-screen', 'DashboardController@tvScreen')->name('tv-screen');
    Route::post('/tv-screen', 'DashboardController@tvScreenDataTable')->name('tv-screen-data-table');
    Route::post('/room-for-tv-screen', 'DashboardController@DeptWiseRoom')->name('room-for-tv-screen');

    Route::post('lookupCodeId', 'PresLookupDetailDataController@getLookupCodeId')->name('lookupCodeId');
    Route::resource('preslookupdetaildata', 'PresLookupDetailDataController');
    Route::get('preslookupdetaildata-form', 'PresLookupDetailDataController@create_form')->name('preslookupdetaildata-form');
    Route::get('pcrm/individual-doctor-wise-performance-details-report', 'ReportController@getIndividualDoctorPerformanceDetails')->name('pcrm.individual-doctor-wise-performance-details-report');
    Route::post('pcrm/individual-doctor-wise-performance-details-report-search', 'ReportController@getIndividualDoctorPerformanceDetailsSearch')->name('pcrm.individual-doctor-wise-performance-details-report-search');
    Route::post('pcrm/individual-doctor-wise-performance-details-report-pdf', 'ReportController@getIndividualDoctorPerformanceDetailsPdf')->name('pcrm.individual-doctor-wise-performance-details-report-pdf');

    // doctor income summary report
    Route::get('pcrm/doctor-wise-income-summary', 'ReportController@doctorWiseIncomeSummery')->name('pcrm.doctor-wish-income-summery');
    Route::get('pcrm-doctor-wise-income-summary-details/{person_no_pk}/{to_date?}/{from_date?}/{type?}', 'ReportController@doctorWiseIncomeSummeryDetails')->name('doctor-wise-income-summary-details');
    Route::post('pcrm/doctor-wish-income-summery-search', 'ReportController@doctorWiseIncomeSummerySearch')->name('pcrm.doctor-wish-income-summery-search');
    Route::post('pcrm/doctor-wish-income-summery-pdf/{id}', 'ReportController@doctorWiseIncomeSummeryPdf')->name('pcrm.doctor-wish-income-summery-pdf');

    # Doctor Performance Summary
    Route::get('reports/doctor-performance-summary', [ReportController::class, 'doctorPerformanceSummary'])->name('reports.doctor-performance-summary');
    Route::post('reports/doctor-performance-summary-search', [ReportController::class, 'doctorPerformanceSummarySearch'])->name('reports.doctor-performance-summary-search');
    Route::post('reports/doctor-performance-summary-download/{type}', [ReportController::class, 'doctorPerformanceSummaryDownload'])->name('reports.doctor-performance-summary-download');

    # Patient Flow Summary
    Route::get('/patient-flow-summary', [ReportController::class, 'patientFlowSummary'])->name('reports.patientFlowSummary');
    Route::post('/reports/patient-flow-summary', [ReportController::class, 'patientFlowSummaryReport'])->name('reports.patientFlowSummaryReport');

    // referral payment details report
    Route::get('pcrm/doctor-referal-wise-income-summary', 'ReportController@doctorReferalWiseIncomeSummery')->name('pcrm.doctor-referal-wish-income-summery');
    Route::post('pcrm/doctor-referal-wish-income-summery-search', 'ReportController@doctorReferalWiseIncomeSummerySearch')->name('pcrm.doctor-referal-wish-income-summery-search');
    Route::post('pcrm/doctor-referal-wish-income-summery-pdf/{id}', 'ReportController@doctorReferalWiseIncomeSummeryPdf')->name('pcrm.doctor-referal-wish-income-summery-pdf');
    Route::get('pcrm/referral-payment-report', 'PcrmController@referralPaymentReport')->name('pcrm.referral-payment-report');
    Route::post('pcrm/referral-payment-report-search', 'PcrmController@referralPaymentSearch')->name('pcrm.referral-payment-report-search');
    Route::post('pcrm/referral-payment-search-pdf/{id}', 'PcrmController@referralPaymentPdf')->name('pcrm.referral-payment-search-pdf');



    // Route::get('job-test', function () {

    //     foreach (range(0, 5) as $number) {
    //         dispatch(function() {
    //             sleep(5);
    //             logger('job done!');
    //         });
    //     }

    //     dd('loaded!');
    // });

    Route::get('pcrm/supplier-wise-po-report', 'ReportController@getSupplierWisePo')->name('pcrm.supplier-wise-po-report');
    Route::post('pcrm/supplier-wise-po-report-search', 'ReportController@getSupplierWisePoSearch')->name('pcrm.supplier-wise-po-report-search');
    Route::post('pcrm/supplier-wise-po-report-pdf', 'ReportController@getSupplierWisePoPdf')->name('pcrm.supplier-wise-po-report-pdf');
    Route::get('pcrm/supplier-wise-po-item-details-report', 'ReportController@getSupplierWisePoItemDetails')->name('pcrm.supplier-wise-po-item-details-report');
    Route::post('pcrm/supplier-wise-po-item-details-report-search', 'ReportController@getSupplierWisePoItemDetailsReportSearch')->name('pcrm.supplier-wise-po-item-details-report-search');
    Route::post('pcrm/supplier-wise-po-item-details-report-pdf', 'ReportController@getSupplierWisePoItemDetailsReportPdf')->name('pcrm.supplier-wise-po-item-details-report-pdf');
    Route::get('pcrm/supplier-ledger-report', 'ReportController@getSupplierLedger')->name('pcrm.supplier-ledger-report');
    Route::get('pcrm/supplier-id/{id?}', 'ReportController@getSupplierId')->name('pcrm.supplier-id');
    Route::get('pcrm/po-no/{no?}', 'ReportController@getPONo')->name('pcrm.po-no');
    Route::post('pcrm/supplier-ledger-report-search', 'ReportController@getSupplierLedgerSearch')->name('pcrm.supplier-ledger-report-search');
    Route::post('pcrm/supplier-ledger-report-pdf', 'ReportController@getSupplierLedgerReportPdf')->name('pcrm.supplier-ledger-report-pdf');

    Route::get('pcrm/doctor-wise-performance-summary-report', 'PcrmController@getDoctorPerformanceSummaryReport')->name('pcrm.doctor-wise-performance-summary-report');
    Route::post('pcrm/doctor-wise-performance-summary-report-search', 'PcrmController@getDoctorPerformanceSummaryReportSearch')->name('pcrm.doctor-wise-performance-summary-report-search');
    Route::post('pcrm/doctor-wise-performance-summary-report-pdf', 'PcrmController@getDoctorPerformanceSummaryReportPdf')->name('pcrm.doctor-wise-performance-summary-report-pdf');

    // daily performance of the consultation
    Route::get('pcrm/daily-doctor-wise-performance-report', 'PcrmController@getDailyDoctorPerformanceReport')->name('pcrm.daily-doctor-wise-performance-report');
    Route::post('pcrm/daily-doctor-wise-performance-report-search', 'PcrmController@getDailyDoctorPerformanceReportSearch')->name('pcrm.daily-doctor-wise-performance-report-search');
    Route::post('pcrm/daily-doctor-wise-performance-report-pdf', 'PcrmController@getDailyDoctorPerformanceReportPdf')->name('pcrm.daily-doctor-wise-performance-report-pdf');

    // daily MIS report OPD
    Route::get('pcrm/daily-mis-opd-report', 'PcrmController@getDailyMisOpdReport')->name('pcrm.daily-mis-opd-report');
    Route::post('pcrm/daily-mis-opd-report-search', 'PcrmController@getDailyMisOpdReportSearch')->name('pcrm.daily-mis-opd-report-search');
    Route::post('pcrm/daily-mis-opd-report-pdf', 'PcrmController@getDailyMisOpdReportPdf')->name('pcrm.daily-mis-opd-report-pdf');

    // daily MIS report IPD
    Route::get('pcrm/daily-mis-ipd-report', 'PcrmController@getDailyMisIpdReport')->name('pcrm.daily-mis-ipd-report');
    Route::post('pcrm/daily-mis-ipd-report-search', 'PcrmController@getDailyMisIpdReportSearch')->name('pcrm.daily-mis-ipd-report-search');
    Route::post('pcrm/daily-mis-ipd-report-pdf', 'PcrmController@getDailyMisIpdReportPdf')->name('pcrm.daily-mis-ipd-report-pdf');


    Route::get('opd/nurse-station-report', 'ReportController@getNurseStationReport')->name('opd.nurse-station-report');
    Route::post('opd/nurse-station-report-search', 'ReportController@getNurseStationReportSearch')->name('opd.nurse-station-report-search');
    Route::post('opd/nurse-station-report-pdf', 'ReportController@getNurseStationReportPdf')->name('opd.nurse-station-report-pdf');
    Route::get('delivery-man/delivery-service-report', 'ReportController@getDeliveryServiceReport')->name('delivery-man.delivery-service-report');
    Route::post('delivery-man/delivery-service-report-search', 'ReportController@getDeliveryServiceReportSearch')->name('delivery-man.delivery-service-report-search');
    Route::post('delivery-man/delivery-service-report-pdf', 'ReportController@getDeliveryServiceReportPdf')->name('delivery-man.delivery-service-report-pdf');





    // Supplier Payment Worklist
    Route::get('supplier-payment-worklist', 'SupplierPaymentController@supplierPaymentWorklist')->name('supplier-payment-worklist');
    Route::get('supplier-finalize-worklist', 'SupplierPaymentController@supplierFinalizeWorklist')->name('supplier-finalize-worklist');
    Route::get('supplier-disbursement-worklist', 'SupplierPaymentController@supplierDisbursementWorklist')->name('supplier-disbursement-worklist');
    Route::get("supplier-payment-worklist-voucher-search", 'SupplierPaymentController@supplierPaymentWorklistVoucherSearch')->name('supplier-payment-worklist-voucher-search');
    Route::post('supplier-payment-search-worklist', 'SupplierPaymentController@suppilerPaymentSearchWorklist')->name('supplier-payment-search-worklist');
    Route::post('supplier-payment-print', 'SupplierPaymentController@suppilerPaymentPrint')->name('supplier-payment-print');

    Route::get('supplier-advance-worklist', 'SupplierPaymentController@supplierAdvanceWorklist')->name('supplier-advance-worklist');
    Route::post('supplier-advance-search-worklist', 'SupplierPaymentController@suppilerAdvanceSearchWorklist')->name('supplier-advance-search-worklist');
    Route::post('supplier-advance-print', 'SupplierPaymentController@suppilerAdvancePrint')->name('supplier-advance-print');

    Route::get('supplier-deduct-worklist', 'SupplierPaymentController@supplierDeductWorklist')->name('supplier-deduct-worklist');
    Route::post('supplier-deduct-search-worklist', 'SupplierPaymentController@suppilerDeductSearchWorklist')->name('supplier-deduct-search-worklist');
    Route::post('supplier-deduct-print', 'SupplierPaymentController@suppilerDeductPrint')->name('supplier-deduct-print');

    Route::get('supplier-payment-bill', 'SupplierPaymentController@supplierPaymentBill')->name('supplier-payment-bill');
    Route::get('supplier-payment-bill-list', 'SupplierPaymentController@supplierPaymentBillList')->name('supplier-payment-bill-list');
    Route::post('supplier-payment-bill-list-search', 'SupplierPaymentController@supplierPaymentBillListSearch')->name('supplier-payment-bill-list-search');

    //lab step cancelation
    Route::resource('investigation-cancel', 'InvestigationCancelController');
    Route::post('inv/get-investigation-data-search', 'InvestigationCancelController@cancelInvestigation')->name('inv.get-investigation-data-search');
    Route::get('inv/restructure', 'InvestigationCancelController@reStructure')->name('inv.restructure');
    Route::post('inv/set-item-restructure', 'InvestigationCancelController@setItemRestructure')->name('set-item-restructure');
    Route::post('inv/cancel-investigation-data', 'InvestigationCancelController@cancelInvestigationItem')->name('inv.cancel-investigation-data');
    Route::post('inv/split-investigation-data', 'InvestigationCancelController@splitInvestigationData')->name('inv.split-investigation-data');
    //pathology sample collection life cycle
    Route::get('path-sample-collection-life-cycle', 'InvestigationCancelController@PathSampleCollectionLifeCycle')->name('path-sample-collection-life-cycle');
    Route::post('path-sample-collection-life-cycle-search', 'InvestigationCancelController@PathSampleCollectionLifeCycleSearch')->name('path-sample-collection-life-cycle-search');

    # Laboratory Life Cycle
    Route::get('laboratory-life-cycle', [InvestigationCancelController::class, 'laboratoryLifeCycle'])->name('laboratoryLifeCycle.index');
    Route::post('laboratory-life-cycle/get-data', [InvestigationCancelController::class, 'getData'])->name('laboratoryLifeCycle.getData');
    Route::post('laboratory-life-cycle/filter', [InvestigationCancelController::class, 'filter'])->name('laboratoryLifeCycle.filter');

    # service item from prescription show to billing
    Route::get('service-item-from-prescription/SERVICE', [InvestigationCancelController::class, 'serviceItemFromPrescription'])->name('service-item-from-prescription');
    Route::get('med-item-from-prescription/MED', [InvestigationCancelController::class, 'medItemFromPrescription'])->name('med-item-from-prescription');
    Route::post('service-item-from-prescription/get-data', [InvestigationCancelController::class, 'serviceItemFromPrescriptionGetData'])->name('service-item-from-prescription.getData');
    Route::post('service-item-from-prescription/filter', [InvestigationCancelController::class, 'serviceItemfilter'])->name('service-item-from-prescription.filter');

    // Medicine delivery
    Route::get('med-item-delivery', [InvestigationCancelController::class, 'medItemDelivery'])->name('med-item-delivery');
    Route::post('med-item-from-prescription/get-data', [InvestigationCancelController::class, 'medItemFromPrescriptionGetData'])->name('med-item-from-prescription.getData');
    Route::post('med-item-from-prescription-ready/get-data', [InvestigationCancelController::class, 'medItemFromPrescriptionReadyGetData'])->name('med-item-from-prescription-ready.getData');
    Route::post('med-item-from-prescription/filter', [InvestigationCancelController::class, 'medItemfilter'])->name('med-item-from-prescription.filter');
    Route::post('med-item-search', [InvestigationCancelController::class, 'medItemSearch'])->name('med-item-search');
    Route::post('med-item-delivered', [InvestigationCancelController::class, 'medItemDelivered'])->name('med-item-delivered');
    Route::post('med-item-ready', [InvestigationCancelController::class, 'medItemReady'])->name('med-item-ready');
    Route::post('med-item-delivery-done', [InvestigationCancelController::class, 'medItemDeliveryDone'])->name('med-item-delivery-done');
    Route::get('dose-print/{invoice}/{pres_id}', [InvestigationCancelController::class, 'dosePrint'])->name('dose-print');
    Route::get('prescriped-medicine-list-pdf/{pres_id}', [InvestigationCancelController::class, 'prescripedMedListPdf'])->name('prescriped-medicine-list-pdf');

    //rad step cancelation
    Route::get('investigation-cancel-rad', 'InvestigationCancelController@createRad')->name('investigation-cancel-rad');
    Route::post('inv/get-investigation-data-search-rad', 'InvestigationCancelController@cancelInvestigationRad')->name('inv.get-investigation-data-search-rad');
    Route::post('inv/cancel-investigation-data-rad', 'InvestigationCancelController@cancelInvestigationItemRad')->name('inv.cancel-investigation-data-rad');

    Route::resource('prescription-favourite-item', 'PrescriptionFavouriteController');
    Route::post('departmentId', 'PrescriptionFavouriteController@getDepartmentId')->name('departmentId');
    Route::get('prescription-favourite-item-form', 'PrescriptionFavouriteController@create_form')->name('prescription-favourite-item-form');
    Route::get('prescription-favourite-item-form', 'PrescriptionFavouriteController@create_form')->name('prescription-favourite-item-form');
    Route::get('delivery-man-list', 'DeliveryController@getDeliveryManList')->name('delivery-man-list');
    Route::get('admin-assigned-order-list', 'DeliveryController@getAssignedOrderList')->name('admin-assigned-order-list');
    Route::get('admin-unassigned-order-list', 'DeliveryController@getUnassignedOrderList')->name('admin-unassigned-order-list');
    Route::get('admin-picked-order-list', 'DeliveryController@getPickedOrderList')->name('admin-picked-order-list');
    Route::get('admin-cancelled-order-list', 'DeliveryController@getCancelledOrderList')->name('admin-cancelled-order-list');
    Route::get('admin-delivered-order-list', 'DeliveryController@getDeliveredOrderList')->name('admin-delivered-order-list');
    Route::get('delivery-info/{order_id}', 'DeliveryController@getDeliveryInfo')->name('delivery-info');
    Route::get('item-info/{order_id}', 'DeliveryController@getItemInfo')->name('item-info');
    Route::get('delivery-item-info/{order_id}', 'DeliveryManDashboardController@getDeliveryItemInfo')->name('delivery-item-info');
    Route::get('delivery-item-batch/{order_id}/{service_point}', 'DeliveryManDashboardController@getDeliveryItemWithBatch')->name('delivery-item-batch');
    Route::get('update-delivery-info/{ecom_delivery_no}', 'DeliveryController@updateDeliveryInfo')->name('update-delivery-info');
    Route::post('create-delivery', 'DeliveryController@createDelivery')->name('create-delivery');
    Route::post('update-delivery', 'DeliveryController@updateDelivery')->name('update-delivery');
    Route::get('/delivery-man/login', 'DeliveryManLoginController@getLoginForm')->name('delivery-man/login');
    Route::get('delivery-man/logout', 'DeliveryManLoginController@logout')->name('delivery-logout');
    Route::post('delivery-man/credential/submission', 'DeliveryManLoginController@checkLoginCredential')->name('submission');
    Route::get('delivery-man/dashboard', 'DeliveryManDashboardController@getDashboard')->name('delivery-man.dashboard');
    Route::get('delivery-man/order-list', 'DeliveryManDashboardController@getDeliveryManOrderList')->name('delivery-man.order-list');
    Route::post('pick-delivery', 'DeliveryManDashboardController@pickDelivery')->name('pick-delivery');
    Route::post('complete-delivery', 'DeliveryManDashboardController@completeDelivery')->name('complete-delivery');
    // Route::get('pick-delivery/{id}', 'DeliveryManDashboardController@pickDelivery')->name('pick-delivery');
    Route::post('cancel-delivery', 'DeliveryManDashboardController@cancelDelivery')->name('cancel-delivery');
    Route::get('delivery-man/picked-order-list', 'DeliveryManDashboardController@getPickedOrderList')->name('delivery-man.picked-order-list');
    Route::get('delivery-man/delivered-order-list', 'DeliveryManDashboardController@getDeliveredOrderList')->name('delivery-man.delivered-order-list');
    Route::get('delivery-man/cancelled-order-list', 'DeliveryManDashboardController@getCancelledOrderList')->name('delivery-man.cancelled-order-list');
    Route::get('pharmacy/dashboard', 'PharmacyController@pharmacyDashboard')->name('pharmacy.dashboard');
    Route::get('send-otp-to-customer/{id}', 'DeliveryManDashboardController@sendOtp')->name('send-otp-to-customer');
    Route::get('delivery-man/reset-password', 'DeliveryManDashboardController@getResetPasswordForm')->name('delivery-man.reset-password');
    Route::post('delivery-man/reset-password/update', 'DeliveryManDashboardController@getResetPassword')->name('password.update');
    Route::resource('team', 'TeamController');
    Route::get('sales-team-form', 'TeamController@create_form')->name('sales-team-form');
    Route::get('sales-team-members', 'TeamBuildController@memberList')->name('sales-team-members');
    Route::get('members-by-team', 'TeamBuildController@membersByTeam')->name('members-by-team');
    Route::resource('team-build', 'TeamBuildController');
    // Rate Management
    Route::get('rate/management/general', 'RateManagementController@generalRate')->name('rate.management/general');
    Route::get('rate/management/general/list', 'RateManagementController@generalRateList')->name('rate.management-general-list');
    Route::get('rate/management/item-edit/{id?}/{type?}', 'RateManagementController@editRate')->name('rate.management-item-edit');
    Route::post('rate/management/item-update', 'RateManagementController@updateRate')->name('rate.management-update');
    Route::post('rate/management/general/list', 'RateManagementController@searchGeneralList')->name('rate.management-search-general-list');
    Route::post('rate/management/list/print', 'RateManagementController@searchGeneralListPrint')->name('rate.management-search-list-print');
    // Rate Management PHR
    Route::get('rate/management/general/phr', 'RateManagementController@generalRatePhr')->name('rate.management/general/phr');
    Route::get('rate/management/general/list/phr', 'RateManagementController@generalRateListPhr')->name('rate.management-general-list-phr');
    Route::post('rate/management/general/list/phr', 'RateManagementController@searchGeneralListPhr')->name('rate.management-search-general-list-phr');
    Route::post('rate/management/list/print/phr', 'RateManagementController@searchGeneralListPrintPhr')->name('rate.management-search-list-print-phr');

    Route::resource('delivery-charge', 'DeliveryChargeController');
    Route::get('delivery-charge-form', 'DeliveryChargeController@getDeliveryChargeForm')->name('delivery-charge-form');

    Route::post('populate-default-items', 'StoreController@populateDefaultItems')->name('populate-default-items');
    Route::post('populate-default-items-from-last-purchase', 'StoreController@populateDefaultItemsFromLastPurchase')->name('populate-default-items-from-last-purchase');
    Route::post('filter-default-supplier-items', 'StoreController@filterDefaultSupplierItems')->name('filter-default-supplier-items');

    //Stock Adjustment
    Route::get('stock_consumption', 'StoreAdjustmentController@stock_consumption')->name('stock_consumption');
    Route::post('store_stock_consumption', 'StoreAdjustmentController@store_stock_consumption')->name('store_stock_consumption');
    Route::get('stock_issue_worklist', 'StoreAdjustmentController@stock_issue_worklist')->name('stock_issue_worklist');
    Route::post('search_stock_issue_worklist', 'StoreAdjustmentController@search_stock_issue_worklist')->name('search_stock_issue_worklist');
    Route::post('export_stock_issue', 'StoreAdjustmentController@export_stock_issue')->name('export_stock_issue');
    Route::get('export_stock_issue', 'StoreAdjustmentController@stock_issue_worklist')->name('export_stock_issue');
    Route::post('phr_stock_details', 'PharmacyController@phr_stock_details')->name('phr_stock_details');


    // patient Type
    Route::get('patient-type/create_form', 'PcrmController@create_form')->name('patient-type.create_form');
    Route::post('patient-type/list', 'PcrmController@getAllPatientType')->name('patient-type-list');
    route::get('create-patient-type', 'PcrmController@patientTypeCreate')->name('patient-type-create');
    route::get('edit-patient-type/{id?}', 'PcrmController@editPatientType')->name('patient-type-edit');
    route::get('patient-type', 'PcrmController@patientType')->name('patient-type');
    route::get('edit-patient-type', 'PcrmController@EditPatientType')->name('edit-patient-type');
    route::post('store-patient-type', 'PcrmController@storePatientType')->name('store-patient-type');

    // patient Type
    Route::get('auto-item-type/create_form', 'PcrmController@autoItemTypeForm')->name('auto-item-type.create_form');
    Route::post('auto-item-type/list', 'PcrmController@getAllAutoItemType')->name('auto-item-type-list');
    Route::post('auto-item-list-itemtype', 'PcrmController@autoItemListForItemType')->name('auto-item-list-for-item-type');
    route::get('create-auto-item-type', 'PcrmController@autoItemTypeCreate')->name('auto-item-type-create');
    route::get('auto-item-type', 'PcrmController@autoItemType')->name('auto-item-type');
    route::get('edit-auto-item-type/{id?}', 'PcrmController@EditAutoItemType')->name('edit-auto-item-type');
    route::post('store-auto-item-type', 'PcrmController@storeAutoItemType')->name('store-auto-item-type');


    // Dept Wise performance report
    Route::get('pcrm/dept-wise-performance-report', 'ReportController@deptWisePerformanceReport')->name('pcrm/dept-wise-performance-report');
    Route::post('pcrm/dept-wise-performance-report-search', 'ReportController@deptWisePerformanceDetailsSearch')->name('pcrm/dept-wise-performance-report-search');
    Route::post('pcrm/dept-wise-performance-report-report-excle', 'ReportController@deptWisePerformanceDetailsExcel')->name('pcrm/dept-wise-performance-report-excel');
    Route::post('pcrm/dept-wise-performance-report-report-pdf', 'ReportController@deptWisePerformanceDetailsPdf')->name('pcrm/dept-wise-performance-report-pdf');

    # Doctor Wise Schedule Report
    Route::get('reports/doctor-wise-schedule-report', [ReportController::class, 'doctorWiseScheduleReport'])->name('reports.doctorWiseScheduleReport');
    Route::post('reports/doctor-wise-schedule-report/filter', [ReportController::class, 'doctorWiseScheduleReportFilter'])->name('reports.doctorWiseScheduleReportFilter');
    Route::post('reports/doctor-wise-schedule-report/excel', 'ReportController@doctorWiseScheduleReportExcel')->name('reports.doctorWiseScheduleReportExcel');
    Route::post('reports/doctor-wise-schedule-report/pdf', 'ReportController@doctorWiseScheduleReportPdf')->name('reports.doctorWiseScheduleReportPdf');


    //Month Wise

    Route::get('pcrm/dept-wise-sum-performance-report', 'ReportController@deptWiseSumPerformanceReport')->name('pcrm.dept-wise-sum-performance-report');
    Route::post('pcrm/dept-wise-sum-performance-report-search', 'ReportController@deptWiseSumPerformanceDetailsSearch')->name('pcrm.dept-wise-sum-performance-report-search');
    Route::post('pcrm/dept-wise-sum-performance-report-report-excle', 'ReportController@deptWiseSumPerformanceDetailsExcel')->name('pcrm.dept-wise-sum-performance-report-excel');
    Route::post('pcrm/dept-wise-sum-performance-report-report-pdf', 'ReportController@deptWiseSumPerformanceDetailsPdf')->name('pcrm.dept-wise-sum-performance-report-pdf');


    // Organism Setup
    Route::get('pathology/organism', 'PathologyController@organism')->name('pathology.organism');
    Route::get('pathology/organism/create', 'PathologyController@organismcreate')->name('organism.create');
    Route::get('pathology/organism/form', 'PathologyController@organismForm')->name('pathology.organism-form');
    Route::get('pathology/organism-edit/{id}', 'PathologyController@organismEdit')->name('pathology.organism-edit');
    Route::post('pathology/organism-store', 'PathologyController@organismStore')->name('pathology.organism-store');
    Route::post('pathology/organism-all-data', 'PathologyController@organismAllData')->name('pathology.organism-all-data');


    // Antivic Setup
    Route::get('pathology/antivitic', 'PathologyController@antivitic')->name('pathology.antivitic');
    Route::get('pathology/antivitic/create', 'PathologyController@antiviticcreate')->name('antivitic.create');
    Route::get('pathology/antivitic/form', 'PathologyController@antiviticForm')->name('pathology.antivitic-form');
    Route::get('pathology/antivitic-edit/{id}', 'PathologyController@antiviticEdit')->name('pathology.antivitic-edit');
    Route::post('pathology/antivitic-store', 'PathologyController@antiviticStore')->name('pathology.antivitic-store');
    Route::post('pathology/antivitic-all-data', 'PathologyController@antiviticAllData')->name('pathology.antivitic-all-data');


    // Ticket/Issue Setup
    // Route::resource('user/ticket', 'UserTicketController');
    Route::resource('support/team/ticket', 'SupportTeamTicketController');
    Route::get('support-team-ticket-create', 'SupportTeamTicketController@popUpCreate')->name('support.team.tricket.create');
    Route::post('support-team-ticket-list', 'SupportTeamTicketController@getAllIssueList')->name('support.team.tricket.list');
    Route::get('edit-support-team-ticket/{id}', 'SupportTeamTicketController@editAllSupportTeamTricketList')->name('support.team.tricket.edit');
    Route::post('issue/search', 'SupportTeamTicketController@issueSearch')->name('issue.search');

    // Ticket V1
    Route::get('v1/ticket/user-ticket', 'UserTicketController@index')->name('v1.ticket.user-ticket');
    Route::get('v1/ticket/get-user-ticket', 'UserTicketController@getuserTicket')->name('v1.ticket.get-user-ticket');
    Route::post('v1/ticket/save-user-ticket', 'UserTicketController@store')->name('v1.ticket.save-user-ticket');

    // Ticket-IT
    Route::get('v1/ticket/support-ticket', 'SupportTeamTicketController@home')->name('v1.ticket.support-ticket');
    Route::get('v1/ticket/get-support-ticket/{id}', 'SupportTeamTicketController@getTicketById')->name('v1.get-ticket-by-id');
    Route::get('v1/ticket/get-support-ticket-by-id/{id}', 'SupportTeamTicketController@getSupportTicketById')->name('v1.ticket.get-support-ticket-by-id');
    Route::post('v1/ticket/get-support-ticket', 'SupportTeamTicketController@getsupportTicket')->name('v1.ticket.get-support-ticket');
    Route::post('v1/ticket/update-ticket-progress', 'SupportTeamTicketController@updateTicket')->name('v1.ticket.update-ticket-progress');

    // Ticket Employee
    Route::get('v1/ticket/employee-task', 'EmployeeTaskController@index')->name('v1.ticket.employee-task');
    Route::post('v1/ticket/get-employee-task', 'EmployeeTaskController@getEmloyeeTask')->name('v1.ticket.get-employee-task');

    Route::get('v1/ticket/get-employe-task-by-id/{id}', 'EmployeeTaskController@getEmployeeTaskById')->name('v1.get-employe-task-by-id');
    Route::post('v1/ticket/update-employe-task-progress', 'EmployeeTaskController@updateEmployeeTask')->name('v1.ticket.update-employe-task-progress');

    // Notice Board  V1
    Route::get('v1/notice/notice-post', [NoticeController::class, 'index'])->name('v1.notice.notice-post');
    Route::get('v1/notice/get-notice', [NoticeController::class, 'getNotice'])->name('v1.notice.get-notice');
    Route::get('v1/notice/get-notice-by-id/{id}', [NoticeController::class, 'getNoticebyId'])->name('v1.notice.get-notice-by-id');
    Route::post('notice/save-notice', [NoticeController::class, 'store'])->name('notice.save-notice');


    // Notice Type
    Route::get('v1/notice/notice-type', [NoticeController::class, 'indexNoticeType'])->name('v1.notice.notice-type');
    Route::get('v1/notice/get-notice-type', [NoticeController::class, 'getNoticeType'])->name('v1.notice.get-notice-type');
    Route::get('v1/notice/get-notice-type-by-id/{id}', [NoticeController::class, 'getNoticeTypebyId'])->name('v1.notice.get-notice-type-by-id');
    Route::post('notice/save-type', [NoticeController::class, 'storeType'])->name('notice.save-type');




    //marketing report
    Route::get('marketing/report', 'ReportController@marketingReport')->name('marketing-reports');
    Route::get('reports/area-report-details/{area?}/{year?}/{month?}/{type?}', 'ReportController@marketingReportDetails')->name('area-wise-patient-details');

    Route::get('marketing/report/summary', 'ReportController@marketingReportSummary')->name('marketing-reports-summary');
    Route::get('reports/area-report-details/{area?}/{year?}/{month?}/{type?}', 'ReportController@marketingReportDetails')->name('area-wise-patient-details');



    // leave entry list
    Route::get('leavelist', 'LeaveEntryListController@index')->name('leavelist.index');
    Route::get('leavelist/dep', 'LeaveEntryListController@indexDep')->name('leavelist.index.dep');
    Route::get('leavelist/hr', 'LeaveEntryListController@indexHr')->name('leavelist.index.hr');
    Route::get('leavelist', 'LeaveEntryListController@index')->name('leavelist.index');

    Route::get('hr/show-balance-leave', 'LeaveEntryListController@showBalanceLeaveHR')->name('hr.show-balance-leave');
    Route::post('hr/search_leave_balance', 'LeaveEntryListController@searchBalanceLeaveHR')->name('hr.search_leave_balance');
    Route::post('hr/search_leave_balance_pdf_download', 'LeaveEntryListController@searchBalancePdfDownload')->name('hr.search_leave_balance_pdf_download');
    Route::get('hr/show-leave-details-for-hr/{id?}', 'LeaveEntryListController@showLeaveDetailsfoHR')->name('hr.show-leave-details-for-hr');
    Route::get('hr/show-availed-leave-details/{id?}', 'LeaveEntryListController@showAvailedDetails')->name('hr.show-availed-leave-details');

    Route::get('show-balance-leave-hod', 'LeaveEntryListController@showBalanceLeaveHOD')->name('show-balance-leave-hod');
    Route::post('search_leave_balance_hod', 'LeaveEntryListController@searchBalanceLeaveHOD')->name('search_leave_balance_hod');
    // Route::get('hr/show-leave-details-for-hr/{id?}', 'LeaveEntryListController@showLeaveDetailsfoHR')->name('hr.show-leave-details-for-hr');

    Route::get('leavelist-create-dep/{id}/{type?}', 'LeaveEntryListController@leavepopUpCreateByDep')->name('leavelist.create.dep');
    Route::get('leavelist-create-hr/{id}/{type?}', 'LeaveEntryListController@leavepopUpCreateByHr')->name('leavelist.create.hr');

    Route::get('leavelist-edit-emp/{id}', 'LeaveEntryListController@leaveEmployeeEdit')->name('leavelist.edit.emp');
    Route::get('leavelist-view-emp/{id}', 'LeaveEntryListController@leaveEmployeeView')->name('leavelist.view.emp');
    Route::post('leavelist-view-emp-print', 'LeaveEntryListController@leave_view_Print')->name('leave.view_print');

    Route::post('leavelist/dep/app', 'LeaveEntryListController@depApprove')->name('leavelist.dep.app');
    Route::post('leavelist/dep/rej', 'LeaveEntryListController@depApprove')->name('leavelist.dep.rej');
    Route::post('leavelist/hr/app', 'LeaveEntryListController@hrpApprove')->name('leavelist.hr.app');
    Route::post('leavelist/hr/rej', 'LeaveEntryListController@hrpApprove')->name('leavelist.hr.rej');
    Route::post('leavelist/hr/cancel', 'LeaveEntryListController@hrCancel')->name('leavelist.hr.cancel');
    Route::post('leavelist/search', 'LeaveEntryListController@searchLeaveList')->name('leavelist.search');
    Route::post('leavelist/search/hr', 'LeaveEntryListController@searchLeaveList_hr')->name('leavelist.search.hr');
    Route::post('leavelist/currentdata', 'LeaveEntryListController@currentLeaveList')->name('current.leavelist');
    Route::post('leavelist/currentdata/dep', 'LeaveEntryListController@currentLeaveListDep')->name('current.leavelist.dep');

    Route::get('hrm/leave_report', 'LeaveEntryListController@leave_Report')->name('hrm.leave_report');
    Route::post('hrm/leave_search_report', 'LeaveEntryListController@leave_ReportSearch')->name('hrm.leave_search');
    Route::post('hrm/leave_print_report', 'LeaveEntryListController@leave_ReportPrint')->name('hrm.leave_print');
    Route::post('hrm/leave_excel_report', 'LeaveEntryListController@leave_Reportexcel')->name('hrm.leave_excel');

    //Stock Adjustment Report
    Route::get('stock-adjustment-report', 'StoreController@stockAdjustmentIndex')->name('stock.adjustment.index');
    Route::post('stock-adjustment-report/get', 'StoreController@stockAdjustmentList')->name('stock.adjustment.getlist');
    Route::post('stock-adjustment-report/pdf', 'StoreController@stockAdjustmentPdf')->name('stock.adjustment.pdf');
    Route::post('stock-adjustment-report/search', 'StoreController@stockAdjustmentsearch')->name('stock.adjustment.search');




    //Pharmacy Item List
    Route::get('pharmacyitem', 'ItemController@pharmacyindex')->name('pharmacyindex');
    Route::post('/pharmacyitem-list', 'ItemController@searchPharmacyitemList')->name('pharmacyitem-list');
    Route::post('pharmacyitem/item_type_search', 'ItemController@pharmacyitemTypeSearch')->name('pharmacyitem.item_type_search');
    Route::post('pharmacyitem/item-list-print', 'ItemController@pharmacyitemListPrint')->name('pharmacyitem.item-list-print');
    Route::get('pharmacyitem/create-quick-item', 'ItemController@create_quick_pharmacyitem_form')->name('pharmacyitem.create-quick-item');
    Route::post('pharmacyitem/item-list-search', 'ItemController@searchpharmacyitem')->name('pharmacyitem.search_item');



    // area
    Route::post('marketing-area/search-list', 'ReportController@marketingAreaReportSearch')->name('marketing-area/search-list');
    Route::post('marketing-area/search-list-report-print', 'ReportController@marketingAreaReportPrint')->name('marketing-area/search-list-report-print');

    Route::post('marketing-area/search-list-summary', 'ReportController@marketingAreaReportSearchSummary')->name('marketing-area/search-list-summary');
    Route::post('marketing-area/search-list-summary-report-print', 'ReportController@marketingAreaSummaryReportPrint')->name('marketing-area.search-list-summaryreport-print');

    // MPO
    Route::post('marketing-mpo/search-list', 'ReportController@marketingMpoReportSearch')->name('marketing-mpo/search-list');
    Route::post('marketing-mpo/search-list-report-print', 'ReportController@marketingMpoReportPrint')->name('marketing-mpo/search-list-report-print');
    // Income Tax Setup
    // Route::resource('income-tax-slab','IncomeTaxController');
    Route::get('income-tax-cale', 'IncomeTaxController@index')->name('income-tax-cale');
    Route::post('tax-cale-list', 'IncomeTaxController@incomeTaxCale')->name('tax-cale-list');
    Route::post('tax-cale-store', 'IncomeTaxController@store')->name('tax-cale-store');




    Route::post('get-type-wise-microbiology-report', 'PathologyController@getTypeWiseMicrobiologyReport')->name('pathology.get-type-wise-microbiology-report');


    // PHR GRN Work List
    Route::get('phr-grn-work-list', 'GRNController@phr_grnView')->name('grn');
    Route::post("phr-grn-work-list/search", "GRNController@phr_search_grn")->name('grn.search_worklist');

    // Inventory GRN Work List
    Route::get('inv-grn-work-list', 'GRNController@inv_grnView')->name('grn.inv');
    Route::post("inventory-grn-work-list/search", "GRNController@inv_search_grn")->name('grn.search_worklist.inv');

    //Route::get('/test123','ReportController@test')->name('test');
    // Jakat Fund Report
    Route::get('jakat-fund-report', 'ReportController@jakatFundReport')->name('jakat.fund-report');
    Route::post('jakat-fund-report-search', 'ReportController@jakatFundReportSearch')->name('jakat.fund-report-search');
    Route::post('jakat-fund-report-print', 'ReportController@jakatFundReportPrint')->name('jakat.fund-report-print');
    Route::post('jakat-fund-report-excel', 'ReportController@jakatFundReportexcel')->name('jakat.fund-report-excel');

    Route::get('schedule-jakat-fund-report', 'ReportController@scheduleJakatFundReport')->name('schedule-jakat.fund-report');
    Route::post('schedule-jakat-fund-report-search', 'ReportController@scheduleJakatFundReportSearch')->name('schedule-jakat.fund-report-search');
    Route::post('schedule-jakat-fund-report-pdf', 'ReportController@scheduleJakatFundReportPdf')->name('schedule-jakat.fund-report-pdf');

    //Doctor Monthly Reports

    Route::get('reports/doctor-wise-income-summary', 'DoctorReportController@doctorWiseIncomeSummery')->name('reports.doctor-wish-income-summery');
    Route::get('reports-doctor-wise-income-summary-details/{person_no_pk}/{date},{type?}', 'DoctorReportController@doctorWiseIncomeSummeryDetails')->name('reports-wise-income-summary-details');
    Route::post('reports/doctor-wish-income-summery-search', 'DoctorReportController@doctorWiseIncomeSummerySearch')->name('reports.doctor-wish-income-summery-search');
    Route::post('reports/doctor-wish-income-summery-pdf/{id}', 'DoctorReportController@doctorWiseIncomeSummeryPdf')->name('reports.doctor-wish-income-summery-pdf');


    Route::get('reports/doctor-share-report', 'DoctorReportController@doctorShareReport')->name('reports.doctor-share-report');
    Route::post('reports/doctor-wise-share-report-search', 'DoctorReportController@doctorWiseShareReportSearch')->name('reports.doctor-wise-share-report-search');



    // Report Route
    Route::get('reports/doctor-income-details-print/{id}/{date}/{from_date}/{type}', 'DoctorReportController@incomeDetailsPrint')->name('reports.income-details-print');

    Route::get('get_item_list_by_req_no', 'StoreController@get_item_list_by_req_no')->name('get_item_list_by_req_no');
    Route::get('get_item_list_from_comparative_by_req_no', 'StoreController@get_item_list_from_comparative_by_req_no')->name('get_item_list_from_comparative_by_req_no');
    Route::get('get_supplier_list_from_comparative_by_req_no', 'StoreController@get_supplier_list_from_comparative_by_req_no')->name('get_supplier_list_from_comparative_by_req_no');
    Route::get('test-sms', 'PatientAppointmentController@test');
    Route::post('pharmacy-receive-by-item-pdf', 'PharmacyController@pharmacyIndentItemReceivePdf')->name('pharmacy-receive-by-item-pdf');
    Route::post('pharmacy-indent-item-pdf', 'PharmacyController@pharmacyIndentItemPdf')->name('pharmacy-indent-item-pdf');
    Route::post('pharmacy-issue-worklist-pdf', 'PharmacyController@pharmacyIssueWoklistPdf')->name('pharmacy-issue-worklist-pdf');


    Route::get('reports/doctor-wise-commission-summary', 'DoctorReportController@doctorWiseCommissionSummery')->name('reports.doctor-wish-commission-summery');
    Route::post('reports/doctor-wish-commission-summery-search', 'DoctorReportController@doctorWiseCommissionSummerySearch')->name('reports.doctor-wish-commission-summery-search');
    Route::post('reports/doctor-wish-commission-summery-pdf/{id}', 'DoctorReportController@doctorWiseCommissionSummeryPdf')->name('reports.doctor-wish-commission-summery-pdf');

    Route::get('reports/doctor-opd-consult-summary', 'DoctorReportController@doctorOpdConsultSummery')->name('reports.doctor-opd-consult-summary');
    Route::post('reports/doctor-opd-consult-summary-search', 'DoctorReportController@doctorOPDSummerySearch')->name('reports.doctor-opd-consult-summary-search');
    Route::post('reports/doctor-opd-consult-summary-pdf/{id}', 'DoctorReportController@doctorOPDSummerySearchPdf')->name('reports.doctor-opd-consult-summary-pdf');

    Route::get('reports/doctor-ipd-consult-summary', 'DoctorReportController@doctorIPDConsultSummery')->name('reports.doctor-ipd-consult-summary');
    Route::post('reports/doctor-ipd-consult-summary-search', 'DoctorReportController@doctorIPDSummerySearch')->name('reports.doctor-ipd-consult-summary-search');
    Route::post('reports/doctor-ipd-consult-summary-pdf/{id}', 'DoctorReportController@doctorIPDSummerySearchPdf')->name('reports.doctor-ipd-consult-summary-pdf');
    Route::resource('income-tax-setup', 'IncomeTaxSetupController');

    Route::get('puch-time-details/{person_no_pk}/{date}', 'ReportController@punchTimeDetails')->name('puch-time-details');

    Route::get('/get_corporate_list', 'CorporateController@getCorporateList')->name('get_corporate_list');


    //Corporate Bill
    Route::get('Corporate-bill', 'CorporateController@corporateBill')->name('corporate-bill');
    Route::post('store-corporate-bill', 'CorporateController@storeCorporateBill')->name('store-corporate-bill');

    //Corporate Bill

    Route::get('accounts-cheque-test', 'CorporateController@chequePrintTest')->name('accounts-cheque-test');
    Route::get('accounts-cheque', 'CorporateController@chequeBill')->name('accounts-cheque');
    Route::post('store-accounts-cheque', 'CorporateController@storeCheque')->name('store-accounts-cheque');
    Route::post('accounts_cheque_report_search', 'CorporateController@accountsChequeReportSearch')->name('accounts_cheque_report_search');
    Route::get('accounts-cheque/{cheque_id?}', 'CorporateController@chequePrint')->name('accounts.cheque-print');
    Route::get('accounts-cheque-hp/{cheque_id?}', 'CorporateController@chequePrintHp')->name('accounts.cheque-print-hp');
    Route::post('cheque-print-all', 'CorporateController@chequePrintAll')->name('cheque-print-all');

    Route::post('accounts_cheque_report_print', 'CorporateController@accountsChequeReportPrint')->name('accounts_cheque_report_print');
    Route::post('accounts_cheque_report_print_excel', 'CorporateController@accountsChequeReportPrintExcel')->name('accounts_cheque_report_print_excel');
    Route::post('cancel-accounts-cheque', 'CorporateController@cancelAccountsCheque')->name('cancel-accounts-cheque');
    Route::get('edit-accounts-cheque/{id}', 'CorporateController@editAccountsCheque')->name('edit-accounts-cheque');




    // Employee Performance Report
    Route::post('employee-performance-report-list', 'FinancialReportController@employeePerformanceReportData')->name('employee-performance-report-list');
    Route::get('employee-performance-report', 'FinancialReportController@employeePerformanceReport')->name('employee-performance-report');
    Route::post('employee-performance-report-pdf', 'FinancialReportController@employeePerformanceReportPdf')->name('employee-performance-report-pdf');
    Route::post('employee-performance-report-pdf-monthly', 'FinancialReportController@employeePerformanceReportPdfMonthly')->name('employee-performance-report-pdf-monthly');


    //Pharmacy Item List
    Route::get('pharmacyitem-stock', 'ItemController@pharmacyStockindex')->name('pharmacy.stock-index');
    Route::post('/pharmacyitem-stock-list', 'ItemController@searchPharmacyStockItemList')->name('pharmacy.stock-item-list');
    // Route::post('pharmacyitem/item_type_search', 'ItemController@pharmacyitemTypeSearch')->name('pharmacyitem.item_type_search');
    Route::post('pharmacyitem/item-list-print-stock', 'ItemController@pharmacyitemListPrintStock')->name('pharmacyitem.item-list-print-stock');
    // Route::get('pharmacyitem/create-quick-item', 'ItemController@create_quick_pharmacyitem_form')->name('pharmacyitem.create-quick-item');
    Route::post('pharmacystock/item-list-search', 'ItemController@searchpharmacyItemStock')->name('pharmacystock.search_item');
    // Route::post('item/item-list-print', 'ItemController@ItemListPrint')->name('item.item-list-print');

    //MPO repor
    Route::get('mpo-wise-refferal-performance', 'MPOWiseReferPFMController@mpoWiseRefPerformance')->name('mpo-wise-refferal-performance');
    Route::post('mpo-wise-refferal-performance-search', 'MPOWiseReferPFMController@referralPaymentSearch')->name('mpo-wise-refferal-performance-search');
    Route::post('mpo-wise-refferal-performance-pdf/{id}', 'MPOWiseReferPFMController@referralPaymentPdf')->name('mpo-wise-refferal-performance-pdf');


    //Inventory Consumption
    Route::get('inventory-consumption', "InventoryConsumptionController@index")->name('inventory-consumption');
    Route::get('inventory-transfer-record', "InventoryConsumptionController@stockTransferRecord")->name('inventory-transfer-record');
    Route::post('search-transfer-record', "InventoryConsumptionController@searchInventoryTransfer")->name('search-transfer-record');
    Route::post('search-inventory-consumption', "InventoryConsumptionController@searchInventoryConsumption")->name('search-inventory-consumption');
    Route::post('inventory-consumption-pdf', "InventoryConsumptionController@searchInventoryConsumptionpdf")->name('inventory-consumption-pdf');
    Route::post('inventory-transfer-record-pdf', "InventoryConsumptionController@inventoryTransferpdf")->name('inventory-transfer-record-pdf');



    //    IPD Patient List
    Route::post('v1/ipd-patient-list-search', 'IPDController@ipdPatientListSearch')->name('v1.ipd-patient-list-search');
    Route::post('v1/ipd-patient-list-dis-rec-search', 'IPDController@ipdPatientDisRecListSearch')->name('v1.ipd-patient-dis-rec-list-search');
    Route::post('v1/ipd-patient-list-dis-search', 'IPDController@ipdPatientDisListSearch')->name('v1.ipd-patient-dis-list-search');


    // Refferal V1

    Route::get('v1/refferal-payment', 'RefferalReportController@refferalPaymentV1')->name('v1.refferal-payment');
    Route::post('v1/search-refferal-payment', 'RefferalReportController@searchReferralPaymentV1')->name('v1.search-refferal-payment');
    //Refferal IPD
    Route::get('v1/ipd-refferal-payment', 'RefferalReportController@refferalIPDPaymentV1')->name('v1.ipd-refferal-payment');
    Route::post('v1/ipd-search-refferal-payment', 'RefferalReportController@searchIPDReferralPaymentV1')->name('v1.ipd-search-refferal-payment');

    Route::post('v1/referral-payment-ind-update', 'RefferalReportController@referralPaymentIndUpdate')->name('v1.referral-payment-ind-update');

    Route::get('v1/refferal-payment-report', 'RefferalReportController@refferalPaymentReportV1')->name('v1.refferal-payment-report');
    Route::get('v1/refferral_payment_pdf/{id}/{print_id?}', 'RefferalReportController@printReferralPayment')->name('v1.refferral_payment_pdf');


    Route::post('v1/referral-payment-report-search', 'RefferalReportController@referralPaymentSearch')->name('v1.referral-payment-report-search');
    Route::post('v1/referral-payment-search-pdf/{id}', 'RefferalReportController@referralPaymentPdf')->name('v1.referral-payment-search-pdf');
    Route::post('v1/adjusted-amount-admission', 'RefferalReportController@adjustingAmountAdmission')->name('v1.adjusted-amount-admission');
    Route::get('v1/refferral_payment_pdf-admission/{id}/{print_id?}', 'RefferalReportController@printReferralPaymentAdm')->name('v1.refferral_payment_pdf_adm');

    Route::get('v1/refferal-payment-edit/{invoice_id?}/{type?}', 'RefferalReportController@refferalPaymentEdit')->name('v1.refferal-payment-edit');

    Route::post('v1/refferal-payment-update', 'RefferalReportController@refferalPaymentUpdate')->name('v1.refferal-payment-update');

    Route::get('v1/external-referral-performance-report', 'RefferalReportController@externalReferralPerformanceReport')->name('v1.external-referral-performance-report');
    Route::post('v1/search-external-referral-performance', 'RefferalReportController@searchExternalReferralPerformance')->name('v1.search-external-referral-performance');
    Route::post('v1/external-referral-performance-report-print', 'RefferalReportController@externalReferralPerformanceReportPrint')->name('v1.external-referral-performance-report-print');


    Route::get('pharmacy/stock_adjustment_worklist', 'StoreController@stock_adjustment_worklist')->name('pharmacy.stock_adjustment_worklist');

    Route::post('pharmacy/search_stock_adjustment_worklist', "StoreController@search_stock_adjustment_worklist")->name('pharmacy.search_stock_adjustment_worklist');






    //item previlize List
    Route::get('item/user-item-setup-list', 'ItemController@getAllUserItemSetup')->name('item.user-item-setup-list');
    Route::get('item/user-item-setup-popup/', 'ItemController@userItemSetupPopup')->name('item.user-item-setup-popup');
    Route::post('item/store-item', 'ItemController@storeItemPrevilize')->name('item.store-item');



    //Month Wise

    Route::get('dept-wise-summary-performance-report', 'ReportController@deptWiseSummaryReport')->name('dept-wise-summary-performance-report');
    Route::post('dept-wise-summary-performance-report-search', 'ReportController@deptWiseSummaryDetailsSearch')->name('dept-wise-summary-performance-report-search');
    Route::post('dept-wise-summary-performance-report-report-excle', 'ReportController@deptWiseSummaryDetailsExcel')->name('dept-wise-summary-performance-report-excel');
    Route::post('dept-wise-summary-performance-report-report-pdf', 'ReportController@deptWiseSummaryDetailsPdf')->name('dept-wise-summary-performance-report-pdf');

    // hospital financial service
    Route::post('v1/hospital-financial-report-print-search', 'FinancialReportController@hospitalFinancialReportSearch')->name('v1.hospital-financial-report-print-search');
    Route::post('v1/hospital2-financial-report-print-search', 'FinancialReportController@hospital2FinancialReportSearch')->name('v1.hospital2-financial-report-print-search');
    Route::post('v1/hospital-financial-report-print-excel', 'FinancialReportController@hospitalFinancialReportExcel')->name('v1.hospital-financial-report-print-excel');
    Route::post('v1/hospital-financial-report-print-pdf', 'FinancialReportController@dhospitalFinancialReportPdf')->name('v1.hospital-financial-report-print-pdf');

    // //Month Wise

    Route::get('pathology-summary-report', 'ReportController@pathologySummaryReport')->name('pathology-summary-report');
    Route::post('pathology-summary-report-search', 'ReportController@pathologySummaryDetailsSearch')->name('pathology-summary-report-search');
    Route::post('pathology-summary-report-report-pdf', 'ReportController@pathologySummaryDetailsPdf')->name('pathology-summary-report-pdf');


    Route::get('pathology-summary-report-admission', 'ReportController@pathologySummaryReportAdmission')->name('pathology-summary-report-admission');
    Route::post('pathology-summary-report-search-admission', 'ReportController@pathologySummaryDetailsSearchAdmission')->name('pathology-summary-report-search-admission');
    Route::post('pathology-summary-report-report-pdf-admission', 'ReportController@pathologySummaryDetailsPdfAdmission')->name('pathology-summary-report-pdf-admission');


    //Doctor Income Report
    Route::get('income-report', 'ReportController@incomeReport')->name('income-report');
    Route::post('income-report-search', 'ReportController@incomeDetailsSearch')->name('income-report-search');
    Route::post('income-report-pdf', 'ReportController@incomeDetailsPdf')->name('income-report-pdf');

    //Doctor Income Report
    Route::get('corporate-report', 'ReportController@corporateReport')->name('corporate-report');
    Route::post('corporate-report-search', 'ReportController@corporateDetailsSearch')->name('corporate-report-search');
    Route::post('corporate-report-pdf', 'ReportController@corporateDetailsPdf')->name('corporate-report-pdf');



    //Department wise Item Report

    Route::get("department-wise-item-report-ipd/{type?}", 'ReportController@deptWiseIpd')->name('dept.item-report-ipd');
    Route::get("department-wise-item-report-opd/{type?}", 'ReportController@deptWiseOpd')->name('dept.item-report-opd');
    Route::post('department-wise-item-report-search-data', 'ReportController@deptWiseSearch')->name('dept.item-report-search');
    Route::post('department-wise-item-report-pdf', 'ReportController@deptWiseReportPdf')->name('dept.item-report-pdf');

    //Department wise IPD Report

    Route::get("department-wise-ipd-report", 'ReportController@deptWiseIpdReport')->name('department-wise-ipd-report');
    Route::post('department-wise-ipd-report-search-data', 'ReportController@deptWiseIpdReportSearch')->name('department-wise-ipd-report-search');
    Route::post('department-wise-ipd-report-pdf', 'ReportController@deptWiseIpdReportPdf')->name('department-wise-ipd-report-pdf');

    // For Promotion history
    Route::get('/promotion-history/{id?}', 'PromotionController@promotionHistory')->name('promotion-history');

    // For Increment history
    // Route::get('increment-history/{id?}', 'HRMIncreamentPolicyController@incrementHistory')->name('increment-history');
    Route::get('increment-history/{id?}', 'PromotionController@incrementHistory')->name('increment-history');


    //Department wise IPD Report

    Route::get("interdepartmental-report", 'ReportController@interpartmentalReport')->name('interdepartmental-report');
    Route::post('interdepartmental-report-search-data', 'ReportController@interpartmentalReportSearch')->name('interdepartmental-report-search');
    Route::post('interdepartmental-report-pdf', 'ReportController@interpartmentalReportPdf')->name('interdepartmental-report-pdf');
    //item type Report

    Route::get("item-type-report", 'ReportController@itemTypeReport')->name('item-type-report');
    Route::get("item-type-report-details/{to_date?}/{from_date?}/{doctor_id?}/{item_type?}/{department?}", 'ReportController@itemTypeReportDetails')->name('item-type-report-details');
    Route::post('item-type-report-search-data', 'ReportController@itemTypeReportSearch')->name('item-type-report-search');
    Route::post('item-type-report-pdf', 'ReportController@itemTypeReportPdf')->name('item-type-report-pdf');

    // billing cancellation report
    Route::get('/reports/billing-refund-report', 'ReportController@billingRefundReport')->name('reports.billing-refund-report');
    // Route::get('ipd-patient-due-report', [ReportController::class, 'ipdPatientDueReport'])->name('ipd.patient-due-report');
    Route::post('/reports/billing-refund-due-report-search', 'ReportController@billingRefundDueReportSearch')->name('reports.billing-refund-due-report-search');
    Route::post('/reports/billing-refund-due-report-pdf', 'ReportController@billingRefundDueReportPdf')->name('reports.billing-refund-due-report-pdf');


    //item type Report

    Route::get("housekeeping-report", 'HousekeepingController@housekeepingReport')->name('housekeeping-report');
    Route::post('housekeeping-report-search', 'HousekeepingController@housekeepingReportSearch')->name('housekeeping-report-search');
    Route::post('housekeeping-report-pdf', 'HousekeepingController@housekeepingReportPdf')->name('housekeeping-report-pdf-v1');
    Route::get('housekeeping-report-print/{id?}', 'HousekeepingController@housekeepingReportPdfId')->name('housekeeping-report-pdf-v1-id');

    Route::get('ipd/doctor-wise-performance-summary-report', 'PcrmController@ipdDoctorPerformanceSummaryReport')->name('ipd.doctor-wise-performance-summary-report');
    Route::post('ipd/doctor-wise-performance-summary-report-search', 'PcrmController@ipdDoctorPerformanceSummaryReportSearch')->name('ipd.doctor-wise-performance-summary-report-search');
    Route::post('ipd/doctor-wise-performance-summary-report-pdf', 'PcrmController@ipdDoctorPerformanceSummaryReportPdf')->name('ipd.doctor-wise-performance-summary-report-pdf');

    Route::get('get-last-month-data', 'FixedAssetsController@getLastMonthData')->name('get-last-month-data');
    Route::post('get-last-month-depreciation-cancel', 'FixedAssetsController@getLastMonthDataCancel')->name('get-last-month-depreciation-cancel');

    Route::post('/uniform-request-store', [UniformController::class, 'uniformRequestStore'])->name('uniform-request-store');

    Route::post('/update-issue', [UniformController::class, 'updateIssue'])->name('update.issue');


    //Conveyance Bill
    Route::get('urgent-trasport', [ConveyanceBillController::class, 'urgentTransport'])->name('urgent-trasport');
    Route::get('conveyance-bill', [ConveyanceBillController::class, 'conveyanceBill'])->name('conveyance-bill');
    Route::post('conveyance-bill-save', [ConveyanceBillController::class, 'conveyanceBillSave'])->name('conveyance-bill-save');
    Route::get('conveyance-bill-worklist', [ConveyanceBillController::class, 'conveyanceBillWorklist'])->name('conveyance-bill-worklist');
    Route::post('search-conveyance-worklist', [ConveyanceBillController::class, 'conveyanceBillSearch'])->name('search-conveyance-worklist');
    Route::post('conveyancebill-worklist-print', [ConveyanceBillController::class, 'conveyanceBillPdf'])->name('conveyancebill-worklist-print');
    Route::post('conveyancebill-worklist-excel', [ConveyanceBillController::class, 'conveyanceBillExcel'])->name('conveyancebill-worklist-excel');
    Route::get('conveyancebill-update/{bill_id?}', [ConveyanceBillController::class, 'conveyanceBillUpdate'])->name('conveyancebill-update');
    Route::get('conveyance-bill-payment{id?}', [ConveyanceBillController::class, 'conveyanceBillPayment'])->name('conveyance-bill-payment');
    Route::post('conveyance-bill-payment-update', [ConveyanceBillController::class, 'conveyanceBillPaymentUpdate'])->name('conveyance-bill-payment-update');
    Route::get('view-conveyance-bill/{bill_id?}', [ConveyanceBillController::class, 'conveyanceBillView'])->name('view_conveyance_bill');
    Route::get('view_conveyance_bill_finance/{bill_id}/{from}/{to}/{isPaid}', [ConveyanceBillController::class, 'conveyanceBillViewFinance'])->name('view_conveyance_bill_finance');
    Route::get('conveyancebill-report/{bill_id}', [ConveyanceBillController::class, 'conveyanceBillReport'])->name('conveyancebill-report');
    Route::post('conveyancebill-finance-worklist-print', [ConveyanceBillController::class, 'conveyanceBillFinancePdf'])->name('conveyancebill-finance-worklist-print');
    Route::post('conveyancebill-finance-worklist-excel', [ConveyanceBillController::class, 'conveyanceBillFinanceExcel'])->name('conveyancebill-finance-worklist-excel');
    Route::post('conveyancebill-finance-details-report', [ConveyanceBillController::class, 'conveyanceBillFinanceDetailsReport'])->name('conveyancebill-finance-details-report');
    Route::get('approval-level-tracking-conveyance/{id?}', [ConveyanceBillController::class, 'ApprovalTrackingforConveyance'])->name('approval-level-tracking-conveyance');


    //Department wise IPD Report
    Route::get("doctor-refered-wise-report", 'ReportController@referedReport')->name('doctor-refered-wise-report');
    Route::post('doctor-refered-wise-report-search-data', 'ReportController@referedReportSearch')->name('doctor-refered-wise-report-search');
    Route::post('doctor-refered-wise-report-pdf', 'ReportController@referedReportPdf')->name('doctor-refered-wise-report-pdf');

    //Conveyance Bill Approval
    Route::get('conveyancebill-approval-worklist', [ConveyanceBillController::class, 'conveyanceBillApprovalWorklist'])->name('conveyancebill-approval-worklist');
    Route::post('search-conveyance-approval-worklist', [ConveyanceBillController::class, 'conveyanceBillApprovalSearch'])->name('search-conveyance-approval-worklist');

    //Conveyance Bill for Finance
    Route::get('conveyancebill-worklist-finance', [ConveyanceBillController::class, 'conveyanceBillApprovalWorklist'])->name('conveyancebill-worklist-finance');
    Route::post('search-conveyancebill-worklist-finance', [ConveyanceBillController::class, 'conveyanceBillApprovalSearch'])->name('search-conveyancebill-worklist-finance');


    Route::get('report/cashier-wise-summary-report', 'ReportController@cashierWiseSummaryReport')->name('report.cashier-wise-summary-report');
    Route::post('report/cashier-wise-report-summary-search', 'ReportController@cashierWiseReportSummarySearch')->name('report.cashier-wise-report-summary-search');
    Route::post('report/cashier-wise-report-summaryPdf', 'ReportController@cashierWiseReportPrintSummary')->name('report.cashier-wise-report-summaryPdf');

    Route::get('pharmacy/v1/pharmacy-stock-report', [StockReportController::class, 'pharmacyStockReportV1'])->name('pharmacy.v1.pharmacy-stock-report');
    Route::post('pharmacy/v1/pharmacy-stock-report-search-v1', [StockReportController::class, 'pharmacyStockReportSearchV1'])->name('pharmacy.v1.pharmacy-stock-report-search-v1');
    Route::post('pharmacy/v1/pharmacy-stock-report-print-v1', [StockReportController::class, 'pharmacyStockReportPrintV1'])->name('pharmacy.v1.pharmacy-stock-report-print-v1');
    Route::post('pharmacy.v1.pharmacy-stock-report-excel-v1', [StockReportController::class, 'pharmacyStockReportexcelV1'])->name('pharmacy.v1.pharmacy-stock-report-excel-v1');


    // referral income summary report
    Route::get('pcrm/referral-wise-income-summary', 'ReportController@referralWiseIncomeSummery')->name('pcrm.referral-wish-income-summery');
    Route::get('pcrm-referral-wise-income-summary-details/{person_no_pk}/{to_date?}/{from_date?}/{type?}', 'ReportController@referralWiseIncomeSummeryDetails')->name('referral-wise-income-summary-details');
    Route::post('pcrm/referral-wish-income-summery-search', 'ReportController@referralWiseIncomeSummerySearch')->name('pcrm.referral-wish-income-summery-search');
    Route::post('pcrm/referral-wish-income-summery-pdf/{id}', 'ReportController@referralWiseIncomeSummeryPdf')->name('pcrm.referral-wish-income-summery-pdf');


    // income report for gazi medical
    Route::get('income-summary-report-dummy', 'ReportController@incomeSummaryReportDummy')->name('income-summary-report-dummy');
    Route::post('income-summary-report-dummy-process', 'ReportController@incomeSummaryReportDummyProcess')->name('income-summary-report-dummy-process');
    Route::post('income-summary-report-dummy-search', 'ReportController@incomeSummaryReportDummySearch')->name('income-summary-report-dummy-search');
    Route::post('income-summary-report-dummy-pdf/{id}', 'ReportController@incomeSummaryReportDummyPdf')->name('income-summary-report-dummy-pdf');

    // Employee Salary set up
    Route::get('payroll/employee-salary', 'EmployeeController@employeeSalary')->name('payroll.employee-salary');
    Route::post('payroll/search-employee-salary', 'EmployeeController@SearchEmployeeSalary')->name('payroll.search-employee-salary');
    Route::post('payroll/store-employee-salary', 'EmployeeController@storeEmployeeSalary')->name('payroll.store-employee-salary');
    Route::get('payroll/create-employee-salary/{id?}', 'EmployeeController@createEmployeeSalary')->name('payroll.create-employee-salary');
    Route::post('payroll/update-employee-salary', 'EmployeeController@updateEmployeeSalary')->name('payroll.update-employee-salary');

    Route::get('payroll/grade-factor', 'EmployeeController@gradeFactor')->name('payroll.grade-factor');
    //Tax deduction
    Route::get('payroll/employee-tax-deduction', 'EmployeeController@employeeTaxDeduction')->name('payroll.employee-tax-deduction');
    Route::post('payroll/search-employee-tax-deduction', 'EmployeeController@searchEmployeeTaxDeduction')->name('payroll.search-employee-tax-deduction');
    Route::post('payroll/tax-deduction-update', 'EmployeeController@taxDeductionUpdate')->name('payroll.tax-deduction-update');

    // User Munual
    Route::get('create-user-manual', [UserManualController::class, 'CreateUserManual'])->name('create-user-manual');
    Route::post('user-manual-store', [UserManualController::class, 'StoreUserManual'])->name('user-manual-store');
    Route::get('view-user-manual-description/{id?}', [UserManualController::class, 'ViewUserManualDescription'])->name('view-user-manual-description');
    Route::post('user_manual_edit', [UserManualController::class, 'EditUserManual'])->name('user_manual_edit');
    Route::post('remove-user-manual', [UserManualController::class, 'RemoveUserManual'])->name('remove-user-manual');

    //for imperial
    Route::get('due_invoice_list', [DueReportController::class, 'DueInvoiceList'])->name('due_invoice_list');
    Route::post('search_due_invoice_list', [DueReportController::class, 'SearchDueInvoiceList'])->name('search_due_invoice_list');
    Route::post('due_invoice_report_pdf_excel', [DueReportController::class, 'DueInvoiceReportPdfExcel'])->name('due_invoice_report_pdf_excel');

    Route::get('due_patient_list', [DueReportController::class, 'DuePatientList'])->name('due_patient_list');
    Route::post('search_due_patient_list', [DueReportController::class, 'SearchDuePatientList'])->name('search_due_patient_list');
    Route::post('due_discharge_patient_report_pdf_excel', [DueReportController::class, 'DuePatientReportPdfExcel'])->name('due_discharge_patient_report_pdf_excel');

    # Supplier Profile
    Route::get('supplier-profile', [SupplierController::class, 'profile'])->name('supplierProfile');
    Route::post('supplier-profile', [SupplierController::class, 'profileFilter'])->name('supplierProfileFilter');

    # Leave Deduction
    Route::get('leave-deduction', [LeaveController::class, 'leaveDeduction'])->name('leaveDeduction');
    Route::get('leave-deduction/get-data', [LeaveController::class, 'getLeaveDeductionData'])->name('leaveDeduction.getData');
    Route::post('leave-deduction-filter', [LeaveController::class, 'leaveDeductionFilter'])->name('leaveDeductionFilter');
    Route::get('leave-deduction-details/{id}', [LeaveController::class, 'leaveDeductionDetails'])->name('leaveDeductionDetails');

    Route::get('leave-deduction/late-deduction/{person_no_fk}/{monthYear}/{to_be_deducted}/{full_name}', [LeaveController::class, 'lateDeduction'])->name('leaveDeduction.lateDeduction');
    Route::post('leave-deduction/late-deduction/store', [LeaveController::class, 'lateDeductionStore'])->name('leaveDeduction.lateDeductionStore');

    # Prescibe & Sales Medicine
    Route::get('report/prescribe-sales-medicine', [ReportController::class, 'prescribeSalesMedicineReport'])->name('prescribeSalesMedicineReport');
    Route::post('report/prescribe-sales-medicine', [ReportController::class, 'prescribeSalesMedicineReportFilter'])->name('prescribeSalesMedicineReportFilter');
    Route::post('report/prescribe-sales-medicine/export', [ReportController::class, 'prescribeSalesMedicineReportExport'])->name('prescribeSalesMedicineReportExport');

    # PABX Appointment
    Route::get('pabx-appointment/', [PabxAppointmentController::class, 'index'])->name('pabxAppointment.index');
    Route::get('pabx-appointment/create', [PabxAppointmentController::class, 'create'])->name('pabxAppointment.create');
    Route::post('pabx-appointment/store', [PabxAppointmentController::class, 'store'])->name('pabxAppointment.store');
    Route::post('pabx-appointment/filter', [PabxAppointmentController::class, 'filter'])->name('pabxAppointment.filter');

    # Date Wise Report
    Route::get('report/date-wise-collection/', [ReportController::class, 'dateWiseCollectionReport'])->name('report.dateWiseCollectionReport');

    # BIN Card
    Route::get('bin-card', [BinCardController::class, 'index'])->name('binCard.index');
    Route::post('bin-card/filter', [BinCardController::class, 'filter'])->name('binCard.filter');
    Route::post('bin-card/report', [BinCardController::class, 'report'])->name('binCard.report');

    # Hospital Collection Report
    Route::get('reports/hospital-collection', [ReportController::class, 'hospitalCollection'])->name('reports.hospitalCollection');
    Route::post('reports/hospital-collection/filter', [ReportController::class, 'hospitalCollectionFilter'])->name('reports.hospitalCollectionFilter');
    Route::post('reports/hospital-collection/pdf', [ReportController::class, 'hospitalCollectionPdf'])->name('reports.hospitalCollectionPdf');

    Route::get('report/test-mail', [ReportController::class, 'testMail'])->name('reports.testMail');

    Route::get('reports/item-wise-stock', [ReportController::class, 'itemWiseStock'])->name('reports.itemWiseStock');
    Route::get('reports/item-wise-stock/details/{id}', [ReportController::class, 'itemWiseStockDetails'])->name('reports.itemWiseStockDetails');
    Route::post('reports/item-wise-stock/details/download', [ReportController::class, 'itemWiseStockDetailsDownload'])->name('reports.itemWiseStockDetailsDownload');
    Route::post('reports/item-wise-stock/filter', [ReportController::class, 'itemWiseStockFilter'])->name('reports.itemWiseStockFilter');
    Route::post('reports/item-wise-stock/download', [ReportController::class, 'itemWiseStockDownload'])->name('reports.itemWiseStockDownload');

    # ASSET WORKLIST
    Route::get('reports/asset-worklist', [ReportController::class, 'assetWorklist'])->name('reports.assetWorklist');
    Route::post('reports/asset-worklist/filter', [ReportController::class, 'assetWorklistFilter'])->name('reports.assetWorklistFilter');
    Route::post('reports/asset-worklist/download', [ReportController::class, 'assetWorklistDownload'])->name('reports.assetWorklistDownload');

    /**
     * START::Inventory Requisition Report
     */
    // Route::post('item-wise-financial-report-list/v1', [FinancialReportControllerV1::class, 'financialReportData'])->name('item-wise-financial-report-list-v1');
    Route::get('reports/inventory-requisition', [FinancialReportControllerV1::class, 'inventoryRequisitionReport'])->name('reports.inventoryRequisition');
    // Route::post('item-wise-financial-pdf/v1', [FinancialReportControllerV1::class, 'itemWiseFincReportPdf'])->name('item-wise-financial-pdf-v1');
    // Route::get('item-wise-financial-item-dtl/{form_date?}/{to_date?}/{item_no?}/v1', [FinancialReportControllerV1::class, 'itemWiseFincReportDtl'])->name('item-wise-financial-item-dtl-v1');
    // Route::get('item-wise-financial-item-dtl-pdf/{form_date?}/{to_date?}/{item_no?}/v1', [FinancialReportControllerV1::class, 'itemWiseFincReportDtlPdf'])->name('item-wise-financial-item-dtl-pdf-v1');
    /**
     * END::Inventory Requisition Report
     */

    Route::get('finc_opdcollection', [ReportController::class, 'fincOPDCollection'])->name('finc_opdcollection');
    Route::post('search-opd-financial-report-worklist', [ReportController::class, 'fincOPDCollectionSearch'])->name('search-opd-financial-report-worklist');
    Route::post('search-opd-fin-report-pdf-download', [ReportController::class, 'fincOPDCollectionReportPDF'])->name('search-opd-fin-report-pdf-download');

    //OPD sells report
    Route::get('opd-sells-report', [ReportController::class, 'OPDSellsReport'])->name('opd-sells-report');
    Route::post('search-opd-sells-report-worklist', [ReportController::class, 'OPDSellsSearch'])->name('search-opd-sells-report-worklist');
    Route::post('search-opd-sells-report-pdf-download', [ReportController::class, 'OPDSellsReportPDF'])->name('search-opd-sells-report-pdf-download');


    //MIS Reports
    Route::get('reports/mis-report-entry', 'MISReportController@reportEntry')->name('reports.mis-report-entry');
    Route::post('reports/mis-report-generate', 'MISReportController@store')->name('reports.mis-report-generate');
    Route::post('reports/mis-report-update', 'MISReportController@updateReport')->name('reports.mis-report-update');
    Route::get('reports/get-mis-report', 'MISReportController@getMISReport')->name('reports.get-mis-report');
    Route::get('reports/edit-mis-report/{id}', 'MISReportController@reportEntryEdit')->name('reports.edit-mis-report');
    Route::get('report/mis-report-details/{id}', 'MISReportController@reportDetatils')->name('report.mis-report-details');

    // Reports Generate
    Route::get('reports/report-generate', 'MISReportController@reportGenerate')->name('reports.report-generate');
    Route::post('reports/report-generate-download', 'MISReportController@reportGenerateDownload')->name('reports.generate-mis-report');
    Route::get('reports/generate-mis-report/{id?}', 'MISReportController@reportGenerateRequest')->name('reports.generate-mis-report-request');
    Route::get('reports/get-report-list/{id?}', 'MISReportController@getReportList')->name('reports.get-report-list');
    Route::post('reports/report-generate-excel', 'MISReportController@reportGenerateExcel')->name('reports.report-generate-excel');

    //daliy attendance all punch
    Route::get('hrm/daily-attendance-all-punch', 'ReportController@dailyAttendanceAllPunch')->name('hrm.daily-attendance-all-punch');
    Route::post('hrm/search-daily-attendance-all-punch', 'ReportController@searchDailyAttendanceAllPunch')->name('hrm.search-daily-attendance-all-punch');
    Route::post('hrm/print-daily-attendance-all-punch', 'ReportController@printDailyAttendanceAllPunch')->name('hrm.print-daily-attendance-all-punch');
    //leave carry forward
    Route::get('hrm/leave-carry-forward', 'LeaveEntryListController@leaveCarryForward')->name('hrm.leave-carry-forward');
    Route::post('hrm/search-leave-carry-forward', 'LeaveEntryListController@searchLeaveCarryForward')->name('hrm.search-leave-carry-forward');
    Route::post('hrm/save-leave-carry-forward', 'LeaveEntryListController@saveLeaveCarryForward')->name('hrm.save-leave-carry-forward');
    Route::post('hrm/leave-carry-forward-pdf', 'LeaveEntryListController@leaveCarryForwardPdf')->name('hrm.leave-carry-forward-pdf');

    // employee bonus
    Route::get('hrm/employee-bonus', 'ReportController@employeeBonus')->name('hrm.employee-bonus');
    Route::post('hrm/search-employee-bonus', 'ReportController@searchEmployeeBonus')->name('hrm.search-employee-bonus');
    Route::post('hrm/download-employee-bonus', 'ReportController@downloadEmployeeBonus')->name('hrm.download-employee-bonus');
    Route::post('hrm/save-employee-bonus', 'ReportController@saveEmployeeBonus')->name('hrm.save-employee-bonus');

    Route::get('inventory/subStore-stock-all', 'StoreController@subStore_stock_all')->name('inventory.subStore-stock-all');
    Route::post('inventory/search-subStore-stock-all', 'StoreController@search_subStore_stock_all')->name('inventory.search-subStore-stock-all');

    //pending leave application
    Route::get('hrm/pending-leave-application', [LeaveController::class, 'pendingLeaveApplication'])->name('hrm.pending-leave-application');
    Route::post('hrm/search-pending-leave-application', [LeaveController::class, 'searchPendingLeaveApplication'])->name('hrm.search-pending-leave-application');
    Route::get('hrm/leave-detail/{id?}', [LeaveController::class, 'leaveDetail'])->name('hrm.leave-detail');

});

// Test Count

  Route::get('item-wise-summary-report', 'ReportController@itemWiseSummaryReport')->name('item-wise-summary-report');
  Route::post('dept-wise-item-list-report', 'ReportController@deptWiseItemListReport')->name('dept-wise-item-list-report');
  Route::post('item-wise-summary-report-search', 'ReportController@itemWiseSummaryReportSearch')->name('item-wise-summary-search');
  Route::post('item-wise-summary-report-report-excle', 'ReportController@itemWiseSummaryReportExcel')->name('item-wise-summary-excel');
  Route::post('item-wise-summary-report-report-pdf', 'ReportController@itemWiseSummaryReportPdf')->name('item-wise-summary-pdf');

// TV Screen Module
Route::get('tv-screen/tv-setup', 'TVScreenSetupController@index')->name('tv-screen.tv-setup');
Route::get('tv-screen/get-tv-info', 'TVScreenSetupController@getTVInfo')->name('tv-screen.get-tv-info');
Route::post('tv-screen/save-tv-entry', 'TVScreenSetupController@saveTVSetup')->name('tv-screen.save-tv-entry');
Route::get('tv_screen/edit_tv_setup/{id}', 'TVScreenSetupController@editTVSetup')->name('tv_screen.edit_tv_setup');
Route::post('tv-screen/update-tv-info', 'TVScreenSetupController@updateTVSetup')->name('tv-screen.update-tv-info');
// TV Wise Doctor Entry
Route::get('tv-screen/tv-wise-doctor-setup', 'TVScreenSetupController@doctorSetup')->name('tv-screen.tv-wise-doctor-setup');
Route::get('tv-screen/get-tv-wise-doctor-info', 'TVScreenSetupController@getTVWiseDoctorInfo')->name('tv-screen.get-tv-wise-doctor-info');
Route::post('tv-screen/save-tv-wise-doctor-entry', 'TVScreenSetupController@saveTVWiseDoctor')->name('tv-screen.save-tv-wise-doctor-entry');
Route::get('tv_screen/edit_tv_wise_doctor_setup/{id}', 'TVScreenSetupController@editTVWiseSetup')->name('tv_screen.edit_tv_wise_doctor_setup');
Route::post('tv-screen/update-tv-wise-doctor-info', 'TVScreenSetupController@updateTVWiseSetup')->name('tv-screen.update-tv-wise-doctor-info');

// TV Wise Counter Entry
Route::get('tv-screen/tv-wise-counter-setup', 'TVWiseCounterController@counterSetup')->name('tv-screen.tv-wise-counter-setup');
Route::get('tv-screen/get-tv-wise-counter-info', 'TVWiseCounterController@getTVWiseCounterInfo')->name('tv-screen.get-tv-wise-counter-info');
Route::post('tv-screen/save-tv-wise-counter-entry', 'TVWiseCounterController@saveTVWiseCounter')->name('tv-screen.save-tv-wise-counter-entry');
Route::get('tv_screen/edit_tv_wise_counter_setup/{id}', 'TVWiseCounterController@editTVWiseCounterSetup')->name('tv_screen.edit_tv_wise_counter_setup');
Route::post('tv-screen/update-tv-wise-counter-info', 'TVWiseCounterController@updateTVWiseCounterSetup')->name('tv-screen.update-tv-wise-counter-info');
Route::get('v1/accounts/auto-integrated-gl', 'AccountsReportController@auto_integrate_gl')->name('v1.accounts.auto-integrated-gl');
Route::post('v1/accounts/auto-integrated-general-ledger', 'AccountsReportController@auto_integated_general_ledger_v1')->name('v1.accounts.auto-integrated-general-ledger');
Route::get('v1/accounts/get-auto-journal-report', 'AccountsReportController@get_auto_journal_report')->name('v1.accounts.get-auto-journal-report');
// Route::post('v1/accounts/general-ledger', 'AccountsReportController@general_ledger_v1')->name('v1.accounts.general-ledger');

// TV
Route::get('tv/{id?}', 'TVController@index')->name('tv-screen.tv-show');
Route::get('default-tv-data/{id?}', 'TVController@defaultTVShow')->name('tv-screen.default-tv-data');
// Pharmacy TV
Route::get('pharmacy-tv/{id?}', 'PharmacyTVController@index')->name('tv-screen.pharmacy-tv-show');
Route::get('pharmacy-default-tv-data/{id?}', 'PharmacyTVController@defaultTVShow')->name('tv-screen.pharmacy-default-tv-data');





Route::get('employee-phonebook', [EmployeePhoneBookController::class, 'employeePhoneBook'])->name('employee-phonebook');
Route::post('search-employee-phonebook', [EmployeePhoneBookController::class, 'searchEmployeePhoneBook'])->name('search-employee-phonebook');
Route::post('search-employee-phonebook-pdf', [EmployeePhoneBookController::class, 'searchEmployeePhoneBookPDF'])->name('search-employee-phonebook-pdf');


Route::get('/radiology-user-wise-room', 'RadiologyController@radiologyUserWiseRoom')->name('radiology-user-wise-room');
Route::get('/radiology-user-wise-room-schedule', 'RadiologyController@radiologyUserWiseRoomSchedule')->name('radiology-user-wise-room-schedule');
Route::get('/radiology-user-wise-room-schedule-edit/{id}', 'RadiologyController@radiologyUserWiseRoomScheduleEdit')->name('radiology-user-wise-room-schedule-edit');
Route::get('/radiology-user-wise-room-schedule-form', 'RadiologyController@radiologyUserWiseRoomScheduleForm')->name('radiology-user-wise-room-schedule-form');
Route::post('/radiology-user-wise-room-schedule-list', 'RadiologyController@radiologyUserWiseRoomScheduleList')->name('radiology-user-wise-room-schedule-list');
Route::post('/radiology-user-wise-room-list', 'RadiologyController@storeRadiologyUserWiseRoomList')->name('radiology-user-wise-room.storeRadiologyUserWiseRoom');

//  Route::get('/radiology-user-wise-room/{edit_id}', 'RadiologyController@edit')->name('radiology-user-wise-room.edit');
//  Route::put('/radiology-user-wise-room/{update_id}', 'RadiologyController@update')->name('radiology-user-wise-room.update');
Route::get('radiology-editor-autocomplete', 'RadiologyController@radiologyEditorAutocomplete')->name('radiology-editor-autocomplete');
Route::get('radiology-editor-autocomplete-form', 'RadiologyController@radiologyEditorAutocompleteForm')->name('radiology-editor-autocomplete-form');
Route::post('radiology.store-radiology-autocomplete', 'RadiologyController@storeRadiologyAutocomplete')->name('radiology.store-radiology-autocomplete');
Route::post('radiology-editor-autocomplete-list', 'RadiologyController@RadiologyAllAutocomplete')->name('radiology-editor-autocomplete-list');
Route::get('radiology-editor-autocomplete/{id}', 'RadiologyController@editRadiologyAutocomplete')->name('radiology-editor-autocomplete-edit');
Route::get('radiology/value-search', 'RadiologyController@radiologyValueSearch')->name('radiology.value-search');



# Doctor Performance Summary
Route::get('reports/doctor-performance-summary-v2', [ReportController::class, 'doctorPerformanceSummaryV2'])->name('reports.doctor-performance-summary-v2');
Route::post('reports/doctor-performance-summary-v2-search', [ReportController::class, 'doctorPerformanceSummaryV2Search'])->name('reports.doctor-performance-summary-v2-search');
Route::post('reports/doctor-performance-summary-v2-download/{type}', [ReportController::class, 'doctorPerformanceSummaryV2Download'])->name('reports.doctor-performance-summary-v2-download');
Route::post('reports/doctor-performance-summary-pdf-v2/{type}', [ReportController::class, 'doctorPerformanceReportPdfV2'])->name('reports.doctor-performance-summary-pdf-v2');
Route::post('save-lab-test-template-his', 'PathologyController@saveLabTestTemplateHis')->name('save-lab-test-template-his');




// stockTransferWorklist
Route::get('stock-transfer-worklist', 'StoreController@stockTransferWorklist')->name('stock-transfer-worklist');
Route::get('stock-transfer-worklist-list', 'StoreController@stockTransferWorkListShow')->name('stock-transfer-worklist-list');
// Route::get('stock-transfer-pending-list', 'StoreController@stockTransferPendingListShow')->name('stock-transfer-pending-list');
Route::post('stock-transfer-search', 'StoreController@stockTransferSearchListShow')->name('stock-transfer-search');
Route::post('stock-transfer-pdf', 'StoreController@stockTransferReportPdf')->name('stock-transfer-pdf');
Route::get('stock-transfer-details/{id?}', 'StoreController@stockTransferDetails')->name('stock-transfer-details');

// supplier return Worklist
Route::get('supplier-return-worklist', 'StoreController@supplierReturnWorklist')->name('supplier-return-worklist');
// Route::get('stock-transfer-worklist-list', 'StoreController@stockTransferWorkListShow')->name('stock-transfer-worklist-list');
// Route::get('stock-transfer-pending-list', 'StoreController@stockTransferPendingListShow')->name('stock-transfer-pending-list');
Route::post('supplier-return-search', 'StoreController@supplierReturnListShow')->name('supplier-return-search');
Route::post('supplier-return-pdf', 'StoreController@supplierReturnReportPdf')->name('supplier-return-pdf');
Route::get('supplier-return-details/{id?}', 'StoreController@supplierReturnDetails')->name('supplier-return-details');

//daliy attendance all punch
Route::get('hrm/daily-attendance-all-punch', 'ReportController@dailyAttendanceAllPunch')->name('hrm.daily-attendance-all-punch');
Route::post('hrm/search-daily-attendance-all-punch', 'ReportController@searchDailyAttendanceAllPunch')->name('hrm.search-daily-attendance-all-punch');
Route::post('hrm/print-daily-attendance-all-punch', 'ReportController@printDailyAttendanceAllPunch')->name('hrm.print-daily-attendance-all-punch');

// UOM Routes
Route::get('uom-list', 'ShiftController@uomList')->name('uom-list');
Route::get('uom/create_form', 'ShiftController@uomCreate')->name('uom.create_form');
Route::post('get-uom-list', 'ShiftController@getUomList')->name('get-uom-list');
Route::get('edit/uom/{id}', 'ShiftController@editUom')->name('edit.uom');
Route::post('uom-store', 'ShiftController@uomStore')->name('uom-store');
//excel data upload for recruitment
Route::get('hrm/salary-excel-data-upload', 'EmployeeController@salaryExcelDataUpload')->name('hrm.salary-excel-data-upload');
Route::post('hrm/salary-info-save', 'EmployeeController@salaryInfoSave')->name('hrm.salary-info-save');
Route::post('referral_print', 'DoctorController@referralPrint')->name('referral_print');

route::get('print-ogtt-worklist/{labId?}/{invoiceId?}', 'BillingController@ogttWorklist')->name('print-ogtt-worklist');


Route::get('stock-as-on-report', [StockReportController::class, 'stockAsOnReportV1'])->name('stock-as-on-report');
Route::post('stock-as-on-report-search-v1', [StockReportController::class, 'stockAsOnReportSearchV1'])->name('stock-as-on-report-search-v1');
Route::post('stock-as-on-report-print-v1', [StockReportController::class, 'stockAsOnReportPrintV1'])->name('stock-as-on-report-print-v1');
Route::post('stock-as-on-report-excel-v1', [StockReportController::class, 'stockAsOnReportexcelV1'])->name('stock-as-on-report-excel-v1');

Route::get('write-signature', [HomeController::class, 'writeSignature'])->name('write-signature');
Route::get('/refresh-csrf', function() {
return response()->json(['token' =>'this route run for application running']);
})->name('refresh-csrf');
Route::get('path/bc-report-pdf/{report_id?}', 'PathologyController@resultEntryPdf')->name('path.bc-report-pdf');
Route::get('path/bc-report-pdf-v1/{report_id?}', 'PathologyController@resultEntryPdfV1')->name('path.bc-report-pdf-v1');
Route::get('path/bc-report-pdf-column-4/{report_id?}', 'PathologyController@resultEntryPdfUnireColumn4')->name('path.bc-report-pdf-column-4');
Route::get('path/bc-report-pdf/3column/{report_id?}', 'PathologyController@resultEntryPdf3Column')->name('path.bc-report-pdf-3column');
Route::get('path/bc-report-pdf-elisa/{report_id?}', 'PathologyController@resultEntryPdfElisa')->name('path.bc-report-pdf-elisa');
Route::get('path/bc-report-pdf/column-2/{report_id}', 'PathologyController@resultEntryPdfColumn2')->name('path.bc-report-pdf-column-2');
Route::get('path/bc-report-pdf/column-2-pbf/{report_id}', 'PathologyController@resultEntryPdfPBFColumn2')->name('path.bc-report-pdf-column-2-pbf');
Route::get('path/bc-report-pdf-pcr/{report_id}', 'PathologyController@resultEntryPdfPcr')->name('path.bc-report-pdf-pcr');
Route::get('path/bc-report-pdf/mic/{report_id}', 'PathologyController@resultEntryPdfMic')->name('path.bc-report-pdf-mic');
Route::get('path/bc-report-pdf/cm/{report_id}', 'PathologyController@resultEntryPdfCm')->name('path.bc-report-pdf-cr');
Route::get('result-entry-form/column-2/{report_id}/{type}/{lab_id?}', 'PathologyController@resultEntryFormColumn2')->name('result-entry-form-column2');
// Form Template Management

Route::get('create-templates', [FormTemplateController::class,'create'])->name('create-templates');
Route::post('templates-store', [FormTemplateController::class,'store'])->name('templates.store');
// Route::resource('templates', FormTemplateController::class);
// Route::resource('fields', FormFieldController::class)->except(['index', 'show']);
Route::get('create-fields/{temp_id?}', [FormFieldController::class,'create'])->name('create-fields');
Route::get('show-form-fields/{temp_id}', [DynamicFormController::class,'show'])->name('show-form-fields');
Route::post('store-dynamic-form', [DynamicFormController::class,'store'])->name('store-dynamic-form');
Route::post('store-fields', [FormFieldController::class,'store'])->name('store-fields');

// // Dynamic Form Display and Submission
// Route::get('/forms/{id}', [DynamicFormController::class, 'show'])->name('dynamic-form.show');
// Route::post('/forms/{id}/submit', [DynamicFormController::class, 'submit'])->name('dynamic-form.submit');



//SurgicalChecklist Form
Route::get('/surgical-checklist/sign-in', [SurgicalChecklistController::class, 'create'])->name('surgical-checklist.sign-in');
Route::post('/surgical-checklist-store', [SurgicalChecklistController::class, 'store'])->name('surgical-checklist.store');
Route::get('surgical-checklist/print/{id}', [SurgicalChecklistController::class, 'surgicalChecklistExportPDF'])->name('surgical-checklist.print');
