<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    //DBのリスト用
    blogs: Array,
});
</script>

<template>
    <!-- フラッシュメッセージ表示 -->
    <div v-if="$page.props.flash.message" class="bg-blue-200">
        {{ $page.props.flash.message }}
    </div>
    <ul>
        <li v-for="blog in blogs" :key="blog.id">
            件名:
            <Link
                class="text-blue-300"
                :href="route('inertia.show', { id: blog.id })"
                >{{ blog.title }}</Link
            >, 本文:
            {{ blog.content }}
        </li>
    </ul>
</template>
