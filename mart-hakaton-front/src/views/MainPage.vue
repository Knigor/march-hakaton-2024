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

import { AtSign, Hash, Hexagon, Pencil } from 'lucide-vue-next'
</script>

<template>
  <div class="flex flex-col gap-8 max-h-full h-full p-16 box-border">
    <SiteHeader />
    <main class="flex h-full gap-8 max-h-full">
      <nav class="h-full max-h-full">
        <ProfileMenu />
      </nav>
      <section class="flex w-full max-h-full h-full gap-6">
        <!-- Первая колонка -->
        <div class="w-full h-full max-h-full">
          <Card class="flex flex-col w-full max-h-full h-full bg-transparent gap-4 p-4 box-border overflow-hidden">
            <h2 class="font-semibold text-2xl">Последние просмотренные</h2>
            <ScrollArea>
              <div class="flex flex-col gap-5 overflow-y-auto">
                <ProfileRecentView></ProfileRecentView><ProfileRecentView></ProfileRecentView
                ><ProfileRecentView></ProfileRecentView><ProfileRecentView></ProfileRecentView
                ><ProfileRecentView></ProfileRecentView>
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
                <h2 class="font-semibold text-2xl">Иванов Иван Иванович</h2>
                <Button variant="outline" size="icon" class="w-8 h-8 rounded-full"
                  ><Pencil size="16"
                /></Button>
              </div>
              <div class="flex gap-4">
                <Badge variant="outline" class="flex gap-1.5"
                  ><AtSign size="16" />ivanov_ivan12</Badge
                >
                <Badge variant="outline" class="flex gap-1.5"><Hash size="16" />Студент</Badge>
                <Badge variant="outline" class="flex gap-1.5"><Hexagon size="16" />ФАИ</Badge>
              </div>
            </div>
          </Card>
          <Card class="flex flex-col w-full h-full max-h-full bg-transparent gap-4 p-4 box-border overflow-hidden">
            <h2 class="font-semibold text-2xl">Избранное</h2>
            <ScrollArea>
              <div class="flex flex-col gap-5">
                <FavoriteElement /><FavoriteElement /> <FavoriteElement /><FavoriteElement />
                <FavoriteElement /><FavoriteElement />
              </div>
            </ScrollArea>
          </Card>
        </div>
      </section>
    </main>
  </div>
</template>
