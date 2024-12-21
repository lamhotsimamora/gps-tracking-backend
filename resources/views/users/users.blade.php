<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Data GPS Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.16/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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


<div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">History Data</h5>
    <hr>
    <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Latitude
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Longitude
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Time
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="data in coordinate" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @{{data.id}}
                        </th>
                        <td class="px-6 py-4">
                            @{{data.username}}
                        </td>
                        <td class="px-6 py-4">
                            @{{data.latitude}}
                        </td>
                        <td class="px-6 py-4">
                            @{{data.longitude}}
                        </td>
                        <td class="px-6 py-4">
                            @{{data.date}}
                        </td>
                        <td class="px-6 py-4">
                            @{{data.time}}
                        </td>
                        <td class="px-6 py-4">
                            <button @click="deleteData(data.id)" type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">x</button>
                        </td>
                    </tr>
                    
                   
                </tbody>
            </table>
        </div>
    </p>
   
</div>


           
        </center>
    </div>
  
    <script>
        const SERVER = 'http://derania.com/public/index.php/';
       // const SERVER = 'http://127.0.0.1:8000/';

        const _TOKEN_ = "<?= csrf_token() ?>";
        var app = new Vue({
            el: '#app',
            data: {
                coordinate : null
            },
            methods: {
                deleteData : function(id){
                    const $this = this;
                    axios.post(SERVER+'admin-api-delete-tracking', {
                            _token: _TOKEN_,
                            id: id
                        })
                        .then(function(response) {
                            var obj = response.data;
                            if (obj) {
                                Swal.fire({
                                    title: "Success !",
                                    text: "Delete user success",
                                    icon: "success"
                                });
                                $this.loadData()
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                loadData: function() {
                    const $this = this;
                    axios.post(SERVER+'user-load-all-data-map', {
                            _token: _TOKEN_
                        })
                        .then(function(response) {
                            var obj = response.data;
                            if (obj) {
                                $this.coordinate = obj;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
            },
            mounted() {
                const $this = this;
                this.loadData()

            },
        })
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

</html>
