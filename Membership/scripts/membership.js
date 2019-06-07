$(document).ready(function(){
    var msg ="Our records indicate that the company entered is already a member. If you would like to learn about gaining access please contact "
    var thisSegment='';
    var arSegmentOne=['FoodserviceOperations','ConvenienceStore','NotForProfit'];
    var arSegmentTwo=['Supermarkets','Grocers'];
    var companyName;
    var duesAmount;
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

    $("#CheckMemberStatus").click(function() {
        var coName = $('#companyName').val();
        //alert('coName = ' + coName);
        
        $.getJSON('memberCheck.json',function(data){
            
            var output = '<p>';  
            $.each(data, function(key,val){
                if(val.companyName === coName){
                    if(val.isMember)
                       output += msg + val.companyContact;
                    else{
                        companyName=val.companyName;
                        alert('company Name = ' + companyName);
                        //duesAmount = vale.duesAmount;
                        output = "Based on the information provided your yealy dues will be " + val.duesAmount;
                        $("#continueProcessButton").css('display','inline-block');
                        //alert("companyName = " + companyName);
                    }
                }           
            });
            output += '</p>';
            $('#memberCheckMessage').html(output);
            });
    });
    $("#mainBusiness").change(function(){

        $.getJSON('BusinessTypes.json',function(data){
            $('#produceSegment').empty();
           $.each(data, function(){
            $('#produceSegment').append($('<option></option>'));
               $.each(this,function(k,v){
                if(this.business.toUpperCase() ===$('#mainBusiness').val().toUpperCase() ){
                    $('#produceSegment').append($('<option></option>').val(this.businessType).html(this.businessType));

                }
                //else{alert(this.businessType)}
                   /* $.each(this,function(k,v){
                        //alert('drop = ' + $('#mainBusiness').val());
                        //alert('it = ' + v);
                        if(k ==='businessType' && v.toUpperCase() ===$('#mainBusiness').val().toUpperCase() ){
                            alert('its  = ' + v);
                            alert(this);

                        }
                        //build floral business segment dropdown
                        if(k === 'segments'){$("#floralSegment").empty();
                            $('#floralSegment').append($('<option></option>'));
                            $.each(this,function(k,v){
                                $('#floralSegment').append($('<option></option>').val(v.segment).html(v.segment));
                            })
                        }//end build floral business segment dropdown
                    })*/
               });
           });
        });
    })
     
        

    $("#continueProcessButton").click(function(){
        $("#completeApplication").css('display','block');
        $( ".InsertCoName" ).text(companyName);
    })
});
