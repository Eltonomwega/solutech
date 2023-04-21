<template>
  <div class="row align-items-center">
    <a
      class="col-9 row"
      data-bs-toggle="collapse"
      :href="`#collapseExample${task.id}`"
      role="button"
      aria-expanded="false"
      :aria-controls="`collapseExample${task.id}`"
    >
      <div class="task-name col-9">
        <h5>{{ task.task }}</h5>
      </div>
      <div class="task-status col-3 d-none d-md-block">
        <div
          class="btn-status d-inline-block px-2 py-1"
          :style="`background-color: ${statusColor(task.status)}`"
        >
          {{ task.status }}
        </div>
      </div>
    </a>
    <div class="action col-3 d-flex d-md-block">
      <RouterLink
        :to="{ name: 'edit-task', params: { id: task.id } }"
        class="btn btn-outline-info m-1"
      >
        <img src="@/assets/img/IconEdit.svg" alt="Edit button" />
      </RouterLink>
      <button class="btn btn-outline-danger m-1" @click="deleteTask(task.id)">
        <img src="@/assets/img/IconDelete.svg" alt="Delete button" />
      </button>
    </div>
    <div class="collapse" :id="`collapseExample${task.id}`">
      <div class="card card-body">
        <div class="description">
          {{ task.description }}
        </div>
        <div class="remark mt-4">
          <em>
            {{ task.remarks }}
          </em>
        </div>
      </div>
    </div>
  </div>
  <slot name="divider"></slot>
</template>
<script>
import { RouterLink } from "vue-router";
import axios from "axios";

export default {
  name: "TaskItem",
  data() {
    return {};
  },
  props: {
    task: {
      type: Object,
      required: true,
    },
    onDeleteTask: {
      type: Function,
      required: true,
    },
  },
  computed: {},
  methods: {
    statusColor(status) {
      if (status === "Completed") return "#42b883";
      else if (status === "Pending") return "#d9e537";
      else return "#379fe5";
    },
    deleteTask(id) {
      if (confirm("Are you sure you want to delete this task?")) {
        const accessToken = `Bearer ${localStorage.getItem("access_token")}`;
        axios
          .delete(`${import.meta.env.VITE_API_URL}/tasks/user/${id}`, {
            headers: {
              Authorization: accessToken,
            },
          })
          .then(() => {
            this.onDeleteTask(id);
            this.$router.push("/");
          });
      }
    },
  },
};
</script>
<style scoped>
.btn-status {
  border-radius: 20px;
  color: white;
  font-size: 15px;
}
h5 {
  font-size: 20px;
}

a {
  text-decoration: none;
  color: black;
}
.description {
  border-left: 2px solid #35495e;
  padding-left: 5px;
}
</style>
