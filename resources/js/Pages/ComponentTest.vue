<script setup>
// インポート名(GuestLayout)は任意の名前でオッケー
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Label from "@/Components/InputLabel.vue";
import Input from "@/Components/TextInput.vue";

const emitTest = (e) => console.log(e);
</script>

<template>
    <!-- 上でインポートした際に決めたインポート名のタグで囲んでコンポーネントを配置する -->
    <GuestLayout>
        <Label value="件名"></Label>
        <Input modelValue="テスト" @update:modelValue="emitTest"></Input>
    </GuestLayout>
</template>
