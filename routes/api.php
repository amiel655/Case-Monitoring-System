<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('user', 'API\UserController');

Route::get('profile', 'API\UserController@profile');

Route::put('profile', 'API\UserController@updateProfile');

Route::post('check-old-password', 'API\UserController@checkPassword');

Route::get('findUser', 'API\UserController@search');

Route::get('findClient', 'API\ClientsController@search');

Route::apiResource('interview-form', 'API\FormController');

Route::apiResource('clients', 'API\ClientsController');

Route::apiResource('prepare-case', 'API\ClientsController');

Route::post('prepare-case', 'API\ClientsController@prepare');

Route::post('generate-code', 'API\CasesController@generateAccessCode');

Route::apiResource('cases', 'API\CasesController');

Route::apiResource('hearing', 'API\HearingController');

Route::put('calendar/hearing-date/{id}', 'API\CalendarController@updateHearingDate');

Route::post('individual-performance-reports', 'API\IndividualPerformanceReportController@loadReport');
//IPR PENDING
Route::post('pending-criminal', 'API\IndividualPerformanceReportController@pendingCriminal');

Route::post('pending-civil', 'API\IndividualPerformanceReportController@pendingCivil');

Route::post('pending-adm1', 'API\IndividualPerformanceReportController@pendingADM1');

Route::post('pending-adm2', 'API\IndividualPerformanceReportController@pendingADM2');

Route::post('pending-adm3', 'API\IndividualPerformanceReportController@pendingADM3');
//-
//IPR RECEIVED
Route::post('received-criminal', 'API\IndividualPerformanceReportController@receivedCriminal');

Route::post('received-civil', 'API\IndividualPerformanceReportController@receivedCivil');

Route::post('received-adm1', 'API\IndividualPerformanceReportController@receivedADM1');

Route::post('received-adm2', 'API\IndividualPerformanceReportController@receivedADM2');

Route::post('received-adm3', 'API\IndividualPerformanceReportController@receivedADM3');
//-
//IPR TRANSFER TO
Route::post('transfer-criminal', 'API\IndividualPerformanceReportController@transferCriminal');

Route::post('transfer-civil', 'API\IndividualPerformanceReportController@transferCivil');

Route::post('transfer-adm1', 'API\IndividualPerformanceReportController@transferADM1');

Route::post('transfer-adm2', 'API\IndividualPerformanceReportController@transferADM2');

Route::post('transfer-adm3', 'API\IndividualPerformanceReportController@transferADM3');
//-
//IPR TERMI OLD + NEW
Route::post('total-terminated-old', 'API\IndividualPerformanceReportController@totalTerminatedOld');

Route::post('total-terminated-new', 'API\IndividualPerformanceReportController@totalTerminatedNew');
//-
//IPR AQUITTED
Route::post('aquitted-cr', 'API\IndividualPerformanceReportController@AquittedCriminal');

Route::post('aquitted-cv', 'API\IndividualPerformanceReportController@AquittedCivil');

Route::post('aquitted-adm1', 'API\IndividualPerformanceReportController@AquittedAdm1');

Route::post('aquitted-adm2', 'API\IndividualPerformanceReportController@AquittedAdm2');

Route::post('aquitted-adm3', 'API\IndividualPerformanceReportController@AquittedAdm3');
//-
//IPR Dismissed-w-p
Route::post('dismissed-w-p-cr', 'API\IndividualPerformanceReportController@DismissedwpCriminal');

Route::post('dismissed-w-p-cv', 'API\IndividualPerformanceReportController@DismissedwpCivil');

Route::post('dismissed-w-p-adm1', 'API\IndividualPerformanceReportController@DismissedwpAdm1');

Route::post('dismissed-w-p-adm2', 'API\IndividualPerformanceReportController@DismissedwpAdm2');

Route::post('dismissed-w-p-adm3', 'API\IndividualPerformanceReportController@DismissedwpAdm3');
//-
//IPR Motion
Route::post('motion-cr', 'API\IndividualPerformanceReportController@MotionCriminal');

Route::post('motion-cv', 'API\IndividualPerformanceReportController@MotionCivil');

Route::post('motion-adm1', 'API\IndividualPerformanceReportController@MotionAdm1');

Route::post('motion-adm2', 'API\IndividualPerformanceReportController@MotionAdm2');

Route::post('motion-adm3', 'API\IndividualPerformanceReportController@MotionAdm3');
//-
//IPR Demurrer
Route::post('demurrer-cr', 'API\IndividualPerformanceReportController@DemurrerCriminal');

Route::post('demurrer-cv', 'API\IndividualPerformanceReportController@DemurrerCivil');

Route::post('demurrer-adm1', 'API\IndividualPerformanceReportController@DemurrerAdm1');

Route::post('demurrer-adm2', 'API\IndividualPerformanceReportController@DemurrerAdm2');

Route::post('demurrer-adm3', 'API\IndividualPerformanceReportController@DemurrerAdm3');
//-
//IPR ProvisionallyD
Route::post('provisionallyd-cr', 'API\IndividualPerformanceReportController@ProvisionallyDCriminal');

Route::post('provisionallyd-cv', 'API\IndividualPerformanceReportController@ProvisionallyDCivil');

Route::post('provisionallyd-adm1', 'API\IndividualPerformanceReportController@ProvisionallyDAdm1');

Route::post('provisionallyd-adm2', 'API\IndividualPerformanceReportController@ProvisionallyDAdm2');

Route::post('provisionallyd-adm3', 'API\IndividualPerformanceReportController@ProvisionallyDAdm3');
//-
//IPR ConvictedToLesser
Route::post('convictedtolesser-cr', 'API\IndividualPerformanceReportController@ConvictedToLesserCriminal');

Route::post('convictedtolesser-cv', 'API\IndividualPerformanceReportController@ConvictedToLesserCivil');

Route::post('convictedtolesser-adm1', 'API\IndividualPerformanceReportController@ConvictedToLesserAdm1');

Route::post('convictedtolesser-adm2', 'API\IndividualPerformanceReportController@ConvictedToLesserAdm2');

Route::post('convictedtolesser-adm3', 'API\IndividualPerformanceReportController@ConvictedToLesserAdm3');
//-
//IPR ProbationGranted
Route::post('probationgranted-cr', 'API\IndividualPerformanceReportController@ProbationGrantedCriminal');

Route::post('probationgranted-cv', 'API\IndividualPerformanceReportController@ProbationGrantedCivil');

Route::post('probationgranted-adm1', 'API\IndividualPerformanceReportController@ProbationGrantedAdm1');

Route::post('probationgranted-adm2', 'API\IndividualPerformanceReportController@ProbationGrantedAdm2');

Route::post('probationgranted-adm3', 'API\IndividualPerformanceReportController@ProbationGrantedAdm3');
//-
//IPR Won
Route::post('won-cr', 'API\IndividualPerformanceReportController@WonCriminal');

Route::post('won-cv', 'API\IndividualPerformanceReportController@WonCivil');

Route::post('won-adm1', 'API\IndividualPerformanceReportController@WonAdm1');

Route::post('won-adm2', 'API\IndividualPerformanceReportController@WonAdm2');

Route::post('won-adm3', 'API\IndividualPerformanceReportController@WonAdm3');
//-
//IPR GrantedLesser
Route::post('grantedlesser-cr', 'API\IndividualPerformanceReportController@GrantedLesserCriminal');

Route::post('grantedlesser-cv', 'API\IndividualPerformanceReportController@GrantedLesserCivil');

Route::post('grantedlesser-adm1', 'API\IndividualPerformanceReportController@GrantedLesserAdm1');

Route::post('grantedlesser-adm2', 'API\IndividualPerformanceReportController@GrantedLesserAdm2');

Route::post('grantedlesser-adm3', 'API\IndividualPerformanceReportController@GrantedLesserAdm3');
//-
//IPR Dismissed-cases-c-a
Route::post('dismissed-cases-c-a-cr', 'API\IndividualPerformanceReportController@DismissedCasesCACriminal');

Route::post('dismissed-cases-c-a-cv', 'API\IndividualPerformanceReportController@DismissedCasesCACivil');

Route::post('dismissed-cases-c-a-adm1', 'API\IndividualPerformanceReportController@DismissedCasesCAAdm1');

Route::post('dismissed-cases-c-a-adm2', 'API\IndividualPerformanceReportController@DismissedCasesCAAdm2');

Route::post('dismissed-cases-c-a-adm3', 'API\IndividualPerformanceReportController@DismissedCasesCAAdm3');
//-
//IPR CaseFiled
Route::post('casefiled-cr', 'API\IndividualPerformanceReportController@CaseFiledCriminal');

Route::post('casefiled-cv', 'API\IndividualPerformanceReportController@CaseFiledCivil');

Route::post('casefiled-adm1', 'API\IndividualPerformanceReportController@CaseFiledAdm1');

Route::post('casefiled-adm2', 'API\IndividualPerformanceReportController@CaseFiledAdm2');

Route::post('casefiled-adm3', 'API\IndividualPerformanceReportController@CaseFiledAdm3');
//-
//IPR FavorableDismissedRespondent
Route::post('favorabledismissed-cr', 'API\IndividualPerformanceReportController@FavorableDismissedRespondentCriminal');

Route::post('favorabledismissed-cv', 'API\IndividualPerformanceReportController@FavorableDismissedRespondentCivil');

Route::post('favorabledismissed-adm1', 'API\IndividualPerformanceReportController@FavorableDismissedRespondentAdm1');

Route::post('favorabledismissed-adm2', 'API\IndividualPerformanceReportController@FavorableDismissedRespondentAdm2');

Route::post('favorabledismissed-adm3', 'API\IndividualPerformanceReportController@FavorableDismissedRespondentAdm3');
//-
//IPR Bail
Route::post('bail-cr', 'API\IndividualPerformanceReportController@BailCriminal');

Route::post('bail-cv', 'API\IndividualPerformanceReportController@BailCivil');

Route::post('bail-adm1', 'API\IndividualPerformanceReportController@BailAdm1');

Route::post('bail-adm2', 'API\IndividualPerformanceReportController@BailAdm2');

Route::post('bail-adm3', 'API\IndividualPerformanceReportController@BailAdm3');
//-
//IPR Recognizance
Route::post('recognizance-cr', 'API\IndividualPerformanceReportController@RecognizanceCriminal');

Route::post('recognizance-cv', 'API\IndividualPerformanceReportController@RecognizanceCivil');

Route::post('recognizance-adm1', 'API\IndividualPerformanceReportController@RecognizanceAdm1');

Route::post('recognizance-adm2', 'API\IndividualPerformanceReportController@RecognizanceAdm2');

Route::post('recognizance-adm3', 'API\IndividualPerformanceReportController@RecognizanceAdm3');
//-
//IPR DiversionProceeding
Route::post('diversionproceeding-cr', 'API\IndividualPerformanceReportController@DiversionProceedingCriminal');

Route::post('diversionproceeding-cv', 'API\IndividualPerformanceReportController@DiversionProceedingCivil');

Route::post('diversionproceeding-adm1', 'API\IndividualPerformanceReportController@DiversionProceedingAdm1');

Route::post('diversionproceeding-adm2', 'API\IndividualPerformanceReportController@DiversionProceedingAdm2');

Route::post('diversionproceeding-adm3', 'API\IndividualPerformanceReportController@DiversionProceedingAdm3');
//-
//IPR SuspenseSentence
Route::post('suspensesentence-cr', 'API\IndividualPerformanceReportController@SuspenseSentenceCriminal');

Route::post('suspensesentence-cv', 'API\IndividualPerformanceReportController@SuspenseSentenceCivil');

Route::post('suspensesentence-adm1', 'API\IndividualPerformanceReportController@SuspenseSentenceAdm1');

Route::post('suspensesentence-adm2', 'API\IndividualPerformanceReportController@SuspenseSentenceAdm2');

Route::post('suspensesentence-adm3', 'API\IndividualPerformanceReportController@SuspenseSentenceAdm3');
//-
//IPR MaximumImposable
Route::post('maximumimposable-cr', 'API\IndividualPerformanceReportController@MaximumImposableCriminal');

Route::post('maximumimposable-cv', 'API\IndividualPerformanceReportController@MaximumImposableCivil');

Route::post('maximumimposable-adm1', 'API\IndividualPerformanceReportController@MaximumImposableAdm1');

Route::post('maximumimposable-adm2', 'API\IndividualPerformanceReportController@MaximumImposableAdm2');

Route::post('maximumimposable-adm3', 'API\IndividualPerformanceReportController@MaximumImposableAdm3');
//-
//IPR ConvictedCharge
Route::post('convictedcharge-cr', 'API\IndividualPerformanceReportController@ConvictedChargeCriminal');

Route::post('convictedcharge-cv', 'API\IndividualPerformanceReportController@ConvictedChargeCivil');

Route::post('convictedcharge-adm1', 'API\IndividualPerformanceReportController@ConvictedChargeAdm1');

Route::post('convictedcharge-adm2', 'API\IndividualPerformanceReportController@ConvictedChargeAdm2');

Route::post('convictedcharge-adm3', 'API\IndividualPerformanceReportController@ConvictedChargeAdm3');
//-
//IPR Lost
Route::post('lost-cr', 'API\IndividualPerformanceReportController@LostCriminal');

Route::post('lost-cv', 'API\IndividualPerformanceReportController@LostCivil');

Route::post('lost-adm1', 'API\IndividualPerformanceReportController@LostAdm1');

Route::post('lost-adm2', 'API\IndividualPerformanceReportController@LostAdm2');

Route::post('lost-adm3', 'API\IndividualPerformanceReportController@LostAdm3');
//-
//IPR DismissedCAL
Route::post('dismissedcal-cr', 'API\IndividualPerformanceReportController@DismissedCALCriminal');

Route::post('dismissedcal-cv', 'API\IndividualPerformanceReportController@DismissedCALCivil');

Route::post('dismissedcal-adm1', 'API\IndividualPerformanceReportController@DismissedCALAdm1');

Route::post('dismissedcal-adm2', 'API\IndividualPerformanceReportController@DismissedCALAdm2');

Route::post('dismissedcal-adm3', 'API\IndividualPerformanceReportController@DismissedCALAdm3');
//-
//IPR UnfavorableDismissedComplainant
Route::post('unfavorabledismissedcomplainant-cr', 'API\IndividualPerformanceReportController@UnfavorableDismissedComplainantCriminal');

Route::post('unfavorabledismissedcomplainant-cv', 'API\IndividualPerformanceReportController@UnfavorableDismissedComplainantCivil');

Route::post('unfavorabledismissedcomplainant-adm1', 'API\IndividualPerformanceReportController@UnfavorableDismissedComplainantAdm1');

Route::post('unfavorabledismissedcomplainant-adm2', 'API\IndividualPerformanceReportController@UnfavorableDismissedComplainantAdm2');

Route::post('unfavorabledismissedcomplainant-adm3', 'API\IndividualPerformanceReportController@UnfavorableDismissedComplainantAdm3');
//-
//IPR UnfavorableDismissedRespondent
Route::post('unfavorabledismissedrespondent-cr', 'API\IndividualPerformanceReportController@UnfavorableDismissedRespondentCriminal');

Route::post('unfavorabledismissedrespondent-cv', 'API\IndividualPerformanceReportController@UnfavorableDismissedRespondentCivil');

Route::post('unfavorabledismissedrespondent-adm1', 'API\IndividualPerformanceReportController@UnfavorableDismissedRespondentAdm1');

Route::post('unfavorabledismissedrespondent-adm2', 'API\IndividualPerformanceReportController@UnfavorableDismissedRespondentAdm2');

Route::post('unfavorabledismissedrespondent-adm3', 'API\IndividualPerformanceReportController@UnfavorableDismissedRespondentAdm3');
//-
//IPR Archived
Route::post('archived-cr', 'API\IndividualPerformanceReportController@ArchivedCriminal');

Route::post('archived-cv', 'API\IndividualPerformanceReportController@ArchivedCivil');

Route::post('archived-adm1', 'API\IndividualPerformanceReportController@ArchivedAdm1');

Route::post('archived-adm2', 'API\IndividualPerformanceReportController@ArchivedAdm2');

Route::post('archived-adm3', 'API\IndividualPerformanceReportController@ArchivedAdm3');
//-
//IPR Withdrawn
Route::post('withdrawn-cr', 'API\IndividualPerformanceReportController@WithdrawnCriminal');

Route::post('withdrawn-cv', 'API\IndividualPerformanceReportController@WithdrawnCivil');

Route::post('withdrawn-adm1', 'API\IndividualPerformanceReportController@WithdrawnAdm1');

Route::post('withdrawn-adm2', 'API\IndividualPerformanceReportController@WithdrawnAdm2');

Route::post('withdrawn-adm3', 'API\IndividualPerformanceReportController@WithdrawnAdm3');
//-
//IPR TransferredtoPrivateLawyer
Route::post('transferredtoprivate-cr', 'API\IndividualPerformanceReportController@TransferredtoPrivateLawyerCriminal');

Route::post('transferredtoprivate-cv', 'API\IndividualPerformanceReportController@TransferredtoPrivateLawyerCivil');

Route::post('transferredtoprivate-adm1', 'API\IndividualPerformanceReportController@TransferredtoPrivateLawyerAdm1');

Route::post('transferredtoprivate-adm2', 'API\IndividualPerformanceReportController@TransferredtoPrivateLawyerAdm2');

Route::post('transferredtoprivate-adm3', 'API\IndividualPerformanceReportController@TransferredtoPrivateLawyerAdm3');
//-
//IPR investigation pending
Route::post('pendinginvestigation-cr', 'API\IndividualPerformanceReportController@pendingInvestigationCriminal');

Route::post('pendinginvestigation-cv', 'API\IndividualPerformanceReportController@pendingInvestigationCivil');

Route::post('pendinginvestigation-adm1', 'API\IndividualPerformanceReportController@pendingInvestigationAdm1');

Route::post('pendinginvestigation-adm2', 'API\IndividualPerformanceReportController@pendingInvestigationAdm2');

Route::post('pendinginvestigation-adm3', 'API\IndividualPerformanceReportController@pendingInvestigationAdm3');
//-
//IPR investigation received
Route::post('receivedinvestigation-cr', 'API\IndividualPerformanceReportController@receivedInvestigationCriminal');

Route::post('receivedinvestigation-cv', 'API\IndividualPerformanceReportController@receivedInvestigationCivil');

Route::post('receivedinvestigation-adm1', 'API\IndividualPerformanceReportController@receivedInvestigationAdm1');

Route::post('receivedinvestigation-adm2', 'API\IndividualPerformanceReportController@receivedInvestigationAdm2');

Route::post('receivedinvestigation-adm3', 'API\IndividualPerformanceReportController@receivedInvestigationAdm3');
//-
//IPR investigation transfer
Route::post('transferinvestigation-cr', 'API\IndividualPerformanceReportController@transferInvestigationCriminal');

Route::post('transferinvestigation-cv', 'API\IndividualPerformanceReportController@transferInvestigationCivil');

Route::post('transferinvestigation-adm1', 'API\IndividualPerformanceReportController@transferInvestigationAdm1');

Route::post('transferinvestigation-adm2', 'API\IndividualPerformanceReportController@transferInvestigationAdm2');

Route::post('transferinvestigation-adm3', 'API\IndividualPerformanceReportController@transferInvestigationAdm3');
//-
//total case filed investigation
Route::post('casefiledinvestigation', 'API\IndividualPerformanceReportController@CaseFiledInvestigation');
//-
//total case investigation
Route::post('terminated-investigation', 'API\IndividualPerformanceReportController@terminatedInvestigation');
//-
//CICL CICL
Route::post('pendingcicl-cr', 'API\IndividualReportCICLController@pendingCICLCriminal');

Route::post('pendingcicl-cv', 'API\IndividualReportCICLController@pendingCICLCivil');

Route::post('pendingcicl-adm1', 'API\IndividualReportCICLController@pendingCICLAdm1');

Route::post('pendingcicl-adm2', 'API\IndividualReportCICLController@pendingCICLAdm2');

Route::post('pendingcicl-adm3', 'API\IndividualReportCICLController@pendingCICLAdm3');

Route::post('favorable-cicl', 'API\IndividualReportCICLController@favorableCICL');

Route::post('unfavorable-cicl', 'API\IndividualReportCICLController@unfavorableCICL');

Route::post('others-cicl', 'API\IndividualReportCICLController@otherCICL');

Route::post('oaths-cicl', 'API\IndividualReportCICLController@oathsCICL');
//-
//CICL Indigenous Group
Route::post('indigenousgroup-cr', 'API\IndividualReportCICLController@pendingIndigenousGroupCriminal');

Route::post('indigenousgroup-cv', 'API\IndividualReportCICLController@pendingIndigenousGroupCivil');

Route::post('indigenousgroup-adm1', 'API\IndividualReportCICLController@pendingIndigenousGroupAdm1');

Route::post('indigenousgroup-adm2', 'API\IndividualReportCICLController@pendingIndigenousGroupAdm2');

Route::post('indigenousgroup-adm3', 'API\IndividualReportCICLController@pendingIndigenousGroupAdm3');

Route::post('favorable-indigenousgroup', 'API\IndividualReportCICLController@favorableIndigenousGroup');

Route::post('unfavorable-indigenousgroup', 'API\IndividualReportCICLController@unfavorableIndigenousGroup');

Route::post('others-indigenousgroup', 'API\IndividualReportCICLController@otherIndigenousGroup');

Route::post('oaths-indigenousgroup', 'API\IndividualReportCICLController@oathsIndigenousGroup');
//-
//CICL PWD
Route::post('pwd-cr', 'API\IndividualReportCICLController@pendingPWDCriminal');

Route::post('pwd-cv', 'API\IndividualReportCICLController@pendingPWDCivil');

Route::post('pwd-adm1', 'API\IndividualReportCICLController@pendingPWDAdm1');

Route::post('pwd-adm2', 'API\IndividualReportCICLController@pendingPWDAdm2');

Route::post('pwd-adm3', 'API\IndividualReportCICLController@pendingPWDAdm3');

Route::post('favorable-pwd', 'API\IndividualReportCICLController@favorablePWD');

Route::post('unfavorable-pwd', 'API\IndividualReportCICLController@unfavorablePWD');

Route::post('others-pwd', 'API\IndividualReportCICLController@otherPWD');

Route::post('oaths-pwd', 'API\IndividualReportCICLController@oathsPWD');
//-
//CICL UrbanPoor
Route::post('up-cr', 'API\IndividualReportCICLController@pendingUPCriminal');

Route::post('up-cv', 'API\IndividualReportCICLController@pendingUPCivil');

Route::post('up-adm1', 'API\IndividualReportCICLController@pendingUPAdm1');

Route::post('up-adm2', 'API\IndividualReportCICLController@pendingUPAdm2');

Route::post('up-adm3', 'API\IndividualReportCICLController@pendingUPAdm3');

Route::post('favorable-up', 'API\IndividualReportCICLController@favorableUP');

Route::post('unfavorable-up', 'API\IndividualReportCICLController@unfavorableUP');

Route::post('others-up', 'API\IndividualReportCICLController@otherUP');

Route::post('oaths-up', 'API\IndividualReportCICLController@oathsUP');
//-
//CICL RuralPoor
Route::post('rp-cr', 'API\IndividualReportCICLController@pendingRPCriminal');

Route::post('rp-cv', 'API\IndividualReportCICLController@pendingRPCivil');

Route::post('rp-adm1', 'API\IndividualReportCICLController@pendingRPAdm1');

Route::post('rp-adm2', 'API\IndividualReportCICLController@pendingRPAdm2');

Route::post('rp-adm3', 'API\IndividualReportCICLController@pendingRPAdm3');

Route::post('favorable-rp', 'API\IndividualReportCICLController@favorableRP');

Route::post('unfavorable-rp', 'API\IndividualReportCICLController@unfavorableRP');

Route::post('others-rp', 'API\IndividualReportCICLController@otherRP');

Route::post('oaths-rp', 'API\IndividualReportCICLController@oathsRP');
//-
//CICL OFW Land
Route::post('ofwl-cr', 'API\IndividualReportCICLController@pendingOFWLCriminal');

Route::post('ofwl-cv', 'API\IndividualReportCICLController@pendingOFWLCivil');

Route::post('ofwl-adm1', 'API\IndividualReportCICLController@pendingOFWLAdm1');

Route::post('ofwl-adm2', 'API\IndividualReportCICLController@pendingOFWLAdm2');

Route::post('ofwl-adm3', 'API\IndividualReportCICLController@pendingOFWLAdm3');

Route::post('favorable-ofwl', 'API\IndividualReportCICLController@favorableOFWL');

Route::post('unfavorable-ofwl', 'API\IndividualReportCICLController@unfavorableOFWL');

Route::post('others-ofwl', 'API\IndividualReportCICLController@otherOFWL');

Route::post('oaths-ofwl', 'API\IndividualReportCICLController@oathsOFWL');
//-
//CICL OFW SEA
Route::post('ofws-cr', 'API\IndividualReportCICLController@pendingOFWSCriminal');

Route::post('ofws-cv', 'API\IndividualReportCICLController@pendingOFWSCivil');

Route::post('ofws-adm1', 'API\IndividualReportCICLController@pendingOFWSAdm1');

Route::post('ofws-adm2', 'API\IndividualReportCICLController@pendingOFWSAdm2');

Route::post('ofws-adm3', 'API\IndividualReportCICLController@pendingOFWSAdm3');

Route::post('favorable-ofws', 'API\IndividualReportCICLController@favorableOFWS');

Route::post('unfavorable-ofws', 'API\IndividualReportCICLController@unfavorableOFWS');

Route::post('others-ofws', 'API\IndividualReportCICLController@otherOFWS');

Route::post('oaths-ofws', 'API\IndividualReportCICLController@oathsOFWS');
//-
//CICL Senior Citizen
Route::post('sc-cr', 'API\IndividualReportCICLController@pendingSCCriminal');

Route::post('sc-cv', 'API\IndividualReportCICLController@pendingSCCivil');

Route::post('sc-adm1', 'API\IndividualReportCICLController@pendingSCAdm1');

Route::post('sc-adm2', 'API\IndividualReportCICLController@pendingSCAdm2');

Route::post('sc-adm3', 'API\IndividualReportCICLController@pendingSCAdm3');

Route::post('favorable-sc', 'API\IndividualReportCICLController@favorableSC');

Route::post('unfavorable-sc', 'API\IndividualReportCICLController@unfavorableSC');

Route::post('others-sc', 'API\IndividualReportCICLController@otherSC');

Route::post('oaths-sc', 'API\IndividualReportCICLController@oathsSC');
//-
//CICL (Human Security Act)
Route::post('hsa-cr', 'API\IndividualReportCICLController@pendingHSACriminal');

Route::post('hsa-cv', 'API\IndividualReportCICLController@pendingHSACivil');

Route::post('hsa-adm1', 'API\IndividualReportCICLController@pendingHSAAdm1');

Route::post('hsa-adm2', 'API\IndividualReportCICLController@pendingHSAAdm2');

Route::post('hsa-adm3', 'API\IndividualReportCICLController@pendingHSAAdm3');

Route::post('favorable-hsa', 'API\IndividualReportCICLController@favorableHSA');

Route::post('unfavorable-hsa', 'API\IndividualReportCICLController@unfavorableHSA');

Route::post('others-hsa', 'API\IndividualReportCICLController@otherHSA');

Route::post('oaths-hsa', 'API\IndividualReportCICLController@oathsHSA');
//-
//CICL (Anti Torture-Law)
Route::post('atl-cr', 'API\IndividualReportCICLController@pendingATLCriminal');

Route::post('atl-cv', 'API\IndividualReportCICLController@pendingATLCivil');

Route::post('atl-adm1', 'API\IndividualReportCICLController@pendingATLAdm1');

Route::post('atl-adm2', 'API\IndividualReportCICLController@pendingATLAdm2');

Route::post('atl-adm3', 'API\IndividualReportCICLController@pendingATLAdm3');

Route::post('favorable-atl', 'API\IndividualReportCICLController@favorableATL');

Route::post('unfavorable-atl', 'API\IndividualReportCICLController@unfavorableATL');

Route::post('others-atl', 'API\IndividualReportCICLController@otherATL');

Route::post('oaths-atl', 'API\IndividualReportCICLController@oathsATL');
//-
//CICL Rape Victim
Route::post('rv-cr', 'API\IndividualReportCICLController@pendingRVCriminal');

Route::post('rv-cv', 'API\IndividualReportCICLController@pendingRVCivil');

Route::post('rv-adm1', 'API\IndividualReportCICLController@pendingRVAdm1');

Route::post('rv-adm2', 'API\IndividualReportCICLController@pendingRVAdm2');

Route::post('rv-adm3', 'API\IndividualReportCICLController@pendingRVAdm3');

Route::post('favorable-rv', 'API\IndividualReportCICLController@favorableRV');

Route::post('unfavorable-rv', 'API\IndividualReportCICLController@unfavorableRV');

Route::post('others-rv', 'API\IndividualReportCICLController@otherRV');

Route::post('oaths-rv', 'API\IndividualReportCICLController@oathsRV');
//-
//CICL ANTI-TRAFFICKING IN PERSONS
Route::post('atip-cr', 'API\IndividualReportCICLController@pendingATIPCriminal');

Route::post('atip-cv', 'API\IndividualReportCICLController@pendingATIPCivil');

Route::post('atip-adm1', 'API\IndividualReportCICLController@pendingATIPAdm1');

Route::post('atip-adm2', 'API\IndividualReportCICLController@pendingATIPAdm2');

Route::post('atip-adm3', 'API\IndividualReportCICLController@pendingATIPAdm3');

Route::post('favorable-atip', 'API\IndividualReportCICLController@favorableATIP');

Route::post('unfavorable-atip', 'API\IndividualReportCICLController@unfavorableATIP');

Route::post('others-atip', 'API\IndividualReportCICLController@otherATIP');

Route::post('oaths-atip', 'API\IndividualReportCICLController@oathsATIP');
//-
//COMPREHENSIVE DANGEROUS DRUGS CICL
Route::post('cdd-cr', 'API\IndividualReportCICLController@pendingCDDCriminal');

Route::post('cdd-cv', 'API\IndividualReportCICLController@pendingCDDCivil');

Route::post('cdd-adm1', 'API\IndividualReportCICLController@pendingCDDAdm1');

Route::post('cdd-adm2', 'API\IndividualReportCICLController@pendingCDDAdm2');

Route::post('cdd-adm3', 'API\IndividualReportCICLController@pendingCDDAdm3');

Route::post('favorable-cdd', 'API\IndividualReportCICLController@favorableCDD');

Route::post('unfavorable-cdd', 'API\IndividualReportCICLController@unfavorableCDD');

Route::post('others-cdd', 'API\IndividualReportCICLController@otherCDD');

Route::post('oaths-cdd', 'API\IndividualReportCICLController@oathsCDD');
//-
//Agrarian Case CICL
Route::post('ac-cr', 'API\IndividualReportCICLController@pendingACCriminal');

Route::post('ac-cv', 'API\IndividualReportCICLController@pendingACCivil');

Route::post('ac-adm1', 'API\IndividualReportCICLController@pendingACAdm1');

Route::post('ac-adm2', 'API\IndividualReportCICLController@pendingACAdm2');

Route::post('ac-adm3', 'API\IndividualReportCICLController@pendingACAdm3');

Route::post('favorable-ac', 'API\IndividualReportCICLController@favorableAC');

Route::post('unfavorable-ac', 'API\IndividualReportCICLController@unfavorableAC');

Route::post('others-ac', 'API\IndividualReportCICLController@otherAC');

Route::post('oaths-ac', 'API\IndividualReportCICLController@oathsAC');
//-
//Refugee CICL
Route::post('re-cr', 'API\IndividualReportCICLController@pendingRECriminal');

Route::post('re-cv', 'API\IndividualReportCICLController@pendingRECivil');

Route::post('re-adm1', 'API\IndividualReportCICLController@pendingREAdm1');

Route::post('re-adm2', 'API\IndividualReportCICLController@pendingREAdm2');

Route::post('re-adm3', 'API\IndividualReportCICLController@pendingREAdm3');

Route::post('favorable-re', 'API\IndividualReportCICLController@favorableRE');

Route::post('unfavorable-re', 'API\IndividualReportCICLController@unfavorableRE');

Route::post('others-re', 'API\IndividualReportCICLController@otherRE');

Route::post('oaths-re', 'API\IndividualReportCICLController@oathsRE');
//-
//Non-Filipino CICL
Route::post('nf-cr', 'API\IndividualReportCICLController@pendingNFCriminal');

Route::post('nf-cv', 'API\IndividualReportCICLController@pendingNFCivil');

Route::post('nf-adm1', 'API\IndividualReportCICLController@pendingNFAdm1');

Route::post('nf-adm2', 'API\IndividualReportCICLController@pendingNFAdm2');

Route::post('nf-adm3', 'API\IndividualReportCICLController@pendingNFAdm3');

Route::post('favorable-nf', 'API\IndividualReportCICLController@favorableNF');

Route::post('unfavorable-nf', 'API\IndividualReportCICLController@unfavorableNF');

Route::post('others-nf', 'API\IndividualReportCICLController@otherNF');

Route::post('oaths-nf', 'API\IndividualReportCICLController@oathsNF');
//-
//VAWC Women CICL
Route::post('vw-cr', 'API\IndividualReportCICLController@pendingVWCriminal');

Route::post('vw-cv', 'API\IndividualReportCICLController@pendingVWCivil');

Route::post('vw-adm1', 'API\IndividualReportCICLController@pendingVWAdm1');

Route::post('vw-adm2', 'API\IndividualReportCICLController@pendingVWAdm2');

Route::post('vw-adm3', 'API\IndividualReportCICLController@pendingVWAdm3');

Route::post('terminated-vw', 'API\IndividualReportCICLController@terminatedVW');

Route::post('oaths-vw', 'API\IndividualReportCICLController@oathsVW');
//-
//VAWC Children CICL
Route::post('vc-cr', 'API\IndividualReportCICLController@pendingVCCriminal');

Route::post('vc-cv', 'API\IndividualReportCICLController@pendingVCCivil');

Route::post('vc-adm1', 'API\IndividualReportCICLController@pendingVCAdm1');

Route::post('vc-adm2', 'API\IndividualReportCICLController@pendingVCAdm2');

Route::post('vc-adm3', 'API\IndividualReportCICLController@pendingVCAdm3');

Route::post('terminated-vc', 'API\IndividualReportCICLController@terminatedVC');

Route::post('oaths-vc', 'API\IndividualReportCICLController@oathsVC');
//-
Route::apiResource('individual-performance-report', 'API\IndividualPerformanceReportController');

Route::apiResource('individual-report-cicl', 'API\IndividualReportCICLController');

Route::post('individual-report-cicls', 'API\IndividualReportCICLController@loadReport');

Route::apiResource('inquest-report', 'API\InquestReportController');

Route::post('inquest-reports', 'API\InquestReportController@loadReport');

Route::post('list-detainees-represented-court', 'API\ListDetaineesRepresentedCourtController@store');

Route::post('list-detainees-represented-courts', 'API\ListDetaineesRepresentedCourtController@loadReport');

Route::apiResource('list-favorable-decision', 'API\ListFavorableDecisionDispositionController');

Route::apiResource('document-notarized', 'API\DocumentNotarizedController');

Route::apiResource('monthly-inventory-cases', 'API\MonthlyInventoryCasesController');

Route::post('monthly-inventory-served', 'API\MonthlyInventoryCasesController@loadReport');

Route::post('list-favorable-decisions', 'API\ListFavorableDecisionDispositionController@loadReport');

Route::post('document-notarizeds', 'API\DocumentNotarizedController@loadReport');

Route::post('report-victims-cases-handleds', 'API\ReportVictimsCasesHandledController@loadReport');

Route::post('monthly-inventory-cases-criminal', 'API\MonthlyInventoryCasesController@Criminal');

Route::post('monthly-inventory-cases-civil', 'API\MonthlyInventoryCasesController@Civil');

Route::post('monthly-inventory-cases-labor', 'API\MonthlyInventoryCasesController@Labor');

Route::post('monthly-inventory-cases-adm', 'API\MonthlyInventoryCasesController@Adm');

Route::apiResource('report-victims-cases-handled', 'API\ReportVictimsCasesHandledController');

Route::apiResource('calendar', 'API\CalendarController');

Route::apiResource('dashboard', 'API\DashboardController');

Route::get('markAsRead/{id}', 'API\DashboardController@markAsReadNotification');

Route::get('audit', 'API\UserController@audit');

Route::get('all-audit', 'API\UserController@allAudit');

Route::post('client-status', 'API\FormController@updateClientStatus');

