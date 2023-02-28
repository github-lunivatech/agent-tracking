(function ($) {
  let today = new Date();
  $("#tblBulk").DataTable({});
  setTimeout(function () {
    $("#hamclose").trigger("click");
  }, 500);

  $("#from, #to").daterangepicker({
    locale: {
      format: "YYYY-MM-DD",
    },
    singleDatePicker: true,
    calender_style: "picker_4",
    timePickerSeconds: true,
    maxDate: today,
  });

  // $('#searchEmp').on('submit', async function (e) {
  //     e.preventDefault();
  //     const res = await callEmployeeSal();
  //     let tabber = '';
  //     let rowNo = 0;
  //     if(res){
  //         res.forEach(ele => {
  //             tabber += `<tr class="row_${rowNo}"><td>${ele.EmployeeId}</td>`+
  //             `<td>${ele.BasicSalary}</td>`+
  //             `<td>${ele.FestivalBonus}</td>`+
  //             `<td>${ele.Allowance}</td>`+
  //             `<td>${ele.Others}</td>`+
  //             `<td>${ele.ProvidentFund}</td>`+
  //             `<td>${ele.CitizenInvestmentTrust}</td>`+
  //             `<td>${ele.Insurane}</td>`+
  //             `<td>${ele.OtherFund}</td>`+
  //             `<td>${ele['TDS']}</td>`+
  //             `<td>${ele.TotalPayable}</td>`+
  //             `<td><input type="checkbox"></td>`+
  //             `<td><button class="btn btn-success btn-sm save_empDet" data-row="row_${rowNo}">Save</button></td>`+
  //             `</tr>`;
  //             rowNo++;
  //         });
  //     }
  //     $('#tblBulk tbody').html(tabber);
  // })

  // function callEmployeeSal() {
  //     return new Promise(resolve => {
  //         $.ajax({
  //             url: BASE_URL + 'salary/ajaxBulkSal',
  //             data: { empId: $('#emp_id').val(), from: $('#from').val(), to: $('#to').val() },
  //             method: 'post',
  //             dataType: 'json'
  //         }).done(function (res) {
  //             resolve(res)
  //         }).fail(function (res) {
  //             console.log('server error');
  //             resolve(false)
  //         })
  //     })
  // }

  $("body").on("click", ".save_one_sal", async function (e) {
    e.preventDefault();
    let rowNo = this.dataset.row;
    this.disabled = true;
    let data = $(
      "." + rowNo + " input, ." + rowNo + " textarea"
    ).serializeArray();
    data.push(
      { name: "monthName", value: $("#salMonth").val() },
      { name: "from", value: $("#from").val() },
      { name: "to", value: $("#to").val() },
      { name: "actPay", value: $(".pay_" + rowNo + " .shower").text() }
    );
    console.log(data);
    const res = await saveAndDispatch(data);
    if (res != false) {
      if (res.i != 0) {
        toastr.success(res.res);
      } else {
        toastr.warning(res.res);
        this.disabled = false;
      }
    } else {
      toastr.error("Server error");
      this.disabled = false;
    }
  });

  function saveAndDispatch(data) {
    return new Promise((resolve) => {
      $.ajax({
        url: BASE_URL + "salary/insertUpdateSalary",
        data: data,
        method: "post",
        dataType: "json",
      })
        .done(function (res) {
          resolve(res);
        })
        .fail(function (res) {
          resolve(false);
        });
    });
  }

  $("body").on("input", 'input[name="dedAmt"]', function () {
    let maxer = this.max;
    let dedAmt = Number(this.value);
    let clN = this.parentElement.parentElement.className;
    calculateDeductible(dedAmt, clN, maxer);
  });

  function calculateDeductible(dedAmt, clN, maxer) {
    let totPay = maxer;
    let actPay = totPay - dedAmt;
    if (actPay < 0) {
      $("." + clN + ' input[name="dedAmt"]').val("");
      actPay = maxer;
    }
    $(".pay_" + clN + " .shower").text(actPay);
  }
})(jQuery);
