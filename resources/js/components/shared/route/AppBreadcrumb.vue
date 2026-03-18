<script setup lang="ts">
defineOptions({
  name: 'AppBreadcrumb',
});

defineProps<{
  items: IBreadcrumbItem[];
}>();
</script>

<template>
  <Breadcrumb class="mb-4">
    <BreadcrumbList>
      <template v-for="(item, index) in items" :key="index">
        <BreadcrumbItem>
          <BreadcrumbLink v-if="item.to" class="cursor-pointer" as-child>
            <RouterLink :to="item.to">
              {{ item.label }}
            </RouterLink>
          </BreadcrumbLink>

          <BreadcrumbLink v-else class="font-bold">
            {{ item.label }}
          </BreadcrumbLink>
        </BreadcrumbItem>

        <BreadcrumbSeparator v-if="index < items.length - 1" />
      </template>
    </BreadcrumbList>
  </Breadcrumb>
</template>
