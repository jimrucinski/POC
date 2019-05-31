$(document).ready(function(){
    var thisSegment='';
    var arSegmentOne=['FoodserviceOperations','ConvenienceStore','NotForProfit'];
    var arSegmentTwo=['Supermarkets','Grocers'];
    $('#floralSegmentItems').hide();
    $('#produceSegmentItems').hide();
    $('#numberOfStoresSegment').hide();
    $('#annualSalesSegement').hide();
    
    $('#mainBusiness').on('change', function(event) {
        thisSegment = $(this).val();

        switch(thisSegment){
            case 'Floral':
                $('#floralSegmentItems').show();
                $('#produceSegmentItems').hide();
                $('#numberOfStoresSegment').hide();
                $('#annualSalesSegement').hide();
                $('#produceSegment').val('');
                $('#NumberOfStores').val('');
                $('#AnnualSales').val('');
                break;
            case 'Produce':
                $('#floralSegmentItems').hide();
                $('#produceSegmentItems').show();

                $('#floralSegment').val('');
                break;
            case 'ProduceAndFloral':
                $('#produceSegment').val('');
                $('#floralSegment').val('');
                $('#floralSegmentItems').show();
                $('#produceSegmentItems').show();
                break;
            default:
                $('#floralSegmentItems').hide();
                $('#produceSegmentItems').hide();
        }

    });

    $('#floralSegment').on('change',function(event){
        (thisSegment)==='Floral'?alert('call crm'):'';
    });

    function hideStoresAndSales(){
        $('#AnnualSales').val('');
        $('#NumberOfStores').val('');
        $('#annualSalesSegement').hide();
        $('#numberOfStoresSegment').hide();

    }
    function toggleSales(){
        $('#annualSalesSegement').show();
        $('#numberOfStoresSegment').hide();
    }
    function toggleStores(){
        $('#annualSalesSegement').hide();
        $('#numberOfStoresSegment').show();
    }
    $('#produceSegment').on('change',function(event){
        if(jQuery.inArray($(this).val(),arSegmentOne)!== -1){
            hideStoresAndSales();
            alert('Call to CRM');
        }            
        else{
            (jQuery.inArray($(this).val(),arSegmentTwo)=== -1 ? toggleSales():toggleStores());
        }
            
        
    });
});