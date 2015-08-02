 (function($) {
	$(document).ready(function(){

		$( "#jform_startdate" ).datepicker({
			showOn: "button",
			buttonImage: "components/com_event/assests/js/calendar.gif",
			buttonImageOnly: true,
			dateFormat: 'yy-mm-dd'
		});
		$( "#jform_enddate" ).datepicker({
			showOn: "button",
			buttonImage: "components/com_event/assests/js/calendar.gif",
			buttonImageOnly: true,
			dateFormat: 'yy-mm-dd'
		});
		$('#jform_starttime').timepicker({
			 timeFormat: "HH:mm:ss"
			}); 
		$('#jform_endtime').timepicker({
			 timeFormat: "HH:mm:ss"
			});
		/*
		 * for input form validation..
		 * 
		 */
		$('#event-editform').submit(function() {
			
			var stringfilter = /^[a-zA-Z_ ]*$/;
			var addressfilter = /^[a-zA-Z0-9-_ ]*$/;
			var phonereg = /^[0-9]*$/;
			var Emailregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			var websiteReg = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
			
			if($('#jform_title').val() != ''){if(!stringfilter.test($('#jform_title').val())){ alert('Invalid title of event'); $('#jform_title').focus(); return false;}}
			else{alert('please enter title of event'); $('#jform_title').focus(); return false;}

			if($('#jform_eventtype').val() <= 0){alert('please select a event type'); $('#jform_eventtype').focus(); return false;}
			
			if($('#jform_startdate').val() == ''){alert('please select a event startdate'); $('#jform_startdate').focus(); return false;}
			
			if($('#jform_enddate').val() == ''){alert('please select a event enddate'); $('#jform_enddate').focus(); return false;}
			
			if($('#jform_starttime').val() == ''){alert('please select a event stattime'); $('#jform_starttime').focus(); return false;}
			
			if($('#jform_endtime').val() == ''){alert('please select a event endtime'); $('#jform_endtime').focus(); return false;}
			
			if($('#jform_startdate').val() > $('#jform_enddate').val()){alert('Event start date should be less than end date'); $('#jform_startdate').focus(); return false;}

			var now = new Date();
			var currenttime = now.getHours()+':'+now.getMinutes()+':'+now.getSeconds();
			var month = now.getMonth()+1;
			var day = now.getDate();
			var currentdate = now.getFullYear() + '-' +
			    (month<10 ? '0' : '') + month + '-' +
			    (day<10 ? '0' : '') + day;
            if((currentdate == $('#jform_enddate').val()))
            {
            	if($('#jform_endtime').val() < currenttime){alert('Event time should be greater than current time'); $('#jform_endtime').focus(); return false;}
            }
			if(($('#jform_startdate').val() == $('#jform_enddate').val())){ 
				if(currentdate == $('#jform_startdate').val()){
				if($('#jform_endtime').val() < currenttime){alert('Event end time should be greater than current time'); $('#jform_endtime').focus(); return false;}}
				if($('#jform_starttime').val() > $('#jform_endtime').val()){
					alert('Event end time should be greater than start time'); $('#jform_endtime').focus(); return false;
				}
			}
			if($("input[name^='jform[musictype]']:checked").length <= 0){alert('please select a music type'); return false;}
			 
			if($("input[name^='jform[cancelled]']:checked").length >= 1){alert('please fill the cancellreason, as you select cancell option'); $('#jform_cancelledreason').focus(); return false;}
			
			if($('#jform_dresscode').val() <= 0){alert('please select a dresscode type'); $('#jform_dresscode').focus(); return false;}

		    var ext = $('#jform_frontfly').val().match(/\.(.+)$/)[1]; 
			if(!(ext == 'jpg' || ext == 'JPG' || ext == 'png' || ext == 'PNG' || ext == 'jpeg'|| ext == 'JPEG' || ext == 'bmp' || ext == 'gif' || ext == 'GIF')){
				$('#jform_frontfly').focus();
				alert('please select an image type');
				return false;
			} 			
		    var ext1 = $('#jform_backfly').val().match(/\.(.+)$/)[1]; 
			if(!(ext1 == 'jpg' || ext1 == 'JPG' || ext1 == 'png' || ext1 == 'PNG' || ext1 == 'jpeg'|| ext1 == 'JPEG' || ext1 == 'bmp' || ext1 == 'gif' || ext1 == 'GIF')){
				$('#jform_backfly').focus();
				alert('please select an image type');
				return false;
			} 			

			if($('#jform_venue').val() != ''){if(!addressfilter.test($('#jform_venue').val())){ alert('Invalid Venue of event'); $('#jform_venue').focus(); return false;}}
			else{alert('please enter venue of event'); $('#jform_venue').focus(); return false;}
			
			if($('#jform_address1').val() != ''){if(!addressfilter.test($('#jform_address1').val())){ alert('Invalid address1 of event'); $('#jform_address1').focus(); return false;}}
			else{alert('please enter address of event'); $('#jform_address1').focus(); return false;}
			
			if($('#jform_address2').val() != ''){if(!addressfilter.test($('#jform_address2').val())){ alert('Invalid address2 of event'); $('#jform_address1').focus(); return false;}}
			else{alert('please enter address of event'); $('#jform_address2').focus(); return false;}
			
			if($('#jform_city').val() != ''){if(!stringfilter.test($('#jform_city').val())){ alert('Invalid city of event'); $('#jform_city').focus(); return false;}}
			else{alert('please enter city of event'); $('#jform_city').focus(); return false;}
			
			if($('#jform_state').val() != ''){if(!stringfilter.test($('#jform_state').val())){ alert('Invalid state of event'); $('#jform_state').focus(); return false;}}
			else{alert('please enter state of event'); $('#jform_state').focus(); return false;}
				
			if($('#jform_postcode').val() != ''){if(!stringfilter.test($('#jform_postcode').val())){}}
			else{alert('please enter postcode of event'); $('#jform_postcode').focus(); return false;}
			
			if($('#jform_country').val() == 0){alert('please select a country'); $('#jform_country').focus(); return false;}
			
			if($('#jform_phone').val() != ''){if(!phonereg.test($('#jform_phone').val())){ alert('Invalid phone no.'); $('#jform_phone').focus(); return false;}}
			else{alert('please enter phone no.'); $('#jform_phone').focus(); return false;}

			if($('#jform_email').val() != ''){if(!Emailregex.test($('#jform_email').val())){ alert('Invalid email address'); $('#jform_email').focus(); return false;}}
			else{alert('please enter email address'); $('#jform_email').focus(); return false;}

			if($('#jform_website').val() != ''){if(!websiteReg.test($('#jform_website').val())){ alert('Invalid website url'); $('#jform_website').focus(); return false;}}
			else{alert('please enter website'); $('#jform_website').focus(); return false;}
			if($('#captchverify').val() != ''){
			if(!($('#txtCaptcha').val().split(' ').join('') == $('#captchverify').val().split(' ').join(''))){alert('Wrong captcha entered'); $('#captchverify').focus(); return false;}}
			else{
				alert('Please enter captcha'); $('#captchverify').focus(); return false;
			} 
		});
	});
	})(jQuery);
 /*
  * function for front fly preview.
  */
 function readFrontURL(input)
 {    
       if (input.files && input.files[0])
               {
                     var reader = new FileReader();
                    reader.onload = function (e)
                                           {
                                                 $('#frontfly')
                                                 .attr('src',e.target.result)
                                                 .css('display', 'block')
                                                 .width(100)
                                                 .height(100);
                                           };
                    reader.readAsDataURL(input.files[0]);
                    }
 }
 /*
  * function for back fly preview.
  */
 function readBackURL(input)
 {    
       if (input.files && input.files[0])
               {
                     var reader = new FileReader();
                    reader.onload = function (e)
                                           {
                                                 $('#backfly')
                                                 .attr('src',e.target.result)
                                                 .css('display', 'block')
                                                 .width(100)
                                                 .height(100);
                                           };
                    reader.readAsDataURL(input.files[0]);
                    }
 }