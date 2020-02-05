<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-nav navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
                <i class="material-icons">
                    dehaze
                </i>
            </a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <div class="form-inline" style="width: 100%;">
        <div class="search input-group">
            <input class="form-control" type="search" @keyup="searching" v-model="search" placeholder="Search here..."
                aria-label="Search" aria-label="" aria-describedby="basic-addon2" :style="[search.length == 0 ? {'border-top-right-radius': '13px !important'} : {'border-top-right-radius': '0px !important'}, search.length == 0 ? {'border-bottom-right-radius': '13px !important'} : {'border-bottom-right-radius': '0px !important'}]">
            <div class="input-group-append">
                <button v-show="search.length !== 0" class="btn btn-secondary search-cancel" type="button" @click="search = ''"> <small>Cancel</small></button>
            </div>
            <ul class="results" :style="[search !== '' ? {'display': 'block'} : {'display': 'none'}, searchResults.length === 0 ? {'height': '70px'} : {'height': '300px'}]"
                id="style-1">
                <div v-show="searchResults.length === 0">
                    <p class="text-center pt-4">Searching...</p>
                </div>
                @can('isSuperAdmin')
                <div v-show="searchResults[4] === 0 && searchResults[5] === 0 && searchResults[3] === 0">
                    <h3 class="text-center mt-5">No Results for "&nbsp;<i>@{{search}}</i>&nbsp;"</h3>
                </div>
                @endcan

                @can('isAdmin')
                <div v-show="searchResults[4] === 0 && searchResults[5] === 0 && searchResults[3] === 0">
                    <h3 class="text-center mt-5">No Results for "&nbsp;<i>@{{search}}</i>&nbsp;"</h3>
                </div>
                @endcan

                @can('isStaff')
                <div v-show="searchResults[4] === 0 && searchResults[5] === 0 && searchResults[3] === 0">
                    <h3 class="text-center mt-5">No Results for "&nbsp;<i>@{{search}}</i>&nbsp;"</h3>
                </div>
                @endcan

                @can('isAdminAndSuperAdmin')
                <span v-show="searchResults[4] !== 0">
                    <h5 class="pl-3 pt-2 pb-2 bg-success search-title">
                        <court-icon></court-icon> Cases (@{{searchResults[4]}})
                    </h5>
                    <li v-for="cases in searchResults[1]" :key="cases.id"><a :href="'cases/' + cases.control_num">
                            <div v-show="cases.control_num.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><i>#
                                    @{{cases.control_num}}</i></div>
                            @{{cases.case_title}}
                            <div v-show="cases.court.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><b>Court:</b>
                                <i>@{{cases.court}}</i></div>
                            <div v-show="cases.crime.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><b>Crime:</b>
                                <i>@{{cases.crime}}</i></div>
                            <div v-show="cases.detained.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><b>Detained:</b>
                                <i>@{{cases.detained}}</i></div>
                            <div v-show="cases.complainant.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><b>Complainant:</b>
                                <i>@{{cases.complainant}}</i></div>
                            <div v-show="cases.respondent.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><b>Respondent:</b>
                                <i>@{{cases.respondent}}</i></div>
                            <div v-show="cases.status.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><b>Status:</b>
                                <i>@{{cases.status}}</i></div>
                        </a></li>
                </span>
                @endcan

                <span v-show="searchResults[5] !== 0">
                    <h5 class="pl-3 pt-2 pb-2 bg-success search-title">
                        <clients-icon></clients-icon> Clients (@{{searchResults[5]}})
                    </h5>
                    <li v-for="client in searchResults[2]" :key="client.id"><a :href="'clients/' + client.control_num">
                            <div v-show="client.control_num.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><i>#
                                    @{{client.control_num}}</i></div>
                            @{{client.client_name}}
                            <div v-show="client.client_citizenship.toLowerCase().search(search.toLowerCase()) != -1"
                                style="font-size: 12px;"><b>Citizenship:</b> <i>@{{client.client_citizenship}}</i></div>
                            <div v-show="client.client_address.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><b>Address:</b>
                                <i>@{{client.client_address}}</i></div>
                            <div v-show="client.nature_request.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><b>Nature
                                    of Request:</b> <i>@{{client.nature_request}}</i></div>
                            <div v-show="client.assigned_to.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><b>Assigned
                                    To:</b> <i>@{{client.assigned_to}}</i></div>
                            <div v-show="client.client_email.toLowerCase().search(search.toLowerCase()) != -1" style="font-size: 12px;"><b>Email:</b>
                                <i>@{{client.client_email}}</i></div>
                        </a></li>
                </span>
                {{-- @can('isSuperAdmin')
                <span v-show="searchResults[3] !== 0">
                    <h5 class="pl-3 pt-2 pb-2 bg-success search-title">
                        <users-icon></users-icon> Users (@{{searchResults[3]}})
                    </h5>
                    <li v-for="user in searchResults[0]" :key="user.id"><a href="/users"><img :src="'img/profile-picture/' + user.image "
                                class="img-fluid img-circle img-border" width="30px"><br>@{{user.firstname}}
                            @{{user.middlename}} @{{user.lastname}}
                            <p class="badge" :class="{'badge-primary' : user.status === 'Available', 'badge-secondary' : user.status === 'Unavailable', 'badge-info' : user.status === 'On-Leave'}">@{{
                                user.status }}</p>
                            <div style="font-size: 12px">
                                <b>Type: </b>
                                <span v-if="user.type === 'Staff'">Staff</span>
                                <span v-if="user.type === 'Admin'">Lawyer</span>
                                <span v-if="user.type === 'Super Admin'">District Public Attorney</span>
                            </div>
                        </a></li>
                </span>
                @endcan --}}
            </ul>
        </div>
    </div>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <notification :unread="{{auth()->user()->unreadNotifications}}" :userid="{{auth()->id()}}"></notification>

        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i class="material-icons mr-2">
                    view_comfy
                </i></a>
        </li> --}}
    </ul>
</nav>
