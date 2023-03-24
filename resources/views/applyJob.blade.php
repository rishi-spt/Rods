@extends('app')

@section('content')
<style type="text/css">
    .bootstrap-tagsinput .tag {
      margin-right: 2px;
      color: white !important;
      background-color: #0d6efd;
      padding: 0.2rem;
    }
  </style>
<div class="col-md-12">
    <div class="wow fadeInUp" data-wow-delay="0.5s">
        <p class="mb-4">Enter Clients details.

            </p>
        <form action="{{'/submitClientData'}}" id="addClientDetails" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="firstName" class="form-control" id="firstName" placeholder="First Name" required>
                        <label for="firstName">First Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Last Name">
                        <label for="lastName">Last Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control" id="email" placeholder="Your Email" required>
                        <label for="email">Your Email</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <input type="number" name="contactNumber" class="form-control" id="contactNumber" placeholder="contactNumber" required>
                        <label for="contactNumber">Contact Number</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="addressLineOne" class="form-control" id="addressLineOne" placeholder="Your addressLineOne" required>
                        <label for="addressLineOne">Address Line 1</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <input type="text" name="addressLineTwo" class="form-control" id="Address Line 2" placeholder="Address Line 2">
                        <label for="Address Line 2">Address Line 2</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="jobtitle" class="form-control" id="jobTitle" placeholder="Software developer" required>
                        <label for="skills">Job title</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <input type="text" name="skills" class="form-control" id="Skills" placeholder="HTML, CSS, React, Node" required>
                        <label for="skills">Skills</label>
                    </div>
                </div>
                
               
                <div class="col-12">
                    <button class="btn btn-primary w-100 py-3" id="submit" type="submit">Submit</button>
                    <button class="btn btn-primary w-100 py-3" id="loader" style="display: none;" disabled>Adding..</button>
                </div>
                <div class="col-12">
                    <p id='resultMessage'></p>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $('#addClientDetails').submit(function(e) {
e.preventDefault();    
let faction = $(this).attr('action');
// console.log('insubmit', $(this).serialize());
$.ajax({
    url:faction,
    type:'POST',
    data : $(this).serialize(),
    // contentType:false,
    // cache: false,
    // processData:false,
     beforeSend: function(){
   
   

    $("#loader").show();
    $("#submit").hide();

},
    success:function(res){
        

        $("#loader").hide();
    $("#submit").show();
   // console.log(res);
        let ares = JSON.parse(res);
       // console.log(ares.status);
        if (ares.status) {
          
$("#resultMessage").html(ares.message);
  alert(ares.message)        
    } else {
            if (ares.message) {
                alert(ares.message)        

                 $("#loader").hide();



            } else {
                console.log('Error');
            }
        }
    },
    error:function() {
        $("#loader").hide();
    $("#submit").show();

console.log("try after some time");
    }
});
});
</script>              
<script>
    $(function () {
      $('input')
        .on('change', function (event) {
          var $element = $(event.target);
          var $container = $element.closest('.example');

          if (!$element.data('tagsinput')) return;

          var val = $element.val();
          if (val === null) val = 'null';
          var items = $element.tagsinput('items');

          $('code', $('pre.val', $container)).html(
            $.isArray(val)
              ? JSON.stringify(val)
              : '"' + val.replace('"', '\\"') + '"'
          );
          $('code', $('pre.items', $container)).html(
            JSON.stringify($element.tagsinput('items'))
          );
        })
        .trigger('change');
    });
  </script>

@endsection
