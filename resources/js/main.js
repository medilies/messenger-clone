import "./bootstrap";
import "../css/app.css";

import { createApp } from "vue";
// import the root component App from a single-file component.
import App from "./App.vue";
import router from "./router";

createApp(App).use(router).mount("#app");
