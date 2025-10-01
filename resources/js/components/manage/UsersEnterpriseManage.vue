<script setup lang="ts">
import { computed, watch, ref } from 'vue';
import TitlePage from '../general/TitlePage.vue';
import UsersEnterpriseTable from '../tables/UsersEnterpriseTable.vue';

defineOptions({
  name: 'UsersEnterpriseManage',
});

const props = defineProps<{
  data: {
    open: boolean;
    enterprise: IEnterprise | null;
  };
}>();

const emit = defineEmits<{
  'update:open': [void];
  'add:user': [IEnterprise];
  'edit:user': [{ enterprise: IEnterprise; user: IUser }];
}>();

const enterpriseName = ref<string>('');

const startAddUser = () => {
  if (props.data.enterprise) {
    emit('add:user', props.data.enterprise);
    emit('update:open');
  }
};
const startEditUser = (user: IUser) => {
  if (props.data.enterprise) {
    emit('edit:user', {
      enterprise: props.data.enterprise,
      user: user,
    });
    emit('update:open');
  }
};

const open = computed({
  get: () => props.data.open,
  set: () => emit('update:open'),
});

watch(
  () => props.data.enterprise,
  (newVal) => {
    if (newVal?.name) {
      enterpriseName.value = newVal.name;
    }
  }
);
</script>

<template>
  <Dialog v-model:open="open">
    <DialogContent class="overflow-y-auto">
      <DialogHeader>
        <DialogTitle>
          <TitlePage title="Painel de usuários" icon="Building2" />
        </DialogTitle>
        <DialogDescription
          class="text-md text-gray-600"
          style="
            white-space: normal;
            word-break: break-word;
            overflow-wrap: break-word;
          "
        >
          {{ enterpriseName }}
        </DialogDescription>
        <Separator class="my-1 bg-gray-500" />
      </DialogHeader>
      <div class="w-full">
        <UsersEnterpriseTable
          @edit:user="startEditUser"
          :enterpriseID="props.data.enterprise?.id"
        />
      </div>
      <div>
        <Button class="w-full cursor-pointer" @click="startAddUser"
          >Adicionar</Button
        >
      </div>
    </DialogContent>
  </Dialog>
</template>
