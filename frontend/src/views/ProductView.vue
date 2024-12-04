<template>
  <div id="app">
    <DefaultPage :pageTitle="'商品修改'" />
    <ProductList :products="products"
    :selectedProduct="selectedProduct" 
    :disabled="selectedProduct !== null"
    @view-detail="viewDetail" />
    <ProductDetail id="detail" v-if="selectedProduct" 
    :product="selectedProduct" 
    @close="closeDetail" @saveData="saveData"/>
  </div>
</template>

<script>
import ProductList from '../components/ProductList.vue';
import ProductDetail from '../components/ProductDetail.vue';
import DefaultPage from '../components/DefaultPage.vue';

export default {
  components: {
    ProductList,
    ProductDetail,
    DefaultPage,
  },
  data() {
    return {
      products: [/*從資料庫農取*/
        {
          id: 1,
          name: '巧克力',
          image: 'https://via.placeholder.com/150',
          price: 50,
          category: '屁眼',
          stock: 10,
          salesVolume: 0,
        },
        {
          id: 2,
          name: '巧克力',
          image: 'https://via.placeholder.com/150',
          price: 50,
          category: '屁眼',
          stock: 10,
          salesVolume: 0,
        },
        {
          id: 3,
          name: '巧克力',
          image: 'https://via.placeholder.com/150',
          price: 50,
          category: '屁眼',
          stock: 10,
          salesVolume: 0,
        },
        {
          id: 4,
          name: '巧克力',
          image: 'https://via.placeholder.com/150',
          price: 50,
          category: '屁眼',
          stock: 10,
          salesVolume: 0,
        },
        {
          id: 5,
          name: '巧克力',
          image: 'https://via.placeholder.com/150',
          price: 50,
          category: '屁眼',
          stock: 10,
          salesVolume: 0,
        },
        {
          id: 6,
          name: '巧克力',
          image: 'https://via.placeholder.com/150',
          price: 50,
          category: '屁眼',
          stock: 10,
          salesVolume: 0,
        },
      ],
      selectedProduct: null,
    };
  },
  methods: {
    viewDetail(product) {
      this.selectedProduct = product;
    },
    closeDetail() {
      this.selectedProduct = null;
    },
    saveData(data){
      const index = this.products.findIndex(product => product.id === data.id);
      if (index !== -1) {
        this.products[index] = JSON.parse(JSON.stringify(data)); 
        this.selectedProduct = { ...data };
        console.log('修改成功：', this.products[index]);
      } else {
        console.log('修改失敗，找不到對應的產品');
      }
      /*寫回資料庫*/ 
    }
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