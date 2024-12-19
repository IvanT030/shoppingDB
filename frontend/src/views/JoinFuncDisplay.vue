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
import { ref, onMounted } from 'vue'; // 加入 onMounted 确保在组件挂载时调用
import axios from 'axios';
import { useRouter } from 'vue-router';
import DefaultPage from '@/components/DefaultPage.vue';

const joinList = ref([]); // 用于存储 join 的结果
const router = useRouter();

// 返回主页方法
const back = () => {
  router.push({ name: 'branch' });
};

// 获取 join 数据
const fetchJoin = async () => { 
  try {
    console.log('Fetching join data...');
    const response = await axios.get('http://localhost/mytest/join');
    console.log('Response Data:', response.data); // 确认返回的数据信息

    // 数据处理示例：直接映射到 joinList
    joinList.value = response.data.map((purchase) => ({
      StoreID: purchase.StoreID,
      StoreName: purchase.StoreName,
      City: purchase.City,
      ProductID: purchase.ProductID,
      Quantity: purchase.Quantity,
      PurchaseDate: purchase.PurchaseDate, // Date 格式也可以做转换
      ExpirationDate: purchase.ExpirationDate,
    }));
  } catch (error) {
    console.error('Error fetching join data:', error); // 打印具体错误信息
    alert('join不到啦');
    back(); // 如果获取失败返回主页
  }
};

// 确保组件挂载时调用 fetchJoin
onMounted(fetchJoin);
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