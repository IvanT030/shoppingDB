<template>
  <DefaultPage pageTitle="分店查詢" />

  <div class="store-container" v-if="!intoDetail">
    <h2>選擇分店：</h2>
    <div v-for="store in stores" :key="store.StoreID" class="store-item">
      <button class="store-button" @click="openDetail(store)">
        {{ store.StoreName }}
      </button>
    </div>
  </div>

  <StoreDetail
    v-else 
    :display="intoDetail" 
    @closeDetail="closeDetail" 
    @goProductView="navigateToProductView"
    @goPurchaseView="navigateToPurchasetView">
  </StoreDetail>

</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import DefaultPage from '@/components/DefaultPage.vue';
import StoreDetail from '@/components/StoreDetail.vue';

const stores = [
  { StoreID: 1, StoreName: '中正路分店', StoreNumber: '0212344567', City: '台北' },
  { StoreID: 2, StoreName: '民權路分店', StoreNumber: '0223456789', City: '新北' },
  { StoreID: 3, StoreName: '文化路分店', StoreNumber: '0234567890', City: '桃園' },
];

const intoDetail = ref(null);
const router = useRouter();

const openDetail = (store) => {
  intoDetail.value = store;
};

const closeDetail = () => {
  intoDetail.value = null;
  router.push({ name: 'branch' });
};

const navigateToProductView = (id) => {
  router.push({ name: 'ProductView', params: { storeID: id } });
};

const navigateToPurchasetView = (id) => {
  router.push({ name: 'purchaseView', params: { storeID: id } });
}
</script>

<style scoped>
  .store-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100vh;
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
