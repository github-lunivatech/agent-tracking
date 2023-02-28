(function ($) {
  let today = new Date()

  $('#intime,#outtime').daterangepicker({
    timePicker: true,
    singleDatePicker: true,
    timePicker24Hour: false,
    timePickerIncrement: 1,
    timePickerSeconds: true,
    locale: {
      format: 'HH:mm:ss'
    }
  }).on('show.daterangepicker', function (ev, picker) {
    picker.container.find(".calendar-table").hide();
  });

  $('#appoint_date').daterangepicker({
    locale: {
      format: 'YYYY-MM-DD'
    },
    minDate: today,
    singleDatePicker: true,
    calender_style: "picker_4",
    "timePickerSeconds": true,
  })

  $("#appoint_with").select2({
    tags: true
  });

  $('#appoint_date').on('change', function (e) {
    let app_date = $('#appoint_date').val(),
      app_type = $('#appoint_type');

    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    fullDate = yyyy + '-' + mm + '-' + dd;
    if(fullDate != app_date){
      app_type.val(2)
    }else{
      app_type.val(1)
    }
  })

  getNepaliDate()

  function getNepaliDate() {
    let nowTime = new NepaliDate();
    let fullYear = nowTime.getYear() + '-' + nowTime.getMonth() + '-' + nowTime.getDate();
    $('input[name="nepalidate"]').val(fullYear);
    return fullYear;
  }

  const a = new URL(window.location.href);
  const na = a.pathname.split('/')[1];
  var web_so = 'ws://' + a.hostname + ':8282';
  var conn = new WebSocket(web_so);

  var client = {
    user_id: -1,
    recipient_id: null,
    type: 'socket',
    token: null,
    message: null,
    role: 'appointment_send'
  };

  conn.onopen = function (e) {
    conn.send(JSON.stringify(client));
  };

  $('#leaveForm').on('submit', function (e) {
    $('#addApp').attr('disabled', true);

    //send
    client.message = $('#text').val();
    client.token = $('#token').text().split(': ')[1];
    client.type = 'chat';
    client.recipient_id = 0;
    conn.send(JSON.stringify(client));
    //send
    // e.preventDefault()
  })

  $('body').on('input', '.convert-preeti', function (event) {
    var text = this.value;
    var convert = setUnicodePreeti(text);
    this.value = convert;
  
    return true;
  });

})(jQuery)