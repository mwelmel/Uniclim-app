// Revenue Chart (Bar)
const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctxRevenue, {
  type: 'bar',
  data: {
    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
    datasets: [{
      label: 'Revenue (Rp)',
      data: [30000000, 35000000, 28000000, 40000000],
      backgroundColor: '#198754' // Bootstrap green
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: { callbacks: {
        label: context => `Rp ${context.formattedValue}`
      }}
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: value => `Rp ${value / 1000000} jt`
        }
      }
    }
  }
});

// Sales Chart (Pie)
const ctxSales = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctxSales, {
  type: 'doughnut',
  data: {
    labels: ['Fauget Cafe', 'Claudia Store', 'Chidi Barber', 'Yael Amari'],
    datasets: [{
      data: [120, 150, 100, 200],
      backgroundColor: ['#0d6efd', '#ffc107', '#dc3545', '#198754'],
      hoverOffset: 10
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: 'bottom' }
    }
  }
  
});
