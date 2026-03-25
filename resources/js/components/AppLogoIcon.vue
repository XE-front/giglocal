<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    
    <img
        src="/logo/GigLocalIcon.png"
        alt="App Logo Icon"
        :class="['w-35 h-10 rounded-xl', className]"
        v-bind="$attrs"
        
    />
   
    
</template>
