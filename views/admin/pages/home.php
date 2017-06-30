<section class="content-header">
  <h1>Trang quản lý</h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Người dùng</span>
          <span class="info-box-number"><?= number_format($users_count, 0, ",", ".") ?></span>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-coffee"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Sản phẩm</span>
          <span class="info-box-number"><?= number_format($products_count, 0, ",", ".") ?></span>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-shopping-bag"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Đơn hàng</span>
          <span class="info-box-number"><?= number_format($orders_count, 0, ",", ".") ?></span>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-orange"><i class="fa fa-dollar"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Doanh thu</span>
          <span class="info-box-number"><?= number_format($total_amount, 0, ",", ".") ?> VND</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box chart">
        <div class="box-header with-border">
          <h3 class="box-title">Thống kê</h3>

          <div class="pull-right">
            <input type="month" id="filter_month" class="form-control" value="<?= date('Y-m') ?>">
          </div>
        </div>
        <div class="box-body">
          <div id="chart"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(function () {
    function renderChart(chart_data) {
      Highcharts.chart('chart', {
        title: {
          text: 'Số hoá đơn và doanh thu theo ngày'
        },
        xAxis: [{
          categories: chart_data.xAxis,
          crosshair: true,
          title: {
            text: 'Ngày'
          }
        }],
        yAxis: [{
          labels: {
            format: '{value}',
            style: {
              color: Highcharts.getOptions().colors[1]
            }
          },
          title: {
            text: 'Số hoá đơn',
            style: {
              color: Highcharts.getOptions().colors[1]
            }
          }
        }, {
          title: {
            text: 'Doanh thu',
            style: {
              color: Highcharts.getOptions().colors[0]
            }
          },
          labels: {
            formatter: function () {
              return $.number(this.value, 0, ',', '.') + ' VND';
            },
            style: {
              color: Highcharts.getOptions().colors[0]
            }
          },
          opposite: true
        }],
        tooltip: {
          shared: true,
          formatter: function () {
            var rV = 'Ngày ' + this.x + '<br/>';
            this.points.forEach(function (d, i) {
              rV += '<span style="color:' + d.color + '">\u25CF</span> ' + d.series.name + ': <b> ';
              if (i === 1) {
                rV += $.number(d.y, 0, ',', '.') + ' VND';
              } else {
                rV += d.y;
              }
              rV += '</b><br/>';
            });
            return rV;
          }
        },
        series: [{
          name: 'Số hoá đơn',
          type: 'column',
          data: chart_data.series.num_of_orders
        }, {
          name: 'Doanh thu',
          type: 'line',
          yAxis: 1,
          data: chart_data.series.total_amount
        }]
      });
    }

    renderChart(<?= json_encode($num_of_orders) ?>);

    $('#filter_month').change(function () {
      var month = $(this).val();
      $.ajax({
        url: '<?= get_route('statistics', 'getStatistic', 'admin') ?>',
        type: 'POST',
        data: {
          month: month
        },
        dataType: 'JSON',
        success: function (result) {
          renderChart(result);
        }
      })
    });
  });
</script>
