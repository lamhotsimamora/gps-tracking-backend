<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin GPS Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.16/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #userMap {
            height: 600px;
            width: auto;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body>

    @include('@component.navbar')

    <hr><br>

    <div id="app" class="container mx-auto">
        <center>
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">GPS Tracking Real Time</h5>
                <hr>

                <form class="max-w-sm mx-auto">
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                        an User</label>
                    <select @change="selectCoordinate" id="countries" v-model="usersselected"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        <option :id="data.id" v-for="data in users" :name="data.username"
                            :value="data.id">@{{ data.username }}</option>
                    </select>
                </form> <br>
                {{-- <button type="button" @click="selectCoordinate"
                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Get</button> --}}


                <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                <div class="mb-5">
                    <label for="latitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                    <input type="text" readonly v-model="latitude"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Latitude" required />
                </div>
                <div class="mb-5">
                    <label for="longitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                    <input type="text" readonly v-model="longitude"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Longitude" required />
                </div>
                <svg v-if="loading" aria-hidden="true"
                    class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <div id="userMap">

                </div>
                </p>
            </div>
        </center>
    </div>

    
    <script>
        var map;
        var marker;

        map = null;
        const SERVER = 'https://derania.com/public/index.php/';
       // const SERVER = 'http://127.0.0.1:8000/';
       
        const _TOKEN_ = "<?= csrf_token() ?>";
        var app = new Vue({
            el: '#app',
            data: {
                latitude: null,
                longitude: null,
                loading: false,
                usersselected: null,
                users: null,
                username: null
            },
            methods: {
                selectCoordinate: function() {
                    const id_user = this.usersselected;
                    if (id_user==null)
                    {
                        return;
                    }
                    var username = document.getElementById(id_user);
                    if (username==null)
                    {
                        return;
                    }
                    this.username = username.getAttribute('name');

                    if (id_user == null) {
                        Toastify({
                            text: "Select User First !",
                            duration: 3000,
                            gravity: "bottom",
                            position: 'left'
                        }).showToast();
                        return;
                    }
                    const $this = this;
                    this.loading = true;
                    axios.post(SERVER+'admin-load-data-map', {
                            id_user: id_user,
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            var obj = response.data;
                            $this.loading = false;
                            if (obj.result) {

                                if (obj.data == null) {
                                    Toastify({
                                        text: "Data is null !",
                                        duration: 3000,
                                        gravity: "bottom",
                                        position: 'left'
                                    }).showToast();
                                    return;
                                }
                                $this.latitude = obj.data.latitude;
                                $this.longitude = obj.data.longitude;
                                $this.setMap($this.latitude, $this.longitude, 15)

                            } else {
                                $this.latitude = null;
                                $this.longitude = null;
                                Toastify({
                                    text: "Data for today is nothing !",
                                    duration: 3000,
                                    gravity: "bottom",
                                    position: 'left'
                                }).showToast();
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                loadUser: function() {
                    const $this = this;

                    axios.post(SERVER+'admin-load-all-data-user', {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            var obj = response.data;

                            if (obj) {
                                $this.users = obj;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                setMap: function(latitude, longitude, zoom) {

                    try {
                        document.getElementById('userMap').innerHTML =
                            "<div id='map' style='width: 100%; height: 100%;'></div>";
                        map = null;

                        map = L.map('map').setView([latitude, longitude], zoom);

                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: zoom,
                            attribution: 'copyright@2024 Deratek'
                        }).addTo(map);

                        marker = null;
                        marker = L.marker([latitude, longitude]).addTo(map);

                        marker.bindPopup(this.username + " is here !").openPopup();
                    } catch (error) {
                        console.warn(error)
                    }

                }
            },
            mounted() {
                const $this = this;

                this.loadUser();

                setInterval(() => {
                    this.selectCoordinate()
                }, 5000);
            },
        })
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

</html>
