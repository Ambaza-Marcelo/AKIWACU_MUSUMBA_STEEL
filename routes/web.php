<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);

    //settings routes
    Route::get('EBMS/settings/index', 'Backend\SettingController@index')->name('admin.settings.index');
    Route::get('EBMS/settings/create', 'Backend\SettingController@create')->name('admin.settings.create');
    Route::post('EBMS/settings/store', 'Backend\SettingController@store')->name('admin.settings.store');
    Route::get('EBMS/settings/edit/{id}', 'Backend\SettingController@edit')->name('admin.settings.edit');
    Route::put('EBMS/settings/update/{id}', 'Backend\SettingController@update')->name('admin.settings.update');
    Route::delete('EBMS/settings/destroy/{id}', 'Backend\SettingController@destroy')->name('admin.settings.destroy');


     //musumba-steel-facture
    Route::get('musumba-steel-facture/index', 'Backend\MusumbaSteel\Ebp\FactureController@index')->name('admin.musumba-steel-facture.index');
    Route::get('musumba-steel-facture/list/all', 'Backend\MusumbaSteel\Ebp\FactureController@listAll')->name('admin.musumba-steel-facture.listAll');
    Route::get('musumba-steel-facture/facture/create', 'Backend\MusumbaSteel\Ebp\FactureController@create')->name('admin.musumba-steel-facture.create');
    Route::post('musumba-steel-facture/store', 'Backend\MusumbaSteel\Ebp\FactureController@store')->name('admin.musumba-steel-facture.store');
    Route::delete('musumba-steel-facture/facture/destroy/{invoice_number}', 'Backend\MusumbaSteel\Ebp\FactureController@destroy')->name('admin.musumba-steel-facture.destroy');
    Route::put('musumba-steel-facture/valider-facture/{invoice_number}','Backend\MusumbaSteel\Ebp\FactureController@validerFacture')->name('admin.musumba-steel-facture.validate');

    Route::get('musumba-steel/voir-facture-a-annuler/{invoice_number}','Backend\MusumbaSteel\Ebp\FactureController@voirFactureAnnuler')->name('admin.musumba-steel-voir-facture.reset');
    Route::put('musumba-steel/facture/annuler-facture/{invoice_number}','Backend\MusumbaSteel\Ebp\FactureController@annulerFacture')->name('admin.musumba-steel-facture.reset');
    Route::get('musumba-steel/facture/show/{invoice_number}','Backend\MusumbaSteel\Ebp\FactureController@show')->name('admin.musumba-steel-facture.show');

    Route::get('musumba-steel/facture-envoye-a-obr/generatepdf','Backend\MusumbaSteel\Ebp\FactureController@invoiceSentObrToPdf')->name('admin.musumba-steel-facture-envoye.pdf');
    Route::get('musumba-steel/facture-envoye-a-obr/export-to-excel','Backend\MusumbaSteel\Ebp\FactureController@exportToExcel')->name('admin.musumba-steel-facture-envoye.export-to-excel');

    //musumba-steel-items routes
    Route::get('musumba-steel-items/index', 'Backend\MusumbaSteel\Ebp\ArticleController@index')->name('admin.musumba-steel-items.index');
    Route::get('musumba-steel-items/create', 'Backend\MusumbaSteel\Ebp\ArticleController@create')->name('admin.musumba-steel-items.create');
    Route::post('musumba-steel-items/store', 'Backend\MusumbaSteel\Ebp\ArticleController@store')->name('admin.musumba-steel-items.store');
    Route::get('musumba-steel-items/edit/{id}', 'Backend\MusumbaSteel\Ebp\ArticleController@edit')->name('admin.musumba-steel-items.edit');
    Route::put('musumba-steel-items/update/{id}', 'Backend\MusumbaSteel\Ebp\ArticleController@update')->name('admin.musumba-steel-items.update');
    Route::delete('musumba-steel-items/destroy/{id}', 'Backend\MusumbaSteel\Ebp\ArticleController@destroy')->name('admin.musumba-steel-items.destroy'); 

    //musumba-steel-clients routes
    Route::get('musumba-steel-clients/index', 'Backend\MusumbaSteel\Ebp\ClientController@index')->name('admin.musumba-steel-clients.index');
    Route::get('musumba-steel-clients/create', 'Backend\MusumbaSteel\Ebp\ClientController@create')->name('admin.musumba-steel-clients.create');
    Route::post('musumba-steel-clients/store', 'Backend\MusumbaSteel\Ebp\ClientController@store')->name('admin.musumba-steel-clients.store');
    Route::get('musumba-steel-clients/edit/{id}', 'Backend\MusumbaSteel\Ebp\ClientController@edit')->name('admin.musumba-steel-clients.edit');
    Route::put('musumba-steel-clients/update/{id}', 'Backend\MusumbaSteel\Ebp\ClientController@update')->name('admin.musumba-steel-clients.update');
    Route::delete('musumba-steel-clients/destroy/{id}', 'Backend\MusumbaSteel\Ebp\ClientController@destroy')->name('admin.musumba-steel-clients.destroy'); 

    //musumba-steel-item-categories routes
    Route::get('musumba-steel-item-categories/index', 'Backend\MusumbaSteel\Ebp\CategoryController@index')->name('admin.musumba-steel-item-categories.index');
    Route::get('musumba-steel-item-categories/create', 'Backend\MusumbaSteel\Ebp\CategoryController@create')->name('admin.musumba-steel-item-categories.create');
    Route::post('musumba-steel-item-categories/store', 'Backend\MusumbaSteel\Ebp\CategoryController@store')->name('admin.musumba-steel-item-categories.store');
    Route::get('musumba-steel-item-categories/edit/{id}', 'Backend\MusumbaSteel\Ebp\CategoryController@edit')->name('admin.musumba-steel-item-categories.edit');
    Route::put('musumba-steel-item-categories/update/{id}', 'Backend\MusumbaSteel\Ebp\CategoryController@update')->name('admin.musumba-steel-item-categories.update');
    Route::delete('musumba-steel-item-categories/destroy/{id}', 'Backend\MusumbaSteel\Ebp\CategoryController@destroy')->name('admin.musumba-steel-item-categories.destroy');



    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
    
    //change language
    Route::get('/changeLang','Backend\DashboardController@changeLang')->name('changeLang');

    //hr routes
    //hr-departements routes
    Route::get('hr-departements/index', 'Backend\Hr\DepartementController@index')->name('admin.hr-departements.index');
    Route::get('hr-departements/create', 'Backend\Hr\DepartementController@create')->name('admin.hr-departements.create');
    Route::post('hr-departements/store', 'Backend\Hr\DepartementController@store')->name('admin.hr-departements.store');
    Route::get('hr-departements/edit/{id}', 'Backend\Hr\DepartementController@edit')->name('admin.hr-departements.edit');
    Route::put('hr-departements/update/{id}', 'Backend\Hr\DepartementController@update')->name('admin.hr-departements.update');
    Route::delete('hr-departements/destroy/{id}', 'Backend\Hr\DepartementController@destroy')->name('admin.hr-departements.destroy');

    //hr-services routes
    Route::get('hr-services/index', 'Backend\Hr\ServiceController@index')->name('admin.hr-services.index');
    Route::get('hr-services/create', 'Backend\Hr\ServiceController@create')->name('admin.hr-services.create');
    Route::post('hr-services/store', 'Backend\Hr\ServiceController@store')->name('admin.hr-services.store');
    Route::get('hr-services/edit/{id}', 'Backend\Hr\ServiceController@edit')->name('admin.hr-services.edit');
    Route::put('hr-services/update/{id}', 'Backend\Hr\ServiceController@update')->name('admin.hr-services.update');
    Route::delete('hr-services/destroy/{id}', 'Backend\Hr\ServiceController@destroy')->name('admin.hr-services.destroy');

    //hr-fonctions routes
    Route::get('hr-fonctions/index', 'Backend\Hr\FonctionController@index')->name('admin.hr-fonctions.index');
    Route::get('hr-fonctions/create', 'Backend\Hr\FonctionController@create')->name('admin.hr-fonctions.create');
    Route::post('hr-fonctions/store', 'Backend\Hr\FonctionController@store')->name('admin.hr-fonctions.store');
    Route::get('hr-fonctions/edit/{id}', 'Backend\Hr\FonctionController@edit')->name('admin.hr-fonctions.edit');
    Route::put('hr-fonctions/update/{id}', 'Backend\Hr\FonctionController@update')->name('admin.hr-fonctions.update');
    Route::delete('hr-fonctions/destroy/{id}', 'Backend\Hr\FonctionController@destroy')->name('admin.hr-fonctions.destroy');

    //hr-banques routes
    Route::get('hr-banques/index', 'Backend\Hr\BanqueController@index')->name('admin.hr-banques.index');
    Route::get('hr-banques/create', 'Backend\Hr\BanqueController@create')->name('admin.hr-banques.create');
    Route::post('hr-banques/store', 'Backend\Hr\BanqueController@store')->name('admin.hr-banques.store');
    Route::get('hr-banques/edit/{id}', 'Backend\Hr\BanqueController@edit')->name('admin.hr-banques.edit');
    Route::put('hr-banques/update/{id}', 'Backend\Hr\BanqueController@update')->name('admin.hr-banques.update');
    Route::delete('hr-banques/destroy/{id}', 'Backend\Hr\BanqueController@destroy')->name('admin.hr-banques.destroy');

    //hr-grades routes
    Route::get('hr-grades/index', 'Backend\Hr\GradeController@index')->name('admin.hr-grades.index');
    Route::get('hr-grades/create', 'Backend\Hr\GradeController@create')->name('admin.hr-grades.create');
    Route::post('hr-grades/store', 'Backend\Hr\GradeController@store')->name('admin.hr-grades.store');
    Route::get('hr-grades/edit/{id}', 'Backend\Hr\GradeController@edit')->name('admin.hr-grades.edit');
    Route::put('hr-grades/update/{id}', 'Backend\Hr\GradeController@update')->name('admin.hr-grades.update');
    Route::delete('hr-grades/destroy/{id}', 'Backend\Hr\GradeController@destroy')->name('admin.hr-grades.destroy');

    //hr-employes routes
    Route::get('hr-employes/index/{company_id}', 'Backend\Hr\EmployeController@index')->name('admin.hr-employes.index');
    Route::get('hr-employes/create', 'Backend\Hr\EmployeController@create')->name('admin.hr-employes.create');
    Route::get('hr-employes/show/{id}', 'Backend\Hr\EmployeController@show')->name('admin.hr-employes.show');
    Route::post('hr-employes/store', 'Backend\Hr\EmployeController@store')->name('admin.hr-employes.store');
    Route::get('hr-employes/edit/{id}', 'Backend\Hr\EmployeController@edit')->name('admin.hr-employes.edit');
    Route::put('hr-employes/update/{id}', 'Backend\Hr\EmployeController@update')->name('admin.hr-employes.update');
    Route::delete('hr-employes/destroy/{id}', 'Backend\Hr\EmployeController@destroy')->name('admin.hr-employes.destroy');

    Route::get('hr-employes/exportToExcel/{company_id}', 'Backend\Hr\EmployeController@exportToExcel')->name('admin.hr-employes.exportToExcel');

    //hr-stagiaires routes
    Route::get('hr-stagiaires/index/{company_id}', 'Backend\Hr\StagiaireController@index')->name('admin.hr-stagiaires.index');
    Route::get('hr-stagiaire/select-by-company', 'Backend\Hr\StagiaireController@selectByCompany')->name('admin.stagiare-select-by-company');
    Route::get('hr-stagiaires/create', 'Backend\Hr\StagiaireController@create')->name('admin.hr-stagiaires.create');
    Route::get('hr-stagiaires/show/{id}', 'Backend\Hr\StagiaireController@show')->name('admin.hr-stagiaires.show');
    Route::post('hr-stagiaires/store', 'Backend\Hr\StagiaireController@store')->name('admin.hr-stagiaires.store');
    Route::get('hr-stagiaires/edit/{id}', 'Backend\Hr\StagiaireController@edit')->name('admin.hr-stagiaires.edit');
    Route::put('hr-stagiaires/update/{id}', 'Backend\Hr\StagiaireController@update')->name('admin.hr-stagiaires.update');
    Route::delete('hr-stagiaires/destroy/{id}', 'Backend\Hr\StagiaireController@destroy')->name('admin.hr-stagiaires.destroy');

    //hr-jours-feries routes
    Route::get('hr-jours-feries/index', 'Backend\Hr\JourFerieController@index')->name('admin.hr-jours-feries.index');
    Route::get('hr-jours-feries/create', 'Backend\Hr\JourFerieController@create')->name('admin.hr-jours-feries.create');
    Route::post('hr-jours-feries/store', 'Backend\Hr\JourFerieController@store')->name('admin.hr-jours-feries.store');
    Route::get('hr-jours-feries/edit/{id}', 'Backend\Hr\JourFerieController@edit')->name('admin.hr-jours-feries.edit');
    Route::put('hr-jours-feries/update/{id}', 'Backend\Hr\JourFerieController@update')->name('admin.hr-jours-feries.update');
    Route::delete('hr-jours-feries/destroy/{id}', 'Backend\Hr\JourFerieController@destroy')->name('admin.hr-jours-feries.destroy');

    //hr-jours-travails routes
    Route::get('hr-jours-travails/index', 'Backend\Hr\JourTravailController@index')->name('admin.hr-jours-travails.index');
    Route::get('hr-jours-travails/create', 'Backend\Hr\JourTravailController@create')->name('admin.hr-jours-travails.create');
    Route::post('hr-jours-travails/store', 'Backend\Hr\JourTravailController@store')->name('admin.hr-jours-travails.store');
    Route::get('hr-jours-travails/edit/{id}', 'Backend\Hr\JourTravailController@edit')->name('admin.hr-jours-travails.edit');
    Route::put('hr-jours-travails/update/{id}', 'Backend\Hr\JourTravailController@update')->name('admin.hr-jours-travails.update');
    Route::delete('hr-jours-travails/destroy/{id}', 'Backend\Hr\JourTravailController@destroy')->name('admin.hr-jours-travails.destroy');

    //hr-ecoles routes
    Route::get('hr-ecoles/index', 'Backend\Hr\EcoleController@index')->name('admin.hr-ecoles.index');
    Route::get('hr-ecoles/create', 'Backend\Hr\EcoleController@create')->name('admin.hr-ecoles.create');
    Route::post('hr-ecoles/store', 'Backend\Hr\EcoleController@store')->name('admin.hr-ecoles.store');
    Route::get('hr-ecoles/edit/{id}', 'Backend\Hr\EcoleController@edit')->name('admin.hr-ecoles.edit');
    Route::put('hr-ecoles/update/{id}', 'Backend\Hr\EcoleController@update')->name('admin.hr-ecoles.update');
    Route::delete('hr-ecoles/destroy/{id}', 'Backend\Hr\EcoleController@destroy')->name('admin.hr-ecoles.destroy');

    //hr-filieres routes
    Route::get('hr-filieres/index', 'Backend\Hr\FiliereController@index')->name('admin.hr-filieres.index');
    Route::get('hr-filieres/create', 'Backend\Hr\FiliereController@create')->name('admin.hr-filieres.create');
    Route::post('hr-filieres/store', 'Backend\Hr\FiliereController@store')->name('admin.hr-filieres.store');
    Route::get('hr-filieres/edit/{id}', 'Backend\Hr\FiliereController@edit')->name('admin.hr-filieres.edit');
    Route::put('hr-filieres/update/{id}', 'Backend\Hr\FiliereController@update')->name('admin.hr-filieres.update');
    Route::delete('hr-filieres/destroy/{id}', 'Backend\Hr\FiliereController@destroy')->name('admin.hr-filieres.destroy');

    //hr-type-absences routes
    Route::get('hr-type-absences/index', 'Backend\Hr\TypeAbsenceController@index')->name('admin.hr-type-absences.index');
    Route::get('hr-type-absences/create', 'Backend\Hr\TypeAbsenceController@create')->name('admin.hr-type-absences.create');
    Route::post('hr-type-absences/store', 'Backend\Hr\TypeAbsenceController@store')->name('admin.hr-type-absences.store');
    Route::get('hr-type-absences/edit/{id}', 'Backend\Hr\TypeAbsenceController@edit')->name('admin.hr-type-absences.edit');
    Route::put('hr-type-absences/update/{id}', 'Backend\Hr\TypeAbsenceController@update')->name('admin.hr-type-absences.update');
    Route::delete('hr-type-absences/destroy/{id}', 'Backend\Hr\TypeAbsenceController@destroy')->name('admin.hr-type-absences.destroy');


    //hr-conge-payes routes
    Route::get('hr-conge-payes/index', 'Backend\Hr\CongePayeController@index')->name('admin.hr-conge-payes.index');
    Route::get('hr-conge-payes/create', 'Backend\Hr\CongePayeController@create')->name('admin.hr-conge-payes.create');
    Route::post('hr-conge-payes/store', 'Backend\Hr\CongePayeController@store')->name('admin.hr-conge-payes.store');
    Route::get('hr-conge-payes/edit/{id}', 'Backend\Hr\CongePayeController@edit')->name('admin.hr-conge-payes.edit');
    Route::put('hr-conge-payes/update/{id}', 'Backend\Hr\CongePayeController@update')->name('admin.hr-conge-payes.update');
    Route::delete('hr-conge-payes/destroy/{id}', 'Backend\Hr\CongePayeController@destroy')->name('admin.hr-conge-payes.destroy');

    //hr-type-conges routes
    Route::get('hr-type-conges/index', 'Backend\Hr\TypeCongeController@index')->name('admin.hr-type-conges.index');
    Route::get('hr-type-conges/create', 'Backend\Hr\TypeCongeController@create')->name('admin.hr-type-conges.create');
    Route::post('hr-type-conges/store', 'Backend\Hr\TypeCongeController@store')->name('admin.hr-type-conges.store');
    Route::get('hr-type-conges/edit/{id}', 'Backend\Hr\TypeCongeController@edit')->name('admin.hr-type-conges.edit');
    Route::put('hr-type-conges/update/{id}', 'Backend\Hr\TypeCongeController@update')->name('admin.hr-type-conges.update');
    Route::delete('hr-type-conges/destroy/{id}', 'Backend\Hr\TypeCongeController@destroy')->name('admin.hr-type-conges.destroy');

    //hr-take-conges routes
    Route::get('hr-take-conges/index/{company_id}', 'Backend\Hr\TakeCongeController@index')->name('admin.hr-take-conges.index');
    Route::get('hr-leave-taken/select-by-company', 'Backend\Hr\TakeCongeController@selectByCompany')->name('admin.hr-leave-taken.select-by-company');
    Route::get('hr-take-conges/create/{company_id}', 'Backend\Hr\TakeCongeController@create')->name('admin.hr-take-conges.create');
    Route::post('hr-take-conges/store', 'Backend\Hr\TakeCongeController@store')->name('admin.hr-take-conges.store');
    Route::get('hr-take-conges/edit/{id}', 'Backend\Hr\TakeCongeController@edit')->name('admin.hr-take-conges.edit');
    Route::put('hr-take-conges/update/{id}', 'Backend\Hr\TakeCongeController@update')->name('admin.hr-take-conges.update');
    Route::delete('hr-take-conges/destroy/{id}', 'Backend\Hr\TakeCongeController@destroy')->name('admin.hr-take-conges.destroy');

    Route::get('hr-take-conges/billet-sortie/{id}', 'Backend\Hr\TakeCongeController@billetSortie')->name('admin.hr-take-conges.billetSortie');

    //hr-take-conge-payes routes
    Route::get('hr-take-conge-payes/index/{company_id}', 'Backend\Hr\TakeCongePayeController@index')->name('admin.hr-take-conge-payes.index');
    Route::get('hr-take-paid-leave/select-by-company', 'Backend\Hr\TakeCongePayeController@selectByCompany')->name('admin.hr-take-paid-leave.select-by-company');
    Route::get('hr-take-conge-payes/create/{company_id}', 'Backend\Hr\TakeCongePayeController@create')->name('admin.hr-take-conge-payes.create');
    Route::post('hr-take-conge-payes/store', 'Backend\Hr\TakeCongePayeController@store')->name('admin.hr-take-conge-payes.store');
    Route::get('hr-take-conge-payes/edit/{id}', 'Backend\Hr\TakeCongePayeController@edit')->name('admin.hr-take-conge-payes.edit');
    Route::put('hr-take-conge-payes/update/{id}', 'Backend\Hr\TakeCongePayeController@update')->name('admin.hr-take-conge-payes.update');
    Route::delete('hr-take-conge-payes/destroy/{id}', 'Backend\Hr\TakeCongePayeController@destroy')->name('admin.hr-take-conge-payes.destroy');

    Route::post('hr-take-conge-payes/fetch', 'Backend\Hr\TakeCongePayeController@fetch')->name('admin.hr-take-conge-payes.fetch');

    Route::get('hr-take-conge-payes/lettre-Demande-Conge/{id}', 'Backend\Hr\TakeCongePayeController@lettreDemandeConge')->name('admin.hr-take-conge-payes.lettreDemandeConge');

    Route::put('hr-take-conge-paye/valider/{id}', 'Backend\Hr\TakeCongePayeController@validerConge')->name('admin.hr-take-conge-paye.valider');
    Route::put('hr-take-conge-paye/confirmer/{id}', 'Backend\Hr\TakeCongePayeController@confirmerConge')->name('admin.hr-take-conge-paye.confirmer');
    Route::put('hr-take-conge-paye/approuver/{id}', 'Backend\Hr\TakeCongePayeController@approuverConge')->name('admin.hr-take-conge-paye.approuver');
    Route::put('hr-take-conge-paye/rejeter/{id}', 'Backend\Hr\TakeCongePayeController@rejeterConge')->name('admin.hr-take-conge-paye.rejeter');
    Route::put('hr-take-conge-paye/annuler/{id}', 'Backend\Hr\TakeCongePayeController@annulerConge')->name('admin.hr-take-conge-paye.annuler');

    //hr-loans routes
    Route::get('hr-loans/index', 'Backend\Hr\LoanController@index')->name('admin.hr-loans.index');
    Route::get('hr-loans/create', 'Backend\Hr\LoanController@create')->name('admin.hr-loans.create');
    Route::post('hr-loans/store', 'Backend\Hr\LoanController@store')->name('admin.hr-loans.store');
    Route::get('hr-loans/edit/{id}', 'Backend\Hr\LoanController@edit')->name('admin.hr-loans.edit');
    Route::put('hr-loans/update/{id}', 'Backend\Hr\LoanController@update')->name('admin.hr-loans.update');
    Route::delete('hr-loans/destroy/{id}', 'Backend\Hr\LoanController@destroy')->name('admin.hr-loans.destroy');

    //hr-cotations routes
    Route::get('hr-cotations/index', 'Backend\Hr\CotationController@index')->name('admin.hr-cotations.index');
    Route::get('hr-cotations/create', 'Backend\Hr\CotationController@create')->name('admin.hr-cotations.create');
    Route::post('hr-cotations/store', 'Backend\Hr\CotationController@store')->name('admin.hr-cotations.store');
    Route::get('hr-cotations/edit/{id}', 'Backend\Hr\CotationController@edit')->name('admin.hr-cotations.edit');
    Route::put('hr-cotations/update/{id}', 'Backend\Hr\CotationController@update')->name('admin.hr-cotations.update');
    Route::delete('hr-cotations/destroy/{id}', 'Backend\Hr\CotationController@destroy')->name('admin.hr-cotations.destroy');

    //hr-paiements routes
    Route::get('hr-paiement/create-by-company', 'Backend\Hr\PaiementController@createByCompany')->name('admin.hr-paiement.createByCompany');
    Route::get('hr-paiement/select-by-company', 'Backend\Hr\PaiementController@selectByCompany')->name('admin.hr-paiement.selectByCompany');
    Route::get('hr-paiements/index/{company_id}', 'Backend\Hr\PaiementController@index')->name('admin.hr-paiements.index');
    Route::get('hr-paiements/create/{company_id}', 'Backend\Hr\PaiementController@create')->name('admin.hr-paiements.create');
    Route::post('hr-paiements/store', 'Backend\Hr\PaiementController@store')->name('admin.hr-paiements.store');
    Route::get('hr-paiements/edit/{id}/by-company/{company_id}', 'Backend\Hr\PaiementController@edit')->name('admin.hr-paiements.edit');
    Route::get('hr-paiements/show/{code}', 'Backend\Hr\PaiementController@show')->name('admin.hr-paiements.show');
    Route::put('hr-paiements/update/{id}', 'Backend\Hr\PaiementController@update')->name('admin.hr-paiements.update');
    Route::delete('hr-paiements/destroy/{id}', 'Backend\Hr\PaiementController@destroy')->name('admin.hr-paiements.destroy');

    Route::get('hr-fiche-paie/print/{code}', 'Backend\Hr\PaiementController@ficheSalaire')->name('admin.hr-fiche-paie.print');

    Route::post('hr-paiements/fetch', 'Backend\Hr\PaiementController@fetch')->name('admin.hr-paiements.fetch');

    //hr-note-interne routes
    Route::get('hr-note-interne/index', 'Backend\Hr\NoteInterneController@index')->name('admin.hr-note-interne.index');
    Route::get('hr-note-interne/create', 'Backend\Hr\NoteInterneController@create')->name('admin.hr-note-interne.create');
    Route::post('hr-note-interne/store', 'Backend\Hr\NoteInterneController@store')->name('admin.hr-note-interne.store');
    Route::get('hr-note-interne/edit/{id}', 'Backend\Hr\NoteInterneController@edit')->name('admin.hr-note-interne.edit');
    Route::put('hr-note-interne/update/{id}', 'Backend\Hr\NoteInterneController@update')->name('admin.hr-note-interne.update');
    Route::delete('hr-note-interne/destroy/{id}', 'Backend\Hr\NoteInterneController@destroy')->name('admin.hr-note-interne.destroy');

    //hr-reglages routes
    Route::get('hr-reglages/index', 'Backend\Hr\ReglageController@index')->name('admin.hr-reglages.index');
    Route::get('hr-reglages/create', 'Backend\Hr\ReglageController@create')->name('admin.hr-reglages.create');
    Route::post('hr-reglages/store', 'Backend\Hr\ReglageController@store')->name('admin.hr-reglages.store');
    Route::get('hr-reglages/edit/{id}', 'Backend\Hr\ReglageController@edit')->name('admin.hr-reglages.edit');
    Route::put('hr-reglages/update/{id}', 'Backend\Hr\ReglageController@update')->name('admin.hr-reglages.update');
    Route::delete('hr-reglages/destroy/{id}', 'Backend\Hr\ReglageController@destroy')->name('admin.hr-reglages.destroy');

    //hr-companies routes
    Route::get('hr-company/select', 'Backend\Hr\CompanyController@selectCompany')->name('admin.hr-company.select');
    Route::get('hr-companies/index', 'Backend\Hr\CompanyController@index')->name('admin.hr-companies.index');
    Route::get('hr-companies/create', 'Backend\Hr\CompanyController@create')->name('admin.hr-companies.create');
    Route::post('hr-companies/store', 'Backend\Hr\CompanyController@store')->name('admin.hr-companies.store');
    Route::get('hr-companies/edit/{id}', 'Backend\Hr\CompanyController@edit')->name('admin.hr-companies.edit');
    Route::put('hr-companies/update/{id}', 'Backend\Hr\CompanyController@update')->name('admin.hr-companies.update');
    Route::delete('hr-companies/destroy/{id}', 'Backend\Hr\CompanyController@destroy')->name('admin.hr-companies.destroy');

    //hr-journal-paies routes
    Route::get('hr-journal-paie/select-by-company/{code}', 'Backend\Hr\JournalPaieController@selectByCompany')->name('admin.hr-journal-paie.select-by-company');
    Route::get('hr-journal-paies/index', 'Backend\Hr\JournalPaieController@index')->name('admin.hr-journal-paies.index');
    Route::get('hr-journal-paies/export-to-excel', 'Backend\Hr\JournalPaieController@exportToExcel')->name('admin.hr-journal-paies.export-to-excel');
    Route::get('hr-journal-paies/create', 'Backend\Hr\JournalPaieController@create')->name('admin.hr-journal-paies.create');
    Route::post('hr-journal-paies/store', 'Backend\Hr\JournalPaieController@store')->name('admin.hr-journal-paies.store');
    Route::get('hr-journal-paies/edit/{id}', 'Backend\Hr\JournalPaieController@edit')->name('admin.hr-journal-paies.edit');
    Route::get('hr-journal-paies/show/{code}/{company_id}', 'Backend\Hr\JournalPaieController@show')->name('admin.hr-journal-paies.show');
    Route::put('hr-journal-paies/cloturer/{id}', 'Backend\Hr\JournalPaieController@cloturer')->name('admin.hr-journal-paies.cloturer');
    Route::put('hr-journal-paies/update/{id}', 'Backend\Hr\JournalPaieController@update')->name('admin.hr-journal-paies.update');
    Route::delete('hr-journal-paies/destroy/{id}', 'Backend\Hr\JournalPaieController@destroy')->name('admin.hr-journal-paies.destroy');

    //hr-journal-cotisations routes
    Route::get('hr-journal-cotisations/index/{company_id}', 'Backend\Hr\JournalCotisationController@index')->name('admin.hr-journal-cotisations.index');
    Route::get('hr-journal-cotisations/select-by-company', 'Backend\Hr\JournalCotisationController@selectByCompany')->name('admin.hr-journal-cotisations.select-by-company');
    Route::get('hr-journal-cotisations/export-to-excel', 'Backend\Hr\JournalCotisationController@exportToExcel')->name('admin.hr-journal-cotisations.export-to-excel');

    //hr-journal-impots routes
    Route::get('hr-journal-impots/index/{company_id}', 'Backend\Hr\JournalImpotController@index')->name('admin.hr-journal-impots.index');
    Route::get('hr-journal-impots/select-by-company', 'Backend\Hr\JournalImpotController@selectByCompany')->name('admin.hr-journal-impots.select-by-company');
    Route::get('hr-journal-impots/export-to-excel', 'Backend\Hr\JournalImpotController@exportToExcel')->name('admin.hr-journal-impots.export-to-excel');

    //hr-journal-conges routes
    Route::get('hr-journal-conges/index', 'Backend\Hr\JournalCongeController@index')->name('admin.hr-journal-conges.index');
    Route::get('hr-journal-conges/create', 'Backend\Hr\JournalCongeController@create')->name('admin.hr-journal-conges.create');
    Route::post('hr-journal-conges/store', 'Backend\Hr\JournalCongeController@store')->name('admin.hr-journal-conges.store');
    Route::get('hr-journal-conges/edit/{id}', 'Backend\Hr\JournalCongeController@edit')->name('admin.hr-journal-conges.edit');
    Route::put('hr-journal-conges/update/{id}', 'Backend\Hr\JournalCongeController@update')->name('admin.hr-journal-conges.update');
    Route::delete('hr-journal-conges/destroy/{id}', 'Backend\Hr\JournalCongeController@destroy')->name('admin.hr-journal-conges.destroy');

    Route::get('hr-choose-report/index', 'Backend\Hr\ReportController@choose')->name('admin.hr-choose-report.choose');

    //musumba-steel ROUTES
    //materials routes
    Route::get('musumba-steel/ms-materials/index', 'Backend\MusumbaSteel\MaterialController@index')->name('admin.ms-materials.index');
    Route::get('musumba-steel/ms-materials/create', 'Backend\MusumbaSteel\MaterialController@create')->name('admin.ms-materials.create');
    Route::post('musumba-steel/ms-materials/store', 'Backend\MusumbaSteel\MaterialController@store')->name('admin.ms-materials.store');
    Route::get('musumba-steel/ms-materials/edit/{id}', 'Backend\MusumbaSteel\MaterialController@edit')->name('admin.ms-materials.edit');
    Route::put('musumba-steel/ms-materials/update/{id}', 'Backend\MusumbaSteel\MaterialController@update')->name('admin.ms-materials.update');
    Route::delete('musumba-steel/ms-materials/destroy/{id}', 'Backend\MusumbaSteel\MaterialController@destroy')->name('admin.ms-materials.destroy');

    //material-category routes
    Route::get('musumba-steel/ms-material-category/index', 'Backend\MusumbaSteel\MaterialCategoryController@index')->name('admin.ms-material-category.index');
    Route::get('musumba-steel/ms-material-category/create', 'Backend\MusumbaSteel\MaterialCategoryController@create')->name('admin.somstb-material-category.create');
    Route::post('musumba-steel/ms-material-category/store', 'Backend\MusumbaSteel\MaterialCategoryController@store')->name('admin.ms-material-category.store');
    Route::get('musumba-steel/ms-material-category/edit/{id}', 'Backend\MusumbaSteel\MaterialCategoryController@edit')->name('admin.ms-material-category.edit');
    Route::put('musumba-steel/ms-material-category/update/{id}', 'Backend\MusumbaSteel\MaterialCategoryController@update')->name('admin.ms-material-category.update');
    Route::delete('musumba-steel/ms-material-category/destroy/{id}', 'Backend\MusumbaSteel\MaterialCategoryController@destroy')->name('admin.ms-material-category.destroy');

    Route::get('musumba-steel/ms-material-store/index', 'Backend\MusumbaSteel\MaterialStoreController@index')->name('admin.ms-material-store.index');
    Route::get('musumba-steel/ms-material-store/create', 'Backend\MusumbaSteel\MaterialStoreController@create')->name('admin.ms-material-store.create');
    Route::post('musumba-steel/ms-material-store/store', 'Backend\MusumbaSteel\MaterialStoreController@store')->name('admin.ms-material-store.store');
    Route::get('musumba-steel/ms-material-store/show/{code}', 'Backend\MusumbaSteel\MaterialStoreController@show')->name('admin.ms-material-store.show');
    Route::get('musumba-steel/ms-material-store/edit/{code}', 'Backend\MusumbaSteel\MaterialStoreController@edit')->name('admin.ms-material-store.edit');
    Route::put('musumba-steel/ms-material-store/update/{code}', 'Backend\MusumbaSteel\MaterialStoreController@update')->name('admin.ms-material-store.update');
    Route::delete('musumba-steel/ms-material-store/destroy/{id}', 'Backend\MusumbaSteel\MaterialStoreController@destroy')->name('admin.ms-material-store.destroy');

    Route::get('musumba-steel/ms-material-store/store-status/{code}', 'Backend\MusumbaSteel\MaterialStoreController@storeStatus')->name('admin.ms-material-store.storeStatus');

    Route::get('musumba-steel/ms-material-store/export-to-excel/{code}', 'Backend\MusumbaSteel\MaterialStoreController@exportToExcel')->name('admin.ms-material-store.export-to-excel');


    //Inventaire Grand Stock Des Materiels
    Route::get('musumba-steel/ms-material-store-inventory/index', 'Backend\MusumbaSteel\MaterialStoreInventoryController@index')->name('admin.ms-material-store-inventory.index');
    Route::get('musumba-steel/ms-material-store-inventory/create/{code}', 'Backend\MusumbaSteel\MaterialStoreInventoryController@create')->name('admin.ms-material-store-inventory.create');
    Route::post('musumba-steel/ms-material-store-inventory/store', 'Backend\MusumbaSteel\MaterialStoreInventoryController@store')->name('admin.ms-material-store-inventory.store');
    Route::get('musumba-steel/ms-material-store-inventory/inventory/{id}', 'Backend\MusumbaSteel\MaterialStoreInventoryController@inventory')->name('admin.ms-material-store-inventory.inventory');
    Route::get('musumba-steel/ms-material-store-inventory/edit/{inventory_no}', 'Backend\MusumbaSteel\MaterialStoreInventoryController@edit')->name('admin.ms-material-store-inventory.edit');
    Route::get('musumba-steel/ms-material-store-inventory/show/{inventory_no}', 'Backend\MusumbaSteel\MaterialStoreInventoryController@show')->name('admin.ms-material-store-inventory.show');
    Route::put('musumba-steel/ms-material-store-inventory/update/{id}', 'Backend\MusumbaSteel\MaterialStoreInventoryController@update')->name('admin.ms-material-store-inventory.update');
    Route::delete('musumba-steel/ms-material-store-inventory/destroy/{id}', 'Backend\MusumbaSteel\MaterialStoreInventoryController@destroy')->name('admin.ms-material-store-inventory.destroy');

    Route::get('musumba-steel/ms-material-store-inventory/generatePdf/{inventory_no}','Backend\MusumbaSteel\MaterialStoreInventoryController@bon_inventaire')->name('admin.ms-material-store-inventory.generatePdf');
    Route::put('musumba-steel/ms-material-store-inventory/validate/{inventory_no}','Backend\MusumbaSteel\MaterialStoreInventoryController@validateInventory')->name('admin.ms-material-store-inventory.validate');
    Route::put('musumba-steel/ms-material-store-inventory/reject/{inventory_no}','Backend\MusumbaSteel\MaterialStoreInventoryController@rejectInventory')->name('admin.ms-material-store-inventory.reject');
    Route::put('musumba-steel/ms-material-store-inventory/reset/{inventory_no}','Backend\MusumbaSteel\MaterialStoreInventoryController@resetInventory')->name('admin.ms-material-store-inventory.reset');

    //material-requisitions routes
    Route::get('musumba-steel/ms-material-requisitions/index', 'Backend\MusumbaSteel\MaterialRequisitionController@index')->name('admin.ms-material-requisitions.index');
    Route::get('musumba-steel/ms-material-requisitions/choose', 'Backend\MusumbaSteel\MaterialRequisitionController@choose')->name('admin.ms-material-requisitions.choose');
    Route::get('musumba-steel/ms-material-requisitions/select-md-store', 'Backend\MusumbaSteel\MaterialRequisitionController@selectMdStore')->name('admin.ms-material-requisitions.selectMdStore');
    Route::get('musumba-steel/ms-material-requisitions/select-bg-store', 'Backend\MusumbaSteel\MaterialRequisitionController@selectBgStore')->name('admin.ms-material-requisitions.selectBgStore');
    Route::get('musumba-steel/ms-material-requisitions/create/{code}', 'Backend\MusumbaSteel\MaterialRequisitionController@create')->name('admin.ms-material-requisitions.create');
    Route::get('musumba-steel/ms-material-requisitions/createFromBig/{code}', 'Backend\MusumbaSteel\MaterialRequisitionController@createFromBig')->name('admin.ms-material-requisitions.createFromBig');
    Route::post('musumba-steel/ms-material-requisitions/store', 'Backend\MusumbaSteel\MaterialRequisitionController@store')->name('admin.ms-material-requisitions.store');
    Route::get('musumba-steel/ms-material-requisitions/edit/{requisition_no}', 'Backend\MusumbaSteel\MaterialRequisitionController@edit')->name('admin.ms-material-requisitions.edit');
    Route::put('musumba-steel/ms-material-requisitions/update/{requisition_no}', 'Backend\MusumbaSteel\MaterialRequisitionController@update')->name('admin.ms-material-requisitions.update');
    Route::delete('musumba-steel/admin.ms-material-requisitions/destroy/{requisition_no}', 'Backend\MusumbaSteel\MaterialRequisitionController@destroy')->name('admin.ms-material-requisitions.destroy');

    Route::get('musumba-steel/ms-material-requisitions/show/{requisition_no}', 'Backend\MusumbaSteel\MaterialRequisitionController@show')->name('admin.ms-material-requisitions.show');

    Route::get('musumba-steel/ms-material-requisitions/generatepdf/{requisition_no}','Backend\MusumbaSteel\MaterialRequisitionController@demande_requisition')->name('admin.ms-material-requisitions.generatepdf');
    Route::put('musumba-steel/ms-material-requisitions/validate/{requisition_no}', 'Backend\MusumbaSteel\MaterialRequisitionController@validateRequisition')->name('admin.ms-material-requisitions.validate');
    Route::put('musumba-steel/ms-material-requisitions/reject/{requisition_no}','Backend\MusumbaSteel\MaterialRequisitionController@reject')->name('admin.ms-material-requisitions.reject');
    Route::put('musumba-steel/ms-material-requisitions/reset/{requisition_no}','Backend\MusumbaSteel\MaterialRequisitionController@reset')->name('admin.ms-material-requisitions.reset');
    Route::put('musumba-steel/ms-material-requisitions/confirm/{requisition_no}','Backend\MusumbaSteel\MaterialRequisitionController@confirm')->name('admin.ms-material-requisitions.confirm');
    Route::put('musumba-steel/ms-material-requisitions/approuve/{requisition_no}','Backend\MusumbaSteel\MaterialRequisitionController@approuve')->name('admin.ms-material-requisitions.approuve');
    
    //material purchases routes
    Route::get('musumba-steel/ms-material-purchases/index', 'Backend\MusumbaSteel\MaterialPurchaseController@index')->name('admin.ms-material-purchases.index');
    Route::get('musumba-steel/ms-material-purchases/create', 'Backend\MusumbaSteel\MaterialPurchaseController@create')->name('admin.ms-material-purchases.create');
    Route::post('musumba-steel/ms-material-purchases/store', 'Backend\MusumbaSteel\MaterialPurchaseController@store')->name('admin.ms-material-purchases.store');
    Route::get('musumba-steel/ms-material-purchases/edit/{purchase_no}', 'Backend\MusumbaSteel\MaterialPurchaseController@edit')->name('admin.ms-material-purchases.edit');
    Route::put('musumba-steel/ms-material-purchases/update/{purchase_no}', 'Backend\MusumbaSteel\MaterialPurchaseController@update')->name('admin.ms-material-purchases.update');
    Route::delete('musumba-steel/ms-material-purchases/destroy/{purchase_no}', 'Backend\MusumbaSteel\MaterialPurchaseController@destroy')->name('admin.ms-material-purchases.destroy');
    Route::get('musumba-steel/ms-material-purchases/show/{purchase_no}','Backend\MusumbaSteel\MaterialPurchaseController@show')->name('admin.ms-material-purchases.show');

    Route::get('musumba-steel/ms-material-purchases/materialPurchase/{purchase_no}','Backend\MusumbaSteel\MaterialPurchaseController@materialPurchase')->name('admin.ms-material-purchases.materialPurchase');
    Route::put('musumba-steel/ms-material-purchases/validate/{purchase_no}', 'Backend\MusumbaSteel\MaterialPurchaseController@validatePurchase')->name('admin.ms-material-purchases.validate');
    Route::put('musumba-steel/ms-material-purchases/reject/{purchase_no}','Backend\MusumbaSteel\MaterialPurchaseController@reject')->name('admin.ms-material-purchases.reject');
    Route::put('musumba-steel/ms-material-purchases/reset/{purchase_no}','Backend\MusumbaSteel\MaterialPurchaseController@reset')->name('admin.ms-material-purchases.reset');
    Route::put('musumba-steel/ms-material-purchases/confirm/{purchase_no}','Backend\MusumbaSteel\MaterialPurchaseController@confirm')->name('admin.ms-material-purchases.confirm');
    Route::put('musumba-steel/ms-material-purchases/approuve/{purchase_no}','Backend\MusumbaSteel\MaterialPurchaseController@approuve')->name('admin.ms-material-purchases.approuve');

    //material supplier-orders routes
    Route::get('musumba-steel/ms-material-supplier-orders/index', 'Backend\MusumbaSteel\MaterialSupplierOrderController@index')->name('admin.ms-material-supplier-orders.index');
    Route::get('musumba-steel/ms-material-supplier-orders/create/{purchase_no}', 'Backend\MusumbaSteel\MaterialSupplierOrderController@create')->name('admin.ms-material-supplier-orders.create');
    Route::post('musumba-steel/ms-material-supplier-orders/store', 'Backend\MusumbaSteel\MaterialSupplierOrderController@store')->name('admin.ms-material-supplier-orders.store');
    Route::get('musumba-steel/ms-material-supplier-orders/edit/{order_no}', 'Backend\MusumbaSteel\MaterialSupplierOrderController@edit')->name('admin.ms-material-supplier-orders.edit');
    Route::put('musumba-steel/ms-material-supplier-orders/update/{order_no}', 'Backend\MusumbaSteel\MaterialSupplierOrderController@update')->name('admin.ms-material-supplier-orders.update');
    Route::delete('musumba-steel/ms-material-supplier-orders/destroy/{order_no}', 'Backend\MusumbaSteel\MaterialSupplierOrderController@destroy')->name('admin.ms-material-supplier-orders.destroy');
    Route::get('musumba-steel/ms-material-supplier-orders/show/{order_no}','Backend\MusumbaSteel\MaterialSupplierOrderController@show')->name('admin.ms-material-supplier-orders.show');

    Route::get('musumba-steel/ms-material-supplier-orders/materialSupplierOrder/{order_no}','Backend\MusumbaSteel\MaterialSupplierOrderController@materialSupplierOrder')->name('admin.ms-material-supplier-orders.materialSupplierOrder');
    Route::put('musumba-steel/ms-material-supplier-orders/validate/{order_no}', 'Backend\MusumbaSteel\MaterialSupplierOrderController@validateOrder')->name('admin.ms-material-supplier-orders.validate');
    Route::put('musumba-steel/ms-material-supplier-orders/reject/{order_no}','Backend\MusumbaSteel\MaterialSupplierOrderController@reject')->name('admin.ms-material-supplier-orders.reject');
    Route::put('musumba-steel/ms-material-supplier-orders/reset/{order_no}','Backend\MusumbaSteel\MaterialSupplierOrderController@reset')->name('admin.ms-material-supplier-orders.reset');
    Route::put('musumba-steel/ms-material-supplier-orders/confirm/{order_no}','Backend\MusumbaSteel\MaterialSupplierOrderController@confirm')->name('admin.ms-material-supplier-orders.confirm');
    Route::put('musumba-steel/ms-material-supplier-orders/approuve/{order_no}','Backend\MusumbaSteel\MaterialSupplierOrderController@approuve')->name('admin.ms-material-supplier-orders.approuve');

    //material receptions routes
    Route::get('musumba-steel/ms-material-receptions/index', 'Backend\MusumbaSteel\MaterialReceptionController@index')->name('admin.ms-material-receptions.index');
    Route::get('musumba-steel/ms-material-receptions/create/{order_no}', 'Backend\MusumbaSteel\MaterialReceptionController@create')->name('admin.ms-material-receptions.create');
    Route::get('musumba-steel/ms-material-reception-without-order/create/{purchase_no}', 'Backend\MusumbaSteel\MaterialReceptionController@createWithoutOrder')->name('admin.ms-material-reception-without-order.create');
    Route::post('musumba-steel/ms-material-receptions/store', 'Backend\MusumbaSteel\MaterialReceptionController@store')->name('admin.ms-material-receptions.store');
    Route::post('musumba-steel/ms-material-reception-without-order/store', 'Backend\MusumbaSteel\MaterialReceptionController@storeWithoutOrder')->name('admin.ms-material-reception-without-order.store');
    Route::get('musumba-steel/ms-material-receptions/edit/{reception_no}', 'Backend\MusumbaSteel\MaterialReceptionController@edit')->name('admin.ms-material-receptions.edit');
    Route::put('musumba-steel/ms-material-receptions/update/{reception_no}', 'Backend\MusumbaSteel\MaterialReceptionController@update')->name('admin.ms-material-receptions.update');
    Route::delete('musumba-steel/ms-material-receptions/destroy/{reception_no}', 'Backend\MusumbaSteel\MaterialReceptionController@destroy')->name('admin.ms-material-receptions.destroy');
    Route::get('musumba-steel/ms-material-receptions/show/{reception_no}','Backend\MusumbaSteel\MaterialReceptionController@show')->name('admin.ms-material-receptions.show');

    Route::get('musumba-steel/ms-material-receptions/fiche_reception/{reception_no}','Backend\MusumbaSteel\MaterialReceptionController@fiche_reception')->name('admin.ms-material-receptions.fiche_reception');
    Route::put('musumba-steel/ms-material-receptions/validate/{reception_no}', 'Backend\MusumbaSteel\MaterialReceptionController@validateReception')->name('admin.ms-material-receptions.validate');
    Route::put('musumba-steel/ms-material-receptions/reject/{reception_no}','Backend\MusumbaSteel\MaterialReceptionController@reject')->name('admin.ms-material-receptions.reject');
    Route::put('musumba-steel/ms-material-receptions/reset/{reception_no}','Backend\MusumbaSteel\MaterialReceptionController@reset')->name('admin.ms-material-receptions.reset');
    Route::put('musumba-steel/ms-material-receptions/confirm/{reception_no}','Backend\MusumbaSteel\MaterialReceptionController@confirm')->name('admin.ms-material-receptions.confirm');
    Route::put('musumba-steel/ms-material-receptions/approuve/{reception_no}','Backend\MusumbaSteel\MaterialReceptionController@approuve')->name('admin.ms-material-receptions.approuve');

    //material stockins routes
    Route::get('musumba-steel/ms-material-stockins/index', 'Backend\MusumbaSteel\MaterialStockinController@index')->name('admin.ms-material-stockins.index');

    Route::get('musumba-steel/ms-material-stockins/create', 'Backend\MusumbaSteel\MaterialStockinController@create')->name('admin.ms-material-stockins.create');
    Route::post('musumba-steel/ms-material-stockins/store', 'Backend\MusumbaSteel\MaterialStockinController@store')->name('admin.ms-material-stockins.store');
    Route::get('musumba-steel/ms-material-stockins/edit/{stockin_no}', 'Backend\MusumbaSteel\MaterialStockinController@edit')->name('admin.ms-material-stockins.edit');
    Route::put('musumba-steel/ms-material-stockins/update/{stockin_no}', 'Backend\MusumbaSteel\MaterialStockinController@update')->name('admin.ms-material-stockins.update');
    Route::delete('musumba-steel/ms-material-stockins/destroy/{stockin_no}', 'Backend\MusumbaSteel\MaterialStockinController@destroy')->name('admin.ms-material-stockins.destroy');
    Route::get('musumba-steel/ms-material-stockins/show/{stockin_no}','Backend\MusumbaSteel\MaterialStockinController@show')->name('admin.ms-material-stockins.show');

    Route::get('musumba-steel/ms-material-stockins/bonEntree/{stockin_no}','Backend\MusumbaSteel\MaterialStockinController@bonEntree')->name('admin.ms-material-stockins.bonEntree');
    Route::put('musumba-steel/ms-material-stockins/validate/{stockin_no}', 'Backend\MusumbaSteel\MaterialStockinController@validateStockin')->name('admin.ms-material-stockins.validate');
    Route::put('musumba-steel/ms-material-stockins/reject/{stockin_no}','Backend\MusumbaSteel\MaterialStockinController@reject')->name('admin.ms-material-stockins.reject');
    Route::put('musumba-steel/ms-material-stockins/reset/{stockin_no}','Backend\MusumbaSteel\MaterialStockinController@reset')->name('admin.ms-material-stockins.reset');
    Route::put('musumba-steel/ms-material-stockins/confirm/{stockin_no}','Backend\MusumbaSteel\MaterialStockinController@confirm')->name('admin.ms-material-stockins.confirm');
    Route::put('musumba-steel/ms-material-stockins/approuve/{stockin_no}','Backend\MusumbaSteel\MaterialStockinController@approuve')->name('admin.ms-material-stockins.approuve');


    //material stockouts routes
    Route::get('musumba-steel/ms-material-stockouts/index', 'Backend\MusumbaSteel\MaterialStockoutController@index')->name('admin.ms-material-stockouts.index');
    Route::get('musumba-steel/ms-material-stockouts/create', 'Backend\MusumbaSteel\MaterialStockoutController@create')->name('admin.ms-material-stockouts.create');
    Route::post('musumba-steel/ms-material-stockouts/store', 'Backend\MusumbaSteel\MaterialStockoutController@store')->name('admin.ms-material-stockouts.store');
    Route::get('musumba-steel/ms-material-stockouts/edit/{stockout_no}', 'Backend\MusumbaSteel\MaterialStockoutController@edit')->name('admin.ms-material-stockouts.edit');
    Route::put('musumba-steel/ms-material-stockouts/update/{stockout_no}', 'Backend\MusumbaSteel\MaterialStockoutController@update')->name('admin.ms-material-stockouts.update');
    Route::delete('musumba-steel/ms-material-stockouts/destroy/{stockout_no}', 'Backend\MusumbaSteel\MaterialStockoutController@destroy')->name('admin.ms-material-stockouts.destroy');
    Route::get('musumba-steel/ms-material-stockouts/show/{stockout_no}','Backend\MusumbaSteel\MaterialStockoutController@show')->name('admin.ms-material-stockouts.show');

    Route::get('musumba-steel/ms-material-stockouts/bonSortie/{stockout_no}','Backend\MusumbaSteel\MaterialStockoutController@bonSortie')->name('admin.ms-material-stockouts.bonSortie');
    Route::put('musumba-steel/ms-material-stockouts/validate/{stockout_no}', 'Backend\MusumbaSteel\MaterialStockoutController@validateStockout')->name('admin.ms-material-stockouts.validate');
    Route::put('musumba-steel/ms-material-stockouts/reject/{stockout_no}','Backend\MusumbaSteel\MaterialStockoutController@reject')->name('admin.ms-material-stockouts.reject');
    Route::put('musumba-steel/ms-material-stockouts/reset/{stockout_no}','Backend\MusumbaSteel\MaterialStockoutController@reset')->name('admin.ms-material-stockouts.reset');
    Route::put('musumba-steel/ms-material-stockouts/confirm/{stockout_no}','Backend\MusumbaSteel\MaterialStockoutController@confirm')->name('admin.ms-material-stockouts.confirm');
    Route::put('musumba-steel/ms-material-stockouts/approuve/{stockout_no}','Backend\MusumbaSteel\MaterialStockoutController@approuve')->name('admin.ms-material-stockouts.approuve');

    //musumba-material big store report routes
    Route::get('musumba-steel/ms-material-store-report/index','Backend\MusumbaSteel\MaterialBgStoreReportController@index')->name('admin.ms-material-store-report.index');
    Route::get('musumba-steel/ms-material-store-report/export-to-pdf','Backend\MusumbaSteel\MaterialBgStoreReportController@exportToPdf')->name('admin.ms-material-store-report.export-to-pdf');
    Route::get('musumba-steel/ms-material-store-report/export-to-excel','Backend\MusumbaSteel\MaterialBgStoreReportController@exportToExcel')->name('admin.ms-material-store-report.export-to-excel');
    //les routes pour la gestion du stock carburant

    //drivers routes
    Route::get('ms-drivers/index', 'Backend\MusumbaSteel\DriverController@index')->name('admin.ms-drivers.index');
    Route::get('ms-drivers/create', 'Backend\MusumbaSteel\DriverController@create')->name('admin.ms-drivers.create');
    Route::post('ms-drivers/store', 'Backend\MusumbaSteel\DriverController@store')->name('admin.ms-drivers.store');
    Route::get('ms-drivers/edit/{id}', 'Backend\MusumbaSteel\DriverController@edit')->name('admin.ms-drivers.edit');
    Route::put('ms-drivers/update/{id}', 'Backend\MusumbaSteel\DriverController@update')->name('admin.ms-drivers.update');
    Route::delete('ms-drivers/destroy/{id}', 'Backend\MusumbaSteel\DriverController@destroy')->name('admin.ms-drivers.destroy');

    //suppliers routes
    Route::get('ms-fuel-suppliers/index', 'Backend\MusumbaSteel\FuelSupplierController@index')->name('admin.ms-fuel-suppliers.index');
    Route::get('ms-fuel-suppliers/create', 'Backend\MusumbaSteel\FuelSupplierController@create')->name('admin.ms-fuel-suppliers.create');
    Route::post('ms-fuel-suppliers/store', 'Backend\MusumbaSteel\FuelSupplierController@store')->name('admin.ms-fuel-suppliers.store');
    Route::get('ms-fuel-suppliers/edit/{id}', 'Backend\MusumbaSteel\FuelSupplierController@edit')->name('admin.ms-fuel-suppliers.edit');
    Route::put('ms-fuel-suppliers/update/{id}', 'Backend\MusumbaSteel\FuelSupplierController@update')->name('admin.ms-fuel-suppliers.update');
    Route::delete('ms-fuel-suppliers/destroy/{id}', 'Backend\MusumbaSteel\FuelSupplierController@destroy')->name('admin.ms-fuel-suppliers.destroy');

    //suppliers routes
    Route::get('ms-material-suppliers/index', 'Backend\MusumbaSteel\MaterialSupplierController@index')->name('admin.ms-material-suppliers.index');
    Route::get('ms-material-suppliers/create', 'Backend\MusumbaSteel\MaterialSupplierController@create')->name('admin.ms-material-suppliers.create');
    Route::post('ms-material-suppliers/store', 'Backend\MusumbaSteel\MaterialSupplierController@store')->name('admin.ms-material-suppliers.store');
    Route::get('ms-material-suppliers/edit/{id}', 'Backend\MusumbaSteel\MaterialSupplierController@edit')->name('admin.ms-material-suppliers.edit');
    Route::put('ms-material-suppliers/update/{id}', 'Backend\MusumbaSteel\MaterialSupplierController@update')->name('admin.ms-material-suppliers.update');
    Route::delete('ms-material-suppliers/destroy/{id}', 'Backend\MusumbaSteel\MaterialSupplierController@destroy')->name('admin.ms-material-suppliers.destroy');


    //cars routes
    Route::get('ms-cars/index', 'Backend\MusumbaSteel\CarController@index')->name('admin.ms-cars.index');
    Route::get('ms-cars/create', 'Backend\MusumbaSteel\CarController@create')->name('admin.ms-cars.create');
    Route::post('ms-cars/store', 'Backend\MusumbaSteel\CarController@store')->name('admin.ms-cars.store');
    Route::get('ms-cars/edit/{id}', 'Backend\MusumbaSteel\CarController@edit')->name('admin.ms-cars.edit');
    Route::put('ms-cars/update/{id}', 'Backend\MusumbaSteel\CarController@update')->name('admin.ms-cars.update');
    Route::delete('ms-cars/destroy/{id}', 'Backend\MusumbaSteel\CarController@destroy')->name('admin.ms-cars.destroy');

    //ms-driver-cars routes
    Route::get('ms-driver-cars/index', 'Backend\MusumbaSteel\DriverCarController@index')->name('admin.ms-driver-cars.index');
    Route::get('ms-driver-cars/create', 'Backend\MusumbaSteel\DriverCarController@create')->name('admin.ms-driver-cars.create');
    Route::post('ms-driver-cars/store', 'Backend\MusumbaSteel\DriverCarController@store')->name('admin.ms-driver-cars.store');
    Route::get('ms-driver-cars/edit/{id}', 'Backend\MusumbaSteel\DriverCarController@edit')->name('admin.ms-driver-cars.edit');
    Route::put('ms-driver-cars/update/{id}', 'Backend\MusumbaSteel\DriverCarController@update')->name('admin.ms-driver-cars.update');
    Route::delete('ms-driver-cars/destroy/{id}', 'Backend\MusumbaSteel\DriverCarController@destroy')->name('admin.ms-driver-cars.destroy');
    Route::get('ms-driver-cars/exportTopdf', 'Backend\MusumbaSteel\DriverCarController@exportTopdf')->name('admin.ms-driver-cars.exportTopdf');

    //fuel pumps routes
    Route::get('musumba-steel/stock-fuels/ms-fuel-pumps/index', 'Backend\MusumbaSteel\FuelPumpController@index')->name('admin.ms-fuel-pumps.index');
    Route::get('musumba-steel/stock-fuels/ms-fuel-pumps/create', 'Backend\MusumbaSteel\FuelPumpController@create')->name('admin.ms-fuel-pumps.create');
    Route::post('musumba-steel/stock-fuels/ms-fuel-pumps/store', 'Backend\MusumbaSteel\FuelPumpController@store')->name('admin.ms-fuel-pumps.store');
    Route::get('musumba-steel/stock-fuels/ms-fuel-pumps/edit/{id}', 'Backend\MusumbaSteel\FuelPumpController@edit')->name('admin.ms-fuel-pumps.edit');
    Route::put('musumba-steel/stock-fuels/ms-fuel-pumps/update/{id}', 'Backend\MusumbaSteel\FuelPumpController@update')->name('admin.ms-fuel-pumps.update');
    Route::delete('musumba-steel/stock-fuels/stocks/destroy/{id}', 'Backend\MusumbaSteel\FuelPumpController@destroy')->name('admin.ms-fuel-pumps.destroy');
    Route::get('musumba-steel/stock-fuels/ms-fuel-pumps-statement_of_needs/need', 'Backend\MusumbaSteel\FuelPumpController@need')->name('admin.fuel_pump_statement_of_needs.need');
    Route::get('musumba-steel/stock-fuels/ms-fuel-pumps-exportTopdf', 'Backend\MusumbaSteel\FuelPumpController@exportTopdf')->name('admin.ms-fuel-pumps.exportTopdf');

    //suppliers routes
    Route::get('ms-fuel-suppliers/index', 'Backend\MusumbaSteel\FuelSupplierController@index')->name('admin.ms-fuel-suppliers.index');
    Route::get('ms-fuel-suppliers/create', 'Backend\MusumbaSteel\FuelSupplierController@create')->name('admin.ms-fuel-suppliers.create');
    Route::post('ms-fuel-suppliers/store', 'Backend\MusumbaSteel\FuelSupplierController@store')->name('admin.ms-fuel-suppliers.store');
    Route::get('ms-fuel-suppliers/edit/{id}', 'Backend\MusumbaSteel\FuelSupplierController@edit')->name('admin.ms-fuel-suppliers.edit');
    Route::put('ms-fuel-suppliers/update/{id}', 'Backend\MusumbaSteel\FuelSupplierController@update')->name('admin.ms-fuel-suppliers.update');
    Route::delete('ms-fuel-suppliers/destroy/{id}', 'Backend\MusumbaSteel\FuelSupplierController@destroy')->name('admin.ms-fuel-suppliers.destroy');


    //fuels routes
    Route::get('musumba-steel/stock-fuels/fuels/index', 'Backend\MusumbaSteel\FuelController@index')->name('admin.ms-fuels.index');
    Route::get('musumba-steel/stock-fuels/fuels/create', 'Backend\MusumbaSteel\FuelController@create')->name('admin.ms-fuels.create');
    Route::post('musumba-steel/stock-fuels/fuels/store', 'Backend\MusumbaSteel\FuelController@store')->name('admin.ms-fuels.store');
    Route::get('musumba-steel/stock-fuels/fuels/edit/{id}', 'Backend\MusumbaSteel\FuelController@edit')->name('admin.ms-fuels.edit');
    Route::put('musumba-steel/stock-fuels/fuels/update/{id}', 'Backend\MusumbaSteel\FuelController@update')->name('admin.ms-fuels.update');
    Route::delete('musumba-steel/stock-fuels/fuels/destroy/{id}', 'Backend\MusumbaSteel\FuelController@destroy')->name('admin.ms-fuels.destroy');

    //fuel_index_pumps routes
    Route::get('musumba-steel/stock-fuels/fuel_index_pumps/index', 'Backend\MusumbaSteel\FuelIndexPumpController@index')->name('admin.ms-fuel-index-pumps.index');
    Route::get('musumba-steel/stock-fuels/fuel_index_pumps/create', 'Backend\MusumbaSteel\FuelIndexPumpController@create')->name('admin.ms-fuel-index-pumps.create');
    Route::post('musumba-steel/stock-fuels/fuel_index_pumps/store', 'Backend\MusumbaSteel\FuelIndexPumpController@store')->name('admin.ms-fuel-index-pumps.store');
    Route::get('musumba-steel/stock-fuels/fuel_index_pumps/edit/{id}', 'Backend\MusumbaSteel\FuelIndexPumpController@edit')->name('admin.ms-fuel-index-pumps.edit');
    Route::put('musumba-steel/stock-fuels/fuel_index_pumps/update/{id}', 'Backend\MusumbaSteel\FuelIndexPumpController@update')->name('admin.ms-fuel-index-pumps.update');
    Route::delete('musumba-steel/stock-fuels/fuel_index_pumps/destroy/{id}', 'Backend\MusumbaSteel\FuelIndexPumpController@destroy')->name('admin.ms-fuel-index-pumps.destroy');

    //fuel_purchases routes
    Route::get('musumba-steel/stock-fuels/fuel_purchases/index', 'Backend\MusumbaSteel\FuelPurchaseController@index')->name('admin.ms-fuel-purchases.index');
    Route::get('musumba-steel/stock-fuels/fuel_purchases/create', 'Backend\MusumbaSteel\FuelPurchaseController@create')->name('admin.ms-fuel-purchases.create');
    Route::post('musumba-steel/stock-fuels/fuel_purchases/store', 'Backend\MusumbaSteel\FuelPurchaseController@store')->name('admin.ms-fuel-purchases.store');
    Route::get('musumba-steel/stock-fuels/fuel_purchases/edit/{requisition_no}', 'Backend\MusumbaSteel\FuelPurchaseController@edit')->name('admin.ms-fuel-purchases.edit');
    Route::put('musumba-steel/stock-fuels/fuel_purchases/update/{requisition_no}', 'Backend\MusumbaSteel\FuelPurchaseController@update')->name('admin.ms-fuel-purchases.update');
    Route::delete('musumba-steel/stock-fuels/fuel_purchases/destroy/{requisition_no}', 'Backend\MusumbaSteel\FuelPurchaseController@destroy')->name('admin.ms-fuel-purchases.destroy');
    Route::get('musumba-steel/stock-fuels/fuel_purchase/show/{requisition_no}','Backend\MusumbaSteel\FuelPurchaseController@show')->name('admin.ms-fuel-purchases.show');

    Route::get('musumba-steel/ms-fuel-purchases/fuelPurchase/{purchase_no}','Backend\MusumbaSteel\FuelPurchaseController@fuelPurchase')->name('admin.ms-fuel-purchases.fuelPurchase');
    Route::put('musumba-steel/ms-fuel-purchases/validate/{purchase_no}', 'Backend\MusumbaSteel\FuelPurchaseController@validatePurchase')->name('admin.ms-fuel-purchases.validate');
    Route::put('musumba-steel/ms-fuel-purchases/reject/{purchase_no}','Backend\MusumbaSteel\FuelPurchaseController@reject')->name('admin.ms-fuel-purchases.reject');
    Route::put('musumba-steel/ms-fuel-purchases/reset/{purchase_no}','Backend\MusumbaSteel\FuelPurchaseController@reset')->name('admin.ms-fuel-purchases.reset');
    Route::put('musumba-steel/ms-fuel-purchases/confirm/{purchase_no}','Backend\MusumbaSteel\FuelPurchaseController@confirm')->name('admin.ms-fuel-purchases.confirm');
    Route::put('musumba-steel/ms-fuel-purchases/approuve/{purchase_no}','Backend\MusumbaSteel\FuelPurchaseController@approuve')->name('admin.ms-fuel-purchases.approuve');

    //fuel_requisitions routes
    Route::get('musumba-steel/stock-fuels/fuel_requisitions/index', 'Backend\MusumbaSteel\FuelRequisitionController@index')->name('admin.ms-fuel-requisitions.index');
    Route::get('musumba-steel/stock-fuels/fuel_requisitions/create', 'Backend\MusumbaSteel\FuelRequisitionController@create')->name('admin.ms-fuel-requisitions.create');
    Route::post('musumba-steel/stock-fuels/fuel_requisitions/store', 'Backend\MusumbaSteel\FuelRequisitionController@store')->name('admin.ms-fuel-requisitions.store');
    Route::put('musumba-steel/stock-fuels/fuel_requisitions/reject/{requisition_no}', 'Backend\MusumbaSteel\FuelRequisitionController@reject')->name('admin.ms-fuel-requisitions.reject');
    Route::put('musumba-steel/stock-fuels/fuel_requisitions/validate/{requisition_no}', 'Backend\MusumbaSteel\FuelRequisitionController@validateRequisition')->name('admin.ms-fuel-requisitions.validate');
    Route::put('musumba-steel/stock-fuels/fuel_requisitions/reset/{requisition_no}', 'Backend\MusumbaSteel\FuelRequisitionController@reset')->name('admin.ms-fuel-requisitions.reset');
    Route::put('musumba-steel/stock-fuels/fuel_requisitions/confirm/{requisition_no}', 'Backend\MusumbaSteel\FuelRequisitionController@confirm')->name('admin.ms-fuel-requisitions.confirm');
    Route::put('musumba-steel/stock-fuels/fuel_requisitions/approuve/{requisition_no}', 'Backend\MusumbaSteel\FuelRequisitionController@approuve')->name('admin.ms-fuel-requisitions.approuve');
    Route::delete('musumba-steel/stock-fuels/fuel_requisitions/destroy/{requisition_no}', 'Backend\MusumbaSteel\FuelRequisitionController@destroy')->name('admin.ms-fuel-requisitions.destroy');
    Route::get('musumba-steel/stock-fuels/fuel_requisitions/show/{requisition_no}','Backend\MusumbaSteel\FuelRequisitionController@show')->name('admin.ms-fuel-requisitions.show');
    Route::get('musumba-steel/stock-fuels/fuel_requisitions/bonRequisition/{requisition_no}','Backend\MusumbaSteel\FuelRequisitionController@bonRequisition')->name('admin.ms-fuel-requisitions.bonRequisition');

    //fuel stockouts routes
    Route::get('musumba-steel/stock-fuels/fuel_stockouts/index', 'Backend\MusumbaSteel\FuelStockoutController@index')->name('admin.ms-fuel-stockouts.index');
    Route::get('musumba-steel/stock-fuels/fuel_stockouts/create/{requisition_no}', 'Backend\MusumbaSteel\FuelStockoutController@create')->name('admin.ms-fuel-stockouts.create');
    Route::post('musumba-steel/stock-fuels/fuel_stockouts/store', 'Backend\MusumbaSteel\FuelStockoutController@store')->name('admin.ms-fuel-stockouts.store');
    Route::delete('musumba-steel/stock-fuels/fuel_stockouts/destroy/{id}', 'Backend\MusumbaSteel\FuelStockoutController@destroy')->name('admin.ms-fuel-stockouts.destroy');
    Route::get('musumba-steel/stock-fuels/fuel_stockouts/show/{stockout_no}','Backend\MusumbaSteel\FuelStockoutController@show')->name('admin.ms-fuel-stockouts.show');

    Route::get('musumba-steel/stock-fuels/fuel_stockouts/bon_sortie/{stockout_no}','Backend\MusumbaSteel\FuelStockoutController@bon_sortie')->name('admin.ms-fuel-stockouts.bon_sortie');
    Route::put('musumba-steel/stock-fuels/fuel_stockouts/validate/{stockout_no}', 'Backend\MusumbaSteel\FuelStockoutController@validateStockout')->name('admin.ms-fuel-stockouts.validate');
    Route::put('musumba-steel/stock-fuels/fuel_stockouts/reject/{stockout_no}','Backend\MusumbaSteel\FuelStockoutController@reject')->name('admin.ms-fuel-stockouts.reject');
    Route::put('musumba-steel/stock-fuels/fuel_stockouts/reset/{stockout_no}','Backend\MusumbaSteel\FuelStockoutController@reset')->name('admin.ms-fuel-stockouts.reset');
    Route::put('musumba-steel/stock-fuels/fuel_stockouts/confirm/{stockout_no}','Backend\MusumbaSteel\FuelStockoutController@confirm')->name('admin.ms-fuel-stockouts.confirm');
    Route::put('musumba-steel/stock-fuels/fuel_stockouts/approuve/{stockout_no}','Backend\MusumbaSteel\FuelStockoutController@approuve')->name('admin.ms-fuel-stockouts.approuve');
    Route::put('musumba-steel/stock-fuels/fuel_stockouts/stockout/{stockout_no}','Backend\MusumbaSteel\FuelStockoutController@stockout')->name('admin.ms-fuel-stockouts.stockout');
    Route::get('musumba-steel/stock-fuels/fuel_stockouts/exportTopdf', 'Backend\MusumbaSteel\FuelStockoutController@exportTopdf')->name('admin.ms-fuel-stockouts.exportTopdf');


    //fuel stockins routes
    Route::get('musumba-steel/stock-fuels/fuel_stockins/index', 'Backend\MusumbaSteel\FuelStockinController@index')->name('admin.ms-fuel-stockins.index');
    Route::get('musumba-steel/stock-fuels/fuel_stockins/create', 'Backend\MusumbaSteel\FuelStockinController@create')->name('admin.ms-fuel-stockins.create');
    Route::post('musumba-steel/stock-fuels/fuel_stockins/store', 'Backend\MusumbaSteel\FuelStockinController@store')->name('admin.ms-fuel-stockins.store');
    Route::delete('musumba-steel/stock-fuels/fuel_stockins/destroy/{stockin_no}', 'Backend\MusumbaSteel\FuelStockinController@destroy')->name('admin.ms-fuel-stockins.destroy');
    Route::get('musumba-steel/stock-fuels/fuel_stockins/show/{stockin_no}','Backend\MusumbaSteel\FuelStockinController@show')->name('admin.ms-fuel-stockins.show');

    Route::get('musumba-steel/stock-fuels/fuel_stockins/bon_entree/{stockin_no}','Backend\MusumbaSteel\FuelStockinController@bon_entree')->name('admin.ms-fuel-stockins.bon_entree');
    Route::put('musumba-steel/stock-fuels/fuel_stockins/validate/{stockin_no}', 'Backend\MusumbaSteel\FuelStockinController@validateStockin')->name('admin.ms-fuel-stockins.validate');
    Route::put('musumba-steel/stock-fuels/fuel_stockins/reject/{stockin_no}','Backend\MusumbaSteel\FuelStockinController@reject')->name('admin.ms-fuel-stockins.reject');
    Route::put('musumba-steel/stock-fuels/fuel_stockins/reset/{stockin_no}','Backend\MusumbaSteel\FuelStockinController@reset')->name('admin.ms-fuel-stockins.reset');
    Route::put('musumba-steel/stock-fuels/fuel_stockins/confirm/{stockin_no}','Backend\MusumbaSteel\FuelStockinController@confirm')->name('admin.ms-fuel-stockins.confirm');
    Route::put('musumba-steel/stock-fuels/fuel_stockins/approuve/{stockin_no}','Backend\MusumbaSteel\FuelStockinController@approuve')->name('admin.ms-fuel-stockins.approuve');
    Route::get('musumba-steel/stock-fuels/fuel_stockins/exportTopdf', 'Backend\MusumbaSteel\FuelStockinController@exportTopdf')->name('admin.ms-fuel-stockins.exportTopdf');



    //fuel reception routes
    Route::get('musumba-steel/stock-fuels/reception/index', 'Backend\MusumbaSteel\FuelReceptionController@index')->name('admin.ms-fuel-receptions.index');
    Route::get('musumba-steel/ms-fuel-receptions/create/{order_no}', 'Backend\MusumbaSteel\FuelReceptionController@create')->name('admin.ms-fuel-receptions.create');
    Route::get('musumba-steel/ms-fuel-reception-without-order/create/{purchase_no}', 'Backend\MusumbaSteel\FuelReceptionController@createWithoutOrder')->name('admin.ms-fuel-reception-without-order.create');
    Route::post('musumba-steel/stock-fuels/reception/store', 'Backend\MusumbaSteel\FuelReceptionController@store')->name('admin.ms-fuel-receptions.store');
    Route::post('musumba-steel/stock-fuels/reception-without-order/store', 'Backend\MusumbaSteel\FuelReceptionController@storeWithoutOrder')->name('admin.ms-fuel-reception-without-order.store');
    Route::get('musumba-steel/stock-fuels/reception/edit/{id}', 'Backend\MusumbaSteel\FuelReceptionController@edit')->name('admin.ms-fuel-receptions.edit');
    Route::put('musumba-steel/stock-fuels/reception/update/{id}', 'Backend\MusumbaSteel\FuelReceptionController@update')->name('admin.ms-fuel-receptions.update');
    Route::delete('musumba-steel/stock-fuels/reception/destroy/{id}', 'Backend\MusumbaSteel\FuelReceptionController@destroy')->name('admin.ms-fuel-receptions.destroy');
    Route::get('musumba-steel/stock-fuels/reception/show/{reception_no}','Backend\MusumbaSteel\FuelReceptionController@show')->name('admin.ms-fuel-receptions.show');

    Route::get('musumba-steel/stock-fuels/reception/fiche_reception/{reception_no}','Backend\MusumbaSteel\FuelReceptionController@fiche_reception')->name('admin.ms-fuel-receptions.fiche_reception');
    Route::put('musumba-steel/stock-fuels/reception/validate/{reception_no}', 'Backend\MusumbaSteel\FuelReceptionController@validateReception')->name('admin.ms-fuel-receptions.validate');
    Route::put('musumba-steel/stock-fuels/reception/reject/{reception_no}','Backend\MusumbaSteel\FuelReceptionController@reject')->name('admin.ms-fuel-receptions.reject');
    Route::put('musumba-steel/stock-fuels/reception/reset/{reception_no}','Backend\MusumbaSteel\FuelReceptionController@reset')->name('admin.ms-fuel-receptions.reset');
    Route::put('musumba-steel/stock-fuels/reception/confirm/{reception_no}','Backend\MusumbaSteel\FuelReceptionController@confirm')->name('admin.ms-fuel-receptions.confirm');
    Route::put('musumba-steel/stock-fuels/reception/approuve/{reception_no}','Backend\MusumbaSteel\FuelReceptionController@approuve')->name('admin.ms-fuel-receptions.approuve');
    Route::put('musumba-steel/stock-fuels/reception/reception/{reception_no}','Backend\MusumbaSteel\FuelReceptionController@reception')->name('admin.ms-fuel-receptions.reception');
    Route::get('musumba-steel/stock-fuels/reception/exportTopdf', 'Backend\MusumbaSteel\FuelReceptionController@exportTopdf')->name('admin.ms-fuel-receptions.exportTopdf');

    //fuel_orders routes
    Route::get('musumba-steel/stock-fuels/ms-supplier-orders/index', 'Backend\MusumbaSteel\FuelSupplierOrderController@index')->name('admin.ms-fuel-supplier-orders.index');
    Route::get('musumba-steel/stock-fuels/ms-supplier-orders/create/{purchase_no}', 'Backend\MusumbaSteel\FuelSupplierOrderController@create')->name('admin.ms-fuel-supplier-orders.create');
    Route::post('musumba-steel/stock-fuels/ms-supplier-orders/store', 'Backend\MusumbaSteel\FuelSupplierOrderController@store')->name('admin.ms-fuel-supplier-orders.store');
    Route::get('musumba-steel/stock-fuels/ms-supplier-orders/edit/{order_no}', 'Backend\MusumbaSteel\FuelSupplierOrderController@edit')->name('admin.ms-fuel-supplier-orders.edit');
    Route::put('musumba-steel/stock-fuels/ms-supplier-orders/update/{order_no}', 'Backend\MusumbaSteel\FuelSupplierOrderController@update')->name('admin.ms-fuel-supplier-orders.update');
    Route::delete('musumba-steel/stock-fuels/supplier_requisitions/destroy/{order_no}', 'Backend\MusumbaSteel\FuelSupplierOrderController@destroy')->name('admin.ms-fuel-supplier-orders.destroy');

    Route::get('musumba-steel/stock-fuels/ms-supplier-orders/show/{order_no}', 'Backend\MusumbaSteel\FuelSupplierOrderController@show')->name('admin.ms-fuel-supplier-orders.show');

    Route::get('musumba-steel/ms-fuel-supplier-orders/fuelSupplierOrder/{order_no}','Backend\MusumbaSteel\FuelSupplierOrderController@fuelSupplierOrder')->name('admin.ms-fuel-supplier-orders.fuelSupplierOrder');
    Route::put('musumba-steel/ms-fuel-supplier-orders/validate/{order_no}', 'Backend\MusumbaSteel\FuelSupplierOrderController@validateOrder')->name('admin.ms-fuel-supplier-orders.validate');
    Route::put('musumba-steel/ms-fuel-supplier-orders/reject/{order_no}','Backend\MusumbaSteel\FuelSupplierOrderController@reject')->name('admin.ms-fuel-supplier-orders.reject');
    Route::put('musumba-steel/ms-fuel-supplier-orders/reset/{order_no}','Backend\MusumbaSteel\FuelSupplierOrderController@reset')->name('admin.ms-fuel-supplier-orders.reset');
    Route::put('musumba-steel/ms-fuel-supplier-orders/confirm/{order_no}','Backend\MusumbaSteel\FuelSupplierOrderController@confirm')->name('admin.ms-fuel-supplier-orders.confirm');
    Route::put('musumba-steel/ms-fuel-supplier-orders/approuve/{order_no}','Backend\MusumbaSteel\FuelSupplierOrderController@approuve')->name('admin.ms-fuel-supplier-orders.approuve');


    //fuel inventories routes
    Route::get('musumba-steel/stock-fuels/ms-fuel-inventories/index', 'Backend\MusumbaSteel\FuelInventoryController@index')->name('admin.ms-fuel-inventories.index');
    Route::get('musumba-steel/stock-fuels/ms-fuel-inventories/create', 'Backend\MusumbaSteel\FuelInventoryController@create')->name('admin.ms-fuel-inventories.create');
    Route::post('musumba-steel/stock-fuels/ms-fuel-inventories/store', 'Backend\MusumbaSteel\FuelInventoryController@store')->name('admin.ms-fuel-inventories.store');
    Route::get('musumba-steel/stock-fuels/ms-fuel-inventories/inventory/{id}', 'Backend\MusumbaSteel\FuelInventoryController@inventory')->name('admin.ms-fuel-inventories.inventory');
    Route::get('musumba-steel/stock-fuels/ms-fuel-inventories/edit/{bon_no}', 'Backend\MusumbaSteel\FuelInventoryController@edit')->name('admin.ms-fuel-inventories.edit');
    Route::get('musumba-steel/stock-fuels/ms-fuel-inventories/show/{bon_no}', 'Backend\MusumbaSteel\FuelInventoryController@show')->name('admin.ms-fuel-inventories.show');
    Route::put('musumba-steel/stock-fuels/ms-fuel-inventories/update/{id}', 'Backend\MusumbaSteel\FuelInventoryController@update')->name('admin.ms-fuel-inventories.update');
    Route::delete('musumba-steel/stock-fuels/ms-fuel-inventories/destroy/{id}', 'Backend\MusumbaSteel\FuelInventoryController@destroy')->name('admin.ms-fuel-inventories.destroy');

    Route::get('musumba-steel/stock-fuels/ms-fuel-inventories/generatePdf/{bon_no}','Backend\MusumbaSteel\FuelInventoryController@bon_inventaire')->name('admin.ms-fuel-inventories.generatePdf');
    Route::put('musumba-steel/stock-fuels/ms-fuel-inventories/validate/{bon_no}','Backend\MusumbaSteel\FuelInventoryController@validateInventory')->name('admin.ms-fuel-inventories.validate');
    Route::put('musumba-steel/stock-fuels/ms-fuel-inventories/reject/{bon_no}','Backend\MusumbaSteel\FuelInventoryController@rejectInventory')->name('admin.ms-fuel-inventories.reject');
    Route::put('musumba-steel/stock-fuels/ms-fuel-inventories/reset/{bon_no}','Backend\MusumbaSteel\FuelInventoryController@resetInventory')->name('admin.ms-fuel-inventories.reset');
    Route::get('musumba-steel/stock-fuels/ms-fuel-inventories/exportTopdf', 'Backend\MusumbaSteel\FuelInventoryController@exportTopdf')->name('admin.ms-fuel-inventories.exportTopdf');

    Route::get('musumba-steel/stock-fuels/ms-fuel-report/index', 'Backend\MusumbaSteel\FuelReportController@index')->name('admin.ms-fuel-report.index');
    Route::get('musumba-steel/stock-fuels/ms-fuel-report/export-to-pdf', 'Backend\MusumbaSteel\FuelReportController@exportTopdf')->name('admin.ms-fuel-report.export-to-pdf');
    Route::get('musumba-steel/stock-fuels/ms-fuel-report/export-to-excel', 'Backend\MusumbaSteel\FuelReportController@exportToExcel')->name('admin.ms-fuel-report.export-to-excel');

    Route::get('/404/muradutunge/ivyomwasavye-ntibishoboye-kuboneka',function(){
        return view('errors.404');


    });
});
