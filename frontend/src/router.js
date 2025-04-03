import { createRouter, createWebHistory } from "vue-router";
import ImportCsv from "./components/ImportCsv.vue";
import ListRecords from "./components/ListRecords.vue";
import EditRecord from "./components/EditRecord.vue";

const routes = [
    { path: "/", component: ImportCsv },
    { path: "/records", component: ListRecords },
    { path: "/edit/:id", component: EditRecord, name: "EditRecord" },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
