<h4>Tổng quan bảng điều khiển</h4>
<h5 class="title-s">Tổng quan thống kê</h5>
<div class="grid-statistical">
  <!-- Thống kê hôm nay -->
  <?php
  $today = date('Y-m-d');
  $startOfDay = $today . ' 00:00:00';
  $endOfDay = $today . ' 23:59:59';
  $sql = "SELECT SUM(total_amount) AS totalAmount FROM invoices WHERE invoice_date BETWEEN '$startOfDay' AND '$endOfDay' AND order_status = 'Hoàn tất đơn hàng'";
  $todayResult = selectInvoice($sql);  
  $totalToday = number_format($todayResult['totalAmount'], 0, ',', '.');
  ?>
  <div class="grid-statistical-item">
    <div class="icon"><i class="fa-solid fa-coins"></i></div>
    <h6>Đơn hàng hôm nay</h6>
    <?php
    if ($totalToday > 0) {
      ?>
      <div class="price">
        <?= $totalToday ?><sup>đ</sup>
      </div>
    <?php } else { ?>
      <div class="price">Không có dữ liệu cho hôm nay!</div>
    <?php } ?>
  </div>
  <!-- Thống kê hôm qua -->
  <?php
  $yesterday = date("Y-m-d", strtotime("-1 day"));
  $startYesterday = $yesterday . ' 00:00:00';
  $endYesterday = $yesterday . ' 23:59:59';
  $sql = "SELECT SUM(total_amount) AS totalAmount FROM invoices WHERE invoice_date BETWEEN '$startYesterday' AND '$endYesterday' AND order_status = 'Hoàn tất đơn hàng'";
  $yesterdayResult = selectInvoice($sql);
  $totalYesterday = number_format($yesterdayResult['totalAmount'], 0, ',', '.');
  ?>
  <div class="grid-statistical-item">
    <div class="icon"><i class="fa-solid fa-coins"></i></div>
    <h6>Đơn hàng hôm qua</h6>
    <?php
    if ($totalYesterday > 0) {
      ?>
      <div class="price">
        <?= $totalYesterday ?><sup>đ</sup>
      </div>
    <?php } else { ?>
      <div class="price">Không có dữ liệu cho ngày hôm qua!</div>
    <?php } ?>
  </div>
  <!-- Thống kê tháng này -->
  <?php
  $firstDayOfMonth = date("Y-m-01");
  $lastDayOfMonth = date("Y-m-t");
  $sql = "SELECT SUM(total_amount) AS totalAmount FROM invoices WHERE invoice_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth' AND order_status = 'Hoàn tất đơn hàng'";
  $result = selectInvoice($sql);
  $totalAmount = number_format($result['totalAmount'], 0, ',', '.')
    ?>
  <div class="grid-statistical-item">
    <div class="icon"><i class="fa-solid fa-cart-plus"></i></div>
    <h6>Đơn hàng tháng này</h6>
    <?php if ($totalAmount > 0) { ?>
      <div class="price">
        <?= $totalAmount ?><sup>đ</sup>
      </div>
    <?php } else { ?>
      <div class="price">Không có dữ liệu cho tháng này!</div>
    <?php } ?>
  </div>
  <!-- Thống kê tháng trước -->
  <?php
  $firstDayOfLastMonth = date("Y-m-01", strtotime("last month"));
  $lastDayOfLastMonth = date("Y-m-t", strtotime("last month"));
  $sql = "SELECT SUM(total_amount) AS totalAmount FROM invoices WHERE invoice_date BETWEEN '$firstDayOfLastMonth' AND '$lastDayOfLastMonth' AND order_status = 'Hoàn tất đơn hàng'";
  $result_2 = selectInvoice($sql);
  $totalAmount_2 = number_format($result_2['totalAmount'], 0, ',', '.')
    ?>
  <div class="grid-statistical-item">
    <div class="icon"><i class="fa-solid fa-cart-plus"></i></div>
    <h6>Đơn hàng tháng Trước</h6>
    <?php
    if ($totalAmount_2 > 0) {
      ?>
      <div class="price">
        <?= $totalAmount_2 ?><sup>đ</sup>
      </div>
    <?php } else { ?>
      <div class="price">Không có dữ liệu cho tháng này!</div>
    <?php } ?>
  </div>
  <!-- Tất cả các đơn hàng -->
  <?php
  $sql = "SELECT SUM(total_amount) AS totalAmount FROM invoices WHERE order_status = 'Hoàn tất đơn hàng'";
  $resultTotal = selectInvoice($sql);
  $total = number_format($resultTotal['totalAmount'], 0, ',', '.');
  ?>
  <div class="grid-statistical-item">
    <div class="icon"><i class="fa-solid fa-cubes"></i></i></div>
    <h6>Tất cả các đơn hàng</h6>
    <div class="price">
      <?= $total ?><sup>đ</sup>
    </div>
  </div>
</div>
<div class="statistical-order">
  <div class="statiscal-order-item">
    <div class="icon-order orange"><i class="fa-solid fa-cart-plus"></i></div>
    <div class="quantity-order">
      <span>Tổng đơn hàng</span>
      <?php
      $totalOrder = statisticalOrder();
      ?>
      <strong style="font-size:1.2rem;">
        <?= $totalOrder['total_order'] ?>
      </strong>
    </div>
  </div>
  <div class="statiscal-order-item">
    <div class="icon-order blue"><i class="fa-solid fa-arrows-rotate"></i></div>
    <div class="quantity-order">
      <span>Đơn hàng chờ xác nhận</span>
      <?php
      $orderPending = statisticalOrder_2();
      ?>
      <strong style="font-size:1.2rem;">
        <?= $orderPending['total_order'] ?>
      </strong>
    </div>
  </div>
  <div class="statiscal-order-item">
    <div class="icon-order green"><i class="fa-solid fa-truck"></i></div>
    <div class="quantity-order">
      <span>Đang vận chuyển</span>
      <?php
      $order_transport = statisticalOrder_3();
      ?>
      <strong style="font-size:1.2rem;">
        <?= $order_transport['total_order'] ?>
      </strong>
    </div>
  </div>
  <div class="statiscal-order-item">
    <div class="icon-order green-2"><i class="fa-solid fa-check"></i></div>
    <div class="quantity-order">
      <span>Hoàn tất đơn hàng</span>
      <?php
      $orders_delivered = statisticalOrder_4();
      ?>
      <strong style="font-size:1.2rem;">
        <?= $orders_delivered['total_order'] ?>
      </strong>
    </div>
  </div>
</div>
<div class="statistical-chart">
  <div class="chart-item">
    <h5>Thống kê sản phẩm</h5>
    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
  </div>
  <div class="chart-item">
    <h5>Thống kê lượt xem sản phẩm</h5>
    <div id="myChart-2" style="width:100%; max-width:600px; height:330px;"></div>
  </div>
</div>
<?php
$data = statisticalProduct();
$textData = "";
foreach ($data as $result) {
  $textData .= "{$result['category_name']}:{$result['quantity']},";
}

$sql = "SELECT C.category_name, SUM(view) as totalViews FROM products AS P INNER JOIN categories AS C ON P.category_id = C.category_id GROUP BY P.category_id";
$statistical = selectCategoryAll($sql);
?>
<script>


  const textData = "<?php echo $textData; ?>";
  const dataPairs = textData.split(",");

  // Loại bỏ phần tử rỗng (nếu có)
  const filteredData = dataPairs.filter(pair => pair.trim() !== "");

  const xValues = [];
  const yValues = [];

  filteredData.forEach(pair => {
    const [category, quantity] = pair.split(":");
    xValues.push(category);
    yValues.push(parseInt(quantity));
  });

  new Chart("myChart", {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: "rgb(15, 163, 255)",
        borderColor: "rgba(0,0,255,0.1)",
        borderWidth: 1,
        data: yValues
      }]
    },
    options: {
      legend: { display: false },
      scales: {
        yAxes: [{ ticks: { beginAtZero: true } }]
      }

    }
  });
</script>
<script>
  google.charts.load('current', { 'packages': ['corechart'] });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    <?php
    if ($statistical !== null) {
      echo "var chartData = [['Danh mục', 'Lượt xem']];";
      foreach ($statistical as $row) {
        echo "chartData.push(['" . $row['category_name'] . "', " . $row['totalViews'] . "]);";
      }

      echo "var data = google.visualization.arrayToDataTable(chartData);";
      echo "var options = { title: 'Thống kê lượt xem theo danh mục', is3D: true };";
      echo "var chart = new google.visualization.PieChart(document.getElementById('myChart-2'));";
      echo "chart.draw(data, options);";
    } else {
      echo "document.getElementById('myChart-2').innerHTML = 'Không có dữ liệu để hiển thị.';";
    }
    ?>
  }
</script>