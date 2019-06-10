$(document).ready(function() {
 
    $('#prelimMembership').submit(function(e) {
      e.preventDefault();
      var companyName = $('#companyName').val(); 
      var mainBusiness = $('#mainBusiness').val();
      var produceSegment = $('#produceSegment').val();
      var annualSales = $('#AnnualSales').val();
      var hasErrors = false;

      //alert('produceSegement =  ' + produceSegment.length);
      //var last_name = $('#last_name').val();
      //var email = $('#email').val();
      //var password = $('#password').val();
        
  
      $(".error").remove();
   
      if (companyName.length < 1) {
        $('#companyName').after('<span class="error">This field is required</span>');
        hasErrors = true;
      }
      if(mainBusiness.length < 1){
          $('#mainBusiness').after('<span class="error">This field is required</span>');
          hasErrors = true;
      }
      if(mainBusiness.toUpperCase() == 'PRODUCE' && produceSegment.length == 0){
          $('#produceSegment').after('<span class="error">This field is required</span>');
          hasErrors = true;
      }
      if(produceSegment.length > 0 && annualSales == "")
      {
        $('#AnnualSales').after('<span class="error">This field is required</span>');
        hasErrors = true;
      }

      if(hasErrors)
        return false;
 
      $("#memberMessage").html("<p>Based on the information provided your yearly membership dues will be " +  $("#AnnualSales").val() + ".")
      $("#memberCheckMessage").css('display','inline-block'); 
      
      //if (last_name.length < 1) {
      //  $('#last_name').after('<span class="error">This field is required</span>');
     // }
     // if (email.length < 1) {
     //   $('#email').after('<span class="error">This field is required</span>');
     // } else {
     //   var regEx = /^[A-Z0-9][A-Z0-9._%+-]{0,63}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/;
     //   var validEmail = regEx.test(email);
    //  if (!validEmail) {
    //      $('#email').after('<span class="error">Enter a valid email</span>');
      //  }
     // }
     // if (password.length < 8) {
     //   $('#password').after('<span class="error">Password must be at least 8 characters long</span>');
     // }
    });
   
  });