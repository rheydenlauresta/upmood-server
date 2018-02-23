<template>
    <div class="users-wrapper">
        <div class="users-table-wrapper">
            <div class="row">
                <a href="javascript:;" class="btn btn-success pull-right downloadfile" @click="downloadFile()">Download File</a>
            </div>
            <div class="row">
                <div class="filter-wrapper">
                    <form method="get" action="" class="formfilters">
                        <div class="basic-filter">
                            <div class="form-group col-md-6">
                                <label for="search">Search:</label>
                                <div class="input-ic ic-search">
                                    <input v-model="formdata.search" placeholder="e.g. Name, Emotions or Status" type="text" class="form-control" name="search" id="search" @keyup="getAxios()" @click="HideSortWrapper">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="filter">Filter By:</label>
                                <div class="select-ic ic-filter half-input">
                                    <select v-model="formdata.filter" id="filter" name="filter"  @change="selectAdvanceFilter(null,formdata.filter)" class="form-control" @click="HideSortWrapper">
                                        <option value="" selected hidden>Select Filter</option>
                                        <option v-for="(item,key) in filters"  v-if="checkFilterSelected(item.value,formdata.filter)"  :value="item.value">{{item.text}}</option>
                                    </select>
                                </div>
                                <select v-model="formdata.filterValue" id="filter-value" name="filter-value" class="form-control half-input" :disabled="disableFilterValue" @change="getAxios()" @click="HideSortWrapper">
                                    <option v-for="item in filterOptions" v-if="":value="item.value">
                                        {{item.text}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="sort">Sort By:</label>
                                <div class="select-ic ic-sort">
                                    <select v-model="sortValue" id="sort" name="sort" class="form-control"  @click="ToggleSortWrapper" :disabled="disableSort">
                                        <option value="" selected hidden>{{ this.formdata.sortCategory }}</option>
                                    </select>
                                    <div class="sort-by-wrapper">
                                        <div class="category-sort">
                                            <label class="form-group category-group" for="category-name">
                                                <input type="radio" id="category-name" name="category" value="Name" @change="selectSort()" v-model="formdata.sortCategory">
                                                <span class="radio-label" for="category-name">Name</span>
                                            </label>
                                            <label class="form-group category-group" for="category-emotion">
                                                <input type="radio"  id="category-emotion" name="category" value="Emotion" @change="selectSort()" v-model="formdata.sortCategory">
                                                <span class="radio-label">Current Emotion</span>
                                            </label>
                                            <label class="form-group category-group" for="category-status">
                                                <input type="radio"  id="category-status" name="category" value="Status" @change="selectSort()" v-model="formdata.sortCategory">
                                                <span class="radio-label">Status</span>
                                            </label>
                                            <label class="form-group category-group" for="category-location">
                                                <input type="radio" id="category-location" name="category" value="Location" @change="selectSort()" v-model="formdata.sortCategory">
                                                <span class="radio-label">Location</span>
                                            </label>
                                        </div>
                                        <div class="order-sort">
                                            <label class="form-group order-group" for="order-ascending">
                                                <input type="radio" id="order-ascending" name="order" value="ASC" @change="selectSort()" v-model="formdata.sortOrder">
                                                <span class="radio-label">Ascending</span>
                                            </label>
                                            <label class="form-group order-group" for="order-descending">
                                                <input type="radio" id="order-descending" name="order" value="DESC" @change="selectSort()" v-model="formdata.sortOrder">
                                                <span class="radio-label">Descending</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="advance-filter" v-if="advanceFilter.length > 0" >
                            <div class="advance-filter-input row">
                                <div class="advance-filter-row">
                                    <div class="col-md-5" v-for="(advance,key) in advanceFilter" >
                                        <div class="form-group">
                                            <label for="" class="col-md-4">Filter By:</label>
                                            <div class="select-ic ic-filter col-md-6 filter-width">
                                                <select id="filter" class="form-control" @change="selectAdvanceFilter(advance)" v-model="advance.selectedFilter">
                                                    <option value="" selected hidden>Select Filter</option>
                                                    <option v-for="(item,key) in filters"  v-if="checkFilterSelected(item.value,advance.selectedFilter)"  :value="item.value">{{item.text}}</option>
                                                </select>
                                            </div>
                                            <select v-model="advance.filterValues" id="filter-value" name="filter-value" class="form-control col-md-2 filter-width" @change="getAxios()">
                                                <option v-for="item in advance.advanceFilterValues" :value="item.value">
                                                    {{item.text}}
                                                </option>
                                            </select>
                                            <a href="javascript:;" class="filter-close" @click='RemoveAdvanceFilter(key)'><img :src="base_url+'img/ic_close.png'" alt=""></a>
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
                            <div class="advance-card advance-user col-md-3" @click="HideSortWrapper">
                                <div class="user-value">{{recordData.total}}</div>
                                <div class="advance-card-label">User Selected</div>
                            </div>
                            <div class="advance-card advance-gender col-md-3" @click="HideSortWrapper">
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
                            <div class="advance-card advance-country col-md-3" v-if="formdata.filter == 'location'" @click="HideSortWrapper">
                                <div class="country-value">{{ formdata.filterValue }}</div>
                                <div class="country-value" v-if="formdata.filterValue == ''"> - </div>
                                <div class="advance-card-label">Country</div>
                            </div>
                            <div class="advance-card advance-country col-md-3" v-if="formdata.filter != 'location'" @click="HideSortWrapper">
                                <div class="country-value">{{ countryCount }}</div>
                                <div class="advance-card-label">No. of Location</div>
                            </div>
                            <div class="advance-card advance-meter col-md-3" @click="HideSortWrapper">
                                <div class="meter-value">{{ up_meter(avgUpmoodmeter) }}</div>
                                <div class="advance-card-label">Average Upmood Meter</div>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table table-stripe users-table" @click="HideSortWrapper">
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
                            <td v-if="user.facebook_id != ''"><div class="table-profile-image"><img :src="user.image" alt=""></div></td>
                            <td v-else><div class="table-profile-image"><img :src="base_url+'img/'+user.image" alt=""></div></td>
                            <td><a :href="base_url + 'users/userProfile/'+user.id">{{ user.name }}</a></td>
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
                <div class="pagination" @click="HideSortWrapper">
                    <a v-on:click="preventPrev($event)" class="prev" :href="recordData.prev_page_url">Prev</a>
                    <div class="pagination-number" v-for="page in pageNumber">
                        <a :class="{ active: page.isActive }"  href="javascript:;" @click="preventPage(page.counter)">{{page.counter}}</a>
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


                disableFilterValue: true,
                disableSort: false,

                filterCount: 1,

                formdata: {
                    search: '',
                    filter: '',
                    filterValue: '',
                    sortCategory:'Name',
                    sortOrder:'ASC',
                    page: 1,
                    advanceFilterValues: '',
                    filterSelected: '',
                    advance_filter_id: 1
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
                ],

                pageNumber: [],
                sortValue: '',
            }
        },
        watch: {

        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-user-green"></i>Users');
            this.generatePaginationNumbers();
            this.searchFilters();
        },
        created() {
            this.updateData();
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
            },
        },
        methods: {
            selectAdvanceFilter(data,filter = null){

                if(this.formdata.filter != '' || this.filterSelected != null){
                    this.disableSort = true;
                }else{
                    this.disableSort = false;
                }

                this.formdata.sortCategory = '';
                this.formdata.sortOrder = '';
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

                    if(removeSelected != -1){
                        this.filterSelected.splice(removeSelected,1);
                    }

                    this.filterSelected.push({
                        id : 0,
                        value : filter
                    })

                    this.filterOptions = this[filter];
                    this.disableFilterValue = false;
                }  
            },

            addFilter(){

                if(this.filterCount < this.filters.length){

                    this.filterCount = this.filterCount + 1;

                    this.advanceFilter.push({
                        id: this.formdata.advance_filter_id,
                        selectedFilter: '', 
                        advanceFilterValues: '', 
                    });

                    this.formdata.advance_filter_id = this.formdata.advance_filter_id + 1;
                }
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
                this.pageNumber = [];
                var current = this.recordData.current_page;
                var counter = this.formdata.page;
                var lastpage = this.recordData.last_page;
                var path = this.recordData.path;
                var limit = 5;
                var limitControl = 2;
                var numberstring = "";

                // page control
                if (counter >= (lastpage - (limit - limitControl))+1){
                    counter = (lastpage - (limit - limitControl))+1;
                }

                if (counter <= 0){
                    counter = 1;
                }

                if (counter >= 3 ){
                    counter = counter - limitControl;
                }else{
                    counter = 1
                }
                // /page control

                // page creator
                for (var i = 0 ; i < limit ; i++){
                    if (i < lastpage ){

                        if (current == counter){
                            this.pageNumber.push({
                                isActive: true,
                                counter: counter,
                            }) 
                        }else{
                            this.pageNumber.push({
                                isActive: false,
                                counter: counter,
                            }) 
                        }

                    }
                    counter += 1;
                }
                // /page creator
            },

            updateData(){
                var filters = window.location.href.split('?')

                if(filters[1]){
                    var data = filters[1].split('&') 

                    this.formdata.search = decodeURIComponent(data[0].split('=')[1]);
                    this.formdata.filter = data[1].split('=')[1];
                    this.formdata.filterValue = data[2].split('=')[1];

                    if(data[3].split('=')[1] != ''){
                        this.formdata.sortCategory = decodeURIComponent(data[3].split('=')[1]);
                    }

                    if(data[4].split('=')[1] != ''){
                        this.formdata.sortOrder = decodeURIComponent(data[4].split('=')[1]);
                    }
                    this.formdata.page = parseInt(decodeURIComponent(data[5].split('=')[1]));

                    if(data[6].split('=')[1] != ''){
                        this.formdata.advanceFilterValues = decodeURIComponent(data[6].split('=')[1]);
                        this.advanceFilter = JSON.parse(decodeURIComponent(data[6].split('=')[1]));
                    }

                    if(data[7].split('=')[1] != ''){
                        this.formdata.filterSelected = decodeURIComponent(data[7].split('=')[1]);
                        this.filterSelected = JSON.parse(decodeURIComponent(data[7].split('=')[1]));
                    }

                    this.formdata.advance_filter_id = parseInt(data[8].split('=')[1]);

                    if(this.formdata.filter != ''){
                        this.filterOptions = this[data[1].split('=')[1]];
                        this.disableFilterValue = false;
                    }
                }
            },

            searchFilters(){
                let vue = this;

                let filter = vue.formdata;
                if(vue.advanceFilter.length != 0 ){
                    filter.advanceFilterValues = JSON.stringify(vue.advanceFilter);
                }else{
                    filter.advanceFilterValues = ''
                }

                if(vue.filterSelected.length != 0 ){
                    filter.filterSelected = JSON.stringify(vue.filterSelected);
                }else{
                    filter.filterSelected = ''
                }

                if(filter.filter  == 'age'){
                    filter.ageValue = JSON.stringify(filter.filterValue);
                }

                let data = {
                    query:filter
                }

                vue.$router.push(data);
                axios.get(base_url+'users/userFilter?'+window.location.href.split('?')[1]).then(function (response) {
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

            downloadFile() {
                window.open(base_url+'users/downloadFile?'+window.location.href.split('?')[1],'_self')
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

            preventPage(event){
                this.formdata.page = event
                this.searchFilters();
            },

            clearFields(){
                this.filterSelected = [];
                this.filterOptions = [];
                this.advanceFilter = [];
                this.sortValue = '';
                this.formdata.search = '';
                this.formdata.filter = '';
                this.formdata.filterValue = '';
                this.formdata.page = 1
                this.disableFilterValue = true;
                this.filterCount = 1;
                this.disableSort = false;
                this.formdata.sortCategory = '';
                this.formdata.sortOrder = '';

                this.searchFilters()
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

            selectSort(){
                this.searchFilters()
            },

            RemoveAdvanceFilter(event){

                this.filterCount = this.filterCount - 1;


                var duplicateId = this.filterSelected.find(item => item.id === this.advanceFilter[event].id);
                var removeSelected = this.filterSelected.indexOf(duplicateId);

                if(removeSelected != -1){
                    this.filterSelected.splice(removeSelected,1);
                }

                if(this.filterSelected.length != 0){
                    this.disableSort = true;
                }else{
                    this.disableSort = false;
                }

                this.advanceFilter.splice(event,1);
                this.searchFilters()
            },

            ToggleSortWrapper(){
                $(".sort-by-wrapper").toggle();
            },

            HideSortWrapper(){
                $(".sort-by-wrapper").hide();
            },


            getAxios: _.debounce(
                function () {
                    this.formdata.page = 1
                    this.searchFilters()
                },500
            )
        }
    }
</script>
