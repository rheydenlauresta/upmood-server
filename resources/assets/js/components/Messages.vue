<template>
    <div class="messages-wrapper">
        <div class="messages-nav">
            <button class="btn btn-success compose" v-on:click="ComposeMessage">Compose</button>
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
            <div class="messages-row-wrapper scrollbar-outer">
                <ul class="message-row-menu">
                    <li class="messages-row" data-message="#messagedisplay1">
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
                    <li class="messages-row" data-message="#messagedisplay2">
                        <div class="message-header row">
                            <div class="col-md-2">
                                <div class="image-wrapper ">
                                    <img :src="base_url+'img/profile-avatar.png'" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="name">Michael Jackson</div>
                                <div class="subject">Inquire</div>
                            </div>
                            <div class="col-md-3">
                                <div class="time pull-right">9:53 AM</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="message-glance col-md-11">
                                'Cause this is thriller Thriller night And no one’s gonna save you..........

                            </div>
                        </div>
                    </li>
                    <li class="messages-row" data-message="#messagedisplay3">
                        <div class="message-header row">
                            <div class="col-md-2">
                                <div class="image-wrapper ">
                                    <img :src="base_url+'img/profile-avatar.png'" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="name">Bimby</div>
                                <div class="subject">Inquire</div>
                            </div>
                            <div class="col-md-3">
                                <div class="time pull-right">8:42 AM</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="message-glance col-md-11">
                                Please tell darla to call my mom
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="messages-content" id="messagedisplay1">
            <div class="message-content-row">
                <div class="message-header">
                    <div class="image-wrapper pull-left">
                        <img :src="base_url+'img/profile-avatar.png'" alt="">
                    </div>
                    <div class="message-to">John Michael Cruz to Upmood admin</div>
                    <div class="message-subject">Inquire</div>
                    <div class="message-timestamp">
                        <div class="date">January 20, 2018</div>
                        <div class="time">10:43 AM</div>
                    </div>
                </div>
                <div class="content-body">
                    <div class="content-row">
                        <p>Hi Upmood Admin <br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.<br><br> orem ipsum dolor sit amet, consectetur</p>
                    </div>
                </div>
            </div>
            <div class="message-content-row message-reply">
                <div class="message-header">
                    <div class="message-to">Upmood admin to John Michael Cruz</div>
                    <div class="message-timestamp">
                        <div class="date">January 20, 2018</div>
                        <div class="time">10:43 AM</div>
                    </div>
                </div>
                <div class="content-body">
                    <div class="content-row">
                        <p>Hi John Michael Cruz<br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.<br><br> orem ipsum dolor sit amet, consectetur</p>
                    </div>
                </div>
            </div>
            <div class="message-reply-input">
                <form action="" method="post">
                    <textarea  name="" id="">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. |</textarea>
                    <button class="btn btn-success pull-right" type="submit">Send</button>
                </form>
            </div>
        </div>
        <div class="messages-content" id="messagedisplay2">
            <div class="message-content-row">
                <div class="message-header">
                    <div class="image-wrapper pull-left">
                        <img :src="base_url+'img/profile-avatar.png'" alt="">
                    </div>
                    <div class="message-to">Michael Jackson to Upmood admin</div>
                    <div class="message-subject">Inquire</div>
                    <div class="message-timestamp">
                        <div class="date">January 19, 2018</div>
                        <div class="time">9:53 AM</div>
                    </div>
                </div>
                <div class="content-body">
                    <div class="content-row">
                        <p>'Cause this is thriller<br>
                        Thriller night<br>
                        And no one’s gonna save you<br>
                        From the beast about to strike<br>
                        You know it’s thriller<br>
                        Thriller night<br>
                        You’re fighting for your life<br>
                        Inside a killer thriller tonight, yeah<br>
                        Ahahahahahahahaha<br>
                        I'm gonna bring it tonight<br>
                        </p>
                    </div>
                </div>
            </div>
            <div class="message-reply-input">
                <form action="" method="post">
                    <textarea  name="" id=""></textarea>
                    <button class="btn btn-success pull-right" type="submit">Send</button>
                </form>
            </div>
        </div>
        <div class="messages-content" id="messagedisplay3">
            <div class="message-content-row">
                <div class="message-header">
                    <div class="image-wrapper pull-left">
                        <img :src="base_url+'img/profile-avatar.png'" alt="">
                    </div>
                    <div class="message-to">Bimby to Upmood admin</div>
                    <div class="message-subject">Inquire</div>
                    <div class="message-timestamp">
                        <div class="date">January 18, 2018</div>
                        <div class="time">8:42 AM</div>
                    </div>
                </div>
                <div class="content-body">
                    <div class="content-row">
                        <p>Hi Upmood Admin <br><br>Please tell darla to call my mom</p>
                    </div>
                </div>
            </div>
            <div class="message-reply-input">
                <form action="" method="post">
                    <textarea  name="" id="">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. |</textarea>
                    <button class="btn btn-success pull-right" type="submit">Send</button>
                </form>
            </div>
        </div>
        <div class="messages-content" id="compose">
            <div class="compose-wrapper">
                <h2>Compose Message</h2>
                <button class="btn btn-success">Send</button>
                <form action="" method="post" id="ComposeForm">
                    <div class="form-group">
                        <label for="email-to">To:</label>
                        <input type="text" id="email-to" name="email-to" value="waylon.dalton@gmail.com,emilia.maria@yahoo.com" data-role="tagsinput">
                    </div>
                    <div class="form-group">
                        <label for="email-subject">Subject:</label>
                        <input type="text" id="email-subject" name="email-subject" class="form-control">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control autoExpand" name="" id=""></textarea>
                    </div>
                </form>
            </div>
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
            $(".main-header > .title").html('<i class="header-ic ic-message-green"></i>Messages');
            this.resizeMessageContent();
            this.highlightFirstMessage();
        },
        methods: {
            resizeMessageContent(){
                var wrapper_width = parseInt($(".messages-wrapper").css('width').replace('px',''));
                var nav = parseInt($(".messages-nav").css('width').replace('px',''));
                var list = parseInt($(".messages-list").css('width').replace('px',''));
                var new_width = wrapper_width - (nav + list);
                $(".messages-content").css('width',new_width + "px");

                var nav_height = parseInt($(".messages-nav").css('height').replace('px',''));
                $(".messages-content").css('height',nav_height + "px");
            },
            highlightFirstMessage(){
                if ($(".messages-row:first-child").length){
                    $(".messages-row:first-child").addClass('active');
                    $("#messagedisplay1").show();
                }
            },
            ComposeMessage(){
                $(".messages-row").removeClass('active');
                $(".messages-content").hide();
                $("#compose").fadeIn();
            }
        }
    }
</script>
