<template>
  <div>
    <!-- 頁面標題 -->
    <DefaultPage :pageTitle="'商品管理'" />

    <!-- 商品列表 -->
    <ProductList 
      :products="products" 
      @view-detail="viewDetail" 
    />

    <!-- 商品詳細資訊 -->
    <ProductDetail
      v-if="selectedProduct"
      :product="selectedProduct"
      @close="closeDetail"
      @saveData="saveProduct"
    />
  </div>
</template>

<script>
import axios from "axios";
import ProductList from "../components/ProductList.vue";
import ProductDetail from "../components/ProductDetail.vue";
import DefaultPage from "../components/DefaultPage.vue";

export default {
  components: {
    ProductList,
    ProductDetail,
    DefaultPage,
  },
  data() {
    return {
      products: [],          // 商品列表數據
      selectedProduct: null, // 當前選中的商品
    };
  },
  async mounted() {
    // 組件掛載時從後端獲取商品列表
    await this.fetchProducts();
  },
  methods: {
    // 從後端獲取商品列表
    async fetchProducts() {
      try {
        const response = await axios.get("http://localhost/mytest/products");
        // 從後端回傳的數據映射成前端使用的格式
        this.products = response.data.map(product => ({
          id: product.ProductID,
          name: product.ProductName,
          image: "https://via.placeholder.com/150", // 預設圖片
          category: product.Category,
          price: product.Price,
          stock: product.Stock,
          salesVolume: product.SaleVolume,
        }));
      } catch (error) {
        console.error("獲取商品失敗：", error);
      }
    },
    // 顯示商品詳細資訊
    viewDetail(product) {
      this.selectedProduct = product;
    },
    // 關閉商品詳細資訊視窗
    closeDetail() {
      this.selectedProduct = null;
    },
    // 保存修改後的商品資訊
    async saveProduct(updatedProduct) {
      try {
        // 將修改後的商品資訊提交給後端
        await axios.put(`http://localhost/mytest/products/${updatedProduct.id}`, updatedProduct);

        // 更新本地商品列表
        const index = this.products.findIndex(p => p.id === updatedProduct.id);
        if (index !== -1) {
          this.products.splice(index, 1, updatedProduct);
        }

        // 關閉詳細資訊視窗
        this.closeDetail();
      } catch (error) {
        console.error("保存商品失敗：", error);
      }
    },
  },
};
</script>

<style scoped>
/* 全局樣式 */
#app {
  font-family: Arial, sans-serif;
  text-align: center;
}

/* 商品詳細資訊視窗樣式 */
#detail {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 50%;
  max-width: 600px;
  padding: 20px;
  background-color: aliceblue;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  z-index: 1000;
}
</style>
