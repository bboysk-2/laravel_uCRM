<script setup>
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    errors: Object,
});

// リアクティブなオブジェクトを作成
const form = reactive({
    title: null,
    content: null,
});

const submitFunction = () => {
    // 第一引数にアクセス先、第二引数に渡すオブジェクト
    Inertia.post("/inertia", form);
};
</script>

<template>
    <form v-on:submit.prevent="submitFunction">
        <!-- v-modelで上で定義したformオブジェクトとバインディング -->
        <input type="text" v-model="form.title" /><br />
        <!-- バリデーションのエラーオブジェクトの中身がある場合はエラーメッセージを表示 -->
        <div v-if="errors.title">{{ errors.title }}</div>
        <input type="text" v-model="form.content" /><br />
        <div v-if="errors.content">{{ errors.content }}</div>
        <button>送信</button>
    </form>
</template>
