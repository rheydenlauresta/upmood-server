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
                            <table class="table table-stripe">
                                <thead>
                                    <th>Country:</th>
                                    <th>Online:</th>
                                    <th>Offline:</th>
                                    <th>Average Emotion:</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
                                    </tr>
                                    <tr>
                                        <td>Philippines</td>
                                        <td>1000</td>
                                        <td>3265</td>
                                        <td>54.65</td>
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
                                    <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">few mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">20 mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">1 hour ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">1 hour ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">20 mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">20 mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
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
                                    <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">few mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">20 mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">1 hour ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">1 hour ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">20 mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">20 mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
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
                                    <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">few mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">20 mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">1 hour ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">1 hour ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">20 mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
                                        </div>
                                    </tr>
                                     <tr>
                                        <div class="listview-row">
                                            <div class="listview-title">lorem</div>
                                            <div class="listview-time">20 mins ago.</div>
                                            <p class="listview-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam......</p>
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
        props: ['users','countries'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url,
            }
        },
        mounted() {
            $(".main-header > .title").html('<i class="header-ic ic-dashboard-green"></i>Dashboard');
        }
    }
</script>
