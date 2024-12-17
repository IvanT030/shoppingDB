<template>
  <!-- 頁面標題 -->
  <DefaultPage pageTitle="分店查詢" />

  <!-- 分店列表 -->
  <div class="store-container" v-if="!intoDetail">
    <div v-for="store in stores" :key="store.StoreID" class="store-item">
      <button class="store-button" @click="openDetail(store)">
        {{ store.StoreName }}
      </button>
    </div>
  </div>

  <!-- 分店詳細資訊 -->
  <StoreDetail 
    v-else 
    :display="intoDetail" 
    @closeDetail="closeDetail" 
  />
</template>

<script setup>
import { ref, onMounted } from 'vue';
import DefaultPage from '@/components/DefaultPage.vue';
import StoreDetail from '@/components/StoreDetail.vue';
import axios from 'axios';

const intoDetail = ref(null); // 當前選中的分店詳細資訊
const stores = ref([]);       // 分店列表數據

// 從後端獲取分店列表數據
const fetchStores = async () => {
  try {
    const response = await axios.get('http://localhost/mytest/stores'); // 請求後端 API
    stores.value = response.data.map(store => ({
      StoreID: store.StoreID,
      StoreName: store.StoreName,
      StoreNumber: store.StoreNumber,
      City: store.City,
    }));
  } catch (error) {
    console.error('獲取分店數據失敗：', error);
  }
};

// 打開分店詳細頁面
const openDetail = (store) => {
  intoDetail.value = store;
};

// 關閉分店詳細頁面
const closeDetail = () => {
  intoDetail.value = null;
};

// 組件掛載時自動調用 API
onMounted(() => {
  fetchStores();
});
</script>

<style scoped>
.store-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100vh; /* 讓容器填滿整個視窗高度 */
  padding-top: 140px; /* 避免與頁面標題重疊 */
}

  .store-container h2 {
    font-size: 32px;
  }

  .store-item {
    margin: 15px 0;
  }

  .store-button {
    padding: 15px 60px;
    font-size: 18px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.2s ease, background-color 0.2s ease;
    text-align: center;
  }

  .store-button:hover {
    transform: scale(1.05);
    background-color: #0056b3;
  }
</style>
