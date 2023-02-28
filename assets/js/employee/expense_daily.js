(function ($) {

    $('#DiscountAmount').on('input', function (e) {
        var discountAmount = $(this).val();
        var expenseAmount = $('input[name="ExpensesAmount"]').val();
        var totalAmount = expenseAmount - discountAmount;
        $('input[name="TotalExpenses"]').val(totalAmount);
    });



})(jQuery);