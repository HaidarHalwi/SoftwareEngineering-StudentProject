<style>
#gambar:hover {
  filter: brightness(0.7);
}
</style>

<template>
  <div class="text-center" style="margin-top: 200px">
    <h1 class="text-black">GALERI</h1>
  </div>

  <VRow>
    <VCol>
      <div class="d-flex flex-wrap gap-2 float-right">
        <input
          id="inputGambar"
          ref="refInputEl"
          type="file"
          name="file"
          accept=".jpeg,.png,.jpg"
          hidden
          @change="changeAvatar"
        />
      </div>
    </VCol>
  </VRow>

  <VRow no-gutters>
    <VCol cols="12" md="3" sm="6" v-for="data in dataGambar">
      <VImg
        id="gambar"
        style="width: 100%; height: 200px"
        cover
        :src="data.gambar"
        alt="image"
        @click="lihatGambar(data.gambar, data.nama_lengkap, data.id_gambar)"
      />
      <!-- <h1>{{ data.id_gambar }}</h1> -->
    </VCol>
  </VRow>
  <VRow>
    <VCol>
      <div class="text-center my-3 float-right">
        <v-pagination
          v-model="page"
          :length="banyakPage"
          :total-visible="5"
          @click="fetchData"
        ></v-pagination>
      </div>
    </VCol>
  </VRow>
</template>

<script>
//import EditEdukasi from "./EditEdukasi.vue";
import wallet from "@/assets/images/pages/1.png";
import axios from "axios";
import config from "@/@core/config.vue";
import { ref } from "vue";
import Swal from "sweetalert2";

export default {
  data() {
    return {
      dialog: ref([]),
      dataGambar: ref([]),
      urlServer: config.urlServer,
      refInputEl: ref(),
      page: 1,
      banyakPage: 0,
      wallet,
    };
  },

  methods: {
    inputGambar() {
      document.getElementById("inputGambar").click();
    },

    async fetchData() {
      const banyakDataTampil = 12;
      const response = await axios.get(
        `${this.urlServer}/api/gambar?start=${this.page}&length=${banyakDataTampil}`
      );
      this.dataGambar = response.data.gambar.map((item) => {
        item.gambar = ref(this.urlServer + item.gambar);
        item.refInput = ref();
        item.nama_lengkap = ref(item.nama_lengkap);
        return item;
      });
      this.banyakPage = Math.ceil(response.data.jumlah_data / banyakDataTampil);
    },

    async lihatGambar(gambar, judul, id_gambar) {
      const ask = await Swal.fire({
        imageUrl: gambar,
        // html: judul,
        imageAlt: "Ini gambar",
        // showConfirmButton: false,
        // showDenyButton: true,
        // showCancelButton: true,
        // denyButtonText: "Hapus",
      });
      if (ask.isDenied) {
        const response = await axios.delete(
          `${this.urlServer}/api/gambar?id_gambar=${id_gambar}`,
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          }
        );
        if (response.data.success) {
          Swal.fire({
            toast: true,
            position: "top",
            iconColor: "white",
            color: "white",
            background: "rgb(var(--v-theme-success))",
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 1500,
            icon: "success",
            title: response.data.success.message,
          });
          this.fetchData();
        }
      }
    },
  },

  mounted() {
    this.fetchData();
  },
};
</script>
