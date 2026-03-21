var base_url = "https://www.zeronoticeperiod.com/";

$(document).ready(function(){

    

    $(".email_checkbox").click(function(){

        alert('test');

        var array = new Array();

        // var checked = $(".email_checkbox:checked").length;

        var checkbox = $(".email_checkbox:checked");

        if (checkbox) {

            var check = checkbox.map(function(){

                // check1= $(this).val();

                array.push($(this).val());

            });

        }

        $("#bulkuser_id").val(array);

        //console.log(array);

    });



    $("#select_all").click(function(event){

        var array1 = new Array();

        var checkbox = $(".email_checkbox");

        if (checkbox.is(':checked')) {

            var selectid = checkbox.map(function(){

                array1.push($(this).val());

            });

        } else {

           selectid=0; 

        }

        $("#bulkuser_id").val(array1);

    });

});