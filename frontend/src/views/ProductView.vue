<template>
  <div>
    <!-- 頁面標題 -->
    <DefaultPage :pageTitle="'商品管理'" />

    <button class="btn" @click="back">回主頁</button> <br><br>
    <button class="btn" @click="insert"> 新增商品 </button>

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

    <ProductCreateForm
      v-if="showCreateForm"
      @close="closeCreateForm"
      @save="addProduct"
    />

  </div>
</template>

<script setup>
  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';
  import axios from 'axios';
  import DefaultPage from '@/components/DefaultPage.vue';
  import ProductList from '@/components/ProductList.vue';
  import ProductDetail from '@/components/ProductDetail.vue';
  import ProductCreateForm from '@/components/ProductCreateForm.vue';

  const products = ref([]);
  const selectedProduct = ref(null);
  const router = useRouter()
  const showCreateForm = ref(false);

  const fetchProducts = async () => {
    try {
      const response = await axios.get("http://localhost/mytest/products");
      console.log("Response Data:", response.data);  // Log the entire response data
      if (Array.isArray(response.data)) {
        products.value = response.data.map(product => ({
          id: product.ProductID,
          name: product.ProductName,
          category: product.Category,
          price: product.Price,
          sales: product.SaleVolume,
        }));
      } else {
        console.error('Expected an array but received:', response.data);
      }
    } catch (error) {
      alert('获取商品失败');
      console.error("Fetch Products Error:", error.response || error.message);
    }
  };

  onMounted(fetchProducts);

  const back = () =>{
    router.push({name: 'branch'})
  }

  const insert = () => {
    showCreateForm.value = true;
  };

  const closeCreateForm = () => {
    showCreateForm.value = false;
  };

  const viewDetail = (product) => {
    selectedProduct.value = product;
  };

  const closeDetail = () => {
    selectedProduct.value = null;
  };

  const addProduct = async (newProduct) => {
    const formattedProduct = {
      ProductName: newProduct.name,
      Category: newProduct.category,
      Price: newProduct.price,
      SaleVolume: newProduct.sales,
    };

    try {
      if (!formattedProduct.ProductName || !formattedProduct.SaleVolume ||
      !formattedProduct.Category || !formattedProduct.Price == null) {
        alert("請填寫所有必要的欄位！");
        return;
      }
      const response = await axios.post("http://localhost/mytest/products", formattedProduct);

      const createdProduct = response.data; // 從後端獲取返回的產品數據
      console.log(createdProduct)
      products.value.push({
        id: createdProduct.ProductID,
        name: createdProduct.ProductName,
        category: createdProduct.Category,
        price: createdProduct.Price,
        sales: createdProduct.SaleVolume,
      });
      console.log(products.value)
      alert("商品新增成功！");
    } catch (error) {
      alert("商品新增失敗！");
      console.error("Add Product Error:", error.response || error.message);
    } finally {
      closeCreateForm();
    }
  };

  //更新Product
  const saveProduct = async (updatedProduct) => {
  const formattedProduct = {
    ProductID: updatedProduct.id,
    ProductName: updatedProduct.name,
    Category: updatedProduct.category,
    Price: updatedProduct.price,
    SaleVolume: updatedProduct.sales,
  };
  console.log(formattedProduct)

  try {
    if (!formattedProduct.ProductID || !formattedProduct.ProductName || !formattedProduct.SaleVolume||
      !formattedProduct.Category || formattedProduct.Price == null) {
      alert("請填寫所有必要的欄位！");
      return;
    }
    await axios.put(`http://localhost/mytest/products/${formattedProduct.ProductID}`, formattedProduct);
    const index = products.value.findIndex((p) => p.id === updatedProduct.id);
    if (index !== -1) {
      products.value.splice(index, 1, {
        id: formattedProduct.ProductID,
        name: formattedProduct.ProductName,
        category: formattedProduct.Category,
        price: formattedProduct.Price,
        sales: formattedProduct.SaleVolume,
      });
    }
    closeDetail();
    alert("商品更新成功！");
  } catch (error) {
    console.error("Save Product Error:", error.response || error.message);
    alert("商品更新失敗！");
  }
};
</script>

<style>
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

.btn {
  background-color: #2ecc71;
  color: b6b6b6;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #27ae60;
}
</style>
