<template>
    <div class="messages-wrapper">
        <div class="messages-nav">
            <button class="btn btn-success compose">Compose</button>
            <ul class="menu-list">
                <li><a href="javascript:;">Inbox</a></li>
                <li><a href="javascript:;">Send</a></li>
                <li class="seperator"></li>
                <li><a href="javascript:;">General</a></li>
                <li><a href="javascript:;">Inquires</a></li>
                <li><a href="javascript:;">Reports</a></li>
                <li><a href="javascript:;">Account Cancellation</a></li>
            </ul>
        </div>
        <div class="messages-list">
            <form action="" method="post">
                <input type="hidden" :value="csrf">
                <div class="input-ic ic-search messages-search-wrapper">
                    <input type="text"  name="messages-search" class="form-control messages-search" placeholder="Search Messages">
                </div>
            </form>
            <div class="messages-row-wrapper">
                <ul class="message-row-menu">
                    <li class="messages-row">
                        <div class="message-header row">
                            <div class="col-md-2">
                                <div class="image-wrapper ">
                                    <img :src="base_url+'img/profile-avatar.png'" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="name">John Michael Cruz</div>
                                <div class="subject">Inquire</div>
                            </div>
                            <div class="col-md-3">
                                <div class="time pull-right">10:52 AM</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="message-glance col-md-11">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ..........
                            </div>
                        </div>
                    </li>
                    <li class="messages-row active">
                        <div class="message-header row">
                            <div class="col-md-2">
                                <div class="image-wrapper ">
                                    <img :src="base_url+'img/profile-avatar.png'" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="name">John Michael Cruz</div>
                                <div class="subject">Inquire</div>
                            </div>
                            <div class="col-md-3">
                                <div class="time pull-right">10:52 AM</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="message-glance col-md-11">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ..........
                            </div>
                        </div>
                    </li>
                    <li class="messages-row">
                        <div class="message-header row">
                            <div class="col-md-2">
                                <div class="image-wrapper ">
                                    <img :src="base_url+'img/profile-avatar.png'" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="name">John Michael Cruz</div>
                                <div class="subject">Inquire</div>
                            </div>
                            <div class="col-md-3">
                                <div class="time pull-right">10:52 AM</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="message-glance col-md-11">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ..........
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="messages-content">
            
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url,
            }
        },
        mounted() {
           this.resizeMessageContent();
            $(".main-header > .title").html('<i class="header-ic ic-message-green"></i>Messages');
        },
        methods: {
            resizeMessageContent(){
                var wrapper_width = $(".messages-wrapper").css('width').replace('px','');
                var nav = $(".messages-nav").css('width').replace('px','');
                var list = $(".messages-list").css('width').replace('px','');
                var new_width = parseInt(wrapper_width) - (parseInt(nav) + parseInt(list));
                $(".messages-content").css('width',new_width + "px");

                var nav_height = $(".messages-nav").css('height');
                $(".messages-content").css('height',nav_height);
            }
        }
    }
</script>
