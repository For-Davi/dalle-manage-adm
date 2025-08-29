<script setup lang="ts">
import { Button } from "@/components/ui/button"
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "@/components/ui/tabs"
</script>

<template>
  <Tabs default-value="account" class="w-[400px]">
    <TabsList class="grid w-full grid-cols-2">
      <TabsTrigger value="account">
        Entrar
      </TabsTrigger>
      <TabsTrigger value="password">
        Recuperar
      </TabsTrigger>
    </TabsList>
    <TabsContent value="account">
      <Card>
        <CardHeader>
          <CardTitle>Dalle Manage</CardTitle>
          <CardDescription>
            Painel administrativo
          </CardDescription>
        </CardHeader>
        <CardContent class="space-y-2">
          <div class="space-y-1">
            <Label for="name">Name</Label>
            <Input id="name" default-value="Pedro Duarte" />
          </div>
          <div class="space-y-1">
            <Label for="username">Username</Label>
            <Input id="username" default-value="@peduarte" />
          </div>
        </CardContent>
        <CardFooter>
          <Button>Save changes</Button>
        </CardFooter>
      </Card>
    </TabsContent>
    <TabsContent value="password">
      <Card>
        <CardHeader>
          <CardTitle>Redefinir</CardTitle>
          <CardDescription>
            Recupere sua senha
          </CardDescription>
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