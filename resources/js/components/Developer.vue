<template>
    <div class="container-fluid pt-3">
        <div v-if="!$gate.isAdminAndSuperAdmin()">
            <not-found></not-found>
        </div>
        <div v-if="$gate.isAdminAndSuperAdmin()"  class="row justify-content-center">
            <div class="col-md-12">
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
        }
    }
</script>
