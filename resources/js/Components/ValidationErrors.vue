<script setup>
import { computed } from 'vue';

const props = defineProps({
    errors: Object
})
// computed関数でリアクティブなプロパティや変数の値が変更されると、propsオブジェクトのerrorsプロパティが空でない場合にhasErrorsがtrueになる
const hasErrors = computed(() => Object.keys(props.errors).length > 0);
</script>

<template>
    <div v-if="hasErrors">
        <div class="font-medium text-red-600">問題が発生しました。</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="(error, key) in props.errors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>
