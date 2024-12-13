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

<script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import DefaultPage from '@/components/DefaultPage.vue';
  import ProductList from '@/components/ProductList.vue';
  import ProductDetail from '@/components/ProductDetail.vue';

  const products = ref([]);
  const selectedProduct = ref(null);

  /*出問題了 沒辦法拿資料*/
  const fetchProducts = async () => {
    try {
      const response = await axios.get("http://localhost/mytest/products");
      console.log(response)
      products = response.data.map(product => ({
        id: product.ProductID,
        name: product.ProductName,
        image: "https://via.placeholder.com/150",
        category: product.Category,
        price: product.Price,
        stock: product.Stock,
        salesVolume: product.SaleVolume
      }));
    } catch (error) {
      console.error('获取商品失败:', error);
    }
  }

  onMounted(fetchProducts);

  const viewDetail = (product) => {
    selectedProduct.value = product;
  };

  const closeDetail = () => {
    selectedProduct.value = null;
  };

  const saveProduct = async (updatedProduct) => {
    try {
      await axios.put(`http://localhost/mytest/products/${updatedProduct.id}`, updatedProduct);
      const index = products.value.findIndex((p) => p.id === updatedProduct.id);
      if (index !== -1) products.value.splice(index, 1, updatedProduct);
    } catch (error) {
      console.error('保存商品失败:', error);
    }
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