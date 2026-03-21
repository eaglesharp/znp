var base_url = "https://www.zeronoticeperiod.com/";

$(document).ready(function(){



    $('.edit_collection').click(function(){
        //alert('hi Baskar');
        var id = $(this).data('id');
        //alert(id);
        $.ajax({
            type:"GET",
            url:base_url+"editcollection/"+id,
            success:function(res){        
              if(res){
                //console.log(res);
                $("#edit").html(res);
                $("#editcollection").modal('show');
              }
            }
        });
    });
    $('.delete_collection').click(function(){
        var id = $(this).data('id');
        //alert(id);
        $.ajax({
            type:"GET",
            url:base_url+"go-to-delete-modal/"+id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(res){        
              if(res){
                //console.log(res);
                $("#delete").html(res);
                $("#deletecollection").modal('show');
                // $("#delete_message").show();
                // setTimeout(function() { $("#delete_message").hide(); }, 5000);
              }
            }
        });
    });
});