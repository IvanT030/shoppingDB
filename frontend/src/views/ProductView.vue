<template>
  <div>
    <DefaultPage :pageTitle="'商品管理'" />
    <ProductList :products="products" @view-detail="viewDetail" />
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
  components: { ProductList, ProductDetail, DefaultPage },
  data() {
    return {
      products: [],
      selectedProduct: null,
    };
  },
  async mounted() {
  try {
    const response = await axios.get("http://localhost/mytest/products");
    // 映射字段名
    this.products = response.data.map(product => ({
      id: product.ProductID,
      name: product.ProductName,
      image: "https://via.placeholder.com/150", // 默認圖片
      category: product.Category,
      price: product.Price,
      stock: product.Stock,
      salesVolume: product.SaleVolume
    }));
  } catch (error) {
    console.error("獲取商品失敗：", error);
  }
},
  methods: {
    viewDetail(product) {
      this.selectedProduct = product;
    },
    closeDetail() {
      this.selectedProduct = null;
    },
    async saveProduct(updatedProduct) {
      try {
        await axios.put(`http://localhost/mytest/products/${updatedProduct.id}`, updatedProduct);
        const index = this.products.findIndex((p) => p.id === updatedProduct.id);
        if (index !== -1) this.products.splice(index, 1, updatedProduct);
      } catch (error) {
        console.error("保存商品失敗：", error);
      }
    },
  },
};
</script>



<style>
#app {
  font-family: Arial, sans-serif;
  text-align: center;
}

#detail {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); /* 平移至真正居中位置 */
  width: 50%;    
  max-width: 600px; 
  padding: 20px; 
  background-color: aliceblue; 
  border-radius: 8px; 
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
  z-index: 1000;
}

</style>