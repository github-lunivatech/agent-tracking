jQuery(function() {
    let pucher = $('#punch_more').val();

    window.setInterval(function () {
        $('#clock').html(moment().format('H:mm:ss'))
    }, 1000);

    $('.in .card, .out .card').on('click', function(e){
        e.preventDefault()
        if(pucher != false){
            this.style.pointerEvents = 'none';
            this.style.cursor = 'not-allowed'
        }else{
            $('.in .card').remove()
        }
    })
})