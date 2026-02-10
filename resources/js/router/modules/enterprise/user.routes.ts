import type { RouteRecordRaw } from 'vue-router';

export const userRoutes: RouteRecordRaw[] = [
  {
    path: 'enterprises/:id/users',
    name: 'enterprise-users',
    props: true,
    component: () => import('@/pages/Enterprise/User/UserIndex.vue'),
  },
  {
    path: 'enterprises/:id/users/create',
    name: 'enterprise-user.create',
    props: true,
    component: () => import('@/pages/Enterprise/User/UserCreate.vue'),
  },
  {
    path: 'enterprises/users/:userID/edit',
    name: 'enterprise-user.edit',
    props: true,
    component: () => import('@/pages/Enterprise/User/UserEdit.vue'),
  },
];
