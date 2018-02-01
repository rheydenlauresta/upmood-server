<template>
    <div class="messages-wrapper">
        <div class="messages-nav">
            <button class="btn btn-success compose" v-on:click="ComposeMessage">Compose</button>
            <ul class="menu-list">
                <li><a href="javascript:;" @click="getContent('')">Inbox</a></li>
                <li><a href="javascript:;">Send</a></li>
                <li class="seperator"></li>
                <li><a href="javascript:;" @click="getContent('general')">General</a></li>
                <li><a href="javascript:;" @click="getContent('inquiries')">Inquires</a></li>
                <li><a href="javascript:;" @click="getContent('reports')">Reports</a></li>
                <li><a href="javascript:;" @click="getContent('account_cancellation')">Account Cancellation</a></li>
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
                <ul class="message-row-menu" v-for="message in messages">
                    <li class="messages-row" @click="viewMessage(message)" :id="'messages-row' + message.id">
                        <div class="message-header row">
                            <div class="col-md-2">
                                <div class="image-wrapper ">
                                    <img :src="base_url+'img/profile-avatar.png'" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="name">{{ message.name }}</div>
                                <div class="subject">{{ messageType(message.type) }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="time pull-right">{{ message.time_created }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="message-glance col-md-11">
                                {{ message.content | truncate('200')}}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="messages-content" id="messagedisplay">
            <div class="message-content-row">
                <div class="message-header">
                    <div class="image-wrapper pull-left">
                        <img :src="base_url+'img/profile-avatar.png'" alt="">
                    </div>
                    <div class="message-to">{{ messageContent.name }} to Upmood admin</div>
                    <div class="message-subject">{{ messageType(messageContent.type) }}</div>
                    <div class="message-timestamp">
                        <div class="date">{{ messageContent.date }}</div>
                        <div class="time">{{ messageContent.time }}</div>
                    </div>
                </div>
                <div class="content-body">
                    <div class="content-row">
                        <p>{{ messageContent.content }}</p>
                    </div>
                </div>
            </div>

            <div class="message-content-row message-reply" v-if="replyContent.message != ''">
                <div class="message-header">
                    <div class="message-to">Upmood admin to {{ messageContent.name }}</div>
                    <div class="message-timestamp">
                        <div class="date">{{ replyContent.date }}</div>
                        <div class="time">{{ replyContent.time }}</div>
                    </div>
                </div>
                <div class="content-body">
                    <div class="content-row">
                        <p>{{ replyContent.message }}</p>
                    </div>
                </div>
            </div>

            <div class="message-reply-input" v-if="replyContent.message == ''">
                <form action="" method="post">
                    <textarea v-model="formData.message" name="" id=""></textarea>
                    <button @click="sendMessage()" class="btn btn-success pull-right" type="button">Send</button>
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
                        <input type="text" id="email-to" name="email-to" value="waylon.dalton@gmail.com,emilia.maria@yahoo.com" data-role="tagsinput" v-on:click="HideContacts">
                        <div class="compose-suggestion">
                            <div class="suggestion-row">
                                <div class="image-wrapper">
                                    <img :src="base_url + 'img/profile-avatar.png'" alt="">
                                </div>
                                <div class="suggestion-content">
                                    <div class="suggestion-name">Waylon Dalton</div>
                                    <div class="suggestion-email">waylon.dalton@gmail.com</div>
                                    <i class="suggestion-ic ic-check-contact"></i>
                                </div>
                            </div>
                            <div class="suggestion-row">
                                <div class="image-wrapper">
                                    <img :src="base_url + 'img/profile-avatar.png'" alt="">
                                </div>
                                <div class="suggestion-content">
                                    <div class="suggestion-name">Drei</div>
                                    <div class="suggestion-email">drei@gmail.com</div>
                                </div>
                            </div>
                            <div class="suggestion-row">
                                <div class="image-wrapper">
                                    <img :src="base_url + 'img/profile-avatar.png'" alt="">
                                </div>
                                <div class="suggestion-content">
                                    <div class="suggestion-name">Waylon Dalton</div>
                                    <div class="suggestion-email">waylon.dalton@gmail.com</div>
                                </div>
                            </div>
                        </div>
                        <span class="add-contact ic-add-contact-messages" v-on:click="showContacts"></span>
                        <div class="contact-wrapper">
                            <div class="contact-search">
                                <form action="" method="post">
                                    <div class="form-group input-ic ic-search">
                                        <input type="text" class="form-control contact-search-input" placeholder="Search Email Address">
                                    </div>
                                </form>
                            </div>
                            <div class="contact-row">
                                <div class="image-wrapper">
                                    <img :src="base_url + 'img/profile-avatar.png'" alt="">
                                </div>
                                <div class="contact-content">
                                    <div class="contact-name">Waylon Dalton</div>
                                    <div class="contact-email">waylon.dalton@gmail.com</div>
                                    <i class="contact-ic ic-check-contact"></i>
                                </div>
                            </div>
                            <div class="contact-row">
                                <div class="image-wrapper">
                                    <img :src="base_url + 'img/profile-avatar.png'" alt="">
                                </div>
                                <div class="contact-content">
                                    <div class="contact-name">Drei</div>
                                    <div class="contact-email">drei@gmail.com</div>
                                </div>
                            </div>
                            <div class="contact-row">
                                <div class="image-wrapper">
                                    <img :src="base_url + 'img/profile-avatar.png'" alt="">
                                </div>
                                <div class="contact-content">
                                    <div class="contact-name">Waylon Dalton</div>
                                    <div class="contact-email">waylon.dalton@gmail.com</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email-subject">Subject:</label>
                        <input type="text" id="email-subject" name="email-subject" class="form-control" v-on:click="HideContacts">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control autoExpand" name="" id="" v-on:click="HideContacts"></textarea>
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

                messages: [],

                types: [{
                    'general': 'General',
                    'reports': 'Report',
                    'inquiries': 'Inquire',
                    'account_cancellation': 'Account Cancellation'
                }],

                messageContent: {
                    name: '',
                    type: '',
                    date: '',
                    time: '',
                    content: '',
                    id: 0,
                },

                replyContent: {
                    message: '',
                    date: '',
                    time: '',
                },

                formData: {
                    contact_message_id: 0,
                    message: '',
                }
            }
        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-message-green"></i>Messages');
            this.getContent('')
            this.highlightFirstMessage();
            this.resizeMessageContent()
        },

        filters: {
      
            truncate: function(string, value) {
                return string.substring(0, value) + '...';
            },
        },

        methods: {
            getContent(type){
                let vue = this;

                axios.get(base_url+'content?type='+type).then(function (response) {
                    vue.messages = response['data'];
                    vue.viewMessage(vue.messages[0]);
                }).catch(function (error) {
                });

            },

            messageType(type){
                return this.types[0][type]
            },

            viewMessage(message){

                let vue = this;

                this.messageContent.name = message.name;
                this.messageContent.type = message.type;
                this.messageContent.date = message.date_created;
                this.messageContent.time = message.time_created;
                this.messageContent.content = message.content;
                this.messageContent.id = message.id;

                axios.get(base_url+'reply?id='+message.id).then(function (response) {

                    if(response['data'].length > 0){
                        vue.replyContent.message = response['data'][0].message
                        vue.replyContent.date = response['data'][0].date_created
                        vue.replyContent.time = response['data'][0].time_created
                    }else{
                        vue.replyContent.message = ''
                        vue.replyContent.date = ''
                        vue.replyContent.time = ''
                    }
                }).catch(function (error) {
                });

                $(".messages-row").removeClass('active');
                $("#messages-row" + message.id).addClass('active');
                $("#compose").hide();
                $("#messagedisplay").fadeIn();
            },

            sendMessage(){
                let vue = this;

                vue.formData.contact_message_id = vue.messageContent.id;

                axios.post(base_url+'messages', this.formData).then(function (response) {
                    // vue.messages = response['data'];
                    // vue.viewMessage(vue.messages[0]);
                }).catch(function (error) {
                });
            },

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
            },
            showContacts(){
                $(".contact-wrapper").show();  
            },
            HideContacts(){
                $(".contact-wrapper").hide();
            }
        }
    }
</script>
