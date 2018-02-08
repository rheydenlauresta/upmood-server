<template>
    <div class="main-header">
        <div class="title"></div>
        <div class="header-right">
            <div class="notification">
                <i class="nav-ic ic-notification" @click="toggleNotification"></i>
                <div class="notification-count notification-count-active">0</div>
                <div class="notification-list">
                    <!-- <div class="notification-empty">
                        <div class="image-wrapper">
                            <img :src="base_url +'img/ic_no_notification.png'" alt="">
                        </div>
                        <span>No Notification</span>
                    </div> -->
                    <div class="notification-list-container">
                        <div class="title">Notifications</div>
                        <div class="scrollbar-outer infinite-wrapper" style="overflow-y:auto" >
                            <ul v-for="noti in notification">
                                <li><a href="javascript:;">
                                    <div class="list-wrapper">
                                        <div class="image-flex">
                                            <div class="image-wrapper">
                                                <img :src="base_url + 'img/profile-avatar.png'" alt="">
                                            </div>
                                        </div>
                                        <div class="content-wrapper content-flex">
                                            <div class="content">Fname Lname, send an inquire <b>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod"</b></div>
                                            <div class="time">A few minutes ago</div>
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
    export default {
        components: {
            InfiniteLoading,
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url,
                notification: []
            }
        },
        mounted() {

        },

        methods:{
            notificationInfiniteHandler($state) {
                setTimeout(() => {
                    const temp = [];
                    for (let i = this.notification.length + 1; i <= this.notification.length + 10; i++) {
                      temp.push(i);
                    }
                    this.notification = this.notification.concat(temp);
                    $state.loaded();
                }, 1000);
            },

            toggleNotification(){
                $(".notification-list").toggle();
                this.notificationInfiniteHandler();
            }
        }
    }
</script>