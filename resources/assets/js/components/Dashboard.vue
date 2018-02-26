<template>
    <div class="dashboard-wrapper">
            <div class="dashboard-cards row row-break">
                <div class="col-md-4">
                    <div class="card card-yellow">
                        <span class="card-title">Online Users</span>
                        <span class="card-value">{{ users.online }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-red">
                        <span class="card-title">Offline Users</span>
                        <span class="card-value">{{ users.offline }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-blue">
                        <span class="card-title">Registered Users</span>
                        <span class="card-value">{{ users.registered_users }}</span>
                    </div>
                </div>
            </div>
            <div class="row row-break">
                <div class="col-md-6">
                    <div class="dashboard-panel">
                        <div class="panel-title">Upmood Population</div>
                        <div class="scrollbar-outer dashboard-population-table">
                            <table class="table table-population table-stripe">
                                <thead>
                                    <th>Country:</th>
                                    <th>Online:</th>
                                    <th>Offline:</th>
                                    <th>Average Emotion:</th>
                                </thead>
                                <tbody>
                                    <tr v-for='country in countries'>
                                        <td>{{ country.country }}</td>
                                        <td>{{ country.online }}</td>
                                        <td>{{ country.offline }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dashboard-panel">
                        <div class="panel-title">Account Cancellation</div>
                        <div class="scrollbar-outer dashboard-cancellation-table">
                            <table class="table table-stripe">
                                <tbody>
                                    <tr v-for="accountCancellation in accountCancellation">
                                        <div class="listview-row">
                                            <div class="listview-title">{{accountCancellation.name}}</div>
                                            <div class="listview-time">{{accountCancellation.created_at}}</div>
                                            <p class="listview-content">{{accountCancellation.content}}</p>
                                        </div>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-break">
                <div class="col-md-6">
                    <div class="dashboard-panel">
                        <div class="panel-title">Upmood Inquiries</div>
                        <div class="scrollbar-outer dashboard-inquiries-table">
                            <table class="table table-stripe">
                                <tbody>
                                    <tr v-for="inquire in inquire">
                                        <div class="listview-row">
                                            <div class="listview-title">{{inquire.name}}</div>
                                            <div class="listview-time">{{inquire.created_at}}</div>
                                            <p class="listview-content">{{inquire.content}}</p>
                                        </div>
                                    </tr>
                                     
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dashboard-panel">
                        <div class="panel-title">Upmood Reports</div>
                        <div class="scrollbar-outer dashboard-reports-table">
                            <table class="table table-stripe">
                                <tbody>
                                    <tr v-for="report in report">
                                        <div class="listview-row">
                                            <div class="listview-title">{{report.name}}</div>
                                            <div class="listview-time">{{report.created_at}}</div>
                                            <p class="listview-content">{{report.content}}</p>
                                        </div>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        props: ['users','countries','messages'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url,

                report:[],
                accountCancellation:[],
                inquire:[],
            }
        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-dashboard-green"></i>Dashboard');
            $("#sidenav-dashboard").addClass('active');
            let vue = this;
            $.each(this.messages,function(k,v){
                if(v.type == 'reports'){
                    vue.report.push({
                        name : v.name,
                        content : v.content,
                        created_at : v.created_at
                    })
                }else if(v.type == 'account_cancellation'){
                    vue.accountCancellation.push({
                        name : v.name,
                        content : v.content,
                        created_at : v.created_at
                    })

                }else if(v.type == 'inquiries'){
                    vue.inquire.push({
                        name : v.name,
                        content : v.content,
                        created_at : v.created_at
                    })
                }
            })
        }
    }
</script>
