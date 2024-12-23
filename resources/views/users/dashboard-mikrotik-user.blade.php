<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Data GPS Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.16/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js "></script>
    <script src="https://kit.fontawesome.com/672dd512a0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js">
        < /scrip> <
        script src = "https://cdn.jsdelivr.net/npm/sweetalert2@11" >
    </script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #map {
            height: 600px;
            width: auto;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body>



    @include('users.navbar')

    <hr><br>

    <div id="app" class="container mx-auto">
        <center>

            <a href="./mikrotik-dashboard"
                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Reload</a>


            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <h6 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Data Interface @{{ interface_name }}
                </h6>
                <hr>
                <span
                    class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300">@{{ tx_text }}</span>
                <span
                    class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">@{{ rx_text }}</span>

                <center><canvas id="myChart" style="width:100%;max-width:700px"></canvas></center>
                <hr>
                <span
                    class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                    CPU : @{{ cpu }}
                </span>
                <span
                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                    Memory : @{{ memory }} MB
                </span>
                <span
                    class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300">
                    Uptime : @{{ uptime }}
                </span>
                <span
                    class="bg-green-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300">
                    Date : @{{ date }}
                </span>

                <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                    <center>
                        <ul
                            class="w-80 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li v-for="data in interface" :class="loadClass(data.running)">
                                <a data-tooltip-target="tooltip-running" href="#" @click="loadTraffic(data)"><i
                                        class="fa-solid fa-gear"></i>
                                    @{{ data.name }} | <small>@{{ data['mac-address'] }}</small></a>
                            </li>
                        </ul>
                    </center>
                </p>
                < </div>
        </center>
        <div id="tooltip-running" role="tooltip"
            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
            Interface Running
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>

  
    <script>
        moment.locale();
        var now = "<?= $datetime ?>";
        var theDate = moment(now);
       
         const SERVER = 'https://derania.com/public/index.php/';
      // const SERVER = 'http://127.0.0.1:8000/';

        var newDate = [];
        for (let index = 0; index < 60; index++) {
            var localDate = theDate.local();
            localDate = localDate.add(1, "second");

            newDate[index] = localDate.format('HH:mm:ss');
        }

        const ip = "<?= $ip ?>";
        const username = "<?= $username ?>";
        const password = "<?= $password ?>";
        const port = "<?= $port ?>";


        const _TOKEN_ = "<?= csrf_token() ?>";
        var app = new Vue({
            el: '#app',
            data: {
                interface: null,
                myChart: null,
                interface_name: null,
                tx_text: null,
                rx_text: null,
                cpu: null,
                memory: null,
                uptime: null,
                date:null
            },
            methods: {
                loadDate:function(){
                    const $this = this;
                    axios.post(SERVER+'api-load-date-user', {
                            _token: _TOKEN_,
                            ip: ip,
                            port: port,
                            username: username,
                            password: password
                        }, {
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        })
                        .then(function(response) {
                            var obj = response.data;
                            if (obj) {
                                $this.date = obj[0]['date'];
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                loadCpu: function() {
                    const $this = this;
                    axios.post(SERVER+'api-load-cpu-user', {
                            _token: _TOKEN_,
                            ip: ip,
                            port: port,
                            username: username,
                            password: password
                        }, {
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        })
                        .then(function(response) {
                            var obj = response.data;
                            if (obj) {
                                $this.cpu = obj[0].cpu + " | Board " + obj[0]['board-name'];
                                $this.memory = obj[0]['total-memory'] / 1000000;
                                $this.uptime = obj[0]['uptime'];
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                initChart: function() {
                    this.myChart = new Chart("myChart", {
                        type: "line",
                        data: {
                            labels: newDate,
                            datasets: [{
                                    backgroundColor: "rgba(245, 40, 145, 0.8)",
                                    borderColor: "rgba(245, 40, 145, 0.8)",
                                    data: [],
                                    label: 'Tx Mbps'
                                },
                                {
                                    backgroundColor: "rgba(120, 0, 255, 1)",
                                    borderColor: "rgba(120, 0, 255, 1)",
                                    data: [],
                                    label: 'Rx Mbps'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Traffic Interface '
                                }
                            }
                        },
                    });
                },
                proccessTraffic: function(name_ethernet) {
                    const $this = this;

                    axios.post(SERVER+'api-load-traffic-user', {
                            _token: _TOKEN_,
                            ethernet: name_ethernet
                        })
                        .then(function(response) {
                            var obj = response.data;
                            if (obj) {

                                var tx = obj['tx'] / 1000000;
                                var rx = obj['rx'] / 1000000;

                                var data = $this.myChart.data;
                                data.datasets[0].data.push(tx);
                                data.datasets[1].data.push(rx);
                                $this.tx_text = 'Tx : ' + Number(tx).toFixed(2) + ' Mbps';
                                $this.rx_text = "Rx : " + Number(rx).toFixed(2) + ' Mbps';
                                $this.myChart.update();

                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                loadTraffic: function(data) {
                    console.log(data.running)
                    if (data.running === 'false') {
                        Swal.fire({
                            title: "Uppz",
                            text: "Interface {" + data.name + "} is not running !",
                            icon: "error"
                        });
                        return;
                    }
                    const $this = this;
                    this.interface_name = data.name;
                    this.proccessTraffic(data.name);
                    setInterval(function() {
                        $this.proccessTraffic(data.name);
                    }, 2000);

                },
                loadClass: function(running) {

                    if (running === 'true') {
                        return 'w-full px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600 bg-blue-700 text-white';
                    } else {
                        return 'w-full px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600 bg-red-700 text-white';
                    }
                },
                loadDataInterface: function() {
                    const $this = this;
                    axios.post(SERVER+'api-load-interface-user', {
                            _token: _TOKEN_,
                            ip: ip,
                            port: port,
                            username: username,
                            password: password
                        }, {
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        })
                        .then(function(response) {
                            var obj = response.data;
                            if (obj) {
                                $this.interface = obj;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
            },
            mounted() {
                const $this = this;
                this.loadDataInterface()
                this.initChart()
                this.loadCpu()
                this.loadDate()
            },
        })
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

</html>
