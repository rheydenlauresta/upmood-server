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
                <div class="mood-steam">
                    <div class="title">Mood Steam</div>
                    <div class="scrollbar-outer mood-steam-table">
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
                            <tbody v-for="(record,key) in records">
                                <tr>
                                    <td>{{ record.created_at }}</td>
                                    <td>{{ record.heartbeat_count }}</td>
                                    <td>{{ record.ppi }}</td>
                                    <td>{{ record.total_ppi }}</td>
                                    <td>{{ record.stress_level }}</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/' + record.emotion_set + '/emoji/' + record.emotion_value + '.png'" alt=""></div></td>
                                    <td><div class="image-wrapper" v-if="record.set_name != null"><img :src="base_url + 'img/resources/' + record.set_name + '/' + record.type + '/' + record.filename" alt=""></div></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="table-loading">
                            <div class="loading"><img :src="base_url + 'img/spinner.svg'" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="featured-friends">
                    <div class="title">Featured Friends</div>
                    <div class="scrollbar-outer featured-friends-table">
                        <table class="table">
                            <thead>
                                <th>Name</th>
                                <th>Emotion</th>
                                <th>Reaction</th>
                            </thead>
                            <tbody v-for="feature in featured">
                                <tr>
                                    <td>{{ feature.name }}</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/' + feature.emotion_set + '/emoji/' + feature.emotion_value + '.png'" alt=""></div></td>
                                    <td><div class="image-wrapper" v-if="feature.set_name != null"><img :src="base_url + 'img/resources/' + feature.set_name + '/' + feature.type + '/' + feature.filename" alt=""></div></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="table-loading">
                            <div class="loading"><img :src="base_url + 'img/spinner.svg'" alt=""></div>
                        </div>
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
    export default {
        props: ['profile','records','featured'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url,
                demoEvents: [
                    // {
                    //     date: '2018/02/5',
                    //     // title: 'Bar',
                    //     // desc: 'description',
                    //     customClass: 'calendar-ic emoji-gummybear-pleasant' // Custom classes to an calendar cell
                    // }
                ],
            }
        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-user-green"></i>Users');
            // this.Notify("Well Done!","You're message has been successfully sent");
            this.UpdateMoodMeter(this.profile.upmood_meter);
            this.handleMonthChanged(new Date().getUTCMonth() + 1+'/'+new Date().getUTCFullYear());
        },
        methods: {
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

                axios.get(base_url+'users/upmoodCalendar?id='+this.profile.id+'&date='+val).then(function (response) {
                    // vue.demoEvents = response['data'];
                    // vue.demoEvents.title = 'Bar';
                    // vue.demoEvents.desc = 'description';
                    // console.log(response['data'])
                }).catch(function (error) {
                });
            }
            // Notify(title,message){
            //     $('.notification-title').html(title);
            //     $('.notification-description').html(message);
            //     $('#notification-modal').modal('toggle');
            // }
        }
    }
</script>
