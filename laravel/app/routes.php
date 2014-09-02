<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::filter('admincheck', function()
{
    $t=DB::table('administrateurs')
    	->where('compte_id','=',Auth::user()->id)
    	->get();

    if(count($t)>0){
    	
    }
    else{
    	return Redirect::to('forbidden');
    }
});

App::missing(function($exception){
	return View::make('pages.divers.notfound');
});

Route::get('/', ['uses'=>'HomeController@index','as' =>'home.index']);

Route::get('/forbidden',function(){
	return View::make('pages.divers.forbidden');
});



Route::get('/contact-us', ['uses'=>'NouscontacterController@index','as' =>'nouscontacter.index']);
Route::post('/contact-us', ['uses'=>'NouscontacterController@action','as' =>'nouscontacter.action']);

Route::get('/home', ['uses'=>'HomeController@index','as' =>'home.index']);
Route::post('/home', ['uses'=>'HomeController@index','as' =>'home.index']);

	Route::group(array('before' => 'guest'), function() {

			Route::get('/signup', 'SignupController@index');
			Route::post('/signup',['uses'=>'SignupController@register','as' =>'signup.register']);

			Route::get('/login', 'LoginController@index');
			Route::post('/login',['uses'=>'LoginController@login','as' =>'login.login']);
			});
		
	Route::group(array('before' => 'auth'), function(){

			Route::get('/logout', ['uses'=>'LogoutController@index','as' =>'logout.index' ]);

			Route::get('/profil', ['uses'=>'ProfilController@index','as' =>'profil.index' ]);
			Route::post('/profil', ['uses'=>'ProfilController@goToEdit','as' =>'profil.edit' ]);

			Route::get('/editprofil',['uses'=>'EditProfilController@index','as' =>'editprofil.index' ]);
			Route::post('/editprofil',['uses'=>'EditProfilController@edit','as' =>'editprofil.edit']);

			Route::get('/newproject', [ 'uses'=>'NewProjectController@index','as' =>'newproject.index' ]);
			Route::post('/newproject',['uses'=>'NewProjectController@createnew','as' =>'newproject.createnew']);

			Route::get('/messagerie-br', [ 'uses'=>'MessagerieController@boite_reception','as' =>'messagerie.boite_reception']);
			Route::get('/messagerie-br/{num_msg}', ['uses'=>'MessagerieController@display_msg_br','as' =>'messagerie.display_msg_br' ]);
			Route::post('/messagerie-br', ['uses'=>'MessagerieController@action_br','as' =>'messagerie.action_br' ]);

			Route::get('/messagerie-newmsg',[ 'uses'=>'MessagerieController@nouveau_message','as' =>'messagerie.nouveau_message' ]);
			Route::post('/messagerie-newmsg', ['uses'=>'MessagerieController@send_message','as' =>'messagerie.send_message' ]);

			Route::get('/messagerie-be', [ 'uses'=>'MessagerieController@boite_envoi','as' =>'messagerie.boite_envoi' ]);
			Route::get('/messagerie-be/{num_msg}', ['uses'=>'MessagerieController@display_msg_be','as' =>'messagerie.display_msg_be' ]);
			Route::post('/messagerie-be', [ 'uses'=>'MessagerieController@action_envoi','as' =>'messagerie.action_envoi' ]);

			Route::get('/messagerie-trash',['uses'=>'MessagerieController@trash','as' =>'messagerie.trash' ]);
			Route::post('/messagerie-trash', [ 'uses'=>'MessagerieController@action_trash','as' =>'messagerie.action_trash' ]);

			Route::get('/messagerie-saved', [ 'uses'=>'MessagerieController@msg_saved','as' =>'messagerie.saved' ]);
			Route::post('/messagerie-saved', [ 'uses'=>'MessagerieController@action_msg_saved','as' =>'messagerie.action_saved']);

			Route::get('/projects-trash', [ 'uses'=>'ProjectsTrashController@index','as' =>'projectstrash.index' ]);
			Route::post('/projects-trash', [ 'uses'=>'ProjectsTrashController@action','as' =>'projectstrash.action' ]);

			Route::get('/recherche', ['uses'=>'RechercheController@index','as' =>'recherche.index' ]);
			Route::post('/recherche', [ 'uses'=>'RechercheController@action','as' =>'recherche.action' ]);

			Route::get('/notifications', ['uses'=>'NotificationsController@index','as' =>'notifications.index' ]);
			Route::post('/notifications', [ 'uses'=>'NotificationsController@action','as' =>'notifications.action']);


			Route::group(array('before'=>'admincheck'), function()
					{
						Route::get('/admin',['uses'=>'AdminController@index','as' =>'admin.index' ]);
						Route::post('/admin',['uses'=>'AdminController@action','as' =>'admin.action' ]);

						Route::get('/admin/membres',['uses'=>'AdminMembresController@index','as' =>'adminmembres.index' ]);
						Route::post('/admin/membres',['uses'=>'AdminMembresController@action','as' =>'adminmembres.action' ]);

					});


			Route::group(array('prefix' => 'projet'), function()
					{
						Route::get('/{hash}',['uses'=>'VisuProjetController@index','as' =>'visuprojet.index' ]);
						Route::post('/{hash}',['uses'=>'VisuProjetController@action','as' =>'visuprojet.action' ]);

					});

			Route::group(array('prefix' => 'my-projects'), function()
				{
					Route::get('/',[ 'uses'=>'MesProjetsController@index','as' =>'mesprojets.index' ]);
					Route::get('/{num_proj}', [ 'uses'=>'MesProjetsController@display_myprojet','as' =>'mesprojets.display_myprojet']);
					Route::post('/', ['uses'=>'MesProjetsController@action','as' =>'mesprojets.action' ]);


					Route::get('{id}/edit', ['uses'=>'EditProjetController@index','as' =>'editprojet.index' ]);
				    Route::post('{id}/edit', ['uses'=>'EditProjetController@edit','as' =>'editprojet.edit' ]);

					Route::get('{id}/members/',['uses'=>'ProjectsMembersController@index','as' =>'projectmembers.index' ]);
					Route::post('{id}/members/',['uses'=>'ProjectsMembersController@action','as' =>'projectmembers.action' ]);

					Route::get('{id}/lieux',['uses'=>'ProjectsLieuxController@index','as' =>'projectlieux.index' ]);
					Route::post('{id}/lieux',['uses'=>'ProjectsLieuxController@action','as' =>'projectlieux.action' ]);

					Route::get('{id}/categorie_activite',['uses'=>'CategorieActiviteController@index','as' =>'categorieactivite.index' ]);
					Route::post('{id}/categorie_activite',['uses'=>'CategorieActiviteController@action','as' =>'categorieactivite.action' ]);
					

					Route::post('{id}/post_comment',['uses'=>'EditProjetController@post_comment','as' =>'mon_projo.post_comment' ]);
					

					Route::get('{id}/activites',['uses'=>'ActiviteController@index','as' =>'activite.index' ]);
					Route::post('{id}/activites',['uses'=>'ActiviteController@action','as' =>'activite.action' ]);
					
					Route::get('{id}/activites/mesactivites/{num_page}',['uses'=>'ActiviteController@display_page','as' =>'activite.display_page' ]);
					Route::post('{id}/activites/mesactivites/{num_page}',['uses'=>'ActiviteController@display_page','as' =>'activite.display_page' ]);

					Route::get('{id}/calendrier',['uses'=>'CalendrierController@index','as' =>'calendrier.index' ]);
					Route::post('{id}/calendrier',['uses'=>'CalendrierController@action','as' =>'calendrier.action' ]);

					Route::get('{id}/indicateurs',['uses'=>'IndicateursController@index','as' =>'indicateurs.index' ]);
					Route::post('{id}/indicateurs',['uses'=>'IndicateursController@action','as' =>'indicateurs.action' ]);
				
					Route::get('{id}/pop_ajout_lieux',['uses'=>'PopLieuxController@pop_new_lieu','as' =>'poplieux.pop_new_lieu' ]);
					Route::post('{id}/pop_ajout_lieux',['uses'=>'PopLieuxController@action','as' =>'poplieux.action' ]);

					Route::get('{id}/pop_ajout_lieu_enregistre',['uses'=>'PopLieuxController@pop_lieu','as' =>'poplieux.pop_lieu' ]);
					Route::post('{id}/pop_ajout_lieu_enregistre',['uses'=>'PopLieuxController@action','as' =>'poplieux.action' ]);

					Route::get('{id}/pop_ajout_cat',['uses'=>'PopCatController@pop_cat','as' =>'popcat.pop_cat' ]);
					Route::post('{id}/pop_ajout_cat',['uses'=>'PopCatController@action','as' =>'popcat.action' ]);

					Route::get('{id}/outils',['uses'=>'OutilsController@index','as' =>'outils.index' ]);
					Route::post('{id}/outils',['uses'=>'OutilsController@action','as' =>'outils.action' ]);

					Route::get('{id}/creation_questionnaire',['uses'=>'OutilsController@AccueilQuestionnaire','as' =>'outils.questionnaire' ]);
					Route::post('{id}/creation_questionnaire',['uses'=>'OutilsController@action','as' =>'outils.action' ]);

					Route::post('{id}/shadow_lieu',['uses'=>'ShadowLieuxController@action','as' =>'shadowLieux.action' ]);

					Route::post('{id}/shadow_outilsc',['uses'=>'ShadowOutilsCController@action','as' =>'shadowOutilsC.action' ]);

					Route::post('{id}/shadow_membresc',['uses'=>'ShadowMembresCController@action','as' =>'shadowMembresC.action' ]);

					Route::post('{id}/shadow_membresa',['uses'=>'ShadowMembresAController@action','as' =>'shadowMembresA.action' ]);

					Route::post('{id}/shadow_indics',['uses'=>'ShadowIndicateursController@action','as' =>'shadowindicateurs.action' ]);

					Route::post('{id}/shadow_indics_act',['uses'=>'ShadowIndicateursActController@action','as' =>'shadowindicateursact.action' ]);

					Route::post('{id}/shadow_lieu_a',['uses'=>'ShadowLieuxAController@action','as' =>'shadowlieuxa.action' ]);

					Route::post('{id}/shadow_cat_a',['uses'=>'ShadowCategoriesController@action','as' =>'shadowcategoriea.action' ]);

					Route::post('{id}/shadow_outils_i',['uses'=>'ShadowOutilsIController@action','as' =>'shadowOutilsI.action' ]);

					Route::get('{id}/associations',['uses'=>'AssociationsController@index','as' =>'association.index' ]);
					Route::post('{id}/associations',['uses'=>'AssociationsController@action','as' =>'association.action' ]);

					Route::get('{id}/depot_compte_rendu',['uses'=>'CompteRenduController@index','as' =>'CompteRendu.index' ]);
					Route::post('{id}/depot_compte_rendu',['uses'=>'CompteRenduController@action','as' =>'CompteRendu.action' ]);
					
					Route::get('{id}/gestion_expertise',['uses'=>'GestionExpertiseController@index','as' =>'GestionExpertise.index' ]);
					Route::post('{id}/gestion_expertise',['uses'=>'GestionExpertiseController@action','as' =>'GestionExpertise.action' ]);

					Route::get('{id}/notation',['uses'=>'NotationController@index','as' =>'notation.index' ]);
					Route::post('{id}/notation',['uses'=>'NotationController@action','as' =>'notation.action' ]);
				
				});

});



