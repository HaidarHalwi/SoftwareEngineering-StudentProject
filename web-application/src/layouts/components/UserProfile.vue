<script setup>
import avatar1 from "@images/avatars/avatar-1.png";
import axios from "axios";
import config from "@/@core/config.vue";

const fotoProfile = localStorage.getItem("foto_profile");
const logout = async () => {
  const response = await axios.post(
    `${config.urlServer}/api/logout`,
    {},
    {
      headers: {
        Authorization: "Bearer " + localStorage.getItem("tokenAuth"),
      },
    }
  );
  localStorage.clear();
  window.location.href = "/login";
};
</script>

<template>
  <VForm @submit="login">
    <VBadge
      dot
      location="bottom right"
      offset-x="3"
      offset-y="3"
      color="success"
      bordered
    >
      <VAvatar class="cursor-pointer" color="primary" variant="tonal">
        <VImg :src="fotoProfile" />

        <!-- SECTION Menu -->
        <VMenu
          activator="parent"
          width="230"
          location="bottom end"
          offset="14px"
        >
          <VList>
            <!-- 👉 User Avatar & Name -->
            <VListItem>
              <template #prepend>
                <VListItemAction start>
                  <VBadge
                    dot
                    location="bottom right"
                    offset-x="3"
                    offset-y="3"
                    color="success"
                  >
                    <VAvatar color="primary" variant="tonal">
                      <VImg :src="fotoProfile" />
                    </VAvatar>
                  </VBadge>
                </VListItemAction>
              </template>

              <VListItemTitle class="font-weight-semibold">
                John Doe
              </VListItemTitle>
              <VListItemSubtitle>Admin</VListItemSubtitle>
            </VListItem>
            <VDivider class="my-2" />

            <!-- 👉 Profile -->
            <VListItem link to="/account-settings">
              <template #prepend>
                <VIcon class="me-2" icon="bx-user" size="22" />
              </template>

              <VListItemTitle>Profile</VListItemTitle>
            </VListItem>

            <!-- 👉 Logout -->
            <VListItem @click="logout">
              <template #prepend>
                <VIcon class="me-2" icon="bx-log-out" size="22" />
              </template>

              <VListItemTitle>Logout</VListItemTitle>
            </VListItem>
          </VList>
        </VMenu>
        <!-- !SECTION -->
      </VAvatar>
    </VBadge>
  </VForm>
</template>
