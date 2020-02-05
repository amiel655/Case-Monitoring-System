<template>
    <div class="container-fluid">
        <div v-if="!$gate.isAdminAndSuperAdmin()">
            <not-found></not-found>
        </div>
        <div v-if="$gate.isAdminAndSuperAdmin()" class="row dashboard-sec-1 mt-3 pb-5">
            <div class="col-md-3 pt-5 d-md-none" id="dashboard-calendar">
                <h2>
                    <dashboard-icon></dashboard-icon> Dashboard
                </h2>
                <hr class="hr">
                <datepicker :disabled-dates="disabledFutureDates" :inline="true" v-model="dash_date" @input="convertDate()"></datepicker>
            </div>
            <div class="col-md-3 pt-3">
                <h2 class="d-none d-md-block">
                    <dashboard-icon></dashboard-icon> Dashboard
                </h2>
                <hr class="hr d-none d-md-block">
                <p class="pl-5 pt-5">As of this month you have</p>
                <span class="pl-5" style="font-size:70px">{{monthly.length}} <span style="font-size:30px" v-show="monthly.length <= 1">Case</span><span
                        style="font-size:30px" v-show="monthly.length > 1">Cases</span></span>
                <div class="pl-2 text-center"><a v-show="latestCase.length !== 0" :href="'cases/' + latestCase"><button
                            class="btn btn-sm btn-outline-success">View
                            Latest Case</button></a></div>
            </div>
            <div class="col-md-3 pt-5">
                <div class="pt-5 mt-4"></div>
                <h5>Weekly Case</h5><br>
                <canvas id="case-weekly" height="150" v-show="weekly.length !== 0"></canvas>
                <h4 class="pt-5" v-show="weekly.length === 0">No Case/s for this Weekly</h4>
            </div>
            <div class="col-md-3 pt-5">
                <h5>Case Segments According to Status</h5>
                <small>(Monthly)</small>
                <canvas id="case-segments" height="200" v-show="monthly.length !== 0"></canvas>
                <h4 class="pt-5" v-show="monthly.length === 0">No Case/s for this Month</h4>
            </div>
            <div class="col-md-3 pt-5 d-none d-md-block" id="dashboard-calendar">
                <datepicker :disabled-dates="disabledFutureDates" :inline="true" v-model="dash_date" @input="convertDate()"></datepicker>
            </div>
        </div>

        <div v-if="$gate.isAdminAndSuperAdmin()" class="row dashboard-sec-2 mt-2 pb-5 mb-4">
            <div class="col-md-4">
                <div class="mt-5 pt-2">
                    <h4>
                        <crime-icon></crime-icon> Most Crimes Recorded
                    </h4>
                    <ul class="list-group list-group-flush" v-for="(crime, index) in crimes.slice(0, 5)" :key="crime.id">
                        <li class="list-group-item crime-list">#{{ index + 1 }} <i>{{ crime | capitalize }}</i></li>
                    </ul>
                    <!-- <span class="pt-5 pl-5" v-show="crimes.length === 0">No Crimes Recorded for this Month</span> -->
                </div>
                <div class="mt-5">
                    <h4>
                        <nature-req-icon></nature-req-icon> Nature of Request
                    </h4>
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <router-link :to="{ path: 'clients'}" style="text-decoration: none; color: #fff">
                                    <div class="nature-request-card card m-3" @click="$parent.client_request = 'Legal Advice'">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">Legal Advice</div>
                                                <div class="col-md-6 text-right" style="font-size: 20px">{{ legalAdvice
                                                    }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>

                                 <router-link :to="{ path: 'clients'}" style="text-decoration: none; color: #fff">
                                <div class="nature-request-card card m-3" @click="$parent.client_request = 'Legal Documentation'">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">Legal Documentation</div>
                                            <div class="col-md-6 text-right" style="font-size: 20px">{{
                                                legalDocumentation }}</div>
                                        </div>
                                    </div>
                                </div>
                                 </router-link>

                                  <router-link :to="{ path: 'clients'}" style="text-decoration: none; color: #fff">
                                <div class="nature-request-card card m-3" @click="$parent.client_request = 'Representation in Court/Quasi-Judicial Bodies'">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">Court / Quasi-Judicial Bodies</div>
                                            <div class="col-md-6 text-right" style="font-size: 20px">{{ representation
                                                }}</div>
                                        </div>
                                    </div>
                                </div>
                                  </router-link>

                                   <router-link :to="{ path: 'clients'}" style="text-decoration: none; color: #fff">
                                <div class="nature-request-card card m-3" @click="$parent.client_request = 'Inquest/Legal Assistance'">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">Inquest / Legal Assistance</div>
                                            <div class="col-md-6 text-right" style="font-size: 20px">{{ inquest }}</div>
                                        </div>
                                    </div>
                                </div>
                                </router-link>
                            </div>
                            <div class="carousel-item">
                                 <router-link :to="{ path: 'clients'}" style="text-decoration: none; color: #fff">
                                <div class="nature-request-card1 card m-3" @click="$parent.client_request = 'Mediation/Concillation'">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">Mediation/ Concillation</div>
                                            <div class="col-md-6 text-right" style="font-size: 20px">{{ mediation }}</div>
                                        </div>
                                    </div>
                                </div>
                                 </router-link>

                                  <router-link :to="{ path: 'clients'}" style="text-decoration: none; color: #fff">
                                <div class="nature-request-card1 card m-3" @click="$parent.client_request = 'Administration of Oath'">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">Administration of Oath</div>
                                            <div class="col-md-6 text-right" style="font-size: 20px">{{ administration
                                                }}</div>
                                        </div>
                                    </div>
                                </div>
                                  </router-link>

                                   <router-link :to="{ path: 'clients'}" style="text-decoration: none; color: #fff">
                                <div class="nature-request-card1 card m-3" @click="$parent.client_request = 'Others'">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">Others</div>
                                            <div class="col-md-6 text-right" style="font-size: 20px">{{ others }}</div>
                                        </div>
                                    </div>
                                </div>
                                   </router-link>
                                <div class="nature-request-card card m-3" style="visibility: hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">Inquest / Legal Assistance</div>
                                            <div class="col-md-6 text-right"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 pt-5">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4" v-if="authUser.type === 'Admin'"></div>
                    <div class="col-md-4">
                        <div class="main-stats card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h1>
                                            <clients-icon width="50px" height="50px"></clients-icon>
                                        </h1>Clients
                                    </div>
                                    <div class="col-md-4 text-right" style="font-size: 20px">{{ clientsServed }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" v-if="authUser.type === 'Super Admin'">
                        <div class="main-stats card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h1>
                                            <users-icon width="50px" height="50px"></users-icon>
                                        </h1>Users
                                    </div>
                                    <div class="col-md-4 text-right" style="font-size: 20px">{{ users }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 pt-5">
                        <h5 class="text-center">Cases Data from the Past Year and Present Year</h5>
                        <canvas id="case-yearly" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        Bar
    } from 'vue-chartjs';
    import Datepicker from 'vuejs-datepicker';
    export default {
        extends: Bar,
        components: {
            Datepicker
        },
        data() {
            return {
                dash_date: new Date(),
                disabledFutureDates: {
                    from: new Date()
                },
                latestCase: '',
                weekly: {},
                monthly: {},
                legalAdvice: '',
                legalDocumentation: '',
                representation: '',
                inquest: '',
                mediation: '',
                administration: '',
                others: '',
                crimes: [],
                clientsServed: '',
                users: '',
                authUser: '',
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
            convertDate() {
                let form = new Form({
                    date: this.dash_date
                })
                if (this.$gate.isAdminAndSuperAdmin()) {
                    form.post('api/dashboard').then(({
                        data
                    }) => {
                        let sunday = 0,
                            monday = 0,
                            tuesday = 0,
                            wednesday = 0,
                            thursday = 0,
                            friday = 0,
                            saturday = 0,
                            pending = 0,
                            arraignment = 0,
                            pre_trial = 0,
                            prosecution = 0,
                            defense = 0,
                            terminated = 0,
                            presentJan = 0,
                            presentFeb = 0,
                            presentMar = 0,
                            presentApr = 0,
                            presentMay = 0,
                            presentJun = 0,
                            presentJul = 0,
                            presentAug = 0,
                            presentSept = 0,
                            presentOct = 0,
                            presentNov = 0,
                            presentDec = 0,
                            pastJan = 0,
                            pastFeb = 0,
                            pastMar = 0,
                            pastApr = 0,
                            pastMay = 0,
                            pastJun = 0,
                            pastJul = 0,
                            pastAug = 0,
                            pastSept = 0,
                            pastOct = 0,
                            pastNov = 0,
                            pastDec = 0

                        this.weekly = data[0]
                        this.monthly = data[1]
                        this.legalAdvice = data[4]
                        this.legalDocumentation = data[5]
                        this.representation = data[6]
                        this.inquest = data[7]
                        this.mediation = data[8]
                        this.administration = data[9]
                        this.others = data[10]
                        this.clientsServed = data[12]
                        this.users = data[13]

                        if (this.monthly[0] !== undefined) {
                            this.latestCase = this.monthly[0].control_num
                        } else {
                            this.latestCase = ''
                        }

                        for (let i = 0; i < data[0].length; i++) {
                            let day = window.moment(data[0][i].created_at).format('dddd')
                            if (day === 'Sunday') {
                                sunday++
                            } else if (day === 'Monday') {
                                monday++
                            } else if (day === 'Tuesday') {
                                tuesday++
                            } else if (day === 'Wednesday') {
                                wednesday++
                            } else if (day === 'Thursday') {
                                thursday++
                            } else if (day === 'Friday') {
                                friday++
                            } else if (day === 'Saturday') {
                                saturday++
                            }
                        }

                        for (let i = 0; i < data[1].length; i++) {

                            if (data[1][i].status === 'Pending') {
                                pending++
                            } else if (data[1][i].status === 'Arraignment') {
                                arraignment++
                            } else if (data[1][i].status === 'Pre-Trial') {
                                pre_trial++
                            } else if (data[1][i].status === 'Prosecution Evidence') {
                                prosecution++
                            } else if (data[1][i].status === 'Defense Evidence') {
                                defense++
                            } else {
                                terminated++
                            }
                        }

                        for (let i = 0; i < data[2].length; i++) {
                            let presentMonth = window.moment(data[2][i].created_at).format('MMMM')
                            if (presentMonth === 'January') {
                                presentJan++
                            } else if (presentMonth === 'February') {
                                presentFeb++
                            } else if (presentMonth === 'March') {
                                presentMar++
                            } else if (presentMonth === 'April') {
                                presentApr++
                            } else if (presentMonth === 'May') {
                                presentMay++
                            } else if (presentMonth === 'June') {
                                presentJun++
                            } else if (presentMonth === 'July') {
                                presentJul++
                            } else if (presentMonth === 'August') {
                                presentAug++
                            } else if (presentMonth === 'September') {
                                presentSept++
                            } else if (presentMonth === 'October') {
                                presentOct++
                            } else if (presentMonth === 'November') {
                                presentNov++
                            } else if (presentMonth === 'December') {
                                presentDec++
                            }
                        }

                        for (let i = 0; i < data[3].length; i++) {
                            let pastMonth = window.moment(data[3][i].created_at).format('MMMM')
                            if (pastMonth === 'January') {
                                pastJan++
                            } else if (pastMonth === 'February') {
                                pastFeb++
                            } else if (pastMonth === 'March') {
                                pastMar++
                            } else if (pastMonth === 'April') {
                                pastApr++
                            } else if (pastMonth === 'May') {
                                pastMay++
                            } else if (pastMonth === 'June') {
                                pastJun++
                            } else if (pastMonth === 'July') {
                                pastJul++
                            } else if (pastMonth === 'August') {
                                pastAug++
                            } else if (pastMonth === 'September') {
                                pastSept++
                            } else if (pastMonth === 'October') {
                                pastOct++
                            } else if (pastMonth === 'November') {
                                pastNov++
                            } else if (pastMonth === 'December') {
                                pastDec++
                            }
                        }

                        // for (let i = 0; i < data[11].length; i++) {
                        //     this.crimes.push(data[11][i].concat(data[11][i + 1]))
                        // }


                        // let count = {}
                        // let arr = []
                        // if (this.crimes.length !== 0) {
                        //     this.crimes[0].forEach(function (i) {
                        //         count[i] = (count[i] || 0) + 1;
                        //     })
                        //     for (let i = 0; i < 5; i++) {
                        //         Object.keys(count).reduce((a, b) => {
                        //             if (count[a] > count[b]) {
                        //                 arr.push(a)
                        //                 delete count[a]
                        //             } else {
                        //                 return b
                        //             }
                        //         })
                        //     }
                        // } else {
                        //     this.crimes = arr
                        // }
                        // this.crimes = arr

                        setTimeout(() => {
                            let weekly = document.getElementById("case-weekly")
                            let weeklyGradient = weekly.getContext('2d').createLinearGradient(0, 0, 0,
                                400)
                            weeklyGradient.addColorStop(0, '#34cc7d')
                            weeklyGradient.addColorStop(1, '#ffed4a')
                            let caseWeeklyChart = new Chart(weekly, {
                                type: 'bar',
                                data: {
                                    labels: ["Sun", "Mon", "Tue",
                                        "Wed", "Thurs",
                                        "Fri", "Sat"
                                    ],
                                    datasets: [{
                                        label: 'No. of Cases',
                                        data: [sunday, monday, tuesday,
                                            wednesday, thursday,
                                            friday, saturday
                                        ],
                                        backgroundColor: weeklyGradient,
                                        hoverBackgroundColor: weeklyGradient,
                                        hoverBorderColor: '#    ',
                                        hoverBorderWidth: 3,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false
                                    },
                                    tooltips: {
                                        titleFontColor: '#34cc7d',
                                        multiKeyBackground: '#34cc7d',
                                        backgroundColor: '',
                                    },
                                    scales: {
                                        xAxes: [{
                                            barThickness: 25,
                                            ticks: {
                                                fontColor: '#fff'
                                            },
                                            gridLines: {
                                                color: "rgba(0, 0, 0, 0)",
                                            }
                                        }],
                                        yAxes: [{
                                            display: false,
                                            ticks: {
                                                beginAtZero: true
                                            },
                                            gridLines: {
                                                color: "rgba(0, 0, 0, 0)",
                                            }
                                        }]
                                    }
                                }
                            })

                            let segments = document.getElementById("case-segments")
                            let segmentsGradient = segments.getContext('2d').createLinearGradient(0, 0,
                                0,
                                600)
                            segmentsGradient.addColorStop(0, '#ffed4a')
                            segmentsGradient.addColorStop(1, '#34cc7d')
                            let caseSegmentsChart = new Chart(segments, {
                                type: 'doughnut',
                                data: {
                                    labels: ["Pending", "Arraignment", "Pre-Trial",
                                        "Prosecution Evidence", "Defense Evidence",
                                        "Terminated"
                                    ],
                                    datasets: [{
                                        label: 'No. of Cases',
                                        data: [pending, arraignment, pre_trial,
                                            prosecution,
                                            defense, terminated
                                        ],
                                        backgroundColor: ["#34cc7d", "#007bff",
                                            "#6c757d",
                                            "#FFB22B", "#26C6DA", "#FC4B6C"
                                        ],
                                        hoverBackgroundColor: ["#34cc7d", "#007bff",
                                            "#6c757d", "#FFB22B", "#26C6DA",
                                            "#FC4B6C"
                                        ],
                                        hoverBorderColor: '#34cc7d',
                                        hoverBorderWidth: 3,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    tooltips: {
                                        titleFontColor: '#34cc7d',
                                        backgroundColor: '',
                                    },
                                    legend: {
                                        labels: {
                                            fontColor: '#fff'
                                        },
                                        position: 'right'
                                    },
                                    title: {
                                        display: true,
                                        fontSize: 18
                                    },
                                    labels: {
                                        fontColor: '#34cc7d'
                                    },
                                }
                            })

                            let yearly = document.getElementById("case-yearly")
                            let yearlyGradient1 = yearly.getContext('2d').createLinearGradient(0, 0, 0,
                                600)
                            let yearlyGradient2 = yearly.getContext('2d').createLinearGradient(0, 0, 0,
                                600)
                            yearlyGradient1.addColorStop(0, '#ffed4a')
                            yearlyGradient1.addColorStop(1, '#34cc7d')
                            yearlyGradient2.addColorStop(0, '#00C9FF')
                            yearlyGradient2.addColorStop(1, '#92FE9D')
                            let caseYearlyChart = new Chart(yearly, {
                                type: 'line',
                                data: {
                                    labels: ["Jan", "Feb", "Mar",
                                        "Apr", "May",
                                        "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"
                                    ],
                                    datasets: [{
                                        label: 'Present Year',
                                        data: [presentJan, presentFeb, presentMar,
                                            presentApr,
                                            presentMay, presentJun, presentJul,
                                            presentAug, presentSept, presentOct,
                                            presentNov, presentDec
                                        ],
                                        backgroundColor: yearlyGradient1,
                                        hoverBackgroundColor: yearlyGradient1,
                                        hoverBorderColor: '#34cc7d',
                                        hoverBorderWidth: 3,
                                        borderWidth: 1
                                    }, {
                                        label: 'Past Year',
                                        data: [pastJan, pastFeb, pastMar, pastApr,
                                            pastMay, pastJun, pastJul, pastAug,
                                            pastSept, pastOct, pastNov, pastDec
                                        ],
                                        backgroundColor: yearlyGradient2,
                                        hoverBackgroundColor: yearlyGradient2,
                                        hoverBorderColor: '#34cc7d',
                                        hoverBorderWidth: 3,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    legend: {
                                        labels: {
                                            fontColor: '#fff'
                                        }
                                    },
                                    scales: {
                                        xAxes: [{
                                            barThickness: 25,
                                            ticks: {
                                                fontColor: '#fff'
                                            },
                                            gridLines: {
                                                color: "rgba(0, 0, 0, 0)",
                                            }
                                        }],
                                        yAxes: [{
                                            display: true,
                                            ticks: {
                                                beginAtZero: true
                                            },
                                            gridLines: {
                                                color: "rgba(0, 0, 0, 0)",
                                            }
                                        }]
                                    }
                                }
                            })
                        }, 1000)
                    })
                }
            },
            loadDashboard() {
                if (this.$gate.isAdminAndSuperAdmin()) {
                    axios.get('api/dashboard').then(({
                        data
                    }) => {
                        let sunday = 0,
                            monday = 0,
                            tuesday = 0,
                            wednesday = 0,
                            thursday = 0,
                            friday = 0,
                            saturday = 0,
                            pending = 0,
                            arraignment = 0,
                            pre_trial = 0,
                            prosecution = 0,
                            defense = 0,
                            terminated = 0,
                            presentJan = 0,
                            presentFeb = 0,
                            presentMar = 0,
                            presentApr = 0,
                            presentMay = 0,
                            presentJun = 0,
                            presentJul = 0,
                            presentAug = 0,
                            presentSept = 0,
                            presentOct = 0,
                            presentNov = 0,
                            presentDec = 0,
                            pastJan = 0,
                            pastFeb = 0,
                            pastMar = 0,
                            pastApr = 0,
                            pastMay = 0,
                            pastJun = 0,
                            pastJul = 0,
                            pastAug = 0,
                            pastSept = 0,
                            pastOct = 0,
                            pastNov = 0,
                            pastDec = 0

                        this.weekly = data[0]
                        this.monthly = data[1]
                        this.legalAdvice = data[4]
                        this.legalDocumentation = data[5]
                        this.representation = data[6]
                        this.inquest = data[7]
                        this.mediation = data[8]
                        this.administration = data[9]
                        this.others = data[10]
                        this.clientsServed = data[12]
                        this.users = data[13]

                        if (this.monthly[0] !== undefined) {
                            this.latestCase = this.monthly[0].control_num
                        } else {
                            this.latestCase = ''
                        }

                        for (let i = 0; i < data[0].length; i++) {
                            let day = window.moment(data[0][i].created_at).format('dddd')
                            if (day === 'Sunday') {
                                sunday++
                            } else if (day === 'Monday') {
                                monday++
                            } else if (day === 'Tuesday') {
                                tuesday++
                            } else if (day === 'Wednesday') {
                                wednesday++
                            } else if (day === 'Thursday') {
                                thursday++
                            } else if (day === 'Friday') {
                                friday++
                            } else if (day === 'Saturday') {
                                saturday++
                            }
                        }

                        for (let i = 0; i < data[1].length; i++) {
                            if (data[1][i].status === 'Pending') {
                                pending++
                            } else if (data[1][i].status === 'Arraignment') {
                                arraignment++
                            } else if (data[1][i].status === 'Pre-Trial') {
                                pre_trial++
                            } else if (data[1][i].status === 'Prosecution Evidence') {
                                prosecution++
                            } else if (data[1][i].status === 'Defense Evidence') {
                                defense++
                            } else {
                                terminated++
                            }
                        }

                        for (let i = 0; i < data[2].length; i++) {
                            let presentMonth = window.moment(data[2][i].created_at).format('MMMM')
                            if (presentMonth === 'January') {
                                presentJan++
                            } else if (presentMonth === 'February') {
                                presentFeb++
                            } else if (presentMonth === 'March') {
                                presentMar++
                            } else if (presentMonth === 'April') {
                                presentApr++
                            } else if (presentMonth === 'May') {
                                presentMay++
                            } else if (presentMonth === 'June') {
                                presentJun++
                            } else if (presentMonth === 'July') {
                                presentJul++
                            } else if (presentMonth === 'August') {
                                presentAug++
                            } else if (presentMonth === 'September') {
                                presentSept++
                            } else if (presentMonth === 'October') {
                                presentOct++
                            } else if (presentMonth === 'November') {
                                presentNov++
                            } else if (presentMonth === 'December') {
                                presentDec++
                            }
                        }

                        for (let i = 0; i < data[3].length; i++) {
                            let pastMonth = window.moment(data[3][i].created_at).format('MMMM')
                            if (pastMonth === 'January') {
                                pastJan++
                            } else if (pastMonth === 'February') {
                                pastFeb++
                            } else if (pastMonth === 'March') {
                                pastMar++
                            } else if (pastMonth === 'April') {
                                pastApr++
                            } else if (pastMonth === 'May') {
                                pastMay++
                            } else if (pastMonth === 'June') {
                                pastJun++
                            } else if (pastMonth === 'July') {
                                pastJul++
                            } else if (pastMonth === 'August') {
                                pastAug++
                            } else if (pastMonth === 'September') {
                                pastSept++
                            } else if (pastMonth === 'October') {
                                pastOct++
                            } else if (pastMonth === 'November') {
                                pastNov++
                            } else if (pastMonth === 'December') {
                                pastDec++
                            }
                        }

                        let dataArr = []
                        for (let i = 0; i < data[11].length; i++) {
                            dataArr.push(data[11][i])
                        }
                        let arr = []
                        for (let i = 0; i < dataArr.length; i++) {
                            for (let x = 0; x < dataArr[i].length; x++) {
                                arr.push(dataArr[i][x])
                            }
                        }

                        this.crimes = arr.filter(function (item, pos) {
                            return arr.indexOf(item) == pos;
                        })





                        setTimeout(() => {
                            let weekly = document.getElementById("case-weekly")
                            let weeklyGradient = weekly.getContext('2d').createLinearGradient(0, 0, 0,
                                400)
                            weeklyGradient.addColorStop(0, '#34cc7d')
                            weeklyGradient.addColorStop(1, '#ffed4a')
                            let caseWeeklyChart = new Chart(weekly, {
                                type: 'bar',
                                data: {
                                    labels: ["Sun", "Mon", "Tue",
                                        "Wed", "Thurs",
                                        "Fri", "Sat"
                                    ],
                                    datasets: [{
                                        label: 'No. of Cases',
                                        data: [sunday, monday, tuesday,
                                            wednesday, thursday,
                                            friday, saturday
                                        ],
                                        backgroundColor: weeklyGradient,
                                        hoverBackgroundColor: weeklyGradient,
                                        hoverBorderColor: '#    ',
                                        hoverBorderWidth: 3,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false
                                    },
                                    tooltips: {
                                        titleFontColor: '#34cc7d',
                                        multiKeyBackground: '#34cc7d',
                                        backgroundColor: '',
                                    },
                                    scales: {
                                        xAxes: [{
                                            barThickness: 25,
                                            ticks: {
                                                fontColor: '#fff'
                                            },
                                            gridLines: {
                                                color: "rgba(0, 0, 0, 0)",
                                            }
                                        }],
                                        yAxes: [{
                                            display: false,
                                            ticks: {
                                                beginAtZero: true
                                            },
                                            gridLines: {
                                                color: "rgba(0, 0, 0, 0)",
                                            }
                                        }]
                                    }
                                }
                            })

                            let segments = document.getElementById("case-segments")
                            let segmentsGradient = segments.getContext('2d').createLinearGradient(0, 0,
                                0,
                                600)
                            segmentsGradient.addColorStop(0, '#ffed4a')
                            segmentsGradient.addColorStop(1, '#34cc7d')
                            let caseSegmentsChart = new Chart(segments, {
                                type: 'doughnut',
                                data: {
                                    labels: ["Pending", "Arraignment", "Pre-Trial",
                                        "Prosecution Evidence", "Defense Evidence",
                                        "Terminated"
                                    ],
                                    datasets: [{
                                        label: 'No. of Cases',
                                        data: [pending, arraignment, pre_trial,
                                            prosecution,
                                            defense, terminated
                                        ],
                                        backgroundColor: ["#34cc7d", "#007bff",
                                            "#6c757d",
                                            "#FFB22B", "#26C6DA", "#FC4B6C"
                                        ],
                                        hoverBackgroundColor: ["#34cc7d", "#007bff",
                                            "#6c757d", "#FFB22B", "#26C6DA",
                                            "#FC4B6C"
                                        ],
                                        hoverBorderColor: '#34cc7d',
                                        hoverBorderWidth: 3,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    tooltips: {
                                        titleFontColor: '#34cc7d',
                                        backgroundColor: '',
                                    },
                                    legend: {
                                        labels: {
                                            fontColor: '#fff'
                                        },
                                        position: 'right'
                                    },
                                    title: {
                                        display: true,
                                        fontSize: 18
                                    },
                                    labels: {
                                        fontColor: '#34cc7d'
                                    },
                                }
                            })

                            let yearly = document.getElementById("case-yearly")
                            let yearlyGradient1 = yearly.getContext('2d').createLinearGradient(0, 0, 0,
                                600)
                            let yearlyGradient2 = yearly.getContext('2d').createLinearGradient(0, 0, 0,
                                600)
                            yearlyGradient1.addColorStop(0, '#ffed4a')
                            yearlyGradient1.addColorStop(1, '#34cc7d')
                            yearlyGradient2.addColorStop(0, '#00C9FF')
                            yearlyGradient2.addColorStop(1, '#92FE9D')
                            let caseYearlyChart = new Chart(yearly, {
                                type: 'line',
                                data: {
                                    labels: ["Jan", "Feb", "Mar",
                                        "Apr", "May",
                                        "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"
                                    ],
                                    datasets: [{
                                        label: 'Present Year',
                                        data: [presentJan, presentFeb, presentMar,
                                            presentApr,
                                            presentMay, presentJun, presentJul,
                                            presentAug, presentSept, presentOct,
                                            presentNov, presentDec
                                        ],
                                        backgroundColor: yearlyGradient1,
                                        hoverBackgroundColor: yearlyGradient1,
                                        hoverBorderColor: '#34cc7d',
                                        hoverBorderWidth: 3,
                                        borderWidth: 1
                                    }, {
                                        label: 'Past Year',
                                        data: [pastJan, pastFeb, pastMar, pastApr,
                                            pastMay, pastJun, pastJul, pastAug,
                                            pastSept, pastOct, pastNov, pastDec
                                        ],
                                        backgroundColor: yearlyGradient2,
                                        hoverBackgroundColor: yearlyGradient2,
                                        hoverBorderColor: '#34cc7d',
                                        hoverBorderWidth: 3,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    legend: {
                                        labels: {
                                            fontColor: '#fff'
                                        }
                                    },
                                    scales: {
                                        xAxes: [{
                                            barThickness: 25,
                                            ticks: {
                                                fontColor: '#fff'
                                            },
                                            gridLines: {
                                                color: "rgba(0, 0, 0, 0)",
                                            }
                                        }],
                                        yAxes: [{
                                            display: true,
                                            ticks: {
                                                beginAtZero: true
                                            },
                                            gridLines: {
                                                color: "rgba(0, 0, 0, 0)",
                                            }
                                        }]
                                    }
                                }
                            })
                        }, 1000)
                    })
                }
            },
        },
        mounted() {
            this.loadDashboard()
            this.loadAuthUser()
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
