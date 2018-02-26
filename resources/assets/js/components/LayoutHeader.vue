<template>
    <div class="main-header">
        <div class="title"></div>
        <div class="header-right">
            <div class="notification">
                <i class="nav-ic ic-notification" @click="toggleNotification"></i>
                <div class="notification-count notification-count-active">{{ notificationCount }}</div>
                <div class="notification-list">
                    <div class="notification-empty" v-if="this.notificationCount == 0">
                        <div class="image-wrapper">
                            <img :src="base_url +'img/ic_no_notification.png'" alt="">
                        </div>
                        <span>No Notification</span>
                    </div>
                    <div class="notification-list-container" v-if="this.notificationCount > 0">
                        <div class="title">Notifications</div>
                        <div class="scrollbar-outer infinite-wrapper" style="overflow-y:auto" >
                            <ul v-for="noti in notification.data">
                                <li><a :href="base_url+'messages?message='+noti.id">
                                    <div class="list-wrapper">
                                        <div class="image-flex">
                                            <div class="image-wrapper">
                                                <img :src="noti.image" alt="" v-if="noti.facebook_id != null">
                                                <img :src="base_url+'img/'+noti.image+'.png'" alt=""  v-else>
                                            </div>
                                        </div>
                                        <div class="content-wrapper content-flex">
                                            <div class="content">{{ noti.name }}, send an inquire <b>"{{noti.content | truncate('50')}}"</b></div>
                                            <div class="time">{{ noti.date_created }} {{ noti.time_created }}</div>
                                        </div>
                                    </div>
                                </a></li>
                            </ul>
                            <infinite-loading @infinite="notificationInfiniteHandler" ref="infiniteLoading" spinner="bubbles"></infinite-loading>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile"><a class="logout-link" href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img :src="base_url + 'img/profile-avatar.png'" alt=""></a></div>


            <form id="logout-form" :action="base_url + 'logout'" method="POST" style="display: none;">
                <input type="hidden" name="_token" :value="csrf">
            </form>
        </div>
    </div>
</template>
<script>
    import InfiniteLoading from 'vue-infinite-loading';
    import { EventBus } from '../app.js';
    export default {
        components: {
            InfiniteLoading,
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url,
                notification: [],
                notificationCount: 0,
            }
        },
        mounted() {
            var socket = io('http://localhost:8012');

            socket.on('notification', function(response) {
                this.notification = response.data
                this.notificationCount = response.data.total

            }.bind(this))

            this.getNoti();

        },

        created(){
            this.events()
        },

        filters: {
      
            truncate: function(string, value) {
                if(string.length > value){
                    return string.substring(0, value) + '...';
                }else{

                    return string;
                }
            },
        },

        methods:{
            events(){
                let vue = this;
                EventBus.$on('updateNoti', function(data){
                    vue.getNoti()
                });
            },

            notificationInfiniteHandler($state) {
                setTimeout(() => {
                    let vue = this;
                    if(vue.notification.next_page_url != null){
                        axios.get(base_url+'messages/getUnseen?page='+(vue.notification.current_page + 1)).then(function (response) {
                            vue.notification.next_page_url = response.data.next_page_url;
                            vue.notification.current_page = (vue.notification.current_page + 1);

                            $.each(response['data']['data'],function(k,v){
                                vue.notification.data.push(v);
                            })

                        }).catch(function (error) {
                        });
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                }, 1000);
            },

            getNoti(){
                let vue = this;

                axios.get(base_url+'/messages/getUnseen').then(function (response) {
                    vue.notification = response.data;
                    vue.notificationCount = response.data.total;

                }).catch(function (error) {
                });
            },

            toggleNotification(){
                $(".notification-list").toggle();
            }
        }
    }
</script>