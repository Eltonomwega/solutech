<template>
  <div class="container">
    <div class="title mb-5 d-flex justify-content-between">
      <h1>Tasks</h1>
      <div>
        <RouterLink to="/task" class="btn btn-outline-dark">
          <img src="@/assets/img/IconPlus.svg" alt="Add a Task" />
        </RouterLink>
      </div>
    </div>
    <div class="tasks">
      <TaskItem
        v-for="(task, index) in tasks"
        :key="index"
        :task="task"
        :onDeleteTask="handleDeleteTask"
      >
        <template v-slot:divider v-if="index != tasks.length - 1">
          <div class="divider"></div>
        </template>
      </TaskItem>
    </div>
  </div>
</template>

<script>
import TaskItem from "./TaskItem.vue";
import axios from "axios";

export default {
  name: "TaskList",
  components: {
    TaskItem,
  },
  data() {
    return {
      tasks: [],
    };
  },
  mounted() {
    const userId = localStorage.getItem("id");
    const accessToken = `Bearer ${localStorage.getItem("access_token")}`;
    if (userId) {
      axios
        .get(`${import.meta.env.VITE_API_URL}/tasks/user/${userId}`, {
          headers: {
            Authorization: accessToken,
          },
        })
        .then((response) => {
          this.tasks = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    } else {
      // handle case where user id is missing in local storage
    }
  },
  methods: {
    handleDeleteTask(id) {
      const index = this.tasks.findIndex((task) => task.id === id);
      // If the object is found, delete it
      if (index !== -1) {
        this.tasks.splice(index, 1);
      }
    },
  },
};
</script>

<style>
.divider {
  margin: 20px 0;
  border-bottom: 1px solid #35495e;
}
</style>
