import axios from 'axios';
// sebuah library JavaScript untuk melakukan HTTP request (GET, POST, PUT, DELETE).

window.axios = axios;
//  Menjadikan Axios tersedia secara global dalam aplikasi.

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//Menambahkan header X-Requested-With agar Laravel mengenali request AJAX.
