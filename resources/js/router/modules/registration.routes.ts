import type { RouteRecordRaw } from 'vue-router';

export const registrationRoutes: RouteRecordRaw[] = [
  {
    path: 'sellers/registrations',
    name: 'registrations',
    component: () => import('@/pages/Registration/RegistrationIndex.vue'),
  },
];
