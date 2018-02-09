<!DOCTYPE html>
<html>
<head>
    <title>Real time</title>
</head>
<body>
    <div id="app">
        <h1>New User</h1>
        <p>Client->POST chat trigger event->broadcast to user</p>
        <ul>
            <li v-for="data in data.data">
                @{{ data.email }}
            </li>
        </ul>    
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.3/vue-resource.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.min.js"></script>
    <script type="text/javascript">
        var socket = io('http://localhost:6379');
        new Vue({
            el: '#app',
            data: {
                count: 0,
                data: [],
            },
            mounted: function() {
                socket.on('notification', function(response) {
                    console.log(response)
                    this.data = response.data
                    this.count = response.data.total

                }.bind(this))    
            }
        })
    </script>
</body>
</html>