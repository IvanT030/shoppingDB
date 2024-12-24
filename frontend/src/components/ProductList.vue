<template>
    <div class="product-list" :class="{ 'disabled': selectedProduct }">
      <div 
        v-for="product in products"
        :key="product.id"
        class="product-card"
        :class="{ selected: selectedProduct && selectedProduct.id === product.id }"
        @click="viewDetail(product)"
      >
        <h2>{{ product.name }}</h2>
        <p>價格：{{ product.price }}</p>
        <p>總銷售量：{{ product.sales }}</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      products: {
        type: Object,
        required: true,
      },
      selectedProduct: {
        type: Object,
        default: null,
      },
    },
    methods: {
      viewDetail(product) {
        this.$emit('view-detail', product); // 通知父組件點擊商品
      },
    },
  };
  </script>
  
  <style>
  .product-list.disabled {
    pointer-events: none;
    opacity: 0.6;
  }
  
  .product-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }
  .product-card {
    border: 2px solid #0F0F0F;
    border-radius: 8px;
    padding: 16px;
    margin: 10px;
    text-align: center;
    width: 200px;
    cursor: pointer;
    animation: openIn 0.5s ease-in;
  }
  /*滑鼠在上面的時候觸發*/
  .product-card:hover { 
    transform: scale(1.08);
  }
  .product-card.selected {
    border-color: rgba(7, 76, 105, 0.4);
    background-color:rgba(7, 76, 105, 0.4);
  }

  @keyframes openIn {
    0%{
      capacity: 0;
      transform: translateY(150px);
    }
    100%{
      capacity: 1;
      transform: translateY(0);
    }
  }
  </style>
  