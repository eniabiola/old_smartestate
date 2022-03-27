<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('messagetemplates/{tenantid}', 'MessagetemplateController@index');
    Route::get('messagetemplatessearch/{tenantid}/{search}', 'MessagetemplateController@search');
    Route::get('messagetemplatessearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'MessagetemplateController@searchsub');
    Route::get('messagetemplates/{tenantid}/{id}', 'MessagetemplateController@indexone');
    Route::get('messagetemplates/{tenantid}/{feild}/{search}', 'MessagetemplateController@indexmultiple');
    Route::get('messagetemplates/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'MessagetemplateController@indexmultiple2');
    Route::post('messagetemplates', 'MessagetemplateController@store');
    Route::put('messagetemplates/{id}', 'MessagetemplateController@update');
    Route::delete('messagetemplates/{id}', 'MessagetemplateController@delete');

    Route::get('userroles/{tenantid}', 'UserroleController@index');
    Route::get('userrolessearch/{tenantid}/{search}', 'UserroleController@search');
    Route::get('userrolessearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'UserroleController@searchsub');
    Route::get('userroles/{tenantid}/{id}', 'UserroleController@indexone');
    Route::get('userroles/{tenantid}/{feild}/{search}', 'UserroleController@indexmultiple');
    Route::get('userroles/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'UserroleController@indexmultiple2');
    Route::post('userroles', 'UserroleController@store');
    Route::put('userroles/{id}', 'UserroleController@update');
    Route::delete('userroles/{id}', 'UserroleController@delete');

    Route::get('rolemanagements/{tenantid}', 'RolemanagementController@index');
    Route::get('rolemanagementssearch/{tenantid}/{search}', 'RolemanagementController@search');
    Route::get('rolemanagementssearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'RolemanagementController@searchsub');
    Route::get('rolemanagements/{tenantid}/{id}', 'RolemanagementController@indexone');
    Route::get('rolemanagements/{tenantid}/{feild}/{search}', 'RolemanagementController@indexmultiple');
    Route::get('rolemanagements/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'RolemanagementController@indexmultiple2');
    Route::post('rolemanagements', 'RolemanagementController@store');
    Route::put('rolemanagements/{id}', 'RolemanagementController@update');
    Route::delete('rolemanagements/{id}', 'RolemanagementController@delete');

    Route::get('usermanagements/{tenantid}', 'UsermanagementController@index');
    Route::get('usermanagementssearch/{tenantid}/{search}', 'UsermanagementController@search');
    Route::get('usermanagementssearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'UsermanagementController@searchsub');
    Route::get('usermanagements/{tenantid}/{id}', 'UsermanagementController@indexone');
    Route::get('usermanagements/{tenantid}/{feild}/{search}', 'UsermanagementController@indexmultiple');
    Route::get('usermanagements/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'UsermanagementController@indexmultiple2');
    Route::post('usermanagements', 'UsermanagementController@store');
    Route::put('usermanagements/{id}', 'UsermanagementController@update');
    Route::delete('usermanagements/{id}', 'UsermanagementController@delete');

    Route::get('superadmindboard/{tenantid}', 'SubscriberController@superadmindboard');
    Route::get('admindashboard/{tenantid}', 'SubscriberController@admindashboard');

    Route::get('checkduplicate/{tenantid}', 'SubscriberController@checkduplicate');

    Route::get('subscribers/{tenantid}', 'SubscriberController@index');
    Route::get('subscriberssearch/{tenantid}/{search}', 'SubscriberController@search');
    Route::get('subscriberssearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'SubscriberController@searchsub');
    Route::get('verifycode/{tenantid}', 'SubscriberController@verifycode');
    Route::get('subscribers/{tenantid}/{id}', 'SubscriberController@indexone');

    Route::get('getbankname/{ac}/{bnk}', 'SubscriberController@getbankname');

    Route::get('subscribers/{tenantid}/{feild}/{search}', 'SubscriberController@indexmultiple');
    Route::get('subscribers/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'SubscriberController@indexmultiple2');
    Route::post('subscribers', 'SubscriberController@store');
    Route::put('subscribers/{id}', 'SubscriberController@update');
    Route::delete('subscribers/{id}', 'SubscriberController@delete');

    Route::get('messages/{tenantid}', 'MessageController@index');
    Route::get('messagessearch/{tenantid}/{search}', 'MessageController@search');
    Route::get('messagerecipient/{tenantid}/{messageid}', 'MessageController@messagerecipient');
    Route::get('messagessearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'MessageController@searchsub');
    Route::get('messages/{tenantid}/{id}', 'MessageController@indexone');
    Route::get('messages/{tenantid}/{feild}/{search}', 'MessageController@indexmultiple');
    Route::get('messages/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'MessageController@indexmultiple2');
    Route::post('messages', 'MessageController@store');
    Route::post('sendmessage', 'MessageController@sendmessage');
    Route::post('storerecipient', 'MessageController@storerecipient');
    Route::put('messages/{id}', 'MessageController@update');
    Route::delete('messages/{id}', 'MessageController@delete');

    Route::get('states/{tenantid}', 'StateController@index');
    Route::get('statessearch/{tenantid}/{search}', 'StateController@search');
    Route::get('statessearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'StateController@searchsub');
    Route::get('states/{tenantid}/{id}', 'StateController@indexone');
    Route::get('states/{tenantid}/{feild}/{search}', 'StateController@indexmultiple');
    Route::get('states/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'StateController@indexmultiple2');
    Route::post('states', 'StateController@store');
    Route::put('states/{id}', 'StateController@update');
    Route::delete('states/{id}', 'StateController@delete');

    Route::get('cities/{tenantid}', 'CityController@index');
    Route::get('citiessearch/{tenantid}/{search}', 'CityController@search');
    Route::get('citiessearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'CityController@searchsub');
    Route::get('cities/{tenantid}/{id}', 'CityController@indexone');
    Route::get('cities/{tenantid}/{feild}/{search}', 'CityController@indexmultiple');
    Route::get('cities/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'CityController@indexmultiple2');
    Route::post('cities', 'CityController@store');
    Route::put('cities/{id}', 'CityController@update');
    Route::delete('cities/{id}', 'CityController@delete');

    Route::get('banks/{tenantid}', 'BankController@index');
    Route::get('bankssearch/{tenantid}/{search}', 'BankController@search');
    Route::get('bankssearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'BankController@searchsub');
    Route::get('banks/{tenantid}/{id}', 'BankController@indexone');
    Route::get('banks/{tenantid}/{feild}/{search}', 'BankController@indexmultiple');
    Route::get('banks/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'BankController@indexmultiple2');
    Route::post('banks', 'BankController@store');
    Route::put('banks/{id}', 'BankController@update');
    Route::delete('banks/{id}', 'BankController@delete');

    Route::get('mainmenus/{tenantid}', 'MainmenuController@index');
    Route::get('mainmenusresident/{tenantid}', 'MainmenuController@indexresident');
    Route::get('mainmenussystem/{tenantid}', 'MainmenuController@indexsystem');
    Route::get('mainmenussecurity/{tenantid}', 'MainmenuController@indexsecurity');
    Route::get('mainmenussearch/{tenantid}/{search}', 'MainmenuController@search');
    Route::get('mainmenussearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'MainmenuController@searchsub');
    Route::get('mainmenus/{tenantid}/{id}', 'MainmenuController@indexone');
    Route::get('mainmenus/{tenantid}/{feild}/{search}', 'MainmenuController@indexmultiple');
    Route::get('mainmenus/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'MainmenuController@indexmultiple2');
    Route::post('mainmenus', 'MainmenuController@store');
    Route::put('mainmenus/{id}', 'MainmenuController@update');
    Route::delete('mainmenus/{id}', 'MainmenuController@delete');

    Route::get('submenus/{tenantid}', 'SubmenuController@index');
    Route::get('submenussearch/{tenantid}/{search}', 'SubmenuController@search');
    Route::get('submenussearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'SubmenuController@searchsub');
    Route::get('submenus/{tenantid}/{id}', 'SubmenuController@indexone');
    Route::get('submenus/{tenantid}/{feild}/{search}', 'SubmenuController@indexmultiple');
    Route::get('submenus/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'SubmenuController@indexmultiple2');
    Route::post('submenus', 'SubmenuController@store');
    Route::put('submenus/{id}', 'SubmenuController@update');
    Route::delete('submenus/{id}', 'SubmenuController@delete');

    Route::get('estates/{tenantid}', 'EstateController@index');
    Route::get('estatessearch/{tenantid}/{search}', 'EstateController@search');
    Route::get('estatessearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'EstateController@searchsub');
    Route::get('estates/{tenantid}/{id}', 'EstateController@indexone');
    Route::get('estates/{tenantid}/{feild}/{search}', 'EstateController@indexmultiple');
    Route::get('estates/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'EstateController@indexmultiple2');
    Route::post('estates', 'EstateController@store');
    Route::put('estates/{id}', 'EstateController@update');
    Route::delete('estates/{id}', 'EstateController@delete');

    Route::get('residents/{tenantid}', 'ResidentController@index');
    Route::get('residentssearch/{tenantid}/{search}/{status}', 'ResidentController@search');
    Route::get('residentssearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'ResidentController@searchsub');
    Route::get('residents/{tenantid}/{id}', 'ResidentController@indexone');
    Route::get('residentaction/{id}/{action}', 'ResidentController@residentaction');
    Route::get('residents/{tenantid}/{feild}/{search}', 'ResidentController@indexmultiple');
    Route::get('residents/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'ResidentController@indexmultiple2');
    Route::post('residents', 'ResidentController@store');
    Route::put('residents/{id}', 'ResidentController@update');
    Route::delete('residents/{id}', 'ResidentController@delete');

    Route::get('housetypes/{tenantid}', 'HousetypeController@index');
    Route::get('housetypessearch/{tenantid}/{search}', 'HousetypeController@search');
    Route::get('housetypessearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'HousetypeController@searchsub');
    Route::get('housetypes/{tenantid}/{id}', 'HousetypeController@indexone');
    Route::get('housetypes/{tenantid}/{feild}/{search}', 'HousetypeController@indexmultiple');
    Route::get('housetypes/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'HousetypeController@indexmultiple2');
    Route::post('housetypes', 'HousetypeController@store');
    Route::put('housetypes/{id}', 'HousetypeController@update');
    Route::delete('housetypes/{id}', 'HousetypeController@delete');

    Route::get('street/{tenantid}', 'StreetController@index');
    Route::post('street', 'StreetController@store');
    Route::put('street/{id}', 'StreetController@update');
    Route::delete('street/{id}', 'StreetController@delete');

    Route::get('landlords/{tenantid}', 'LandlordController@index');
    Route::get('landlordssearch/{tenantid}/{search}', 'LandlordController@search');
    Route::get('landlordssearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'LandlordController@searchsub');
    Route::get('landlords/{tenantid}/{id}', 'LandlordController@indexone');
    Route::get('landlords/{tenantid}/{feild}/{search}', 'LandlordController@indexmultiple');
    Route::get('landlords/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'LandlordController@indexmultiple2');
    Route::post('landlords', 'LandlordController@store');
    Route::put('landlords/{id}', 'LandlordController@update');
    Route::delete('landlords/{id}', 'LandlordController@delete');

    Route::get('billings/{tenantid}', 'BillingController@index');
    Route::get('billingssearch/{tenantid}/{search}', 'BillingController@search');
    Route::get('billingssearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'BillingController@searchsub');
    Route::get('billings/{tenantid}/{id}', 'BillingController@indexone');
    Route::get('billings/{tenantid}/{feild}/{search}', 'BillingController@indexmultiple');
    Route::get('billings/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'BillingController@indexmultiple2');
    Route::post('billings', 'BillingController@store');
    Route::put('billings/{id}', 'BillingController@update');
    Route::delete('billings/{id}', 'BillingController@delete');

    Route::get('electricity_tokens', 'ElectricitytokenController@index');
    Route::get('electricity_tokenssearch/{tenantid}/{search}', 'ElectricitytokenController@search');
    Route::get('electricity_tokenssearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'ElectricitytokenController@searchsub');
    Route::get('electricity_tokens/{tenantid}/{id}', 'ElectricitytokenController@indexone');
    Route::get('electricity_tokens/{tenantid}/{feild}/{search}', 'ElectricitytokenController@indexmultiple');
    Route::get('electricity_tokens/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'ElectricitytokenController@indexmultiple2');
    Route::post('electricity_tokens', 'InvoiceController@electricityinvoice');
    Route::get('electricity/verify_meter_no', 'ElectricitytokenController@verifyMeterNo');
    Route::post('electricity/purchase_token', 'ElectricitytokenController@purchaseElectricityToken');
    //Route::post('electricity_tokens', 'ElectricitytokenController@store');
    Route::put('electricity_tokens/{id}', 'ElectricitytokenController@update');
    Route::delete('electricity_tokens/{id}', 'ElectricitytokenController@delete');

    Route::get('complaints/{tenantid}', 'ComplaintsController@index');
    Route::get('complaintssearch/{tenantid}/{search}', 'ComplaintsController@search');
    Route::get('complaintresident/{tenantid}/{resident}', 'ComplaintsController@complaintresident');
    Route::get('complaintssearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'ComplaintsController@searchsub');
    Route::get('complaints/{tenantid}/{id}', 'ComplaintsController@indexone');
    Route::get('requestresident/{tenantid}/{id}', 'ComplaintsController@requestresident');
    Route::post('storeresponse', 'ComplaintsController@storeresponse');
    Route::get('storeresponselist/{tenantid}/{id}', 'ComplaintsController@storeresponselist');
    Route::get('requestclose/{tenantid}/{id}', 'ComplaintsController@requestclose');
    Route::get('requestcancel/{tenantid}/{id}', 'ComplaintsController@requestcancel');
    Route::get('complaints/{tenantid}/{feild}/{search}', 'ComplaintsController@indexmultiple');
    Route::get('complaints/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'ComplaintsController@indexmultiple2');
    Route::post('complaints', 'ComplaintsController@store');
    Route::post('uploadPhoto', 'ComplaintsController@storeUpload');
    Route::put('complaints/{id}', 'ComplaintsController@update');
    Route::delete('complaints/{id}', 'ComplaintsController@delete');

    Route::get('visitor_passes', 'VisitorPassController@index');
    Route::get('visitorpassresident/{tenantid}', 'VisitorPassController@visitorpassresident');
    Route::get('visitor_passessearch/{tenantid}/{search}', 'VisitorPassController@search');
    Route::get('visitorpass/{tenantid}/{resident}', 'VisitorPassController@visitorpass');
    Route::get('processguest/{id}/{status}', 'VisitorPassController@processguest');
    Route::get('visitor_passessearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'VisitorPassController@searchsub');
    Route::get('visitor_passes/{id}', 'VisitorPassController@indexone');
    Route::get('cancelgatepass/{tenantid}/{id}', 'VisitorPassController@cancelgatepass');
    Route::get('visitor_passes/{tenantid}/{feild}/{search}', 'VisitorPassController@indexmultiple');
    Route::get('visitor_passes/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'VisitorPassController@indexmultiple2');
    Route::post('visitor_passes', 'VisitorPassController@store');
    Route::put('visitor_passes/{id}', 'VisitorPassController@update');
    Route::delete('visitor_passes/{id}', 'VisitorPassController@delete');

    Route::get('payments/{tenantid}', 'PaymentController@index');
    Route::get('paymentssearch/{tenantid}/{search}', 'PaymentController@search');
    Route::get('paymentssearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'PaymentController@searchsub');
    Route::get('payments/{tenantid}/{id}', 'PaymentController@indexone');
    Route::get('payments/{tenantid}/{feild}/{search}', 'PaymentController@indexmultiple');
    Route::get('payments/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'PaymentController@indexmultiple2');
    Route::post('payments', 'PaymentController@store');
    Route::put('payments/{id}', 'PaymentController@update');
    Route::delete('payments/{id}', 'PaymentController@delete');

    Route::get('invoicebalance/{tenantid}/{resid}', 'InvoiceController@invoicebalance');
    Route::get('invoices/{tenantid}', 'InvoiceController@index');
    Route::get('invoicessearch/{tenantid}/{search}', 'InvoiceController@search');
    Route::get('indexresident/{tenantid}/{resident}', 'InvoiceController@indexresident');
    Route::get('indexresidentpaid/{tenantid}/{resident}', 'InvoiceController@indexresidentpaid');

    Route::get('invoiceadmin/{tenantid}', 'InvoiceController@invoiceadmin');
    Route::get('paymentadmin/{tenantid}', 'InvoiceController@paymentadmin');
    Route::get('walletsadmin/{tenantid}', 'WalletController@walletsadmin');

    Route::get('invoicessearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'InvoiceController@searchsub');
    Route::get('pay/{tenantid}/{id}', 'InvoiceController@pay');
    Route::get('invoices/{tenantid}/{id}', 'InvoiceController@indexone');
    Route::get('invoices/{tenantid}/{feild}/{search}', 'InvoiceController@indexmultiple');
    Route::get('invoices/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'InvoiceController@indexmultiple2');
    Route::post('invoices', 'InvoiceController@store');
    Route::put('invoices/{id}', 'InvoiceController@update');
    Route::delete('invoices/{id}', 'InvoiceController@delete');

    Route::get('wallets/{tenantid}', 'WalletController@index');
    Route::get('walletsresident/{tenantid}/{search}', 'WalletController@indexresident');
    Route::get('walletbalance/{tenantid}/{walletid}', 'WalletController@walletbalance');
    Route::get('walletssearch/{tenantid}/{search}', 'WalletController@search');
    Route::get('walletssearchsub/{tenantid}/{feild}/{feildfvalue}/{search}', 'WalletController@searchsub');
    Route::get('wallets/{tenantid}/{id}', 'WalletController@indexone');
    Route::get('wallets/{tenantid}/{feild}/{search}', 'WalletController@indexmultiple');
    Route::get('wallets/{tenantid}/{feild}/{search}/{feild2}/{search2}', 'WalletController@indexmultiple2');
    Route::post('wallets', 'WalletController@store');
    Route::put('wallets/{id}', 'WalletController@update');
    Route::delete('wallets/{id}', 'WalletController@delete');

    Route::get('docs/{tenantid}/{ownertype}/{id}', 'DocumentUploadController@documetslist');
    Route::get('docs/{id}', 'DocumentUploadController@fileGet');
    Route::post('upload', 'DocumentUploadController@fileUpload');

    Route::get('countresident/{tenantid}', 'ResidentController@countresident');
    Route::get('countrequest/{tenantid}', 'ResidentController@countrequest');

    Route::get('checkdomain/{tenantid}/{id}', 'SubscriberController@checkdomain');
    Route::post('login', 'UsermanagementController@login');
    Route::post('changepassword', 'UsermanagementController@changepassword');
    Route::post('loginresident', 'UsermanagementController@loginresident');
