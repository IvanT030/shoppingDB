<template>
    <div class="store-detail">
      <button class="back-button" @click="emit('closeDetail')"> 回分店頁面 </button>
      <div class="store-card">
        <h1>{{ display.StoreName }}</h1>
        <p>電話: {{ display.StoreNumber }}</p>
        <p>分店城市: {{ display.City }}</p>
        <div class="button-group">
          <button class="action-button"> 查看進貨清單 </button>
          <button class="action-button"> 修改商品 </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from 'vue';
  
  const emit = defineEmits(['closeDetail']);
  
  const props = defineProps({
    display: {
      type: Object,
      default: false,
    },
  });
  </script>
  
  <style scoped>
  .store-detail {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #d2dbe2;
  }
  
  .back-button {
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
  
  .store-card {
    width: 400px;
    padding: 40px;
    border-radius: 8px;
    background-color: rgb(232, 234, 244);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-bottom: 40px;
    }
  
  .store-card h2 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
  }
  
  .store-card p {
    font-size: 18px;
    color: #666;
    margin: 10px 0;
  }
  
  .button-group {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
  }
  
  .action-button {
    width: 48%;
    background-color: #2ecc71;
    color: b6b6b6;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .action-button:hover {
    background-color: #27ae60;
  }
  </style>
  