// Composables
import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "",
    name: "portada",
    component: () => import("@/views/portada.vue"),
  },
  {
    path: "/iniciarSessio",
    name: "iniciarSessio",

    component: () => import("@/views/iniciarSessio.vue"),
  },
  {
    path: "/tasques",
    name: "tasques",

    component: () => import("@/views/tasques.vue"),
  },
  {
    path: "/tasques/editar",
    name: "editarTasques",

    component: () => import("@/views/editarTasques.vue"),
  },
  {
    path: "/crearTasques",
    name: "crearTasques",

    component: () => import("@/views/crearTasques.vue"),
  },
  {
    path: "/crearUsuaris",
    name: "crearUsuaris",

    component: () => import("@/views/crearUsuaris.vue"),
  },
  {
    path: "/usuairs/editar",
    name: "editarUsuaris",

    component: () => import("@/views/editarUsuaris.vue"),
  },
  {
    path: "/usuaris",
    name: "usuaris",

    component: () => import("@/views/usuaris.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
