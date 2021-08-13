<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = "entryform";
$route['404_override'] = 'error_404';
$route['translate_uri_dashes'] = FALSE;


/*********** USER DEFINED ROUTES *******************/
$route['admin'] = "login";
$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";

$route['addNew'] = "user/addNew";
$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['profile'] = "user/profile";
$route['profile/(:any)'] = "user/profile/$1";
$route['profileUpdate'] = "user/profileUpdate";
$route['profileUpdate/(:any)'] = "user/profileUpdate/$1";

$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['changePassword/(:any)'] = "user/changePassword/$1";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['login-history'] = "user/loginHistoy";
$route['login-history/(:num)'] = "user/loginHistoy/$1";
$route['login-history/(:num)/(:num)'] = "user/loginHistoy/$1/$2";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

$route['zoomAccountListing'] = 'zoomaccount/zoomaccountListing';
$route['zoomAccountListing/(:any)'] = 'zoomaccount/zoomaccountListing/$1';
$route['addZoomAccount'] = "zoomaccount/addZoomAccount";
$route['insertZoomAccount'] = "zoomaccount/insertZoomAccount";
$route['editZoomAccount'] = "zoomaccount/editOld";
$route['updateZoomAccount'] = "zoomaccount/editZoomAccount";
$route['editZoomAccount/(:num)'] = "zoomaccount/editOld/$1";
$route['deleteZoomAccount'] = "zoomaccount/deleteZoomAccount";

$route['zoomRoomListing'] = 'zoomroom/zoomroomListing';
$route['zoomRoomListing/(:any)/(:any)'] = 'zoomroom/zoomroomListing/$1/$2';
$route['editZoomRoom'] = "zoomroom/editOld";
$route['editZoomRoom/(:num)'] = "zoomroom/editOld/$1";
$route['updateZoomRoom'] = "zoomroom/editZoomRoom";
$route['getSameRoomPlayers'] = "zoomroom/getSameRoomPlayers";
$route['movePlayer'] = "zoomroom/movePlayer";
$route['setRoomVacant'] = "zoomroom/setRoomVacant";
$route['setSoloRoomClosed'] = "zoomroom/setSoloRoomClosed";
$route['setRoomNeedHelp'] = "zoomroom/setRoomNeedHelp";
$route['clearAllRoomData'] = "zoomroom/clearAllRoomData";
$route['changePlayerStatus'] = "zoomroom/changePlayerStatus";

$route['schoolListing'] = 'school/schoolListing';
$route['schoolListing/(:any)'] = 'school/schoolListing/$1';
$route['addSchool'] = "school/addSchool";
$route['insertSchool'] = "school/insertSchool";
$route['editSchool'] = "school/editOld";
$route['updateSchool'] = "school/editSchool";
$route['editSchool/(:num)'] = "school/editOld/$1";
$route['deleteSchool'] = "school/deleteSchool";

$route['searchTeam'] = 'entryform/searchTeam';
$route['searchTeam/(:any)'] = 'entryform/searchTeam/$1';
$route['selectTeam'] = 'entryform/selectTeam';

$route['groupListing'] = 'zoomgroup/groupListing';
$route['groupListing/(:any)'] = 'zoomgroup/groupListing/$1';

$route['manageHunt/(:num)'] = 'scavrhunts/manage/$1';
$route['addHunt'] = 'scavrhunts/addHunt';
$route['insertHunt'] = 'scavrhunts/insertHunt';
$route['gotoHuntDetails/(:num)'] = 'scavrhunts/gotoHuntDetails/$1';
$route['updateHunt'] = "scavrhunts/editHunt";
$route['copyHunt/(:num)'] = 'scavrhunts/copyHunt/$1';
$route['deleteHunt/(:num)'] = 'scavrhunts/deleteHunt/$1';
$route['manageChallenges/(:num)'] = 'scavrhunts/manageChallenges/$1';
$route['addChallenge/(:num)'] = 'scavrhunts/addChallenge/$1';
$route['insertChallenge'] = 'scavrhunts/insertChallenge';
$route['gotoChallengeDetails/(:num)'] = 'scavrhunts/gotoChallengeDetails/$1';
$route['uploadChallengeImage'] = 'scavrhunts/uploadChallengeImage2';
$route['updateChallenge'] = 'scavrhunts/editChallenge';
$route['judgeChallenges/(:num)/(:num)'] = 'scavrhunts/judgeChallenges/$1/$2';
$route['getChallengeAnswers'] = 'scavrhunts/getChallengeAnswers';
$route['saveChallengePoints'] = 'scavrhunts/saveChallengePoints';
$route['copyChallenge/(:num)'] = 'scavrhunts/copyChallenge/$1';
$route['deleteChallenge/(:num)'] = 'scavrhunts/deleteChallenge/$1';
$route['manageDataBank/(:num)'] = 'scavrhunts/manageDataBank/$1';
$route['addChallengeDB/(:num)'] = 'scavrhunts/addChallengeDB/$1';
$route['insertChallengeDB'] = 'scavrhunts/insertChallengeDB';
$route['gotoChallengeDBDetails/(:num)/(:num)'] = 'scavrhunts/gotoChallengeDBDetails/$1/$2';
$route['uploadChallengeDBImage'] = 'scavrhunts/uploadChallengeDBImage2';
$route['updateChallengeDB'] = 'scavrhunts/editChallengeDB';
$route['copyChallengeDB/(:num)/(:num)'] = 'scavrhunts/copyChallengeDB/$1/$2';
$route['deleteChallengeDB/(:num)/(:num)'] = 'scavrhunts/deleteChallengeDB/$1/$2';
$route['copyChallengeDBToHunt/(:num)/(:num)'] = 'scavrhunts/copyChallengeDBToHunt/$1/$2';
$route['isJudgeGamesForCheck'] = "scavrhunts/isJudgeGamesForCheck";
$route['getOldestSubmittedChallenge'] = "scavrhunts/getOldestSubmittedChallenge";

$route['gotoHuntGame'] = 'huntform';
$route['endHuntGame'] = 'huntform/huntEndForm';
$route['getHuntGameCode'] = 'huntform/getHuntGameCode';
$route['gotoHunt'] = 'huntform/assignGameCode';
$route['submitHuntAnswer'] = 'huntform/submitAnswer';
$route['viewFeedback'] = 'huntform/viewFeedback';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
