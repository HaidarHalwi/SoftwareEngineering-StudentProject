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
      isLoading: false,
      isLoadingPage: false,
      isDelete: false,
    };
  },

  methods: {
    inputGambar() {
      document.getElementById("inputGambar").click();
    },

    async fetchData() {
      this.isLoadingPage = true;
      const banyakDataTampil = 12;
      const response = await axios.get(
        `${this.urlServer}/api/gambar?start=${this.page}&length=${banyakDataTampil}`
      );
      this.dataGambar = response.data.gambar.map((item) => {
        item.gambar = ref(config.imagePath + item.gambar);
        item.refInput = ref();
        item.nama_lengkap = ref(item.nama_lengkap);
        return item;
      });
      this.banyakPage = Math.ceil(response.data.jumlah_data / banyakDataTampil);
      this.isLoadingPage = false;
    },

    async lihatGambar(gambar, judul, id_gambar) {
      const ask = await Swal.fire({
        imageUrl: gambar,
        html: judul,
        imageAlt: "Ini gambar",
        showConfirmButton: false,
        showDenyButton: true,
        showCancelButton: true,
        denyButtonText: "Hapus",
      });
      if (ask.isDenied) {
        this.isDelete = true;
        const response = await axios.delete(
          `${this.urlServer}/api/gambar?id_gambar=${id_gambar}`,
          {
            headers: {
              Authorization: localStorage.getItem("tokenAuth"),
            },
          }
        );
        this.isDelete = false;
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

    async changeAvatar(file) {
      this.isLoading = true;

      const files = file.target.files[0];
      if (files) {
        const fileReader = new FileReader();
        // Validasi tipe file sebelum menampilkan gambarnya
        if (
          files.type === "image/jpeg" ||
          files.type === "image/png" ||
          files.type === "image/jpg"
        ) {
          fileReader.readAsDataURL(files);
          fileReader.onload = async () => {
            if (typeof fileReader.result === "string") {
              const response = await axios.post(
                `${this.urlServer}/api/gambar`,
                {
                  id_admin: localStorage.getItem("id_admin"),
                  gambar: fileReader.result,
                },
                {
                  headers: {
                    Authorization: localStorage.getItem("tokenAuth"),
                  },
                }
              );
              this.isLoading = false;
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
          };
        } else {
          // Tindakan jika tipe file tidak valid
          alert("File harus berupa gambar dengan tipe jpeg, png, atau jpg.");
          resetAvatar();
        }
      }
    },
  },

  mounted() {
    this.fetchData();
  },
};
</script>

<template>
  <VRow
    v-if="isDelete"
    style="
      position: fixed;
      z-index: 1;
      right: 50px;
      bottom: 50px;
      background-color: azure;
      padding: 1rem;
      padding-block: 5px;
      border-radius: 5px;
    "
  >
    <font>Menghapus... </font>
    <VProgressCircular indeterminate color="primary" class="ml-3 float-center">
    </VProgressCircular>
  </VRow>
  <VRow
    v-if="isLoading"
    style="
      position: fixed;
      z-index: 1;
      right: 50px;
      bottom: 50px;
      background-color: azure;
      padding: 1rem;
      padding-block: 5px;
      border-radius: 5px;
    "
  >
    <font>Mengunggah... </font>
    <VProgressCircular indeterminate color="primary" class="ml-3 float-center">
    </VProgressCircular>
  </VRow>
  <VRow>
    <VCol>
      <div class="d-flex flex-wrap gap-2 float-right">
        <VBtn
          id="gambar"
          color="primary"
          prepend-icon="bx-cloud-upload"
          @click="inputGambar"
        >
          <span class="d-none d-sm-block">Tambah Gambar</span>
        </VBtn>

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
  <VRow>
    <VCol cols="12" md="12" sm="12" v-if="isLoadingPage" class="text-center">
      <VProgressCircular
        indeterminate
        color="primary"
        class="mt-5"
        size="50"
      ></VProgressCircular>
    </VCol>
    <VCol v-else cols="6" md="3" sm="6" v-for="data in dataGambar">
      <VImg
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
