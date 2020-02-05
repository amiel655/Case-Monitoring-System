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
                        INQUEST REPORT <br>
                        (For the Month of {{selectedMonth | month}} {{presentYear}})
                    </strong></p>
                </div>
                <div class="sticky" id="sticky">
                <h3 class="text-center hideInPrint">
                <i class="material-icons">
                        assignment
                </i> Inquest Report</h3>
                    <span class="text-center showInPrint">For the Month of {{selectedMonth | month}}</span><br>
                    <p class="text-left showInPrint">Inquest Lawyer: {{lawyer}}</p>
                    <p class="text-left showInPrint">Inquest Assistant: __________________________________________</p>
                    <p class="text-left showInPrint">Schedule of Duty: __________________________________________</p>
                    <br>
                        <div class="col-md-12 pt-2 pb-3">
                            <button type="button" class="btn btn-success edit-b" v-show="isEditable && selectedMonth.length !== 0" @click="cancel"><strong>Cancel</strong></button>
                            <button type="submit" class="btn btn-success edit-b" v-show="isEditable && selectedMonth.length !== 0" @click="submitReport"><strong>Update Report<i class="material-icons md-18">update</i></strong></button>
                            <button type="button" class="btn btn-success edit-b" v-show="!isEditable && selectedMonth.length !== 0" @click="isEditable = true"><strong>Edit Report<i class="material-icons md-18">edit</i></strong></button>
                            <button type="button" class="btn btn-success edit-b" v-show="!isEditable && selectedMonth.length !== 0" @click="exportPrint"><strong>Save / Print Report<i class="material-icons md-18">print</i></strong></button>
                        </div>

                        <div class="col-md-12 form-inline hideInPrint">
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
                                    <a class="dropdown-item" v-for="atty in attorneys" v-if="atty.type !== 'Staff'"
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
        <div class="pt-4">
            <form @submit.prevent="updateReport">
                <table class="table table-bordered" id="scrollable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name of Client/s</th>
                            <th scope="col">Gender/Sex</th>
                            <th scope="col">Address</th>
                            <th scope="col">Contact No.</th>
                            <th scope="col">Legal Advice</th>
                            <th scope="col">Custodial /Inquest Investigation</th>
                            <th scope="col">Precinct/Jail Facility</th>
                            <th scope="col">Subject Matter</th>
                            <th scope="col">Time of Call</th>
                            <th scope="col">Time Attended To</th>
                        </tr>
                    </thead>
                    <tbody v-for="data in this.reportData" :key="data.id">
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.name">{{ data.client_name }}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.gender">{{ data.client_gender }}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.address">{{ data.client_address }}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.contact" @keypress="validateNumber($event)">{{ data.client_contact }}</td>
                            <td class="text-center"><span v-show="isEditable"><input type="text" class="form-control" v-model="data.legal_advice"></span><span v-show="!isEditable">{{ data.legal_advice }}</span></td>
                            <td class="text-center"><span v-show="isEditable"><input type="text" class="form-control" v-model="data.custodial"></span><span v-show="!isEditable">{{ data.custodial }}</span></td>
                            <td class="text-center"><span v-show="isEditable"><input type="text" class="form-control" v-model="data.precint"></span><span v-show="!isEditable">{{ data.precint }}</span></td>
                            <td class="text-center"><span v-show="isEditable"><input type="text" class="form-control" v-model="data.subject"></span><span v-show="!isEditable">{{ data.subject }}</span></td>
                            <td class="text-center"><span v-show="isEditable"><input type="number" class="form-control" v-model="data.time_call" @keypress="validateNumber($event)"></span><span v-show="!isEditable">{{ data.time_call }}</span></td>
                            <td class="text-center"><span v-show="isEditable"><input type="number" class="form-control" v-model="data.time_attend" @keypress="validateNumber($event)"></span><span v-show="!isEditable">{{ data.time_attend }}</span></td>
                    </tbody>
                </table></form></div>
                 <div class="row pt-4 text-center showInPrint">
                    <div class="col-md-6 p-3 mt-3">
                        <p class="pt-4 text-center" style="margin: 0 auto; width: 50%; border-top: 1px solid #000">INQUEST ASSISTANT</p>
                    </div>
                     <div class="col-md-6 p-3 mt-3">
                        <h4 class="pt-2 text-center"><strong>Atty.  {{lawyer}}</strong></h4>
                        <p class="text-center" style="margin: 0 auto; width: 50%; border-top: 1px solid #000">INQUEST LAWYER</p>
                    </div>
                 </div>
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
                presentYear: (new Date()).getFullYear(),
                presentMonth: (new Date()).getMonth(),
                presentDay: (new Date()).getDay(),
                isEditable: false,
                lawyer: '',
                selectedMonth: '',
                attorneys: {},
                monthLabels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
                reportData: [
                    { id: '', client_name: '', client_gender: '', client_address: '',client_contact: '', legal_advice: '', custodial: '', precint: '', subject: '', time_call: '', time_attend: '',},
                ]
            }
        },
        methods: {
            loadReports(name) {
                this.reportData =  [
                    { id: '', client_name: '', client_gender: '', client_address: '',client_contact: '', legal_advice: '', custodial: '', precint: '', subject: '', time_call: '', time_attend: '',},
                ]
                let report = new Form({
                    name: name,
                    date: this.selectedMonth
                })

                for (let i = 0; i < this.reportData.length; i++) {
                    this.reportData[i].attorney = name
                    this.reportData[i].report_month = this.selectedMonth

                }

                report.post('api/inquest-reports').then(({
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
            // loadReportData() {
            //     if (this.$gate.isAdminAndSuperAdmin()) {
            //         axios.get('api/inquest-report').then(({
            //             data
            //         }) => {
            //             for(let property in this.reportData) {
            //                 for(let i in data) {
            //                         this.reportData[property].item = data[i].id
            //                         this.reportData[property].name = data[i].name
            //                         this.reportData[property].gender = data[i].gender
            //                         this.reportData[property].address = data[i].address
            //                         this.reportData[property].contact = data[i].contact
            //                         this.reportData[property].legal_advice = data[i].legal_advice
            //                         this.reportData[property].custodial = data[i].custodial
            //                         this.reportData[property].precint = data[i].precint
            //                         this.reportData[property].subject = data[i].subject
            //                         this.reportData[property].time_call = data[i].time_call
            //                         this.reportData[property].time_attend = data[i].time_attend
            //                     }
            //                 }
            //         })
            //     }
            // },
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
                    let data = new Form({
                    length: this.reportData.length, report: this.reportData
                })
                    data.post('api/inquest-report').then(() => {
                    toast({
                        type: 'success',
                        title: 'Your Inquest Report was Updated Successfully.'
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
