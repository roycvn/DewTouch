<div class="alert  ">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>

<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>


<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>



<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with</div>

<table class="table table-striped table-bordered table-hover dynamic-rows-table">
<thead>
<th><span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
											<i class="icon-plus"></i></span></th>
<th>Description</th>
<th>Quantity</th>
<th>Unit Price</th>
</thead>

<tbody>
	<tr>
		<td></td>
		<td><textarea name="data[1][description]" class="custom-editbox m-wrap description required" rows="2" >Description Text</textarea></td>
		<td><input name="data[1][quantity]" class="custom-editbox" value="Quantity Text"></td>
		<td><input name="data[1][unit_price]"  class="custom-editbox" value="Unit Price Text"></td>
	</tr>

</tbody>

</table>


<p></p>
<div class="alert alert-info ">
<button class="close" data-dismiss="alert"></button>
Video Instruction</div>

<p style="text-align:left;">
<video width="78%"   controls>
  <source src="/video/q3_2.mov">
Your browser does not support the video tag.
</video>
</p>





<?php $this->start('script_own');?>
<script>
$(document).ready(function(){
	var tbodyElement = $('.dynamic-rows-table');
	var tbodyRowIndex = 1;
	$("#add_item_button").click(function(){
		tbodyRowIndex++;
		var appendHTML = '<td></td>\
												<td><textarea name="data[' + tbodyRowIndex + '][description]" class="custom-editbox m-wrap description required" rows="2" >Description Text</textarea></td>\
												<td><input name="data[' + tbodyRowIndex + '][quantity]" class="custom-editbox" value="Quantity Text"></td>\
												<td><input name="data[' + tbodyRowIndex + '][unit_price]"  class="custom-editbox" value="Unit Price Text"></td>';
		
		var row = document.createElement('tr');
		row.innerHTML = appendHTML;
		tbodyElement.append(row);

		inputTextOperation(true);
		activateEditboxEvents();
	});


	var inputTextOperation = function(lockStatus, element = null) {
		if(element) {
			if(lockStatus) {
				element.attr('readonly', 'readonly')
							 .addClass('lock-editbox');
			} else {
				element.removeAttr('readonly')
							 .removeClass('lock-editbox');
			}
		} else {
			$('.custom-editbox').each(function(e) {
				if(lockStatus) {
						$(this).attr('readonly', 'readonly')
									 .addClass('lock-editbox');
				} else {
						$(this).removeAttr('readonly')
									 .removeClass('lock-editbox');
				}
			});
		}
	}

	var activateEditboxEvents = function() {
		$('.custom-editbox').each(function(e) {
			$(this).click(function(inputEvent) {
				inputTextOperation(false, $(this));
			});
			$(this).blur(function(inputEvent) {
				inputTextOperation(true, $(this));
			});
		});
	}

	inputTextOperation(true);
	activateEditboxEvents();	
});
</script>

<style>
	.lock-editbox {border: none; height: auto; background-color: rgba(0, 0, 0, 0); resize: none;}
</style>
<?php $this->end();?>

