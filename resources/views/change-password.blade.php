<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Change Password Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.16/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/lamhotsimamora/garuda-javascript@master/src/garuda.js"></script>
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
    @include('@component.navbar')
    
    <hr><br>

    <div id="app" class="container mx-auto">
        <center>
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Change Password</h5>
                <hr>
                <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                   
                    
                <div class="mb-5">
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                    <input type="password" id="username" v-model="password_old" ref="password_old"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Old Password" required />
                </div>
                <div class="mb-5">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                    <input type="password" id="password" v-model="password_new" ref="password_new"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="New Password" required />
                </div>
               
                <button @click="save" type="button"
                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Save</button>
               
                </p>

            </div>
        </center>
    </div>

   
    <script>
        const _TOKEN_ = "<?= csrf_token() ?>";
     const SERVER = 'https://derania.com/public/index.php/';
      //const SERVER = 'http://127.0.0.1:8000/';
       
        var app = new Vue({
            el: '#app',
            data: {
                password_old: null,
                password_new : null
            },
            methods: {
                save: function() {
                    if (this.password_old == null) {
                        this.$refs.password_old.focus();
                        return;
                    }
                    if (this.password_new == null) {
                        this.$refs.password_new.focus();
                        return;
                    }
                  
                    __({
                        url: SERVER+'api-change-password-admin',
                        method: 'post',
                        data: {
                            password_old : this.password_old,
                            password_new : this.password_new,
                            _token: _TOKEN_
                        }
                    }).request($response => {
                       
                        var obj = JSON.parse($response);
                        if (obj.result) {
                            Swal.fire({
                                title: "Change Password Success",
                                text: "Success Change Password ("+this.password_new+") Success !",
                                icon: "success"
                            });
                           
                        } else {
                            Swal.fire({
                                title: "Change Password Failed",
                                text: "Password is wrong !",
                                icon: "error"
                            });
                        }
                    });

                }
            },
            mounted() {

            },
        })
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

</html>
