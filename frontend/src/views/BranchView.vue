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
    <router-link to="/joinFunctionDisplay">或是...直接看所有店的進貨清單?</router-link>
  </div>

  <!-- 分店詳細資訊 -->
  <StoreDetail 
    v-else 
    :display="intoDetail" 
    :mostProduct="mostProduct"
    @closeDetail="closeDetail" 
    @goProductView="navigateToProductView"
    @goPurchaseView="navigateToPurchasetView">
  </StoreDetail>
</template>

<script setup>
  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';
  import DefaultPage from '@/components/DefaultPage.vue';
  import StoreDetail from '@/components/StoreDetail.vue';
  import axios from 'axios';

  const intoDetail = ref(null); // 當前選中的分店詳細資訊
  const stores = ref([]);       // 分店列表數據
  const mostProduct = ref();
  const router = useRouter()

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
    getMostProduct(store.storeID);
  };

  // 關閉分店詳細頁面
  const closeDetail = () => {
    intoDetail.value = null;
    router.push({ name: 'branch' });
  };

  //以下是你要實作-----------------
  const navigateToProductView = (id) => {
    router.push({ name: 'ProductView', params: { storeID: id } });
  };
  const navigateToPurchasetView = (id) => {
    router.push({ name: 'purchaseView', params: { storeID: id } });
  }
  //下面是新的功能 這裡要用aggregate function找到再storeID下單個總和最多的商品
  const getMostProduct = (storeID) => {
  /*axios查詢*/
  //mostProduct.value = 查詢的商店物件;
  //下面是範例
    mostProduct.value = {
      name: '我媽',
      Quantity: 50,
    }
  }
  //------------------------------

  // 組件掛載時自動調用 API
  onMounted(() => {
    fetchStores();
  });
</script>

<style scoped>
  .store-container {
    left: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
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
