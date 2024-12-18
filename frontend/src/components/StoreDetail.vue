<template>
  <div class="store-detail">
    <!-- 返回按鈕 -->
    <button class="back-button" @click="$emit('closeDetail')"> 回分店頁面 </button>

    <!-- 分店詳細資訊 -->
    <div class="store-card">
      <h1>{{ display.StoreName }}</h1>
      <p><strong>電話：</strong> {{ display.StoreNumber }}</p>
      <p><strong>城市：</strong> {{ display.City }}</p>
    </div>

    <!-- 操作按鈕組 -->
    <div class="button-group">
      <button class="action-button" @click="$emit('goPurchaseView',display.StoreID)">
        查看進貨清單
      </button>
      <button class="action-button" @click="$emit('goProductView',display.StoreID)">
        修改商品資訊
      </button>
    </div>

    <!--進貨最多的商品-->
    <br>
    <h1>本店進貨最多商品</h1>
    <p>{{mostProduct.name}}: {{mostProduct.Quantity}}件</p>

  </div>
</template>

<script setup>
  import { defineProps, defineEmits } from 'vue';
  // 定義 emit 事件，通知父組件關閉分店詳細視圖 去到其他連結
  const emit = defineEmits(['closeDetail', 'goProductView', 'goPurchaseView']);
  // 定義從父組件接收的 `display` 資料（分店詳細資訊）
  const props = defineProps({
    display: {
      type: Object,
      default: false,
    },
    mostProduct: {
      type: Object,
      default: false,
    },
  });

  /* 這個在你的那個branch被改搬到父組件去了 實作方面到BranchView.vue
  // 查看進貨清單（可擴展功能）
  const viewRestockList = () => {
    console.log(storeID); // 這裡可以連接進貨清單 API
    alert('進貨清單功能尚未實現');
  };

  // 修改商品資訊（可擴展功能）
  const editProducts = () => {
    console.log('修改商品功能尚未實現'); // 這裡可以導航到商品編輯頁面
    alert('修改商品功能尚未實現');
  };
  */
</script>

<style scoped>
/* 整體佈局 */
.store-detail {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: #f9f9f9;
  height: 60vh; /* 滿屏高度 */
  padding: 20px;
}

/* 返回按鈕 */
.back-button {
  background-color: #3498db;
  color: white;
  border: none;
  padding: 10px 20px;
  margin-bottom: 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.back-button:hover {
  background-color: #2980b9;
}

/* 分店資訊卡片 */
.store-card {
  width: 400px;
  padding: 30px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.store-card h1 {
  font-size: 24px;
  margin-bottom: 10px;
  color: #333;
}

.store-card p {
  font-size: 16px;
  color: #555;
  margin: 8px 0;
}

/* 操作按鈕 */
.button-group {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.action-button {
  background-color: #2ecc71;
  color: white;
  border: none;
  padding: 10px 20px;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.action-button:hover {
  background-color: #27ae60;
}
</style>
