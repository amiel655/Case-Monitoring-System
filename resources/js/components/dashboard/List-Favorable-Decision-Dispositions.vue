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
            <div class="col-md-12 card card-border-shadow p-3">
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
                        LIST OF FAVORABLE DECISION / DISPOSITIONS <br>
                        (For the Month of {{selectedMonth | month}} {{presentYear}})
                    </strong></p>
                </div>
                <div class="sticky" id="sticky">
                <h3 class="text-center hideInPrint">
                    <i class="material-icons">
                        assignment
                    </i> List of Favorable Decisions/Dispositions </h3>

                        <div class="col-md-12 pt-2 pb-3 hideInPrint">
                            <button type="button" class="btn btn-success edit-b" v-show="isEditable && selectedMonth.length !== 0" @click="cancel"><strong>Cancel</strong></button>
                            <button type="submit" class="btn btn-success edit-b" v-show="isEditable && selectedMonth.length !== 0" @click="submitReport"><strong>Update Report<i class="material-icons md-18">update</i></strong></button>
                            <button type="button" class="btn btn-success edit-b" v-show="!isEditable && selectedMonth.length !== 0" @click="isEditable = true"><strong>Edit Report<i class="material-icons md-18">edit</i></strong></button>
                            <button type="button" class="btn btn-success edit-b" v-show="!isEditable && selectedMonth.length !== 0" @click="exportPrint"><strong>Save / Print Report<i class="material-icons md-18">print</i></strong></button>
                        </div>

                        <div class="col-md-12 form-inline hideInPrint">
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
                            <th scope="col">Name of Client</th>
                            <th scope="col">Case Title</th>
                            <th scope="col">Docket No.</th>
                            <th scope="col">Place of Detention</th>
                            <th scope="col">Court</th>
                            <th scope="col">Nature of Case</th>
                            <th scope="col">Remarks</th>
                        </tr>
                    </thead>
                    <tbody v-for="data in this.reportData" :key="data.id">
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.name_client" >{{ data.client_name }}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.case_title">{{ data.case_title }}</td>
                            <td class="text-center"><span v-show="isEditable"><input type="text" class="form-control" v-model="data.docket_no"  @keypress="validateNumber($event)"></span><span v-show="!isEditable">{{ data.docket_no }}</span></td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.place_detention">{{ data.detention_place }}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.court">{{ data.court }}</td>
                            <td class="text-center"><input type="hidden" class="form-control" v-model="data.nature_case">{{ data.nature_case }}</td>
                            <td class="text-center"><span v-show="isEditable"><input type="text" class="form-control" v-model="data.remarks"></span><span v-show="!isEditable">{{ data.remarks }}</span></td>
                    </tbody>
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
                    { attorney: '', id: '', name_client: '', case_title: '', docket_no: '', detention_place: '',court: '', remarks: '',},
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

                report.post('api/list-favorable-decisions').then(({
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
            //         axios.get('api/list-favorable-decision').then(({
            //             data
            //         }) => {
            //             for(let property in this.reportData) {
            //                 for(let i in data) {
            //                         this.reportData[property].item = data[i].id
            //                         this.reportData[property].name_client = data[i].name_client
            //                         this.reportData[property].case_title = data[i].case_title
            //                         this.reportData[property].docket_no = data[i].docket_no
            //                         this.reportData[property].place_detention = data[i].place_detention
            //                         this.reportData[property].court = data[i].court
            //                         this.reportData[property].nature_case = data[i].nature_case
            //                         this.reportData[property].remarks = data[i].remarks
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
                    data.post('api/list-favorable-decision').then(() => {
                    toast({
                        type: 'success',
                        title: 'Your Report in Favorable Decision Disposition was Updated Successfully.'
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
