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
                <h3 class="text-center">
                    <i class="material-icons">
                        assignment
                    </i> Monthly Inventory of Cases </h3>

                    <div class="form-inline">
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
                <br>
                <h3>A. Criminal</h3>
                <table class="table table-bordered table-responsive hor" id="scrollable">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th scope="col">ITEM NO.</th>
                            <th scope="col">CONTROL NO.</th>
                            <th scope="col">PARTY REPRESENTED</th>
                            <th scope="col">GENDER</th>
                            <th scope="col">TITLE OF THE CASE</th>
                            <th scope="col">COURT/BODY</th>
                            <th scope="col">CASE NO.</th>
                            <th scope="col">CAUSE OF ACTION</th>
                            <th scope="col">STATUS OF THE CASE</th>
                            <th scope="col">LAST ACTION TAKEN.</th>
                            <th scope="col">CAUSE OF TERMINATION.</th>
                            <th scope="col">DATE OF TERMINATION</th>
                        </tr>
                    </thead>
                    <tbody v-for="criminals in this.criminal" :key="criminals.id">
                        <tr>
                            <td class="text-center">{{criminals.id}}</td>
                            <td class="text-center">{{criminals.control_num}}</td>
                            <td class="text-center">{{criminals.client_name}}</td>
                            <td class="text-center">{{criminals.client_gender}}</td>
                            <td class="text-center">{{criminals.case_title}}</td>
                            <td class="text-center">{{criminals.court}}</td>
                            <td class="text-center">{{criminals.case_no}}</td>
                            <td class="text-center">{{criminals.case_of_action}}</td>
                            <td class="text-center">
                            <span v-show="criminals.status !== 'Pending' && criminals.status !== 'Arraignment' && criminals.status !== 'Pre-Trial' && criminals.status !== 'Prosecution Evidence' && criminals.status !== 'Defense Evidence'">Terminated</span>
                            <span v-show="criminals.status === 'Pending' || criminals.status === 'Arraignment' || criminals.status === 'Pre-Trial' || criminals.status === 'Prosecution Evidence' || criminals.status === 'Defense Evidence'">{{criminals.status}}</span>
                            </td>
                            <td class="text-center">{{criminals.case_summary}}</td>
                            <td class="text-center"><span v-show="criminals.status !== 'Pending' && criminals.status !== 'Arraignment' && criminals.status !== 'Pre-Trial' && criminals.status !== 'Prosecution Evidence' && criminals.status !== 'Defense Evidence'">{{criminals.status}}</span></td>
                            <td class="text-center"><span v-show="criminals.status !== 'Pending' && criminals.status !== 'Arraignment' && criminals.status !== 'Pre-Trial' && criminals.status !== 'Prosecution Evidence' && criminals.status !== 'Defense Evidence'">{{criminals.updated_at}}</span></td>
                            </tr>
                    </tbody>
                </table>

                <br>
                <h3>B. Civil</h3>
                <table class="table table-bordered table-responsive hor" id="scrollable">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th scope="col">ITEM NO.</th>
                            <th scope="col">CONTROL NO.</th>
                            <th scope="col">PARTY REPRESENTED</th>
                            <th scope="col">GENDER</th>
                            <th scope="col">TITLE OF THE CASE</th>
                            <th scope="col">COURT/BODY</th>
                            <th scope="col">CASE NO.</th>
                            <th scope="col">CAUSE OF ACTION</th>
                            <th scope="col">STATUS OF THE CASE</th>
                            <th scope="col">LAST ACTION TAKEN.</th>
                            <th scope="col">CAUSE OF TERMINATION.</th>
                            <th scope="col">DATE OF TERMINATION</th>
                        </tr>
                    </thead>
                    <tbody v-for="civils in this.civil" :key="civils.id">
                        <tr>
                            <td class="text-center">{{civils.id}}</td>
                            <td class="text-center">{{civils.control_num}}</td>
                            <td class="text-center">{{civils.client_name}}</td>
                            <td class="text-center">{{civils.client_gender}}</td>
                            <td class="text-center">{{civils.case_title}}</td>
                            <td class="text-center">{{civils.court}}</td>
                            <td class="text-center">{{civils.case_no}}</td>
                            <td class="text-center">{{civils.case_of_action}}</td>
                            <td class="text-center">
                            <span v-show="civils.status !== 'Pending' && civils.status !== 'Arraignment' && civils.status !== 'Pre-Trial' && civils.status !== 'Prosecution Evidence' && civils.status !== 'Defense Evidence'">Terminated</span>
                            <span v-show="civils.status === 'Pending' || civils.status === 'Arraignment' || civils.status === 'Pre-Trial' || civils.status === 'Prosecution Evidence' || civils.status === 'Defense Evidence'">{{civils.status}}</span>
                            </td>
                            <td class="text-center">{{civils.case_summary}}</td>
                            <td class="text-center"><span v-show="civils.status !== 'Pending' && civils.status !== 'Arraignment' && civils.status !== 'Pre-Trial' && civils.status !== 'Prosecution Evidence' && civils.status !== 'Defense Evidence'">{{civils.status}}</span></td>
                            <td class="text-center"><span v-show="civils.status !== 'Pending' && civils.status !== 'Arraignment' && civils.status !== 'Pre-Trial' && civils.status !== 'Prosecution Evidence' && civils.status !== 'Defense Evidence'">{{civils.updated_at}}</span></td>
                            </tr>
                    </tbody>
                </table>

                <br>
                <h3>C. Labor</h3>
                <table class="table table-bordered table-responsive hor" id="scrollable">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th scope="col">ITEM NO.</th>
                            <th scope="col">CONTROL NO.</th>
                            <th scope="col">PARTY REPRESENTED</th>
                            <th scope="col">GENDER</th>
                            <th scope="col">TITLE OF THE CASE</th>
                            <th scope="col">COURT/BODY</th>
                            <th scope="col">CASE NO.</th>
                            <th scope="col">CAUSE OF ACTION</th>
                            <th scope="col">STATUS OF THE CASE</th>
                            <th scope="col">LAST ACTION TAKEN.</th>
                            <th scope="col">CAUSE OF TERMINATION.</th>
                            <th scope="col">DATE OF TERMINATION</th>
                        </tr>
                    </thead>
                    <tbody v-for="labors in this.labor" :key="labors.id">
                        <tr>
                            <td class="text-center">{{labors.id}}</td>
                            <td class="text-center">{{labors.control_num}}</td>
                            <td class="text-center">{{labors.client_name}}</td>
                            <td class="text-center">{{labors.client_gender}}</td>
                            <td class="text-center">{{labors.case_title}}</td>
                            <td class="text-center">{{labors.court}}</td>
                            <td class="text-center">{{labors.case_no}}</td>
                            <td class="text-center">{{labors.case_of_action}}</td>
                            <td class="text-center">
                            <span v-show="labors.status !== 'Pending' && labors.status !== 'Arraignment' && labors.status !== 'Pre-Trial' && labors.status !== 'Prosecution Evidence' && labors.status !== 'Defense Evidence'">Terminated</span>
                            <span v-show="labors.status === 'Pending' || labors.status === 'Arraignment' || labors.status === 'Pre-Trial' || labors.status === 'Prosecution Evidence' || labors.status === 'Defense Evidence'">{{labors.status}}</span>
                            </td>
                            <td class="text-center">{{labors.case_summary}}</td>
                            <td class="text-center"><span v-show="labors.status !== 'Pending' && labors.status !== 'Arraignment' && labors.status !== 'Pre-Trial' && labors.status !== 'Prosecution Evidence' && labors.status !== 'Defense Evidence'">{{labors.status}}</span></td>
                            <td class="text-center"><span v-show="labors.status !== 'Pending' && labors.status !== 'Arraignment' && labors.status !== 'Pre-Trial' && labors.status !== 'Prosecution Evidence' && labors.status !== 'Defense Evidence'">{{labors.updated_at}}</span></td>
                            </tr>
                    </tbody>
                </table>

                <br>
                <h3>D. Administrative Case Proper</h3>
                <table class="table table-bordered table-responsive hor" id="scrollable">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th scope="col">ITEM NO.</th>
                            <th scope="col">CONTROL NO.</th>
                            <th scope="col">PARTY REPRESENTED</th>
                            <th scope="col">GENDER</th>
                            <th scope="col">TITLE OF THE CASE</th>
                            <th scope="col">COURT/BODY</th>
                            <th scope="col">CASE NO.</th>
                            <th scope="col">CAUSE OF ACTION</th>
                            <th scope="col">STATUS OF THE CASE</th>
                            <th scope="col">LAST ACTION TAKEN.</th>
                            <th scope="col">CAUSE OF TERMINATION.</th>
                            <th scope="col">DATE OF TERMINATION</th>
                        </tr>
                    </thead>
                    <tbody v-for="adms in this.adm" :key="adms.id">
                        <tr>
                            <td class="text-center">{{adms.id}}</td>
                            <td class="text-center">{{adms.control_num}}</td>
                            <td class="text-center">{{adms.client_name}}</td>
                            <td class="text-center">{{adms.client_gender}}</td>
                            <td class="text-center">{{adms.case_title}}</td>
                            <td class="text-center">{{adms.court}}</td>
                            <td class="text-center">{{adms.case_no}}</td>
                            <td class="text-center">{{adms.case_of_action}}</td>
                            <td class="text-center">
                            <span v-show="adms.status !== 'Pending' && adms.status !== 'Arraignment' && adms.status !== 'Pre-Trial' && adms.status !== 'Prosecution Evidence' && adms.status !== 'Defense Evidence'">Terminated</span>
                            <span v-show="adms.status === 'Pending' || adms.status === 'Arraignment' || adms.status === 'Pre-Trial' || adms.status === 'Prosecution Evidence' || adms.status === 'Defense Evidence'">{{adms.status}}</span>
                            </td>
                            <td class="text-center">{{adms.case_summary}}</td>
                            <td class="text-center"><span v-show="adms.status !== 'Pending' && adms.status !== 'Arraignment' && adms.status !== 'Pre-Trial' && adms.status !== 'Prosecution Evidence' && adms.status !== 'Defense Evidence'">{{adms.status}}</span></td>
                            <td class="text-center"><span v-show="adms.status !== 'Pending' && adms.status !== 'Arraignment' && adms.status !== 'Pre-Trial' && adms.status !== 'Prosecution Evidence' && adms.status !== 'Defense Evidence'">{{adms.updated_at}}</span></td>
                            </tr>
                    </tbody>
                </table><br><br>
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
                criminal: {},
                civil: {},
                labor: {},
                adm: {},
                lawyer: '',
                selectedMonth: '',
                attorneys: {},
                monthLabels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            }
        },
        methods: {
            loadReports(name) {
                let report = new Form({
                    name: name,
                    date: this.selectedMonth
                })



                report.post('api/monthly-inventory-cases-criminal').then(({
                    data
                }) => {
                this.criminal = data
                })

                report.post('api/monthly-inventory-cases-civil').then(({
                    data
                }) => {
                this.civil = data
                })

                report.post('api/monthly-inventory-cases-labor').then(({
                    data
                }) => {
                this.labor = data
                })

                report.post('api/monthly-inventory-cases-adm').then(({
                    data
                }) => {
                this.adm = data
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
            //         axios.get('api/monthly-inventory-cases').then(({
            //             data
            //         }) => {
            //             for(let property in this.reportData) {
            //                 for(let i in data) {
            //                     if(this.reportData[property].section == data[i].section) {
            //                         this.reportData[property].item = data[i].id
            //                         this.reportData[property].item_no = data[i].item_no
            //                         this.reportData[property].control_no = data[i].control_no
            //                         this.reportData[property].party_represented = data[i].party_represented
            //                         this.reportData[property].gender = data[i].gender
            //                         this.reportData[property].title_case = data[i].title_case
            //                         this.reportData[property].court_body = data[i].court_body
            //                         this.reportData[property].case_no = data[i].case_no
            //                         this.reportData[property].cause_action = data[i].cause_action
            //                         this.reportData[property].status_case = data[i].status_case
            //                         this.reportData[property].last_action_taken = data[i].last_action_taken
            //                         this.reportData[property].cause_termination = data[i].cause_termination
            //                         this.reportData[property].date_termination = data[i].date_termination
            //                     }
            //                 }
            //             }
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
                    this.reportData.post('api/monthly-inventory-cases').then(() => {
                    toast({
                        type: 'success',
                        title: 'Your Report in Monthly Inventory Case was Updated Successfully.'
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
