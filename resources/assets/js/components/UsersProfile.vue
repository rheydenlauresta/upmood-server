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
                        <div class="name">Samuel Newman <span class="badge-online"></span></div>
                        <div class="row">
                            <div class="col-md-1 text-semibold">Age:</div>
                            <div class="age col-md-5">26 Years Old</div>
                            <div class="col-md-1"><i class="ic-location"></i></div>
                            <div class="col-md-5 location">Metro Manila, Philippines</div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 text-semibold">Gender:</div>
                            <div class="col-md-11 gender">Male</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="description">"Infuse your life with action. Don't wait for it to happen. Make it happen. Make your own future. Make your own hope. Make your own love. And whatever your beliefs, honor your creator, not by passively waiting for grace to come down from upon high, but by doing what you can to make grace happen... yourself, right now, right down here on Earth."</div>
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
                        <img :src="base_url + 'img/resources/gummybear/emoji/confused.png'" alt="">
                    </div>
                    <div class="emotion-info">
                        <div class="row">
                            <div class="col-md-4">BPM:</div>
                            <div class="col-md-8 BPM">43.7405</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">Stress Level:</div>
                            <div class="col-md-8 stress-level">Moderate</div>
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
                            <tbody>
                                <tr>
                                    <td>01-20-18 12:21:43 AM</td>
                                    <td>43.705</td>
                                    <td>202</td>
                                    <td>180160</td>
                                    <td>Moderate</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>01-20-18 12:21:43 AM</td>
                                    <td>43.705</td>
                                    <td>202</td>
                                    <td>180160</td>
                                    <td>Moderate</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>01-20-18 12:21:43 AM</td>
                                    <td>43.705</td>
                                    <td>202</td>
                                    <td>180160</td>
                                    <td>Moderate</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>01-20-18 12:21:43 AM</td>
                                    <td>43.705</td>
                                    <td>202</td>
                                    <td>180160</td>
                                    <td>Moderate</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>01-20-18 12:21:43 AM</td>
                                    <td>43.705</td>
                                    <td>202</td>
                                    <td>180160</td>
                                    <td>Moderate</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>01-20-18 12:21:43 AM</td>
                                    <td>43.705</td>
                                    <td>202</td>
                                    <td>180160</td>
                                    <td>Moderate</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>01-20-18 12:21:43 AM</td>
                                    <td>43.705</td>
                                    <td>202</td>
                                    <td>180160</td>
                                    <td>Moderate</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>01-20-18 12:21:43 AM</td>
                                    <td>43.705</td>
                                    <td>202</td>
                                    <td>180160</td>
                                    <td>Moderate</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                            </tbody>
                        </table>
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
                            <tbody>
                                <tr>
                                    <td>Fname Lname</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>Fname Lname</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>Fname Lname</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>Fname Lname</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>Fname Lname</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>Fname Lname</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>Fname Lname</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                                <tr>
                                    <td>Fname Lname</td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/regular/emoji/confused.png'" alt=""></div></td>
                                    <td><div class="image-wrapper"><img :src="base_url + 'img/resources/chick/emoji/happy.png'" alt=""></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="emotion-calendar">
                    <div class="title">Upmood Emotion Calendar</div>
                    <div class="calendar-wrapper">
                        <vue-event-calendar :events="demoEvents"></vue-event-calendar>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url,
                demoEvents: [{
                    date: '2016/11/12', // Required
                    title: 'Foo' // Required
                  }, {
                    date: '2018/02/5',
                    title: 'Bar',
                    desc: 'description',
                    customClass: 'calendar-ic emoji-gummybear-pleasant' // Custom classes to an calendar cell
                  },{
                    date: '2018/02/1',
                    title: 'asd',
                    desc: 'description',
                    customClass: 'calendar-ic emoji-pancake-sad' // Custom classes to an calendar cell
                  },{
                    date: '2018/02/2',
                    title: 'asd',
                    desc: 'description',
                    customClass: 'calendar-ic emoji-pancake-sad' // Custom classes to an calendar cell
                  },{
                    date: '2018/02/3',
                    title: 'asd',
                    desc: 'description',
                    customClass: 'calendar-ic emoji-regular-happy' // Custom classes to an calendar cell
                  },{
                    date: '2018/02/4',
                    title: 'asd',
                    desc: 'description',
                    customClass: 'calendar-ic emoji-regular-happy' // Custom classes to an calendar cell
                  }]
            }
        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-user-green"></i>Users');
            this.Notify("Well Done!","You're message has been successfully sent");
            this.UpdateMoodMeter('sad');
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
            Notify(title,message){
                $('.notification-title').html(title);
                $('.notification-description').html(message);
                $('#notification-modal').modal('toggle');
            }
        }
    }
</script>
