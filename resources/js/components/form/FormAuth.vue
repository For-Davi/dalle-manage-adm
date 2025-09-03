  <script setup lang="ts">
  import { Button } from '@/components/ui/button';
  import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
  } from '@/components/ui/card';
  import { Input } from '@/components/ui/input';
  import { Label } from '@/components/ui/label';
  import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
  import { useForm } from '@inertiajs/vue3';
  import { Loader2 } from 'lucide-vue-next'


  defineOptions({
    name:'FormAuth',
  })

  const form = useForm({
    email:'',
    password:'',
  })

  const submit = async () => {
    form.post(route('user.login'), {
      onFinish: () => form.reset('password')
    })
  }
  </script>

  <template>
    <Tabs default-value="account" class="w-[400px]">
      <TabsList class="grid w-full grid-cols-2">
        <TabsTrigger value="account"> Entrar </TabsTrigger>
        <TabsTrigger value="password"> Recuperar </TabsTrigger>
      </TabsList>
      <TabsContent value="account">
        <Card>
          <CardHeader>
            <CardTitle>Dalle Manage Adm</CardTitle>
            <CardDescription> Faça seu login </CardDescription>
          </CardHeader>
          <CardContent class="space-y-2">
            <form @submit.prevent="submit">
               <div class="space-y-1">
              <Label for="email">Email</Label>
              <Input v-model="form.email" id="email" placeholder="Insira seu email"/>
            </div>
            <div class="space-y-1">
              <Label for="password">Password</Label>
              <Input v-model="form.password" id="password" type="password" placeholder="Insira sua senha" />
            </div>
            <div v-if="form.errors.email" >
            <p class="ml-6 text-sm text-red-600 font-medium">{{ form.errors.email }}</p>
          </div>
            </form>
          </CardContent>
          <CardFooter>
            <Button
        type="submit"
        class="w-full cursor-pointer"
        :disabled="form.processing"
        @click="submit"
      >
        <div v-if="form.processing">
          <Loader2 class="w-4 h-4 mr-2 animate-spin" />
        </div>
        <div v-else>Entrar</div>
      </Button>
          </CardFooter>
        </Card>
      </TabsContent>
      <TabsContent value="password">
        <Card>
          <CardHeader>
            <CardTitle>Redefinir</CardTitle>
            <CardDescription> Recupere sua senha </CardDescription>
          </CardHeader>
          <CardContent class="space-y-2">
            <div class="space-y-1">
              <Label for="current">E-mail</Label>
              <Input id="current" type="password" />
            </div>
          </CardContent>
          <CardFooter>
            <Button>Enviar</Button>
          </CardFooter>
        </Card>
      </TabsContent>
    </Tabs>
  </template>
