<template>
  <div class="form-container">
    <form @submit.prevent="handleSubmit">
    <h2>{{ purchase?.PurchaseID ? '修改進貨記錄' : '新增進貨記錄' }}</h2>
    <label>
        訂單編號:(選填)
        <input v-model="form.PurchaseID" type="number" required />
    </label>
    <p>
      分店編號: {{ form.StoreID }}
    </p>
    <label>
        商品編號:
        <input v-model="form.ProductID" type="number" required />
    </label>
    <label>
        進貨數量:
        <input v-model="form.Quantity" type="number" required />
    </label>
    <label>
        進貨日期:
        <input v-model="form.PurchaseDate" type="date" required />
    </label>
    <label>
        過期日期:
        <input v-model="form.ExpirationDate" type="date" required />
    </label>
    </form>
    <div class="edit-buttons">
      <button type="button" class="btn-edit-nop" v-on:click="$emit('close')">取消</button>
      <button type="button" class="btn-edit-yap" v-on:click="$emit('save', form);">確認</button>
    </div>
  </div>
</template>
  
<script setup>
  import { ref, watch } from 'vue';

  const props = defineProps({
    purchase: {
      type: Object,
      default: null,
    },
  });
  const storeID = props.purchase?.StoreID ?? null; // 修正 props 的讀取方式

  // 日期格式化函数：将 Date 对象转为 YYYY-MM-DD 格式
  const formatDate = (date) => {
    if (!date) return ''; // 如果日期为空，返回空字符串
    const d = new Date(date);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  };

  const form = ref({
    PurchaseID: '',
    StoreID: storeID,
    ProductID: '',
    Quantity: '',
    PurchaseDate: '',
    ExpirationDate: '',
  });
  
  watch(() => props.purchase,
    (newValue) => {
      if (newValue) {
      form.value = {
        ...newValue,
        PurchaseDate: formatDate(newValue.PurchaseDate), // 格式化進貨日期
        ExpirationDate: formatDate(newValue.ExpirationDate), // 格式化過期日期
      }}else {
        form.value = {
          PurchaseID: '',
          StoreID: storeID,
          ProductID: '',
          Quantity: '',
          PurchaseDate: '',
          ExpirationDate: '',
        };
      }
    },
    { immediate: true }
  );
  
  //傳遞資料給父組件
  const handleSubmit = () => {
    emit('save', form.value);
  };
</script>
  
<style>
  .form-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    /*永遠置中*/
    padding: 20px;
    background-color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    z-index: 1000;
    width: 400px;
  }

  form {
    width: 100%;
    max-width: 400px;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    position: relative;
  }

  form label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    color: #333;
  }

  form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }

  form input::placeholder {
    font-style: italic;
    color: #aaa;
  }

  .button-container {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
  }

  .btn-edit-nop {
    transition-duration: 0.4s;
    left: 10%;
    padding: 5px 15px;
    background-color: #e0e0e0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .btn-edit-nop:hover {
    background-color: #b6b6b6;
  }

  .btn-edit-yap {
    left: -10%;
    transition-duration: 0.4s;
    padding: 5px 15px;
    background-color: #ff4d4d;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .btn-edit-yap:hover {
    background-color: #b50000;
  }
</style>