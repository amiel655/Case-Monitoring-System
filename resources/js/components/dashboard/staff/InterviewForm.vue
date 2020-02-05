<template>
    <!-- <div class="header-text-title">
            <h1 class="text-center">INTERVIEW FORM/CLIENT'S PROFILE</h1>
        </div> -->
    <div class="container pt-4">
        <div v-if="!$gate.isStaffAndSuperAdmin()">
            <not-found></not-found>
        </div>
        <form v-if="$gate.isStaffAndSuperAdmin()" @submit.prevent="createInterviewForm">
            <ul class="nav" id="wizard">
                <li class="nav-item">
                    <a class="nav-link" :class="{ active: activeStep === 1, 'success-step': !$v.form.step1.$invalid }"
                        @click="stepOnClick(1)">
                        <div class="circle-number text-center" :class="{ 'circle-success': !$v.form.step1.$invalid }">1</div>
                        <span class="mt-2 ml-1">STEP 1 <i id="notify-success" class="material-icons md-18 text-success"
                                v-show="!$v.form.step1.$invalid">done</i></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :class="{ active: activeStep === 2, 'success-step': !$v.form.step2.$invalid }"
                        @click="stepOnClick(2)">
                        <div class="circle-number text-center" :class="{ 'circle-success': !$v.form.step2.$invalid }">2</div>
                        <span class="mt-2 ml-1">STEP 2 <i id="notify-success" class="material-icons md-18 text-success"
                                v-show="!$v.form.step2.$invalid">done</i></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :class="{ active: activeStep === 3, 'success-step': !$v.form.step3.$invalid }"
                        @click="stepOnClick(3)">
                        <div class="circle-number text-center" :class="{ 'circle-success': !$v.form.step3.$invalid }">3</div>
                        <span class="mt-2 ml-1">STEP 3 <i id="notify-success" class="material-icons md-18 text-success"
                                v-show="!$v.form.step3.$invalid">done</i></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :class="{ active: activeStep === 4, 'success-step': !$v.form.step4.$invalid }"
                        @click="stepOnClick(4)">
                        <div class="circle-number text-center" :class="{ 'circle-success': !$v.form.step4.$invalid }">4</div>
                        <span class="mt-2 ml-1">STEP 4 <i id="notify-success" class="material-icons md-18 text-success"
                                v-show="!$v.form.step5.$invalid">done</i></span>
                    </a>
                </li>
            </ul>
            <br>
            <div class="row mt-3" v-show="steps[activeStep] === 1">
                <div class="col-md-6">
                    <div class="card card-border shadow">
                        <div class="row mr-4 ml-4">
                            <div class="col-md-12 text-center">
                                <br>
                                <h4 class="text-center">Control Referrence</h4>
                                <center>
                                    <div class="row">
                                        <!-- Region -->
                                        <div class="col-md-6">
                                            <div class="form-group mt-3">
                                                <label for="region"> Region
                                                    <input type="text" name="region" class="form-control formStyle no-focus"
                                                        placeholder="3" readonly>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- District Office -->
                                        <div class="col-md-6 mt-3">
                                            <div class="form-group">
                                                <label for="districtOffice"> District Office
                                                    <input type="text" name="districtOffice" class="form-control formStyle no-focus"
                                                        placeholder="CSFP" readonly>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </center>
                            </div>
                            <div class="col-md-12">

                                <!-- Assigned to -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step1.assigned_to.$error }">
                                    <label for="client_civil_status" class="form__label">Assigned To</label>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-success dropdown-toggle form__input" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span v-show="form.step1.assigned_to === ''">Select Assigned To</span>
                                            <span v-show="form.step1.assigned_to !== ''">Atty. {{
                                                form.step1.assigned_to }}
                                            </span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" v-for="atty in attorneys" v-if="atty.type !== 'Staff' && atty.status !== 'Unavailable'"
                                                :key="atty.id" :value="atty.firstname + ' ' + atty.lastname" @click="form.step1.assigned_to = atty.firstname + ' ' + atty.lastname; $v.form.step1.assigned_to.$model = atty.firstname + ' ' + atty.lastname; form.step1.firstname = atty.firstname; form.step1.lastname = atty.lastname">Atty.
                                                {{
                                                atty.firstname }} {{
                                                atty.lastname }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="error" v-if="!$v.form.step1.assigned_to.required">Assigned to is
                                    required.</div>

                                <!-- Interviewer -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step1.interviewer.$error }">
                                    <label for="client_civil_status" class="form__label">Interviewer</label>
                                    <div class="dropdown" v-show="authUser.type === 'Staff' || authUser.type === 'Super Admin'">
                                        <input type="text" name="interviewer" v-model="form.step1.interviewer" class="form-control form__input"
                                            v-model.trim="$v.form.step1.interviewer.$model" placeholder="Enter Referred/Indorsed By"
                                            readonly>
                                    </div>

                                    <div class="dropdown" v-show="authUser.type !== 'Staff' && authUser.type !== 'Super Admin'">
                                        <button class="btn btn-outline-success dropdown-toggle form__input" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span v-show="form.step1.interviewer === ''">Select Interviewer</span>
                                            <span v-show="form.step1.interviewer !== ''">{{ form.step1.interviewer }}
                                            </span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" v-for="atty in attorneys.data" v-if="atty.type !== 'Admin' && atty.type !== 'Super Admin' && atty.status !== 'Unavailable'"
                                                :key="atty.id" :value="atty.firstname + ' ' + atty.lastname" @click="form.step1.interviewer = atty.firstname + ' ' + atty.lastname; $v.form.step1.interviewer.$model = atty.firstname + ' ' + atty.lastname">{{
                                                atty.firstname }} {{
                                                atty.lastname }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="error" v-if="!$v.form.step1.interviewer.required">Interviewer field is
                                    required.</div>

                                <!-- Referred/Indorsed by -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step1.referred_by.$error }">
                                    <label for="referred_by" class="form__label">Referred/Indorsed By</label>
                                    <br>
                                    <input type="text" name="referred_by" v-model="form.step1.referred_by" class="form-control form__input"
                                        v-model.trim="$v.form.step1.referred_by.$model" placeholder="Enter Referred/Indorsed By">
                                </div>
                                <div class="error" v-if="!$v.form.step1.referred_by.required">Referred/Indorsed by
                                    field is required.</div>

                                <!-- Refer to -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step1.refer_to.$error }">
                                    <label for="refer_to" class="form__label">Refer To</label>
                                    <br>
                                    <input type="text" name="refer_to" v-model="form.step1.refer_to" class="form-control form__input"
                                        v-model.trim="$v.form.step1.refer_to.$model" placeholder="Enter Refer To">
                                </div>
                                <div class="error" v-if="!$v.form.step1.refer_to.required">Refer to field is required.</div>
                                <div class="pb-4"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nature of Request -->
                <div class="col-md-6">
                    <div class="card card-border shadow">
                        <div class="row mr-4 ml-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br>
                                    <h4 class="text-center">Nature of Request </h4>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_request.$error }">
                                                <label class="form-check-label form__label">
                                                    <input type="radio" v-model="form.step1.nature_request" @click="showInput = false"
                                                        name="nature_request" value="Legal Advice" class="form-check-input radio-old form__input"
                                                        v-model.trim="$v.form.step1.nature_request.$model">
                                                    <span class="radio" @click="form.step1.nature_case.isRequired = false"></span>
                                                    Legal Advice
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_request.$error }">
                                                <label class="form-check-label form__label">
                                                    <input type="radio" v-model="form.step1.nature_request" @click="showInput = false"
                                                        name="nature_request" value="Legal Documentation" class="form-check-input radio-old form__input"
                                                        v-model.trim="$v.form.step1.nature_request.$model">
                                                    <span class="radio" @click="form.step1.nature_case.isRequired = false"></span>
                                                    Legal Documentation
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_request.$error }">
                                                <label class="form-check-label form__label">
                                                    <input type="radio" v-model="form.step1.nature_request" @click="showInput = false"
                                                        name="nature_request" value="Representation in Court/Quasi-Judicial Bodies"
                                                        class="form-check-input radio-old form__input" v-model.trim="$v.form.step1.nature_request.$model">
                                                    <span class="radio" @click="form.step1.nature_case.isRequired = true"></span>
                                                    Representation in Court/Quasi-Judicial Bodies
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_request.$error }">
                                                <label class="form-check-label form__label">
                                                    <input type="radio" v-model="form.step1.nature_request" @click="showInput = false"
                                                        name="nature_request" class="form-check-input radio-old form__input"
                                                        v-model.trim="$v.form.step1.nature_request.$model" value="Inquest/Legal Assistance">
                                                    <span class="radio" @click="form.step1.nature_case.isRequired = false"></span>
                                                    Inquest/Legal Assistance
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_request.$error }">
                                                <label class="form-check-label form__label">
                                                    <input type="radio" v-model="form.step1.nature_request" @click="showInput = false"
                                                        name="nature_request" value="Mediation/Concillation" class="form-check-input radio-old form__input"
                                                        v-model.trim="$v.form.step1.nature_request.$model">
                                                    <span class="radio" @click="form.step1.nature_case.isRequired = false"></span>
                                                    Mediation/Concillation
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_request.$error }">
                                                <label class="form-check-label form__label">
                                                    <input type="radio" v-model="form.step1.nature_request" @click="showInput = false"
                                                        name="nature_request" value="Administration of Oath" class="form-check-input radio-old form__input"
                                                        v-model.trim="$v.form.step1.nature_request.$model">
                                                    <span class="radio" @click="form.step1.nature_case.isRequired = false"></span>
                                                    Administration of Oath
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_request.$error }">
                                                <label class="form-check-label form__label">
                                                    <input type="radio" v-model="form.step1.nature_request" name="nature_request"
                                                        value="Others" class="form-check-input radio-old form__input"
                                                        v-model.trim="$v.form.step1.nature_request.$model">
                                                    <span class="radio" @click="showOtherNatureRequest; form.step1.nature_case.isRequired = false"></span>
                                                    Others
                                                </label>
                                            </div>
                                            <div class="error mt-5 text-center" v-if="!$v.form.step1.nature_request.required && !showInput">Nature
                                                of Request is required. Kindly choose one from the list</div>
                                        </div>
                                        <div class="col-md-12" v-show="showInput">
                                            <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step1.nature_request.$error }">
                                                <div class="pb-4">
                                                    <label class="form-check-label form__label">
                                                        <input type="text" v-model="form.step1.nature_request" name="nature_request"
                                                            class="form-control form__input" v-model.trim="$v.form.step1.nature_request.$model"
                                                            placeholder="Please Specify">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3" v-show="form.step1.nature_request === 'Representation in Court/Quasi-Judicial Bodies'">
                    <div class="card card-border shadow">
                        <div class="mr-4 ml-4">
                            <div class="col-md-12 text-center">
                                <br>
                                <h4 class="text-center nature-req">I. Nature of the Case</h4>
                            </div>
                            <div class="row mt-3 mx-auto pt-3">
                                <div class="col-md-1"></div>
                                <div class="col-md-2">
                                    <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_case.input.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step1.nature_case.case" name="criminal_radio"
                                                value="Criminal" class="form-check-input radio-old form__input">
                                            <span class="radio"></span>
                                            Criminal
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_case.input.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step1.nature_case.case" name="civil_radio"
                                                value="Civil" class="form-check-input check-old form__input">
                                            <span class="radio"></span>
                                            Civil
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 mr-5">
                                    <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_case.input.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step1.nature_case.case" name="administrative_radio"
                                                value="Administrative Case Proper" class="form-check-input radio-old form__input">
                                            <span class="radio"></span>
                                            Administrative Case Proper
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_case.input.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step1.nature_case.case" name="prosecutor_radio"
                                                value="Prosecutor Office" class="form-check-input radio-old form__input">
                                            <span class="radio"></span>
                                            Prosecutor Office
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check radio-div nature-req" :class="{ 'form-group--error': $v.form.step1.nature_case.input.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step1.nature_case.case" name="labor_radio"
                                                value="Labor" class="form-check-input radio-old form__input">
                                            <span class="radio"></span>
                                            Labor
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="col-md-6 pt-3">
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step1.nature_case.input.$error }">
                                    <label for="" class="form__label">Specify {{ form.step1.nature_case.case }}</label>
                                    <input type="text" v-model="form.step1.nature_case.input" name="criminal_input"
                                        class="form-control form__input" :disabled="form.step1.nature_case.case === ''"
                                        placeholder="Please Specify" v-model.trim="$v.form.step1.nature_case.input.$model">
                                </div>
                                <div class="error" v-if="!$v.form.step1.nature_case.required">Nature
                                    of the Case is required. Kindly choose one from the list then specify
                                    the case.</div><br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3" v-show="steps[activeStep] === 2">
                <div class="pb-4 card card-border shadow">
                    <div class="row mr-4 ml-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <br>
                                <h4 class="text-center">Client's Personal Circumtances</h4>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-center pb-3">
                                <div class="btn-group btn-group-toggle">
                                    <label class="btn btn-outline-success" :class="{'active' : form.step2.isRepresentative === 'false'}">
                                        <input type="radio" name="Defendant" value="false" v-model="form.step2.isRepresentative">
                                        Defendant
                                    </label>
                                    <label class="btn btn-outline-success" :class="{'active' : form.step2.isRepresentative === 'true'}">
                                        <input type="radio" name="Representative" value="true" v-model="form.step2.isRepresentative">
                                        Representative
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Name -->
                            <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_name.$error }">
                                <br>
                                <label for="client_name" class="form__label">Name</label>
                                <input type="text" v-model="form.step2.client_name" name="client_name" class="form-control form__input"
                                    v-model.trim="$v.form.step2.client_name.$model" placeholder="Firstname Middlename Lastname">
                            </div>
                            <div class="error" v-if="!$v.form.step2.client_name.required">Client's Name is required.</div>

                            <!-- Religion -->
                            <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_religion.$error }">
                                <br>
                                <label for="client_religion" class="form__label">Religion</label>
                                <v-select :options="religionList" v-model="form.step2.client_religion" placeholder="Select Religion"></v-select>
                                <!-- <input type="text" v-model="form.step2.client_religion" name="client_religion" class="form-control form__input"
                                    v-model.trim="$v.form.step2.client_religion.$model" placeholder="Other Please Specify"> -->

                            </div>
                            <div class="error" v-if="!$v.form.step2.client_religion.required">Client's Religion is
                                required.</div>

                            <!-- Citizenship -->
                            <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_citizenship.$error }">
                                <br>
                                <label for="client_citizenship" class="form__label">Citizenship</label>
                                <v-select :options="citizenshipList" v-model="form.step2.client_citizenship"
                                    placeholder="Select Citizenship"></v-select>
                                <!-- <input type="text" v-model="form.step2.client_citizenship" name="client_citizenship"
                                    class="form-control form__input" v-model.trim="$v.form.step2.client_citizenship.$model"
                                    placeholder="Filipino"> -->
                            </div>
                            <div class="error" v-if="!$v.form.step2.client_citizenship.required">Client's Citizenship
                                is required.</div>

                            <!-- Address -->
                            <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_address.$error }">
                                <br>
                                <label for="client_address" class="form__label">Address</label>
                                <input type="text" v-model="form.step2.client_address" name="client_address" class="form-control form__input"
                                    v-model.trim="$v.form.step2.client_address.$model" placeholder="House no. Steet, Barangay, City, Province">
                            </div>
                            <div class="error" v-if="!$v.form.step2.client_address.required">Client's Address is
                                required.</div>

                            <!-- E-mail -->
                            <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_email.$error }">
                                <br>
                                <label for="client_email" class="form__label">Email</label>
                                <input type="email" v-model="form.step2.client_email" name="client_email" class="form-control form__input"
                                    v-model.trim="$v.form.step2.client_email.$model" placeholder="example@email.com">
                            </div>
                            <div class="error" v-if="!$v.form.step2.client_email.email">The email must be a valid email
                                address.</div>

                            <!-- Age -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_age.$error }">
                                        <label for="client_age" class="form__label">Age</label>
                                        <input type="number" v-model="form.step2.client_age" name="client_age" class="form-control form__input"
                                            placeholder="18-100" @keypress="validateNumber($event)" v-model.trim="$v.form.step2.client_age.$model">
                                    </div>
                                    <div class="error" v-if="!$v.form.step2.client_age.required">Client's Age is
                                        required</div>
                                    <div class="error" v-if="!$v.form.step2.client_age.between">Client's Age must be
                                        between {{ $v.form.step2.client_age.$params.between.min }} and {{
                                        $v.form.step2.client_age.$params.between.max }}.</div>
                                </div>
                                <!-- Gender -->
                                <div class="col-md-4 mt">
                                    <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_gender.$error }">
                                        <label for="client_gender" class="form__label">Gender</label>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-success dropdown-toggle form__input" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <span v-show="form.step2.client_gender === ''">Select Gender</span>
                                                <span v-show="form.step2.client_gender !== ''">{{
                                                    form.step2.client_gender }} <span v-if="form.step2.client_gender === 'Male'">
                                                        <male-icon class="ml-1"></male-icon>
                                                    </span> <span v-if="form.step2.client_gender === 'Female'">
                                                        <female-icon></female-icon>
                                                    </span> </span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" value="Male" @click="form.step2.client_gender = 'Male'; $v.form.step2.client_gender.$model = 'Male'">Male
                                                    <male-icon class="ml-1"></male-icon></a>
                                                <a class="dropdown-item" value="Female" @click="form.step2.client_gender = 'Female'; $v.form.step2.client_gender.$model = 'Female'">Female
                                                    <female-icon></female-icon></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="error" v-if="!$v.form.step2.client_gender.required">Client's Gender is
                                        required</div>
                                </div>
                                <!-- Civil Status -->
                                <div class="col-md-4">
                                    <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_civil_status.$error }">
                                        <label for="client_civil_status" class="form__label">Civil Status</label>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-success dropdown-toggle form__input" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <span v-show="form.step2.client_civil_status === ''">Select Civil
                                                    Status</span>
                                                <span v-show="form.step2.client_civil_status !== ''">{{
                                                    form.step2.client_civil_status }} </span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" value="Married" @click="resetSpouseInfo(); form.step2.client_civil_status = 'Married'; $v.form.step2.client_civil_status.$model = 'Married'">Married</a>
                                                <a class="dropdown-item" value="Widowed" @click="resetSpouseInfo(); form.step2.client_civil_status = 'Widowed'; $v.form.step2.client_civil_status.$model = 'Widowed'">Widowed</a>
                                                <a class="dropdown-item" value="Separated" @click="resetSpouseInfo(); form.step2.client_civil_status = 'Separated'; $v.form.step2.client_civil_status.$model = 'Separated'">Separated</a>
                                                <a class="dropdown-item" value="Divorced" @click="resetSpouseInfo(); form.step2.client_civil_status = 'Divorced'; $v.form.step2.client_civil_status.$model = 'Divorced'">Divorced</a>
                                                <a class="dropdown-item" value="Single" @click="resetSpouseInfo(); form.step2.client_civil_status = 'Single'; $v.form.step2.client_civil_status.$model = 'Single'">Single</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="error" v-if="!$v.form.step2.client_civil_status.required">Client's
                                        Civil Status is required</div>
                                </div>
                            </div>

                            <!-- Individual Monthly Net Income -->
                            <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_monthly_income.$error }">
                                <br>
                                <label for="client_monthly_income" class="form__label">Individual Monthly Net Income</label>
                                <input type="number" v-model="form.step2.client_monthly_income" name="client_monthly_income"
                                    class="form-control form__input" v-model.trim="$v.form.step2.client_monthly_income.$model"
                                    @keypress="validateNumber($event)" placeholder="100">
                            </div>
                            <div class="error" v-if="!$v.form.step2.client_monthly_income.required">Client's Monthly
                                Net Income is required.</div>
                            <div class="error" v-if="!$v.form.step2.client_monthly_income.minLength">Client's Monthly
                                Net Income must
                                contain atleast {{ $v.form.step2.client_monthly_income.$params.minLength.min }} digits.</div>

                            <!-- Contact No. -->
                            <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_contact.$error }"><br>
                                <label for="client_contact" class="form__label">Contact No.</label>
                                <input type="text" v-model="form.step2.client_contact" name="client_contact" class="form-control form__input"
                                    @keypress="validateNumber($event)" v-model.trim="$v.form.step2.client_contact.$model"
                                    placeholder="09XX-XXX-XXXX">
                            </div>
                            <div class="error" v-if="!$v.form.step2.client_contact.required">Client's Contact No. is
                                required</div>
                            <div class="error" v-if="!$v.form.step2.client_contact.minLength">Client's Contact No. must
                                contain atleast {{ $v.form.step2.client_contact.$params.minLength.min }} digits.</div>
                            <div class="error" v-if="!$v.form.step2.client_contact.maxLength">Client's Contact No. must
                                only have up to {{ $v.form.step2.client_contact.$params.maxLength.max }} digits.</div>
                        </div>

                        <div class="col-md-6">

                            <!-- Educational Attainment -->
                            <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_educational_attainment.$error }"><br>
                                <label for="client_educational_attainment" class="form__label">Educational Attainment</label>
                                <input type="text" v-model="form.step2.client_educational_attainment" name="client_educational_attainment"
                                    class="form-control form__input" v-model.trim="$v.form.step2.client_educational_attainment.$model"
                                    placeholder="Highschool completion or higher">
                            </div>
                            <div class="error" v-if="!$v.form.step2.client_educational_attainment.required">Client's
                                Educational Attainment is required</div>

                            <!-- Language/Dialect -->
                            <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_dialect.$error }"><br>
                                <label for="client_dialect" class="form__label">Language/Dialect</label>
                                <v-select multiple :options="languagesDialectsList" v-model="form.step2.client_dialect"
                                    placeholder="Select Language/Dialect"></v-select>
                                <!-- <input type="text" v-model="form.step2.client_dialect" name="client_dialect" class="form-control form__input"
                                    v-model.trim="$v.form.step2.client_dialect.$model" placeholder="Tagalog / Kapampangan / English"> -->
                            </div>
                            <div class="error" v-if="!$v.form.step2.client_dialect.required">Client's Language/Dialect
                                is required</div>

                            <div v-show="form.step2.client_civil_status === 'Married'">
                                <!-- Spouse -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step2.client_spouse.$error }"><br>
                                    <label for="client_spouse" class="form__label">Spouse</label>
                                    <input type="text" v-model="form.step2.client_spouse" name="client_spouse" class="form-control form__input"
                                        v-model.trim="$v.form.step2.client_spouse.$model" placeholder="Firstname Middlename Lastname">
                                </div>
                                <div class="error" v-if="!$v.form.step2.client_spouse.required">Spouse Name is required</div>

                                <!-- Address of Spouse -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step2.spouse_address.$error }"><br>
                                    <label for="spouse_address" class="form__label">Address of Spouse</label>
                                    <input type="text" v-model="form.step2.spouse_address" name="spouse_address" class="form-control form__input"
                                        v-model.trim="$v.form.step2.spouse_address.$model" placeholder="House no. Street, Barangay, City, Province">
                                </div>
                                <div class="error" v-if="!$v.form.step2.spouse_address.required">Spouse Address is
                                    required</div>

                                <!-- Contact No. of Spouse -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step2.spouse_contact.$error }"><br>
                                    <label for="spouse_contact" class="form__label">Contact No. of Spouse</label>
                                    <input type="text" v-model="form.step2.spouse_contact" name="spouse_contact" class="form-control form__input"
                                        @keypress="validateNumber($event)" v-model.trim="$v.form.step2.spouse_contact.$model"
                                        placeholder="09XX-(XXX)-XXXX">
                                </div>
                                <div class="error" v-if="!$v.form.step2.spouse_contact.required">Spouse Contact No. is
                                    required</div>
                                <div class="error" v-if="!$v.form.step2.spouse_contact.minLength">Spouse Contact No.
                                    must contain atleast {{ $v.form.step2.spouse_contact.$params.minLength.min }}
                                    digits.</div>
                                <div class="error" v-if="!$v.form.step2.spouse_contact.maxLength">Spouse Contact No.
                                    must only have up to {{ $v.form.step2.spouse_contact.$params.maxLength.max }}
                                    digits.</div>
                            </div>

                            <!-- Detained -->
                            <div class="form-group" :class="{ 'form-group--error': $v.form.step2.detained.$error }">
                                <br>
                                <label for="detained" class="form__label">Detained</label>
                                <div class="row">
                                    <div class="col-md-2 ml-3">
                                        <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step2.detained.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="radio" v-model="form.step2.detained" name="detained" value="Yes"
                                                    class="form-check-input radio-old form__input" v-model.trim="$v.form.step2.detained.$model">
                                                <span class="radio" @click="form.step2.detained_since = ''; form.step2.detention_place = ''"></span>
                                                Yes
                                            </label>
                                        </div>
                                        <div class="error mt-5" v-if="!$v.form.step2.detained.required" style="width: 200px">Detained
                                            is required</div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step2.detained.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="radio" v-model="form.step2.detained" name="detained" value="No"
                                                    class="form-check-input radio-old form__input" v-model.trim="$v.form.step2.detained.$model">
                                                <span class="radio" @click="form.step2.detained_since = ''; form.step2.detention_place = ''"></span>
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detained Since -->
                            <div v-show="form.step2.detained === 'Yes'"><br>
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step2.detained_since.$error }">
                                    <label for="detained_since" class="form__label">Detained Since</label>
                                    <datepicker class="form-calendar form__input" :disabled-dates="disabledFutureDates"
                                        :format="'MMM. dd, yyyy'" v-model="form.step2.detained_since" v-model.trim="$v.form.step2.detained_since.$model"
                                        placeholder="Click Here to Choose a Date" @input="convertDate()"></datepicker>

                                </div>
                                <div class="error" v-if="!$v.form.step2.detained_since.required">Detained Since is
                                    required</div>
                            </div>

                            <!-- Place of Detention -->
                            <div v-show="form.step2.detained === 'Yes'"><br>
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step2.detention_place.$error }">
                                    <label for="detention_place" class="form__label">Place of Detention</label>
                                    <input type="text" v-model="form.step2.detention_place" name="detention_place"
                                        class="form-control form__input" v-model.trim="$v.form.step2.detention_place.$model"
                                        placeholder="Prison Place">
                                </div>
                                <div class="error" v-if="!$v.form.step2.detention_place.required">Detention Place is
                                    required</div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mt-3" v-show="form.step2.isRepresentative === 'true'">
                    <div class="card card-border shadow">
                        <div class="row mr-4 ml-4">
                            <div class="col-md-12 text-center">
                                <br>
                                <h4 class="text-center">Interviewee's Personal Circumtances</h4>
                            </div>
                            <div class="pt-4 col-md-6">
                                <!-- Name -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step2.interviewee_name.$error }">
                                    <label for="interviewee_name" class="form__label">Name</label>
                                    <input type="text" v-model="form.step2.interviewee_name" name="interviewee_name"
                                        class="form-control form__input" v-model.trim="$v.form.step2.interviewee_name.$model"
                                        placeholder="Firstname Middlename Lastname">
                                </div>
                                <div class="error" v-if="!$v.form.step2.interviewee_name.required">Interviewee's Name
                                    is required.</div>

                                <!-- Address -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step2.interviewee_address.$error }">
                                    <label for="interviewee_address" class="form__label">Address</label>
                                    <input type="text" v-model="form.step2.interviewee_address" name="interviewee_address"
                                        class="form-control form__input" v-model.trim="$v.form.step2.interviewee_address.$model"
                                        placeholder="House no. Street, Barangay, City, Province">
                                </div>
                                <div class="error" v-if="!$v.form.step2.interviewee_address.required">Interviewee's
                                    Address is required.</div>

                                <!-- Relationship to Client -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step2.interviewee_relationship_to_client.$error }">
                                    <label for="interviewee_relationship_to_client" class="form__label">Relationship to
                                        Client</label>
                                    <input type="text" v-model="form.step2.interviewee_relationship_to_client" name="interviewee_relationship_to_client"
                                        class="form-control form__input" v-model.trim="$v.form.step2.interviewee_relationship_to_client.$model"
                                        placeholder="Son, Daugther, Father, Mother etc.">
                                </div>
                                <div class="error" v-if="!$v.form.step2.interviewee_relationship_to_client.required">Interviewee's
                                    Relationship to Client is required.</div>


                            </div>
                            <div class="pt-4 col-md-6">
                                <!-- Age -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{ 'form-group--error': $v.form.step2.interviewee_age.$error }">
                                            <label for="interviewee_age" class="form__label">Age</label>
                                            <input type="number" v-model="form.step2.interviewee_age" name="interviewee_age"
                                                class="form-control form__input" @keypress="validateNumber($event)"
                                                v-model.trim="$v.form.step2.interviewee_age.$model" placeholder="18-100">
                                        </div>
                                        <div class="error" v-if="!$v.form.step2.interviewee_age.required">Interviewee's
                                            Age is required</div>
                                        <div class="error" v-if="!$v.form.step2.interviewee_age.between">Interviewee's
                                            Age must be between {{ $v.form.step2.interviewee_age.$params.between.min }}
                                            and {{ $v.form.step2.interviewee_age.$params.between.max }}.</div>
                                    </div>
                                    <!-- Gender -->
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{ 'form-group--error': $v.form.step2.interviewee_gender.$error }">
                                            <label for="interviewee_gender" class="form__label">Gender</label>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success dropdown-toggle form__input"
                                                    type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <span v-show="form.step2.interviewee_gender === ''">Select Gender</span>
                                                    <span v-show="form.step2.interviewee_gender !== ''">{{
                                                        form.step2.interviewee_gender }} <span v-if="form.step2.interviewee_gender === 'Male'">
                                                            <male-icon class="ml-1"></male-icon>
                                                        </span> <span v-if="form.step2.interviewee_gender === 'Female'">
                                                            <female-icon></female-icon>
                                                        </span> </span>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" value="Male" @click="form.step2.interviewee_gender = 'Male'; $v.form.step2.interviewee_gender.$model = 'Male'">Male
                                                        <male-icon class="ml-1"></male-icon></a>
                                                    <a class="dropdown-item" value="Female" @click="form.step2.interviewee_gender = 'Female'; $v.form.step2.interviewee_gender.$model = 'Female'">Female
                                                        <female-icon></female-icon></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="error" v-if="!$v.form.step2.interviewee_gender.required">Interviewee's
                                            Gender is
                                            required</div>
                                    </div>

                                    <!-- Civil Status -->
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{ 'form-group--error': $v.form.step2.interviewee_civil_status.$error }">
                                            <label for="interviewee_civil_status" class="form__label">Civil Status</label>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success dropdown-toggle form__input"
                                                    type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <span v-show="form.step2.interviewee_civil_status === ''">Select
                                                        Civil Status</span>
                                                    <span v-show="form.step2.interviewee_civil_status !== ''">{{
                                                        form.step2.interviewee_civil_status }} </span>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" value="Married" @click="form.step2.interviewee_civil_status = 'Married'; $v.form.step2.client_civil_status.$model = 'Married'">Married</a>
                                                    <a class="dropdown-item" value="Widowed" @click="form.step2.interviewee_civil_status = 'Widowed'; $v.form.step2.client_civil_status.$model = 'Widowed'">Widowed</a>
                                                    <a class="dropdown-item" value="Separated" @click="form.step2.interviewee_civil_status = 'Separated'; $v.form.step2.client_civil_status.$model = 'Separated'">Separated</a>
                                                    <a class="dropdown-item" value="Divorced" @click="form.step2.interviewee_civil_status = 'Divorced'; $v.form.step2.client_civil_status.$model = 'Divorced'">Divorced</a>
                                                    <a class="dropdown-item" value="Single" @click="form.step2.interviewee_civil_status = 'Single'; $v.form.step2.client_civil_status.$model = 'Single'">Single</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="error" v-if="!$v.form.step2.interviewee_civil_status.required">Interviewee's
                                            Civil Status is required</div>
                                    </div>
                                </div>

                                <!-- Contact Number -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step2.interviewee_contact.$error }">
                                    <label for="interviewee_contact" class="form__label">Contact No.</label>
                                    <input type="number" v-model="form.step2.interviewee_contact" name="interviewee_contact"
                                        class="form-control form__input" @keypress="validateNumber($event)"
                                        v-model.trim="$v.form.step2.interviewee_contact.$model" placeholder="09XX-(XXX)-XXXX">
                                </div>
                                <div class="error" v-if="!$v.form.step2.interviewee_contact.required">Interviewee's
                                    Contact No. is required</div>
                                <div class="error" v-if="!$v.form.step2.interviewee_contact.minLength">Interviewee's
                                    Contact No. must contain atleast {{
                                    $v.form.step2.interviewee_contact.$params.minLength.min }} digits.</div>
                                <div class="error" v-if="!$v.form.step2.interviewee_contact.maxLength">Interviewee's
                                    Contact No. must only have up to {{
                                    $v.form.step2.interviewee_contact.$params.maxLength.max }} digits.</div>

                                <!-- E-mail -->
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step2.interviewee_email.$error }">
                                    <label for="interviewee_email" class="form__label">Email</label>
                                    <input type="text" v-model="form.step2.interviewee_email" name="interviewee_email"
                                        class="form-control form__input" v-model.trim="$v.form.step2.interviewee_email.$model"
                                        placeholder="example@email.com">
                                </div>
                                <div class="error" v-if="!$v.form.step2.interviewee_email.email">The email must be a
                                    valid email address.</div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-show="steps[activeStep] === 3">
                <div class="col-md-12 mt-3">
                    <div class="card card-border shadow">
                        <div class="row  mr-4 ml-4">
                            <div class="col-md-12 text-center">
                                <br>
                                <h4 class="text-center">IIA. Client's Case Involvement</h4>
                            </div>
                            <div class="row mt-3 ml-5 text-left">
                                <div class="col-md-3">
                                    <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step3.client_involvement.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step3.client_involvement" name="plaintiff_radio"
                                                value="Plaintiff" class="form-check-input check-old form__input"
                                                v-model.trim="$v.form.step3.client_involvement.$model">
                                            <span class="radio"></span>
                                            Plaintiff
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step3.client_involvement.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step3.client_involvement" name="petitioner_radio"
                                                value="Petitioner" class="form-check-input check-old form__input"
                                                v-model.trim="$v.form.step3.client_involvement.$model">
                                            <span class="radio"></span>
                                            Petitioner
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step3.client_involvement.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step3.client_involvement" name="defendent_radio"
                                                value="Defendent" class="form-check-input check-old form__input"
                                                v-model.trim="$v.form.step3.client_involvement.$model">
                                            <span class="radio"></span>
                                            Defendent
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step3.client_involvement.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step3.client_involvement" name="respondent_radio"
                                                value="Respondent" class="form-check-input check-old form__input"
                                                v-model.trim="$v.form.step3.client_involvement.$model">
                                            <span class="radio"></span>
                                            Respondent
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step3.client_involvement.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step3.client_involvement" name="oppositor_radio"
                                                value="Oppositor" class="form-check-input check-old form__input"
                                                v-model.trim="$v.form.step3.client_involvement.$model">
                                            <span class="radio"></span>
                                            Oppositor
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step3.client_involvement.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step3.client_involvement" name="accused_radio"
                                                value="Accused" class="form-check-input check-old form__input"
                                                v-model.trim="$v.form.step3.client_involvement.$model">
                                            <span class="radio"></span>
                                            Accused
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step3.client_involvement.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step3.client_involvement" name="others_radio"
                                                value="Others" class="form-check-input check-old form__input"
                                                v-model.trim="$v.form.step3.client_involvement.$model">
                                            <span class="radio"></span>
                                            Others
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step3.client_involvement.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.step3.client_involvement" name="complainant_radio"
                                                value="Complainant/Victim" class="form-check-input check-old form__input"
                                                v-model.trim="$v.form.step3.client_involvement.$model">
                                            <span class="radio" @click="form.step3.isRequired = true"></span>
                                            Complainant/Victim
                                        </label>
                                    </div>
                                </div>
                                <div class="row pt-2" v-show="form.step3.client_involvement === 'Complainant/Victim'">
                                    <div class="col-md-12 pt-3">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                Compliant/Victim of:
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_complaint.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="checkbox" v-model="form.step3.client_complaint" name="vawc_checkbox"
                                                    value="R.A 9262 (VAWC)" class="form-check-input check-old form__input"
                                                    v-model.trim="$v.form.step3.client_complaint.$model">
                                                <span class="checkmark"></span>
                                                R.A 9262 (VAWC)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_complaint.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="checkbox" v-model="form.step3.client_complaint" name="atl_checkbox"
                                                    value="R.A 9745 (Anti-Torture Law)" class="form-check-input check-old form__input"
                                                    v-model.trim="$v.form.step3.client_complaint.$model">
                                                <span class="checkmark"></span>
                                                R.A 9745 (Anti-Torture Law)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_complaint.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="checkbox" v-model="form.step3.client_complaint" name="agrarian_checkbox"
                                                    value="Agrarian Case" class="form-check-input check-old form__input"
                                                    v-model.trim="$v.form.step3.client_complaint.$model">
                                                <span class="checkmark"></span>
                                                Agrarian Case
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_complaint.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="checkbox" v-model="form.step3.client_complaint" name="hsa_checkbox"
                                                    value="R.A 9372 (Human Security Act)" class="form-check-input check-old form__input"
                                                    v-model.trim="$v.form.step3.client_complaint.$model">
                                                <span class="checkmark"></span>
                                                R.A 9372 (Human Security Act)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_complaint.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="checkbox" v-model="form.step3.client_complaint" name="cicl_checkbox"
                                                    value="R.A 9344 (CICL)" class="form-check-input check-old form__input"
                                                    v-model.trim="$v.form.step3.client_complaint.$model">
                                                <span class="checkmark"></span>
                                                R.A 9344 (CICL)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_complaint.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="checkbox" v-model="form.step3.client_complaint" name="other_compliant_checkbox"
                                                    value="R.A 9208 (Anti-Trafficking in Persons)" class="form-check-input check-old form__input"
                                                    v-model.trim="$v.form.step3.client_complaint.$model">
                                                <span class="checkmark"></span>
                                                R.A 9208 (Anti-Trafficking in Persons)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_complaint.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="checkbox" v-model="form.step3.client_complaint" name="other_compliant_checkbox"
                                                    value="R.A 9165 (Comprehensive Dangerous Drugs)" class="form-check-input check-old form__input"
                                                    v-model.trim="$v.form.step3.client_complaint.$model">
                                                <span class="checkmark"></span>
                                                R.A 9165 (Comprehensive Dangerous Drugs)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_complaint.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="checkbox" v-model="form.step3.client_complaint" name="other_compliant_checkbox"
                                                    value="Other Compliant/Victim" class="form-check-input check-old form__input"
                                                    v-model.trim="$v.form.step3.client_complaint.$model">
                                                <span class="checkmark"></span>
                                                Others
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step3.client_involvement.$error }">
                                    <label class="form__label">
                                        <input type="hidden" v-model="form.step3.client_involvement" class="form__input"
                                            v-model.trim="$v.form.step3.client_involvement.$model">
                                    </label>
                                </div>
                                <div class="error text-center" v-if="!$v.form.step3.client_involvement.required">Client's
                                    Case Involvement is required.</div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step3.client_complaint.$error }">
                                    <label for="" class="form__label"></label>
                                    <input type="hidden" v-model="form.step3.client_complaint" class="form__input"
                                        v-model.trim="$v.form.step3.client_complaint.$model">
                                </div>
                                <div class="error text-center" v-if="!$v.form.step3.client_complaint.required">Client's
                                    Complainant/Victim of is required.</div>
                            </div>
                        </div><br>
                    </div>


                    <div class="col-md-12 mt-3">
                        <div class="card card-border shadow">
                            <div class="row  mr-4 ml-4">

                                <div class="col-md-12 text-center">
                                    <br>
                                    <h4 class="text-center">IIB. Client's Classification</h4>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_class.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="checkbox" v-model="form.step3.client_class" name="client_classification"
                                                value="Children in Conflict with the Law" class="check-old form-check-input form__input">
                                            <span class="checkmark" @click="validateClassification('children_in_conflict')"></span>
                                            Children in Conflict with the Law
                                            <br>
                                            <div class="col-md-8">
                                                <div class="form-group" :class="{ 'form-group--error': $v.form.step3.client_classification.children_in_conflict.input.$error }">
                                                    <input type="number" v-model="form.step3.client_classification.children_in_conflict.input"
                                                        name="children_in_conflict" class="form-control form__input"
                                                        min="18" max="100" @keypress="validateNumber($event)"
                                                        v-model.trim="$v.form.step3.client_classification.children_in_conflict.input.$model"
                                                        placeholder="Age" :disabled="!form.step3.client_classification.children_in_conflict.checkbox">
                                                </div>
                                                <div class="error" v-if="!$v.form.step3.client_classification.children_in_conflict.input.required">Children
                                                    in Conflict with the Law's
                                                    Age is required.</div>
                                                <div class="error" v-if="!$v.form.step3.client_classification.children_in_conflict.input.between">Age
                                                    must be between {{
                                                    $v.form.step3.client_classification.children_in_conflict.input.$params.between.min
                                                    }} and {{
                                                    $v.form.step3.client_classification.children_in_conflict.input.$params.between.max
                                                    }}.</div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_class.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="checkbox" v-model="form.step3.client_class" name="client_classification"
                                                value="Woment Client" class="check-old form-check-input form__input">
                                            <span class="checkmark" @click="validateClassification('women_client')"></span>
                                            Woment Client
                                        </label>
                                    </div>
                                    <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_class.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="checkbox" v-model="form.step3.client_class" name="client_classification"
                                                value="Indigenous Group" class="check-old form-check-input form__input">
                                            <span class="checkmark" @click="validateClassification('indigenous_group')"></span>
                                            Indigenous Group
                                            <br>
                                            <div class="form-group" :class="{ 'form-group--error': $v.form.step3.client_classification.indigenous_group.input.$error }">
                                                <input type="text" v-model="form.step3.client_classification.indigenous_group.input"
                                                    name="indigenous_group" class="form-control form__input"
                                                    v-model.trim="$v.form.step3.client_classification.indigenous_group.input.$model"
                                                    placeholder="Please Specify" :disabled="!form.step3.client_classification.indigenous_group.checkbox">
                                            </div>
                                            <div class="error" v-if="!$v.form.step3.client_classification.indigenous_group.input.required">Indigenous
                                                Group is required.</div>
                                            <br>
                                        </label>
                                    </div>

                                    <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_class.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="checkbox" v-model="form.step3.client_class" name="client_classification"
                                                value="Person with Disability (PWD)" class="check-old form-check-input form__input">
                                            <span class="checkmark" @click="validateClassification('person_with_disability')"></span>
                                            Person with Disability (PWD)
                                            <br>
                                            <div class="form-group" :class="{ 'form-group--error': $v.form.step3.client_classification.person_with_disability.input.$error }">
                                                <input type="text" v-model="form.step3.client_classification.person_with_disability.input"
                                                    name="person_with_disability" class="form-control form__input"
                                                    v-model.trim="$v.form.step3.client_classification.person_with_disability.input.$model"
                                                    placeholder="Please Specify" :disabled="!form.step3.client_classification.person_with_disability.checkbox">
                                            </div>
                                            <div class="error" v-if="!$v.form.step3.client_classification.person_with_disability.input.required">Person
                                                with Disability is required.</div>
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check checkbox-div" v-show="!form.step3.client_classification.rural_poor.checkbox"
                                        :class="{ 'form-group--error': $v.form.step3.client_class.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="checkbox" v-model="form.step3.client_class" name="client_classification"
                                                value="Urban Poor" class="form-check-input check-old form__input">
                                            <span class="checkmark" @click="validateClassification('urban_poor')"></span>
                                            Urban Poor
                                            <br>
                                            <div class="form-group" :class="{ 'form-group--error': $v.form.step3.client_classification.urban_poor.input.$error }">
                                                <input type="text" v-model="form.step3.client_classification.urban_poor.input"
                                                    name="urban_poor" class="form-control form__input" v-model.trim="$v.form.step3.client_classification.urban_poor.input.$model"
                                                    placeholder="Please Specify" :disabled="!form.step3.client_classification.urban_poor.checkbox">
                                            </div>
                                            <div class="error" v-if="!$v.form.step3.client_classification.urban_poor.input.required">Urban
                                                Poor is required.</div>
                                            <br>
                                        </label>
                                    </div>

                                    <div class="form-check checkbox-div" v-show="!form.step3.client_classification.urban_poor.checkbox"
                                        :class="{ 'form-group--error': $v.form.step3.client_class.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="checkbox" v-model="form.step3.client_class" name="client_classification"
                                                value="Rural Poor" class="form-check-input check-old form__input">
                                            <span class="checkmark" @click="validateClassification('rural_poor')"></span>
                                            Rural Poor
                                            <br>
                                            <div class="form-group" :class="{ 'form-group--error': $v.form.step3.client_classification.rural_poor.input.$error }">
                                                <input type="text" v-model="form.step3.client_classification.rural_poor.input"
                                                    name="rural_poor" class="form-control form__input" v-model.trim="$v.form.step3.client_classification.rural_poor.input.$model"
                                                    placeholder="Please Specify" :disabled="!form.step3.client_classification.rural_poor.checkbox">
                                            </div>
                                            <div class="error" v-if="!$v.form.step3.client_classification.rural_poor.input.required">Rural
                                                Poor is required.</div>
                                        </label>
                                    </div>

                                    <br>
                                    <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_class.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="checkbox" v-model="form.step3.client_class" name="client_classification"
                                                value="Refugees/Evacuees" class="check-old form-check-input form__input">
                                            <span class="checkmark" @click="validateClassification('refugees')"></span>
                                            Refugees/Evacuees
                                        </label>
                                    </div>
                                    <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_class.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="checkbox" v-model="form.step3.client_class" name="client_classification"
                                                value="Senior Citizen
                                                "
                                                class="check-old form-check-input form__input">
                                            <span class="checkmark" @click="validateClassification('senior_citizen')"></span>
                                            Senior Citizen
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_class.$error }">
                                        <label class="form-check-label form__label">
                                            <input type="checkbox" v-model="form.step3.client_class" name="client_classification"
                                                value="OFW" class="check-old form-check-input form__input">
                                            <span class="checkmark" @click="validateClassification('ofw')"></span>
                                            OFW
                                        </label>
                                    </div>
                                    <div v-show="form.step3.client_classification.ofw.checkbox">
                                        <div class="ml-5 form-check radio-div checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_classification.ofw.input.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="radio" v-model="form.step3.client_classification.ofw.input"
                                                    name="specified_client_classification" value="Land-based" class="form-check-input radio-old form__input">
                                                <span class="radio"></span>
                                                Land-based
                                            </label>
                                        </div>
                                        <div class="ml-5 form-check radio-div checkbox-div" :class="{ 'form-group--error': $v.form.step3.client_classification.ofw.input.$error }">
                                            <label class="form-check-label form__label">
                                                <input type="radio" v-model="form.step3.client_classification.ofw.input"
                                                    name="specified_client_classification" value="Sea-based" class="form-check-input radio-old form__input">
                                                <span class="radio"></span>
                                                Sea-based
                                            </label>
                                        </div>
                                        <div class="error pt-4" v-if="!$v.form.step3.client_classification.ofw.input.required">Kindly
                                            select if it is Land-based or Sea-based.</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" :class="{ 'form-group--error': $v.form.step3.client_class.$error }">
                                        <label for="" class="form__label"></label>
                                        <input type="hidden" v-model="form.step3.client_classification" class="form__input"
                                            v-model.trim="$v.form.step3.client_classification.$model">
                                    </div>
                                    <div class="error text-center" v-if="!$v.form.step3.client_classification.required">Client's
                                        Classification is required. Kindly choose one or more from the list.</div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-show="steps[activeStep] === 4">
                <div class="col-md-6 mt-3">
                    <div class="card card-border shadow">
                        <div class="row mr-4 ml-3">
                            <div class="col-md-12 text-center">
                                <br>
                                <h4 class="text-center">III. Adverse Party</h4>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step4.adverse_party.$error }">
                                    <label class="form-check-label form__label">
                                        <input type="radio" v-model="form.step4.adverse_party" name="adverse_party"
                                            value="Plainfill/Petitioner/Complainant" class="form-check-input check-old form__input"
                                            v-model.trim="$v.form.step4.adverse_party.$model">
                                        <span class="radio"></span>
                                        Plainfill/Petitioner/Complainant
                                    </label>
                                </div>
                                <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step4.adverse_party.$error }">
                                    <label class="form-check-label form__label">
                                        <input type="radio" v-model="form.step4.adverse_party" name="adverse_party"
                                            value="Defendant/Respondent/Accused" class="form-check-input check-old form__input"
                                            v-model.trim="$v.form.step4.adverse_party.$model">
                                        <span class="radio"></span>
                                        Defendant/Respondent/Accused
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step4.adverse_party.$error }">
                                    <label class="form-check-label form__label">
                                        <input type="radio" v-model="form.step4.adverse_party" name="adverse_party"
                                            value="Oppositor/Others" class="form-check-input check-old form__input"
                                            v-model.trim="$v.form.step4.adverse_party.$model">
                                        <span class="radio"></span>
                                        Oppositor/Others
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step4.adverse_party.$error }">
                                    <label for="" class="form__label"></label>
                                    <input type="hidden" v-model="form.step4.adverse_party" class="form__input"
                                        v-model.trim="$v.form.step4.adverse_party.$model">
                                </div>
                                <div class="error text-center" v-if="!$v.form.step4.adverse_party.required">Adverse
                                    Party is required.</div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" :class="{ 'form-group--error': $v.form.step4.adverse_party_name.$error }">
                                    <br>
                                    <label for="adverse_party_name" class="form__label">Name</label>
                                    <input type="text" v-model="form.step4.adverse_party_name" name="adverse_party_name"
                                        class="form-control form__input" v-model.trim="$v.form.step4.adverse_party_name.$model"
                                        placeholder="Firstname Middlename Lastname">
                                </div>
                                <div class="error" v-if="!$v.form.step4.adverse_party_name.required">Adverse Party Name
                                    is required</div>

                                <div class="form-group" :class="{ 'form-group--error': $v.form.step4.adverse_party_address.$error }">
                                    <br>
                                    <label for="adverse_party_address" class="form__label">Address</label>
                                    <input type="text" v-model="form.step4.adverse_party_address" name="adverse_party_address"
                                        class="form-control form__input" v-model.trim="$v.form.step4.adverse_party_address.$model"
                                        placeholder="House no. Steet, Barangay, City, Province">
                                </div>
                                <div class="error" v-if="!$v.form.step4.adverse_party_address.required">Adverse Party
                                    Address is required</div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="card card-border shadow">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <br>
                                <h4 class="text-center ml-3">IV. Cause of Action/Nature of Offense</h4>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group" :class="{ 'form-group--error': $v.form.step5.case_of_action.$error }">
                                <textarea v-model="form.step5.case_of_action" name="action_cause" class="form-control form__input"
                                    v-model.trim="$v.form.step5.case_of_action.$model" rows="13"></textarea>
                            </div>
                            <div class="error" v-if="!$v.form.step5.case_of_action.required">Cause of Acion/Nature of
                                Offense is required</div>
                        </div>
                    </div>
                </div>
                <div class="card card-border shadow col-md-12">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <br>
                            <h4 class="text-center">Proof of Indigency Submitted</h4>
                        </div>
                        <div class="mt-3 form-group" :class="{ 'form-group--error': $v.form.step5.pending_submission.$error }">
                            <label for="proof" class="ml-5 form__label">Pending for Submission?</label>
                        </div>
                        <div class="ml-2 col-md-12 row">
                            <div class="col-md-2 pl-5">
                                <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step5.pending_submission.$error }">
                                    <label class="form-check-label form__label">
                                        <input type="radio" v-model="form.step5.pending_submission" name="pending_submission"
                                            value="Yes" class="form-check-input radio-old form__input">
                                        <span class="radio" @click="resetProof"></span>
                                        Yes
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check radio-div" :class="{ 'form-group--error': $v.form.step5.pending_submission.$error }">
                                    <label class="form-check-label form__label">
                                        <input type="radio" v-model="form.step5.pending_submission" name="pending_submission"
                                            value="No" class="form-check-input radio-old form__input">
                                        <span class="radio" @click="resetProof"></span>
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" :class="{ 'form-group--error': $v.form.step5.pending_submission.$error }">
                        </div>
                        <div class="error ml-5 pt-3" v-if="!$v.form.step5.pending_submission.required">Pending for
                            Submission
                            is required</div>

                        <div v-show="form.step5.pending_submission === 'No'" class="col-md-12 form-group" :class="{ 'form-group--error': $v.form.step5.proof_of_indigency.$error }">
                            <label for="proof" class="mt-2 ml-4 form__label">Kindly choose one or more proof of
                                indigency</label>
                        </div>
                        <div class="col-md-3 text-center" v-show="form.step5.pending_submission === 'No'">
                            <div class="form-check checkbox-div ml-5" :class="{ 'form-group--error': $v.form.step5.proof_of_indigency.$error }">
                                <label class="form-check-label form__label">
                                    <input type="checkbox" v-model="form.step5.proof_of_indigency" v-model.trim="$v.form.step5.proof_of_indigency.$model"
                                        name="submitted_proof_indigency" value="Income Tax Return" class="form-check-input check-old form__input">
                                    <span class="checkmark-s"></span>
                                    Income Tax Return
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 text-center" v-show="form.step5.pending_submission === 'No'">
                            <div class="form-check checkbox-div" :class="{ 'form-group--error': $v.form.step5.proof_of_indigency.$error }">
                                <label class="form-check-label form__label">
                                    <input type="checkbox" v-model="form.step5.proof_of_indigency" v-model.trim="$v.form.step5.proof_of_indigency.$model"
                                        name="submitted_proof_indigency" value="Certification from Barangay" class="form-check-input check-old form__input">
                                    <span class="checkmark-s"></span>
                                    Certification from Barangay
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 text-center" v-show="form.step5.pending_submission === 'No'">
                            <div class="form-check checkbox-div ml-4" :class="{ 'form-group--error': $v.form.step5.proof_of_indigency.$error }">
                                <label class="form-check-label mr-2 form__label">
                                    <input type="checkbox" v-model="form.step5.proof_of_indigency" v-model.trim="$v.form.step5.proof_of_indigency.$model"
                                        name="submitted_proof_indigency" value="Certification (DSWD)" class="form-check-input check-old form__input">
                                    <span class="checkmark-s"></span>
                                    Certification (DSWD)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 text-center" v-show="form.step5.pending_submission === 'No'">
                            <div class="form-check checkbox-div mr-5" :class="{ 'form-group--error': $v.form.step5.proof_of_indigency.$error }">
                                <label class="form-check-label form__label">
                                    <input type="checkbox" v-model="form.step5.proof_of_indigency" v-model.trim="$v.form.step5.proof_of_indigency.$model"
                                        name="submitted_proof_indigency" value="Others" class="form-check-input check-old form__input">
                                    <span class="checkmark-s"></span>
                                    Others (payslip, etc.)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="form__label"></label>
                                <input type="hidden" v-model="form.step5.proof_of_indigency" class="form__input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <div class="row m-3">
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="button" class="btn btn-success" @click="resetForm"><i class="material-icons">close</i>Cancel
                        </button>
                        <button type="button" class="btn btn-success" @click="navigation('previous')" v-show="steps[activeStep] !== 1"><i
                                class="material-icons">arrow_back</i> Previous</button>
                        <button type="button" class="btn btn-success" @click="navigation('next')" v-show="steps[activeStep] !== 4">Next
                            <i class="material-icons">arrow_forward</i></button>
                        <button type="button" class="btn btn-success" v-show="steps[activeStep] === 4" @click="createInterviewForm">Submit
                            Form <i class="material-icons">check_circle</i></button>
                    </div>
                </div>
            </div>
        </form>
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
    export default {
        components: {
            Datepicker,
        },
        data() {
            return {
                // disabledPastDates: {
                //     to: new Date(Date.now() - 8640000)
                // },
                religionList: [
                    'Catholic',
                    'Iglesia ni Christo',
                    'Born Again',
                    'Islam',
                    'Buddhists',
                    'Muslim',
                ],
                citizenshipList: [],
                languagesDialectsList: [
                    'Bikol',
                    'Cebuano',
                    'English',
                    'Ilonggo',
                    'Ilocano',
                    'Kapampangan',
                    'Pangasinan',
                    'Tagalog',
                    'Waray',
                ],
                disabledFutureDates: {
                    from: new Date()
                },
                authUser: new Form({
                    id: '',
                    firstname: '',
                    middlename: '',
                    lastname: '',
                    type: '',
                    status: '',
                }),
                detainedDate: new Date(),
                activeStep: 1,
                steps: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                showInput: false,
                attorneys: {},
                date: new Date(),
                form: new Form({
                    step1: {
                        interviewer: '',
                        assigned_to: '',
                        referred_by: '',
                        refer_to: '',
                        nature_request: '',
                        nature_case: {
                            case: '',
                            input: '',
                            isRequired: false
                        },
                        firstname: '',
                        lastname: ''
                    },
                    step2: {
                        isRepresentative: 'false',
                        client_name: '',
                        client_religion: '',
                        client_citizenship: '',
                        client_address: '',
                        client_email: '',
                        client_monthly_income: '',
                        detained: '',
                        detained_since: '',
                        client_age: '',
                        client_gender: '',
                        client_civil_status: '',
                        client_educational_attainment: '',
                        client_dialect: [],
                        client_contact: '',
                        client_spouse: '',
                        spouse_address: '',
                        spouse_contact: '',
                        detention_place: '',
                        interviewee_name: '',
                        interviewee_address: '',
                        interviewee_relationship_to_client: '',
                        interviewee_age: '',
                        interviewee_gender: '',
                        interviewee_civil_status: '',
                        interviewee_contact: '',
                        interviewee_email: '',
                    },
                    step3: {
                        isRequired: false,
                        client_involvement: '',
                        client_complaint: [],
                        client_class: [],
                        client_classification: {
                            children_in_conflict: {
                                checkbox: false,
                                input: ''
                            },
                            women_client: {
                                checkbox: false,
                                input: ''
                            },
                            indigenous_group: {
                                checkbox: false,
                                input: ''
                            },
                            person_with_disability: {
                                checkbox: false,
                                input: ''
                            },
                            urban_poor: {
                                checkbox: false,
                                input: ''
                            },
                            rural_poor: {
                                checkbox: false,
                                input: ''
                            },
                            refugees: {
                                checkbox: false,
                                input: ''
                            },
                            senior_citizen: {
                                checkbox: false,
                                input: ''
                            },
                            ofw: {
                                checkbox: false,
                                input: ''
                            }
                        }
                    },
                    step4: {
                        adverse_party: '',
                        adverse_party_name: '',
                        adverse_party_address: '',
                        fact_of_the_case: 'None'
                    },
                    step5: {
                        case_of_action: '',
                        pending_in_court: 'No',
                        title_of_case: '',
                        court_body_tribunal: '',
                        other_case_of_action: '',
                        other_court_body_tribunal: '',
                        pending_submission: '',
                        proof_of_indigency: []
                    }
                })
            }
        },
        validations: {
            form: {
                step1: {
                    interviewer: {
                        required
                    },
                    assigned_to: {
                        required
                    },
                    referred_by: {
                        required
                    },
                    refer_to: {
                        required
                    },
                    nature_request: {
                        required
                    },
                    nature_case: {
                        case: {
                            required: requiredIf((natureCase) => {
                                return natureCase.isRequired
                            })
                        },
                        input: {
                            required: requiredIf((natureCase) => {
                                return natureCase.isRequired
                            })
                        },
                    }
                },
                step2: {
                    client_name: {
                        required,
                    },
                    client_religion: {
                        required,
                    },
                    client_citizenship: {
                        required,
                    },
                    client_address: {
                        required
                    },
                    client_email: {
                        email
                    },
                    client_monthly_income: {
                        required,
                        minLength: minLength(3),
                    },
                    detained: {
                        required
                    },
                    detained_since: {
                        required: requiredIf((isDetained) => {
                            if (isDetained.detained === 'Yes') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    },
                    client_age: {
                        required,
                        between: between(18, 100)
                    },
                    client_gender: {
                        required
                    },
                    client_civil_status: {
                        required
                    },
                    client_educational_attainment: {
                        required,
                    },
                    client_dialect: {
                        required,
                    },
                    client_contact: {
                        required,
                        minLength: minLength(11),
                        maxLength: maxLength(11)
                    },
                    client_spouse: {
                        required: requiredIf((status) => {
                            if (status.client_civil_status === 'Married') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    },
                    spouse_address: {
                        required: requiredIf((status) => {
                            if (status.client_civil_status === 'Married') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    },
                    spouse_contact: {
                        required: requiredIf((status) => {
                            if (status.client_civil_status === 'Married') {
                                return true
                            } else {
                                return false
                            }
                        }),
                        minLength: minLength(11),
                        maxLength: maxLength(11)
                    },
                    detention_place: {
                        required: requiredIf((isDetained) => {
                            if (isDetained.detained === 'Yes') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    },
                    interviewee_name: {
                        required: requiredIf((step2) => {
                            if (step2.isRepresentative === 'true') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    },
                    interviewee_address: {
                        required: requiredIf((step2) => {
                            if (step2.isRepresentative === 'true') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    },
                    interviewee_relationship_to_client: {
                        required: requiredIf((step2) => {
                            if (step2.isRepresentative === 'true') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    },
                    interviewee_age: {
                        required: requiredIf((step2) => {
                            if (step2.isRepresentative === 'true') {
                                return true
                            } else {
                                return false
                            }
                        }),
                        between: between(18, 100)
                    },
                    interviewee_gender: {
                        required: requiredIf((step2) => {
                            if (step2.isRepresentative === 'true') {
                                return true
                            } else {
                                return false
                            }
                        })
                    },
                    interviewee_civil_status: {
                        required: requiredIf((step2) => {
                            if (step2.isRepresentative === 'true') {
                                return true
                            } else {
                                return false
                            }
                        })
                    },
                    interviewee_contact: {
                        required: requiredIf((step2) => {
                            if (step2.isRepresentative === 'true') {
                                return true
                            } else {
                                return false
                            }
                        }),
                        minLength: minLength(11),
                        maxLength: maxLength(11)
                    },
                    interviewee_email: {
                        email
                    }
                },
                step3: {
                    client_involvement: {
                        required
                    },
                    client_complaint: {
                        required: requiredIf((involvement) => {
                            return involvement.isRequired
                        })
                    },
                    client_class: {
                        required
                    },
                    client_classification: {
                        children_in_conflict: {
                            input: {
                                required: requiredIf((valid) => {
                                    if (valid.checkbox === true) {
                                        return true
                                    } else {
                                        return false
                                    }
                                }),
                                between: between(0, 100)
                            }
                        },
                        women_client: {
                            input: {
                                required: requiredIf((valid) => {
                                    if (valid.checkbox === true) {
                                        return true
                                    } else {
                                        return false
                                    }
                                }),
                            }
                        },
                        indigenous_group: {
                            input: {
                                required: requiredIf((valid) => {
                                    if (valid.checkbox === true) {
                                        return true
                                    } else {
                                        return false
                                    }
                                }),
                            }
                        },
                        person_with_disability: {
                            input: {
                                required: requiredIf((valid) => {
                                    if (valid.checkbox === true) {
                                        return true
                                    } else {
                                        return false
                                    }
                                }),
                            }
                        },
                        urban_poor: {
                            input: {
                                required: requiredIf((valid) => {
                                    if (valid.checkbox === true) {
                                        return true
                                    } else {
                                        return false
                                    }
                                }),
                            }
                        },
                        rural_poor: {
                            input: {
                                required: requiredIf((valid) => {
                                    if (valid.checkbox === true) {
                                        return true
                                    } else {
                                        return false
                                    }
                                }),
                            }
                        },
                        refugees: {
                            input: {
                                required: requiredIf((valid) => {
                                    if (valid.checkbox === true) {
                                        return true
                                    } else {
                                        return false
                                    }
                                })
                            }
                        },
                        senior_citizen: {
                            input: {
                                required: requiredIf((valid) => {
                                    if (valid.checkbox === true) {
                                        return true
                                    } else {
                                        return false
                                    }
                                })
                            }
                        },
                        ofw: {
                            input: {
                                required: requiredIf((valid) => {
                                    if (valid.checkbox === true) {
                                        return true
                                    } else {
                                        return false
                                    }
                                }),
                            }
                        }
                    }
                },
                step4: {
                    adverse_party: {
                        required
                    },
                    adverse_party_name: {
                        required,
                    },
                    adverse_party_address: {
                        required,
                    },
                    fact_of_the_case: {
                        required,
                    }
                },
                step5: {
                    case_of_action: {
                        required,
                    },
                    pending_in_court: {
                        required
                    },
                    title_of_case: {
                        required: requiredIf((check) => {
                            if (check.pending_in_court === 'Yes') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    },
                    court_body_tribunal: {
                        required: requiredIf((check) => {
                            if (check.pending_in_court === 'Yes') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    },
                    other_case_of_action: {
                        required: requiredIf((check) => {
                            if (check.pending_in_court === 'Yes') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    },
                    other_court_body_tribunal: {
                        required: requiredIf((check) => {
                            if (check.pending_in_court === 'Yes') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    },
                    pending_submission: {
                        required
                    },
                    proof_of_indigency: {
                        required: requiredIf((check) => {
                            if (check.pending_submission === 'No') {
                                return true
                            } else {
                                return false
                            }
                        }),
                    }
                }
            }
        },
        methods: {
            convertDate() {
                this.form.step2.detained_since = window.moment(this.form.step2.detained_since).format('YYYY-MM-DD')
            },
            onSelect(items) {
                this.form.step2.client_dialect = items
            },
            resetForm() {
                this.activeStep = 1
                this.form.reset()
                this.$v.$reset()
            },
            stepOnClick(step) {
                if (step === 1) {
                    this.validateForm()
                    if (!this.$v.form.step1.$invalid) {
                        this.activeStep = step
                    }
                } else if (step === 2) {
                    this.validateForm()
                    if (!this.$v.form.step1.$invalid) {
                        this.activeStep = step
                    }
                } else if (step === 3) {
                    this.validateForm()
                    if (!this.$v.form.step2.$invalid) {
                        this.activeStep = step
                    }
                } else if (step === 4) {
                    this.validateForm()
                    if (!this.$v.form.step3.$invalid) {
                        this.activeStep = step
                    }
                } else if (step === 5) {
                    this.validateForm()
                    if (!this.$v.form.step4.$invalid) {
                        this.activeStep = step
                    }
                } else if (step === 6) {
                    this.validateForm()
                    if (!this.$v.form.step5.$invalid) {
                        this.activeStep = step
                    }
                }
            },
            showOtherNatureRequest() {
                return this.showInput = !this.showInput
            },
            createInterviewForm() {
                if (this.$gate.isStaffAndSuperAdmin()) {
                    this.$Progress.start()
                    this.$v.form.step5.$touch()
                    if (this.$v.form.step5.$invalid) {
                        this.$Progress.fail()
                    } else {
                        this.form.post('api/interview-form').then(() => {
                            toast({
                                type: 'success',
                                title: 'Interview Form/Client Profile Created Successfully.'
                            })
                            this.activeStep = 1
                            this.resetForm()
                            this.$Progress.finish()
                        })
                    }
                }
            },
            resetSpouseInfo() {
                this.form.step2.client_spouse = ''
                this.form.step2.spouse_address = ''
                this.form.step2.spouse_contact = ''
            },
            resetCaseInfo() {
                this.form.step5.title_of_case = ''
                this.form.step5.court_body_tribunal = ''
                this.form.step5.other_case_of_action = ''
                this.form.step5.other_court_body_tribunal = ''
            },
            resetProof() {
                this.form.step5.proof_of_indigency = []
            },
            validateNumber(event) {
                if ((event.keyCode < 48 || event.keyCode > 57)) {
                    event.returnValue = false;
                }
            },
            validateClassification(classification) {
                if (classification === 'children_in_conflict') {
                    this.form.step3.client_classification.children_in_conflict.input = ''
                    this.form.step3.client_classification.children_in_conflict.checkbox = !this.form.step3.client_classification
                        .children_in_conflict.checkbox
                    if (!this.form.step3.client_classification.children_in_conflict.checkbox) {
                        this.form.step3.client_classification.children_in_conflict.input = ''
                    }
                }
                if (classification === 'women_client') {
                    this.form.step3.client_classification.women_client.checkbox = !this.form.step3.client_classification
                        .women_client.checkbox
                    if (!this.form.step3.client_classification.women_client.checkbox) {
                        this.form.step3.client_classification.women_client.input = ''
                    } else {
                        this.form.step3.client_classification.women_client.input = 'Women Client'
                    }
                }
                if (classification === 'indigenous_group') {
                    this.form.step3.client_classification.indigenous_group.input = ''
                    this.form.step3.client_classification.indigenous_group.checkbox = !this.form.step3.client_classification
                        .indigenous_group.checkbox
                    if (!this.form.step3.client_classification.indigenous_group.checkbox) {
                        this.form.step3.client_classification.indigenous_group.input = ''
                    }
                }
                if (classification === 'person_with_disability') {
                    this.form.step3.client_classification.person_with_disability.input = ''
                    this.form.step3.client_classification.person_with_disability.checkbox = !this.form.step3.client_classification
                        .person_with_disability.checkbox
                    if (!this.form.step3.client_classification.person_with_disability.checkbox) {
                        this.form.step3.client_classification.person_with_disability.input = ''
                    }
                }
                if (classification === 'urban_poor') {
                    this.form.step3.client_classification.urban_poor.input = ''
                    this.form.step3.client_classification.urban_poor.checkbox = !this.form.step3.client_classification.urban_poor
                        .checkbox
                    if (!this.form.step3.client_classification.urban_poor.checkbox) {
                        this.form.step3.client_classification.urban_poor.input = ''
                    }
                }
                if (classification === 'rural_poor') {
                    this.form.step3.client_classification.rural_poor.input = ''
                    this.form.step3.client_classification.rural_poor.checkbox = !this.form.step3.client_classification.rural_poor
                        .checkbox
                    if (!this.form.step3.client_classification.rural_poor.checkbox) {
                        this.form.step3.client_classification.rural_poor.input = ''
                    }
                }
                if (classification === 'refugees') {
                    this.form.step3.client_classification.refugees.checkbox = !this.form.step3.client_classification.refugees
                        .checkbox
                    if (!this.form.step3.client_classification.refugees.checkbox) {
                        this.form.step3.client_classification.refugees.input = ''
                    } else {
                        this.form.step3.client_classification.refugees.input = 'Refugees/Evacuees'
                    }
                }
                if (classification === 'senior_citizen') {
                    this.form.step3.client_classification.senior_citizen.checkbox = !this.form.step3.client_classification
                        .senior_citizen.checkbox
                    if (!this.form.step3.client_classification.senior_citizen.checkbox) {
                        this.form.step3.client_classification.senior_citizen.input = ''
                    } else {
                        this.form.step3.client_classification.senior_citizen.input = 'Senior Citizen'
                    }
                }
                if (classification === 'ofw') {
                    this.form.step3.client_classification.ofw.checkbox = !this.form.step3.client_classification.ofw.checkbox
                    if (!this.form.step3.client_classification.ofw.checkbox) {
                        this.form.step3.client_classification.ofw.input = ''
                    }
                }
            },
            validateForm() {
                this.$Progress.start()
                if (this.activeStep === 1) {
                    this.$v.form.step1.$touch()
                    if (this.$v.form.step1.$invalid) {
                        this.$Progress.fail()
                    } else {
                        this.$Progress.finish()
                        this.activeStep = this.activeStep + 1
                    }
                } else if (this.activeStep === 2) {
                    this.$v.form.step2.$touch()
                    if (this.$v.form.step2.$invalid) {
                        this.$Progress.fail()
                    } else {
                        this.$Progress.finish()
                        this.activeStep = this.activeStep + 1

                        // if (this.form.step2.client_gender === 'Female') {
                        //     if (this.form.step3.client_classification.women_client.checkbox === false) {
                        //         this.form.step3.client_classification.women_client.checkbox = true
                        //         this.form.step3.client_classification.women_client.input = 'Women Client'
                        //         document.querySelectorAll('input[type="checkbox"]')[9].click()
                        //     } else {
                        //         return false
                        //     }
                        // } else {
                        //     if (this.form.step3.client_classification.women_client.checkbox === true) {
                        //         this.form.step3.client_classification.women_client.checkbox = false
                        //         this.form.step3.client_classification.women_client.input = ''
                        //         document.querySelectorAll('input[type="checkbox"]')[9].click()
                        //     } else {
                        //         return false
                        //     }
                        // }

                        // if (this.form.step2.client_age >= 60) {
                        //     if (this.form.step3.client_classification.senior_citizen.checkbox === false) {
                        //         this.form.step3.client_classification.women_client.checkbox = true
                        //         this.form.step3.client_classification.senior_citizen.input = 'Senior Citizen'
                        //         document.querySelectorAll('input[type="checkbox"]')[15].click()
                        //     } else {
                        //         return false
                        //     }
                        // } else {
                        //     if (this.form.step3.client_classification.senior_citizen.checkbox === true) {
                        //         this.form.step3.client_classification.senior_citizen.checkbox = false
                        //         this.form.step3.client_classification.senior_citizen.input = ''
                        //         document.querySelectorAll('input[type="checkbox"]')[15].click()
                        //     } else {
                        //         return false
                        //     }
                        // }
                    }
                } else if (this.activeStep === 3) {
                    this.$v.form.step3.$touch()
                    if (this.$v.form.step3.$invalid) {
                        this.$Progress.fail()
                    } else {
                        this.$Progress.finish()
                        this.activeStep = this.activeStep + 1
                    }
                } else if (this.activeStep === 4) {
                    this.$v.form.step4.$touch()
                    if (this.$v.form.step4.$invalid) {
                        this.$Progress.fail()
                    } else {
                        this.$Progress.finish()
                        this.activeStep = this.activeStep + 1
                    }
                } else if (this.activeStep === 5) {
                    this.$v.form.step5.$touch()
                    if (this.$v.form.step5.$invalid) {
                        this.$Progress.fail()
                    } else {
                        this.$Progress.finish()
                    }
                }
            },
            navigation(move) {
                if (move === 'next') {
                    this.validateForm()
                } else {
                    this.activeStep = this.activeStep - 1
                }
            },
            ClientInfo() {
                if (Object.keys(this.$parent.clientInfo).length !== 0) {
                    this.form.step2.client_name = this.$parent.clientInfo.client_name
                    this.form.step2.client_religion = this.$parent.clientInfo.client_religion
                    this.form.step2.client_citizenship = this.$parent.clientInfo.client_citizenship
                    this.form.step2.client_address = this.$parent.clientInfo.client_address
                    this.form.step2.client_email = this.$parent.clientInfo.client_email
                    this.form.step2.client_monthly_income = this.$parent.clientInfo.client_monthly_income
                    this.form.step2.detained = this.$parent.clientInfo.detained
                    this.form.step2.detained_since = this.$parent.clientInfo.detained_since
                    this.form.step2.client_age = this.$parent.clientInfo.client_age
                    this.form.step2.client_gender = this.$parent.clientInfo.client_gender
                    this.form.step2.client_civil_status = this.$parent.clientInfo.client_civil_status
                    this.form.step2.client_educational_attainment = this.$parent.clientInfo.client_educational_attainment
                    this.form.step2.client_dialect = this.$parent.clientInfo.client_dialect.split(',')
                    this.form.step2.client_contact = this.$parent.clientInfo.client_contact
                    this.form.step2.client_spouse = this.$parent.clientInfo.client_spouse
                    this.form.step2.spouse_address = this.$parent.clientInfo.spouse_address
                    this.form.step2.spouse_contact = this.$parent.clientInfo.spouse_contact
                    this.form.step2.detention_place = this.$parent.clientInfo.detention_place
                }
            }
        },
        mounted() {
            this.ClientInfo()
            axios.get('api/user').then(({
                data
            }) => (this.attorneys = data))
            axios.get('api/profile').then(({
                data
            }) => {
                this.authUser.fill(data)
                if (this.authUser.type === 'Staff' || this.authUser.type === 'Super Admin') {
                    this.form.step1.interviewer = this.authUser.firstname + ' ' + this.authUser.lastname
                }
            })
            Fire.$on('searching', () => {
                let query = this.$parent.search
                axios.get('api/findUser?val=' + query).then((data) => {
                    this.$parent.searchResults = data.data
                }).catch(() => {
                    this.$Progress.fail()
                })
            })
            $.getJSON('./nationality.json').then((data) => {
                for (let i = 0; i < data.length; i++) {
                    this.citizenshipList.push(data[i].nationality)
                }
            })
        }
    }

</script>
