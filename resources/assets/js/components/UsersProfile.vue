<template>
    <div class="user-profile-wrapper">
        <div class="profile-info-container">
            <div class="row">
                <div class="col-md-2">
                    <div class="image-wrapper">
                        <img :src="profile.image" alt="" v-if="profile.facebook_id != null">
                        <img :src="base_url+'img/'+profile.image+ '.png'" alt=""  v-else>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="profile-info">
                        <div class="name">{{ profile.name }} <span class="badge-online"></span></div>
                        <div class="row">
                            <div class="col-md-1 text-semibold">Age:</div>
                            <div class="age col-md-5">{{ profile.age | emptyVal('age')}}</div>
                            <div class="col-md-1"><i class="ic-location"></i></div>
                            <div class="col-md-5 location">{{ profile.country | emptyVal(null)}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 text-semibold">Gender:</div>
                            <div class="col-md-11 gender">{{ profile.gender | emptyVal(null)}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="description" >"{{ profile.profile_post | emptyVal(null)}}"</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="current-emotion">
                    <div class="title">Current Emotion</div>
                    <div class="image-wrapper">
                        <img :src="base_url + 'img/resources/' + profile.emotion_set + '/emoji/' + profile.emotion_value + '.png'" alt="">
                    </div>
                    <div class="emotion-info">
                        <div class="row">
                            <div class="col-md-4">BPM:</div>
                            <div class="col-md-8 BPM">{{ profile.heartbeat_count }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Stress Level:</div>
                            <div class="col-md-8 stress-level">{{ profile.stress_level }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">Mood Meter:</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="upmood-meter">
                                    <div class="meter">
                                        <div class="meter-control current-emotion-meter">
                                            <img :src="profile.image" alt="" v-if="profile.facebook_id != null">
                                            <img :src="base_url+'img/'+profile.image+ '.png'" alt=""  v-else>
                                        </div>
                                    </div>
                                    <div class="row meter-description">
                                        <div class="description-tag">Sad</div>
                                        <div class="description-tag">Unpleasant</div>
                                        <div class="description-tag">Calm</div>
                                        <div class="description-tag">Pleasant</div>
                                        <div class="description-tag">Happy</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="mood-stream">
                    <div class="title">Mood Stream</div>
                    <div class="scrollbar-outer mood-stream-table infinite-wrapper" style="overflow-y:auto;">
                        <table class="table">
                            <thead>
                                <th>Time</th>
                                <th>BPM</th>
                                <th>No of PPI</th>
                                <th>Total Sum</th>
                                <th>Stress Level</th>
                                <th>Emotion</th>
                                <th>Reaction</th>
                            </thead>
                            <tbody v-for="(value,key) in upmoodMeter.data">
                                <tr>
                                    <td>{{ value.created_at }}</td>
                                    <td>{{ value.heartbeat_count }}</td>
                                    <td>{{ value.ppi | ppiCount(null) }}</td>
                                    <td>{{ value.total_ppi }}</td>
                                    <td>{{ value.stress_level }}</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/' + value.emotion_set + '/emoji/' + value.emotion_value + '.png'" alt=""></div></td>
                                    <td><div class="image-wrapper" v-if="value.set_name != null"><img :src="base_url + 'img/resources/' + value.set_name + '/' + value.type + '/' + value.filename" alt=""></div></td>
                                </tr>
                            </tbody>
                            
                        </table>
                        <infinite-loading @infinite="moodStreamInfiniteHandler" spinner="bubbles">
                            <span slot="no-more"></span>
                            <span id="moodstreamnoresults" slot="no-results"></span>
                        </infinite-loading>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="featured-friends">
                    <div class="title">Featured Friends</div>
                    <div class="scrollbar-outer featured-friends-table infinite-wrapper" style="overflow-y:auto">
                        <table class="table">
                            <thead>
                                <th>Name</th>
                                <th>Emotion</th>
                                <th>Reaction</th>
                            </thead>
                            <tbody v-for="value in featuredFriend.data">
                                <tr>
                                    <td>{{ value.name }}</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/' + value.emotion_set + '/emoji/' + value.emotion_value + '.png'" alt=""></div></td>
                                    <td><div class="image-wrapper" v-if="value.set_name != null"><img :src="base_url + 'img/resources/' + value.set_name + '/' + value.type + '/' + value.filename" alt=""></div></td>
                                </tr>
                            </tbody>
                        </table>
                        <infinite-loading @infinite="featuredInfiniteHandler" spinner="bubbles">
                            <span slot="no-more"></span>
                            <span id="featurednoresults" slot="no-results"></span>
                        </infinite-loading>
                    </div>
                </div>
            </div>
            <div class="col-md-8" id="animation-calendar">
                <div class="emotion-calendar col-md-6">
                    <div class="slide-calendar">
                        <div class="title">Upmood Emotion Calendar</div>
                        <div class="calendar-wrapper">
                            <vue-event-calendar :events="upmoodCalendar"  @month-changed="handleMonthChanged" @day-changed="handleDayChanged"></vue-event-calendar>
                        </div>
                    </div>
                    <div class="slide-calendar-emotion">
                        <div class="current-emotion for-calendar emotion-information">
                            <div class="title">Emotion Information</div>
                            <div class="calendar-close" @click="closeCurrentEmotion"><img :src="base_url + 'img/ic_close.png'"></div>
                            <div class="image-wrapper">
                                <img :src="base_url + 'img/resources/' + moodForTheDay.emotion_set + '/emoji/' + moodForTheDay.emotion_value + '.png'" alt="">
                            </div>
                            <div class="emotion-info">
                                <div class="row">
                                    <div class="col-md-4">BPM:</div>
                                    <div class="col-md-8 BPM">{{ moodForTheDay.heartbeat_count }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">Stress Level:</div>
                                    <div class="col-md-8 stress-level">{{ moodForTheDay.stress_level }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">Mood Meter:</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="upmood-meter">
                                            <div class="meter">

                                                <div class="meter-control">
                                                    <img :src="profile.image" alt="" v-if="profile.facebook_id != null">
                                                    <img :src="base_url+'img/'+profile.image+ '.png'" alt=""  v-else>
                                                </div>
                                            </div>
                                            <div class="row meter-description">
                                                <div class="description-tag">Sad</div>
                                                <div class="description-tag">Unpleasant</div>
                                                <div class="description-tag">Calm</div>
                                                <div class="description-tag">Pleasant</div>
                                                <div class="description-tag">Happy</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';
    export default {
        components: {
            InfiniteLoading,
        },
        props: ['profile','records','featured'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url,
                upmoodCalendar: [],
                upmoodMeter: [],
                moodForTheDay: [],
                featuredFriend: this.featured
            }
        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-user-green"></i>Users');
            $("#sidenav-users").addClass('active');
            this.UpdateCurrentMoodMeter(this.profile.upmood_meter);
            this.UpdateCalendarMoodMeter('happy');
            this.handleMonthChanged(new Date().getUTCMonth() + 1+'/'+new Date().getUTCFullYear());
            this.moodStream();
            
        },
        filters: {
      
            emptyVal: function(string,type) {

                if(string == null || string == ''){
                    return 'N/A'
                }else{
                    if(type == 'age'){
                        string = string + ' Years Old';
                    }
                    return string;
                }
            },

            ppiCount: function(string){
                return JSON.parse(string).length
            },
        },
        methods: {
            featuredInfiniteHandler($state) {
                setTimeout(() => {
                    let vue = this;
                    if(vue.featuredFriend.next_page_url != null){
                        axios.get(vue.featuredFriend.next_page_url).then(function (response) {
                            vue.featuredFriend.next_page_url = response['data']['next_page_url'];

                            $.each(response['data']['data'],function(k,v){
                                vue.featuredFriend.data.push(v);
                            })

                        }).catch(function (error) {
                        });
                        $state.loaded();
                    }else{
                        $state.complete();
                        if (vue.featuredFriend.data.length <= 0){
                            $("#featurednoresults").html('No Results');
                        }
                        else{
                            $("#featurednoresults").html('');   
                        }
                    }
                }, 1000);
            },
            moodStreamInfiniteHandler($state) {

                setTimeout(() => {
                    let vue = this;
                    if(vue.upmoodMeter.next_page_url != null){
                        axios.get(vue.upmoodMeter.next_page_url).then(function (response) {
                            vue.upmoodMeter.next_page_url = response['data']['next_page_url'];

                            $.each(response['data']['data'],function(k,v){
                                vue.upmoodMeter.data.push(v);
                            })

                        }).catch(function (error) {
                        });
                        $state.loaded();
                    }else{
                        $state.complete();
                        if (vue.featuredFriend.data.length <= 0){
                            $("#moodstreamnoresults").html('No Results');
                        }
                        else{
                            $("#moodstreamnoresults").html('');   
                        }
                    }
                }, 1000);
            },

            UpdateCurrentMoodMeter(mood){
                if (mood == 'Sad' || mood == 'sad'){
                    $(".current-emotion-meter").css('left','0px');
                }
                else if (mood == 'Unpleasant' || mood == 'unpleasant'){
                    $(".current-emotion-meter").css('left','62px');     
                }
                else if (mood == 'Calm' || mood == 'calm'){
                    $(".current-emotion-meter").css('left','134px');
                }
                else if (mood == 'Pleasant' || mood == 'pleasant'){
                    $(".current-emotion-meter").css('left','200px');
                }
                else if (mood == 'Happy' || mood == 'happy'){
                    $(".current-emotion-meter").css('left','263px');
                }
            },

            UpdateCalendarMoodMeter(mood){
                if (mood == 'Sad' || mood == 'sad'){
                    $(".calendar-emotion-meter").css('left','0px');
                }
                else if (mood == 'Unpleasant' || mood == 'unpleasant'){
                    $(".calendar-emotion-meter").css('left','62px');     
                }
                else if (mood == 'Calm' || mood == 'calm'){
                    $(".calendar-emotion-meter").css('left','134px');
                }
                else if (mood == 'Pleasant' || mood == 'pleasant'){
                    $(".calendar-emotion-meter").css('left','200px');
                }
                else if (mood == 'Happy' || mood == 'happy'){
                    $(".calendar-emotion-meter").css('left','263px');
                }
            },

            moodStream(){
                let vue = this;
                axios.get(base_url+'users/moodStream/'+this.profile.id).then(function (response) {
                    vue.upmoodMeter.next_page_url = response['data']['next_page_url'];
                    vue.upmoodMeter = response['data'];

                }).catch(function (error) {
                });
            },

            handleMonthChanged(val){
                let vue = this;

                var date = val.split('/');

                if(date[0].length == 1){
                    date[0] = '0'+date[0];
                }
                var dateFormat = date[1]+'-'+date[0];
                
                axios.get(base_url+'users/upmoodCalendar?id='+this.profile.id+'&date='+dateFormat).then(function (response) {
                    vue.upmoodCalendar = response['data'];
                }).catch(function (error) {
                });
            },

            handleDayChanged(val){
                let vue = this;

                var date = val.date.split('/');

                if(date[1].length == 1){
                    date[1] = '0'+date[1];
                }
                var dateFormat = date[0]+'-'+date[1]+'-'+date[2];
                
                axios.get(base_url+'users/moodForTheDay?id='+this.profile.id+'&date='+dateFormat).then(function (response) {
                    vue.moodForTheDay = response.data;
                }).catch(function (error) {
                });
            },

            closeCurrentEmotion(){
                $(".slide-calendar").removeClass('slide-out');
                $(".slide-calendar-emotion").removeClass('slide-in');
            }
        }
    }
</script>
