<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Title</title>
   
<style>
    .invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr  {
    border-top: none;
    margin-left:20px;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}
th, td {
  padding: 5px 0 10px 15px;
}
thead tr td
{
  padding-top: 20px;  
}
.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}

</style>
</head>
<body>
<div class="container">
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    			    	<div class="invoice-title">
                			<h2>Order #  {{$maildata[0]->orderId}}</h3>
                		</div>
                		<hr>
    			    <h3 class="panel-title"><strong>Store : <span>{{$maildata[0]->store_name}}</span></strong></h3>
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    		
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="line-item-tbl" width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    						<thead>
                                <tr>
                                    <td style="width: 10%; font-size:12px;"><strong>Sku</strong></td>
        							<td style="width: 20%; font-size:12px;"><strong>Item</strong></td>
        							<td style="width: 20%;font-size:12px;"><strong>Category</strong></td>
        							<td style="width: 10%;text-align:center;font-size:12px;"><strong>Price</strong></td>
        							<td style="width: 10%;text-align:center;font-size:12px;"><strong>Quantity</strong></td>
        							<td style="width: 30%;font-size:12px;"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    						@foreach ($maildata as $line) 
    							<tr class="line-item">
    							    <td style="width: 10%; font-size:12px;"><strong>{{$line->product_sku}}</strong></td>
    								<td style="width: 20%;font-size:12px;">{{$line->product_name}}</td>
    								<td style="width: 20%;font-size:12px;">{{$line->product_category}}</td>
    								<td style="width: 10%;text-align:center;font-size:12px;">{{$line->unit_price}}</td>
    								<td class="text-center" style="width: 10%;text-align:center;font-size:12px;">{{$line->quantity}}</td>
    								<td style="width: 30%;font-size:12px;">$ {{$line->price}}</td>
    							</tr>
    						
                         	@endforeach
    							<tr>
    							    <td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center" style="text-align:center"><strong>Total</strong></td>
    								<td class="no-line text-right">$ {{$maildata[0]->amount}}</td>
    							</tr>
    						</tbody>
    					</table>
    					
    				</div>
    			</div>
    			@if($maildata[0]->note != null)
    		<div class="panel-footer">
    				<h3 class="panel-title"><strong>Note:</strong></h3>
    				<p>{{$maildata[0]->note}}</p>
    			</div>
    			@endif
    		</div>
    	</div>
    </div>
</div>
</body>
</html>
