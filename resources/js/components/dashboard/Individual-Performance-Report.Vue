<style>
@media print {
    @page {
        margin: 0;
    }
}
</style>
<template>
    <div class="pt-3 container-fluid">
        <div class="loader" v-show="loading">
            <rotate-loader :loading="loading" :color="'#34cc7d'" :size="'20px'"></rotate-loader>
        </div>
        <!-- <div v-if="!$gate.isAdminAndSuperAdmin()">
            <not-found></not-found>
        </div> -->
        <div >
            <div class="row card card-border-shadow p-3">
                <div class="text-center showInPrint">
                    <p>
                        Republica ng Pilipinas<br>
                        KAGAWARAN NG KATARUNGAN<br>
                        TANGGAPAN NG MANANANGGOL PAMBAYA<br>
                        <strong>
                            PUBLIC ATTORNEY'S OFFICE <br>
                            Regional Office No. III
                        </strong><br>
                        District Office: <strong>SAN FERNANDO, PAMPANGA</strong>
                    </p>
                    <p><strong>
                        INDIVIDUAL PERFORMANCE REPORT <br>
                        (For the Month of {{selectedMonth | month}} {{presentYear}})
                    </strong></p>
                </div>
                <div class="sticky hideInPrint" id="sticky">
                    <h3><i class="material-icons">
                            assignment
                        </i> Individual Performance Report (IPR) </h3>
                    <div class="col-md-12 pt-2 pb-3">
                        <button type="button" class="btn btn-success edit-b" v-show="isEditable && selectedMonth.length !== 0" @click="cancel"><strong>Cancel</strong></button>
                        <button type="submit" class="btn btn-success edit-b" v-show="isEditable && selectedMonth.length !== 0" @click="submitReport"><strong>Update
                                Report<i class="material-icons md-18">update</i></strong></button>
                        <button type="button" class="btn btn-success edit-b" v-show="!isEditable && selectedMonth.length !== 0" @click="isEditable = true"><strong>Edit
                                Report<i class="material-icons md-18">edit</i></strong></button>
                        <button type="button" class="btn btn-success edit-b" v-show="!isEditable && selectedMonth.length !== 0" @click="exportPrint"><strong>Save
                                / Print Report<i class="material-icons md-18">print</i></strong></button>
                    </div>
                    <div class="col-md-12 form-inline">
                        <div class="form-group pt-3" v-if="$gate.isStaffAndSuperAdmin()">
                            <label for="attorney" class="form__label"> Attorney</label>
                            <div class="dropdown pl-2">
                                <button class="btn btn-outline-success dropdown-toggle form__input" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span v-show="lawyer === ''">Select Attorney</span>
                                    <span v-show="lawyer !== ''">{{ lawyer }}
                                    </span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" v-for="atty in attorneys" v-if="atty.type !== 'Staff' && atty.status !== 'Unavailable'"
                                        :key="atty.id" :value="atty.firstname + ' ' + atty.lastname" @click="lawyer = atty.firstname + ' ' + atty.lastname;">{{
                                        atty.firstname }} {{
                                        atty.lastname }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div v-show="lawyer !== ''" class="form-group pt-3 pl-2">
                            <label for="month" class="form__label"> Month</label>
                            <div class="pl-2">
                                <vue-monthly-picker :placeHolder="'Select Month'" dateFormat="MMMM" v-model="selectedMonth" :inline="true" :monthLabels="monthLabels" @input="loadReports(lawyer)"></vue-monthly-picker>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 form-inline pt-3">
                        <div class="form-group">
                            <label for="sortBy" class="form__label">Sort By</label>
                            <div class="pl-2 dropdown">
                                <button class="btn btn-success dropdown-toggle form__input" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ sortBy }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" @click="sortBy = 'All'">All</a>
                                    <a class="dropdown-item" @click="sortBy = 'Regular Services'">Regular Services</a>
                                    <a class="dropdown-item" @click="sortBy = 'Limited Services'">Limited Services</a>
                                    <a class="dropdown-item" @click="sortBy = 'Special Legal Services'">Special Legal
                                        Services</a>
                                    <a class="dropdown-item" @click="sortBy = 'Mediation and Conflict'">Mediation and
                                        Conflict</a>
                                    <a class="dropdown-item" @click="sortBy = 'Investigation'">Investigation</a>
                                    <a class="dropdown-item" @click="sortBy = 'Instant/Outreach Services'">Instant/Outreach
                                        Services</a>
                                    <a class="dropdown-item" @click="sortBy = 'Inquest Activities'">Inquest Activities</a>
                                    <a class="dropdown-item" @click="sortBy = 'Jail Visitation/Releases'">Jail
                                        Visitation/Releases</a>
                                    <a class="dropdown-item" @click="sortBy = 'Barangay Legal Outreach and Visitation'">Barangay
                                        Legal Outreach and Visitation</a>
                                    <a class="dropdown-item" @click="sortBy = 'Legal Aid Information/Dissemination'">Legal
                                        Aid Information/Dissemination</a>
                                    <a class="dropdown-item" @click="sortBy = 'Totals'">Totals</a>
                                </div>
                            </div>
                        </div>
                    </div><br>
                </div>
                <div>
                    <form @submit.prevent="updateReport" class="formTable">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Key Results Area</th>
                                    <th scope="col">Key Indicators of Performance</th>
                                    <th scope="col" class="text-center">Total</th>
                                    <th scope="col" class="text-center">CR</th>
                                    <th scope="col" class="text-center">CV</th>
                                    <th scope="col" class="text-center">ADM1</th>
                                    <th scope="col" class="text-center">ADM2</th>
                                    <th scope="col" class="text-center">ADM3</th>
                                </tr>
                            </thead>
                            <tbody v-for="data in reportData" :key="data.id" v-if="data.section == sortSection(data.section)">
                                <tr>
                                    <th scope="row">{{data.area}}</th>
                                    <td>
                                        <h4 v-show="data.title !== ''">{{ data.title }}<br></h4>
                                        <strong v-show="data.childClass === '' && data.isStrong">{{
                                            data.key_indicators_of_performance }}</strong>
                                        <span v-show="data.childClass !== '' && !data.isStrong" :class="data.childClass">{{
                                            data.key_indicators_of_performance }}</span>
                                        <span v-show="data.childClass === '' && !data.isStrong" :class="data.childClass">{{
                                            data.key_indicators_of_performance }}</span>
                                        <strong v-show="data.childClass !== '' && data.isStrong"><span :class="data.childClass">{{
                                                data.key_indicators_of_performance }}</span></strong>
                                    </td>
                                    <td class="text-center"><span>{{ data.total}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span v-show="isEditable && (data.editableField === true)">
                                            <input type="number" class="form-control"
                                                v-model="data.cr" @keypress="validateNumber($event)">
                                        </span>
                                        <span v-show="isEditable && (data.editableField === false)">
                                            {{ data.cr }}
                                        </span>
                                        <span v-show="isEditable && (data.editableField === 'header')">
                                            {{ data.cr }}
                                        </span>
                                        <span v-show="!isEditable && data.cr !== 0">{{ data.cr }}</span>
                                        <span  v-show="!isEditable && data.cr === 0"> - </span>
                                    </td>
                                    <td class="text-center">
                                        <span v-show="isEditable && (data.editableField === true)">
                                            <input type="number" class="form-control"  v-model="data.cv" @keypress="validateNumber($event)">
                                        </span>
                                        <span v-show="isEditable && (data.editableField === 'header')">
                                            {{ data.cv }}
                                        </span>
                                        <span v-show="isEditable && (data.editableField === false)">
                                            {{ data.cv }}
                                        </span>
                                        <span v-show="!isEditable && data.cv !== 0">{{ data.cv }}</span>
                                        <span v-show="!isEditable && data.cv === 0"> - </span>
                                    </td>
                                    <td class="text-center">
                                        <span v-show="isEditable && (data.editableField === true)">
                                            <input type="number" class="form-control" v-model="data.adm1" @keypress="validateNumber($event)">
                                        </span>
                                        <span v-show="isEditable && (data.editableField === 'header')">
                                            {{ data.adm1 }}
                                        </span>
                                        <span v-show="isEditable && (data.editableField === false)">
                                            {{ data.adm1 }}
                                        </span>
                                        <span v-show="!isEditable && data.adm1 !== 0">{{ data.adm1 }}</span>
                                        <span v-show="!isEditable && data.adm1 === 0"> - </span>
                                    </td>
                                    <td class="text-center">
                                        <span v-show="isEditable && (data.editableField === true)">
                                            <input type="number" class="form-control" v-model="data.adm2" @keypress="validateNumber($event)">
                                        </span>
                                        <span v-show="isEditable && (data.editableField === 'header')">
                                            {{ data.adm2 }}
                                        </span>
                                        <span v-show="isEditable && (data.editableField === false)">
                                            {{ data.adm2 }}
                                        </span>
                                        <span v-show="!isEditable && data.adm2 !== 0">{{ data.adm2 }}</span>
                                        <span v-show="!isEditable && data.adm2 === 0"> - </span>
                                    </td>
                                    <td class="text-center">
                                        <span v-show="isEditable && (data.editableField === true)">
                                            <input type="number" class="form-control" v-model="data.adm3" @keypress="validateNumber($event)">
                                        </span>
                                        <span v-show="isEditable && (data.editableField === 'header')">
                                            {{ data.adm3 }}
                                        </span>
                                        <span v-show="isEditable && (data.editableField === false)">
                                            {{ data.adm3 }}
                                        </span>
                                        <span v-show="!isEditable && data.adm3 !== 0">{{ data.adm3 }}</span>
                                        <span v-show="!isEditable && data.adm3 === 0"> - </span>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="1" class="text-left">
                                        <small>
                                            <p><strong>CR</strong> - Criminal Cases</p>
                                            <p><strong>CV</strong> - Civil Cases</p>
                                            <p><strong>ADM 1</strong> - Administrative Cases Proper</p>
                                            <p><strong>ADM 2</strong> - Prosecutor's Office Cases</p>
                                            <p><strong>ADM 3</strong> - Labor Cases</p>
                                        </small>

                                    </td>
                                    <td colspan="7" class="text-right">
                                         <h5>
                            Name of Public Attorney: <u class="pl-2 pr-2">{{lawyer}}</u>
                        </h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>

                <div class="showInPrint pt-3">
                <div class=" row pt-4">
                    <div class="col-md-6 p-3">
                        <h5>Prepared and Submitted By:</h5>
                        <h4 class="pt-2 text-center"><strong>Atty. {{lawyer}} <br>
                       Public Attorney</strong></h4>
                        <p class="text-center" style="margin: 0 auto; width: 50%; border-top: 1px solid #000"></p>
                    </div>
                    <div class="col-md-6 p-3">
                        <h5>Noted by:</h5>
                        <h4 class="pt-2 text-center"><strong>Atty. Socrates A. Padua <br>
                        Officer-in-Charge</strong></h4>
                        <p class="text-center" style="margin: 0 auto; width: 50%; border-top: 1px solid #000">District Public Attorney / OIC / Imeediate Supervisor</p>
                    </div>
                </div>
                </div>

                <div class="showInPrint">
                <div class=" text-center row pt-3">
                    <div class="col-md-4">
                        <small>PAO-F-FOSS/IPR-09</small>
                    </div>
                    <div class="col-md-4">
                        <small>Rev. No: 0</small>
                    </div>
                    <div class="col-md-4">
                        <small>{{presentMonth | month}} {{presentDay}} {{presentYear}}</small>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RotateLoader from "vue-spinner/src/RotateLoader.vue";
import VueMonthlyPicker from 'vue-monthly-picker'
    export default {
        components: {
        VueMonthlyPicker,
        RotateLoader
    },
        data() {
            return {
                presentYear: (new Date()).getFullYear(),
                presentMonth: (new Date()).getMonth(),
                presentDay: (new Date()).getDay(),
                loading: false,
                lawyer: '',
                isEditable: false,
                selectedMonth: '',
                sortBy: 'All',
                pending: '',
                attorneys: {},
                monthLabels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
                reportData: new Form([
                    { atty: '', item: '', area: 'I.RENDITION OF JUDICIAL SERVICES', title: 'A. REGULAR SERVICES', childClass: '', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: '1. Cases pending, beginning', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: '2. New Cases Received', editableField: 'header', total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: '2.1. No. of clients involved', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: '3. Cases received from another PAO lawyer', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: '4. Cases transferred to another PAO lawyer', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: '5. Total Cases Handled (Item 1+2+3-4)', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: '6. Total Terminated Cases/Dispositions (Old + New)', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'a. Old Cases', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'b. New Cases', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-1', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'Status (Terminated cases/dispositions)', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-1', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'I. Favorable Dispositions to Clients', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'a. Acquitted', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'a.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'b. Dismissed with prejudice', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'b.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'c. Motion to quash granted', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'c.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'd. Demurrer to evidence granted', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'd.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'e. Provisionally dismissed', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'e.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'f. Convicted to lesser offense', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'f.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'g. Probation granted', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'g.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'h. Won (civil, labor, and administrative)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'h.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'i. Granted lesser award (civil, administrative & labor)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'i.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'j. Dismissed cases based on comprise agreement (civil & labor)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'j.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'k. Criminal cases for preliminary investigation', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'k.1. Case filed in court (complainant)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5 ml-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'k.1.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'k.2. Dismissed (respondent)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5 ml-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'k.2.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'l. Pre-trial releases and other dispositions', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'l.1. Bail (Non-bailable offense)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5 ml-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'l.1.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'l.2. Recognizance', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5 ml-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'l.2.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'l.3. Diversion proceedings/intervention', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5 ml-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'l.3.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'l.4. Suspended sentence', total: '', editableField: 'header', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5 ml-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'l.4.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'l.5. Maximum imposable penalty served', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5 ml-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'l.5.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-1', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'II. Unfavorable Dispositions to Clients', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'a. Convicted as charged', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'a.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'b. Lost (civil, administrative & labor)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'b.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'c. Dismissed (civil, administrative & labor)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'c.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'd. Criminal cases for preliminary investigation', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'd.1. Dismissed (complainant)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5 ml-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'd.1.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'd.2. Dismissed (respondent)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5 ml-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'd.2.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-1', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'III. Other Dispositions', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'a. Archived', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'a.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'b. Withdrawn', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'b.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'c. Transferred to private lawyer, IBP, etc.', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'c.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-1', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'IV. Total No. of Clients Involved (Terminated Cases/Dispositions)', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'A. REGULAR SERVICES', key_indicators_of_performance: '7. Cases Pending, End (Cases Handled less Terminated Cases/Dispositions)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'a. On Trial', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'b. Submitted for Decision/Resolution',  editableField: true,total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'c. Appealed Cases from MTC to RTC', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. REGULAR SERVICES', key_indicators_of_performance: 'd. Appealed Cases to the Regional/Central Office of an Agency', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'B. LIMITED SERVICES', childClass: '', isStrong: false, section: 'B. LIMITED SERVICES', key_indicators_of_performance: 'No. of Accused:', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. LIMITED SERVICES', key_indicators_of_performance: '1. Assisted for arraignment only', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. LIMITED SERVICES', key_indicators_of_performance: '2. Assisted for pre-trial only', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. LIMITED SERVICES', key_indicators_of_performance: '3. Assisted for promulgation of judgement only', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. LIMITED SERVICES', key_indicators_of_performance: '4. Extended other limited services', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-2', isStrong: true, section: 'B. LIMITED SERVICES', key_indicators_of_performance: 'TOTAL NO. OF CLIENTS SERVED', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'C. SPECIAL LEGAL SERVICES', childClass: '', isStrong: true, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '(Pursuant to Sec. 14-A of R.A. 9406 and MOAs)', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '1. Pending,beginning', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '2. No. of cases received', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '2.1. No. of clients involved', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '3. Cases received from another PAO lawyer', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '3.1. No. of clients involved', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '4. Cases transferred to another PAO lawyer', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '4.1. No. of clients involved', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '5. Total Cases Handled', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '6. Total Terminated Cases/Dispositions', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '6.1. Favorable', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '6.1. Unfavorable', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. SPECIAL LEGAL SERVICES', key_indicators_of_performance: '7. Cases pending, end', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: 'II.RENDITION OF QUASI-JUDICIAL SERVICES', title: 'A. MEDIATION AND CONFLICTION', childClass: '', isStrong: true, section: 'A. MEDIATION AND CONFLICTION', editableField: 'header', key_indicators_of_performance: '', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '1. Disputes pending, beginning', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '2. New request/s received', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '2.1. No. of clients involved', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '3. Cases received from another PAO lawyer', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '3.1. No. of clients involved', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '4. Cases transferred to another PAO lawyer',  editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '4.1. No. of clients involved', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '5. Total Disputes Handled', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '6. Disputes terminated/Dispositions', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '6.1. Disputes Settled (compromised agreement)', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '6.2. Disputes closed without settlement', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. MEDIATION AND CONFLICTION', key_indicators_of_performance: '7. Disputes pending, end', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', childClass: '', isStrong: true, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '1. Pending, beginning', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '2. New cases received', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '2.1. No. of clients involved', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '3. Cases received from another PAO lawyer', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '3.1. No. of clients involved', editableField: false ,total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '4. Cases transferred to another PAO lawyer', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '4.1. No. of clients involved', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '5. Total Cases Handled', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '6. Total Terminated Cases/Dispositions', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '6.1. Cases for filling', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '6.2. Cases considered closed and terminated', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)', key_indicators_of_performance: '7. Pending, end', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: 'III. RENDITION OF NON-JUDICIAL SERVICES', title: 'A. INSTANT/OUTREACH SERVICES', childClass: '', isStrong: true, section: 'A. INSTANT/OUTREACH SERVICES', key_indicators_of_performance: '', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. INSTANT/OUTREACH SERVICES', key_indicators_of_performance: '1. Documents/pleadings prepared', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. INSTANT/OUTREACH SERVICES', key_indicators_of_performance: '2. Oaths Adminstered', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. INSTANT/OUTREACH SERVICES', key_indicators_of_performance: '3. Clients Counselled (inperson, air mail, e-mail, telephone, mobile-phone, and other means of communication)', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'B. INQUEST ACTIVITIES', childClass: '', isStrong: true, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '1. Clients assisted during custodial interrogation', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '1.1. During Office hours', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '1.2. Beyond Office hours', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '2. Clients assisted during inquest interrogation', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '2.1. During Office hours', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '2.2. Beyond Office hours', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '3. Clients counselled during inquest/night duty', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '4. No. of police precincts visited', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '4.1. During Office hours', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '4.2. Beyond Office hours', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B. INQUEST ACTIVITIES', key_indicators_of_performance: '5. No. of times reported for inquest duty', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'C. JAIL VISITATION/RELEASES', childClass: '', isStrong: true, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: '', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: '1. No. of detainees/inamtes interviewed and assited (Preparation of pleadings, motions and other documentations).', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: '2. No. of detainees/inmates provided legal representation in court.', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: '3. No. of detainees/inamtes released:', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: 'a. Acquitted', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5 ml-3', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: 'a.1. after trial', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5 ml-3', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: 'a.2. on appeal', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: 'b. Released on pardon/executive clemency/probation.', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: 'c. Released on motion to dismiss/motion to quash.', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: 'd. Released on inquest assistance/representation.', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: 'e. Released after serving the possible maximum.', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: 'f. Released after serning the possible maximum of the prison term.', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: 'g. Released on other grounds. (i. e. motion for judcial determination of probable cause and others).', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: '4. No. of detainees/inamtes released per PAO-Central Office Legal and Medical, Dental Jail Visitaion and Deconggestion Program.', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'TOTAL NO. OF INAMTES SERVED/RELEASED', childClass: '', isStrong: true, section: 'TOTAL NUMBER', key_indicators_of_performance: '', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: 'C.1. No. of times conducted jail visitation (atleast once a week per MC No.02, series of 2008)', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. JAIL VISITATION/RELEASES', key_indicators_of_performance: 'C.2. No. of jails/detention units visited', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'D. BARANGAY LEGAL OUTREACH & VISITATION', childClass: '', isStrong: true, section: 'D. BARANGAY LEGAL OUTREACH & VISITATION', key_indicators_of_performance: '', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'D. BARANGAY LEGAL OUTREACH & VISITATION', key_indicators_of_performance: '1. No. of barangay legal outreach conducted', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'D. BARANGAY LEGAL OUTREACH & VISITATION', key_indicators_of_performance: '2. No. of beneficiaries', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'E. LEGAL AID INFORMATION/DISSEMINATION', childClass: '', isStrong: true, section: 'E. LEGAL AID INFORMATION/DISSEMINATION', key_indicators_of_performance: '', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'E. LEGAL AID INFORMATION/DISSEMINATION', key_indicators_of_performance: 'E.1. Community Linkages', editableField: 'header', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'E. LEGAL AID INFORMATION/DISSEMINATION', key_indicators_of_performance: 'a. No. of information dissemination, meeting conducted/attended', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'E. LEGAL AID INFORMATION/DISSEMINATION', key_indicators_of_performance: 'b. No. of clients informed', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'TOTAL NUMBER OF CLIENTS ASSISTED', childClass: '', isStrong: true, section: 'TOTAL NUMBER', key_indicators_of_performance: '', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'TOTAL NUMBER OF REQUEST FOR LEGAL ASSISTANCE/REPRESENTATION ACTED UPON WITHIN 3 WORKING DAYS (JUDICAL)', childClass: '', isStrong: true, section: 'TOTAL NUMBER', key_indicators_of_performance: '', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'TOTAL NUMBER OF REQUEST FOR ASSISTANCE ACTED UPON WITHIN 2 HOURS (NON-JUDICIAL)', childClass: '', isStrong: true, section: 'TOTAL NUMBER', key_indicators_of_performance: '', editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'TOTAL NUMBER OF SCHEDULED HEARINGS (JUDICIAL & QUASI-JUDICIAL)', childClass: '', isStrong: true, section: 'TOTAL NUMBER', key_indicators_of_performance: '', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    { atty: '', item: '', area: '', title: 'TOTAL NUMBER OF POSTPONEMENTS SOUGHT BY PUBLIC ATTORNEY (JUDICIAL & QUASI-JUDICIAL)', childClass: '', isStrong: true, section: 'TOTAL NUMBER', key_indicators_of_performance: '', editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                ])
            }
        },
        methods: {
            loadReports(name) {
                this.loading = true
                this.reportData.reset()

                let atty = new Form({
                    name: name,
                    date: this.selectedMonth

                })

                for (let i = 0; i < 162; i++) {
                    this.reportData[i].atty = name
                    this.reportData[i].report_month = this.selectedMonth
                }

                atty.post('api/individual-performance-reports').then(({
                    data
                }) => {
                    for (let property in this.reportData){
                    for (let i in data) {
                        if (this.reportData[property].section == data[i].section && this.reportData[property].key_indicators_of_performance ==
                            data[i].key_indicators_of_performance) {
                            this.reportData[property].item = data[i].id
                            this.reportData[property].cr = parseInt(data[i].cr) || 0
                            this.reportData[property].cv = parseInt(data[i].cv) || 0
                            this.reportData[property].adm1 = parseInt(data[i].adm1) || 0
                            this.reportData[property].adm2 = parseInt(data[i].adm2) || 0
                            this.reportData[property].adm3 = parseInt(data[i].adm3) || 0
                            this.reportData[property].total =   parseInt(data[i].cr)  +  parseInt(data[i].cv)    +    parseInt(data[i].adm1)   +    parseInt(data[i].adm2)  +   parseInt(data[i].adm3)
                        }
                    }
                    this.reportData[158].total = this.reportData[8].total + this.reportData[66].total + this.reportData[77].total
                }
                })

                atty.post('api/pending-criminal').then(({
                    data
                }) => {

                    this.reportData[0].cr = data
                })

                atty.post('api/pending-civil').then(({
                    data
                }) => {
                    this.reportData[0].cv = data
                })

                atty.post('api/pending-adm1').then(({
                    data
                }) => {
                    this.reportData[0].adm1 = data
                })

                atty.post('api/pending-adm2').then(({
                    data
                }) => {
                    this.reportData[0].adm2 = data
                })

                atty.post('api/pending-adm3').then(({
                    data
                }) => {

                    this.reportData[0].adm3 = data
                })
                atty.post('api/received-criminal').then(({
                    data
                }) => {
                    this.reportData[3].cr = data
                })

                atty.post('api/received-civil').then(({
                    data
                }) => {
                    this.reportData[3].cv = data
                })

                atty.post('api/received-adm1').then(({
                    data
                }) => {
                    this.reportData[3].adm1 = data
                })

                atty.post('api/received-adm2').then(({
                    data
                }) => {
                    this.reportData[3].adm2 = data
                })

                atty.post('api/received-adm3').then(({
                    data
                }) => {
                    this.reportData[3].adm3 = data
                })

                atty.post('api/transfer-criminal').then(({
                    data
                }) => {
                    this.reportData[4].cr = data
                })

                atty.post('api/transfer-civil').then(({
                    data
                }) => {
                    this.reportData[4].cv = data
                })

                atty.post('api/transfer-adm1').then(({
                    data
                }) => {
                    this.reportData[4].adm1 = data
                })

                atty.post('api/transfer-adm2').then(({
                    data
                }) => {
                    this.reportData[4].adm2 = data
                })

                atty.post('api/transfer-adm3').then(({
                    data
                }) => {
                    this.reportData[4].adm3 = data
                })

                atty.post('api/total-terminated-old').then(({
                    data
                }) => {
                    this.reportData[7].total = data
                })

                atty.post('api/total-terminated-new').then(({
                    data
                }) => {
                    this.reportData[8].total = data
                })

                atty.post('api/aquitted-cr').then(({
                    data
                }) => {
                    this.reportData[12].cr = data
                })

                atty.post('api/aquitted-cv').then(({
                    data
                }) => {
                    this.reportData[12].cv = data
                })

                atty.post('api/aquitted-adm1').then(({
                    data
                }) => {
                    this.reportData[12].adm1 = data
                })

                atty.post('api/aquitted-adm2').then(({
                    data
                }) => {
                    this.reportData[12].adm2 = data
                })

                atty.post('api/aquitted-adm3').then(({
                    data
                }) => {
                    this.reportData[12].adm3 = data
                })

                atty.post('api/dismissed-w-p-cr').then(({
                    data
                }) => {
                    this.reportData[14].total = this.reportData[14].cr + this.reportData[14].cv + this.reportData[14].adm1 + this.reportData[14].adm2 + this.reportData[14].adm3
                    this.reportData[14].cr = data
                })

                atty.post('api/dismissed-w-p-cv').then(({
                    data
                }) => {
                    this.reportData[14].cv = data
                })

                atty.post('api/dismissed-w-p-adm1').then(({
                    data
                }) => {
                    this.reportData[14].adm1 = data
                })

                atty.post('api/dismissed-w-p-adm2').then(({
                    data
                }) => {
                    this.reportData[14].adm2 = data
                })

                atty.post('api/dismissed-w-p-adm3').then(({
                    data
                }) => {
                    this.reportData[14].adm3 = data
                })

                atty.post('api/motion-cr').then(({
                    data
                }) => {
                    this.reportData[16].cr = data
                })

                atty.post('api/motion-cv').then(({
                    data
                }) => {
                    this.reportData[16].cv = data
                })

                atty.post('api/motion-adm1').then(({
                    data
                }) => {
                    this.reportData[16].adm1 = data
                })

                atty.post('api/motion-adm2').then(({
                    data
                }) => {
                    this.reportData[16].adm2 = data
                })

                atty.post('api/motion-adm3').then(({
                    data
                }) => {
                    this.reportData[16].adm3 = data
                })

                atty.post('api/demurrer-cr').then(({
                    data
                }) => {
                    this.reportData[18].cr = data
                })

                atty.post('api/demurrer-cv').then(({
                    data
                }) => {
                    this.reportData[18].cv = data
                })

                atty.post('api/demurrer-adm1').then(({
                    data
                }) => {
                    this.reportData[18].adm1 = data
                })

                atty.post('api/demurrer-adm2').then(({
                    data
                }) => {
                    this.reportData[18].adm2 = data
                })

                atty.post('api/demurrer-adm3').then(({
                    data
                }) => {
                    this.reportData[18].adm3 = data
                })

                atty.post('api/provisionallyd-cr').then(({
                    data
                }) => {
                    this.reportData[20].cr = data
                })

                atty.post('api/provisionallyd-cv').then(({
                    data
                }) => {
                    this.reportData[20].cv = data
                })

                atty.post('api/provisionallyd-adm1').then(({
                    data
                }) => {
                    this.reportData[20].adm1 = data
                })

                atty.post('api/provisionallyd-adm2').then(({
                    data
                }) => {
                    this.reportData[20].adm2 = data
                })

                atty.post('api/provisionallyd-adm3').then(({
                    data
                }) => {
                    this.reportData[20].adm3 = data
                })

                atty.post('api/convictedtolesser-cr').then(({
                    data
                }) => {
                    this.reportData[22].cr = data
                })

                atty.post('api/convictedtolesser-cv').then(({
                    data
                }) => {
                    this.reportData[22].cv = data
                })

                atty.post('api/convictedtolesser-adm1').then(({
                    data
                }) => {
                    this.reportData[22].adm1 = data
                })

                atty.post('api/convictedtolesser-adm2').then(({
                    data
                }) => {
                    this.reportData[22].adm2 = data
                })

                atty.post('api/convictedtolesser-adm3').then(({
                    data
                }) => {
                    this.reportData[22].adm3 = data
                })

                atty.post('api/probationgranted-cr').then(({
                    data
                }) => {
                    this.reportData[24].cr = data
                })

                atty.post('api/probationgranted-cv').then(({
                    data
                }) => {
                    this.reportData[24].cv = data
                })

                atty.post('api/probationgranted-adm1').then(({
                    data
                }) => {
                    this.reportData[24].adm1 = data
                })

                atty.post('api/probationgranted-adm2').then(({
                    data
                }) => {
                    this.reportData[24].adm2 = data
                })

                atty.post('api/probationgranted-adm3').then(({
                    data
                }) => {
                    this.reportData[24].adm3 = data
                })

                atty.post('api/won-cr').then(({
                    data
                }) => {
                    this.reportData[26].cr = data
                })

                atty.post('api/won-cv').then(({
                    data
                }) => {
                    this.reportData[26].cv = data
                })

                atty.post('api/won-adm1').then(({
                    data
                }) => {
                    this.reportData[26].adm1 = data
                })

                atty.post('api/won-adm2').then(({
                    data
                }) => {
                    this.reportData[26].adm2 = data
                })

                atty.post('api/won-adm3').then(({
                    data
                }) => {
                    this.reportData[26].adm3 = data
                })

                atty.post('api/grantedlesser-cr').then(({
                    data
                }) => {
                    this.reportData[28].cr = data
                })

                atty.post('api/grantedlesser-cv').then(({
                    data
                }) => {
                    this.reportData[28].cv = data
                })

                atty.post('api/grantedlesser-adm1').then(({
                    data
                }) => {
                    this.reportData[28].adm1 = data
                })

                atty.post('api/grantedlesser-adm2').then(({
                    data
                }) => {
                    this.reportData[28].adm2 = data
                })

                atty.post('api/grantedlesser-adm3').then(({
                    data
                }) => {
                    this.reportData[28].adm3 = data
                })

                atty.post('api/dismissed-cases-c-a-cr').then(({
                    data
                }) => {
                    this.reportData[30].cr = data
                })

                atty.post('api/dismissed-cases-c-a-cv').then(({
                    data
                }) => {
                    this.reportData[30].cv = data
                })

                atty.post('api/dismissed-cases-c-a-adm1').then(({
                    data
                }) => {
                    this.reportData[30].adm1 = data
                })

                atty.post('api/dismissed-cases-c-a-adm2').then(({
                    data
                }) => {
                    this.reportData[30].adm2 = data
                })

                atty.post('api/dismissed-cases-c-a-adm3').then(({
                    data
                }) => {
                    this.reportData[30].adm3 = data
                })

                atty.post('api/casefiled-cr').then(({
                    data
                }) => {
                    this.reportData[33].cr = data
                })

                atty.post('api/casefiled-cv').then(({
                    data
                }) => {
                    this.reportData[33].cv = data
                })

                atty.post('api/casefiled-adm1').then(({
                    data
                }) => {
                    this.reportData[33].adm1 = data
                })

                atty.post('api/casefiled-adm2').then(({
                    data
                }) => {
                    this.reportData[33].adm2 = data
                })

                atty.post('api/casefiled-adm3').then(({
                    data
                }) => {
                    this.reportData[33].adm3 = data
                })

                atty.post('api/favorabledismissed-cr').then(({
                    data
                }) => {
                    this.reportData[35].cr = data
                })

                atty.post('api/favorabledismissed-cv').then(({
                    data
                }) => {
                    this.reportData[35].cv = data
                })

                atty.post('api/favorabledismissed-adm1').then(({
                    data
                }) => {
                    this.reportData[35].adm1 = data
                })

                atty.post('api/favorabledismissed-adm2').then(({
                    data
                }) => {
                    this.reportData[35].adm2 = data
                })

                atty.post('api/favorabledismissed-adm3').then(({
                    data
                }) => {
                    this.reportData[35].adm3 = data
                })

                atty.post('api/bail-cr').then(({
                    data
                }) => {
                    this.reportData[38].cr = data
                })

                atty.post('api/bail-cv').then(({
                    data
                }) => {
                    this.reportData[38].cv = data
                })

                atty.post('api/bail-adm1').then(({
                    data
                }) => {
                    this.reportData[38].adm1 = data
                })

                atty.post('api/bail-adm2').then(({
                    data
                }) => {
                    this.reportData[38].adm2 = data
                })

                atty.post('api/bail-adm3').then(({
                    data
                }) => {
                    this.reportData[38].adm3 = data
                })

                atty.post('api/recognizance-cr').then(({
                    data
                }) => {
                    this.reportData[40].cr = data
                })

                atty.post('api/recognizance-cv').then(({
                    data
                }) => {
                    this.reportData[40].cv = data
                })

                atty.post('api/recognizance-adm1').then(({
                    data
                }) => {
                    this.reportData[40].adm1 = data
                })

                atty.post('api/recognizance-adm2').then(({
                    data
                }) => {
                    this.reportData[40].adm2 = data
                })

                atty.post('api/recognizance-adm3').then(({
                    data
                }) => {
                    this.reportData[40].adm3 = data
                })

                atty.post('api/diversionproceeding-cr').then(({
                    data
                }) => {
                    this.reportData[42].cr = data
                })

                atty.post('api/diversionproceeding-cv').then(({
                    data
                }) => {
                    this.reportData[42].cv = data
                })

                atty.post('api/diversionproceeding-adm1').then(({
                    data
                }) => {
                    this.reportData[42].adm1 = data
                })

                atty.post('api/diversionproceeding-adm2').then(({
                    data
                }) => {
                    this.reportData[42].adm2 = data
                })

                atty.post('api/diversionproceeding-adm3').then(({
                    data
                }) => {
                    this.reportData[42].adm3 = data
                })

                atty.post('api/suspensesentence-cr').then(({
                    data
                }) => {
                    this.reportData[44].cr = data
                })

                atty.post('api/suspensesentence-cv').then(({
                    data
                }) => {
                    this.reportData[44].cv = data
                })

                atty.post('api/suspensesentence-adm1').then(({
                    data
                }) => {
                    this.reportData[44].adm1 = data
                })

                atty.post('api/suspensesentence-adm2').then(({
                    data
                }) => {
                    this.reportData[44].adm2 = data
                })

                atty.post('api/suspensesentence-adm3').then(({
                    data
                }) => {
                    this.reportData[44].adm3 = data
                })

                atty.post('api/maximumimposable-cr').then(({
                    data
                }) => {
                    this.reportData[46].cr = data
                })

                atty.post('api/maximumimposable-cv').then(({
                    data
                }) => {
                    this.reportData[46].cv = data
                })

                atty.post('api/maximumimposable-adm1').then(({
                    data
                }) => {
                    this.reportData[46].adm1 = data
                })

                atty.post('api/maximumimposable-adm2').then(({
                    data
                }) => {
                    this.reportData[46].adm2 = data
                })

                atty.post('api/maximumimposable-adm3').then(({
                    data
                }) => {
                    this.reportData[46].adm3 = data
                })

                atty.post('api/convictedcharge-cr').then(({
                    data
                }) => {
                    this.reportData[49].cr = data
                })

                atty.post('api/convictedcharge-cv').then(({
                    data
                }) => {
                    this.reportData[49].cv = data
                })

                atty.post('api/convictedcharge-adm1').then(({
                    data
                }) => {
                    this.reportData[49].adm1 = data
                })

                atty.post('api/convictedcharge-adm2').then(({
                    data
                }) => {
                    this.reportData[49].adm2 = data
                })

                atty.post('api/convictedcharge-adm3').then(({
                    data
                }) => {
                    this.reportData[49].adm3 = data
                })

                atty.post('api/lost-cr').then(({
                    data
                }) => {
                    this.reportData[51].cr = data
                })

                atty.post('api/lost-cv').then(({
                    data
                }) => {
                    this.reportData[51].cv = data
                })

                atty.post('api/lost-adm1').then(({
                    data
                }) => {
                    this.reportData[51].adm1 = data
                })

                atty.post('api/lost-adm2').then(({
                    data
                }) => {
                    this.reportData[51].adm2 = data
                })

                atty.post('api/lost-adm3').then(({
                    data
                }) => {
                    this.reportData[51].adm3 = data
                })

                atty.post('api/dismissedcal-cr').then(({
                    data
                }) => {
                    this.reportData[53].cr = data
                })

                atty.post('api/dismissedcal-cv').then(({
                    data
                }) => {
                    this.reportData[53].cv = data
                })

                atty.post('api/dismissedcal-adm1').then(({
                    data
                }) => {
                    this.reportData[53].adm1 = data
                })

                atty.post('api/dismissedcal-adm2').then(({
                    data
                }) => {
                    this.reportData[53].adm2 = data
                })

                atty.post('api/dismissedcal-adm3').then(({
                    data
                }) => {
                    this.reportData[53].adm3 = data
                })

                atty.post('api/unfavorabledismissedcomplainant-cr').then(({
                    data
                }) => {
                    this.reportData[56].cr = data
                })

                atty.post('api/unfavorabledismissedcomplainant-cv').then(({
                    data
                }) => {
                    this.reportData[56].cv = data
                })

                atty.post('api/unfavorabledismissedcomplainant-adm1').then(({
                    data
                }) => {
                    this.reportData[56].adm1 = data
                })

                atty.post('api/unfavorabledismissedcomplainant-adm2').then(({
                    data
                }) => {
                    this.reportData[56].adm2 = data
                })

                atty.post('api/unfavorabledismissedcomplainant-adm3').then(({
                    data
                }) => {
                    this.reportData[56].adm3 = data
                })

                atty.post('api/unfavorabledismissedrespondent-cr').then(({
                    data
                }) => {
                    this.reportData[58].cr = data
                })

                atty.post('api/unfavorabledismissedrespondent-cv').then(({
                    data
                }) => {
                    this.reportData[58].cv = data
                })

                atty.post('api/unfavorabledismissedrespondent-adm1').then(({
                    data
                }) => {
                    this.reportData[58].adm1 = data
                })

                atty.post('api/unfavorabledismissedrespondent-adm2').then(({
                    data
                }) => {
                    this.reportData[58].adm2 = data
                })

                atty.post('api/unfavorabledismissedrespondent-adm3').then(({
                    data
                }) => {
                    this.reportData[58].adm3 = data
                })

                atty.post('api/archived-cr').then(({
                    data
                }) => {
                    this.reportData[61].cr = data
                })

                atty.post('api/archived-cv').then(({
                    data
                }) => {
                    this.reportData[61].cv = data
                })

                atty.post('api/archived-adm1').then(({
                    data
                }) => {
                    this.reportData[61].adm1 = data
                })

                atty.post('api/archived-adm2').then(({
                    data
                }) => {
                    this.reportData[61].adm2 = data
                })

                atty.post('api/archived-adm3').then(({
                    data
                }) => {
                    this.reportData[61].adm3 = data
                })

                atty.post('api/withdrawn-cr').then(({
                    data
                }) => {
                    this.reportData[63].cr = data
                })

                atty.post('api/withdrawn-cv').then(({
                    data
                }) => {
                    this.reportData[63].cv = data
                })

                atty.post('api/withdrawn-adm1').then(({
                    data
                }) => {
                    this.reportData[63].adm1 = data
                })

                atty.post('api/withdrawn-adm2').then(({
                    data
                }) => {
                    this.reportData[63].adm2 = data
                })

                atty.post('api/withdrawn-adm3').then(({
                    data
                }) => {
                    this.reportData[63].adm3 = data
                })

                atty.post('api/transferredtoprivate-cr').then(({
                    data
                }) => {
                    this.reportData[65].cr = data
                })

                atty.post('api/transferredtoprivate-cv').then(({
                    data
                }) => {
                    this.reportData[65].cv = data
                })

                atty.post('api/transferredtoprivate-adm1').then(({
                    data
                }) => {
                    this.reportData[65].adm1 = data
                })

                atty.post('api/transferredtoprivate-adm2').then(({
                    data
                }) => {
                    this.reportData[65].adm2 = data
                })

                atty.post('api/transferredtoprivate-adm3').then(({
                    data
                }) => {
                    this.reportData[65].adm3 = data
                })

                atty.post('api/pendinginvestigation-cr').then(({
                    data
                }) => {
                    this.reportData[105].cr = data
                })

                atty.post('api/pendinginvestigation-cv').then(({
                    data
                }) => {
                    this.reportData[105].cv = data
                })

                atty.post('api/pendinginvestigation-adm1').then(({
                    data
                }) => {
                    this.reportData[105].adm1 = data
                })

                atty.post('api/pendinginvestigation-adm2').then(({
                    data
                }) => {
                    this.reportData[105].adm2 = data
                })

                atty.post('api/pendinginvestigation-adm3').then(({
                    data
                }) => {
                    this.reportData[105].adm3 = data
                })

                atty.post('api/receivedinvestigation-cr').then(({
                    data
                }) => {
                    this.reportData[109].cr = data
                })

                atty.post('api/receivedinvestigation-cv').then(({
                    data
                }) => {
                    this.reportData[109].cv = data
                })

                atty.post('api/receivedinvestigation-adm1').then(({
                    data
                }) => {
                    this.reportData[109].adm1 = data
                })

                atty.post('api/receivedinvestigation-adm2').then(({
                    data
                }) => {
                    this.reportData[109].adm2 = data
                })

                atty.post('api/receivedinvestigation-adm3').then(({
                    data
                }) => {
                    this.reportData[109].adm3 = data
                })

                atty.post('api/transferinvestigation-cr').then(({
                    data
                }) => {
                    this.reportData[111].cr = data
                })

                atty.post('api/transferinvestigation-cv').then(({
                    data
                }) => {
                    this.reportData[111].cv = data
                })

                atty.post('api/transferinvestigation-adm1').then(({
                    data
                }) => {
                    this.reportData[111].adm1 = data
                })

                atty.post('api/transferinvestigation-adm2').then(({
                    data
                }) => {
                    this.reportData[111].adm2 = data
                })

                atty.post('api/transferinvestigation-adm3').then(({
                    data
                }) => {
                    this.reportData[111].adm3 = data
                })

                atty.post('api/casefiledinvestigation').then(({
                    data
                }) => {
                    this.reportData[114].total = data
                })

                atty.post('api/terminated-investigation').then(({
                    data
                }) => {
                    this.reportData[115].total = data

                    setTimeout(() => {
                        for(let i = 0; i < 162; i++) {
                            this.reportData[i].total = this.reportData[i].cv + this.reportData[i].cr + this.reportData[i].adm1 + this.reportData[i].adm2 + this.reportData[i].adm3
                        }
                        this.reportData[5].total = parseInt(this.reportData[0].total + this.reportData[2].total + this.reportData[3].total + this.reportData[4].total) || parseInt(0)
                        this.reportData[66].total = parseInt(this.reportData[12].total + this.reportData[14].total + this.reportData[16].total + this.reportData[18].total + this.reportData[20].total + this.reportData[22].total + this.reportData[24].total + this.reportData[26].total + this.reportData[28].total + this.reportData[30].total + this.reportData[33].total + this.reportData[35].total + this.reportData[38].total + this.reportData[40].total + this.reportData[42].total + this.reportData[44].total + this.reportData[46].total + this.reportData[49].total + this.reportData[51].total + this.reportData[53].total + this.reportData[56].total + this.reportData[58].total + this.reportData[61].total + this.reportData[63].total + this.reportData[65].total) || parseInt(0)
                        this.reportData[77].total = parseInt(this.reportData[73].total + this.reportData[74].total + this.reportData[75].total + this.reportData[76].total) || parseInt(0)
                        this.reportData[147].total = parseInt(this.reportData[134].total + this.reportData[135].total + this.reportData[138].total + this.reportData[139].total + this.reportData[140].total + this.reportData[141].total + this.reportData[142].total + this.reportData[143].total +this.reportData[144].total + this.reportData[145].total + this.reportData[146].total) || parseInt(0)
                        this.reportData[159].total = parseInt(this.reportData[8].total + this.reportData[77].total + this.reportData[67].total) || parseInt(0)
                        if(this.loading === true) {
                            window.jQuery('.loader').fadeOut()
                        } else {
                             window.jQuery('.loader').fadeIn()
                        }
                        setTimeout(() => {
                            this.loading = false
                        }, 1000);
                    }, 1000);
                })

            },
            loadScrollbar() {
                window.onload = function () {
                    var tableCont = document.querySelector('#scrollable')
                    /**
                     * scroll handle
                     * @param {event} e -- scroll event
                     */
                    function scrollHandle(e) {
                        var scrollTop = this.scrollTop;
                        this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
                    }
                    tableCont.addEventListener('scroll', scrollHandle)
                }
            },
            loadPending() {
                    axios.get('api/pending').then(({
                        data
                    }) => {

                    })
            },
            loadReportData() {
                    axios.get('api/individual-performance-report').then(({
                        data
                    }) => {
                        for (let property in this.reportData) {
                            for (let i in data) {
                                if (this.reportData[property].section == data[i].section && this.reportData[
                                        property].key_indicators_of_performance == data[i].key_indicators_of_performance ||
                                    this.reportData[property].title == data[i].key_indicators_of_performance) {
                                    this.reportData[property].item = data[i].id
                                    this.reportData[property].total = parseInt(data[i].cr) + parseInt(data[i].cv) + parseInt(data[i].adm1) + parseInt(data[i].adm2) + parseInt(data[i].adm3)
                                    this.reportData[property].cr = data[i].cr
                                    this.reportData[property].cv = data[i].cv
                                    this.reportData[property].adm1 = data[i].adm1
                                    this.reportData[property].adm2 = data[i].adm2
                                    this.reportData[property].adm3 = data[i].adm3
                                }
                            }
                        }
                    })
            },
            sortSection(section) {
                if (this.sortBy === 'All') {
                    return section
                } else if (this.sortBy === 'Regular Services') {
                    return 'A. REGULAR SERVICES'
                } else if (this.sortBy === 'Limited Services') {
                    return 'B. LIMITED SERVICES'
                } else if (this.sortBy === 'Special Legal Services') {
                    return 'C. SPECIAL LEGAL SERVICES'
                } else if (this.sortBy === 'Mediation and Conflict') {
                    return 'A. MEDIATION AND CONFLICTION'
                } else if (this.sortBy === 'Investigation') {
                    return 'B. INVESTIGATION (R.A 9475 or Anti-Torture Law)'
                } else if (this.sortBy === 'Instant/Outreach Services') {
                    return 'A. INSTANT/OUTREACH SERVICES'
                } else if (this.sortBy === 'Inquest Activities') {
                    return 'B. INQUEST ACTIVITIES'
                } else if (this.sortBy === 'Jail Visitation/Releases') {
                    return 'C. JAIL VISITATION/RELEASES'
                } else if (this.sortBy === 'Barangay Legal Outreach and Visitation') {
                    return 'D. BARANGAY LEGAL OUTREACH & VISITATION'
                } else if (this.sortBy === 'Legal Aid Information/Dissemination') {
                    return 'E. LEGAL AID INFORMATION/DISSEMINATION'
                } else if (this.sortBy === 'Totals') {
                    return 'TOTAL NUMBER'
                }
            },
            validateNumber(event) {
                if ((event.keyCode < 48 || event.keyCode > 57)) {
                    event.returnValue = false;
                }
            },
            exportPrint() {
                this.$Progress.start()
                this.sortBy = 'All'
                setTimeout(() => {
                    let beforePrint = function () {
                        document.querySelector('#sticky').classList.remove('sticky')
                        document.querySelector('#scrollable').classList.remove('scroll')
                        document.querySelector('#scrollable').classList.remove('cuz')
                    }

                    let afterPrint = function () {
                        document.querySelector('#sticky').classList.add('sticky')
                        document.querySelector('#scrollable').classList.add('scroll')
                        document.querySelector('#scrollable').classList.add('cuz')
                    }

                    if (window.matchMedia) {
                        let mediaQueryList = window.matchMedia('print');
                        mediaQueryList.addListener(function (mql) {
                            if (mql.matches) {
                                beforePrint()
                            } else {
                                afterPrint()
                            }
                        })
                    }
                    window.onbeforeprint = beforePrint;
                    window.onafterprint = afterPrint;
                    window.print()
                }, 500);
                this.$Progress.finish()
            },
            updateReport() {
                this.$Progress.start()
                this.reportData.post('api/individual-performance-report').then(() => {
                    toast({
                        type: 'success',
                        title: 'Your Performance Report was Updated Successfully.'
                    })
                    this.$Progress.finish()
                    Fire.$emit('Refresh')
                    this.loadReports(this.lawyer)
                }).catch(() => {
                    this.$Progress.fail()
                })

            },
            submitReport() {
                this.updateReport()
            },
            submitLoad(){
                this.loadReportData()
            },
            cancel() {
                this.isEditable = false
                this.loadReportData()
            }
        },
        mounted() {
            axios.get('api/user').then(({
                data
            }) => {
                this.attorneys = data
            })
            this.loadScrollbar()
            this.loadPending()
            this.loadReportData()
                document.querySelector(".sidebar-mini").className += ' sidebar-collapse'
                this.lawyer = window.user.firstname + ' ' + window.user.lastname
            Fire.$on('Refresh', () => {
                this.loadReportData()
                this.isEditable = false
            });

        }
    }

</script>
