import type { RouteRecordRaw } from 'vue-router';

export const subscriptionRoutes: RouteRecordRaw[] = [
  {
    path: 'subscriptions',
    name: 'subscriptions',
    component: () => import('@/pages/Subscription/SubscriptionIndex.vue'),
  },
];
