<script setup>
import langit from "@images/pages/2.png";
import cardEdukasi from "./card-edukasi.vue";
</script>

<template>
  <div class="container">
    <img
      class="mt-5"
      style="width: 100%; height: 400px; object-fit: cover"
      :src="langit"
      alt=""
    />
    <Strong style="font-size: 40px">JUDUL</Strong>
    <p><sup>Tanggal</sup></p>
    <p>
      PARAGRAF Lorem, ipsum dolor sit amet consectetur adipisicing elit.
      Necessitatibus est incidunt soluta id ullam dolorem similique, qui sunt
      explicabo a voluptas eum facilis veritatis consequatur iusto saepe hic
      accusamus earum. Laborum reiciendis quae vero tenetur libero voluptas
      velit earum hic. Dolorum aliquid quia laboriosam quidem consequuntur
      possimus odio ipsam sint?
    </p>
    <br />
    <RouterLink to="./">
      <div>
        <v-icon>bx-chevron-left</v-icon>
        Halaman Depan
      </div>
    </RouterLink>
  </div>

  <cardEdukasi />
</template>

<style scope>
.container {
  padding: 0 10px;
  margin: 30px;
}
</style>
