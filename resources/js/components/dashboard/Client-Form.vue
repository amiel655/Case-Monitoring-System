<template>
    <div class="mt-3">
        <div class="loader" v-show="loading">
                <rotate-loader :loading="loading" :color="'#34cc7d'" :size="'20px'"></rotate-loader>
        </div>
        <div v-if="notFound">
            <not-found></not-found>
        </div>
        <form v-if="form.control_num.length !== 0" @submit.prevent="updateForm()">
            <div class="row">
                <div class="col-md-12 text-right pb-3" v-show="$gate.isStaffAndSuperAdmin()" v-if="form.status === 'On-Going'">
                    <label for="edit" class="form__label">Edit Form</label>
                    <label class="m-2 switch">
                                    <input type="checkbox" @click="toggleEdit = !toggleEdit" class="access_code">
                                    <span class="slider round"></span>
                                </label>
                </div>
                <div class="col-md-6">
                    <div class="card card-border shadow">
                        <div class="row mr-4 ml-4">
                            <div class="col-md-12 text-center">
                                <br>
                                <h4 class="text-center">Control Referrence</h4>
                                <center>
                                    <div class="row">
                                        <!-- Region -->
                                        <div class="col-md-12">
                                            <i>No. {{$route.params.id}}</i>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mt-3">
                                                Region
                                                <input type="text" name="region" class="form-control formStyle no-focus"
                                                    placeholder="3" readonly>
                                            </div>
                                        </div>
                                        <!-- District Office -->
                                        <div class="col-md-6 mt-3">
                                            <div class="form-group">
                                                District Office
                                                <input type="text" name="districtOffice" class="form-control formStyle no-focus"
                                                    placeholder="CSFP" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </center>
                            </div>
                            <div class="col-md-12 pb-2">

                                <!-- Interviewer -->
                                <div class="form-group">
                                    <label for="client_civil_status">Interviewer</label>
                                    <div v-if="!toggleEdit">
                                        <input type="text" name="interviewwer" v-model="form.interviewer" class="form-control"
                                        placeholder="Interviewer" readonly>
                                    </div>
                                    <div class="dropdown" v-if="toggleEdit">
                                        <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span v-show="form.interviewer === ''">Select Interviewer</span>
                                            <span v-show="form.interviewer !== ''">{{ form.interviewer }} </span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" v-for="atty in attorneys" v-if="atty.type !== 'Admin' && atty.type !== 'Super Admin' && atty.status !== 'Unavailable'"
                                                :key="atty.id" :value="atty.firstname + ' ' + atty.lastname" @click="form.interviewer = atty.firstname + ' ' + atty.lastname">{{
                                                atty.firstname }} {{
                                                atty.lastname }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Assigned to -->
                                <div class="form-group">
                                    <label for="client_civil_status">Assigned To</label>
                                    <div v-if="!toggleEdit">
                                        <input type="text" name="assgiend_to" v-model="form.assigned_to" class="form-control"
                                        placeholder="Assigned To" readonly>
                                    </div>
                                    <div class="dropdown" v-if="toggleEdit">
                                        <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span v-show="form.assigned_to === ''">Select Assigned To</span>
                                            <span v-show="form.assigned_to !== ''">Atty. {{ form.assigned_to }} </span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" v-for="atty in attorneys" v-if="atty.type !== 'Staff' && atty.status !== 'Unavailable'"
                                                :key="atty.id" :value="atty.firstname + ' ' + atty.lastname" @click="form.assigned_to = atty.firstname + ' ' + atty.lastname">Atty. {{
                                                atty.firstname }} {{
                                                atty.lastname }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Referred/Indorsed by -->
                                <div class="form-group">
                                    <label for="referred_by">Referred/Indorsed By</label>
                                    <br>
                                    <input type="text" name="referred_by" v-model="form.referred_by" class="form-control"
                                        placeholder="Enter Referred/Indorsed By" :disabled="!toggleEdit">
                                </div>

                                <!-- Refer to -->
                                <div class="form-group">
                                    <label for="refer_to">Refer To</label>
                                    <br>
                                    <input type="text" name="refer_to" v-model="form.refer_to" class="form-control"
                                        placeholder="Enter Referred/Indorsed By" :disabled="!toggleEdit">
                                </div>
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
                                            <div class="form-check radio-div nature-req">
                                                <label class="form-check-label" v-if="!toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Legal Advice" class="form-check-input radio-old" :disabled="!toggleEdit">
                                                    <span class="radio"></span>
                                                    Legal Advice
                                                </label>
                                                <label class="form-check-label" v-if="toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Legal Advice" class="form-check-input radio-old">
                                                    <span class="radio" @click="clearNatureCase"></span>
                                                    Legal Advice
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req">
                                                <label class="form-check-label" v-if="!toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Legal Documentation" class="form-check-input radio-old" :disabled="!toggleEdit">
                                                    <span class="radio"></span>
                                                    Legal Documentation
                                                </label>
                                                <label class="form-check-label" v-if="toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Legal Documentation" class="form-check-input radio-old">
                                                    <span class="radio" @click="clearNatureCase"></span>
                                                    Legal Documentation
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req">
                                                <label class="form-check-label" v-if="!toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Representation in Court/Quasi-Judicial Bodies" class="form-check-input radio-old"
                                                        :disabled="!toggleEdit">
                                                    <span class="radio"></span>
                                                    Representation in Court/Quasi-Judicial Bodies
                                                </label>
                                                <label class="form-check-label" v-if="toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Representation in Court/Quasi-Judicial Bodies" class="form-check-input radio-old"
                                                        @click="clearNatureCase">
                                                    <span class="radio"></span>
                                                    Representation in Court/Quasi-Judicial Bodies
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req">
                                                <label class="form-check-label" v-if="!toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        class="form-check-input radio-old" value="Inquest/Legal Assistance" :disabled="!toggleEdit">
                                                    <span class="radio"></span>
                                                    Inquest/Legal Assistance
                                                </label>
                                                <label class="form-check-label" v-if="toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        class="form-check-input radio-old" value="Inquest/Legal Assistance">
                                                    <span class="radio" @click="clearNatureCase"></span>
                                                    Inquest/Legal Assistance
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req">
                                                <label class="form-check-label"  v-if="!toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Mediation/Concillation" class="form-check-input radio-old" :disabled="!toggleEdit">
                                                    <span class="radio"></span>
                                                    Mediation/Concillation
                                                </label>
                                                <label class="form-check-label" v-if="toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Mediation/Concillation" class="form-check-input radio-old">
                                                    <span class="radio" @click="clearNatureCase"></span>
                                                    Mediation/Concillation
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req">
                                                <label class="form-check-label" v-if="!toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Administration of Oath" class="form-check-input radio-old" :disabled="!toggleEdit">
                                                    <span class="radio"></span>
                                                    Administration of Oath
                                                </label>
                                                <label class="form-check-label" v-if="toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Administration of Oath" class="form-check-input radio-old">
                                                    <span class="radio" @click="clearNatureCase"></span>
                                                    Administration of Oath
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="form-check radio-div nature-req">
                                                <label class="form-check-label" v-if="!toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Others" class="form-check-input radio-old" :disabled="!toggleEdit">
                                                    <span class="radio" ></span>
                                                    Others
                                                </label>
                                                <label class="form-check-label" v-if="toggleEdit">
                                                    <input type="radio" v-model="form.nature_request" name="nature_request"
                                                        value="Others" class="form-check-input radio-old">
                                                    <span class="radio" @click="clearNatureCase"></span>
                                                    Others
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12" v-if="form.nature_request !== 'Legal Advice' && form.nature_request !== 'Legal Documentation' && form.nature_request !== 'Representation in Court/Quasi-Judicial Bodies' && form.nature_request !== 'Inquest/Legal Assistance' && form.nature_request !== 'Mediation/Concillation' && form.nature_request !== 'Administration of Oath'">
                                            <div class="form-check radio-div">
                                                <div class="pb-4">
                                                    <label class="form-check-label">
                                                        <input type="text" v-model="form.nature_request" name="nature_request"
                                                            class="form-control" placeholder="Please Specify" :disabled="!toggleEdit">
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

                <div class="col-md-12 mt-3" v-show="form.nature_request === 'Representation in Court/Quasi-Judicial Bodies'">
                    <div class="card card-border shadow">
                        <div class="mr-4 ml-4">
                            <div class="col-md-12 text-center">
                                <br>
                                <h4 class="text-center nature-req">I. Nature of the Case</h4>
                            </div>
                            <div class="row mt-3 mx-auto pt-3">
                                <div class="col-md-1"></div>
                                <div class="col-md-2">
                                    <div class="form-check radio-div nature-req">
                                        <label class="form-check-label">
                                            <input type="radio" v-model="form.nature_case" name="criminal_radio" value="Criminal"
                                                class="form-check-input radio-old" :disabled="!toggleEdit">
                                            <span class="radio"></span>
                                            Criminal
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check radio-div nature-req">
                                        <label class="form-check-label">
                                            <input type="radio" v-model="form.nature_case" name="civil_radio" value="Civil"
                                                class="form-check-input check-old" :disabled="!toggleEdit">
                                            <span class="radio"></span>
                                            Civil
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 mr-5">
                                    <div class="form-check radio-div nature-req">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.nature_case" name="administrative_radio"
                                                value="Administrative Case Proper" class="form-check-input radio-old form__input" :disabled="!toggleEdit">
                                            <span class="radio"></span>
                                            Administrative Case Proper
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check radio-div nature-req">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.nature_case" name="prosecutor_radio"
                                                value="Prosecutor Office" class="form-check-input radio-old form__input" :disabled="!toggleEdit">
                                            <span class="radio"></span>
                                            Prosecutor Office
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check radio-div nature-req">
                                        <label class="form-check-label ">
                                            <input type="radio" v-model="form.nature_case" name="labor_radio" value="Labor"
                                                class="form-check-input radio-old" :disabled="!toggleEdit">
                                            <span class="radio"></span>
                                            Labor
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="col-md-6 pt-3">
                                <div class="form-group">
                                    <label for="">Specified {{ form.nature_case }}</label>
                                    <input type="text" v-model="form.nature_specify_case" name="criminal_input" class="form-control"
                                        :disabled="form.nature_case === '' || !toggleEdit" placeholder="Please Specify" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-12 mt-3">
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
                                        <label class="btn btn-outline-success" :class="{'active' : form.isRepresentative === 'false' }">
                                            <input type="radio" name="Defendant" value="false" v-model="form.isRepresentative"
                                                @click="clearRepresentative">
                                            Defendant
                                        </label>
                                        <label class="btn btn-outline-success" :class="{'active' : form.isRepresentative === 'true' }">
                                            <input type="radio" name="Representative" value="true" v-model="form.isRepresentative">
                                            Representative
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Name -->
                                <div class="form-group">
                                    <br>
                                    <label for="client_name">Name</label>
                                    <input type="text" v-model="form.client_name" name="client_name" class="form-control"
                                        placeholder="Firstname Middlename Lastname" :disabled="!toggleEdit">
                                </div>

                                <!-- Religion -->
                                <div class="form-group">
                                    <br>
                                    <label for="client_religion">Religion</label>
                                    <v-select :options="religionList" v-model="form.client_religion" placeholder="Select Religion" :disabled="!toggleEdit"></v-select>
                                    <!-- <input type="text" v-model="form.client_religion" name="client_religion" class="form-control"
                                    placeholder="Catholic, Iglesia ni Cristo, Muslim etc."> -->
                                </div>

                                <!-- Citizenship -->
                                <div class="form-group">
                                    <br>
                                    <label for="client_citizenship">Citizenship</label>
                                    <v-select :options="citizenshipList" v-model="form.client_citizenship" placeholder="Select Citizenship" :disabled="!toggleEdit"></v-select>
                                    <!-- <input type="text" v-model="form.client_citizenship" name="client_citizenship" class="form-control"
                                    placeholder="Filipino"> -->
                                </div>

                                <!-- Address -->
                                <div class="form-group">
                                    <br>
                                    <label for="client_address">Address</label>
                                    <input type="text" v-model="form.client_address" name="client_address" class="form-control"
                                        placeholder="House no. Steet, Barangay, City, Province" :disabled="!toggleEdit">
                                </div>

                                <!-- E-mail -->
                                <div class="form-group">
                                    <br>
                                    <label for="client_email">Email</label>
                                    <input type="email" v-model="form.client_email" name="client_email" class="form-control"
                                        placeholder="example@email.com" :disabled="!toggleEdit">
                                </div>

                                <!-- Age -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="client_age">Age</label>
                                            <input type="number" v-model="form.client_age" name="client_age" class="form-control"
                                                placeholder="18-100" :disabled="!toggleEdit">
                                        </div>
                                    </div>
                                    <!-- Gender -->
                                    <div class="col-md-4 mt">
                                        <div class="form-group">
                                            <label for="client_gender">Gender</label>
                                            <div v-if="!toggleEdit">
                                                <input type="text" v-model="form.client_gender" name="client_gender" class="form-control"
                                                placeholder="18-100" :disabled="!toggleEdit">
                                            </div>
                                            <div class="dropdown" v-if="toggleEdit">
                                                <button class="btn btn-outline-success dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <span v-show="form.client_gender === ''">Select Gender</span>
                                                    <span v-show="form.client_gender !== ''">{{ form.client_gender }}
                                                        <span v-if="form.client_gender === 'Male'">
                                                            <male-icon class="ml-1"></male-icon>
                                                        </span> <span v-if="form.client_gender === 'Female'">
                                                            <female-icon></female-icon>
                                                        </span> </span>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" value="Male" @click="form.client_gender = 'Male'">Male
                                                        <male-icon class="ml-1"></male-icon></a>
                                                    <a class="dropdown-item" value="Female" @click="form.client_gender = 'Female'">Female
                                                        <female-icon></female-icon></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Civil Status -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="client_civil_status">Civil Status</label>
                                            <div v-if="!toggleEdit">
                                                <input type="text" v-model="form.client_civil_status" name="client_civil_status" class="form-control"
                                                placeholder="18-100" :disabled="!toggleEdit">
                                            </div>
                                            <div class="dropdown" v-if="toggleEdit">
                                                <button class="btn btn-outline-success dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <span v-show="form.client_civil_status === ''">Select Civil Status</span>
                                                    <span v-show="form.client_civil_status !== ''">{{
                                                        form.client_civil_status
                                                        }} </span>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" value="Married" @click="form.client_civil_status = 'Married'">Married</a>
                                                    <a class="dropdown-item" value="Widowed" @click="form.client_civil_status = 'Widowed'; clearSpouseInfo()">Widowed</a>
                                                    <a class="dropdown-item" value="Separated" @click="form.client_civil_status = 'Separated'; clearSpouseInfo()">Separated</a>
                                                    <a class="dropdown-item" value="Divorced" @click="form.client_civil_status = 'Divorced'; clearSpouseInfo()">Divorced</a>
                                                    <a class="dropdown-item" value="Single" @click="form.client_civil_status = 'Single'; clearSpouseInfo()">Single</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Individual Monthly Net Income -->
                                <div class="form-group">
                                    <br>
                                    <label for="client_monthly_income">Individual Monthly Net Income</label>
                                    <input type="number" v-model="form.client_monthly_income" name="client_monthly_income"
                                        class="form-control" placeholder="100" :disabled="!toggleEdit">
                                </div>

                                 <!-- Contact No. -->
                                <div class="form-group"><br>
                                    <label for="client_contact">Contact No.</label>
                                    <input type="text" v-model="form.client_contact" name="client_contact" class="form-control"
                                        placeholder="09XX-XXX-XXXX" :disabled="!toggleEdit">
                                </div>


                            </div>

                            <div class="col-md-6">

                                <!-- Educational Attainment -->
                                <div class="form-group"><br>
                                    <label for="client_educational_attainment">Educational Attainment</label>
                                    <input type="text" v-model="form.client_educational_attainment" name="client_educational_attainment"
                                        class="form-control" placeholder="Highschool completion or higher" :disabled="!toggleEdit">
                                </div>

                                <!-- Language/Dialect -->
                                <div class="form-group"><br>
                                    <label for="client_dialect">Language/Dialect</label>
                                    <v-select multiple :options="languagesDialectsList" v-model="form.client_dialect"
                                        placeholder="Select Language/Dialect" :disabled="!toggleEdit"></v-select>
                                    <!-- <input type="text" v-model="form.client_dialect" name="client_dialect" class="form-control"
                                    placeholder="Tagalog / Kapampangan / English"> -->
                                </div>

                                <div v-show="form.client_civil_status === 'Married'">

                                    <!-- Spouse -->
                                    <div class="form-group"><br>
                                        <label for="client_spouse">Spouse</label>
                                        <input type="text" v-model="form.client_spouse" name="client_spouse" class="form-control"
                                            placeholder="Firstname Middlename Lastname" :disabled="!toggleEdit">
                                    </div>

                                    <!-- Address of Spouse -->
                                    <div class="form-group"><br>
                                        <label for="spouse_address">Address of Spouse</label>
                                        <input type="text" v-model="form.spouse_address" name="spouse_address" class="form-control"
                                            placeholder="House no. Street, Barangay, City, Province" :disabled="!toggleEdit">
                                    </div>

                                    <!-- Contact No. of Spouse -->
                                    <div class="form-group"><br>
                                        <label for="spouse_contact">Contact No. of Spouse</label>
                                        <input type="text" v-model="form.spouse_contact" name="spouse_contact" class="form-control"
                                            placeholder="09XX-(XXX)-XXXX" :disabled="!toggleEdit">
                                    </div>
                                </div>

                                <!-- Detained -->
                                <div class="form-group">
                                    <br>
                                    <label for="detained">Detained</label>
                                    <div class="row">
                                        <div class="col-md-2 ml-3">
                                            <div class="form-check radio-div">
                                                <label class="form-check-label">
                                                    <input type="radio" v-model="form.detained" name="detained" value="Yes"
                                                        class="form-check-input radio-old" :disabled="!toggleEdit">
                                                    <span class="radio" @click="form.detained_since = ''; form.detention_place = ''"></span>
                                                    Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check radio-div">
                                                <label class="form-check-label">
                                                    <input type="radio" v-model="form.detained" name="detained" value="No"
                                                        class="form-check-input radio-old" :disabled="!toggleEdit">
                                                    <span class="radio" @click="form.detained_since = ''; form.detention_place = ''"></span>
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detained Since -->
                                <div v-show="form.detained === 'Yes'"><br>
                                    <div class="form-group">
                                        <label for="detained_since">Detained Since</label>
                                        <datepicker class="form-calendar form__input" :disabled-dates="disabledFutureDates" :disabled="!toggleEdit"
                                            :format="'MMM. dd, yyyy'" v-model="form.detained_since" placeholder="Click Here to Choose a Date"
                                            @input="convertDate()"></datepicker>
                                    </div>
                                </div>

                                <!-- Place of Detention -->
                                <div v-show="form.detained === 'Yes'"><br>
                                    <div class="form-group">
                                        <label for="detention_place">Place of Detention</label>
                                        <input type="text" v-model="form.detention_place" name="detention_place" class="form-control"
                                            placeholder="Prison Place" :disabled="!toggleEdit">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="mt-3" v-show="form.isRepresentative === 'true'">
                        <div class="card card-border shadow">
                            <div class="row mr-4 ml-4">
                                <div class="col-md-12 text-center">
                                    <br>
                                    <h4 class="text-center">Interviewee's Personal Circumtances</h4>
                                </div>
                                <div class="pt-4 col-md-6">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="interviewee_name">Name</label>
                                        <input type="text" v-model="form.interviewee_name" name="interviewee_name"
                                            class="form-control" placeholder="Firstname Middlename Lastname" :disabled="!toggleEdit">
                                    </div>

                                    <!-- Address -->
                                    <div class="form-group">
                                        <label for="interviewee_address">Address</label>
                                        <input type="text" v-model="form.interviewee_address" name="interviewee_address"
                                            class="form-control" placeholder="House no. Street, Barangay, City, Province" :disabled="!toggleEdit">
                                    </div>

                                    <!-- Relationship to Client -->
                                    <div class="form-group">
                                        <label for="interviewee_relationship_to_client">Relationship to
                                            Client</label>
                                        <input type="text" v-model="form.interviewee_relationship_to_client" name="interviewee_relationship_to_client"
                                            class="form-control" placeholder="Son, Daugther, Father, Mother etc." :disabled="!toggleEdit">
                                    </div>


                                </div>
                                <div class="pt-4 col-md-6">
                                    <!-- Age -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="interviewee_age">Age</label>
                                                <input type="number" v-model="form.interviewee_age" name="interviewee_age"
                                                    class="form-control" placeholder="18-100" :disabled="!toggleEdit">
                                            </div>
                                        </div>
                                        <!-- Gender -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="interviewee_gender">Gender</label>
                                                <div v-if="!toggleEdit">
                                                <input type="text" v-model="form.interviewee_gender" name="interviewee_gender" class="form-control"
                                                placeholder="18-100" :disabled="!toggleEdit">
                                            </div>
                                                <div class="dropdown" v-if="toggleEdit">
                                                    <button class="btn btn-outline-success dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span v-show="form.interviewee_gender === ''">Select Gender</span>
                                                        <span v-show="form.interviewee_gender !== ''">{{
                                                            form.interviewee_gender }} <span v-if="form.interviewee_gender === 'Male'">
                                                                <male-icon class="ml-1"></male-icon>
                                                            </span> <span v-if="form.interviewee_gender === 'Female'">
                                                                <female-icon></female-icon>
                                                            </span> </span>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" value="Male" @click="form.interviewee_gender = 'Male'">Male
                                                            <male-icon class="ml-1"></male-icon></a>
                                                        <a class="dropdown-item" value="Female" @click="form.interviewee_gender = 'Female'">Female
                                                            <female-icon></female-icon></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Civil Status -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="interviewee_civil_status">Civil Status</label>
                                                <div v-if="!toggleEdit">
                                                <input type="text" v-model="form.interviewee_civil_status" name="interviewee_civil_status" class="form-control"
                                                placeholder="18-100" :disabled="!toggleEdit">
                                            </div>
                                                <div class="dropdown" v-if="toggleEdit">
                                                    <button class="btn btn-outline-success dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span v-show="form.interviewee_civil_status === ''">Select
                                                            Civil
                                                            Status</span>
                                                        <span v-show="form.interviewee_civil_status !== ''">{{
                                                            form.interviewee_civil_status }} </span>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" value="Married" @click="form.interviewee_civil_status = 'Married'">Married</a>
                                                        <a class="dropdown-item" value="Widowed" @click="form.interviewee_civil_status = 'Widowed'">Widowed</a>
                                                        <a class="dropdown-item" value="Separated" @click="form.interviewee_civil_status = 'Separated'">Separated</a>
                                                        <a class="dropdown-item" value="Divorced" @click="form.interviewee_civil_status = 'Divorced'">Divorced</a>
                                                        <a class="dropdown-item" value="Single" @click="form.interviewee_civil_status = 'Single'">Single</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contact Number -->
                                    <div class="form-group">
                                        <label for="interviewee_contact">Contact No.</label>
                                        <input type="number" v-model="form.interviewee_contact" name="interviewee_contact"
                                            class="form-control" placeholder="09XX-(XXX)-XXXX" :disabled="!toggleEdit">
                                    </div>

                                    <!-- E-mail -->
                                    <div class="form-group">
                                        <label for="interviewee_email">Email</label>
                                        <input type="text" v-model="form.interviewee_email" name="interviewee_email"
                                            class="form-control" placeholder="example@email.com" :disabled="!toggleEdit">
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card card-border shadow">
                        <div class="row  mr-4 ml-4">
                            <div class="col-md-12 text-center">
                                <br>
                                <h4 class="text-center">IIA. Client's Case Involvement</h4>
                            </div>
                            <div class="row mt-3 ml-5 text-left">
                                <div class="col-md-3">
                                    <div class="form-check radio-div">
                                        <label class="form-check-label">
                                            <input type="radio" v-model="form.involvement" name="plaintiff_radio" value="Plaintiff"
                                                class="form-check-input check-old form__input" :disabled="!toggleEdit">
                                            <span class="radio" @click="clearComplainant"></span>
                                            Plaintiff
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div">
                                        <label class="form-check-label">
                                            <input type="radio" v-model="form.involvement" name="petitioner_radio"
                                                value="Petitioner" class="form-check-input check-old form__input" :disabled="!toggleEdit">
                                            <span class="radio" @click="clearComplainant"></span>
                                            Petitioner
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div">
                                        <label class="form-check-label">
                                            <input type="radio" v-model="form.involvement" name="defendent_radio" value="Defendent"
                                                class="form-check-input check-old form__input" :disabled="!toggleEdit">
                                            <span class="radio" @click="clearComplainant"></span>
                                            Defendent
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div">
                                        <label class="form-check-label">
                                            <input type="radio" v-model="form.involvement" name="respondent_radio"
                                                value="Respondent" class="form-check-input check-old form__input" :disabled="!toggleEdit">
                                            <span class="radio" @click="clearComplainant"></span>
                                            Respondent
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div">
                                        <label class="form-check-label">
                                            <input type="radio" v-model="form.involvement" name="oppositor_radio" value="Oppositor"
                                                class="form-check-input check-old form__input" :disabled="!toggleEdit">
                                            <span class="radio" @click="clearComplainant"></span>
                                            Oppositor
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div">
                                        <label class="form-check-label">
                                            <input type="radio" v-model="form.involvement" name="accused_radio" value="Accused"
                                                class="form-check-input check-old form__input" :disabled="!toggleEdit">
                                            <span class="radio" @click="clearComplainant"></span>
                                            Accused
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div">
                                        <label class="form-check-label">
                                            <input type="radio" v-model="form.involvement" name="others_radio" value="Others"
                                                class="form-check-input check-old form__input" :disabled="!toggleEdit">
                                            <span class="radio" @click="clearComplainant"></span>
                                            Others
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check radio-div">
                                        <label class="form-check-label form__label">
                                            <input type="radio" v-model="form.involvement" name="complainant_radio"
                                                value="Complainant/Victim" class="form-check-input check-old form__input" :disabled="!toggleEdit">
                                            <span class="radio" @click="form.complainantRequired = true;"></span>
                                            Complainant/Victim
                                        </label>
                                    </div>
                                </div>
                                <div class="row pt-2" v-show="form.involvement === 'Complainant/Victim'">
                                    <div class="col-md-12 pt-3">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                Compliant/Victim of:
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div">
                                            <label class="form-check-label">
                                                <input type="checkbox" v-model="form.complaint" name="vawc_checkbox"
                                                    value="R.A 9262 (VAWC)" class="form-check-input check-old" :disabled="!toggleEdit">
                                                <span class="checkmark"></span>
                                                R.A 9262 (VAWC)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div">
                                            <label class="form-check-label">
                                                <input type="checkbox" v-model="form.complaint" name="atl_checkbox"
                                                    value="R.A 9745 (Anti-Torture Law)" class="form-check-input check-old" :disabled="!toggleEdit">
                                                <span class="checkmark"></span>
                                                R.A 9745 (Anti-Torture Law)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div">
                                            <label class="form-check-label">
                                                <input type="checkbox" v-model="form.complaint" name="agrarian_checkbox"
                                                    value="Agrarian Case" class="form-check-input check-old" :disabled="!toggleEdit">
                                                <span class="checkmark"></span>
                                                Agrarian Case
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div">
                                            <label class="form-check-label">
                                                <input type="checkbox" v-model="form.complaint" name="hsa_checkbox"
                                                    value="R.A 9372 (Human Security Act)" class="form-check-input check-old" :disabled="!toggleEdit">
                                                <span class="checkmark"></span>
                                                R.A 9372 (Human Security Act)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div">
                                            <label class="form-check-label">
                                                <input type="checkbox" v-model="form.complaint" name="cicl_checkbox"
                                                    value="R.A 9344 (CICL)" class="form-check-input check-old" :disabled="!toggleEdit">
                                                <span class="checkmark"></span>
                                                R.A 9344 (CICL)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check checkbox-div">
                                            <label class="form-check-label">
                                                <input type="checkbox" v-model="form.complaint" name="other_compliant_checkbox"
                                                    value="Other Compliant/Victim" class="form-check-input check-old" :disabled="!toggleEdit">
                                                <span class="checkmark"></span>
                                                Others
                                            </label>
                                        </div>
                                    </div>
                                </div>
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
                                    <div class="form-check checkbox-div">
                                        <label class="form-check-label">
                                            <input type="checkbox" v-model="form.class" name="client_classification"
                                                value="Children in Conflict with the Law" class="check-old form-check-input" :disabled="!toggleEdit">
                                            <span class="checkmark" @click="validateClassification('children_in_conflict')"></span>
                                            Children in Conflict with the Law
                                            <br>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <input type="number" v-model="form.children_in_conflict" name="children_in_conflict"
                                                        class="form-control" min="18" max="100" placeholder="Age"
                                                        :disabled="!form.children_in_conflict_checkbox || !toggleEdit">
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="form-check checkbox-div">
                                        <label class="form-check-label">
                                            <input type="checkbox" v-model="form.class" name="client_classification"
                                                value="Woment Client" class="check-old form-check-input" :disabled="!toggleEdit">
                                            <span class="checkmark" @click="validateClassification('women_client')"></span>
                                            Woment Client
                                        </label>
                                    </div>
                                    <div class="form-check checkbox-div">
                                        <label class="form-check-label">
                                            <input type="checkbox" v-model="form.class" name="client_classification"
                                                value="Indigenous Group" class="check-old form-check-input" :disabled="!toggleEdit">
                                            <span class="checkmark" @click="validateClassification('indigenous_group')"></span>
                                            Indigenous Group
                                            <br>
                                            <div class="form-group">
                                                <input type="text" v-model="form.indigenous_group" name="indigenous_group"
                                                    class="form-control" placeholder="Please Specify" :disabled="!form.indigenous_group_checkbox || !toggleEdit">
                                            </div>
                                            <br>
                                        </label>
                                    </div>

                                    <div class="form-check checkbox-div">
                                        <label class="form-check-label">
                                            <input type="checkbox" v-model="form.class" name="client_classification"
                                                value="Person with Disability (PWD)" class="check-old form-check-input" :disabled="!toggleEdit">
                                            <span class="checkmark" @click="validateClassification('person_with_disability')"></span>
                                            Person with Disability (PWD)
                                            <br>
                                            <div class="form-group">
                                                <input type="text" v-model="form.person_with_disability" name="person_with_disability"
                                                    class="form-control" placeholder="Please Specify" :disabled="!form.person_with_disability_checkbox || !toggleEdit">
                                            </div>
                                            <br>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check checkbox-div" v-show="!form.rural_poor">
                                        <label class="form-check-label">
                                            <input type="checkbox" v-model="form.class" name="client_classification"
                                                value="Urban Poor" class="form-check-input check-old" :disabled="!toggleEdit">
                                            <span class="checkmark" @click="validateClassification('urban_poor')"></span>
                                            Urban Poor
                                            <br>
                                            <div class="form-group">
                                                <input type="text" v-model="form.urban_poor" name="urban_poor" class="form-control"
                                                    placeholder="Please Specify" :disabled="!form.urban_poor_checkbox  || !toggleEdit">
                                            </div>
                                            <br>
                                        </label>
                                    </div>

                                    <div class="form-check checkbox-div" v-show="!form.urban_poor">
                                        <label class="form-check-label">
                                            <input type="checkbox" v-model="form.class" name="client_classification"
                                                value="Rural Poor" class="form-check-input check-old" :disabled="!toggleEdit">
                                            <span class="checkmark" @click="validateClassification('rural_poor')"></span>
                                            Rural Poor
                                            <br>
                                            <div class="form-group">
                                                <input type="text" v-model="form.rural_poor" name="rural_poor" class="form-control"
                                                    placeholder="Please Specify" :disabled="!form.rural_poor_checkbox  || !toggleEdit">
                                            </div>
                                        </label>
                                    </div>

                                    <br>
                                    <div class="form-check checkbox-div">
                                        <label class="form-check-label">
                                            <input type="checkbox" v-model="form.class" name="client_classification"
                                                value="Refugees/Evacuees" class="check-old form-check-input" :disabled="!toggleEdit">
                                            <span class="checkmark" @click="validateClassification('refugees')"></span>
                                            Refugees/Evacuees
                                        </label>
                                    </div>
                                    <div class="form-check checkbox-div">
                                        <label class="form-check-label">
                                            <input type="checkbox" v-model="form.class" name="client_classification"
                                                value="Senior Citizen" class="check-old form-check-input" :disabled="!toggleEdit">
                                            <span class="checkmark" @click="validateClassification('senior_citizen')"></span>
                                            Senior Citizen
                                        </label>
                                    </div>
                                    <br>
                                    <div class="form-check checkbox-div">
                                        <label class="form-check-label">
                                            <input type="checkbox" v-model="form.class" name="client_classification"
                                                value="OFW" class="check-old form-check-input" :disabled="!toggleEdit">
                                            <span class="checkmark" @click="validateClassification('ofw')"></span>
                                            OFW
                                        </label>
                                    </div>
                                    <div v-show="!form.ofw_checkbox">
                                        <div class="ml-5 form-check radio-div checkbox-div">
                                            <label class="form-check-label">
                                                <input type="radio" v-model="form.ofw" name="specified_client_classification"
                                                    value="Land-based" class="form-check-input radio-old" :disabled="!toggleEdit">
                                                <span class="radio"></span>
                                                Land-based
                                            </label>
                                        </div>
                                        <div class="ml-5 form-check radio-div checkbox-div">
                                            <label class="form-check-label">
                                                <input type="radio" v-model="form.ofw" name="specified_client_classification"
                                                    value="Sea-based" class="form-check-input radio-old" :disabled="!toggleEdit">
                                                <span class="radio"></span>
                                                Sea-based
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="card card-border shadow">
                        <div class="row mr-4 ml-3">
                            <div class="col-md-12 text-center">
                                <br>
                                <h4 class="text-center">III. Adverse Party</h4>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-check radio-div">
                                    <label class="form-check-label">
                                        <input type="radio" v-model="form.adverse_party" name="adverse_party" value="Plainfill/Petitioner/Complainant"
                                            class="form-check-input check-old" :disabled="!toggleEdit">
                                        <span class="radio"></span>
                                        Plainfill/Petitioner/Complainant
                                    </label>
                                </div>
                                <div class="form-check radio-div">
                                    <label class="form-check-label">
                                        <input type="radio" v-model="form.adverse_party" name="adverse_party" value="Defendant/Respondent/Accused"
                                            class="form-check-input check-old" :disabled="!toggleEdit">
                                        <span class="radio"></span>
                                        Defendant/Respondent/Accused
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-check radio-div">
                                    <label class="form-check-label">
                                        <input type="radio" v-model="form.adverse_party" name="adverse_party" value="Oppositor/Others"
                                            class="form-check-input check-old" :disabled="!toggleEdit">
                                        <span class="radio"></span>
                                        Oppositor/Others
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="hidden" v-model="form.adverse_party">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <br>
                                    <label for="adverse_party_name">Name</label>
                                    <input type="text" v-model="form.adverse_party_name" name="adverse_party_name"
                                        class="form-control" placeholder="Firstname Middlename Lastname" :disabled="!toggleEdit">
                                </div>

                                <div class="form-group">
                                    <br>
                                    <label for="adverse_party_address">Address</label>
                                    <input type="text" v-model="form.adverse_party_address" name="adverse_party_address"
                                        class="form-control" placeholder="House no. Steet, Barangay, City, Province" :disabled="!toggleEdit">
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                   <div class="card card-border shadow">
                        <div class="row">
                            <div class="col-md-12 text-center pl-3 pr-3">
                                <br>
                                <h4 class="text-center ml-3">V. Cause of Action/Nature of Offense</h4>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <textarea v-model="form.case_of_action" name="action_cause" class="form-control" rows="9" :disabled="!toggleEdit"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card card-border shadow pb-5">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <br>
                                <h4 class="text-center">Proof of Indigency Submitted</h4>
                            </div>
                            <div class="col-md-3 pt-4 text-center">
                                <div class="form-check checkbox-div ml-5">
                                    <label class="form-check-label">
                                        <input type="checkbox" v-model="form.proof_of_indigency" name="submitted_proof_indigency"
                                            value="Income Tax Return" class="form-check-input check-old" :disabled="!toggleEdit">
                                        <span class="checkmark-s"></span>
                                        Income Tax Return
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 pt-4 text-center">
                                <div class="form-check checkbox-div">
                                    <label class="form-check-label">
                                        <input type="checkbox" v-model="form.proof_of_indigency" name="submitted_proof_indigency"
                                            value="Certification from Barangay" class="form-check-input check-old" :disabled="!toggleEdit">
                                        <span class="checkmark-s"></span>
                                        Certification from Barangay
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 pt-4 text-center">
                                <div class="form-check checkbox-div ml-4">
                                    <label class="form-check-label mr-2">
                                        <input type="checkbox" v-model="form.proof_of_indigency" name="submitted_proof_indigency"
                                            value="Certification (DSWD)" class="form-check-input check-old" :disabled="!toggleEdit">
                                        <span class="checkmark-s"></span>
                                        Certification (DSWD)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 pt-4 text-center">
                                <div class="form-check checkbox-div mr-5">
                                    <label class="form-check-label">
                                        <input type="checkbox" v-model="form.proof_of_indigency" name="submitted_proof_indigency"
                                            value="Others" class="form-check-input check-old" :disabled="!toggleEdit">
                                        <span class="checkmark-s"></span>
                                        Others (payslip, etc.)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="$gate.isStaffAndSuperAdmin()" v-if="form.status === 'On-Going'" class="col-md-12 p-3">
                    <div class="text-right">
                        <router-link to="/clients"><button type="submit" class="btn btn-success"><i class="material-icons">cancel</i>
                                Cancel</button></router-link>
                        <button type="submit" class="btn btn-success"><i class="material-icons">save</i> Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>


<script>
    import {
        required,
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
                toggleEdit: false,
                authUser: {},
                loading: true,
                notFound: false,
                disabledFutureDates: {
                    from: new Date()
                },
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
                data: {},
                showInput: false,
                attorneys: {},
                date: new Date(),
                form: new Form({
                    status: '',
                    control_num: '',
                    assigned_from: '',
                    complainantRequired: false,
                    isRepresentative: 'false',
                    children_in_conflict_checkbox: false,
                    women_client_checkbox: false,
                    indigenous_group_checkbox: false,
                    person_with_disability_checkbox: false,
                    urban_poor_checkbox: false,
                    refugees_checkbox: false,
                    senior_citizen_checkbox: false,
                    ofw_checkbox: false,
                    interviewer: '',
                    assigned_to: '',
                    referred_by: '',
                    refer_to: '',
                    nature_request: '',
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
                    client_dialect: '',
                    client_contact: '',
                    client_spouse: '',
                    spouse_address: ' ',
                    spouse_contact: '',
                    detention_place: '',
                    isRepresentative: false,
                    interviewee_name: '',
                    interviewee_address: '',
                    interviewee_relationship_to_client: '',
                    interviewee_age: '',
                    interviewee_gender: '',
                    interviewee_civil_status: '',
                    interviewee_contact: '',
                    interviewee_email: '',
                    nature_case: '',
                    nature_specify_case: '',
                    involvement: '',
                    complaint: [],
                    class: [],
                    children_in_conflict: '',
                    indigenous_group: '',
                    person_with_disability: '',
                    urban_poor: '',
                    rural_poor: '',
                    ofw: '',
                    adverse_party: '',
                    adverse_party_name: '',
                    adverse_party_address: '',
                    fact_of_the_case: '',
                    case_of_action: '',
                    pending_in_court: '',
                    title_of_case: '',
                    court_body_tribunal: '',
                    other_case_of_action: '',
                    other_court_body_tribunal: '',
                    proof_of_indigency: []
                })
            }
        },
        methods: {
        convertDate() {
            this.form.detained_since = window.moment(this.form.detained_since).format('YYYY-MM-DD')
        },
        loadUsers() {
            axios.get('api/user').then(({
                data
            }) => (this.attorneys = data))
        },
        loadAuthUser() {
                axios.get('api/profile').then(({
                    data
                }) => {
                    this.authUser = data
                })
        },
        loadClientForm() {
                axios.get('api/clients/' + this.$route.params.id).then(({
                data
            }) => {
                let authName = this.authUser.firstname + ' ' + this.authUser.lastname
                let assignedName = data[0][0].assigned_to
                if((authName === assignedName && !this.$gate.isSuperAdmin()) || (this.$gate.isStaffAndSuperAdmin())) {
                this.form.fill(data[0][0])
                this.form.class = data[0][0].class.split(',')
                this.form.proof_of_indigency = data[0][0].proof_of_indigency.split(',')
                this.form.complaint = data[0][0].complaint.split(',')
                this.form.client_dialect = data[0][0].client_dialect.split(',')
                this.form.assigned_from = this.form.assigned_to
                this.form.control_num = this.$route.params.id

                if (data[0][0].interviewee_name !== null) {
                    this.form.isRepresentative = 'true'
                } else {
                    this.form.isRepresentative = 'false'
                }
                if (data[0][0].children_in_conflict !== null) {
                    this.form.children_in_conflict_checkbox = true
                } else {
                    this.form.children_in_conflict_checkbox = false
                }
                if (data[0][0].indigenous_group !== null) {
                    this.form.indigenous_group_checkbox = true
                } else {
                    this.form.indigenous_group_checkbox = false
                }
                if (data[0][0].person_with_disability !== null) {
                    this.form.person_with_disability_checkbox = true
                } else {
                    this.form.person_with_disability_checkbox = false
                }
                if (data[0][0].urban_poor !== null) {
                    this.form.urban_poor_checkbox = true
                } else {
                    this.form.urban_poor_checkbox = false
                }
                if (data[0][0].rural_poor !== null) {
                    this.form.rural_poor_checkbox = true
                } else {
                    this.form.rural_poor_checkbox = false
                }
                } else {
                    return false
                }
            })
        },
        updateForm() {
            if (this.$gate.isStaffAndSuperAdmin()) {
                this.$Progress.start();
                this.form.put('api/clients/' + this.$route.params.id).then(() => {
                    $('#Modal').modal('hide')
                    swal(
                        'Updated!',
                        this.$route.params.id + ' Interview Form has been updated.',
                        'success'
                    )
                    this.$Progress.finish()
                    this.loadClientForm()
                }).catch(() => {
                    this.$Progress.fail()
                });
            }
        },
        clearNatureCase() {
            this.form.nature_case = ''
            this.form.nature_specify_case = ''
        },
        clearRepresentative() {
            this.form.interviewee_name = ''
            this.form.interviewee_address = ''
            this.form.interviewee_relationship_to_client = ''
            this.form.interviewee_age = ''
            this.form.interviewee_gender = ''
            this.form.interviewee_civil_status = ''
            this.form.interviewee_contact = ''
            this.form.interviewee_email = ''
        },
        clearSpouseInfo() {
            this.form.client_spouse = '',
                this.form.spouse_address = '',
                this.form.spouse_contact = ''
        },
        clearComplainant() {
            this.form.complaint = [];
        },
        validateClassification(classification) {
            if (classification === 'children_in_conflict') {
                this.form.children_in_conflict = ''
                this.form.children_in_conflict_checkbox = !this.form.children_in_conflict_checkbox
                if (!this.form.children_in_conflict_checkbox) {
                    this.form.children_in_conflict = ''
                }
            }
            if (classification === 'women_client') {
                this.form.women_client_checkbox = !this.form.women_client_checkbox
                if (!this.form.women_client_checkbox) {
                    this.form.women_client = ''
                } else {
                    this.form.women_client = 'Women Client'
                }
            }
            if (classification === 'indigenous_group') {
                this.form.indigenous_group = ''
                this.form.indigenous_group_checkbox = !this.form.indigenous_group_checkbox
                if (!this.form.indigenous_group_checkbox) {
                    this.form.indigenous_group = ''
                }
            }
            if (classification === 'person_with_disability') {
                this.form.person_with_disability = ''
                this.form.person_with_disability_checkbox = !this.form.person_with_disability_checkbox
                if (!this.form.person_with_disability_checkbox) {
                    this.form.person_with_disability = ''
                }
            }
            if (classification === 'urban_poor') {
                this.form.urban_poor = ''
                this.form.urban_poor_checkbox = !this.form.urban_poor_checkbox
                if (!this.form.urban_poor_checkbox) {
                    this.form.urban_poor = ''
                }
            }
            if (classification === 'rural_poor') {
                this.form.rural_poor = ''
                this.form.rural_poor_checkbox = !this.form.rural_poor_checkbox
                if (!this.form.rural_poor_checkbox) {
                    this.form.rural_poor = ''
                }
            }
            if (classification === 'refugees') {
                this.form.refugees_checkbox = !this.form.refugees_checkbox
                if (!this.form.refugees_checkbox) {
                    this.form.refugees = ''
                } else {
                    this.form.refugees = 'Refugees/Evacuees'
                }
            }
            if (classification === 'senior_citizen') {
                this.form.senior_citizen_checkbox = !this.form.senior_citizen_checkbox
                if (!this.form.senior_citizen_checkbox) {
                    this.form.senior_citizen = ''
                } else {
                    this.form.senior_citizen = 'Senior Citizen'
                }
            }
            if (classification === 'ofw') {
                this.form.ofw_checkbox = !this.form.ofw_checkbox
                if (!this.form.ofw_checkbox) {
                    this.form.ofw = ''
                }
            }
        },
        clearCaseInfo() {
            this.form.title_of_case = ''
            this.form.court_body_tribunal = ''
            this.form.other_case_of_action = ''
            this.form.other_court_body_tribunal = ''
        }
    },
    mounted() {
        this.loadAuthUser()
        this.loadClientForm()
        this.loadUsers()
        setTimeout(() => {
            window.jQuery('.loader').fadeOut()
            if(this.form.control_num.length === 0) {
                    this.notFound = true
                }
            this.form.loading = false
        }, 2000);
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
