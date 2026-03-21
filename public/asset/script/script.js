$('document').ready(function() {	
    
    
    
        $(window).scroll(function () {

            counter_start();

        });

    	
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })

    



    //select all innermails page

    $('#select_all').click(function () {

        $('.email_checkbox').prop('checked', this.checked);



        $('.email_checkbox').change(function () {

            var check = ($('.email_checkbox').filter(":checked").length == $('.email_checkbox').length);

            $('#select_all').prop("checked", check);

        });

    });



    //Page active 

    if (window.location.href.indexOf("index") > -1) {

        $('#id_home').addClass('active_1');

    }

    // else if (window.location.href.indexOf("http://localhost/jobportal/") > -1) {

    //     $('#id_home').addClass('active');

    // }

    else if (window.location.href.indexOf("pricing") > -1) {

        $('#id_pricing').addClass('active_1');

    }

    else if (window.location.href.indexOf("home") > -1) {

        $('#id_user_home').addClass('active_1');

    }

    // else if (window.location.href.indexOf("/") > -1) {

    //     $('#id_company_home').addClass('active_1');

    // }

    else if (window.location.href.indexOf("cv-search") > -1) {

        $('#id_candidate').addClass('active_1');

    }

    else if (window.location.href.indexOf("jobs") > -1) {

        $('#id_job').addClass('active_1');

    }

    else if (window.location.href.indexOf("about-us") > -1) {

        $('#id_whyus').addClass('active_1');

    }

    else if (window.location.href.indexOf("contact") > -1) {

        $('#id_contact').addClass('active_1');

    }



    //counter for all page script

    var counted = 0;



    function counter_start () {

        if ($('.number_board-counter').length) {

            var oTop = $(".number_board-counter").offset().top - window.innerHeight;

            if (counted == 0 && $(window).scrollTop() > oTop) {

                $(".number_board-counter .counter").each(function () {

                    var $this = $(this),

                        countTo = $this.attr("data-count");

                    $({

                        countNum: $this.text(),

                    }).animate(

                        {

                            countNum: countTo,

                        },

                        {

                            duration: 4000,

                            easing: "swing",

                            step: function () {

                                $this.text(Math.floor(this.countNum));

                            },

                            complete: function () {

                                $this.text(this.countNum);

                            },

                        }

                    );

                });

            counted = 1;

            }

        }

    }



    // if (window.location.href.indexOf("jobportal") > -1) {


    // }



    if (window.location.href.indexOf("whyus") > -1) {

        counter_start();

    }



    //validation for all page

    $(".contacts-form").each(function(){ 

        $(this).validate({ 

			rules: {

				inputTag: {

					required: true,

				},  

			},

			messages: {

				inputTag: {

					inputTag: "Invalid Email Address",

				},  

			},

			submitHandler: function (form) {		

				form.submit();

			}

		});

	});	

    





    $('.select_skills').select2({

        placeholder : 'Choose by Skills'

    });



    $('.select_skills').on('select2:close', function() {

        let select = $(this);

        $(this).next('span.select2').find('ul').html(function() {

          let count = select.select2('data').length;

          if(count < 1) {

            return "<li>Choose by Skills</li>";

          }

          else {

            return "<li>" + count + " skills selected</li>";

          }

        });

    });	



    //filter for responsive

    $("#filter_show-button").click(function(){

      $(".candidate_filter-sub").css({

          'left' : '0',

          'opacity' : '1'

      });

    });

    

    $("#filter_hide-button").click(function(){

      $(".candidate_filter-sub").css({

        'left' : '-100%',

        'opacity' : '0'

    });

    });



    // footer arrow

	$(window).scroll(function () {

        if ($(this).scrollTop() > 50) {

            $('#back-to-top').fadeIn();

        } else {

            $('#back-to-top').fadeOut();

        }

    });    

    // scroll body to 0px on click

    $('#back-to-top').click(function () {

        $('body,html').animate({

            scrollTop: 0

        }, 400);

        return false;

    });

    



    //candidatedashboard page script

    $("#noticeperiodopt").change(function() {		

        //alert($(this).val());	  

        if ($(this).val() == "servingnp") {		

            $('#appendforsnp').show();		

            $('#appendforsnpinput').attr('required', '');		

            $('#appendforsnpinput').attr('data-error', 'This field is required.');	  

        } 

        else {		

            $('#appendforsnp').hide();		

            $('#appendforsnpinput').removeAttr('required');		

            $('#appendforsnpinput').removeAttr('data-error');	  

        }	  	 

        if ($(this).val() == "buyablenp") {		

            $('#appendforbnp').show();		

            $('#appendforbnpinput').attr('required', '');		

            $('#appendforbnpinput').attr('data-error', 'This field is required.');	  

            

        } 

        else {		

            $('#appendforbnp').hide();		

            $('#appendforbnpinput').removeAttr('required');		

            $('#appendforbnpinput').removeAttr('data-error');	  

            

        }	  	

    });



    //candidatedashboard page script

	$("#extraoffers").change(function() {		

	   // alert($(this).val());	  

	    if ($(this).val() == "1") {		

	        $('.section-offers-details').show();	  

	        

	    } else {		

	        $('.section-offers-details').hide();	  

	        

	    }	

	});	

	
    //candidatedashboard page script

	$('.type-of-process').hide();

	$("#industry").change(function() {		

	   // alert($(this).val());	  

	    if ($(this).val() == "2") {		

	        $('.type-of-process').show();	  

	        $('.gender-canditate').addClass('col-lg-12');

	        

	    } else {		

	        $('.type-of-process').hide();	  

	         $('.gender-canditate').removeClass('col-lg-12');

	        

	    }	

	});	

	

    //candidatedashboard page script

	$("#industry").change(function() {	

	    if ($(this).val() == "1") {		

	        $('.it_projects-process').hide();	  

	       $('.it-project-process').hide();

	        

	    } else {		

	        $('.it_projects-process').show();	  

	       $('.it-project-process').show();

	        

	    }	

	});	



});



//input min & max validation

 function imposeMinMax(el){

    if(el.value != ""){

      if(parseInt(el.value) < parseInt(el.min)){

        el.value = el.min;

      }

      if(parseInt(el.value) > parseInt(el.max)){

        el.value = el.max;

      }

    }

  }
  



    