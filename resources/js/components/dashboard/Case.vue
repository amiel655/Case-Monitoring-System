<template>
    <div class="pt-4 container-fluid">
        <div class="loader" v-show="loading">
            <rotate-loader :loading="loading" :color="'#34cc7d'" :size="'20px'"></rotate-loader>
        </div>
        <div v-if="!$gate.isAdminAndSuperAdmin()">
            <not-found></not-found>
        </div>
        <div v-if="notFound">
            <not-found></not-found>
        </div>
        <form v-if="$gate.isAdminAndSuperAdmin() && cases.case_no !== ''" @submit.prevent="updateCase" class="pt-3">
            <div class="row card-border shadow pb-4" style="background: #fff;">
                <div class="col-md-12">
                    <div class="card-title text-center shadow client-header-card">
                        Case Info and Summary
                    </div>
                </div>
                <br><br><br><br><br><br>
                <div class="col-md-1 case-num">
                    <span class="case-vert">
                        <div class="cnum-b">
                            <h5>Case No.</h5>
                        </div>
                        <h5 class="space-t">{{ cases.case_no }}</h5>
                    </span>
                </div>
                <div class="col-12 back-hr">

                </div>
                <div v-show="!isUpdateMode || tabs === 'Summary'" class="col-md-12 case-title">
                    <div class="title-h">
                        <span class="c-title move-pos">
                            <label for="case_title" class="mob-title">Case Title:</label>
                            <span class="move-t">
                                {{ cases.case_title }}
                            </span>
                            <span class="badge" :class="{'bg-success': hearing[0].case_status === 'Pending', 'bg-primary': hearing[0].case_status === 'Arraignment', 'bg-secondary': hearing[0].case_status === 'Pre-Trial', 'bg-warning': hearing[0].case_status === 'Prosecution Evidence', 'bg-info': hearing[0].case_status === 'Defense Evidence', 'bg-danger': hearing[0].case_status !== 'Pending' && hearing[0].case_status !== 'Arraignment' && hearing[0].case_status !== 'Pre-Trial' && hearing[0].case_status !== 'Prosecution Evidence' && hearing[0].case_status !== 'Defense Evidence'}">
                                <span v-show="hearing[0].case_status !== 'Pending' && hearing[0].case_status !== 'Arraignment' && hearing[0].case_status !== 'Pre-Trial' && hearing[0].case_status !== 'Prosecution Evidence' && hearing[0].case_status !== 'Defense Evidence'">Terminated:
                                </span>{{ hearing[0].case_status }}</span>
                        </span>
                    </div>
                </div><br>

                <div class="col-md-12 text-right">
                    <div v-show="!isUpdateMode" class="a-code">
                        <label>Access Code: </label>
                        <span class="badge badge-primary pt-1 px-2">
                            {{ cases.access_code }}
                        </span>
                    </div>
                </div>

                <div class="col-md-12 pt-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item" v-show="!isUpdateMode">
                            <a class="nav-link" :class="{'active' : tabs === 'Info'}" @click="tabs = 'Info'">Case Info</a>
                        </li>
                        <li class="nav-item" v-show="!isUpdateMode">
                            <a class="nav-link" :class="{'active' : tabs === 'Summary'}" @click="tabs = 'Summary'">Case
                                Summary</a>
                        </li>
                        <li class="nav-item ml-auto text-right pt-1" v-if="hearing[0].case_status === 'Pending' || hearing[0].case_status === 'Arraignment' || hearing[0].case_status === 'Pre-Trial' || hearing[0].case_status === 'Prosecution Evidence' || hearing[0].case_status === 'Defense Evidence' || hearing[0].case_status === 'Provisionally Dismissed' || hearing[0].case_status === 'Archived'">
                            <button v-show="!isUpdateMode && tabs === 'Info'" type="button" class="btn btn-primary"
                                @click="isUpdateMode = true; checkSummary"><i class="material-icons">update</i> Update
                                Info</button>
                            <button v-show="!isUpdateMode && tabs === 'Summary' && hearing[0].hearing_date" type="button"
                                class="btn btn-primary" @click="isUpdateMode = true; checkSummary"><i class="material-icons">update</i>
                                Update Summary</button>
                        </li>
                        <li class="nav-item p-1 pt-1" :class="{'ml-auto text-right' : isUpdateMode === true}">
                            <button v-show="isUpdateMode" type="button" class="btn btn-success" @click="cancel"><i
                                    class="material-icons">cancel</i>
                                Cancel</button>

                        </li>
                        <li class="nav-item p-1 pt-1">
                            <button v-show="isUpdateMode" type="submit" class="btn btn-success"><i class="material-icons">save</i>
                                Save Changes</button>
                        </li>
                        <a :href="'clients/' + $route.params.id">
                            <li class="nav-item p-1">
                                <button type="button" class="btn btn-success"><i class="material-icons">visibility</i>
                                    View Form</button>
                            </li>
                        </a>
                    </ul>
                </div>

                <div v-show="!isUpdateMode" class="col-md-12 pb-3 pt-5" v-if="tabs === 'Info'">
                    <div class="case-cont">
                        <div class="case-sum">
                            INFO
                        </div>
                        <div class="row case-info-responsive justify-content-center col-md-12 pt-3 text-center">
                            <div v-show="!isUpdateMode" class="col-md-4">
                                <label>Name: </label>
                                {{ cases.client_name }}
                            </div>
                            <div v-show="!isUpdateMode" class="col-md-4">
                                <label>Age: </label>
                                {{ cases.client_age }}
                            </div>
                            <div v-show="!isUpdateMode" class="col-md-4">
                                <div v-show="hearing[0].hearing_date" class="form-group">
                                    <label>Hearing Date</label>
                                    {{ hearing[0].hearing_date | renderDate }}
                                </div>
                            </div>
                        </div>

                        <div v-show="!isUpdateMode" class="card-border col-md-12">
                            <div class="row">
                                <div v-show="!isUpdateMode" class="col-md-5 pt-3">
                                    <div class="form-group">
                                        <label for="court">Court: </label><br>
                                        <span class="ml-3">{{ cases.court }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="detained">Detained: </label><br>
                                        <span class="ml-3">{{ cases.detained }}</span>
                                    </div>
                                </div>


                                <div v-show="!isUpdateMode" class="col-md-5 pt-3">
                                    <div class="form-group">
                                        <label v-show="cases.crimes.length === 1" for="case_crime" style="width: 100%">Crime:
                                        </label>
                                        <label v-show="cases.crimes.length > 1" for="case_crime" style="width: 100%">Crimes:
                                        </label>
                                        <ul v-for="crime in cases.crimes" :key="crime.id">
                                            <li>{{ crime }}</li>
                                        </ul>
                                    </div>
                                    <div class="form-group">
                                        <label v-show="cases.complainants.length === 1" for="case_complainant" style="width: 100%">Complainant:
                                        </label>
                                        <label v-show="cases.complainants.length > 1" for="case_complainant" style="width: 100%">Complainants:
                                        </label>
                                        <ul v-for="complainant in cases.complainants" :key="complainant.id">
                                            <li>{{ complainant }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div v-show="!isUpdateMode" class="col-md-2 pt-3">
                                    <div class="form-group">
                                        <label v-show="cases.respondents.length === 1" for="case_respondent" style="width: 100%">Respondent:
                                        </label>
                                        <label v-show="cases.respondents.length > 1" for="case_respondent" style="width: 100%">Respondents:
                                        </label>
                                        <ul v-for="respondent in cases.respondents" :key="respondent.id">
                                            <li>{{ respondent }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="!isUpdateMode" class="col-md-12 pb-3 pt-5" v-if="tabs === 'Summary'">
                    <div v-show="!hearing[0].hearing_date" class="text-center">
                        <h3>No Summary to Update</h3>
                        <i>Update Case Info to Add Hearing Date</i>
                    </div>
                    <div class="case-cont" v-show="hearing[0].hearing_date">
                        <div class="case-sum">
                            SUMMARY
                        </div>
                        <div v-if="hearing.length !== 0" class="pt-2" v-for="data in hearing" :key="data.id">
                            <div class="card card-summary">
                                <div class="card-header" :class="{'bg-success': data.case_status === 'Pending', 'bg-primary': data.case_status === 'Arraignment', 'bg-secondary': data.case_status === 'Pre-Trial', 'bg-warning': data.case_status === 'Prosecution Evidence', 'bg-info': data.case_status === 'Defense Evidence', 'bg-danger': data.case_status !== 'Pending' && data.case_status !== 'Arraignment' && data.case_status !== 'Pre-Trial' && data.case_status !== 'Prosecution Evidence' && data.case_status !== 'Defense Evidence'}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span v-show=" data.case_status !== 'Pending' && data.case_status !== 'Arraignment' && data.case_status !== 'Pre-Trial' && data.case_status !== 'Prosecution Evidence' && data.case_status !== 'Defense Evidence'">Terminated:
                                            </span>{{data.case_status }}
                                        </div>
                                        <div class="col-md-6 text-right"> <span class="mx-auto text-right">{{
                                                data.hearing_date | renderDate }}</span></div>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div v-if="data.case_summary !== null">
                                        <froalaView v-model="data.case_summary"></froalaView>
                                    </div>
                                    <div v-if="data.case_summary == null">
                                        <p class="card-text">No Summary</p>
                                    </div>
                                </div>
                            </div>
                        </div><br>
                    </div>
                </div><br><br>
                <div v-show="isUpdateMode" class="col-md-12 row pt-2">
                    <div class="col-md-12" v-if="tabs === 'Info'">
                        <div class="text-right">
                            <div v-show="isUpdateMode" class="form-group">
                                <label for="access_code" class="form__label">Access Code</label>
                                <label class="m-2 switch">
                                    <input type="checkbox" @click="codeStatus()" class="access_code">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" v-if="tabs === 'Info'">

                        <div class="form-group form-inline" v-show="authUser.type === 'Super Admin'">
                            <label class="form__label">Transfer To</label>
                            <div class="dropdown pl-1">
                                <button class="btn btn-outline-success dropdown-toggle form__input" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span v-show="cases.assigned_to === ''">Select Lawyer</span>
                                    <span v-show="cases.assigned_to !== ''">{{ cases.assigned_to }}</span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" v-for="atty in attorneys" :key="atty.id" v-if="atty.type !== 'Staff' && atty.status !== 'Unavailable'"
                                        :value="atty.firstname + ' ' + atty.lastname" @click="cases.assigned_to = atty.firstname + ' ' + atty.lastname">
                                        {{atty.firstname}} {{atty.lastname}}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div v-show="isUpdateMode" class="form-inline">
                                <div class="form-group">
                                    <label>Next Hearing Date</label>
                                    <datepicker class="pl-1 form-calendar form__input" :disabled-dates="disabledPastDates"
                                        :format="'MMM. dd, yyyy'" v-model="cases.hearing_date" placeholder="Choose Hearing Date"
                                        @input="convertDate('Add Hearing', 0)"></datepicker>
                                </div>

                            </div>
                        </div>

                        <div class="form-group" :class="{ 'form-group--error': $v.cases.case_title.$error }">
                            <label for="case_title" class="form__label">Case Title</label>
                            <input type="text" v-model="cases.case_title" v-model.trim="$v.cases.case_title.$model"
                                name="case_title" class="form-control form__input" placeholder="">
                        </div>
                        <div class="error" v-if="!$v.cases.case_title.required">Case Title
                            is required.</div>

                        <div class="form-group" :class="{ 'form-group--error': $v.cases.court.$error }">
                            <label for="court" class="form__label">Court</label>
                            <input type="text" v-model="cases.court" v-model.trim="$v.cases.court.$model" name="court"
                                class="form-control form__input" placeholder="">
                        </div>
                        <div class="error" v-if="!$v.cases.court.required">Court
                            is required.</div>
                        <div class="form-group" :class="{ 'form-group--error': $v.cases.detained.$error }">
                            <label for="detained" class="form__label">Detained</label>
                            <input type="text" v-model="cases.detained" v-model.trim="$v.cases.detained.$model" name="detained"
                                class="form-control form__input" placeholder="">
                        </div>
                        <div class="error" v-if="!$v.cases.detained.required">Detained
                            is required.</div>
                        <div class="form-group" :class="{ 'form-group--error': $v.cases.crimes.$error }">
                            <label v-show="cases.crimes.length === 1" for="case_crime" style="width: 100%" class="form__label">Crime
                                <button type="button" class="btn btn-sm btn-success float-right" @click="addCrime()"><i
                                        class="material-icons" style="font-size: 16px !important;">add</i> Add Crime</button></label>
                            <label v-show="cases.crimes.length > 1" for="case_crime" style="width: 100%" class="form__label">Crimes
                                <button type="button" class="btn btn-sm btn-success float-right" @click="addCrime()"><i
                                        class="material-icons" style="font-size: 16px !important;">add</i> Add Crime</button></label>
                            <div v-for="(crimes, index) in cases.crimes" :key="crimes.id" class="input-group mb-3">
                                <input type="text" v-model="cases.crimes[index]" class="form-control form__input"
                                    placeholder="Example Sec. 5 (0.108g) - CC# 26333, Frustated Homicide" aria-label="Example Sec. 5 (0.108g) - CC# 26333, Frustated Homicide"
                                    aria-describedby="basic-addon2">
                                <div v-show="index != 0" class="input-group-append">
                                    <button class="btn btn-outline-danger" type="button" @click="removeCrime(index)">Remove</button>
                                </div>
                            </div>
                        </div>
                        <div class="error" v-if="!$v.cases.crimes.required">Crimes
                            is required.</div>
                    </div>

                    <div class="col-md-6" v-if="tabs === 'Info'">
                        <div class="form-group text-right mx-auto">
                            <div class="input-group ml-auto" style="width: 300px !important">
                                <input class="form-control text-center" v-model="cases.access_code" aria-label=""
                                    aria-describedby="basic-addon2" readonly disabled>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger" @click="generateAccessCode">Generate
                                        Access Code</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-inline" style="visibility: hidden">
                            <label></label>
                            <input>
                        </div>
                        <div class="form-group">
                            <label v-show="cases.complainants.length === 1" for="case_complainant" style="width: 100%">Complainant
                                <button type="button" class="btn btn-sm btn-success float-right" @click="addComplainant()"><i
                                        class="material-icons" style="font-size: 16px !important;">add</i> Add
                                    Complainant</button></label>
                            <label v-show="cases.complainants.length > 1" for="case_complainant" style="width: 100%">Complainants
                                <button type="button" class="btn btn-sm btn-success float-right" @click="addComplainant()"><i
                                        class="material-icons" style="font-size: 16px !important;">add</i> Add
                                    Complainant</button></label>
                            <div v-for="(complainants, index) in cases.complainants" :key="complainants.id" class="input-group mb-3">
                                <input type="text" v-model="cases.complainants[index]" class="form-control" placeholder=""
                                    aria-label="" aria-describedby="basic-addon2">
                                <div v-show="index != 0" class="input-group-append">
                                    <button class="btn btn-outline-danger" type="button" @click="removeComplainant(index)">Remove</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label v-show="cases.respondents.length === 1" for="case_respondent" style="width: 100%">Respondent
                                <button type="button" class="btn btn-sm btn-success float-right" @click="addRespondent()"><i
                                        class="material-icons" style="font-size: 16px !important;">add</i> Add
                                    Respondent</button></label>
                            <label v-show="cases.respondents.length > 1" for="case_respondent" style="width: 100%">Respondents
                                <button type="button" class="btn btn-sm btn-success float-right" @click="addRespondent()"><i
                                        class="material-icons" style="font-size: 16px !important;">add</i> Add
                                    Respondent</button></label>
                            <div v-for="(respondents, index) in cases.respondents" :key="respondents.id" class="input-group mb-3">
                                <input type="text" v-model="cases.respondents[index]" class="form-control" placeholder=""
                                    aria-label="" aria-describedby="basic-addon2">
                                <div v-show="index != 0" class="input-group-append">
                                    <button class="btn btn-outline-danger" type="button" @click="removeRespondent(index)">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 pt-5 pb-3" v-if="tabs === 'Summary'">
                        <div v-if="hearing.length == 0 || hearing[0].hearing_date == null" class="text-center">
                            <h4>No Summary to Update</h4>
                        </div>
                        <div v-if="hearing[0].hearing_date !== undefined" class="pt-2" v-for="(data, index) in hearing"
                            :key="data.id">

                            <div class="card card-summary">
                                <div class="card-header" :class="{'bg-success': data.case_status === 'Pending', 'bg-primary': data.case_status === 'Arraignment', 'bg-secondary': data.case_status === 'Pre-Trial', 'bg-warning': data.case_status === 'Prosecution Evidence', 'bg-info': data.case_status === 'Defense Evidence', 'bg-danger': data.case_status !== 'Pending' && data.case_status !== 'Arraignment' && data.case_status !== 'Pre-Trial' && data.case_status !== 'Prosecution Evidence' && data.case_status !== 'Defense Evidence'}">
                                    <div class="row">
                                        <div class="col-md-6 text-left" v-if="hearingHasPassed(data.hearing_date)">
                                            <!-- <span class="mx-auto text-right">{{ data.hearing_date | renderDate }}</span> -->
                                            <div class="input-group">
                                                <datepicker class="pl-1 form-calendar form__input" :disabled-dates="disabledPastDates"
                                                    :format="'MMM. dd, yyyy'" v-model="data.hearing_date" placeholder="Choose Hearing Date"
                                                    @input="convertDate('Update Hearing', index)" aria-label=""
                                                    aria-describedby="basic-addon2" style="color: #000 !important"></datepicker>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger" @click="removeHearing(data)"><i
                                                            class="material-icons" style="font-size: 15px !important">delete</i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-left" v-if="!hearingHasPassed(data.hearing_date)">
                                            <div class="pt-2">{{ data.hearing_date | renderDate }}</div>
                                        </div>
                                        <div class="col-md-6 text-right" v-if="hearingHasPassed(data.hearing_date)">
                                            <div class="pt-2">
                                                <span v-show=" data.case_status !== 'Pending' && data.case_status !== 'Arraignment' && data.case_status !== 'Pre-Trial' && data.case_status !== 'Prosecution Evidence' && data.case_status !== 'Defense Evidence'">Terminated:
                                                </span>{{data.case_status }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-right" v-if="!hearingHasPassed(data.hearing_date)">
                                            <div class="ml-1 dropdown">
                                                <button class="btn dropdown-toggle form__input" :class="{'bg-success': data.case_status === 'Pending', 'bg-primary': data.case_status === 'Arraignment', 'bg-secondary': data.case_status === 'Pre-Trial', 'bg-warning': data.case_status === 'Prosecution Evidence', 'bg-info': data.case_status === 'Defense Evidence', 'bg-danger': data.case_status !== 'Pending' && data.case_status !== 'Arraignment' && data.case_status !== 'Pre-Trial' && data.case_status !== 'Prosecution Evidence' && data.case_status !== 'Defense Evidence'}"
                                                    type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" style="border: 2px solid #fff">
                                                    <span v-if="data.case_status !== 'Criminal Cases for Preliminary Investigation'">{{data.case_status}}</span>
                                                    <span v-if="data.case_status === 'Criminal Cases for Preliminary Investigation'">Terminated:
                                                        Criminal Case</span>
                                                </button>
                                                <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuButton">
                                                    <h6 class="dropdown-header text-left">Active Dispositions</h6>
                                                    <a class="dropdown-item" @click="data.case_status = 'Pending'">
                                                        <span class="pl-2"></span> Pending
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Arraignment'">
                                                        <span class="pl-2"></span> Arraignment
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Pre-Trial'">
                                                        <span class="pl-2"></span> Pre-Trial
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Prosecution Evidence'">
                                                        <span class="pl-2"></span> Prosecution Evidence
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Defense Evidence'">
                                                        <span class="pl-2"></span> Defense Evidence
                                                    </a>
                                                    <h6 class="dropdown-header text-left">Favorable Dispositions</h6>
                                                    <a class="dropdown-item" @click="data.case_status = 'Acquitted'">
                                                        <span class="pl-2"></span> Acquitted
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Dismissed with Prejudice'">
                                                        <span class="pl-2"></span> Dismissed with Prejudice
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Motion to Quash Granted'">
                                                        <span class="pl-2"></span> Motion to Quash Granted
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Demurrer to Evidence Granted'">
                                                        <span class="pl-2"></span> Demurrer to Evidence Granted
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Provisionally Dismissed'">
                                                        <span class="pl-2"></span> Provisionally Dismissed
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Convicted to Lesser Offense'">
                                                        <span class="pl-2"></span> Convicted to Lesser Offense
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Probation Granted'">
                                                        <span class="pl-2"></span> Probation Granted
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Won'">
                                                        <span class="pl-2"></span> Won
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Granted Lesser Award'">
                                                        <span class="pl-2"></span> Granted Lesser Award
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Dismissed Cases Based on Comprise Agreement'">
                                                        <span class="pl-2"></span> Dismissed Cases Based on Comprise
                                                        Agreement
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Favorable: Case Filed in Court (complainant)'">
                                                        <span class="pl-2"></span> Case Filed in Court (complainant)
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Favorable: Dismissed (respondent)'">
                                                        <span class="pl-2"></span> Dismissed (respondent)
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Bail'">
                                                        <span class="pl-2"></span> Bail
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Recognizance'">
                                                        <span class="pl-2"></span> Recognizance
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Diversion Proceedings/Intervention'">
                                                        <span class="pl-2"></span> Diversion Proceedings/Intervention
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Suspended Sentence'">
                                                        <span class="pl-2"></span> Suspended Sentence
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Maximum Imposable Penalty Served'">
                                                        <span class="pl-2"></span> Maximum Imposable Penalty Served
                                                    </a>
                                                    <h6 class="dropdown-header text-left">Unfavorable Dispositions</h6>
                                                    <a class="dropdown-item" @click="data.case_status = 'Convicted as Charged'">
                                                        <span class="pl-2"></span> Convicted as Charged
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Lost'">
                                                        <span class="pl-2"></span> Lost
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Dismissed (civil, administrative & labor)'">
                                                        <span class="pl-2"></span> Dismissed (civil, administrative &
                                                        labor)
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Unfavorable: Dismissed (complainant)'">
                                                        <span class="pl-2"></span> Dismissed (complainant)
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Unfavorable: Dismissed (respondent)'">
                                                        <span class="pl-2"></span> Dismissed (respondent)
                                                    </a>
                                                    <h6 class="dropdown-header text-left">Other Dispositions</h6>
                                                    <a class="dropdown-item" @click="data.case_status = 'Archived'">
                                                        <span class="pl-2"></span> Archived
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Withdrawn'">
                                                        <span class="pl-2"></span> Withdrawn
                                                    </a>
                                                    <a class="dropdown-item" @click="data.case_status = 'Transferred to Private Lawyer, IBP, etc.'">
                                                        <span class="pl-2"></span> Transferred to Private Lawyer, IBP,
                                                        etc.
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">

                                    <div v-if="hearingHasPassed(data.hearing_date)">
                                        <froalaView v-model="data.case_summary"></froalaView>
                                    </div>
                                    <div v-if="hearingHasPassed(data.hearing_date) && !data.case_summary">
                                        <h3 class="text-center">This hearing has not been passed yet...</h3>
                                    </div>
                                    <div v-if="!hearingHasPassed(data.hearing_date)">
                                        <froala :config="config" v-model="data.case_summary"></froala>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form><br>
    </div>
</template>

<script>
    import {
        required,
        requiredIf,
        minLength,
        maxLength,
        alpha,
        email,
        between
    } from 'vuelidate/lib/validators';
    import Datepicker from 'vuejs-datepicker';
    import RotateLoader from "vue-spinner/src/RotateLoader.vue";
    export default {
        components: {
            Datepicker,
            RotateLoader
        },
        data() {
            return {
                loading: true,
                notFound: false,
                tabs: 'Info',
                disabledPastDates: {
                    to: new Date(Date.now() - 8640000)
                },
                recentStatus: '',
                codeEnabled: false,
                isUpdateMode: false,
                authUser: new Form({
                    firstname: '',
                    middlename: '',
                    lastname: '',
                    gender: '',
                    username: '',
                    type: '',
                    status: '',
                }),
                attorneys: {},
                dates: [],
                hearing: new Form({
                    case_no: '',
                    case_status: '',
                    hearing_date: '',
                    case_summary: '',
                }),
                config: {
                    placeholderText: 'Enter Summary Here',
                    toolbarButtons: ['bold', 'italic', 'underline', 'align', 'color', 'fontFamily', 'fontSize',
                        'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'quote', 'clearFormatting'
                    ],
                    quickInsertTags: ['']
                },
                cases: new Form({
                    id: '',
                    assigned_from: '',
                    assigned_to: '',
                    access_status: 'Disabled',
                    access_code: '',
                    control_num: '',
                    case_no: '',
                    case_title: '',
                    case_summary: '',
                    court: '',
                    crimes: '',
                    detained: '',
                    complainants: '',
                    respondents: '',
                    status: '',
                    client_name: '',
                    client_age: '',
                    start_date: '',
                    hearing_date: ''
                })
            }
        },
        validations: {
            cases: {
                case_no: {
                    required
                },
                case_title: {
                    required
                },
                status: {
                    required
                },
                court: {
                    required
                },
                crimes: {
                    required
                },
                complainants: {
                    required
                },
                respondents: {
                    required
                },
                detained: {
                    required
                }
            }
        },
        methods: {
            convertDate(type, index) {
                if (type === 'Add Hearing') {
                    this.cases.hearing_date = window.moment(this.cases.hearing_date).format('YYYY-MM-DD')
                } else {
                    this.hearing[index].hearing_date = window.moment(this.hearing[index].hearing_date).format(
                        'YYYY-MM-DD')
                }
            },
            loadAuthUser() {
                axios.get('api/profile').then(({
                    data
                }) => {
                    this.authUser = data
                })
            },
            loadCase() {
                if (this.$gate.isAdminAndSuperAdmin()) {
                    axios.get('api/cases/' + this.$route.params.id).then(({
                        data
                    }) => {
                        let authName = this.authUser.firstname + ' ' + this.authUser.lastname
                        let assignedName = data[0][0].assigned_to

                        if ((authName === assignedName && !this.$gate.isSuperAdmin()) || (this.$gate.isStaffAndSuperAdmin())) {
                            this.cases.fill(data[0][0])
                            this.recentStatus = data[0][0].status
                            if (data[1].length === 0) {
                                this.hearing[0] = {
                                    case_no: this.cases.case_no,
                                    case_status: this.cases.status,
                                    hearing_date: this.cases.hearing_date,
                                    case_summary: this.cases.case_summary
                                }
                            } else {
                                this.hearing = data[1]
                                for (let i = 0; i < this.hearing.length; i++) {
                                    this.dates.push(this.hearing[i].hearing_date)
                                }
                                this.dates = Array.from(new Set(this.dates))
                            }
                            this.cases.assigned_from = this.cases.assigned_to
                            this.cases.complainants = data[0][0].complainant.split(',')
                            this.cases.crimes = data[0][0].crime.split(',')
                            this.cases.respondents = data[0][0].respondent.split(',')
                            setTimeout(() => {
                                if (this.cases.access_status === 'Enabled') {
                                    this.$el.querySelector('.access_code').checked = true
                                    this.codeEnabled = true
                                } else {
                                    this.$el.querySelector('.access_code').checked = false
                                    this.codeEnabled = false
                                }
                            }, 1000)
                        } else {
                            return false
                        }
                        setTimeout(() => {
                            window.jQuery('.loader').fadeOut()
                            if (this.cases.case_no.length === 0) {
                                this.notFound = true
                            }
                            this.form.loading = false
                        }, 2000);
                    })
                }
            },
            codeStatus() {
                this.codeEnabled = !this.codeEnabled
                if (!this.codeEnabled) {
                    this.cases.access_status = 'Disabled'
                } else {
                    this.cases.access_status = 'Enabled'
                }
            },
            updateCase() {
                if (this.$gate.isAdminAndSuperAdmin()) {
                    if (this.hearing[0].case_status !== 'Pending' && this.hearing[0].case_status !== 'Arraignment' &&
                        this.hearing[0].case_status !== 'Pre-Trial' && this.hearing[0].case_status !==
                        'Prosecution Evidence' && this.hearing[0].case_status !== 'Defense Evidence' && this.hearing[0]
                        .case_status !== 'Provisionally Dismissed' && this.hearing[0].case_status !== 'Archived') {
                        swal({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, Terminate case!'
                        }).then((result) => {
                            if (result.value) {
                                this.$Progress.start();
                                this.cases.status = this.hearing[0].case_status
                                this.cases.case_summary = this.hearing[0].case_summary
                                this.cases.access_status = 'Disabled'
                                this.cases.put('api/cases/' + this.cases.case_no).then(() => {
                                    swal(
                                        'Updated!',
                                        'Case ' + this.cases.case_no + ' has been updated.',
                                        'success'
                                    )
                                    this.$Progress.finish()
                                    this.isUpdateMode = false
                                    this.loadCase()
                                }).catch(() => {
                                    this.$Progress.fail()
                                })

                                let hearingInfo = this.hearing
                                for (let i = 0; i < this.hearing.length; i++) {
                                    hearingInfo = new Form({
                                        id: this.hearing[i].id,
                                        user_id: this.hearing[i].user_id,
                                        case_no: this.cases.case_no,
                                        case_title: this.cases.case_title,
                                        case_status: this.hearing[i].case_status,
                                        case_summary: this.hearing[i].case_summary,
                                        hearing_date: this.hearing[i].hearing_date
                                    })
                                    hearingInfo.put('api/hearing/' + [hearingInfo.id, hearingInfo.case_no,
                                        hearingInfo.case_title,
                                        this.dates
                                    ])
                                }
                            } else {
                                this.hearing[0].case_status = this.cases.status
                            }
                        })
                    } else {
                        this.cases.status = this.hearing[0].case_status
                        this.cases.case_summary = this.hearing[0].case_summary
                        this.cases.put('api/cases/' + this.cases.case_no).then(() => {
                            swal(
                                'Updated!',
                                'Case ' + this.cases.case_no + ' has been updated.',
                                'success'
                            )
                            this.$Progress.finish()
                            this.isUpdateMode = false
                            this.loadCase()
                        }).catch(() => {
                            this.$Progress.fail()
                        })

                        let hearingInfo = this.hearing
                        for (let i = 0; i < this.hearing.length; i++) {
                            hearingInfo = new Form({
                                id: this.hearing[i].id,
                                user_id: this.hearing[i].user_id,
                                case_no: this.cases.case_no,
                                case_title: this.cases.case_title,
                                case_status: this.hearing[i].case_status,
                                case_summary: this.hearing[i].case_summary,
                                hearing_date: this.hearing[i].hearing_date
                            })
                            hearingInfo.put('api/hearing/' + [hearingInfo.id, hearingInfo.case_no,
                                hearingInfo.case_title,
                                this.dates
                            ])
                        }
                    }

                }
            },
            addCrime() {
                this.cases.crimes.push('')
            },
            removeCrime(index) {
                this.cases.crimes.splice(index, 1);
            },
            addComplainant() {
                this.cases.complainants.push('')
            },
            removeComplainant(index) {
                this.cases.complainants.splice(index, 1);
            },
            addRespondent() {
                this.cases.respondents.push('')
            },
            removeRespondent(index) {
                this.cases.respondents.splice(index, 1);
            },
            hearingHasPassed(date) {
                let now = new Date();
                if (new Date(date) < now) {
                    return false
                } else {
                    return true
                }
            },
            checkSummary() {
                for (let i = 0; i < this.hearing.length; i++) {
                    if (this.hearing[i].case_summary == '<p class="text-center">No Summary</p>') {
                        this.hearing[i].case_summary = ''
                    }
                }
            },
            cancel() {
                document.location.reload()
            },
            generateAccessCode() {
                let accessCode = new Form({
                    control_num: this.$route.params.id,
                    code: this.cases.access_code
                })

                if (this.$gate.isAdminAndSuperAdmin()) {
                    accessCode.post('api/generate-code').then(({
                        data
                    }) => {
                        this.cases.access_code = data
                    })
                }
            },
            removeHearing(data) {
                let hearing = data
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.value) {
                        hearing = new Form({
                            id: hearing.id,
                            user_id: hearing.user_id,
                            case_no: hearing.case_no,
                            case_status: hearing.case_status,
                            case_summary: hearing.case_summary,
                            hearing_date: hearing.hearing_date
                        })
                        if (this.$gate.isAdminAndSuperAdmin()) {
                            hearing.delete('api/hearing/' + [hearing.id, hearing.case_no, hearing.hearing_date])
                                .then(
                                    () => {
                                        swal(
                                            'Removed!',
                                            'The hearing has been removed.',
                                            'success'
                                        )
                                        this.loadCase()
                                        this.isUpdateMode = false
                                        this.tabs = 'Info'
                                    }).catch(() => {
                                    swal('Failed!', 'There was something wrong.', 'warning')
                                });
                        }
                    }
                })
            }
        },
        mounted() {
            this.loadAuthUser()
            this.loadCase()
            axios.get('api/user').then(({
                data
            }) => {
                this.attorneys = data
            })

            Fire.$on('searching', () => {
                let query = this.$parent.search
                axios.get('api/findUser?val=' + query).then((data) => {
                    this.$parent.searchResults = data.data
                }).catch(() => {
                    this.$Progress.fail()
                })
            })
        }
    }

</script>
