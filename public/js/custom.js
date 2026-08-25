   $(function(){

    $('.onlyLetters').keydown(function(e) {
      if (e.shiftKey  || e.altKey) {
        e.preventDefault();
      } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
          e.preventDefault();
        }
      }
    });

      $("input[name=ticket_no]").mask("999-9999-999-999");
    
      $(".flight").mask("?aaa-aaa-aaa");
      $(".dob").mask("99/99/9999");
      $(".ticket-date-mask").mask("99-99-9999");

   /*   $(document).on('keyup', 'input[name=sale]', function(){
         var sale = parseFloat($('input[name=sale]').val());
         var cost = parseFloat($('input[name=cost]').val());
         var profit  = sale-cost;
         if (!isNaN(profit)) {
             $('input[name=profit]').val(profit);
         }
      });*/

      $(document).on('keyup', '#visaSale', function(){
         var sale = parseFloat($('#visaSale').val());
         var cost = parseFloat($('#visaCost').val());
         var profit  = sale-cost;
         if (!isNaN(profit)) {
             $('#visaProfit').val(profit);
         }
      });

 $(document).on('keyup', '#ticketSale', function(){
         var sale = parseFloat($('#ticketSale').val());
         var cost = parseFloat($('#ticketCost').val());
         var profit  = parseFloat(sale-cost).toFixed(2);
         if (!isNaN(profit)) {
             $('#ticketProfit').val(profit);
         }
      });
 $(document).on('keyup', '#hotelSale', function(){
         var sale = parseFloat($('#hotelSale').val());
         var cost = parseFloat($('#hotelCost').val());
         var profit  = sale-cost;
         if (!isNaN(profit)) {
             $('#hotelProfit').val(profit);
         }
      });
 $(document).on('keyup', '#packageSale', function(){
         var sale = parseFloat($('#packageSale').val());
         var cost = parseFloat($('#packageCost').val());
         var profit  = sale-cost;
         if (!isNaN(profit)) {
             $('#packageProfit').val(profit);
         }
      });
 $(document).on('keyup', '#umrahSale', function(){
         var sale = parseFloat($('#umrahSale').val());
         var cost = parseFloat($('#umrahCost').val());
         var profit  = sale-cost;
         if (!isNaN(profit)) {
             $('#umrahProfit').val(profit);
         }
      });
 $(document).on('keyup', '#travelSale', function(){
         var sale = parseFloat($('#travelSale').val());
         var cost = parseFloat($('#travelCost').val());
         var profit  = sale-cost;
         if (!isNaN(profit)) {
             $('#travelProfit').val(profit);
         }

      });
 $(document).on('keyup', '#otherSale', function(){
         var sale = parseFloat($('#otherSale').val());
         var cost = parseFloat($('#otherCost').val());
         var profit  = sale-cost;
         if (!isNaN(profit)) {
             $('#otherProfit').val(profit);
         }
      });

       $('select[name=parties_id]').change( function () {
           $('input[name=phone]').val($(this).find(":selected").data('phone'))
       });
   });

	$(document).on('click', '.add-tax', function(){
		var html 	= `<div class="appended_tax"><div class="col-sm-10 form-group">
		<label class="control-label require">Tax</label>
		<input placeholder="Tax" class="form-control" name="tax[]" type="text"  data-validation="number" data-validation-error-msg="Only Digit" onkeyup="calcTax()">
		</div>
		<div class="col-sm-2 form-group">
		<a href="javascript:;" class="btn tax-btn remove-tax btn-danger btn-block btn-sm"><i class="fa fa-minus"></i></a>
		</div></div>`;
		$('.tax-append').append(html);
	});

	$(document).on('click', '.remove-tax', function(){
		var $this = $(this);
		$this.closest('.appended_tax').remove();
	});

   function calcTax(event) {
      var totalTax = 0;
      var fare = $('input[name=fare]').val();
      var tax = $('input[name=tax]').val();
      var tax2 = $('input[name=tax2]').val();
      var tax3 = $('input[name=tax3]').val();
      var tax4 = $('input[name=tax4]').val();
      if (fare != '') {
        totalTax =  parseFloat(totalTax + parseFloat(fare));
      }
      if (tax != '') {
        totalTax =  parseFloat(totalTax + parseFloat(tax));
      }
      if (tax2 != '') {
        totalTax =  parseFloat(totalTax + parseFloat(tax2));
      }
      if (tax3 != '') {
        totalTax =  parseFloat(totalTax + parseFloat(tax3));
      }
      if (tax4 != '') {
        totalTax =  parseFloat(totalTax + parseFloat(tax4));
      }
       var total_cost = totalTax;

         if(!isNaN(total_cost)){
             $('#ticketCost').val(total_cost);
         }
      /*$("input[name='tax[]']").each(function(i, v){
         totalTax = totalTax + parseFloat($(v).val());
         $('input[name=total_tax]').val(totalTax);
        

    });*/
   }

   function limNum(e) {
       var amt = $(e)
       amt.on("keyup", function() {
           if (isNaN(amt.val())) {
               amt.val(0);
           }
           if (amt.val().indexOf(".") > -1 && (amt.val().split('.')[1].length > 2)) {
               amt.val(amt.val().substring(0, amt.val().length - 1));
           }
       })
   }

   /*$('.today-date').datepicker({
       format: "d-M-yyyy",
       "autoclose": true
   }).datepicker("setDate",'now');*/

   
   function nextIndex(e,len, nextInput) {
       var sector = $(e).val().replace(/-/g, "");
       var sector = sector.replace(/_/g, "");
       if(sector.length == len){
           $(nextInput).focus();
       }
   }
   function addsector(value) {
     $('.sector').val(value);
   }
$(document).ready(function(){
  $('.sector').on('blur', function() {
    $('.typeahead').fadeOut('medium');
  });
  $('.sector').on('focus', function() {
    $('.typeahead').show();
  });
  /*var data = 
   [
    "LHR-ISB-LHR", "LHR-LHE-LHR", "LHR-KHI-LHR", "MAN-ISB-MAN", "MAN-LHE-MAN", "BHX-ISB-BHX"
  ];
  var $input = $(".autocomplete");
  $input.typeahead({
    source: data
  });*/
    $("input[name=sector]").mask("?aaa-aaa-aaa-aaa-aaa");
    $("input[name=party_sector]").mask("?aaa-aaa");
    $("input[name=sector_two]").mask("?aaa-aaa");
  $("#startdate").datepicker({
        todayBtn:  1,
        autoclose: true,
         format: "d-M-yyyy",
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());

        $('#enddate').datepicker('setStartDate', minDate);
    });

    $("#enddate").datepicker({
        todayBtn:  1,
        autoclose: true,
         format: "d-M-yyyy",
    });    

    $('#ticket_no').on('blur', function() {
      var last = $(this).val();
      var last2 = last.substr(last.length - 3);
      $('#airlines option').each(function() {
        var code = $(this).data('code');
        if (last2 == code) {
          $(this).attr("selected","selected");    
        }
      });
    });             


    $("#dob").datepicker({ 
    yearRange: "-20:+0", // this is the option you're looking for
    showOn: "both"
  });           
    $('form').submit(function(){
      $(this).find('button[type=submit]').prop('disabled', true);
    });

  });

/*.on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', maxDate);
        })*/

        function opendModal(event) {
          var passengers = $('#party option:selected').data('passengers');
        
          var html = '';
          if (passengers != '') {
            $.each(passengers, function(i, item) {
              var sendata  = "'"+item+"'";

              html += " <li><a href='javascript:;' onclick='showPartyData("+JSON.stringify(item)+")'>"+item.title+" "+item.given_name+" "+item.surname+" </a></li>";
            });
          }else{
            html += '<li style="text-align:center"><a href="javascript:;">No Passenger Found</a><li>';
          }

          $('#passengersList').html(html);
        }
        function showPartyData(data) {
       
          $('select[name="title"]').val(data.title);
          $('input[name="surname"]').val(data.surname);
          $('input[name="given_name"]').val(data.given_name);
          $('input[name="passport"]').val(data.passport);
          $('input[name="dob"]').val(data.dob);
          $('#myModal').modal('hide');
        }
        function showDetailButton(event) {
           var passengers = $('#party option:selected').data('passengers');
           if (passengers != '') {
            $('.partyDetailButton').show();
           }else{
             $('.partyDetailButton').hide();
           }
        }