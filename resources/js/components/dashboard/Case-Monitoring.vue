<template>
    <div class="pt-3 container-fluid">
        <div v-if="!$gate.isAdminAndSuperAdmin()">
            <not-found></not-found>
        </div><br>
        <div class="row card shadow" v-if="$gate.isAdminAndSuperAdmin()">
            <div class="col-md-12">
                <div class="card-title text-center shadow client-header-card">
                    Cases
                </div>
            </div>
            <div v-if="cases.data.length === 0" class="empty col-md-12 pt-2 pb-5 text-center">
                <empty></empty><br>
                <h3 class="p-2">No case/s found</h3>
            </div>

            <div v-if="cases.data.length !== 0" class="col-md-12 p-3">

                <div class="row">
                    <div class="col-md-12 pt-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" :class="{'active' : tabs === 'On-Going Cases'}" @click="tabs = 'On-Going Cases'">On-Going Cases</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color: #FC4B6C !important" :class="{'active' : tabs === 'Terminated Cases'}" @click="tabs = 'Terminated Cases'">Terminated / Archived Cases</a>
                        </li>
                        <li class="nav-item ml-auto text-right">
                            <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" id="orderBy" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{orderBy}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="orderBy">
                                <h6 class="dropdown-header">Order By</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" @click="orderCases(sortBy, 'case_no')">Case No.</a>
                                <a class="dropdown-item" @click="orderCases(sortBy, 'case_title')">Case Title</a>
                                <a class="dropdown-item" @click="orderCases(sortBy, 'complainant')">Complainant</a>
                                <a class="dropdown-item" @click="orderCases(sortBy, 'court')">Court</a>
                                <a class="dropdown-item" @click="orderCases(sortBy, 'crime')">Crime</a>
                                <a class="dropdown-item" @click="orderCases(sortBy, 'detained')">Detained</a>
                                <a class="dropdown-item" @click="orderCases(sortBy, 'respondent')">Respondent</a>
                                <a class="dropdown-item" @click="orderCases(sortBy, 'status')">Status</a>
                            </div>
                        </div>
                        </li>
                    </ul>
                </div>
                    <div class="col-md-4" v-for="caseData in sortBy" :key="caseData.id" v-if="(tabs === 'On-Going Cases') && (caseData.status === 'Pending' || caseData.status === 'Arraignment' || caseData.status === 'Pre-Trial' || caseData.status === 'Prosecution Evidence' || caseData.status === 'Defense Evidence')">
                        <div class="card mt-5 shadow pr-3 pl-3">
                            <div class=" text-center shadow client-header-card">
                                #{{ caseData.case_no }}
                            </div>
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5 class="r">{{ caseData.case_title }}</h5>
                                    <p v-if="typeof(hearing) == Object" class="badge" :class="{'badge-success': hearing[1][0].case_status === 'Pending', 'badge-primary': hearing[1][0].case_status === 'Arraignment', 'badge-secondary': hearing[1][0].case_status === 'Pre-Trial', 'badge-warning': hearing[1][0].case_status === 'Prosecution Evidence', 'badge-info': hearing[1][0].case_status === 'Defense Evidence', 'badge-danger': hearing[1][0].case_status !== 'Pending' && hearing[1][0].case_status !== 'Arraignment' && hearing[1][0].case_status !== 'Pre-Trial' && hearing[1][0].case_status !== 'Prosecution Evidence' && hearing[1][0].case_status !== 'Defense Evidence'}"
                                        style="font-size: 12px;"><span v-show="hearing[1][0].case_status !== 'Pending' && hearing[1][0].case_status !== 'Arraignment' && hearing[1][0].case_status !== 'Pre-Trial' && hearing[1][0].case_status !== 'Prosecution Evidence' && hearing[1][0].case_status !== 'Defense Evidence'">Terminated: </span> {{ hearing[1][0].case_status }}</p>
                                    <p v-if="typeof(hearing) != Object" class="badge" :class="{'badge-success': caseData.status === 'Pending', 'badge-primary': caseData.status === 'Arraignment', 'badge-secondary': caseData.status === 'Pre-Trial', 'badge-warning': caseData.status === 'Prosecution Evidence', 'badge-info': caseData.status === 'Defense Evidence', 'badge-danger': caseData.status !== 'Pending' && caseData.status !== 'Arraignment' && caseData.status !== 'Pre-Trial' && caseData.status !== 'Prosecution Evidence' && caseData.status !== 'Defense Evidence'}"
                                        style="font-size: 12px;"><span v-show="caseData.status !== 'Pending' && caseData.status !== 'Arraignment' && caseData.status !== 'Pre-Trial' && caseData.status !== 'Prosecution Evidence' && caseData.status !== 'Defense Evidence'">Terminated: </span>{{ caseData.status }}</p>
                                    <div class="text-right" v-show="caseData.access_status === 'Enabled'" style="font-size: 16px;">
                                        <small>Access Code: </small>
                                        <span class="badge badge-primary pt-1 px-2">
                                            {{ caseData.access_code }}
                                        </span>
                                    </div>
                                    <hr>
                                </div>
                                <span class="text-success"><i class="material-icons">library_books</i> Crimes:</span>
                                <ul style="list-style-type: none;">
                                    <li>{{ caseData.crime }}</li>
                                </ul>
                                <span class="text-success"><i class="material-icons">supervisor_account</i>
                                    Complainants:</span>
                                <ul style="list-style-type: none;">
                                    <li>{{ caseData.complainant }}</li>
                                </ul>
                                <div class="detained">
                                    <span class="text-success"><i class="material-icons">lock</i> Detained:</span>
                                    <span>{{ caseData.detained }}</span>
                                </div>
                                <div class="pt-4 pb-4 detained">
                                    <span class="text-success"><i class="material-icons">gavel</i> Court:</span>
                                    <span>{{ caseData.court }}</span>
                                </div>
                                <div class="text-right">
                                    <router-link :to="{ path: `cases/${caseData.control_num}`}" style="text-decoration: none;">View
                                        more<i class="material-icons">chevron_right</i></router-link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" v-for="caseData in sortBy" :key="caseData.id" v-if="(tabs === 'Terminated Cases') && (caseData.status !== 'Pending' && caseData.status !== 'Arraignment' && caseData.status !== 'Pre-Trial' && caseData.status !== 'Prosecution Evidence' && caseData.status !== 'Defense Evidence')">
                        <div class="card mt-5 shadow pr-3 pl-3">
                            <div class=" text-center shadow client-header-card">
                                #{{ caseData.case_no }}
                            </div>
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5 class="r">{{ caseData.case_title }}</h5>
                                    <p v-if="typeof(hearing) == Object" class="badge" :class="{'badge-success': hearing[1][0].case_status === 'Pending', 'badge-primary': hearing[1][0].case_status === 'Arraignment', 'badge-secondary': hearing[1][0].case_status === 'Pre-Trial', 'badge-warning': hearing[1][0].case_status === 'Prosecution Evidence', 'badge-info': hearing[1][0].case_status === 'Defense Evidence', 'badge-danger': hearing[1][0].case_status !== 'Pending' && hearing[1][0].case_status !== 'Arraignment' && hearing[1][0].case_status !== 'Pre-Trial' && hearing[1][0].case_status !== 'Prosecution Evidence' && hearing[1][0].case_status !== 'Defense Evidence'}"
                                        style="font-size: 12px;"><span v-show="hearing[1][0].case_status !== 'Pending' && hearing[1][0].case_status !== 'Arraignment' && hearing[1][0].case_status !== 'Pre-Trial' && hearing[1][0].case_status !== 'Prosecution Evidence' && hearing[1][0].case_status !== 'Defense Evidence'">Terminated: </span> {{ hearing[1][0].case_status }}</p>
                                    <p v-if="typeof(hearing) != Object" class="badge" :class="{'badge-success': caseData.status === 'Pending', 'badge-primary': caseData.status === 'Arraignment', 'badge-secondary': caseData.status === 'Pre-Trial', 'badge-warning': caseData.status === 'Prosecution Evidence', 'badge-info': caseData.status === 'Defense Evidence', 'badge-danger': caseData.status !== 'Pending' && caseData.status !== 'Arraignment' && caseData.status !== 'Pre-Trial' && caseData.status !== 'Prosecution Evidence' && caseData.status !== 'Defense Evidence'}"
                                        style="font-size: 12px;"><span v-show="caseData.status !== 'Pending' && caseData.status !== 'Arraignment' && caseData.status !== 'Pre-Trial' && caseData.status !== 'Prosecution Evidence' && caseData.status !== 'Defense Evidence'">Terminated: </span>{{ caseData.status }}</p>
                                    <div class="text-right" v-show="caseData.access_status === 'Enabled'" style="font-size: 16px;">
                                        <small>Access Code: </small>
                                        <span class="badge badge-primary pt-1 px-2">
                                            {{ caseData.access_code }}
                                        </span>
                                    </div>
                                    <hr>
                                </div>
                                <span class="text-success"><i class="material-icons">library_books</i> Crimes:</span>
                                <ul style="list-style-type: none;">
                                    <li>{{ caseData.crime }}</li>
                                </ul>
                                <span class="text-success"><i class="material-icons">supervisor_account</i>
                                    Complainants:</span>
                                <ul style="list-style-type: none;">
                                    <li>{{ caseData.complainant }}</li>
                                </ul>
                                <div class="detained">
                                    <span class="text-success"><i class="material-icons">lock</i> Detained:</span>
                                    <span>{{ caseData.detained }}</span>
                                </div>
                                <div class="pt-4 pb-4 detained">
                                    <span class="text-success"><i class="material-icons">gavel</i> Court:</span>
                                    <span>{{ caseData.court }}</span>
                                </div>
                                <div class="text-right">
                                    <router-link :to="{ path: `cases/${caseData.control_num}`}" style="text-decoration: none;">View
                                        more<i class="material-icons">chevron_right</i></router-link>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                    <pagination :data="cases" @pagination-change-page="paginateCases" :show-disabled="true">
                        <span slot="prev-nav">Prev</span>
	                    <span slot="next-nav">Next</span>
                    </pagination>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tabs: 'On-Going Cases',
                orderBy: 'Order By',
                sortBy: {},
                caseData: {},
                cases: {},
                hearing: {}
            }
        },
        methods: {
            loadCases() {
                if (this.$gate.isAdminAndSuperAdmin()) {
                    axios.get('api/cases').then(({
                        data
                    }) => {
                        this.cases = data
                        this.sortBy = this.cases.data
                    })
                }
            },
            paginateCases(page = 1) {
                axios.get('api/cases?page=' + page).then((response) => {
                    this.sortBy = response.data
                })
            },
            orderCases(data, order) {
                this.sortBy = _.orderBy(data, order, ['asc', 'desc'])
                this.orderBy = order.toLowerCase()
                    .split('_')
                    .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
                    .join(' ')
            }
        },
        mounted() {
            this.loadCases()
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
