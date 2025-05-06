// Revenue Chart
const revenueChart = new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
      labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
      datasets: [{
        label: 'Revenue',
        data: [200, 250, 400, 300],
        borderColor: '#198754',
        backgroundColor: 'rgba(25, 135, 84, 0.2)',
        tension: 0.3,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      }
    }
  });
  
  // Sales Chart
  const salesChart = new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
      labels: ['Item 1', 'Item 2', 'Item 3', 'Item 4'],
      datasets: [
        {
          label: 'Best Sales',
          data: [5, 10, 20, 25],
          borderColor: '#0d6efd',
          tension: 0.3
        },
        {
          label: 'Best Product',
          data: [3, 8, 17, 23],
          borderColor: '#198754',
          tension: 0.3
        }
      ]
    },
    options: {
      responsive: true
    }
  });
  