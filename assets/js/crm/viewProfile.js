(function ($) {
   let today = new Date()
   var dashboard_e = document.getElementById('app-main');
   var loaderElem = ecrm.loaderElement;
   // dashboard_e.prepend(loaderElem);
   // loaderElem.remove();

   function setDate() {
      $('.datepicker').daterangepicker({
         locale: {
            format: 'YYYY-MM-DD'
         },
         singleDatePicker: true,
         calender_style: "picker_4",
         "timePickerSeconds": true,
         // "maxDate": today
      })
   }

   $('.add_new_social').on('click', function (e) {
      $('#socialMediaModal input:not(input[name="cust_id"], #csftoken), #socialMediaModal select').val('');
      $('#socialMediaModal').modal('show');
   })

   $('body').on('click', '.edit_media', function (e) {
      let jsondata = JSON.parse(this.dataset.show);
      $('#media_id').val(jsondata[0])
      $('#media_link').val(jsondata[1])
      $('#cust_hider').val(this.dataset.ext);
      $('#socialMediaModal').modal('show');
   })

   $('.add_new_contact').on('click', function (e) {
      $('#contactModal input:not(:checkbox, input[name="concust_id"]), #contactModal select').val('');
      $('#contactModal').modal('show');
   })

   $('.edit_contacter').on('click', function (e) {
      let jsondata = JSON.parse(this.dataset.show);
      $('#cont_per_name').val(jsondata[0])
      $('#cont_per_num').val(jsondata[1])
      $('#cont_per_email').val(jsondata[2])
      $('#cont_per_des').val(jsondata[3])
      let checkUncheck = jsondata[4] == true ? true : false
      $('#contactModal #isactive').prop('checked', checkUncheck)
      $('#concust_hider').val(this.dataset.ext);
      $('#contactModal').modal('show');
   })

   $('.add_new_employee').on('click', function (e) {
      $('#employeeModal input:not(:checkbox, input[name="assigncust_id"]), #employeeModal select, #employeeModal textarea').val('');
      $('#employeeModal').modal('show');
   })

   $('.edit_employeer').on('click', function (e) {
      let jsondata = JSON.parse(this.dataset.show);
      $('#cust_userid').val(jsondata[0])
      $('#cust_user_stat').val(jsondata[1])
      $('#cust_remarks').val(jsondata[2])
      let checkUncheck = jsondata[3] == true ? true : false
      $('#employeeModal #isactive').prop('checked', checkUncheck)
      $('#csf').val(this.dataset.ext);
      $('#employeeModal').modal('show');
   })

   $('.add_new_plt').on('click', function (e) {
      setDate()
      $('#productLeadModal input:not(input[name="prodd_id"]), #productLeadModal select, #productLeadModal textarea').val('');
      $('#productLeadModal').modal('show');
   })

   $('.edit_plt').on('click', function (e) {
      setDate()
      let jsondata = JSON.parse(this.dataset.show);
      $('#pro_project_id').val(jsondata[0])
      $('#pro_lead_stat').val(jsondata[1])
      $('#pro_amount').val(jsondata[2])
      $('#pro_proba').val(jsondata[3])
      $('#pro_remarks').val(jsondata[4])
      $('#pro_lead_close_date').val(jsondata[5].toString().split('T')[0])
      $('#pro_attach_link').val(jsondata[6])
      $('#csff').val(this.dataset.ext);
      $('#productLeadModal').modal('show');
   })

   $('body').on('submit', 'form', function (e) {
      $(this).find(':input[type=submit]').prop('disabled', true);
   })

   

})(jQuery)