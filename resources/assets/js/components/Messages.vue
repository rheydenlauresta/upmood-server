<template>
    <div class="messages-wrapper">
        <div class="messages-nav">
            <button class="btn btn-success compose" v-on:click="ComposeMessage">Compose</button>
            <ul class="menu-list">
                <li><a href="javascript:;" @click="getContent('')">Inbox</a></li>
                <li><a href="javascript:;" @click="getSent('send')">Send</a></li>
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
            <!-- messages -->
            <div class="messages-row-wrapper scrollbar-outer infinite-wrapper messages-menu" style="overflow-y:auto">
                <ul class="message-row-menu">
                    <div v-for="message in messages.data">
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
                    </div>
                </ul>
                <infinite-loading @infinite="messageInfiniteHandler" ref="infiniteLoading" spinner="bubbles"></infinite-loading>
            </div>
            <!-- //messages -->

            <!-- sent messages -->
            <div class="messages-row-wrapper scrollbar-outer infinite-wrapper sent-menu" style="overflow-y:auto;">
                <ul class="message-row-menu">
                    <div v-for="sentMessage in sentMessages.data">
                        <li class="messages-row" @click="viewSentmail(sentMessage)">
                            <div class="message-header row">
                                <div class="col-md-8">
                                    <div class="name">{{ sentMessage.emails | truncate('35')}}</div>
                                    <div class="subject">{{ sentMessage.subject }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="time pull-right">{{ sentMessage.time_created }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="message-glance col-md-11">
                                    <pre>{{sentMessage.message | truncate('200')}}</pre>
                                </div>
                            </div>
                        </li>
                    </div>
                </ul>
                <infinite-loading @infinite="sentInfiniteHandler" ref="sentInfiniteLoading" spinner="bubbles"></infinite-loading>
            </div>
        </div>
        <!-- /sent messages -->

        <!-- display&reply messages -->
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
                        <pre>{{ replyContent.message }}</pre>
                    </div>
                </div>
            </div>

            <div class="message-reply-input" v-if="replyContent.message == ''">
                <form action="" method="post">
                    <textarea v-model="formData.message" name="" id=""></textarea>
                    <button @click="sendReply()"  data-toggle="modal" data-target="#notification-modal" class="btn btn-success pull-right" type="button" :disabled="sendButton.disable">{{ sendButton.text }}</button>
                </form>
            </div>
        </div>
        <!-- /display&reply messages -->

        <!-- compose messages -->
        <div class="messages-content" id="compose">
            <div class="compose-wrapper">
                <h2>Compose Message</h2>
                <button @click="sendMessage()" data-toggle="modal" data-target="#notification-modal" class="btn btn-success" :disabled="sendButton.disable">{{ sendButton.text }}</button>
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
                                    <i class="suggestion-ic ic-check-contact" v-if="checkSelected(availableEmail.email)"></i>
                                </div>
                            </div>

                        </div>

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
        <!-- /compose messages -->

        <!-- display sent messages -->
        <div class="messages-content" id="messagesent" >
            <div class="message-sent-wrapper">
                <h2>{{ composeContent.subject }}</h2>
                <div class="content-body">
                    <div class="row">
                        <div class="sent-to">
                            <span class="sent-label col-md-1">To:</span>
                            <ul class="sent-tags col-md-11">
                                <li  v-for="composeContent in composeContent.emails">{{ composeContent }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="sent-from">
                            <span class="sent-label col-md-1">From:</span>
                            <ul class="sent-tags col-md-11">
                                <li>admin@upmood.com</li>
                            </ul>
                        </div>
                    </div>
                    <div class="message-sent-content"><pre>{{ composeContent.message }}</pre></div>
                </div>
            </div>
        </div>
        <!-- /display sent messages -->
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

                messages: [],
                sentMessages: [],
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

                composeContent: {
                    subject: '',
                    message: '',
                    emails: [],
                    date: '',
                    time: '',
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
                },
                sent: []
            }
        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-message-green"></i>Messages');
            this.getContent('')
            this.highlightFirstMessage();
            this.resizeMessageContent();
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

        methods: {

            messageInfiniteHandler($state) {

                setTimeout(() => {
                    
                    let vue = this;
                    if(vue.messages.next_page_url != null){
                        axios.get(vue.messages.next_page_url+'&type='+vue.type+'&search='+vue.search).then(function (response) {
                            vue.messages.next_page_url = response['data']['next_page_url'];

                            $.each(response['data']['data'],function(k,v){
                                vue.messages.data.push(v);
                            })

                        }).catch(function (error) {
                        });
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                }, 1000);
            },

            sentInfiniteHandler($state) {
                setTimeout(() => {
                    let vue = this;
                    if(vue.sentMessages.next_page_url != null){
                        axios.get(vue.sentMessages.next_page_url+'&type='+vue.type+'&search='+vue.search).then(function (response) {
                            vue.sentMessages.next_page_url = response['data']['next_page_url'];

                            $.each(response['data']['data'],function(k,v){
                                vue.sentMessages.data.push(v);
                            })

                        }).catch(function (error) {
                        });
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                }, 1000);
            },

            messageType(type){
                return this.types[type]
            },

            getContent(type){
                let vue = this;
                vue.messages = [];
                this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');

                $(".sent-menu").hide();
                $(".messages-menu").show();
                $(".compose-suggestion").hide();

                if(typeof type != 'undefined'){
                    vue.type = type;
                }
                axios.get(base_url+'messages/getMessages?type='+vue.type+'&search='+vue.search).then(function (response) {
                    vue.messages = response['data'];
                    vue.viewMessage(vue.messages['data'][0]);

                }).catch(function (error) {
                });
            },

            getSent(type){
                let vue = this;
                vue.sentMessages = [];
                this.$refs.sentInfiniteLoading.$emit('$sentInfiniteLoading:reset');

                $("#messagesent").fadeIn();
                $(".sent-menu").show();
                $(".messages-menu").hide();
                $(".compose-suggestion").hide();
                // vue.search = ''

                if(typeof type != 'undefined'){
                    vue.type = type;
                }

                axios.get(base_url+'messages/getSentmessage?search='+vue.search).then(function (response) {
                    vue.sentMessages = response['data'];
                    vue.viewSentmail(vue.sentMessages['data'][0]);

                }).catch(function (error) {
                });
            },

            getReply(id){
                let vue = this;

                axios.get(base_url+'messages/getReplies?id='+id).then(function (response) {

                    if(response.data.seen == 0){
                        EventBus.$emit('updateNoti');
                    }

                    if(response['data'][0]){
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

                $("#messagesent").hide();
                $("#messagedisplay").hide();
                $("#messagedisplay").fadeIn(500);
            },

            viewSentmail(sentMessage){
                this.composeContent.emails = sentMessage.emails.split(",")
                this.composeContent.subject = sentMessage.subject
                this.composeContent.message = sentMessage.message
                this.composeContent.time = sentMessage.time_created
                this.composeContent.date = sentMessage.date_created

                $("#compose").hide();

                $("#messagesent").hide();
                $("#messagedisplay").hide();
                $("#messagesent").fadeIn(500);
            },

            sendReply(){
                this.formData.contact_message_id = this.messageContent.id;
                this.formData._method = 'PUT';

                if(this.formData.message == ''){
                    this.Notify("Oops!","Please Complete All Fields");
                }else{
                    this.submit('messages/sendReply', this.formData, 'clearFormData')
                }
            },

            sendMessage(){
                this.emailString = $('#email-to').val()
                this.composeMessage.emailArray = this.emailString.split(",");
                this.composeMessage._method = 'PUT';

                if(this.composeMessage.message == '' || this.composeMessage.subject == '' || $('#email-to').val() == ''){
                    this.Notify("Oops!","Please Complete All Fields");
                }else{
                    this.submit('messages/sendMessage', this.composeMessage, 'clearComposeMessage')
                }
            },

            submit(url, data, successAction){
                let vue = this;

                vue.sendButton.disable = true;
                vue.sendButton.text = 'Sending';

                if(vue.composeMessage.emailArray[0] == ''){
                    vue.composeMessage.emailArray = []
                }

                axios.post(base_url+url, data).then(function (response) {

                    vue.Notify("Well Done!","You're message has been successfully sent");
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
                    
                    vue.sendButton.disable = false;
                    vue.sendButton.text = 'Send';
                    
                }).catch(function (error) {
                    vue.Notify('Error',error);
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

            checkSelected(val){
                var duplicateId = $('#email-to').val().split(",").find(item => item === val);

                if(typeof duplicateId != 'undefined'){
                    return true
                }
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

            Notify(title,message){
                $('.notification-title').html(title);
                $('.notification-description').html(message);
            },

            getAxios: _.debounce(
                function () {
                    if(this.type == 'send'){
                        this.getSent()

                    }else{
                        
                        this.getContent()
                    }
                },500
            )
        }
    }
</script>