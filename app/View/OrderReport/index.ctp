<div class="portlet box yellow">
	<div class="portlet-title">
		<div class="caption">
			<?php echo __($title)?>
		</div>
	</div>
	<div class="portlet-body">
	<!-- start of individual-order-report -->
	<div class="individual-order-report">
		<?php
			echo $this->Form->create('OrderDetails');
			echo $this->Form->input('order_id', array('label' => 'Select Order', 'type' => 'select', 'class' => 'form-control', 'options' => $order_options));
			echo $this->Form->submit('View Order Ingredients', array('class' => 'btn btn-primary'));
			echo $this->Form->end();

			$order_full_details = $order_list_with_details[$this->request->data['OrderDetails']['order_id']];
		?>

		<table border='1'>
			<thead>
				<tr>
					<th colspan="2"><?php echo $order_full_details['name']; ?></th>
				</tr>
				<tr>
					<th style="width:250px;text-align:left;padding-left:5px">Dish</th>
					<th style="width:100px;text-align:left;padding-left:5px">Quantity</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($order_full_details['items'] as $item): ?>
					<tr>
						<td style="width:250px;text-align:left;padding-left:5px">
							<?php echo $item['name']; ?>
						</td>
						<td style="width:100px;text-align:left;padding-left:5px">
							<?php echo $item['quantity']; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<br/>
		<?php foreach($order_full_details['items'] as $item): ?>
		<table border='1'>
			<thead>
				<tr>
					<th colspan="2">Ingredient of <?php echo $item['name']; ?></th>
				</tr>
				<tr>
					<th style="width:250px;text-align:left;padding-left:5px">Name</th>
					<th style="width:100px;text-align:left;padding-left:5px">Value</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach($item_list_with_ingredients[$item['item_id']]['ingredients'] as $details): ?>
					<tr>
						<td style="width:250px;text-align:left;padding-left:5px">
							<?php echo $details['name']; ?>
						</td>
						<td style="width:100px;text-align:left;padding-left:5px">
							<?php echo $details['value']; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<br>
		<?php endforeach; ?>
	</div>
	<br/>
	<!-- end of individual-order-report -->
	


		<div class="row-fluid view_info">
			<div class="span12 ">

				<div class="tabbable tabbable-custom tabbable-full-width">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_item" data-toggle="tab">
								<?php echo __('Answer')?>
							</a>
						</li>

						<li>
							<a href="#order_details" data-toggle="tab">
								<?php echo __('Orders')?>
							</a>
						</li>

						<li>
							<a href="#portion_details" data-toggle="tab">
								<?php echo __('Portion for Dishes')?>
							</a>
						</li>
					</ul>

					<div class="tab-content">
						
						<div class="tab-pane row-fluid active" id="tab_item">

							<div class="row-fluid">
								<table class="table table-bordered dataTable" id="table_orders">
									<thead>
										<tr>
											<th style="width:10%">S/N</th>
											<th colspan="2">Order Name</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($order_reports as $k => $order_report):?>
										<tr class="item_tr" style="background-color:#fff;">
											<td><span class="row-details row-details-close"></span></td>
											<td colspan="2"><?php echo $k?></td>
										</tr>
										<tr class="hide">
											<td></td>
											<td colspan="2">
												<table style="width:100%">
													<thead>
														<tr>
															<th style="border-left:none;width:50%">Part Name</th>
															<th>Value</th>
														</tr>
													</thead>
													<tbody>
													<?php foreach($order_report as $q => $val):?>
														<tr>
															<td style="border-left:none;width:50%"><?php echo $q?></td>
															<td><?php echo $val?></td>
														</tr>
													<?php endforeach;?>
													</tbody>
												</table>
											</td>
										</tr>
									<?php endforeach;?>
									</tbody>
								</table>
							</div>
						</div>

						<div class="tab-pane row-fluid" id="order_details">
							<!-- order_details start -->
							<div class="portlet box">
								
								<div class="portlet-body">
									<div class="row-fluid view_info">
										<div class="span12 ">
											<div class="row-fluid">
												<table class="table table-bordered" id="table_orders">
													<thead>
														<tr>
															<th style="width:10%">ID</th>
															<th>NAME</th>
															<th style="width:25%">Action (click to view order details)</th>		
														</tr>
													</thead>
													<tbody>
														<?php foreach($order_list_with_details as $details):?>
														<tr>
															<td style="width:10%"><?php echo $details['order_id']?></td>
															<td><?php echo $details['name']?></td>
															<td style="width:20%"><?php echo $this->Html3->link('View Detail','/Order/view/'.$details['order_id'])?></td>
														</tr>	
														<?php endforeach;?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- end of order_details -->
						</div>

						<div class="tab-pane row-fluid" id="portion_details">
							<!-- portion_details start -->
							<?php //echo '<pre>'; print_r($item_list_with_ingredients); echo '</pre>'; ?>
							<div class="portlet box">
								<div class="portlet-body">
									<div class="row-fluid view_info">
										<div class="span12 ">
											<div class="row-fluid">
												<table class="table table-bordered" id="table_portions">
													<thead>
														<tr>
															<th style="width:10%">ID</th>
															<th>NAME</th>
															<th style="width:25%">Action (click to view portion details)</th>		
														</tr>
													</thead>
													<tbody>
														<?php foreach($item_list_with_ingredients as $details):?>
														<tr>
															<td style="width:10%"><?php echo $details['item_id']?></td>
															<td><?php echo $details['name']?></td>
															<td style="width:20%"><?php echo $this->Html3->link('View Detail','/Portion/view/'.$details['item_id'])?></td>
														</tr>	
														<?php endforeach;?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- end of portion_details -->
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->start('script_own')?>
<script>
$(document).ready(function(){
	
	$("body").on('click','tbody tr.item_tr',function(){

	  	if($(this).next().hasClass("hide")) {
			$(this).next().removeClass("hide");
	   		$(this).find("td").eq(0).find("span").eq(0).removeClass("row-details-close").addClass("row-details-open");
	 	}else{
	   		$(this).next().addClass("hide");
	   		$(this).find("td").eq(0).find("span").eq(0).removeClass("row-details-open").addClass("row-details-close");
	 	}

	  return false;
	 });
	
})
</script>
<?php $this->end()?>