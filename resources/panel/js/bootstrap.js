import axios from 'axios';
window.axios = axios;

//import "./plugins/global/plugins.bundle";

//import "../../../node_modules/bundle-js/bin/bundle-js.js";


//import "bundle-js";
//import "bundle-require";

//import "./scripts.bundle2.js";

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import "bootstrap";
import $ from "jquery";

window.$ = $;
window.jQuery = $;
//export default jQuery;
import select2 from 'select2'
window.select2 = select2;
select2($);


