<?php
session_start();
if (!isset($_SESSION['listId'])) {
	$_SESSION['listId'] = array();
}
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	header('location:login.php');
} else {

?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="keywords" content="MediaCenter, Template, eCommerce">
		<meta name="robots" content="all">

		<title>Order History</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/green.css">
		<link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

		<!-- Demo Purpose Only. Should be removed in production -->
		<link rel="stylesheet" href="assets/css/config.css">

		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="assets/images/favicon.ico">
		<script language="javascript" type="text/javascript">
			var popUpWin = 0;

			function popUpWindow(URLStr, left, top, width, height) {
				if (popUpWin) {
					if (!popUpWin.closed) popUpWin.close();
				}
				popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
			}
		</script>

	</head>

	<body class="cnt-home">



		<!-- ============================================== HEADER ============================================== -->
		<header class="header-style-1">
			<?php include('includes/top-header.php'); ?>
			<?php include('includes/main-header.php'); ?>
			<?php include('includes/menu-bar.php'); ?>
		</header>
		<!-- ============================================== HEADER : END ============================================== -->
		<div class="breadcrumb">
			<div class="container">
				<div class="breadcrumb-inner">
					<ul class="list-inline list-unstyled">
						<li><a href="#">Home</a></li>
						<li class='active'>Shopping Cart</li>
					</ul>
				</div><!-- /.breadcrumb-inner -->
			</div><!-- /.container -->
		</div><!-- /.breadcrumb -->

		<div class="body-content outer-top-xs">
			<div class="container">
				<div class="row inner-bottom-sm">
					<div class="shopping-cart">
						<div class="col-md-12 col-sm-12 shopping-cart-table ">
							<div class="table-responsive">
								<form name="cart" method="post">

									<table class="table table-bordered">
										<thead>
											<tr>
												<th class="cart-romove item">#</th>
												<th class="cart-description item">Hình ảnh</th>
												<th class="cart-product-name item">Tên Sản phẩm</th>
												<th class="cart-qty item">Số lượng</th>
												<th class="cart-sub-total item">Giá mỗi sản phẩm</th>
												<th class="cart-sub-total item">Phí vận chuyển</th>
												<th class="cart-total item">Tổng cộng</th>
												<th class="cart-total item">Phương thức thanh toán</th>
												<th class="cart-description item">Ngày đặt hàng</th>
											</tr>
										</thead><!-- /thead -->

										<tbody>

											<?php $query = mysqli_query($con, "select orders.id as orders_id, products.productImage1 as pimg1,products.productName as pname,products.id as proid,orders.productId as opid,orders.quantity as qty,products.productPrice as pprice,products.shippingCharge as shippingcharge,orders.paymentMethod as paym,orders.orderDate as odate,orders.id as orderid from orders join products on orders.productId=products.id where orders.userId='" . $_SESSION['id'] . "' and orders.paymentMethod = 'Internet Banking' and orders.orderStatus IS NULL");
											$cnt = 1;
											$listId = array();
											while ($row = mysqli_fetch_array($query)) {
												$listId[] = $row["orders_id"];
												$qty = $row['qty'];
												$price = $row['pprice'];
												$shippcharge = $row['shippingcharge'];
												$subtotal = ($qty * $price) + $shippcharge; // Tính tổng tiền cho mỗi hàng
												$total += $subtotal; // Cộng vào tổng số tiền

												// Định dạng tiền cho các cột
												$formatted_price = number_format($price, 0, ',', '.');
												$formatted_shipping_charge = number_format($shippcharge, 0, ',', '.');
												$formatted_subtotal = number_format($subtotal, 0, ',', '.');
											?>
												<tr>
													<td><?php echo $cnt; ?></td>
													<td class="cart-image">
														<a class="entry-thumbnail" href="detail.html">
															<img src="admin/productimages/<?php echo $row['proid']; ?>/<?php echo $row['pimg1']; ?>" alt="" width="84" height="146">
														</a>
													</td>
													<td class="cart-product-name-info">
														<h4 class='cart-product-description'><a href="product-details.php?pid=<?php echo $row['opid']; ?>">
																<?php echo $row['pname']; ?></a></h4>


													</td>
													<td class="cart-product-quantity">
														<?php echo $qty = $row['qty']; ?>
													</td>
													<td class='cart-product-sub-total'><?php echo $formatted_price ?></td>
													<td class='cart-product-sub-total'><?php echo $formatted_shipping_charge ?>
													</td>
													<td class='cart-product-grand-total'><?php echo $formatted_subtotal ?></td>
													<td class="cart-product-sub-total"><?php echo $row['paym']; ?> </td>
													<td class="cart-product-sub-total"><?php echo $row['odate']; ?> </td>
												</tr>
											<?php $cnt = $cnt + 1;
											}
											$_SESSION['listId'] = $listId; ?>

										</tbody><!-- /tbody -->
									</table><!-- /table -->
								</form>
							</div>
							<div style='text-align:right;margin-top:20px'>
								<form role="form" method="post" action="vnpay.php">
									<input type="hidden" name="money" value="<?php echo $total ?>" />
									<button type=" submit" name="submit" name="redirect" class="btn-upper btn btn-primary checkout-page-button">Thanh toán VnPay</button>
								</form>
							</div>
						</div>

					</div><!-- /.shopping-cart -->
				</div> <!-- /.row -->
				</form>
				<!-- ============================================== BRANDS CAROUSEL ============================================== -->
				<?php echo include('includes/brands-slider.php'); ?>
				<!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
			</div><!-- /.container -->
		</div><!-- /.body-content -->
		<?php include('includes/footer.php'); ?>

		<script src="assets/js/jquery-1.11.1.min.js"></script>

		<script src="assets/js/bootstrap.min.js"></script>

		<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
		<script src="assets/js/owl.carousel.min.js"></script>

		<script src="assets/js/echo.min.js"></script>
		<script src="assets/js/jquery.easing-1.3.min.js"></script>
		<script src="assets/js/bootstrap-slider.min.js"></script>
		<script src="assets/js/jquery.rateit.min.js"></script>
		<script type="text/javascript" src="assets/js/lightbox.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		<script src="assets/js/wow.min.js"></script>
		<script src="assets/js/scripts.js"></script>

		<!-- For demo purposes – can be removed on production -->

		<script src="switchstylesheet/switchstylesheet.js"></script>

		<script>
			$(document).ready(function() {
				$(".changecolor").switchstylesheet({
					seperator: "color"
				});
				$('.show-theme-options').click(function() {
					$(this).parent().toggleClass('open');
					return false;
				});
			});

			$(window).bind("load", function() {
				$('.show-theme-options').delay(2000).trigger('click');
			});
		</script>
		<!-- For demo purposes – can be removed on production : End -->
	</body>

	</html>
<?php } ?>