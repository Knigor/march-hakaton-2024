<script setup>
import SiteHeader from '../components/custom/SiteHeader.vue'
import ProfileMenu from '../components/custom/profile/ProfileMenu.vue'
import ProfileRecentView from '../components/custom/ProfileRecentView.vue'
import FavoriteElement from '../components/custom/FavoriteElement.vue'

import { Card } from '../components/ui/card'
import { Button } from '../components/ui/button'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Badge } from '@/components/ui/badge'
import { ScrollArea } from '@/components/ui/scroll-area'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip'

import { AtSign, Hash, Hexagon, Pencil } from 'lucide-vue-next'
import { ref } from 'vue'
import axios from 'axios'

let login = localStorage.login
let role = localStorage.role_user
let fullName = localStorage.full_name

let id_user = localStorage.id_user
const views = ref([])

console.log(id_user)
const formData = new FormData()
formData.append('id_user', id_user)

axios
  .post(`http://localhost/get_last.php`, formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
  .then((response) => {
    console.log(response.data)

    const status = response.data.status
    console.log(status)

    response.data.forEach((item) => {
      views.value.push({
        date: item.date,
        id_lection: item.id_lection,
        id_user: item.id_user,
        title_lection: item.title_lection,
        full_name_user: item.full_name_user
      })
    })

    console.log(views.value) // Перемещаем console.log внутрь обработчика .then()
  })
  .catch((error) => {
    console.error('Ошибка при получении данных:', error)
  })
</script>

<template>
  <div class="flex flex-col gap-8 max-h-full h-full p-16 box-border">
    <SiteHeader />
    <main class="flex gap-8 overflow-y-auto h-full max-h-full">
      <ProfileMenu />
      <section class="flex w-full max-h-full h-full gap-6">
        <!-- Первая колонка -->
        <div class="w-full h-full max-h-full">
          <Card
            class="flex flex-col w-full max-h-full h-full bg-transparent gap-4 p-4 box-border overflow-hidden"
          >
            <h2 class="font-semibold text-2xl">Последние просмотренные</h2>
            <ScrollArea>
              <div class="flex flex-col gap-5 overflow-y-auto">
                <ProfileRecentView
                  v-for="views in views"
                  :key="views.id"
                  :date="views.date"
                  :title_lection="views.title_lection"
                  :full_name_userr="views.full_name_user"
                />
              </div>
            </ScrollArea>
          </Card>
        </div>
        <!-- Вторая колонка -->
        <div class="flex flex-col w-full max-h-full h-full gap-4">
          <Card class="flex w-full max-h-[96px] p-4 gap-4 items-center box-border">
            <Avatar class="w-16 h-16 max-w-16 max-h-16">
              <AvatarImage src="" alt="@radix-vue" />
              <AvatarFallback class="text-lg">CN</AvatarFallback>
            </Avatar>
            <div class="flex flex-col gap-2">
              <div class="flex gap-3">
                <h2 class="font-semibold text-2xl">{{ fullName }}</h2>
                <TooltipProvider>
                  <Tooltip>
                    <TooltipTrigger
                      ><Button variant="outline" size="icon" class="w-8 h-8 rounded-full"
                        ><Pencil size="16" /></Button
                    ></TooltipTrigger>
                    <TooltipContent>
                      <p>Настроить профиль</p>
                    </TooltipContent>
                  </Tooltip>
                </TooltipProvider>
              </div>
              <div class="flex gap-4">
                <Badge variant="outline" class="flex gap-1.5"
                  ><AtSign size="16" />{{ login }}</Badge
                >
                <Badge variant="outline" class="flex gap-1.5"><Hash size="16" />{{ role }}</Badge>
                <Badge variant="outline" class="flex gap-1.5"><Hexagon size="16" />ФАИ</Badge>
              </div>
            </div>
          </Card>
          <Card
            class="flex flex-col w-full h-full max-h-full bg-transparent gap-4 p-4 box-border overflow-hidden"
          >
            <h2 class="font-semibold text-2xl">Избранное</h2>
            <ScrollArea>
              <div class="flex flex-col gap-5">
                <FavoriteElement /><FavoriteElement /> <FavoriteElement /><FavoriteElement />
                <FavoriteElement /><FavoriteElement /><FavoriteElement /><FavoriteElement /><FavoriteElement /><FavoriteElement />
              </div>
            </ScrollArea>
          </Card>
        </div>
      </section>
    </main>
  </div>
</template>
