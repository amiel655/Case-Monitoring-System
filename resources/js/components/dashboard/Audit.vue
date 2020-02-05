<template>
    <div class="pt-3 container-fluid">
        <div v-if="!$gate.isSuperAdmin()">
            <not-found></not-found>
        </div><br>
        <div class="row card shadow" v-if="$gate.isSuperAdmin()">
            <div class="col-md-12">
                <div class="card-title text-center shadow client-header-card">
                    Audit
                </div>
            </div>
            <div v-show="audits.length === 0" class="empty col-md-12 pt-2 pb-5 text-center">
                <empty></empty><br>
                <h3 class="p-2">No Audit Record</h3>
            </div>

            <div v-show="audits.length !== 0" class="col-md-12 p-3">
                <table class="table table-striped no-top-border">
                                        <thead class="thead">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Event</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">IP Address</th>
                                                <th scope="col">Date and Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="audit in audits.data" :key="audit.id" class="text-muted">
                                                <td>{{audit.firstname}} {{audit.lastname}}</td>
                                                <td><span class="badge" :class="{'badge-warning': audit.event === 'created', 'badge-success': audit.event === 'updated', 'badge-danger': audit.event === 'deleted'}">{{audit.event | capitalize}}</span></td>
                                                <td>{{audit.auditable_type | auditType}}
                                                    <span v-if='audit.auditable_type === "App\\natureRequest"'>in Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\natureOfTheCase"'>in Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\clientProfile"'>in Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\intervieweePersonalCircumstances"'>in Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\clientCaseInvolvement"'>in Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\clientClassification"'>in Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\additionalInformationCase"'>in Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\proofIndigency"'>in Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\Cases"'>Prepared</span>
                                                    <span v-if='audit.auditable_type === "App\\Event"'>in Calendar</span>
                                                    <span v-if='audit.auditable_type === "App\\Hearing"'>Date in Calendar</span>
                                                </td>
                                                <td>{{audit.ip_address}}</td>
                                                <td>{{audit.created_at | auditDate}}</td>
                                            </tr>
                                        </tbody>
                                    </table><br>
                                    <div class="text-right">
                <pagination :data="audits" @pagination-change-page="paginateAudits" :show-disabled="true">
                    <span slot="prev-nav">Prev</span>
	                <span slot="next-nav">Next</span>
                </pagination>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                audits: {},
            }
        },
        methods: {
            loadAudit() {
                if (this.$gate.isSuperAdmin()) {
                    axios.get('api/all-audit').then(({
                    data
                }) => {
                    this.audits = data
                })
                }
            },
            paginateAudits(page = 1) {
                axios.get('api/all-audit?page=' + page).then((response) => {
                    this.audits = response.data
                })
            },
        },
        mounted() {
            this.loadAudit()
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
