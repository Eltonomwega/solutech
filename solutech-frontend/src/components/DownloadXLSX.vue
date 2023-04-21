<template>
  <button class="btn btn-outline-success download-btn" @click="downloadXLSX">
    <img src="@/assets/img/IconDownload.svg" alt="Download Tasks" />
  </button>
</template>
<script>
import * as XLSX from "xlsx";

export default {
  name: "DownloadXLSX",
  props: {
    tasks: {
      type: Object,
      required: true,
    },
  },
  methods: {
    downloadXLSX() {
      const worksheet = XLSX.utils.json_to_sheet(this.tasks);
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, "Tasks");
      XLSX.writeFile(workbook, "tasks.xlsx");
    },
  },
};
</script>
<style scoped></style>
