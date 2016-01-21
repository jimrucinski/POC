<html>
<head>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>        
        <script type="text/javascript" src="./scripts/jquery.formatCurrency-1.4.0.min.js"></script>
	<style>
		table{border:solid 1px #000000;font-family:calibri;padding-left:3px;padding-right:3px;background-color:#eeeeee;}	
		table th{text-align:left;text-transform:capitalize;text-align:right;}	
		table td{text-transform:capitalize;text-align:right;}
		.header{font-weight:bolder;text-align:left;}
                .footer{font-weight:bolder;text-align:right;background-color:#cccccc;}
		input{width:50px;text-align:right;}
		.ItemTot{width:70px;}
	</style>
	<title>M&T Estimate Calculator</title>
</head>
<body>
    <form method='post' action='calc.php' id='estimator'>
            <table cellspacing="0" cellpadding="0">
                    <tr>
                            <th>&nbsp;</th>
                            <th>cost</th>
                            <th>qty.</th>
                            <th>total</th>
                    </tr>
                    <tr id="coffeeStuff">
                            <td class="header">coffee</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="waterStuff">
                            <td class="header">bottled water</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="sodaStuff">
                            <td class="header">assorted soda</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="foodStuff">
                            <td class="header">food</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="barStuff">
                            <td class="header">bar</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="cateringLaborStuff">
                            <td class="header">catering labor</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="roomRentalStuff">
                            <td class="header">room rental</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="signLargeStuff">
                            <td class="header">sign (large)</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="signSmallStuff">
                            <td class="header">sign (small)</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="installationLabortuff">
                            <td class="header">installation labor</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="roomNightsStuff">
                            <td class="header">room nights</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="audioVisualStuff">
                            <td class="header">audio visual</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="transporationStuff">
                            <td class="header">transportation</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="golfStuff">
                            <td class="header">golf</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="decorStuff">
                            <td class="header">décor</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr id="entertainmentStuff">
                            <td class="header">entertainment</td>
                            <td><input type='text' name='itemCost' value="" /></td>
                            <td><input type='text' name='itemQty' value=""/></td>
                            <td><div id="itemTotal" class='ItemTot'/></td>
                    </tr>
                    <tr class="footer">
                            <td colspan="3" style="text-align:right;">subtotal</td>
                            <td id="subTotal"></td>	
                    </tr>
                    <tr class="footer">
                            <td colspan="3" style="text-align:right;">gratuity</td>
                            <td id="gratuityTotal"></td>
                    </tr>
                    <tr class="footer">
                            <td colspan="3" style="text-align:right;">tax</td>
                            <td id="taxTotal"></td>
                    </tr>
                    <tr class="footer">
                            <td colspan="3"style="text-align:right;">total estimate</td>
                            <td id="grandTotal"></td>
                    </tr>
            </table>
    </form>    
    <script>
        var gratuity =.18;
        var tax = .085;
        var sum = 0;
        var gratuityTot=0;
        var taxTot=0;

        $('#gratuity').html('gratuity: ' + (gratuity*100).toFixed(2) + '%');
        $('#tax').html('tax: ' + (tax*100).toFixed(2) + '%');


        $('input[name=itemCost],input[name=itemQty]').change(function(e) {

        var total = 0;
        //var $row = $(this).parent();
        var $row = $(this).closest('tr');
        var cost = $row.find('input[name=itemCost]').val();
        var qty = $row.find('input[name=itemQty]').val();
        total = parseFloat(cost * qty).toFixed(2);
        //$row.find('input[name=itemTotal]').val( total);
        $row.find('#itemTotal').html(total);

        var total_amount = 0;
        $('.itemTot').each(function() {
                //Get the value
                var am= parseFloat($(this).text(),10);
                //if it's a number add it to the total
                if ($.isNumeric(am)) {
                        total_amount += parseFloat(am, 10);
                }
        });
        $('#subTotal').html(total_amount.toFixed(2)).formatCurrency();
        gratuityTot = (total_amount*gratuity).toFixed(2)
        $('#gratuityTotal').html(gratuityTot).formatCurrency();
        taxTot = (total_amount*tax).toFixed(2);
        $('#taxTotal').html(taxTot).formatCurrency();
        sum = Number(total_amount) + Number(gratuityTot) + Number(taxTot);			
        $('#grandTotal').html( sum.toFixed(2)).formatCurrency();
        });
    </script>
</body>

</html>