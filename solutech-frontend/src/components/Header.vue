<script></script>

<template>
  <div class="container d-flex justify-content-around align-items-center">
    <h1>Hello there!</h1>
    <img
      class="flower-img"
      src="@/assets/img/IconFlower.svg"
      alt="Flowers SVG"
    />
  </div>
</template>

<style scoped>
.container {
  background-color: #3f3d56;
  color: white;
  border: none;
  border-radius: 0px;
  padding-left: 10px;
  padding-right: 10px;
}
.flower-img {
  max-height: 300px;
  width: auto;
}

@media (min-width: 768px) {
  .container {
    border-radius: 5px;
  }
}
</style>
