<template>
    <div class="user-profile-wrapper">
        <div class="profile-info-container">
            <div class="row">
                <div class="col-md-2">
                    <div class="image-wrapper">
                        <img :src="base_url + 'img/profile-avatar.png'" alt="">
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="profile-info">
                        <div class="name">{{ profile.name }} <span class="badge-online"></span></div>
                        <div class="row">
                            <div class="col-md-1 text-semibold">Age:</div>
                            <div class="age col-md-5">{{ profile.age }} Years Old</div>
                            <div class="col-md-1"><i class="ic-location"></i></div>
                            <div class="col-md-5 location">{{ profile.country }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 text-semibold">Gender:</div>
                            <div class="col-md-11 gender">{{ profile.gender }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="description" v-if="profile.profile_post != null">"{{ profile.profile_post }}"</div>
                                <div class="description" v-else>"No Post"</div>
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
                                        <div class="meter-control">
                                            <img :src="base_url + 'img/profile-avatar.png'" alt="">
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
                                    <td>{{ value.ppi }}</td>
                                    <td>{{ value.total_ppi }}</td>
                                    <td>{{ value.stress_level }}</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/' + value.emotion_set + '/emoji/' + value.emotion_value + '.png'" alt=""></div></td>
                                    <td><div class="image-wrapper" v-if="value.set_name != null"><img :src="base_url + 'img/resources/' + value.set_name + '/' + value.type + '/' + value.filename" alt=""></div></td>
                                </tr>
                            </tbody>
                            
                        </table>
                        <infinite-loading @infinite="moodSteamInfiniteHandler" spinner="bubbles">
                            <span slot="no-more"></span>
                            <span slot="no-results"></span>
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
                            <span slot="no-results"></span>
                        </infinite-loading>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="emotion-calendar">
                    <div class="title">Upmood Emotion Calendar</div>
                    <div class="calendar-wrapper">
                        <vue-event-calendar :events="demoEvents"  @month-changed="handleMonthChanged"></vue-event-calendar>
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
                demoEvents: [],
                sample: [],
                sample2: [],
                upmoodMeter: this.records,
                featuredFriend: this.featured
            }
        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-user-green"></i>Users');
            this.UpdateMoodMeter(this.profile.upmood_meter);
            this.handleMonthChanged(new Date().getUTCMonth() + 1+'/'+new Date().getUTCFullYear());
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
                    }
                }, 1000);
            },
            moodSteamInfiniteHandler($state) {
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
                    }
                }, 1000);
            },

            UpdateMoodMeter(mood){
                if (mood == 'Sad' || mood == 'sad'){
                    $(".meter-control").css('left','0px');
                }
                else if (mood == 'Unpleasant' || mood == 'unpleasant'){
                    $(".meter-control").css('left','62px');     
                }
                else if (mood == 'Calm' || mood == 'calm'){
                    $(".meter-control").css('left','134px');
                }
                else if (mood == 'Pleasant' || mood == 'pleasant'){
                    $(".meter-control").css('left','200px');
                }
                else if (mood == 'Happy' || mood == 'happy'){
                    $(".meter-control").css('left','263px');
                }
            },

            handleMonthChanged(val){
                let vue = this;

                var date = val.split('/');

                if(date[0].length == 1){
                    date[0] = '0'+date[0];
                }

                var dateFormat = date[1]+'-'+date[0];
                
                axios.get(base_url+'users/upmoodCalendar?id='+this.profile.id+'&date='+dateFormat).then(function (response) {
                    vue.demoEvents = response['data'];
                }).catch(function (error) {
                });
            }
        }
    }
</script>
