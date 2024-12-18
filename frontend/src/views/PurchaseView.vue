<template>
  <DefaultPage :pageTitle="'進貨清單'" />
  <div class="purchase-list">
    <button class="func-button" @click="navToBranch">返回分店頁面</button>
    <button class="func-button" @click="openCreateForm">新增進貨記錄</button>
    <table>
      <thead>
        <tr>
          <th>店家編號</th>
          <th>商品編號</th>
          <th>進貨數量</th>
          <th>進貨日期</th>
          <th>過期日期</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="purchase in purchaseList" :key="purchase.PurchaseID">
          <td>{{ purchase.StoreID }}</td>
          <td>{{ purchase.ProductID }}</td>
          <td>{{ purchase.Quantity }}</td>
          <td>{{ purchase.PurchaseDate }}</td>
          <td>{{ purchase.ExpirationDate }}</td>
          <td>
            <button @click="openEditForm(purchase)">修改</button>
            <button @click="deletePurchase(purchase.PurchaseID)">刪除</button>
          </td>
        </tr>
      </tbody>
    </table>
    <PurchaseForm
      v-if="showForm"
      :purchase="currentPurchase"
      @close="closeForm"
      @save="savePurchase"
    />
  </div>
</template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import axios from 'axios';
  import DefaultPage from '@/components/DefaultPage.vue';
  import PurchaseForm from '@/components/PurchaseForm.vue';
  
  const route = useRoute();
  const router = useRouter();
  const storeID = route.params.storeID;
  const purchaseList = ref([]);
  const showForm = ref(false);
  const currentPurchase = ref(null);
  //因為我表單用同一個格式 但是要去區分更新跟新增
  const createForm = ref(null);

  /*資料庫拿數據*/
  const fetchPurchases = async () => {
  try {
    const response = await axios.get("http://localhost/mytest/purchases");
    const sampleData = response.data.map(product => ({
      StoreID: product.StoreID,
      ProductID: product.ProductID,
      Quantity: product.Quantity,
      PurchaseDate: product.PurchaseDate,
      ExpirationDate: product.ExpirationDate
    }));
    purchaseList.value = sampleData.filter((purchase) => purchase.StoreID == storeID);
  } catch (error) {
    alert('資料讀取錯誤')
  }
  };

  const openCreateForm = () => {
    currentPurchase.value = null;
    createForm.value = true;
    showForm.value = true;
  };
  
  const openEditForm = (purchase) => {
    currentPurchase.value = { ...purchase };
    createForm.value = false;
    showForm.value = true;
  };

  const closeForm = () => {
    createForm.value = null;
    showForm.value = false;
  };
  
  //新增跟修改訂單-----------------------------------
  /*保存修改完訂單 輸入是object*/
  const savePurchase = async (purchase) => {
    /*要確認是否為有效新增 是否為NULL purchase是一個物件
    if(purchase)
    然後purchase = {
      StoreID: '',
      ProductID: '',
      Quantity: '',
      PurchaseDate: '',
      ExpirationDate: '',
    }
    */
    if(createForm.value){
      //這裡做新增的進貨
    }else{
      //這裡做修改的進貨
    }
    closeForm();
  };
  
  /*資料庫刪掉訂單 輸入是ID*/
  const deletePurchase = async (purchaseID) => {
    closeForm();
  };
  //------------------------------------
  const navToBranch = () => {
    router.push({ name: 'branch' });
  }

  onMounted(fetchPurchases);
</script>
  
<style>
  .func-button {
    background-color: #3498db;
    color: b6b6b6;
    border: none;
    padding: 10px 20px;
    margin-top: 40px;
    margin-bottom: 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  .back-button:hover {
    background-color: #2980b9;
  }
  .purchase-list {
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
  button {
    margin: 4px;
  }
</style>