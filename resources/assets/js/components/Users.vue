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
                                    <input v-model="formdata.search" placeholder="e.g. Name, Emotions or Status" type="text" class="form-control" name="search" id="search">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="filter">Filter By:</label>
                                <div class="select-ic ic-filter half-input">
                                    <select v-model="formdata.filter" id="filter" name="filter"  @change="selectAdvanceFilter(null,formdata.filter)" class="form-control">
                                        <option value="" selected hidden>Select Filter</option>
                                        <option v-for="(item,key) in filters"  v-if="checkFilterSelected(item.value,formdata.filter)"  :value="item.value">{{item.text}}</option>
                                    </select>
                                </div>
                                <select v-model="formdata.filterValue" id="filter-value" name="filter-value" class="form-control half-input" :disabled="disableFilterValue" >
                                    <option v-for="item in filterOptions" v-if="":value="item.value">
                                        {{item.text}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="sort">Sort By:</label>
                                <div class="select-ic ic-sort">
                                    <select v-model="formdata.sortValue" id="sort" name="sort" class="form-control" >
                                        <option value="" selected hidden>Select Filter</option>
                                        <option value="name">Name</option>
                                        <option value="emotion_value">Current Emotion</option>
                                        <option value="profile_post">Status</option>
                                        <option value="country">Location</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="advance-filter">
                            <div class="advance-filter-input row">
                                <div class="advance-filter-row">
                                    <div class="col-md-5" id="advancefilter1">
                                        <div class="form-group">
                                            <label for="" class="col-md-4">Filter By No 2:</label>
                                            <div class="select-ic ic-filter col-md-6 filter-width">
                                                <select v-model="formdata.filter2" id="filter" name="advancefilter[]" class="form-control">
                                                    <option value="" selected hidden>Select Filter</option>
                                                    <option v-for="n in filters" :value="n.value">
                                                        {{n.text}}
                                                    </option>
                                                </select>
                                            </div>
                                            <select v-model="formdata.filterValue2" id="filter-value" name="filter-value" class="form-control col-md-2 filter-width" :disabled="disableFilterValue2">
                                                <option v-for="n in filterOptions2" :value="n.value">
                                                    {{n.text}}
                                                </option>
                                            </select>
                                            <a href="javascript:;" class="filter-close" v-on:click="RemoveAdvanceFilter()"><img :src="base_url+'img/ic_close.png'" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="col-md-5" id="advancefilter2">
                                        <div class="form-group">
                                            <label for="" class="col-md-4">Filter By No 3:</label>
                                            <div class="select-ic ic-filter col-md-6 filter-width">
                                                <select v-model="formdata.filter3" id="filter" name="advancefilter[]" class="form-control">
                                                    <option v-for="n in filters" :value="n.value">
                                                        {{n.text}}
                                                    </option>
                                                </select>
                                            </div>
                                            <select v-model="formdata.filterValue3" id="filter-value" name="filter-value" class="form-control col-md-2 filter-width" :disabled="disableFilterValue3">
                                                <option v-for="n in filterOptions3" :value="n.value">
                                                    {{n.text}}
                                                </option>
                                            </select>
                                            <a href="javascript:;" class="filter-close" v-on:click="RemoveAdvanceFilter()"><img :src="base_url+'img/ic_close.png'" alt=""></a>
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
                                                <option v-for="n in filters" :value="n.value">
                                                    {{n.text}}
                                                </option>
                                            </div>
                                            <select v-model="formdata.filterValue4" id="filter-value" name="filter-value" class="form-control col-md-2 filter-width" :disabled="disableFilterValue4">
                                                <option v-for="n in filterOptions4" :value="n.value">
                                                    {{n.text}}
                                                </option>
                                            </select>
                                            <a href="javascript:;" class="filter-close" v-on:click="RemoveAdvanceFilter()"><img :src="base_url+'img/ic_close.png'" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="col-md-5" id="advancefilter4">
                                        <div class="form-group">
                                            <label for="" class="col-md-4">Filter By No 5:</label>
                                            <div class="select-ic ic-filter col-md-6 filter-width">
                                                <option v-for="n in filters" :value="n.value">
                                                    {{n.text}}
                                                </option>
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
                                    <li><a href="javascript:;" class="advance-search" v-on:click="clearFields()">Clear Fields</a></li>

                                </ul>
                            </div>
                            <div class="col-md-4 col-md-offset-8" id="advance-filter-menu-open">
                                <ul class="filter-right-menu">
                                    <li><a href="javascript:;" class="advance-search" v-on:click="AddAdvanceFilter">+ Add Another Filter Fields</a></li>
                                    <li><a href="javascript:;" class="advance-search" v-on:click="CloseAdvanceFilter">Close Advance Filter</a></li>
                                </ul>
                            </div>
                        </div> -->
                        <div class="advance-filter" v-if="advanceFilter.length > 0" >
                            <div class="advance-filter-input row">
                                <div class="advance-filter-row">
                                    <div class="col-md-5" v-for="advance in advanceFilter" >
                                        <div class="form-group">
                                            <label for="" class="col-md-4">Filter By No {{advance.id}}:</label>
                                            <div class="select-ic ic-filter col-md-6 filter-width">
                                                <select id="filter" class="form-control" @change="selectAdvanceFilter(advance)" v-model="advance.selectedFilter">
                                                    <option value="" selected hidden>Select Filter</option>
                                                    <option v-for="(item,key) in filters"  v-if="checkFilterSelected(item.value,advance.selectedFilter)"  :value="item.value">{{item.text}}</option>
                                                </select>
                                            </div>
                                            <select id="filter-value" name="filter-value" class="form-control col-md-2 filter-width" >
                                                <option v-for="item in advance.advanceFilterValues" :value="item.value">
                                                    {{item.text}}
                                                </option>
                                            </select>
                                            <a href="javascript:;" class="filter-close"><img :src="base_url+'img/ic_close.png'" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-8" id="advance-filter-menu-open">
                                <ul class="filter-right-menu">
                                    <li><a href="javascript:;" class="advance-search" @click="addFilter" >{{ advanceFilter.length <= 0 ? 'Advance Search' : '+ Add Another Filter Fields' }}</a></li>
                                    <li><a href="javascript:;" class="advance-search" v-on:click="clearFields()">Clear Fields</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="scoreboard">
                            <div class="advance-card advance-user col-md-3">
                                <div class="user-value">{{recordData.total}}</div>
                                <div class="advance-card-label">User Selected</div>
                            </div>
                            <div class="advance-card advance-gender col-md-3">
                                <div class="gender-value">
                                    <div class="col-md-6 male"  v-if="formdata.filterValue != 'female'">
                                        <span>Male</span>
                                        <div class="male-value">{{ maleRatio }}</div>
                                    </div>
                                    <div class="col-md-6 female"  v-if="formdata.filterValue != 'male'">
                                        <span>Female</span>
                                        <div class="female-value">{{ femaleRatio }}</div>
                                    </div>
                                </div>
                                <div class="advance-card-label">Gender</div>
                            </div>
                            <div class="advance-card advance-country col-md-3" v-if="formdata.filter == 'location'">
                                <div class="country-value">{{ formdata.filterValue }}</div>
                                <div class="advance-card-label">Country</div>
                            </div>
                            <div class="advance-card advance-country col-md-3" v-if="formdata.filter != 'location'">
                                <div class="country-value">{{ countryCount }}</div>
                                <div class="advance-card-label">No. of Location</div>
                            </div>
                            <div class="advance-card advance-meter col-md-3">
                                <div class="meter-value">{{ up_meter(avgUpmoodmeter) }}</div>
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
                        <tr v-for="user in recordData.data">
                            <td><div class="table-profile-image"><img :src="base_url+'img/profile-avatar.png'" alt=""></div></td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.gender }}</td>
                            <td>{{ user.age }}</td>
                            <td>{{ user.emotion_value }}</td>
                            <td>{{ user.stress_level }}</td>
                            <td>{{ user.heartbeat_count }}</td>
                            <td>{{ user.profile_post }}</td>
                            <td>{{ up_meter(user.upmood_meter) }}</td>
                            <td>{{ user.country }}</td>

                            <td v-if="user.active_level == 'online'"><span class="status-online">{{ user.active_level }}</span></td>
                            <td v-else><span class="status-offline">{{ user.active_level }}</span></td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination">
                    <a v-on:click="preventPrev($event)" class="prev" :href="recordData.prev_page_url">Prev</a>
                    <div class="pagination-number">

                    </div>
                    <a v-on:click="preventNext($event)" class="next" :href="recordData.next_page_url">Next</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['results','countries','emotions'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url,
                searchUrl: window.base_url+'userslist?',

                advance_filter: 1,
                advance_filter_id: 1,

                disableFilterValue: true,

                formdata: {
                    search: '',
                    filter: '',
                    filterValue: '',
                    sortValue: '',
                    page: 1
                },

                maleRatio: 0,
                femaleRatio: 0,
                countryCount: 0,
                avgUpmoodmeter: '',

                recordData: this.results,

                advanceFilter: [],
                filterSelected: [],
                filterOptions: [],

                filters: [
                    {value:'active',text:'Active Level'},
                    {value:'location',text:'Location'},
                    {value:'gender',text:'Gender'},
                    {value:'age',text:'Age'},
                    {value:'emotion',text:'Current Emotion'}
                ],

                active: [
                    {value:'1',text:'online'},
                    {value:'0',text:'offline'},
                    {value:'',text:'all'}
                ],
                gender: [
                    {value:'male',text:'male'},
                    {value:'female',text:'female'},
                ],
                age: [
                    {value:['16','20'],text:'16 - 20'},
                    {value:['21','25'],text:'21 - 25'},
                    {value:['26','30'],text:'26 - 30'},
                    {value:['31','35'],text:'31 - 35'},
                    {value:['36','40'],text:'36 - 40'},
                    {value:['41','45'],text:'41 - 45'},
                ]
            }
        },
        watch: {
            'formdata.search': function (val) {
                this.formdata.page = 1
                window.history.pushState({},"",this.searchUrl+'search='+val+'&')
                
                this.getAxios()
            },
            'formdata.filter': function (val) {
                this.filterOptions = this[val];
                this.disableFilterValue = false;
            },

            'formdata.filterValue': function (val) {
                this.formdata.page = 1
                this.getAxios()
            },

            'formdata.sortValue': function (val) {
                this.formdata.page = 1
                this.getAxios()
            },
        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-user-green"></i>Users');
            this.generatePaginationNumbers();
            this.searchFilters();
        },
        computed:{
            location(){
                let location=[];

                $.each(this.countries, function(k,v){
                    location.push({value:v.country, text:v.country})
                })

                return location
            },

            emotion(){
                let emotion=[];

                $.each(this.emotions, function(k,v){
                    emotion.push({value:v.emotion_value, text:v.emotion_value})
                })

                return emotion
            }
        },
        methods: {
            selectAdvanceFilter(data,filter = null){
                if(data != null){
                    data.advanceFilterValues = this[data.selectedFilter];

                    var duplicateId = this.filterSelected.find(item => item.id === data.id);
                    var removeSelected = this.filterSelected.indexOf(duplicateId);

                    if(removeSelected != -1){
                        this.filterSelected.splice(removeSelected,1);
                    }

                    this.filterSelected.push({
                        id : data.id,
                        value : data.selectedFilter
                    })
                }else{
                    var duplicateId = this.filterSelected.find(item => item.id === 0);
                    var removeSelected = this.filterSelected.indexOf(duplicateId);
                    console.log(duplicateId)

                    if(removeSelected != -1){
                        this.filterSelected.splice(removeSelected,1);
                    }

                    this.filterSelected.push({
                        id : 0,
                        value : filter
                    })

                }
            },

            addFilter(){
                this.advanceFilter.push({
                    id: this.advance_filter_id,
                    selectedFilter: '', 
                    advanceFilterValues: '', 
                });

                this.advance_filter_id = this.advance_filter_id + 1;
            },

            checkFilterSelected(data,elem){
                length = this.filterSelected.length;

                for(var i = 0; i < length; i++) {

                    if(elem != data){
                        if(this.filterSelected[i].value == data){

                            return false;
                        }
                    }
                }
                return true;
            },

            generatePaginationNumbers(){
                var current = this.recordData.current_page;
                var counter = this.recordData.current_page;
                var lastpage = this.recordData.last_page;
                var path = this.recordData.path;

                var limit = 5;
                var numberstring = "";
                if (counter >= (lastpage - limit)+1){
                    counter = (lastpage - limit)+1;
                }

                if (counter <= 0){
                    counter = 1;
                }

                for (var i = 0 ; i < limit ; i++){
                    if (i < lastpage ){

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

            filtertUrl(){

            },

            searchFilters(){
                let vue = this;

                axios.get(base_url+'usersfilter?'+window.location.href.split('?')[1]).then(function (response) {
                    vue.recordData = response['data']['content'];
                    vue.recordData.current_page = vue.formdata.page;
                    vue.maleRatio = response['data']['counts'].maleRatio;
                    vue.femaleRatio = response['data']['counts'].femaleRatio;
                    vue.countryCount = response['data']['counts'].countryCount;
                    vue.avgUpmoodmeter = response['data']['counts'].upmood_meter;
                    vue.generatePaginationNumbers();

                }).catch(function (error) {
                });
            },

            preventNext(event) {
                if(this.formdata.page != this.recordData.last_page){
                    this.formdata.page = (this.formdata.page + 1);
                    this.searchFilters();
                }
                event.preventDefault()
            },

            preventPrev(event) {
                if(this.formdata.page != 1){
                    this.formdata.page = (this.formdata.page - 1);
                    this.searchFilters();
                }
                event.preventDefault()
            },

            clearFields(){
                this.disableFilterValue = true;
                this.formdata.search = '';
                this.formdata.filter = '';
                this.formdata.filter2 = '';
                this.formdata.filter3 = '';
                this.formdata.filter4 = '';
                this.formdata.filter5 = '';
                this.formdata.filterValue = '';
                this.formdata.filterValue2 = '';
                this.formdata.filterValue3 = '';
                this.formdata.filterValue4 = '',
                this.formdata.filterValue5 = '';
                this.formdata.page = 1
            },

            up_meter: function(val){
                if(val == null){
                    return "No Record Found";
                }
                if(val <= -61){
                    return 'Sad';
                }else if(val <= -21){
                    return 'Unpleasant';
                }else if(val <= 20){
                    return 'Calm';
                }else if(val <= 60){
                    return 'Pleasant';
                }else if(val <= 100){
                    return 'Happy';
                }
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

            // RemoveAdvanceFilter(){
            //     alert(this)
            //     $(this).parent('col-md-5').hide()
            // },

            getAxios: _.debounce(
                function () {
                    this.searchFilters()
                },500
            )
        }
    }
</script>
