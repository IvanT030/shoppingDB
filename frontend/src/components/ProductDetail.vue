<template>
    <div class="product-detail">
      <button type="button" class="btn-close" v-on:click="closeDetail()"> X </button>
      
      <div v-if="!editing">
        <h2>{{ product.name }}</h2>
        <img :src="product.image" alt="商品圖片" />
        <p>分類：{{ product.category }}</p>
        <p>價格：{{ product.price }} 元</p>
        <p>庫存：{{ product.stock }}</p>
        <p>銷售量：{{ product.salesVolume }}</p>
        <button type="button" class="btn-edit" v-on:click="edit()"> 修改 </button>
      </div>

      <div v-else class="edit-container">
        <div class="edit-field">
          <label>商品名稱：</label>
          <input type="text" v-model="newProduct.name" />
        </div>
        <div class="edit-field">
          <img :src="newProduct.image" alt="商品圖片" />
        </div>
        <div class="edit-field">
          <label>分類：</label>
          <input type="text" v-model="newProduct.category" />
        </div>
        <div class="edit-field">
          <label>價格：</label>
          <input type="number" v-model="newProduct.price" /> 元
        </div>
        <div class="edit-field">
          <label>庫存：</label>
          <input type="number" v-model="newProduct.stock" />
        </div>
        <div class="edit-field">
          <label>銷售量：</label>
          <input type="number" v-model="newProduct.salesVolume" />
        </div>
        <div class="edit-buttons">
          <button type="button" class="btn-edit-nop" v-on:click="cancelEdit()">取消</button>
          <button type="button" class="btn-edit-yap" v-on:click="save(newProduct)">確認</button>
        </div>
      </div>
      
    </div>
</template>
  
  <script>
  export default {
    props: {
      product: {
        type: Object,
        required: true,
      },
    },
    data(){
      return{
        editing: false,
        newProduct: null,
      }
    },
    methods: {
      closeDetail() {
        this.editing = false;
        this.$emit('close'); //通知父組件關閉詳細視窗
      },
      edit(){
        this.editing = true;
        /*deep copy*/
        this.newProduct = JSON.parse(JSON.stringify(this.product));
      },
      cancelEdit(){
        console.log(this.product);
        this.editing = false;
        this.newProduct = null;
      },
      save(data){
        this.$emit('saveData', data);
        this.editing = false;
        this.newProduct = null;
      },
    }
  };
  </script>
  
  <style>
  .product-detail {
    font-size: 20px;
    padding: 13px;
    margin-top: 6px;
    background-color: rgb(88, 84, 84, 0.35);
  }

  .edit-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    max-width: 100%;
    margin: 20px auto;
  }
  .edit-field {
    width: 40%;
    margin-bottom: 16px;
  }

  .edit-field label {
    font-size: 18px;
  }

  .edit-field input {
    width: 100%;
    font-size: 16px;
    border-radius: 4px;
  }

  .btn-close{
    position: absolute;
    right: 8%;
    appearance: none;
    background-color: transparent;
    border: 2px solid #1A1A1A;
    border-radius: 15px;
    box-sizing: border-box;
    color: #3B3B3B;
    cursor: pointer;
    display: inline-block;
    font-family: Roobert,-apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
    font-size: 14px;
    font-weight: 600;
    line-height: normal;
    outline: none;
    padding: 14px;
    text-align: center;
    text-decoration: none;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    will-change: transform;
  }

  .btn-close:disabled {
    pointer-events: none;
  }

  .btn-close:hover {
    color: #fff;
    background-color: #444343;
    box-shadow: rgba(0, 0, 0, 0.25) 0 8px 15px;
    transform: translateY(-2px);
  }

  .btn-close:active {
    box-shadow: none;
    transform: translateY(0);
  }

  .btn-edit {
    transition-duration: 0.4s;
    padding: 5px 15px;
  }

  .btn-edit:hover {
    background-color: #1A1A1A;
    color: white;
  }

  .btn-edit-nop {
    position: relative;
    transition-duration: 0.4s;
    padding: 5px 15px;
    right: 10%;
  }

  .btn-edit-nop:hover {
    background-color: #b6b6b6;
  }

  .btn-edit-yap {
    position: relative;
    transition-duration: 0.4s;
    padding: 5px 15px;
    left: 10%;
  }

  .btn-edit-yap:hover {
    background-color: #b50000;
    color: white;
  }
  
  </style>