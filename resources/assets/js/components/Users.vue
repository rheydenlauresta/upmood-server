<template>
    <div class="users-wrapper">
        <div class="users-table-wrapper">
            <div class="row">
                <div class="filter-wrapper">
                    <form method="get" action="" class="formfilters">
                        <div class="basic-filter">
                            <div class="form-group col-md-6">
                                <label for="search">Search:</label>
                                <div class="input-ic ic-search">
                                    <input placeholder="e.g. Name, Emotions or Status" type="text" class="form-control" name="search" id="search">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="filter">Filter By:</label>
                                <div class="select-ic ic-filter half-input">
                                    <select id="filter" name="filter" class="form-control">
                                        <option value="" selected hidden>Select Filter</option>
                                        <option value="is_online">Active Level</option>
                                        <option value="name">Name</option>
                                        <option value="contry">Location</option>
                                        <option value="gender">Gender</option>
                                        <option value="age">Age</option>
                                        <option value="emotion">Current Emotion</option>
                                        <option value="profile_post">Status</option>

                                    </select>
                                </div>
                                <select id="filter-value" name="filter-value" class="form-control half-input" disabled></select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="sort">Sort By:</label>
                                <div class="select-ic ic-sort">
                                    <select id="sort" name="sort" class="form-control">
                                        <option value="" selected hidden>Select Filter</option>
                                        <option value="location">Location</option>
                                        <option value="gender">Gender</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="advance-filter">
                            <div class="advance-filter-input row">
                                <div class="advance-filter-row">
                                    <div class="col-md-5" id="advancefilter1">
                                        <div class="form-group">
                                            <label for="" class="col-md-4">Filter By No 2:</label>
                                            <div class="select-ic ic-filter col-md-6 filter-width">
                                                <select id="filter" name="advancefilter[]" class="form-control">
                                                    <option value="" selected hidden>Select Filter</option>
                                                    <option value="location">Location</option>
                                                    <option value="gender">Gender</option>
                                                </select>
                                            </div>
                                            <select id="filter-value" name="filter-value" class="form-control col-md-2 filter-width" disabled></select>
                                            <a href="javascript:;" class="filter-close"><img :src="base_url+'img/ic_close.png'" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="col-md-5" id="advancefilter2">
                                        <div class="form-group">
                                            <label for="" class="col-md-4">Filter By No 3:</label>
                                            <div class="select-ic ic-filter col-md-6 filter-width">
                                                <select id="filter" name="advancefilter[]" class="form-control">
                                                    <option value="" selected hidden>Select Filter</option>
                                                    <option value="location">Location</option>
                                                    <option value="gender">Gender</option>
                                                </select>
                                            </div>
                                            <select id="filter-value" name="filter-value" class="form-control col-md-2 filter-width" disabled></select>
                                            <a href="javascript:;" class="filter-close"><img :src="base_url+'img/ic_close.png'" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="advance-filter-input row">
                                <div class="advance-filter-row">
                                    <div class="col-md-5" id="advancefilter3">
                                        <div class="form-group">
                                            <label for="" class="col-md-4">Filter By No 4:</label>
                                            <div class="select-ic ic-filter col-md-6 filter-width">
                                                <select id="filter" name="advancefilter[]" class="form-control">
                                                    <option value="" selected hidden>Select Filter</option>
                                                    <option value="location">Location</option>
                                                    <option value="gender">Gender</option>
                                                </select>
                                            </div>
                                            <select id="filter-value" name="filter-value" class="form-control col-md-2 filter-width" disabled></select>
                                            <a href="javascript:;" class="filter-close"><img :src="base_url+'img/ic_close.png'" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-3 col-md-offset-9" id="advance-filter-menu">
                                <ul class="filter-right-menu">
                                    <li><a href="javascript:;" class="advance-search" v-on:click="OpenAdvanceFilter">Advance Search</a></li>
                                    <li><a href="javascript:;" class="advance-search">Clear Fields</a></li>
                                </ul>
                            </div>
                            <div class="col-md-4 col-md-offset-8" id="advance-filter-menu-open">
                                <ul class="filter-right-menu">
                                    <li><a href="javascript:;" class="advance-search" v-on:click="AddAdvanceFilter">+ Add Another Filter Fields</a></li>
                                    <li><a href="javascript:;" class="advance-search" v-on:click="CloseAdvanceFilter">Close Advance Filter</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="scoreboard">
                            <div class="advance-card advance-user col-md-3">
                                <div class="user-value">5,623</div>
                                <div class="advance-card-label">User Selected</div>
                            </div>
                            <div class="advance-card advance-gender col-md-3">
                                <div class="gender-value">
                                    <div class="col-md-6 male">
                                        <span>Male</span>
                                        <div class="male-value">265</div>
                                    </div>
                                    <div class="col-md-6 female">
                                        <span>Female</span>
                                        <div class="female-value">952</div>
                                    </div>
                                </div>
                                <div class="advance-card-label">Gender</div>
                            </div>
                            <div class="advance-card advance-country col-md-3">
                                <div class="country-value">Philippines</div>
                                <div class="advance-card-label">Country</div>
                            </div>
                            <div class="advance-card advance-meter col-md-3">
                                <div class="meter-value">Calm</div>
                                <div class="advance-card-label">Average Upmood Meter</div>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table table-stripe users-table">
                    <thead>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Current Emotion</th>
                        <th>Stress Level</th>
                        <th>BPM</th>
                        <th>Status</th>
                        <th>Upmood Meter</th>
                        <th>Location</th>
                        <th>Active Level</th>
                    </thead>
                    <tbody>
                        <tr v-for="user in results.data">
                            <td><div class="table-profile-image"><img :src="base_url+'img/profile-avatar.png'" alt=""></div></td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.gender }}</td>
                            <td>{{ user.age }}</td>
                            <td>{{user.emotion_value}}</td>
                            <td>{{user.stress_level}}</td>
                            <td>{{ user.heartbeat_count }}</td>
                            <td>{{ user.profile_post }}</td>
                            <td>{{ user.upmood_meter}}</td>
                            <td>{{ user.country }}</td>

                            <td v-if="user.active_level == 'online'"><span class="status-online">{{ user.active_level }}</span></td>
                            <td v-else><span class="status-offline">{{ user.active_level }}</span></td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination">
                    <a class="prev" :href="results.prev_page_url">Prev</a>
                    <div class="pagination-number">

                    </div>
                    <a class="next" :href="results.next_page_url">Next</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['results','filters'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url,
                advance_filter: 1
            }
        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-user-green"></i>Users');
            this.generatePaginationNumbers();
        },
        methods: {
            generatePaginationNumbers(){
                var current = this.results.current_page;
                var counter = this.results.current_page;
                var lastpage = this.results.last_page;
                var path = this.results.path;
                var limit = 5;
                var numberstring = "";
                if (counter >= (lastpage - limit)+1){
                    counter = (lastpage - limit)+1;
                }
                if (counter <= 0){
                    counter = 1;
                }
                for (var i = 0 ; i < limit ; i++){
                    if (i < lastpage){
                        if (current == counter){
                            numberstring += '<a class="active" href="' + path + '?page=' + counter +   '">' + counter + '</a>';
                        }
                        else{
                            numberstring += '<a href="' + path + '?page=' + counter +   '">' + counter + '</a>';
                        }
                        counter += 1;
                    }
                }
                $(".pagination-number").html(numberstring);
            },
            OpenAdvanceFilter(){
                $(".advance-filter").show();
                $("#advance-filter-menu-open").show();
                $("#advance-filter-menu").hide();
            },
            CloseAdvanceFilter(){
                $(".advance-filter").hide();
                $("#advance-filter-menu-open").hide();
                $("#advance-filter-menu").show();
            },
            AddAdvanceFilter(){
                this.advance_filter = this.advance_filter + 1;
                $("#advancefilter" + this.advance_filter).show();
            }
        }
    }
</script>
