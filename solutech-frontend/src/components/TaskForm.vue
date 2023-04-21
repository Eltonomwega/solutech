<template>
  <div class="form-wrapper d-flex justify-content-center">
    <form class="row g-3 container mx-5 p-5" @submit.prevent="addTask">
      <div class="col-12">
        <label for="task" class="form-label">Task</label>
        <input
          type="text"
          class="form-control"
          id="task"
          v-model="task.task"
          required
        />
      </div>
      <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea
          class="form-control"
          id="description"
          v-model="task.description"
        ></textarea>
      </div>
      <div class="col-12">
        <label for="due_date" class="form-label">Due Date</label>
        <input
          type="datetime-local"
          class="form-control"
          name="due_date"
          id="due_date"
          v-model="task.due_date"
        />
      </div>
      <div class="col-12">
        <label for="start_date" class="form-label">Start Date</label>
        <input
          type="datetime-local"
          class="form-control"
          name="start_date"
          id="start_date"
          v-model="task.start_date"
        />
      </div>
      <div class="col-12">
        <label for="end_date" class="form-label">End Date</label>
        <input
          type="datetime-local"
          class="form-control"
          name="end_date"
          id="end_date"
          v-model="task.end_date"
        />
      </div>
      <div class="col-12">
        <label for="status_id" class="form-label">Status</label>
        <select
          class="form-select"
          name="status_id"
          id="status_id"
          v-model="task.status_id"
        >
          <option value="">-- Select a status --</option>
          <option
            v-for="status in statuses"
            :key="status.id"
            :value="status.id"
          >
            {{ status.name }}
          </option>
        </select>
      </div>
      <div class="col-12">
        <label for="remarks" class="form-label">Remarks</label>
        <input
          type="text"
          class="form-control"
          name="remarks"
          id="remarks"
          v-model="task.remarks"
        />
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          {{ action }}
        </button>
      </div>
    </form>
  </div>
</template>
<script>
import axios from "axios";
import router from "@/router";

export default {
  name: "TaskForm",
  data() {
    return {
      action: "",
      task: {},
      statuses: [],
    };
  },
  mounted() {
    this.action = this.$route.params.id ? "Edit" : "Add";

    const accessToken = `Bearer ${localStorage.getItem("access_token")}`;
    // get all statuses
    axios
      .get(`${import.meta.env.VITE_API_URL}/status/`, {
        headers: {
          Authorization: accessToken,
        },
      })
      .then((response) => {
        this.statuses = response.data.data;
        console.log(response.data.data);
      });
    if (this.action === "Edit") {
      const id = this.$route.params.id;
      if (id) {
        axios
          .get(`${import.meta.env.VITE_API_URL}/tasks/user/task/${id}`, {
            headers: {
              Authorization: accessToken,
            },
          })
          .then((response) => {
            this.task = response.data.data;
          })
          .catch((error) => {
            console.log(error);
          });
      }
    }
  },
  methods: {
    addTask() {
      const accessToken = `Bearer ${localStorage.getItem("access_token")}`;
      const user_id = parseInt(localStorage.getItem("id"));
      let baseUrl = import.meta.env.VITE_API_URL;
      let endpoint =
        this.action === "Add"
          ? `${baseUrl}/tasks/user`
          : `${baseUrl}/tasks/user/${this.$route.params.id}`;
      const method = this.action === "Add" ? "post" : "patch";
      axios[method](
        `${baseUrl}/tasks/${method === "patch" ? this.task.task_id : ""}`,
        {
          name: this.task.task,
          description: this.task.description,
          status_id: this.task.status_id,
        },
        {
          headers: {
            Authorization: accessToken,
          },
        }
      )
        .then((response) => {
          axios[method](
            endpoint,
            { ...this.task, user_id: user_id, task_id: response.data.data.id },
            {
              headers: {
                Authorization: accessToken,
              },
            }
          ).then((response) => {
            router.push("/home");
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
<style scoped>
.container {
  max-width: 600px;
  padding: 10px;
}
</style>
