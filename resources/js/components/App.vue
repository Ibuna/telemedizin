<template>
    <main class="flex flex-col min-h-screen">
        <Header />
        <main class="flex-1">
            <RouterView />
        </main>
        <Footer />
    </main>
</template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  import Header from './Header.vue';
  import Footer from './Footer.vue';
  
  export default defineComponent({
    name: 'App',
    components: {
        Header,
        Footer
    },
    data() {
      return {
        title: 'Telemedizin',
      };
    },
    computed: {

    },
    methods: {
      
    },
  });
  </script>
  
  