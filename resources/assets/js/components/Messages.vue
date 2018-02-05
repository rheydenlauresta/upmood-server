<template>
    <div class="messages-wrapper">
        <div class="messages-nav">
            <button class="btn btn-success compose" v-on:click="ComposeMessage">Compose</button>
            <ul class="menu-list">
                <li><a href="javascript:;" @click="getContent('')">Inbox</a></li>
                <li><a href="javascript:;" @click="getContent('sentMessage')">Send</a></li>
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
                    <input v-model="search" @keyup="getAxios()" type="text"  name="messages-search" class="form-control messages-search" placeholder="Search Messages">
                </div>
            </form>
            <div class="messages-row-wrapper scrollbar-outer">
                <ul class="message-row-menu" v-for="message in messages">
                    <li class="messages-row" @click="viewMessage(message)" :id="'message' + message.id">
                        <div class="message-header row">
                            <div class="col-md-2">
                                <div class="image-wrapper ">
                                    <img :src="base_url+'img/'+message.image" alt="">
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
                        <img :src="base_url+'img/'+messageContent.image" alt="">
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
                    <button @click="sendReply()" class="btn btn-success pull-right" type="button" :disabled="sendButton.disable">{{ sendButton.text }}</button>
                </form>
            </div>
        </div>

        <div class="messages-content" id="compose">
            <div class="compose-wrapper">
                <h2>Compose Message</h2>
                <button @click="sendMessage()" class="btn btn-success" :disabled="sendButton.disable">{{ sendButton.text }}</button>
                <form action="" method="post" id="ComposeForm">
                    <div class="form-group">
                        <div @keyup="emailSearch()">
                            <label for="email-to">To:</label>
                            <input type="text" id="email-to" name="email-to"  data-role="tagsinput">
                        </div>
                        <div class="compose-suggestion" >

                            <div class="suggestion-row" v-for="availableEmail in availableEmails" @click="selectEmail(availableEmail.email)">
                                <div class="image-wrapper">
                                    <img :src="base_url + 'img/'+availableEmail.image" alt="">
                                </div>
                                <div class="suggestion-content">
                                    <div class="suggestion-name">{{availableEmail.name}}</div>
                                    <div class="suggestion-email">{{availableEmail.email}}</div>
                                    <i class="suggestion-ic ic-check-contact" ></i>
                                </div>
                            </div>

                        </div>

                        <!-- <span class="add-contact ic-add-contact-messages" @click="showContacts"></span> -->

    <!--                     <div class="contact-wrapper">
                            <div class="contact-search">
                                <form action="" method="post">
                                    <div class="form-group input-ic ic-search">
                                        <input v-model="contactEmail" type="text" class="form-control contact-search-input" placeholder="Search Email Address" @keyup="emailSearch()">
                                    </div>
                                </form>
                            </div>
                            <div class="contact-row" v-for="availableEmail in availableEmails" @click="selectEmail(availableEmail.email)">
                                <div class="image-wrapper">
                                    <img :src="base_url + 'img/'+availableEmail.image" alt="">
                                </div>
                                <div class="contact-content">
                                    <div class="contact-name">{{availableEmail.name}}</div>
                                    <div class="contact-email">{{availableEmail.email}}</div>
                                    <i class="contact-ic ic-check-contact"></i>
                                </div>
                            </div>
                        </div> -->

                    </div>
                    <div class="form-group">
                        <label for="email-subject">Subject:</label>
                        <input v-model="composeMessage.subject" type="text" id="email-subject" name="email-subject" class="form-control" @click="HideContacts">
                    </div>
                    <div class="form-group">
                        <textarea v-model="composeMessage.message" class="form-control autoExpand" name="" id="" @click="HideContacts"></textarea>
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
                availableEmails: [],

                search: "",
                type: "",
                emailString: "",
                contactEmail: "",

                sendButton:{
                    disable: false,
                    text: 'Send',
                },

                types:{
                    general: 'General',
                    reports: 'Report',
                    inquiries: 'Inquire',
                    account_cancellation: 'Account Cancellation'
                },

                messageContent: {
                    name: '',
                    type: '',
                    date: '',
                    time: '',
                    content: '',
                    image: '',
                    id: 0,
                },


                replyContent: {
                    message: '',
                    date: '',
                    time: '',
                },

                composeMessage: {
                    emailArray: [],
                    subject: '',
                    message: '',
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
            messageType(type){
                return this.types[type]
            },

            getContent(type){
                let vue = this;

                if(typeof type != 'undefined'){
                    vue.type = type;
                }

                axios.get(base_url+'messages/getMessages?type='+vue.type+'&search='+vue.search).then(function (response) {
                    vue.messages = response['data'];
                    vue.viewMessage(vue.messages[0]);
                }).catch(function (error) {
                });
            },

            getReply(id){
                let vue = this;

                axios.get(base_url+'messages/getReplies?id='+id).then(function (response) {

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
            },

            viewMessage(message){

                let vue = this;

                this.messageContent.name = message.name;
                this.messageContent.type = message.type;
                this.messageContent.date = message.date_created;
                this.messageContent.time = message.time_created;
                this.messageContent.content = message.content;
                this.messageContent.image = message.image;
                this.messageContent.id = message.id;

                this.getReply(message.id);

                $(".messages-row").removeClass('active');
                $("#message" + message.id).addClass('active');
                $("#compose").hide();
                $("#messagedisplay").hide();
                $("#messagedisplay").fadeIn(500);
            },

            sendReply(){
                this.formData.contact_message_id = this.messageContent.id;
                this.formData._method = 'PUT';
                this.submit('messages/sendReply', this.formData, 'clearFormData')
            },

            sendMessage(){
                this.emailString = $('#email-to').val()
                this.composeMessage.emailArray = this.emailString.split(",");
                this.composeMessage._method = 'PUT';

                this.submit('messages/sendMessage', this.composeMessage, 'clearComposeMessage')
            },

            submit(url, data, successAction){
                let vue = this;

                vue.sendButton.disable = true;
                vue.sendButton.text = 'Sending';

                axios.post(base_url+url, data).then(function (response) {
                    vue.sendButton.disable = false;
                    vue.sendButton.text = 'Send';

                    if(successAction == 'clearFormData'){
                        vue.formData.contact_message_id = 0;
                        vue.formData.message = '';
                        vue.getReply(vue.messageContent.id);
                    }else if(successAction == 'clearComposeMessage'){
                        vue.composeMessage.emailArray = [];
                        vue.composeMessage.subject = '';
                        vue.composeMessage.message = '';
                        $('#email-to').val('');
                        $('#email-to').tagsinput('removeAll');
                    }
                    
                }).catch(function (error) {
                });
            },

            emailSearch: _.debounce(
                function(){
                    let vue = this;

                    var searchEmail = $('.bootstrap-tagsinput > input').val(); 

                    axios.get(base_url+'messages/emailSearch?email='+searchEmail+'&conemail='+vue.contactEmail).then(function (response) {
                        vue.availableEmails = response['data'];
                        $(".suggestion-row").show();

                    }).catch(function (error) {
                    });
                },100
            ),

            selectEmail(val){
                // alert()
                $('#email-to').tagsinput('add', val);
                $('#email-to').tagsinput('refresh');
                $(".contact-wrapper").hide();
                $(".compose-suggestion").hide();
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
                $(".compose-suggestion").hide();
            },

            HideContacts(){
                $(".contact-wrapper").hide();
            },

            getAxios: _.debounce(
                function () {
                    this.getContent()
                },500
            )
        }
    }
</script>