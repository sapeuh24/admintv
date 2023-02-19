var dataClientes = [];
var dataVentas = [];
var meses = [];

const formatter = new Intl.NumberFormat("es-CO", {
  style: "currency",
  currency: "COP"
});

$.ajax({
  url: route_clientes,
  type: 'GET',
  dataType: 'json',
  success: function (data) {
    var dataClientes = {
      labels: data.meses,
      datasets: [
        {
          label: 'Clientes nuevos',
          data: data.clientes,
          backgroundColor: [
            'rgba(0, 187, 221, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
          ],
          borderColor: [
            'rgba(0, 187, 221, 1)',
          ],
          borderWidth: 1,
          yAxisID: "Clientes",
        },
      ],
    };

    var optionsClientes = {
      scales: {
        yAxes: [
          {
            id: "Clientes"
          },
        ]
      },
      legend: {
        display: true
      },
      elements: {
        point: {
          radius: 0
        }
      },
    };
    if ($("#barChartClientes").length) {
      var barChartClientes = $("#barChartClientes").get(0).getContext("2d");
      var barChartClientes = new Chart(barChartClientes, {
        type: 'bar',
        data: dataClientes,
        options: optionsClientes
      });
    }
  },
  error: function (data) {
    console.log(data);
  }
});

////////////////////////////////////////////////////////////////////////////////////////////

$.ajax({
  url: route_ventas,
  type: 'GET',
  dataType: 'json',
  success: function (data) {
    var dataVentas = {
      labels: data.meses,
      datasets: [
        {
          label: 'Ventas',
          data: data.ventas,
          backgroundColor: [
            'rgba(0, 187, 221, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
          ],
          borderColor: [
            'rgba(0, 187, 221, 1)',
          ],
          borderWidth: 1,
          yAxisID: "Ventas",
        },
      ],
    };

    var optionsVentas = {
      scales: {
        yAxes: [
          {
            id: "Ventas"
          },
        ]
      },
      legend: {
        display: true
      },
      elements: {
        point: {
          radius: 0
        }
      },
    };
    if ($("#barChartVentas").length) {
      var barChartVentas = $("#barChartVentas").get(0).getContext("2d");
      var barChartVentas = new Chart(barChartVentas, {
        type: 'bar',
        data: dataVentas,
        options: optionsVentas
      });
    }
  },
  error: function (data) {
    console.log(data);
  }
});