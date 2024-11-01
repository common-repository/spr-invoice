<!doctype html>
<html dir="ltr" lang="en" class="no-js">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width" />

	<title><?php echo $options['company']; ?> Invoice</title>

	<link rel="stylesheet" href="<?php echo plugin_dir_url( 'sprinvoice'); ?>spr-invoice/reset.css" media="all" />
	<link rel="stylesheet" href="<?php echo plugin_dir_url( 'sprinvoice'); ?>spr-invoice/style.css" media="all" />
	<link rel="stylesheet" href="<?php echo plugin_dir_url( 'sprinvoice'); ?>spr-invoice/print.css" media="print" />

	<!-- give life to HTML5 objects in IE -->
	<!--[if lte IE 8]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

	<!-- js HTML class -->
	<script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
</head>
<body>
<!-- begin markup -->

<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>

<div id="invoice" <?php $tk = 'spr_meta_invoice_status';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?> class="is-<?php echo $tkv; ?>"<?php }; ?>>

	<div class="this-is">
		<strong>Invoice</strong>
	</div><!-- invoice headline -->
<?php $options = get_option('spr_options'); ?>
	
	<header id="header">
		<div class="invoice-intro">
			<h1><?php echo $options['company']; ?></h1>
			<p><?php echo $options['tag']; ?></p>
		</div>

		<dl class="invoice-meta">
			<?php $tk = 'spr_meta_invoice_num';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?>
			<dt class="invoice-number">Invoice #</dt>
			<dd><?php echo $tkv; ?></dd>
			<?php }; ?>

			<?php $tk = 'spr_meta_invoice_date';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?>
			<dt class="invoice-date">Date of Invoice</dt>
			<dd><?php echo $tkv; ?></dd>
			<?php }; ?>

			<?php $tk = 'spr_meta_invoice_due';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?>			
			<dt class="invoice-due">Due Date</dt>
			<dd><?php echo $tkv; ?></dd>
			<?php }; ?>
		</dl>
	</header>
	<!-- e: invoice header -->


	<section id="parties">

		<div class="invoice-to">
			<h2>Invoice To:</h2>
			<div class="vcard">
				<?php $tk = 'spr_meta_name';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?>
				<span class="fn"><?php echo $tkv; ?></span>
				<?php }; ?>

				<?php $tk = 'spr_meta_company';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?>
				<div class="org"><?php echo $tkv; ?></div>
				<?php }; ?>

				<?php $tk = 'spr_meta_email';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?>
				<a class="email" href="mailto:<?php echo $tkv; ?>"><?php echo $tkv; ?></a>
				<?php }; ?>
				
				<div class="adr">
					<?php $tk = 'spr_meta_address_1';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?>
					<div class="street-address"><?php echo $tkv; ?></div>
					<?php }; ?>

					<?php $tk = 'spr_meta_address_2';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?>
					<div class="street-address"><?php echo $tkv; ?></div>
					<?php }; ?>
				</div>

				<?php $tk = 'spr_meta_phone';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?>
				<div class="tel"><?php echo $tkv; ?></div>
				<?php }; ?>
			</div><!-- e: vcard -->
		</div><!-- e invoice-to -->


		<div class="invoice-from">
			<h2>Invoice From:</h2>
			<div class="vcard">
				<a class="url fn" href="<?php echo $options['url']; ?>"><?php echo $options['contact']; ?></a>
				<div class="org"><?php echo $options['company']; ?></div>
				<a class="email" href="mailto:<?php echo $options['email']; ?>"><?php echo $options['email']; ?></a>
				
				<div class="adr">
					<?php if($options['address1']){; ?>
					<div class="street-address"><?php echo $options['address1']; ?></div>
					<?php }; ?>

					<?php if($options['address2']){; ?>
					<div class="street-address"><?php echo $options['address2']; ?></div>
					<?php }; ?>
				</div>
				<?php if($options['phone']){; ?>
				<div class="tel"><?php echo $options['phone']; ?></div>
				<?php }; ?>
			</div><!-- e: vcard -->
		</div><!-- e invoice-from -->


		<div class="invoice-status">
			<h3>Invoice Status</h3>
			<?php $tk = 'spr_meta_invoice_status';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?>	
			<strong>Invoice is <em><?php echo $tkv; ?></em></strong>
			<?php }; ?>
		</div><!-- e: invoice-status -->

	</section><!-- e: invoice partis -->


	<section class="invoice-financials">

		<div class="invoice-items">
			<table>
				<caption>Your Invoice</caption>
				<thead>
					<tr>
						<th>Item &amp; Description</th>
						<th>Quantity</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<?php $invoiceRows = get_post_meta($post->ID, 'invoice_rows', true );?>

					<?php $rowCount = count($invoiceRows); 
					$dollarAmount = (float)0;
				    for ( $i = 0; $i < $rowCount; $i++ ) { ?>
				    	<?php $dollarAmount = $dollarAmount + (float)$invoiceRows[$i+1]['rowItemCosts']; ?>
				        <tr>
							<th><?php echo $invoiceRows[$i+1]['rowItemNames']; ?></th>
							<td><?php echo $invoiceRows[$i+1]['rowItemCounts']; ?></td>
							<td>$<?php echo number_format($invoiceRows[$i+1]['rowItemCosts']); ?></td>
						</tr>
				    <?php }; ?>
					

				</tbody>
				<tfoot>
					<tr>
						<td colspan="3">Amounts in <?php $tk = 'spr_meta_invoice_currency';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){ echo $tkv; } else{echo 'USD';};?></td>
					</tr>
				</tfoot>
			</table>
		</div><!-- e: invoice items -->


		<div class="invoice-totals">
			<table>
				<caption>Totals:</caption>
				<tbody>
					<tr>
						<th>Subtotal:</th>
						<td></td>
						<td>$<?php echo number_format($dollarAmount); ?></td>
					</tr>
					<?php if($options['tax']){; ?>
					<tr>
						<th>Tax:</th>
						<td><?php echo $options['tax']; ?>%</td>
						<td>$<?php $tt = $dollarAmount * $options['tax'] / 100; echo sprintf("%0.2f",$tt)?></td>
					</tr>
					<?php }; ?>
					<tr>
						<th>Total:</th>
						<td></td>
						<?php if($options['tax']){?>
						<td>$<?php echo sprintf("%0.2f",$dollarAmount +$tt)?></td>
						<?php } else { ?>
						<td>$<?php echo $dollarAmount?></td>
						<?php }; ?>
					</tr>
				</tbody>
			</table>

		</div><!-- e: invoice totals -->


		<div class="invoice-notes">
			<h6>Notes &amp; Information:</h6>
			<?php $tk = 'spr_meta_notes';  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){?>
			<p><?php echo $tkv; ?></p>
			<?php } else { ?>
			<p>n/a</p>
			<?php }; ?>
		</div><!-- e: invoice-notes -->

	</section><!-- e: invoice financials -->


	<footer id="footer">
		<p>
			<?php echo $options['tag']; ?>
		</p>
	</footer>


</div><!-- e: invoice -->

<?php endwhile; else : ?>

<h1>No invoice?! yikes.</h1>

<?php endif; ?>


</body>
</html>