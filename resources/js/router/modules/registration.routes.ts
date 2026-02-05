import type { RouteRecordRaw } from 'vue-router';

export const registrationRoutes: RouteRecordRaw[] = [
  {
    path: 'sellers/registrations',
    name: 'registrations',
    component: () =>
      import('@/pages/Seller/Registration/RegistrationIndex.vue'),
  },
];
