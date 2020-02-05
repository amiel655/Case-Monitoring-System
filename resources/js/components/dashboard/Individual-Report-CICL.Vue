<style>
@media print {
    @page {
        margin: 0;
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
        <div class="row justify-content-center">
            <div class="card card-border-shadow p-3">
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
                    </i> Individual Report on CICL</h3>

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
                        <div class="form-group pt-3"  v-if="$gate.isStaffAndSuperAdmin()">
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
                                <vue-monthly-picker :placeHolder="'Select Month'" dateFormat="MMMM" v-model="selectedMonth"
                                    :inline="true" :monthLabels="monthLabels" @input="loadReports(lawyer)"></vue-monthly-picker>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 form-inline pt-3">
                            <div class="form-group">
                                        <label for="sortBy" class="form__label">Sort By</label>
                                        <div class="pl-2 dropdown">
                                            <button class="btn btn-success dropdown-toggle form__input" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                {{ sortBy }}
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" @click="sortBy = 'All'">All</a>
                                                <a class="dropdown-item" @click="sortBy = 'CICL'">CICL</a>
                                                <a class="dropdown-item" @click="sortBy = 'R.A. 9262 - Women'">R.A. 9262 - Women</a>
                                                <a class="dropdown-item" @click="sortBy = 'R.A. 9262 - Children'">R.A. 9262 - Children</a>
                                                <a class="dropdown-item" @click="sortBy = 'Women Client'">Women Client</a>
                                                <a class="dropdown-item" @click="sortBy = 'Person with Disability'">Person with Disability</a>
                                                <a class="dropdown-item" @click="sortBy = 'Urban Poor'">Urban Poor</a>
                                                <a class="dropdown-item" @click="sortBy = 'Rural Poor'">Rural Poor</a>
                                                <a class="dropdown-item" @click="sortBy = 'OFW Land Based'">OFW Land Based</a>
                                                <a class="dropdown-item" @click="sortBy = 'OFW Sea Based'">OFW Sea Based</a>
                                                <a class="dropdown-item" @click="sortBy = 'Senior Citizen'">Senior Citizen</a>

                                                <a class="dropdown-item" @click="sortBy = 'R.A. 9372 (Human Security Act)'">R.A. 9372 (Human Security Act)</a>
                                                <a class="dropdown-item" @click="sortBy = 'R.A. 9745 (Anti-Torture Law)'">R.A. 9745 (Anti-Torture Law)</a>
                                                <a class="dropdown-item" @click="sortBy = 'Rape Victims'">Rape Victims</a>
                                                <a class="dropdown-item" @click="sortBy = 'R.A. 9208 (Anti-Trafficking)'">R.A. 9208 (Anti-Trafficking)</a>
                                                <a class="dropdown-item" @click="sortBy = 'R.A. 9165 (Comprehesive Drugs)'">R.A. 9165 (Comprehesive Drugs)</a>
                                                <a class="dropdown-item" @click="sortBy = 'Law Enforcement Officer'">Law Enforcement Officer</a>
                                                <a class="dropdown-item" @click="sortBy = 'Agrarian Cases'">Agrarian Cases</a>
                                                <a class="dropdown-item" @click="sortBy = 'Refugees/Evacuees'">Refugees/Evacuees</a>
                                                <a class="dropdown-item" @click="sortBy = 'Non-filipino Citizens'">Non-filipino Citizens</a>
                                            </div>
                                        </div>
                                    </div>
                        </div><br>
                </div>
        <div>
            <form @submit.prevent="updateReport" class="formTable">
                <table class="table table-bordered" id="scrollable">
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
                        <th scope="row">{{data.area}}</th>
                            <td>
                                <h4 v-show="data.title !== ''">{{ data.title }}<br></h4>
                                <strong v-show="data.childClass === '' && data.isStrong">{{ data.key_indicators_of_performance }}</strong>
                                <span v-show="data.childClass !== '' && !data.isStrong"  :class="data.childClass">{{ data.key_indicators_of_performance }}</span>
                                <span v-show="data.childClass === '' && !data.isStrong"  :class="data.childClass">{{ data.key_indicators_of_performance }}</span>
                                <strong v-show="data.childClass !== '' && data.isStrong"><span :class="data.childClass">{{ data.key_indicators_of_performance }}</span></strong>
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
                </table></form></div>

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
                        <small>PAO-F-FOSS/IRSM-10</small>
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
                isEditable: false,
                sortBy: 'All',
                attorneys: {},
                lawyer: '',
                selectedMonth: '',
                monthLabels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
                reportData: new Form([
                    {  atty: '', item: '', area: 'I.RENDITION OF JUDICIAL SERVICES', title: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', childClass: '', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', editableField: false,key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)', total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '',hideField: true, item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '4.a.3. Other dispositions', editableField: false,total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    //B.1
                    {  atty: '', item: '', area: '', title: 'B.1. Victims of R.A. 9262 (VAWC) - Women', childClass: '', isStrong: false, section: 'B.1. Victims of R.A. 9262 (VAWC) - Women', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'B.1. Victims of R.A. 9262 (VAWC) - Women', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B.1. Victims of R.A. 9262 (VAWC) - Women', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'B.1. Victims of R.A. 9262 (VAWC) - Women', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'B.1. Victims of R.A. 9262 (VAWC) - Women', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B.1. Victims of R.A. 9262 (VAWC) - Women', key_indicators_of_performance: '4.1. Cases for filing',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B.1. Victims of R.A. 9262 (VAWC) - Women', key_indicators_of_performance: '4.2. Cases considered closed and terminated',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'B.1. Victims of R.A. 9262 (VAWC) - Women', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'B.1. Victims of R.A. 9262 (VAWC) - Women', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'B.1. Victims of R.A. 9262 (VAWC) - Women', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'B.1. Victims of R.A. 9262 (VAWC) - Women', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    //B.2
                    {  atty: '', item: '', area: '', title: 'B.2. Victims of R.A. 9262 (VAWC) - Children', childClass: '', isStrong: false, section: 'B.2. Victims of R.A. 9262 (VAWC) - Children', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'B.2. Victims of R.A. 9262 (VAWC) - Children', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B.2. Victims of R.A. 9262 (VAWC) - Children', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'B.2. Victims of R.A. 9262 (VAWC) - Children', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'B.2. Victims of R.A. 9262 (VAWC) - Children', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B.2. Victims of R.A. 9262 (VAWC) - Children', key_indicators_of_performance: '4.1. Cases for filing',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'B.2. Victims of R.A. 9262 (VAWC) - Children', key_indicators_of_performance: '4.2. Cases considered closed and terminated',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'B.2. Victims of R.A. 9262 (VAWC) - Children', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'B.2. Victims of R.A. 9262 (VAWC) - Children', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'B.2. Victims of R.A. 9262 (VAWC) - Children', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'B.2. Victims of R.A. 9262 (VAWC) - Children', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    //C
                    {  atty: '', item: '', area: '', title: 'C. WOMEN CLIENT - Other Cases', childClass: '', isStrong: false, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '2. New cases received', editableField: true, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '4.1. Cases for filing',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '4.2. Cases considered closed and terminated',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '7. Oaths Administered',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'C. WOMEN CLIENT - Other Cases', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    //D
                    {  atty: '', item: '', area: '', title: 'D. INDIGENOUS GROUP', childClass: '', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'D. INDIGENOUS GROUP', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    //E
                    {  atty: '', item: '', area: '', title: 'E. PERSON WITH DISABILITY (PWD)', childClass: '', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)', editableField: false,total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'E. PERSON WITH DISABILITY (PWD)', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    //F
                    {  atty: '', item: '', area: '', title: 'F. URBAN POOR', childClass: '', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)', editableField: false,total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '2.a. No of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'F. URBAN POOR', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'F. URBAN POOR', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'F. URBAN POOR', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'F. URBAN POOR', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    //G
                    {  atty: '', item: '', area: '', title: 'G. RURAL POOR', childClass: '', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'G. RURAL POOR', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'G. RURAL POOR', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'G. RURAL POOR', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'G. RURAL POOR', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    //H1
                    {  atty: '', item: '', area: '', title: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', childClass: '', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    //H2
                    {  atty: '', item: '', area: '', title: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', childClass: '', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)', editableField: true,total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    //I
                    {  atty: '', item: '', area: '', title: 'I. SENIOR CITIZEN', childClass: '', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '7. Oaths Administered',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'I. SENIOR CITIZEN', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                     //J
                    {  atty: '', item: '', area: '', title: 'J. R.A. 9372 (HUMAN SECURITY ACT)', childClass: '', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients', editableField: false,total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '5.a. On trial', editableField: true,total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: '', report_month: '',},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'J. R.A. 9372 (HUMAN SECURITY ACT)', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    //K
                    {  atty: '', item: '', area: '', title: 'K. R.A. 9745 (ANTI-TORTURE LAW)', childClass: '', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'K. R.A. 9745 (ANTI-TORTURE LAW)', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                     //L
                    {  atty: '', item: '', area: '', title: 'L. RAPE VICTIMS', childClass: '', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'L. RAPE VICTIMS', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    //M
                    {  atty: '', item: '', area: '', title: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', childClass: '', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    //N
                    {  atty: '', item: '', area: '', title: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', childClass: '', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    //O
                    {  atty: '', item: '', area: '', title: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', childClass: '', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES)', key_indicators_of_performance: '2. New cases received',editableField: true, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '4.a Status',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '4.b. No. of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '7. Oaths Administered',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    //P
                    {  atty: '', item: '', area: '', title: 'P. AGRARIAN CASES', childClass: '', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'P. AGRARIAN CASES', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    //Q
                    {  atty: '', item: '', area: '', title: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', childClass: '', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    //R
                    {  atty: '', item: '', area: '', title: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', childClass: '', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '1. Cases pending, beginning (Pending end of the previous month)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '',isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '2. New cases received',editableField: false, total: '', cr: '', cv: '', adm1: '', adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '2.a. No of clients involved',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '3. Total cases handled (Item 1 + 2)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '4. Total terminated cases/dispositions (Total of Item 4.a.)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '4.a Status',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '4.a.1. Favorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '4.a.2. Unfavorable dispositions to clients',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-5', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '4.a.3. Other dispositions',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)', key_indicators_of_performance: '4.b. No. of clients involved',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: true, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '5. Cases pending, end (Item 3 - 4)',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '5.a. On trial',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '5.b. Submitted for decision / resolution',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '5.c. Appealed cases from MTC to RTC',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: 'pl-3', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '5.d. Cases referred to SACS',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '6. Documents/Pleadings Prepared',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '7. Oaths Administered',editableField: false, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '8. Counseled (in person air mail, e-mail, telephone, mobile phone, and other means of communication)',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '9. Assisted During Custodial Interrogation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
                    {  atty: '', item: '', area: '', title: '', childClass: '', isStrong: false, section: 'R. NON-FILIPINO CITIZENS/FOREIGN NATIONALS', key_indicators_of_performance: '10. Assisted During Inquest Investigation',editableField: true, total: '', cr: '', cv: '', adm1: '',adm2: '', adm3: ''},
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
                for (let i = 0; i < 375; i++) {
                    this.reportData[i].atty = name
                    this.reportData[i].report_month = this.selectedMonth
                }
                    atty.post('api/individual-report-cicls').then(({
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
                    }
                }
                )

                atty.post('api/pendingcicl-cr').then(({
                    data
                }) => {
                    this.reportData[0].cr = data
                })

                atty.post('api/pendingcicl-cv').then(({
                    data
                }) => {
                    this.reportData[0].cv = data
                })

                atty.post('api/pendingcicl-adm1').then(({
                    data
                }) => {
                    this.reportData[0].adm1 = data
                })

                atty.post('api/pendingcicl-adm2').then(({
                    data
                }) => {
                    this.reportData[0].adm2 = data
                })

                atty.post('api/pendingcicl-adm3').then(({
                    data
                }) => {
                    this.reportData[0].adm3 = data
                })

                atty.post('api/favorable-cicl').then(({
                    data
                }) => {
                    this.reportData[6].cr = data
                })

                atty.post('api/unfavorable-cicl').then(({
                    data
                }) => {
                    this.reportData[7].cr = data
                })

                atty.post('api/others-cicl').then(({
                    data
                }) => {
                    this.reportData[8].cr = data
                })

                atty.post('api/oaths-cicl').then(({
                    data
                }) => {
                    this.reportData[16].cr = data
                })

                atty.post('api/indigenousgroup-cr').then(({
                    data
                }) => {
                    this.reportData[57].cr = data
                })

                atty.post('api/indigenousgroup-cv').then(({
                    data
                }) => {
                    this.reportData[57].cv = data
                })

                atty.post('api/indigenousgroup-adm1').then(({
                    data
                }) => {
                    this.reportData[57].adm1 = data
                })

                atty.post('api/indigenousgroup-adm2').then(({
                    data
                }) => {
                    this.reportData[57].adm2 = data
                })

                atty.post('api/indigenousgroup-adm3').then(({
                    data
                }) => {
                    this.reportData[57].adm3 = data
                })

                atty.post('api/favorable-indigenousgroup').then(({
                    data
                }) => {
                    this.reportData[61].cr = data
                })

                atty.post('api/unfavorable-indigenousgroup').then(({
                    data
                }) => {
                    this.reportData[62].cr = data
                })

                atty.post('api/others-indigenousgroup').then(({
                    data
                }) => {
                    this.reportData[63].cr = data
                })

                atty.post('api/oaths-indigenousgroup').then(({
                    data
                }) => {
                    this.reportData[71].cr = data
                })

                atty.post('api/pwd-cr').then(({
                    data
                }) => {
                    this.reportData[75].cr = data
                })

                atty.post('api/pwd-cv').then(({
                    data
                }) => {
                    this.reportData[75].cv = data
                })

                atty.post('api/pwd-adm1').then(({
                    data
                }) => {
                    this.reportData[75].adm1 = data
                })

                atty.post('api/pwd-adm2').then(({
                    data
                }) => {
                    this.reportData[75].adm2 = data
                })

                atty.post('api/pwd-adm3').then(({
                    data
                }) => {
                    this.reportData[75].adm3 = data
                })

                atty.post('api/favorable-pwd').then(({
                    data
                }) => {
                    this.reportData[81].cr = data
                })

                atty.post('api/unfavorable-pwd').then(({
                    data
                }) => {
                    this.reportData[82].cr = data
                })

                atty.post('api/others-pwd').then(({
                    data
                }) => {
                    this.reportData[83].cr = data
                })

                atty.post('api/oaths-pwd').then(({
                    data
                }) => {
                    this.reportData[91].cr = data
                })

                atty.post('api/up-cr').then(({
                    data
                }) => {
                    this.reportData[95].cr = data
                })

                atty.post('api/up-cv').then(({
                    data
                }) => {
                    this.reportData[95].cv = data
                })

                atty.post('api/up-adm1').then(({
                    data
                }) => {
                    this.reportData[95].adm1 = data
                })

                atty.post('api/up-adm2').then(({
                    data
                }) => {
                    this.reportData[95].adm2 = data
                })

                atty.post('api/up-adm3').then(({
                    data
                }) => {
                    this.reportData[95].adm3 = data
                })

                atty.post('api/favorable-up').then(({
                    data
                }) => {
                    this.reportData[101].center = data
                })

                atty.post('api/unfavorable-up').then(({
                    data
                }) => {
                    this.reportData[102].cr = data
                })

                atty.post('api/others-up').then(({
                    data
                }) => {
                    this.reportData[103].cr = data
                })

                atty.post('api/oaths-up').then(({
                    data
                }) => {
                    this.reportData[111].cr = data
                })

                atty.post('api/rp-cr').then(({
                    data
                }) => {
                    this.reportData[115].cr = data
                })

                atty.post('api/rp-cv').then(({
                    data
                }) => {
                    this.reportData[115].cv = data
                })

                atty.post('api/rp-adm1').then(({
                    data
                }) => {
                    this.reportData[115].adm1 = data
                })

                atty.post('api/rp-adm2').then(({
                    data
                }) => {
                    this.reportData[115].adm2 = data
                })

                atty.post('api/rp-adm3').then(({
                    data
                }) => {
                    this.reportData[115].adm3 = data
                })

                atty.post('api/favorable-rp').then(({
                    data
                }) => {
                    this.reportData[121].cr = data
                })

                atty.post('api/unfavorable-rp').then(({
                    data
                }) => {
                    this.reportData[122].cr = data
                })

                atty.post('api/others-rp').then(({
                    data
                }) => {
                    this.reportData[123].cr = data
                })

                atty.post('api/oaths-rp').then(({
                    data
                }) => {
                    this.reportData[131].cr = data
                })

                atty.post('api/ofwl-cr').then(({
                    data
                }) => {
                    this.reportData[135].cr = data
                })

                atty.post('api/ofwl-cv').then(({
                    data
                }) => {
                    this.reportData[135].cv = data
                })

                atty.post('api/ofwl-adm1').then(({
                    data
                }) => {
                    this.reportData[135].adm1 = data
                })

                atty.post('api/ofwl-adm2').then(({
                    data
                }) => {
                    this.reportData[135].adm2 = data
                })

                atty.post('api/ofwl-adm3').then(({
                    data
                }) => {
                    this.reportData[135].adm3 = data
                })

                atty.post('api/favorable-ofwl').then(({
                    data
                }) => {
                    this.reportData[141].cr = data
                })

                atty.post('api/unfavorable-ofwl').then(({
                    data
                }) => {
                    this.reportData[142].cr = data
                })

                atty.post('api/others-ofwl').then(({
                    data
                }) => {
                    this.reportData[143].cr = data
                })

                atty.post('api/oaths-ofwl').then(({
                    data
                }) => {
                    this.reportData[151].cr = data
                })

                atty.post('api/ofws-cr').then(({
                    data
                }) => {
                    this.reportData[135].cr = data
                })

                atty.post('api/ofws-cv').then(({
                    data
                }) => {
                    this.reportData[155].cv = data
                })

                atty.post('api/ofws-adm1').then(({
                    data
                }) => {
                    this.reportData[155].adm1 = data
                })

                atty.post('api/ofws-adm2').then(({
                    data
                }) => {
                    this.reportData[155].adm2 = data
                })

                atty.post('api/ofws-adm3').then(({
                    data
                }) => {
                    this.reportData[155].adm3 = data
                })

                atty.post('api/favorable-ofws').then(({
                    data
                }) => {
                    this.reportData[161].cr = data
                })

                atty.post('api/unfavorable-ofws').then(({
                    data
                }) => {
                    this.reportData[162].cr = data
                })

                atty.post('api/others-ofws').then(({
                    data
                }) => {
                    this.reportData[163].cr = data
                })

                atty.post('api/oaths-ofws').then(({
                    data
                }) => {
                    this.reportData[171].cr = data
                })

                atty.post('api/sc-cr').then(({
                    data
                }) => {
                    this.reportData[175].cr = data
                })

                atty.post('api/sc-cv').then(({
                    data
                }) => {
                    this.reportData[175].cv = data
                })

                atty.post('api/sc-adm1').then(({
                    data
                }) => {
                    this.reportData[175].adm1 = data
                })

                atty.post('api/sc-adm2').then(({
                    data
                }) => {
                    this.reportData[175].adm2 = data
                })

                atty.post('api/sc-adm3').then(({
                    data
                }) => {
                    this.reportData[175].adm3 = data
                })

                atty.post('api/favorable-sc').then(({
                    data
                }) => {
                    this.reportData[181].cr = data
                })

                atty.post('api/unfavorable-sc').then(({
                    data
                }) => {
                    this.reportData[182].cr = data
                })

                atty.post('api/others-sc').then(({
                    data
                }) => {
                    this.reportData[183].cr = data
                })

                atty.post('api/oaths-sc').then(({
                    data
                }) => {
                    this.reportData[191].cr = data
                })

                atty.post('api/hsa-cr').then(({
                    data
                }) => {
                    this.reportData[195].cr = data
                })

                atty.post('api/hsa-cv').then(({
                    data
                }) => {
                    this.reportData[195].cv = data
                })

                atty.post('api/hsa-adm1').then(({
                    data
                }) => {
                    this.reportData[195].adm1 = data
                })

                atty.post('api/hsa-adm2').then(({
                    data
                }) => {
                    this.reportData[195].adm2 = data
                })

                atty.post('api/hsa-adm3').then(({
                    data
                }) => {
                    this.reportData[195].adm3 = data
                })

                atty.post('api/favorable-hsa').then(({
                    data
                }) => {
                    this.reportData[201].cr = data
                })

                atty.post('api/unfavorable-hsa').then(({
                    data
                }) => {
                    this.reportData[202].cr = data
                })

                atty.post('api/others-hsa').then(({
                    data
                }) => {
                    this.reportData[203].cr = data
                })

                atty.post('api/oaths-hsa').then(({
                    data
                }) => {
                    this.reportData[211].cr = data
                })

                atty.post('api/atl-cr').then(({
                    data
                }) => {
                    this.reportData[215].cr = data
                })

                atty.post('api/atl-cv').then(({
                    data
                }) => {
                    this.reportData[215].cv = data
                })

                atty.post('api/atl-adm1').then(({
                    data
                }) => {
                    this.reportData[215].adm1 = data
                })

                atty.post('api/atl-adm2').then(({
                    data
                }) => {
                    this.reportData[215].adm2 = data
                })

                atty.post('api/atl-adm3').then(({
                    data
                }) => {
                    this.reportData[215].adm3 = data
                })

                atty.post('api/favorable-atl').then(({
                    data
                }) => {
                    this.reportData[221].cr = data
                })

                atty.post('api/unfavorable-atl').then(({
                    data
                }) => {
                    this.reportData[222].cr = data
                })

                atty.post('api/others-atl').then(({
                    data
                }) => {
                    this.reportData[223].cr = data
                })

                atty.post('api/oaths-atl').then(({
                    data
                }) => {
                    this.reportData[231].cr = data
                })

                atty.post('api/rv-cr').then(({
                    data
                }) => {
                    this.reportData[235].cr = data
                })

                atty.post('api/rv-cv').then(({
                    data
                }) => {
                    this.reportData[235].cv = data
                })

                atty.post('api/rv-adm1').then(({
                    data
                }) => {
                    this.reportData[235].adm1 = data
                })

                atty.post('api/rv-adm2').then(({
                    data
                }) => {
                    this.reportData[235].adm2 = data
                })

                atty.post('api/rv-adm3').then(({
                    data
                }) => {
                    this.reportData[235].adm3 = data
                })

                atty.post('api/favorable-rv').then(({
                    data
                }) => {
                    this.reportData[241].cr = data
                })

                atty.post('api/unfavorable-rv').then(({
                    data
                }) => {
                    this.reportData[242].cr = data
                })

                atty.post('api/others-rv').then(({
                    data
                }) => {
                    this.reportData[243].cr = data
                })

                atty.post('api/oaths-rv').then(({
                    data
                }) => {
                    this.reportData[251].cr = data
                })

                atty.post('api/atip-cr').then(({
                    data
                }) => {
                    this.reportData[255].cr = data
                })

                atty.post('api/atip-cv').then(({
                    data
                }) => {
                    this.reportData[255].cv = data
                })

                atty.post('api/atip-adm1').then(({
                    data
                }) => {
                    this.reportData[255].adm1 = data
                })

                atty.post('api/atip-adm2').then(({
                    data
                }) => {
                    this.reportData[255].adm2 = data
                })

                atty.post('api/atip-adm3').then(({
                    data
                }) => {
                    this.reportData[255].adm3 = data
                })

                atty.post('api/favorable-atip').then(({
                    data
                }) => {
                    this.reportData[261].cr = data
                })

                atty.post('api/unfavorable-atip').then(({
                    data
                }) => {
                    this.reportData[262].cr = data
                })

                atty.post('api/others-atip').then(({
                    data
                }) => {
                    this.reportData[263].cr = data
                })

                atty.post('api/oaths-atip').then(({
                    data
                }) => {
                    this.reportData[271].cr = data
                })

                atty.post('api/cdd-cr').then(({
                    data
                }) => {
                    this.reportData[275].cr = data
                })

                atty.post('api/cdd-cv').then(({
                    data
                }) => {
                    this.reportData[275].cv = data
                })

                atty.post('api/cdd-adm1').then(({
                    data
                }) => {
                    this.reportData[275].adm1 = data
                })

                atty.post('api/cdd-adm2').then(({
                    data
                }) => {
                    this.reportData[275].adm2 = data
                })

                atty.post('api/cdd-adm3').then(({
                    data
                }) => {
                    this.reportData[275].adm3 = data
                })

                atty.post('api/favorable-cdd').then(({
                    data
                }) => {
                    this.reportData[281].cr = data
                })

                atty.post('api/unfavorable-cdd').then(({
                    data
                }) => {
                    this.reportData[282].cr = data
                })

                atty.post('api/others-cdd').then(({
                    data
                }) => {
                    this.reportData[283].cr = data
                })

                atty.post('api/oaths-cdd').then(({
                    data
                }) => {
                    this.reportData[291].cr = data
                })

                atty.post('api/ac-cr').then(({
                    data
                }) => {
                    this.reportData[315].cr = data
                })

                atty.post('api/ac-cv').then(({
                    data
                }) => {
                    this.reportData[315].cv = data
                })

                atty.post('api/ac-adm1').then(({
                    data
                }) => {
                    this.reportData[315].adm1 = data
                })

                atty.post('api/ac-adm2').then(({
                    data
                }) => {
                    this.reportData[315].adm2 = data
                })

                atty.post('api/ac-adm3').then(({
                    data
                }) => {
                    this.reportData[315].adm3 = data
                })

                atty.post('api/favorable-ac').then(({
                    data
                }) => {
                    this.reportData[321].cr = data
                })

                atty.post('api/unfavorable-ac').then(({
                    data
                }) => {
                    this.reportData[322].cr = data
                })

                atty.post('api/others-ac').then(({
                    data
                }) => {
                    this.reportData[323].cr = data
                })

                atty.post('api/oaths-ac').then(({
                    data
                }) => {
                    this.reportData[331].cr = data
                })

                atty.post('api/re-cr').then(({
                    data
                }) => {
                    this.reportData[335].cr = data
                })

                atty.post('api/re-cv').then(({
                    data
                }) => {
                    this.reportData[335].cv = data
                })

                atty.post('api/re-adm1').then(({
                    data
                }) => {
                    this.reportData[335].adm1 = data
                })

                atty.post('api/re-adm2').then(({
                    data
                }) => {
                    this.reportData[335].adm2 = data
                })

                atty.post('api/re-adm3').then(({
                    data
                }) => {
                    this.reportData[335].adm3 = data
                })

                atty.post('api/favorable-re').then(({
                    data
                }) => {
                    this.reportData[341].cr = data
                })

                atty.post('api/unfavorable-re').then(({
                    data
                }) => {
                    this.reportData[342].cr = data
                })

                atty.post('api/others-re').then(({
                    data
                }) => {
                    this.reportData[343].cr = data
                })

                atty.post('api/oaths-re').then(({
                    data
                }) => {
                    this.reportData[351].cr = data
                })

                atty.post('api/nf-cr').then(({
                    data
                }) => {
                    this.reportData[355].cr = data
                })

                atty.post('api/nf-cv').then(({
                    data
                }) => {
                    this.reportData[355].cv = data
                })

                atty.post('api/nf-adm1').then(({
                    data
                }) => {
                    this.reportData[355].adm1 = data
                })

                atty.post('api/nf-adm2').then(({
                    data
                }) => {
                    this.reportData[355].adm2 = data
                })

                atty.post('api/nf-adm3').then(({
                    data
                }) => {
                    this.reportData[355].adm3 = data
                })

                atty.post('api/favorable-nf').then(({
                    data
                }) => {
                    this.reportData[361].cr = data
                })

                atty.post('api/unfavorable-nf').then(({
                    data
                }) => {
                    this.reportData[362].cr = data
                })

                atty.post('api/others-nf').then(({
                    data
                }) => {
                    this.reportData[363].cr = data
                })

                atty.post('api/oaths-nf').then(({
                    data
                }) => {
                    this.reportData[371].cr = data
                })

                atty.post('api/vw-cr').then(({
                    data
                }) => {
                    this.reportData[20].cr = data
                })

                atty.post('api/vw-cv').then(({
                    data
                }) => {
                    this.reportData[20].cv = data
                })

                atty.post('api/vw-adm1').then(({
                    data
                }) => {
                    this.reportData[20].adm1 = data
                })

                atty.post('api/vw-adm2').then(({
                    data
                }) => {
                    this.reportData[20].adm2 = data
                })

                atty.post('api/vw-adm3').then(({
                    data
                }) => {
                    this.reportData[20].adm3 = data
                })

                atty.post('api/terminated-vw').then(({
                    data
                }) => {
                    this.reportData[26].cr = data
                })

                atty.post('api/oaths-vw').then(({
                    data
                }) => {
                    this.reportData[29].cr = data
                })

                atty.post('api/vc-cr').then(({
                    data
                }) => {
                    this.reportData[31].cr = data
                })

                atty.post('api/vc-cv').then(({
                    data
                }) => {
                    this.reportData[31].cv = data
                })

                atty.post('api/vc-adm1').then(({
                    data
                }) => {
                    this.reportData[31].adm1 = data
                })

                atty.post('api/vc-adm2').then(({
                    data
                }) => {
                    this.reportData[31].adm2 = data
                })

                atty.post('api/vc-adm3').then(({
                    data
                }) => {
                    this.reportData[31].adm3 = data
                })

                atty.post('api/terminated-vc').then(({
                    data
                }) => {
                    this.reportData[37].cr = data
                })

                atty.post('api/oaths-vc').then(({
                    data
                }) => {
                    this.reportData[40].total = data
                    setTimeout(() => {
                        for(let i = 0; i < 375; i++) {
                            this.reportData[i].total = this.reportData[i].cv + this.reportData[i].cr + this.reportData[i].adm1 + this.reportData[i].adm2 + this.reportData[i].adm3
                        }
                        this.reportData[9].total = parseInt(this.reportData[6].total) + parseInt(this.reportData[7].total) + parseInt(this.reportData[8].total) || parseInt(0)
                        this.reportData[3].total = parseInt(this.reportData[0].total) + parseInt(this.reportData[2].total) || parseInt(0)
                        this.reportData[23].total = parseInt(this.reportData[20].total) + parseInt(this.reportData[22].total) || parseInt(0)
                        this.reportData[34].total = parseInt(this.reportData[31].total) + parseInt(this.reportData[33].total) || parseInt(0)
                        this.reportData[45].total = parseInt(this.reportData[43].total) + parseInt(this.reportData[42].total) || parseInt(0)
                        this.reportData[58].total = parseInt(this.reportData[55].total) + parseInt(this.reportData[56].total) || parseInt(0)
                        this.reportData[64].total = parseInt(this.reportData[61].total) + parseInt(this.reportData[62].total) + parseInt(this.reportData[63].total) || parseInt(0)
                        this.reportData[78].total = parseInt(this.reportData[75].total) + parseInt(this.reportData[76].total) || parseInt(0)
                        this.reportData[84].total = parseInt(this.reportData[81].total) + parseInt(this.reportData[82].total) + parseInt(this.reportData[83].total) || parseInt(0)
                        this.reportData[98].total = parseInt(this.reportData[95].total) + parseInt(this.reportData[97].total) || parseInt(0)
                        this.reportData[104].total = parseInt(this.reportData[101].total) + parseInt(this.reportData[103].total) + parseInt(this.reportData[103].total) || parseInt(0)
                        this.reportData[118].total = parseInt(this.reportData[115].total) + parseInt(this.reportData[116].total) || parseInt(0)
                        this.reportData[124].total = parseInt(this.reportData[121].total) + parseInt(this.reportData[122].total) + parseInt(this.reportData[123].total) || parseInt(0)
                        this.reportData[138].total = parseInt(this.reportData[135].total) + parseInt(this.reportData[137].total) || parseInt(0)
                        this.reportData[144].total = parseInt(this.reportData[141].total) + parseInt(this.reportData[142].total) + parseInt(this.reportData[143].total) || parseInt(0)
                        this.reportData[158].total = parseInt(this.reportData[155].total) + parseInt(this.reportData[157].total) || parseInt(0)
                        this.reportData[164].total = parseInt(this.reportData[161].total) + parseInt(this.reportData[162].total) + parseInt(this.reportData[163].total) || parseInt(0)
                        this.reportData[178].total = parseInt(this.reportData[175].total) + parseInt(this.reportData[177].total) || parseInt(0)
                        this.reportData[184].total = parseInt(this.reportData[181].total) + parseInt(this.reportData[182].total) + parseInt(this.reportData[183].total) || parseInt(0)
                        this.reportData[198].total = parseInt(this.reportData[195].total) + parseInt(this.reportData[197].total) || parseInt(0)
                        this.reportData[204].total = parseInt(this.reportData[201].total) + parseInt(this.reportData[202].total) + parseInt(this.reportData[203].total) || parseInt(0)
                        this.reportData[218].total = parseInt(this.reportData[215].total) + parseInt(this.reportData[217].total) || parseInt(0)
                        this.reportData[224].total = parseInt(this.reportData[221].total) + parseInt(this.reportData[222].total) + parseInt(this.reportData[223].total) || parseInt(0)
                        this.reportData[238].total = parseInt(this.reportData[235].total) + parseInt(this.reportData[237].total) || parseInt(0)
                        this.reportData[244].total = parseInt(this.reportData[241].total) + parseInt(this.reportData[242].total) + parseInt(this.reportData[243].total) || parseInt(0)
                        this.reportData[258].total = parseInt(this.reportData[255].total) + parseInt(this.reportData[257].total) || parseInt(0)
                        this.reportData[264].total = parseInt(this.reportData[261].total) + parseInt(this.reportData[262].total) + parseInt(this.reportData[263].total) || parseInt(0)
                        this.reportData[278].total = parseInt(this.reportData[275].total) + parseInt(this.reportData[277].total) || parseInt(0)
                        this.reportData[284].total = parseInt(this.reportData[281].total) + parseInt(this.reportData[282].total) + parseInt(this.reportData[283].total) || parseInt(0)
                        this.reportData[298].total = parseInt(this.reportData[295].total) + parseInt(this.reportData[297].total) || parseInt(0)
                        this.reportData[304].total = parseInt(this.reportData[301].total) + parseInt(this.reportData[302].total) + parseInt(this.reportData[303].total) || parseInt(0)
                        this.reportData[318].total = parseInt(this.reportData[315].total) + parseInt(this.reportData[317].total) || parseInt(0)
                        this.reportData[324].total = parseInt(this.reportData[321].total) + parseInt(this.reportData[322].total) + parseInt(this.reportData[323].total) || parseInt(0)
                        this.reportData[338].total = parseInt(this.reportData[335].total) + parseInt(this.reportData[337].total) || parseInt(0)
                        this.reportData[344].total = parseInt(this.reportData[341].total) + parseInt(this.reportData[342].total) + parseInt(this.reportData[343].total) || parseInt(0)
                        this.reportData[358].total = parseInt(this.reportData[355].total) + parseInt(this.reportData[357].total) || parseInt(0)
                        this.reportData[364].total = parseInt(this.reportData[361].total) + parseInt(this.reportData[362].total) + parseInt(this.reportData[363].total) || parseInt(0)
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
                window.onload = function(){
                    var tableCont = document.querySelector('#scrollable')
                    /**
                     * scroll handle
                     * @param {event} e -- scroll event
                     */
                    function scrollHandle (e){
                        var scrollTop = this.scrollTop;
                        this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
                    }
                    tableCont.addEventListener('scroll',scrollHandle)
                }
            },
            loadReportData() {
                if (this.$gate.isAdminAndSuperAdmin()) {
                    axios.get('api/individual-report-cicl').then(({
                        data
                    }) => {
                        for(let property in this.reportData) {
                            for(let i in data) {
                                if(this.reportData[property].section == data[i].section && this.reportData[property].key_indicators_of_performance == data[i].key_indicators_of_performance || this.reportData[property].title == data[i].key_indicators_of_performance) {
                                    this.reportData[property].item = data[i].id
                                    this.reportData[property].total = data[i].total
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
                }
            },
            sortSection(section) {
                if(this.sortBy === 'All') {
                    return section
                } else if(this.sortBy === 'CICL') {
                    return 'A. CHILDREN IN CONFLICT WITH THE LAW (CICL)'
                } else if(this.sortBy === 'R.A. 9262 - Women') {
                    return 'B.1. Victims of R.A. 9262 (VAWC) - Women'
                } else if(this.sortBy === 'R.A. 9262 - Children') {
                    return 'B.2. Victims of R.A. 9262 (VAWC) - Children'
                } else if(this.sortBy === 'Women Client') {
                    return 'C. WOMEN CLIENT - Other Cases'
                } else if(this.sortBy === 'Indigenous Group') {
                    return 'D. INDIGENOUS GROUP'
                } else if(this.sortBy === 'Person with Disability') {
                    return 'E. PERSON WITH DISABILITY (PWD)'
                } else if(this.sortBy === 'Urban Poor') {
                    return 'F. URBAN POOR'
                } else if(this.sortBy === 'Rural Poor') {
                    return 'G. RURAL POOR'
                } else if(this.sortBy === 'OFW Land Based') {
                    return 'H.1. OVERSEAS FILIPINO WORKER (OFW)~LAND-BASED)'
                } else if(this.sortBy === 'OFW Sea Based') {
                    return 'H.2. OVERSEAS FILIPINO WORKER (OFW)~SEA-BASED)'
                } else if(this.sortBy === 'Senior Citizen') {
                    return 'I. SENIOR CITIZEN'
                } else if(this.sortBy === 'R.A. 9372 (Human Security Act)') {
                    return 'J. R.A. 9372 (HUMAN SECURITY ACT)'
                } else if(this.sortBy === 'R.A. 9745 (Anti-Torture Law)') {
                    return 'K. R.A. 9745 (ANTI-TORTURE LAW)'
                } else if(this.sortBy === 'Rape Victims') {
                    return 'L. RAPE VICTIMS'
                } else if(this.sortBy === 'R.A. 9208 (Anti-Trafficking)') {
                    return 'M. R.A. 9208 (ANTI-TRAFFICKING IN PERSONS ACT OF 2003)'
                } else if(this.sortBy === 'R.A. 9165 (Comprehesive Drugs)') {
                    return 'N. R.A. 9165 (COMPREHENSIVE DANGEROUS DRUGS ACT OF 2012)'
                } else if(this.sortBy === 'Law Enforcement Officer') {
                    return 'O. LAW ENFORECEMENT OFFICER WHO WERE SUED IN THE PERFORMANCE OF THEIR DUTIES INVOLVING DRUG RELATED CASES'
                } else if(this.sortBy === 'Agrarian Cases') {
                    return 'P. AGRARIAN CASES'
                } else if(this.sortBy === 'Refugees/Evacuees') {
                    return 'Q. REFUGEES / EVACUEES  (As per MOA with the UNHCR)'
                } else if(this.sortBy === 'Non-filipino Citizens') {
                    return 'R. NON-FILIPINO CITIZENS'
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
                    let beforePrint = function() {
                    document.querySelector('#sticky').classList.remove('sticky')
                    document.querySelector('#scrollable').classList.remove('scroll')
                    document.querySelector('#scrollable').classList.remove('cuz')
                }

                let afterPrint = function() {
                    document.querySelector('#sticky').classList.add('sticky')
                    document.querySelector('#scrollable').classList.add('scroll')
                    document.querySelector('#scrollable').classList.add('cuz')
                }

                if (window.matchMedia) {
                    let mediaQueryList = window.matchMedia('print');
                    mediaQueryList.addListener(function(mql) {
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
                    this.reportData.post('api/individual-report-cicl').then(() => {
                    toast({
                        type: 'success',
                        title: 'Your Report on CICL was Updated Successfully.'
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
            cancel() {
                this.isEditable = false
                this.reportData.reset()
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
            this.loadReportData()
            if(this.$gate.isAdminAndSuperAdmin()) {
                document.querySelector(".sidebar-mini").className += ' sidebar-collapse'
                this.lawyer = window.user.firstname + ' ' + window.user.lastname
            }
            Fire.$on('Refresh', () => {
                this.loadReportData()
                this.isEditable = false
            });
        }
    }
</script>
