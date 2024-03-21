<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Chat from '@/Components/Chat.vue'

</script>

<template>
    <Head title="Welcome" />

    <div class="md:w-1/2 mx-auto">

      <header class="mt-5">
        <div class="flex space-x-3">
          <div>
            <Link href="/">
              <svg width="38" height="44" viewBox="0 0 38 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M30.3478 24.6149C29.3619 23.3278 27.93 22.4563 26.3339 22.172C27.7497 21.7585 29.004 20.9192 29.9264 19.7682C30.8514 18.5592 31.3281 17.0667 31.2753 15.5453C31.2953 14.1819 30.9137 12.8428 30.1779 11.6948C29.3861 10.5126 28.2623 9.59099 26.9479 9.0461C25.4605 8.41856 23.8625 8.0954 22.2482 8.0957L20.8308 12.7726H21.0332C22.4115 12.7726 23.474 13.0904 24.2208 13.7262C24.9676 14.362 25.3399 15.2579 25.3378 16.4141C25.3378 17.5768 24.9655 18.4651 24.2208 19.0889C23.4762 19.7127 22.4115 20.0164 21.0332 20.0164H18.6132L17.2578 24.4908H21.448C22.8567 24.4908 23.9748 24.8424 24.8022 25.5457C25.2163 25.9069 25.5431 26.3573 25.758 26.863C25.973 27.3688 26.0705 27.9166 26.0432 28.4655C26.0432 29.6804 25.6502 30.6188 24.8642 31.2807C24.0782 31.9426 22.9808 32.2692 21.5721 32.2605H15.7326V26.2838H17.1304L9.94531 22.1883V36.9962H22.4082C24.1543 37.0366 25.8884 36.6967 27.49 36C28.8302 35.418 29.9743 34.4621 30.7854 33.2468C31.5565 32.0282 31.9518 30.6095 31.9219 29.1677C31.9413 27.5134 31.3848 25.9039 30.3478 24.6149Z" fill="#3CB777"></path><path d="M22.993 7.45944L21.3273 6.7442L16.0626 24.0995L8.19164 19.6186L3.39068 27.6137L1 31.5949L2.35537 27.2446L6.47374 14.0208L9.11917 15.5329L13.6882 18.1424L14.4819 15.5329L17.5911 5.32024L15.8013 4.80749L21.7062 0L22.993 7.45944Z" fill="#F9BF17"></path></svg>
            </Link>
          </div>
          <div class="grid place-items-center">
            <Link href="/">
              <h1 class="font-black text-2xl tracking-tighter">Bigly AI - SDK Demos</h1>
            </Link>
          </div>
        </div>
      </header>

      <main class="mt-5">
        <h3 class="font-bolt text-3xl tracking-tight">Chatbot Demo</h3>
        <p>On the bottom-right of this page is a chat icon. Click it to begin interacting with the chatbot.</p>
      </main>

      <Chat class="absolute bottom-0 right-[50px] mb-[25px]"/>
    </div>
</template>

<style>


</style>
