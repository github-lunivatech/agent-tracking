(function ($) {
    $('#emp_type').on('change',function(e){
        let val=$(this).val();
        var text;
        // alert(val);
        if(val==2){
             text='Chief Marketing Officer';
        }else if(val==3){
             text='Marketing Officer';
        }else{
             text='Customer';
        }
        $('.cust_name').show();
        $('#customer_type_name').html(text)

        $.ajax({
            method:'post',
            url:`${BASE_URL}employee/ajaxLoadEmployeeName/`+val,   //for loading employee name
            success: function(response){
                var json=JSON.parse(response)
                // console.log(json)
                var option='<option>Select '+ text+'</option>'
                for(i=0;i<json.EmpDetail.length ;i++){
                   
                    option +='<option value ='+json.EmpDetail[i].EId+'>'+json.EmpDetail[i].EmployeeName+'</option>';
                }
                $('#emp_type1').html(option);
        }
        });
    })

    $(".select2").select2({
        // width: 'resolve' // need to override the changed default
    })



})(jQuery)