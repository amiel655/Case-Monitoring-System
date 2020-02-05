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
        <div v-if="$gate.isAdminAndSuperAdmin() && !isPreparedAlready && form.client_name !== ''">
            <case-already-exist-icon></case-already-exist-icon>
        </div>
        <form v-if="$gate.isAdminAndSuperAdmin() && form.client_name !== '' && isPreparedAlready" @submit.prevent="prepareCase"
            class="pt-4">
            <div class="row card-border shadow" style="background: #fff;">
                <div class="col-md-12">
                    <div class="card-title text-center shadow client-header-card">
                        Prepare Case
                    </div>

                </div>
                <div class="col-md-4 text-center"><br><br>
                    <h5>Control No. {{ $route.params.id }}</h5>

                </div>
                <div class="col-md-4 text-center"><br><br>
                    <h5>Name: {{ form.client_name }}</h5>

                </div>
                <div class="col-md-4 text-center"><br><br>
                    <h5>Age: {{ form.client_age }}</h5>
                </div>
                <div class="col-md-12"><br>
                    <h3>Case Information</h3>
                    <hr>
                </div>
                <div class="col-md-6">
                    <div class="form-inline form-group" :class="{ 'form-group--error': $v.cases.case_no.$error }">
                        <label class="form__label">Case No.</label>
                        <input type="text" v-model="cases.case_no" v-model.trim="$v.cases.case_no.$model" class="ml-2 form-control date form__input"
                            name="case_number">
                    </div>
                    <div class="error" v-if="!$v.cases.case_no.required">Case No.
                        is required.</div>
                    <div class="form-group" :class="{ 'form-group--error': $v.cases.case_title.$error }">
                        <label for="case_title" class="form__label">Case Title</label>
                        <input type="text" v-model="cases.case_title" v-model.trim="$v.cases.case_title.$model" name="case_title"
                            class="form-control form__input" :placeholder="'Example PEOPLE vs. ' + form.client_name.toUpperCase()">
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
                    <div class="form-group">
                        <label v-show="cases.crimes.length === 1" for="case_crime" style="width: 100%">Crime <button
                                type="button" class="btn btn-sm btn-success float-right" @click="addCrime()"><i class="material-icons"
                                    style="font-size: 16px !important;">add</i> Add Crime</button></label>
                        <label v-show="cases.crimes.length > 1" for="case_crime" style="width: 100%">Crimes <button
                                type="button" class="btn btn-sm btn-success float-right" @click="addCrime()"><i class="material-icons"
                                    style="font-size: 16px !important;">add</i> Add Crime</button></label>
                        <input type="text" v-model="cases.crimes[0].crime_title" name="case_crime" class="form-control form__input"
                            placeholder="Example Sec. 5 (0.108g) - CC# 26333, Frustated Homicide"><br>
                        <div v-for="(data, index) in cases.crimes" :key="data.id">
                            <div v-show="index != 0" class="input-group mb-3">
                                <input type="text" v-model="cases.crimes[index].crime_title" class="form-control"
                                    placeholder="Example Sec. 5 (0.108g) - CC# 26333, Frustated Homicide" aria-label="Example Sec. 5 (0.108g) - CC# 26333, Frustated Homicide"
                                    aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger" type="button" @click="removeCrime(index)">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'form-group--error': $v.cases.detained.$error }">
                        <label for="detained" class="form__label">Detained</label>
                        <input type="text" v-model="cases.detained" v-model.trim="$v.cases.detained.$model" name="detained"
                            class="form-control form__input" placeholder="Example PPj since, On Bail">
                    </div>
                    <div class="error" v-if="!$v.cases.detained.required">Detained
                        is required.</div>
                    <div class="form-group">
                        <label v-show="cases.complainants.length === 1" for="complainant_name" style="width: 100%">Complainant
                            <button type="button" class="btn btn-sm btn-success float-right" @click="addComplainant()"><i
                                    class="material-icons" style="font-size: 16px !important;">add</i> Add Complainant</button></label>
                        <label v-show="cases.complainants.length > 1" for="complainant_name" style="width: 100%">Complainants
                            <button type="button" class="btn btn-sm btn-success float-right" @click="addComplainant()"><i
                                    class="material-icons" style="font-size: 16px !important;">add</i> Add Complainant</button></label>
                        <input type="text" v-model="cases.complainants[0].complainant_name" name="complainant_name"
                            class="form-control form__input" placeholder=""><br>
                        <div v-for="(data, index) in cases.complainants" :key="data.id">
                            <div v-show="index != 0" class="input-group mb-3">
                                <input type="text" v-model="cases.complainants[index].complainant_name" class="form-control"
                                    placeholder="" aria-label="" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger" type="button" @click="removeComplainant(index)">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label v-show="cases.respondents.length === 1" for="respondent_name" style="width: 100%">Respondent
                            <button type="button" class="btn btn-sm btn-success float-right" @click="addRespondent()"><i
                                    class="material-icons" style="font-size: 16px !important;">add</i> Add Respondent</button></label>
                        <label v-show="cases.respondents.length > 1" for="respondent_name" style="width: 100%">Respondents
                            <button type="button" class="btn btn-sm btn-success float-right" @click="addRespondent()"><i
                                    class="material-icons" style="font-size: 16px !important;">add</i> Add Respondent</button></label>
                        <input type="text" v-model="cases.respondents[0].respondent_name" name="respondent_name" class="form-control form__input"
                            placeholder="Example LCR of CSFP, OSG, PSA"><br>
                        <div v-for="(data, index) in cases.respondents" :key="data.id">
                            <div v-show="index != 0" class="input-group mb-3">
                                <input type="text" v-model="cases.respondents[index].respondent_name" class="form-control"
                                    placeholder="Example LCR of CSFP, OSG, PSA" aria-label="" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger" type="button" @click="removeRespondent(index)">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="text-right p-3">
                    <button type="submit" class="btn btn-primary"><i class="material-icons">check_circle</i> Prepare Case</button>
                </div><br>
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
    import RotateLoader from "vue-spinner/src/RotateLoader.vue";
    export default {
        components: {
            RotateLoader
        },
        data() {
            return {
                authUser: {},
                loading: true,
                notFound: false,
                control: [],
                isPreparedAlready: false,
                cases: new Form({
                    control_num: this.$route.params.id,
                    name: '',
                    age: '',
                    case_no: '',
                    case_title: '',
                    crimes: [{
                        crime_title: ''
                    }],
                    complainants: [{
                        complainant_name: ''
                    }],
                    respondents: [{
                        respondent_name: ''
                    }],
                    detained: '',
                    court: '',
                }),
                form: new Form({
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
        validations: {
            cases: {
                case_no: {
                    required
                },
                case_title: {
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
            loadAuthUser() {
                axios.get('api/profile').then(({
                    data
                }) => {
                    this.authUser = data
                })
            },
            loadClientForm() {
                if (this.$gate.isAdminAndSuperAdmin()) {
                    axios.get('api/clients/' + this.$route.params.id).then(({
                        data
                    }) => {
                        let authName = this.authUser.firstname + ' ' + this.authUser.lastname
                        let assignedName = data[0][0].assigned_to

                        if((authName === assignedName && !this.$gate.isSuperAdmin()) || (this.$gate.isStaffAndSuperAdmin())) {
                        this.control = data[1]
                        this.form.fill(data[0][0])
                        this.form.class = data[0][0].class.split(',')
                        this.form.proof_of_indigency = data[0][0].proof_of_indigency.split(',')
                        this.form.complaint = data[0][0].complaint.split(',')
                        this.cases.name = data[0][0].client_name
                        this.cases.age = data[0][0].client_age

                        if (this.control.length === 0) {
                            return false
                        } else {
                            for (let i = 0; i < this.control.length; i++) {
                                if (this.control[i].control_num === this.cases.control_num) {
                                    return this.isPreparedAlready = true
                                }
                            }
                        }

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
                }
            },
            prepareCase() {
                this.$v.cases.$touch()
                if (this.$v.cases.$invalid) {
                    this.$Progress.fail()
                } else {
                    if (this.$gate.isAdminAndSuperAdmin()) {
                        this.$Progress.start()
                        this.cases.post('api/prepare-case').then(() => {
                            toast({
                                type: 'success',
                                title: 'Case Prepared Successfully!'
                            })
                            this.$Progress.finish()
                            setTimeout(() => {
                                window.location.href = '/cases'
                            }, 2000);
                        }).catch(() => {
                            this.$Progress.fail()
                        })
                    }
                }
            },
            addCrime() {
                this.cases.crimes.push({
                    crime_title: ''
                })
            },
            removeCrime(index) {
                this.cases.crimes.splice(index, 1);
            },
            addComplainant() {
                this.cases.complainants.push({
                    complainant_name: ''
                })
            },
            removeComplainant(index) {
                this.cases.complainants.splice(index, 1);
            },
            addRespondent() {
                this.cases.respondents.push({
                    respondent_name: ''
                })
            },
            removeRespondent(index) {
                this.cases.respondents.splice(index, 1);
            }
        },
        mounted() {
            this.loadAuthUser()
            this.loadClientForm()
            setTimeout(() => {
            window.jQuery('.loader').fadeOut()
            if(this.form.client_name.length === 0) {
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
        }
    }

</script>
