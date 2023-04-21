<template>
  <div>
    <canvas ref="pieChart"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js/auto";

export default {
  name: "TaskPieChart",
  props: {
    tasks: {
      type: Array,
      required: true,
    },
  },
  mounted() {
    const pendingTasks = this.tasks.filter((task) => task.status === "Pending");
    const completeTasks = this.tasks.filter(
      (task) => task.status === "Complete"
    );
    const activeTasks = this.tasks.filter((task) => task.status === "Active");
    const pieChart = new Chart(this.$refs.pieChart, {
      type: "pie",
      data: {
        labels: ["Pending", "Complete", "Active"],
        datasets: [
          {
            label: "Tasks",
            data: [
              pendingTasks.length,
              completeTasks.length,
              activeTasks.length,
            ],
            backgroundColor: ["#FFCE56", "#42b883", "#379fe5"],
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
    });
  },
};
</script>

<style scoped>
canvas {
  max-width: 600px;
  max-height: 400px;
}
</style>
