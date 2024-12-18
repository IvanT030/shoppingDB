<template>
    <div class="product-create-form">
      <button class="btn-close" @click="closeForm">X</button>
      <h2>新增商品</h2>
      <form @submit.prevent="saveNewProduct">
        <div class="form-field">
          <label>商品名稱：</label>
          <input type="text" v-model="newProduct.name" placeholder="請輸入商品名稱" />
        </div>
  
        <div class="form-field">
          <label>分類：</label>
          <input type="text" v-model="newProduct.category" placeholder="請輸入商品分類" />
        </div>
  
        <div class="form-field">
          <label>價格：</label>
          <input type="number" v-model="newProduct.price" placeholder="請輸入商品價格" />
        </div>
  
        <div class="form-field">
          <label>庫存：</label>
          <input type="number" v-model="newProduct.stock" placeholder="請輸入庫存數量" />
        </div>
  
        <div class="form-field">
          <label>銷售量：</label>
          <input type="number" v-model="newProduct.salesVolume" placeholder="請輸入銷售量" />
        </div>
  
        <div class="form-buttons">
          <button type="button" class="btn-cancel" @click="closeForm">取消</button>
          <button type="submit" class="btn-save">確認</button>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      showForm: {
        type: Boolean,
        required: true,
      },
    },
    data() {
      return {
        newProduct: {
          name: "",
          category: "",
          price: null,
          stock: null,
          salesVolume: null,
        },
      };
    },
    methods: {
      closeForm() {
        this.$emit("close"); // 通知父组件关闭表单
      },
      saveNewProduct() {
        this.$emit("save", this.newProduct); // 将新商品数据传递给父组件
      },
    },
  };
  </script>
  
  <style scoped>
  .product-create-form {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    width: 400px;
    text-align: center;
    z-index: 1000;
  }
  
  .btn-close {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #ff4d4d;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .btn-close:hover {
    background-color: #d43f3f;
  }
  
  h2 {
    margin-bottom: 20px;
    color: #333;
  }
  
  .form-field {
    margin-bottom: 16px;
    text-align: left;
  }
  
  label {
    display: block;
    font-size: 14px;
    margin-bottom: 8px;
    color: #555;
  }
  
  input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  
  .form-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
  }
  
  .btn-cancel {
    background-color: #ff4d4d;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .btn-cancel:hover {
    background-color: #d43f3f;
  }
  
  .btn-save {
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .btn-save:hover {
    background-color: #45a049;
  }
  </style>
  