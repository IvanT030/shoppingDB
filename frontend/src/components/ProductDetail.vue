<template>
  <div class="modal-container">
    <div class="product-detail">
      <button type="button" class="btn-close" v-on:click="closeDetail()"> X </button>
      
      <div v-if="!editing">
        <h2>{{ product.name }}</h2>
        <p>分類：{{ product.category }}</p>
        <p>價格：{{ product.price }} 元</p>
        <p>總銷售量：{{ product.sales }} 件</p>
        <button type="button" class="btn-edit" v-on:click="edit()"> 修改 </button>
      </div>

      <div v-else class="edit-container">
        <div class="edit-field">
          <label>商品名稱：</label>
          <input type="text" v-model="newProduct.name" />
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
          <label>總銷售量：</label>
          <input type="number" v-model="newProduct.sales" /> 件
        </div>

        <div class="edit-buttons">
          <button type="button" class="btn-edit-nop" v-on:click="cancelEdit()">取消</button>
          <button type="button" class="btn-edit-yap" v-on:click="save(newProduct)">確認</button>
        </div>
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
  data() {
    return {
      editing: false,
      newProduct: null,
    };
  },
  methods: {
    closeDetail() {
      this.editing = false;
      this.$emit("close"); // 通知父组件关闭模态框
    },
    edit() {
      this.editing = true;
      this.newProduct = JSON.parse(JSON.stringify(this.product)); // 深拷贝
    },
    cancelEdit() {
      this.editing = false;
      this.newProduct = null;
    },
    save(data) {
    const cleanData = JSON.parse(JSON.stringify(data)); // 深拷貝，避免代理問題
    this.$emit('saveData', cleanData); // 發送事件通知父組件更新數據
    this.editing = false; // 結束編輯模式
    this.newProduct = null;
  }

  },
};
</script>

<style scoped>
/* 模态框外层容器 */
.modal-container {
  position: fixed; /* 固定定位，确保模态框不随页面滚动 */
  top: 0;
  left: 0;
  width: 100vw; /* 占满整个视窗宽度 */
  height: 100vh; /* 占满整个视窗高度 */
  background-color: rgba(0, 0, 0, 0.5); /* 半透明背景 */
  display: flex; /* 使用 flexbox 实现居中对齐 */
  align-items: center; /* 垂直居中 */
  justify-content: center; /* 水平居中 */
  z-index: 1000; /* 确保在最上层显示 */
}

/* 商品详情卡片 */
.product-detail {
  width: 400px; /* 固定宽度 */
  padding: 20px; /* 内边距 */
  border-radius: 8px; /* 圆角边框 */
  background-color: #ffffff; /* 白色背景 */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* 投影效果 */
  text-align: center; /* 居中对齐文本 */
  position: relative; /* 方便定位关闭按钮 */
}

/* 关闭按钮 */
.btn-close {
  background-color: #ff4d4d;
  color: white;
  border: none;
  padding: 10px;
  border-radius: 4px;
  cursor: pointer;
  position: absolute;
  right: 10px;
  top: 10px;
}

.btn-close:hover {
  background-color: #d43f3f;
}

/* 编辑模式容器 */
.edit-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  padding: 20px;
  border-radius: 8px;
  background-color: rgb(88, 84, 84, 0.1);
}

/* 输入框样式 */
.edit-field {
  width: 100%;
  margin-bottom: 16px;
}

.edit-field label {
  display: block;
  font-size: 18px;
  margin-bottom: 8px;
}

.edit-field input {
  width: 100%;
  padding: 8px;
  font-size: 16px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 4px;
}

/* 按钮组样式 */
.edit-buttons {
  display: flex;
  justify-content: space-between; /* 按钮两端对齐 */
  width: 100%;
}

.btn-edit-nop,
.btn-edit-yap {
  padding: 10px 20px;
  font-size: 18px;
  cursor: pointer;
  border: none;
  border-radius: 4px;
}

.btn-edit-nop {
  background-color: #ff4d4d;
  color: white;
}

.btn-edit-yap {
  background-color: #4caf50;
  color: white;
}
</style>
