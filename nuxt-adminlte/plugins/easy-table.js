import Vue from "vue";
import "vue-easytable/libs/theme-default/index.css"; // import style
// import VueEasytable from "vue-easytable"; // import library
import { VeTable, VePagination, veLoading } from "vue-easytable";
import { VeLocale } from "vue-easytable";
// import language config
// import enUS from "vue-easytable/libs/locale/lang/en-US.js";

Vue.component(VeTable.name, VeTable);
Vue.component(VePagination.name, VePagination);
// Vue.component(veLoading.name, veLoading);
// Vue.prototype.$veLoading = ()=> {
//     return veLoading;
// }; // globally GAGAL
// export default (context, inject)=> {
//     context.app.$veLoading =  ()=> {
//             return veLoading;
//         };
//     // inject('veLoading', paramsObject => console.log(`TES ${paramsObject}`));
// }

// Vue.use(veLoading);
// VeLocale.use(enUS);
// Vue.prototype.$veLocale = VeLocale;