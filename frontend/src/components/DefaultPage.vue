<template>
  <header id="upperDefault">{{ pageTitle }}</header>
  <div id="content"></div>
</template>

<script setup>
  defineProps(['pageTitle']);
</script>
  
<style>
  #upperDefault {
    font-family: cursive;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 120px;
    font-size: 54px;
    color: black;
    padding: 20px;
    text-align: left;
    z-index: 1000;
    box-sizing: border-box;
    display: flex;
    align-items: center; /* 垂直居中 */
    background: linear-gradient(90deg, #00416A, #E4E5E6);
    box-shadow: rgba(0, 0, 0, 0.3) 2px 8px 8px;
    border-bottom: 4px rgba(40, 40, 40, 0.7) solid;

    white-space: nowrap;
    text-overflow: ellipsis;
  }

  #content {
    padding-top: 130px;
    box-sizing: border-box;
  }

  html {
    background-color: rgba(7, 76, 105, 0.4);
  }
</style>