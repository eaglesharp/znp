<?php


 
/* * ******  User Start ********** */

Route::get('list-users', array_merge(['uses' => 'Admin\UserController@indexUsers'], $all_users))->name('list.users');

Route::get('bulkuseruploads', array_merge(['uses' => 'Admin\UserController@bulkuseruploads'], $all_users))->name('bulkuseruploads');

Route::get('bulkresumeupload', array_merge(['uses' => 'Admin\UserController@bulkresume'], $all_users))->name('bulkresume');

Route::get('bulkresumeresponse', array_merge(['uses' => 'Admin\UserController@bulkresumeresponse'], $all_users))->name('bulkresumeresponse');

Route::get('create-user', array_merge(['uses' => 'Admin\UserController@createUser'], $all_users))->name('create.user');

Route::post('store-user', array_merge(['uses' => 'Admin\UserController@storeUser'], $all_users))->name('store.user');

Route::get('edit-user/{id}', array_merge(['uses' => 'Admin\UserController@editUser'], $all_users))->name('edit.user');

Route::get('edit-user/skills/{id}', array_merge(['uses' => 'Admin\UserController@editUserSkills'], $all_users))->name('edit.userskills');

Route::put('update-user/{id}', array_merge(['uses' => 'Admin\UserController@updateUser'], $all_users))->name('update.user');

Route::delete('delete-user', array_merge(['uses' => 'Admin\UserController@deleteUser'], $all_users))->name('delete.user');

Route::get('fetch-users', array_merge(['uses' => 'Admin\UserController@fetchUsersData'], $all_users))->name('fetch.data.users');

Route::put('make-active-user', array_merge(['uses' => 'Admin\UserController@makeActiveUser'], $all_users))->name('make.active.user');

Route::put('make-not-active-user', array_merge(['uses' => 'Admin\UserController@makeNotActiveUser'], $all_users))->name('make.not.active.user');

Route::put('make-verified-user', array_merge(['uses' => 'Admin\UserController@makeVerifiedUser'], $all_users))->name('make.verified.user');

Route::put('make-not-verified-user', array_merge(['uses' => 'Admin\UserController@makeNotVerifiedUser'], $all_users))->name('make.not.verified.user');

/* * *********************************** */

Route::get('download-state', array_merge(['uses' => 'Admin\UserController@downloadstate'], $all_users))->name('download.state');

Route::get('download-careerlevel', array_merge(['uses' => 'Admin\UserController@downloadcareerlevel'], $all_users))->name('download.careerlevel');

Route::get('download-industry', array_merge(['uses' => 'Admin\UserController@downloadindustry'], $all_users))->name('download.industry');

Route::get('download-degreetype', array_merge(['uses' => 'Admin\UserController@downloaddegreetype'], $all_users))->name('download.degreetype');

Route::get('download-jobskills', array_merge(['uses' => 'Admin\UserController@downloadjobskills'], $all_users))->name('download.jobskills');

Route::get('download-languages', array_merge(['uses' => 'Admin\UserController@downloadlanguages'], $all_users))->name('download.languages');

Route::get('latest-company-export', array_merge(['uses' => 'Admin\UserController@downloadlatestcompany'], $all_users))->name('latest-company-export');

Route::get('download-country', array_merge(['uses' => 'Admin\UserController@downloadcountry'], $all_users))->name('download.country');

Route::post('bulkuserupload', array_merge(['uses' => 'Admin\UserController@bulkuserupload'], $all_users))->name('bulkuserupload');

Route::post('bulkuserresume', array_merge(['uses' => 'Admin\UserController@bulkuserresume'], $all_users))->name('bulkuserresume');



Route::post('update-profile-np/{id}', array_merge(['uses' => 'Admin\UserController@updateProfileNp'], $all_users))->name('update.profile.np');

Route::post('update-profile-jobcity/{id}', array_merge(['uses' => 'Admin\UserController@updatecurrentProfileJobCity'], $all_users))->name('update.profile.jc');

Route::post('update-previous-profile-jobcity/{id}', array_merge(['uses' => 'Admin\UserController@updatepreviousProfileJobCity'], $all_users))->name('update.previous.profile.jc');

Route::post('update-profile-details/{id}', array_merge(['uses' => 'Admin\UserController@updateProfileDetails'], $all_users))->name('update.profile.details');

Route::post('update-profile-compensation/{id}', array_merge(['uses' => 'Admin\UserController@updateProfileCompensation'], $all_users))->name('update.profile.compensation');

Route::post('update-profile-interview/{id}', array_merge(['uses' => 'Admin\UserController@updateProfileInterview'], $all_users))->name('update.profile.interview');

Route::post('update-profile-night-interview/{id}', array_merge(['uses' => 'Admin\UserController@updateProfileNightInterview'], $all_users))->name('update.profile.nightinterview');

Route::post('update-profile-verifications/{id}', array_merge(['uses' => 'Admin\UserController@updateVerifications'], $all_users))->name('update.profile.verifications');



/*offers*/



Route::post('update-offers/{id}', array_merge(['uses' => 'Admin\UserController@updateOffers'], $all_users))->name('update.offers');



// Route::put('update-user/{id}', array_merge(['uses' => 'Admin\UserController@updateUser'], $all_users))->name('update.user');

Route::get('delete-resume/{id}',array_merge(['uses'=>'Admin\UserController@deleteresume'],$all_users))->name('delete.resume');



Route::post('update-profile-summary/{id}', array_merge(['uses' => 'Admin\UserController@updateProfileSummary'], $all_users))->name('update.profile.summary');

/* * *********************************** */

Route::post('show-profile-cvs/{id}', array_merge(['uses' => 'Admin\UserController@showProfileCvs'], $all_users))->name('show.profile.cvs');

Route::post('upload-cv-temp-image', array_merge(['uses' => 'Admin\UserController@uploadCvTempImage'], $all_users))->name('upload.cv.temp.image');

Route::post('get-profile-cv-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileCvForm'], $all_users))->name('get.profile.cv.form');

/** certificates */

Route::post('get-certificate-certificate-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfilecertificateForm'], $all_users))->name('get.certificate.certificate.form');

Route::post('store-certificate/{id}', array_merge(['uses' => 'Admin\UserController@storecertificate'], $all_users))->name('store.certificate');

Route::post('show-certificates/{id}', array_merge(['uses' => 'Admin\UserController@showcertificates'], $all_users))->name('show.certificates');

Route::delete('delete-certificates', array_merge(['uses' => 'Admin\UserController@deletecertificates'], $all_users))->name('delete.certificate');

Route::post('get-certificate-edit-form/{user_id}', array_merge(['uses' => 'Admin\UserController@getcertificateEditForm'], $all_users))->name('get.certificate.edit.form');

Route::put('update-certificae/{id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updatecertificate'], $all_users))->name('update.certificate');


//Accomplishment

Route::post('show-accomplishments/{id}', array_merge(['uses' => 'Admin\UserController@showaccomplishments'], $all_users))->name('show.accomplishments');

Route::post('get-accomplishment-accomplishment-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileaccomplishmentForm'], $all_users))->name('get.accomplishment.accomplishment.form');

Route::post('store-accomplishment/{id}', array_merge(['uses' => 'Admin\UserController@storeaccomplishment'], $all_users))->name('store.accomplishment');

Route::post('get-accomplishment-edit-form/{user_id}', array_merge(['uses' => 'Admin\UserController@getaccomplishmentEditForm'], $all_users))->name('get.accomplishment.edit.form');

Route::put('update-accomplishment/{id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateaccomplishment'], $all_users))->name('update.accomplishment');

Route::delete('delete-accomplishments', array_merge(['uses' => 'Admin\UserController@deleteaccomplishments'], $all_users))->name('delete.accomplishments');


/* Key Skill */

Route::post('get-profile-keyskill/{id}', array_merge(['uses' => 'Admin\UserController@getProfilekeySkill'], $all_users))->name('get.profile.keyskill.show.form');

Route::post('store-keyskill/{id}', array_merge(['uses' => 'Admin\UserController@storekeyskill'], $all_users))->name('store.keyskill');

Route::post('show-profile-keyskills/{id}', array_merge(['uses' => 'Admin\UserController@showProfileKeySkills'], $all_users))->name('show.profile.keyskills');

Route::post('get-profile-keyskill-edit-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfilekeySkillEditForm'], $all_users))->name('get.profile.keyskill.edit.form');

Route::put('update-keyskill/{keyskill_id}/{user_id}',array_merge(['uses' => 'Admin\UserController@updatekeyskill'],$all_users))->name('update.keyskill');

Route::delete('delete-keyskill',array_merge(['uses'=>'Admin\UserController@deletekeyskill'],$all_users))->name('delete.profile.keyskill');







Route::post('store-profile-cv/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileCv'], $all_users))->name('store.profile.cv');

Route::post('get-profile-cv-edit-form/{user_id}', array_merge(['uses' => 'Admin\UserController@getProfileCvEditForm'], $all_users))->name('get.profile.cv.edit.form');

Route::post('update-profile-cv/{id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileCv'], $all_users))->name('update.profile.cv');

Route::delete('delete-profile-cv', array_merge(['uses' => 'Admin\UserController@deleteProfileCv'], $all_users))->name('delete.profile.cv');

/* * *********************************** */

Route::post('show-profile-projects/{id}', array_merge(['uses' => 'Admin\UserController@showProfileProjects'], $all_users))->name('show.profile.projects');

Route::post('upload-project-temp-image', array_merge(['uses' => 'Admin\UserController@uploadProjectTempImage'], $all_users))->name('upload.project.temp.image');

Route::post('get-profile-project-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileProjectForm'], $all_users))->name('get.profile.project.form');

Route::post('store-profile-project/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileProject'], $all_users))->name('store.profile.project');

Route::post('get-profile-project-edit-form/{user_id}', array_merge(['uses' => 'Admin\UserController@getProfileProjectEditForm'], $all_users))->name('get.profile.project.edit.form');

Route::put('update-profile-project/{id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileProject'], $all_users))->name('update.profile.project');

Route::delete('delete-profile-project', array_merge(['uses' => 'Admin\UserController@deleteProfileProject'], $all_users))->name('delete.profile.project');

/* * *********************************** */

Route::post('show-profile-experience/{id}', array_merge(['uses' => 'Admin\UserController@showProfileExperience'], $all_users))->name('show.profile.experience');



Route::post('show-profile-gap/{id}', array_merge(['uses' => 'Admin\UserController@showProfileGap'], $all_users))->name('show.profile.gap');

Route::post('get-profile-experience-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileExperienceForm'], $all_users))->name('get.profile.experience.form');

Route::post('get-profile-gap-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileGapForm'], $all_users))->name('get.profile.gap.form');



Route::post('store-profile-experience/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileExperience'], $all_users))->name('store.profile.experience');

Route::post('store-profile-gap/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileGap'], $all_users))->name('store.profile.gap');



Route::post('get-profile-experience-edit-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileExperienceEditForm'], $all_users))->name('get.profile.experience.edit.form');

Route::post('get-profile-gap-edit-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileGapEditForm'], $all_users))->name('get.profile.gap.edit.form');

Route::put('update-profile-experience/{profile_experience_id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileExperience'], $all_users))->name('update.profile.experience');

Route::put('update-profile-gap/{profile_experience_id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileGap'], $all_users))->name('update.profile.gap');

Route::delete('delete-profile-experience', array_merge(['uses' => 'Admin\UserController@deleteProfileExperience'], $all_users))->name('delete.profile.experience');

Route::delete('delete-profile-gap', array_merge(['uses' => 'Admin\UserController@deleteProfileGap'], $all_users))->name('delete.profile.gap');

/* * *********************************** */

Route::post('show-profile-education/{id}', array_merge(['uses' => 'Admin\UserController@showProfileEducation'], $all_users))->name('show.profile.education');

Route::post('get-profile-education-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileEducationForm'], $all_users))->name('get.profile.education.form');

Route::post('store-profile-education/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileEducation'], $all_users))->name('store.profile.education');

Route::post('get-profile-education-edit-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileEducationEditForm'], $all_users))->name('get.profile.education.edit.form');

Route::put('update-profile-education/{education_id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileEducation'], $all_users))->name('update.profile.education');

Route::delete('delete-profile-education', array_merge(['uses' => 'Admin\UserController@deleteProfileEducation'], $all_users))->name('delete.profile.education');

/* * *********************************** */

Route::post('show-profile-skills/{id}', array_merge(['uses' => 'Admin\UserController@showProfileSkills'], $all_users))->name('show.profile.skills');

Route::post('get-profile-skill-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileSkillForm'], $all_users))->name('get.profile.skill.form');

Route::post('store-profile-skill/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileSkill'], $all_users))->name('store.profile.skill');

Route::post('get-profile-skill-edit-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileSkillEditForm'], $all_users))->name('get.profile.skill.edit.form');

Route::put('update-profile-skill/{skill_id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileSkill'], $all_users))->name('update.profile.skill');

Route::delete('delete-profile-skill', array_merge(['uses' => 'Admin\UserController@deleteProfileSkill'], $all_users))->name('delete.profile.skill');

/* * *********************************** */

Route::post('show-profile-languages/{id}', array_merge(['uses' => 'Admin\UserController@showProfileLanguages'], $all_users))->name('show.profile.languages');

Route::post('get-profile-language-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileLanguageForm'], $all_users))->name('get.profile.language.form');

Route::post('store-profile-language/{id}', array_merge(['uses' => 'Admin\UserController@storeProfileLanguage'], $all_users))->name('store.profile.language');

Route::post('get-profile-language-edit-form/{id}', array_merge(['uses' => 'Admin\UserController@getProfileLanguageEditForm'], $all_users))->name('get.profile.language.edit.form');

Route::put('update-profile-language/{language_id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateProfileLanguage'], $all_users))->name('update.profile.language');

Route::delete('delete-profile-language', array_merge(['uses' => 'Admin\UserController@deleteProfileLanguage'], $all_users))->name('delete.profile.language');

Route::post('get.profile.certificate.form}', array_merge(['uses' => 'Admin\UserController@showcertificate'], $all_users))->name('get.profile.certificate.form');



Route::get('fetch-employers', array_merge(['uses' => 'Admin\UserController@fetchemployersData'], $all_users))->name('fetch.employers.data');

/* * ****** End User ********** */


Route::get('user-payment-history',array_merge(['uses' => 'Admin\UserController@paymenthistory'], $all_users))->name('candidate.payment.history');

Route::get('user-payments/{id}',array_merge(['uses' => 'Admin\UserController@userpaymenthistory'], $all_users))->name('user.payment.history');




// Interview Routes


Route::post('show-interview-form/{id}', array_merge(['uses' => 'Admin\UserController@showInterview'], $all_users))->name('show.interview.form');
Route::post('get-interview-form/{id}', array_merge(['uses' => 'Admin\UserController@getInterviewForm'], $all_users))->name('get.interview.form');
Route::post('store-interview/{id}', array_merge(['uses' => 'Admin\UserController@storeInterview'], $all_users))->name('store.interview');
Route::post('get-interview-edit-form/{id}', array_merge(['uses' => 'Admin\UserController@getInterviewEditForm'], $all_users))->name('get.interview.edit.form');
Route::put('update-interview/{interview_id}/{user_id}', array_merge(['uses' => 'Admin\UserController@updateInterview'], $all_users))->name('update.interview');
Route::delete('delete-interview', array_merge(['uses' => 'Admin\UserController@deleteInterview'], $all_users))->name('delete.interview');

Route::get('users-softdelete', array_merge(['uses' => 'Admin\UserController@userSoftDelete'], $all_users))->name('users.softdelete');
Route::get('hided-users', array_merge(['uses' => 'Admin\UserController@hidedUsersList'], $all_users))->name('hide.users');
Route::get('fetch-hide-users', array_merge(['uses' => 'Admin\UserController@fetchHideUsersData'], $all_users))->name('fetch.hidedata.users');
Route::get('users-restore', array_merge(['uses' => 'Admin\UserController@restoredUsersList'], $all_users))->name('users.restore');
Route::get('users-delete-all', array_merge(['uses' => 'Admin\UserController@deleteAllUsersList'], $all_users))->name('users.delete.all');


Route::post('adminsendbulkemailusers', array_merge(['uses' => 'Admin\UserController@sendbulkemailusers'], $all_users))->name('email.admin_send_bulkemail_users');


?>