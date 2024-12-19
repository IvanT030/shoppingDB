<template>
  <DefaultPage :pageTitle="'進貨清單'" />
  <div class="purchase-list">
    <h1>本店進貨最多商品</h1>
    <p>{{mostProductDisplay}}</p>
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
          <td>{{ purchase.PurchaseDate.toLocaleDateString() }}</td>
          <td>{{ purchase.ExpirationDate.toLocaleDateString() }}</td>
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
  import { ref, onMounted, computed} from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import axios from 'axios';
  import DefaultPage from '@/components/DefaultPage.vue';
  import PurchaseForm from '@/components/PurchaseForm.vue';
  
  const route = useRoute();
  const router = useRouter();
  const storeID = route.params.storeID;
  const purchaseList = ref([]);
  const showForm = ref(false);
  const mostProduct = ref(null);
  const currentPurchase = ref(null);
  //因為我表單用同一個格式 但是要去區分更新跟新增
  const createForm = ref(null);

  /*資料庫拿數據*/
  const fetchPurchases = async () => {
  try {
    const response = await axios.get(`http://localhost/mytest/purchases/${storeID}`);
    purchaseList.value = response.data.map(purchase => ({
      PurchaseID: purchase.PurchaseID,
      StoreID: purchase.StoreID,
      ProductID: purchase.ProductID,
      Quantity: purchase.Quantity,
      PurchaseDate: new Date(purchase.PurchaseDate),
      ExpirationDate: new Date(purchase.ExpirationDate),
    }));

  } catch (error) {
    alert('資料讀取錯誤：請檢查後端或網絡連接');
    }
  };

  //aggregate function call
  const fetchMostPurchasedProduct = async () => {
    try {
      const response = await axios.get(`http://localhost/mytest/mostPurchasedProduct/${storeID}`);
      if (response.data) {
        mostProduct.value = response.data;
      } else {
        mostProduct.value = { Name: '無資料', Quantity: 0 };
      }
    } catch (error) {
      console.error('Error fetching most purchased product:', error.response || error.message);
      alert('無法獲取進貨最多商品');
    }
  };

  // 使用計算屬性處理顯示的內容
  const mostProductDisplay = computed(() => {
    if (mostProduct.value) {
      return `${mostProduct.value.name}: ${mostProduct.value.Quantity} 件`;
    }
    return '暫無數據'; // 默認顯示
  });

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
  // 保存進貨資料（新增或修改）
  const savePurchase = async (purchase) => {
    // 驗證必填欄位是否為空
    if (
      !purchase.StoreID ||
      !purchase.ProductID ||
      !purchase.Quantity ||
      !purchase.PurchaseDate ||
      !purchase.ExpirationDate
    ) {
      alert("所有欄位都是必填的！");
      return;
    }

    try {
      if (createForm.value) {
        // 新增進貨
        const response = await axios.post("http://localhost/mytest/purchases", purchase);
        alert("進貨新增成功！");
      } else {
        // 修改進貨
        const response = await axios.put(
          `http://localhost/mytest/purchases/${purchase.PurchaseID}`,
          purchase
        );
        alert("進貨修改成功！");
      }
    } catch (error) {
      console.error("保存進貨錯誤:", error.response || error.message);
      alert("保存進貨失敗！");
    }

    closeForm(); // 關閉表單
    fetchPurchases();
    fetchMostPurchasedProduct();
  };

  // 刪除進貨
  const deletePurchase = async (purchaseID) => {
    try {
      await axios.delete(`http://localhost/mytest/purchases/${purchaseID}`);
      alert("進貨刪除成功！");
    } catch (error) {
      console.error("刪除進貨錯誤:", error.response || error.message);
      alert("刪除進貨失敗！");
    }

    closeForm(); // 關閉表單
    fetchPurchases();
    fetchMostPurchasedProduct();
  };
  //------------------------------------
  const navToBranch = () => {
    router.push({ name: 'branch' });
  }

  onMounted(() => {
    fetchPurchases();
    fetchMostPurchasedProduct();
  });
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