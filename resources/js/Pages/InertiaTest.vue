<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

//ref関数によってリアクティブなデータを作成
const newTitle = ref("");
const newContent = ref("");
</script>

<template>
    Inertiaテストです。<br />
    <a href="/">aタグ経由です</a><br />
    <Link href="/">Link経由です</Link><br />
    <Link :href="route('inertia.index')">名前付きテストです</Link><br />
    <Link :href="route('inertia.show', { id: 1 })"
        >ルートパラメータテストです</Link
    ><br />

    <div class="mb-8"></div>
    <input type="text" name="newTitle" v-model="newTitle" /><br />
    <input type="text" name="newContent" v-model="newContent" /><br />
    <!-- as="button" リンクコンポーネントをボタンとして扱う -->
    <!-- :data="{}" inputで入力された値をコントローラーに渡す -->
    <Link
        as="button"
        method="post"
        :href="route('inertia.store')"
        :data="{
            title: newTitle,
            content: newContent,
        }"
        >DB保存テスト</Link
    >
</template>
