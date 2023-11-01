<script setup>
import { getToday} from '@/common'
import { reactive, onMounted, ref, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'


const props = defineProps({
    'customers': Array,
    'items': Array
})
//ページが読み込まれた瞬間にgetToday()を実行し、フォームの日付のデフォルト値として設定する
onMounted(() => {
    form.date = getToday()
    //数量を指定してリアルタイムで合計金額を算出するにあたりpropsのままでは値の操作が出来ないため、リアクティブな配列itemListに値をループ文で挿入し直す
    props.items.forEach( item => { // 配列を1つずつ処理
      itemList.value.push({ // 配列に1つずつ追加
      id: item.id,
      name: item.name,
      price: item.price,
      quantity: 0
    })
  })
})

// リアクティブな配列
const itemList = ref([])

const quantity = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"] // option用

const form = reactive({
    date: null,
    customer_id: null,
    status: true,
    items: []
})

// 商品の数量を変更するとその場で合計金額が計算される
const totalPrice = computed(() => {
    let total = 0
    itemList.value.forEach( item => {
        total += item.price * item.quantity
    })
    return total
})

// 商品と数量を指定し、１つ以上指定した商品のidと数量をform変数に代入しコントローラーにポスト
const storePurchase = () => {
   itemList.value.forEach( item => {
    if( item.quantity > 0){
        form.items.push({
            id: item.id,
            quantity: item.quantity
        })
    }
   })
   Inertia.post(route('purchases.store'), form)
}

</script>

<template>
    <form v-on:submit.prevent="storePurchase" action="">
    日付<br>
    <input type="date" name="date" v-model="form.date"><br>
    会員名<br>
    <!-- セレクトボックスで会員名、idを表示 -->
    <select name="customer" v-model="form.customer_id">
        <option v-for="customer in customers" :value="customer.id" :key="customer.id">
            {{ customer.id }} : {{ customer.name }}
        </option>
    </select>
    <br><br>

商品・サービス<br>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>商品名</th>
            <th>金額</th>
            <th>数量</th>
            <th>小計</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="item in itemList" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.price }}</td>
            <td>
                <select name="quantity" v-model="item.quantity">
                    <option v-for="q in quantity" :value="q" :key="q.id">{{ q }}</option>
                </select>
            </td>
            <td>
                <!-- 小計 -->
                {{ item.price * item.quantity }}
            </td>
        </tr>
    </tbody>
</table>
<br>
合計：{{ totalPrice }}円
<br>
<button>登録する</button>
</form>
</template>
