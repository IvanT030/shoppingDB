<template>
    <DefaultPage pageTitle="單純展示join的地方" />
    <button class="bak" @click="back">回主頁</button>
    <table>
      <thead>
        <tr>
          <th>店家編號</th>
          <th>分店名稱</th>
          <th>分店城市</th>
          <th>商品編號</th>
          <th>進貨數量</th>
          <th>進貨日期</th>
          <th>過期日期</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in joinList" :key="item.StoreID">
          <td>{{ item.StoreID }}</td>
          <td>{{ item.StoreName }}</td>
          <td>{{ item.City }}</td>
          <td>{{ item.ProductID }}</td>
          <td>{{ item.Quantity }}</td>
          <td>{{ item.PurchaseDate }}</td>
          <td>{{ item.ExpirationDate }}</td>
        </tr>
      </tbody>
    </table>
</template>
  
<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import DefaultPage from '@/components/DefaultPage.vue';

const joinList = ref([])
const router = useRouter()

const back = () =>{
    router.push({name: 'branch'})
}

/*把purchase跟branch給他join起來，然後照sampleData的格式*/
/*如果要加product的格式也可以*/
try {
    const sampleData = [
    {
        StoreName: '中正路分店', 
        City: '台北',
        StoreID: 1,
        ProductID: 201,
        Quantity: 50,
        PurchaseDate: "2024-12-01",
        ExpirationDate: "2025-01-01",
    },
    {
        StoreName: '中正路分店', 
        City: '台北',
        StoreID: 1,
        ProductID: 202,
        Quantity: 30,
        PurchaseDate: "2024-12-05",
        ExpirationDate: "2025-01-10",
    },
    {
        StoreName: '中正路分店', 
        City: '台北',
        StoreID: 1,
        ProductID: 203,
        Quantity: 20,
        PurchaseDate: "2024-12-10",
        ExpirationDate: "2025-02-01",
    },
    {
        StoreName: '中正路分店', 
        City: '台北',
        StoreID: 1,
        ProductID: 203,
        Quantity: 20,
        PurchaseDate: "2024-12-10",
        ExpirationDate: "2025-02-01",
    },];

    joinList.value = sampleData;
} catch (error) {
  console.error(error);
}

</script>
  
<style>
  .join-list {
    padding: 16px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  table th, table td {
    border: 2px solid #ccc;
    padding: 8px;
    text-align: left;
  }
  .bak {
    background-color: #2ecc71;
    color: b6b6b6;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .bak:hover {
    background-color: #27ae60;
  }
</style>