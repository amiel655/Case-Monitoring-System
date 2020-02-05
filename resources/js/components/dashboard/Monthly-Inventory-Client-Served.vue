<style>
@media print {
    @page {
        size: landscape;
        margin: 0;
    }
}
</style>
<template>
    <div class="pt-3 container-fluid">
        <!-- <div v-if="!$gate.isAdminAndSuperAdmin()">
            <not-found></not-found>
        </div> -->
        <div >
        <div class="row justify-content-center">
            <div class="card card-border-shadow p-3">
            <div class="stick" id="sticky">
                <h3 class="text-center">
                    <i class="material-icons">
                        assignment
                    </i> Monthly Inventory of Client Served </h3>
                       <div class="col-md-12 pt-2 pb-3">
                            <button type="button" class="btn btn-success edit-b" v-show="isEditable && selectedMonth.length !== 0" @click="cancel"><strong>Cancel</strong></button>
                            <button type="submit" class="btn btn-success edit-b" v-show="isEditable && selectedMonth.length !== 0" @click="submitReport"><strong>Update Report<i class="material-icons md-18">update</i></strong></button>
                            <button type="button" class="btn btn-success edit-b" v-show="!isEditable && selectedMonth.length !== 0" @click="isEditable = true"><strong>Edit Report<i class="material-icons md-18">edit</i></strong></button>
                        </div>
                        <div class="form-inline pb-3">
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
                    </div>
        <div class="scroll cuz" >
            <form @submit.prevent="updateReport">
                <table class="table table-bordered table-responsive hor" >
                    <thead class="thead-dark" id="scrollable">
                        <tr class="text-center">
                            <th scope="col" colspan="2">Name of Client/s</th>
                            <th scope="col"></th>
                            <th scope="col" colspan="4">Client's Information</th>
                            <th scope="col" colspan="8">Mandated Clients (pls. mark with “x")</th>
                            <th scope="col" colspan="3">Assistance Requested, (pls. mark with “x”)</th>
                            <th scope="col">Action Taken*</th>
                            <th scope="col" colspan="3">If Represented in Court (Regular , Limited , Provisional)</th>
                            <th scope="col">Nature of The Case 4</th>
                        </tr>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Age</th>
                            <th>Gender/Sex</th>
                            <th>Contact Nos.<br>If any</th>
                            <th>Email Address</th>
                            <th>CICL</th>
                            <th>Women</th>
                            <th>Indigenous Group</th>
                            <th>Person with Disability</th>
                            <th>Urban Poor</th>
                            <th>Rural Poor</th>
                            <th>Senior Citizen</th>
                            <th>OFW</th>
                            <th>Judicial1</th>
                            <th>Quasi-Judicial2</th>
                            <th>Non-Judicial3</th>
                            <th></th>
                            <th>Title of the Case</th>
                            <th>Case No.</th>
                            <th>Status of the Case</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody v-for="data in this.reportData" :key="data.id">
                            <td class="text-center">{{ data.id}}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.client_name" >{{ data.client_name}}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.client_address" >{{ data.client_address}}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.client_age" >{{ data.client_age}}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.client_gender" >{{ data.client_gender}}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.client_contact" >{{ data.client_contact}}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.client_email" >{{ data.client_email}}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.children_in_conflict" >{{ data.children_in_conflict}}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.class">
                            <span v-show="data.class === 'Women Client,Refugees/Evacuees,Senior Citizen' ||
                                          data.class === 'Women Client,Senior Citizen,Refugees/Evacuees' ||
                                          data.class === 'Senior Citizen,Women Client,Refugees/Evacuees' ||
                                          data.class === 'Refugees/Evacuees,Women Client,Senior Citizen' ||
                                          data.class === 'Refugees/Evacuees,Senior Citizen,Women Client' ||
                                          data.class === 'Senior Citizen,Refugees/Evacuees,Women Client' ||
                                          data.class === 'Women Client,Refugees/Evacuees' ||
                                          data.class === 'Refugees/Evacuees,Women Client' ||
                                          data.class === 'Senior Citizen,Women Client' ||
                                          data.class === 'Women Client,Senior Citizen' ||
                                          data.class === 'Women Client'">X</span><span
                                            v-show="data.class === '' && data.class === null"></span></td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.indigenous_group"><span
                                            v-show="data.indigenous_group !== null && data.indigenous_group !== ''">X</span><span
                                            v-show="data.indigenous_group === '' && data.indigenous_group === null"></span></td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.person_with_disability" ><span
                                            v-show="data.person_with_disability !== null && data.person_with_disability !== ''">X</span><span
                                            v-show="data.person_with_disability !== null && data.person_with_disability !== ''"></span></td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.urban_poor" ><span
                                            v-show="data.urban_poor !== null && data.urban_poor !== ''">X</span><span
                                            v-show="data.urban_poor !== null && data.urban_poor !== ''"></span></td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.rural_poor" ><span
                                            v-show="data.rural_poor !== null && data.rural_poor !== ''">X</span><span
                                            v-show="data.rural_poor !== null && data.rural_poor !== ''"></span></td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.class" ><span v-show="
                                          data.class === 'Senior Citizen,Refugees/Evacuees,Women Client' ||
                                          data.class === 'Senior Citizen,Women Client,Refugees/Evacuees' ||
                                          data.class === 'Women Client,Senior Citizen,Refugees/Evacuees' ||
                                          data.class === 'Refugees/Evacuees,Senior Citizen,Women Client' ||
                                          data.class === 'Refugees/Evacuees,Women Client,Senior Citizen' ||
                                          data.class === 'Women Client,Refugees/Evacuees,Senior Citizen' ||
                                          data.class === 'Senior Citizen,Refugees/Evacuees' ||
                                          data.class === 'Refugees/Evacuees,Senior Citizen' ||
                                          data.class === 'Women Client,Senior Citizen' ||
                                          data.class === 'Senior Citizen,Women Client' ||
                                          data.class === 'Senior Citizen'">X</span><span
                                            v-show="data.class === '' && data.class === null"></span></td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.ofw" ><span
                                            v-show="data.ofw !== null && data.ofw !== ''">X</span><span
                                            v-show="data.ofw !== null && data.ofw !== ''"></span></td>
                            <td class="text-center"><span v-show="isEditable"><input type="text" class="form-control" v-model="data.judicial"></span><span v-show="!isEditable">{{ data.judicial}}</span></td>
                            <td class="text-center"><span v-show="isEditable"><input type="text" class="form-control" v-model="data.quasi_judicial"></span><span v-show="!isEditable">{{ data.quasi_judicial}}</span></td>
                            <td class="text-center"><span v-show="isEditable"><input type="text" class="form-control" v-model="data.non_judicial"></span><span v-show="!isEditable">{{ data.non_judicial}}</span></td>
                            <td class="text-center"><span v-show="isEditable"><input type="text" class="form-control" v-model="data.action_taken"></span><span v-show="!isEditable">{{ data.action_taken}}</span></td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.case_title" >{{ data.case_title}}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.case_no" >{{ data.case_no}}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.status" >{{ data.status}}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.nature_case" >{{ data.nature_case}}</td>
                    </tbody>
                </table></form></div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import VueMonthlyPicker from 'vue-monthly-picker'
    export default {
        components: {
        VueMonthlyPicker
    },
        data() {
            return {
                isEditable: false,
                lawyer: '',
                selectedMonth: '',
                attorneys: {},
                monthLabels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
                reportData: [
                    { id: '', client_name: '', client_address: '', client_age: '', client_gender: '', client_contact: '', client_email: '', children_in_conflict: '', class: '', indigenous_group: '', person_with_disability: '', urban_poor: '', rural_poor: '', class: '', ofw: '', judicial: '', quasi_judicial: '', non_judicial: '', action_taken: '', case_title: '', case_no: '', status: '', nature_case: '',},
                ]
            }
        },
        methods: {
            loadReports(name) {
                let report = new Form({
                    name: name,
                    date: this.selectedMonth
                })

                for (let i = 0; i < this.reportData.length; i++) {
                    this.reportData[i].attorney = name
                    this.reportData[i].report_month = this.selectedMonth

                }

                report.post('api/monthly-inventory-served').then(({
                    data
                }) => {
                    if(data.length !== 0) {
                    this.reportData = data
                    for(let i = 0; i < data.length; i++) {
                        data[i].attorney = name
                        data[i].report_month = this.selectedMonth
                    }
                }
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
                    axios.get('api/monthly-inventory-client-serve').then(({
                        data
                    }) => {
                        for(let property in this.reportData) {
                            for(let i in data) {
                                    this.reportData[property].item = data[i].id
                                    this.reportData[property].item_no = data[i].item_no
                                    this.reportData[property].control_no = data[i].control_no
                                    this.reportData[property].party_represented = data[i].party_represented
                                    this.reportData[property].gender = data[i].gender
                                    this.reportData[property].title_case = data[i].title_case
                                    this.reportData[property].court_body = data[i].court_body
                                    this.reportData[property].case_no = data[i].case_no
                                    this.reportData[property].cause_action = data[i].cause_action
                                    this.reportData[property].status_case = data[i].status_case
                                    this.reportData[property].last_action_taken = data[i].last_action_taken
                                    this.reportData[property].cause_termination = data[i].cause_termination
                                    this.reportData[property].date_termination = data[i].date_termination
                                }
                            }
                    })
            },
            validateNumber(event) {
                if ((event.keyCode < 48 || event.keyCode > 57)) {
                    event.returnValue = false;
                }
            },
            exportPrint() {
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
            },
            updateReport() {
                this.$Progress.start()
                    let data = new Form({
                    length: this.reportData.length, report: this.reportData
                })
                    data.post('api/monthly-inventory-cases').then(() => {
                    toast({
                        type: 'success',
                        title: 'Your Report in Monthly Inventory Client Served was Updated Successfully.'
                    })
                    this.$Progress.finish()
                    Fire.$emit('Refresh')
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

            }
        },
        mounted() {
            axios.get('api/user').then(({
                data
            }) => {
                this.attorneys = data
            })
            this.loadScrollbar()

                document.querySelector(".sidebar-mini").className += ' sidebar-collapse'
                this.lawyer = window.user.firstname + ' ' + window.user.lastname
            Fire.$on('Refresh', () => {

                this.isEditable = false
            });
        }
    }
</script>
