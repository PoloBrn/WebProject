$(document).ready(function() {
    
    $(document).on('mousemove', function(e) {
        $('.background-shape').each(function() {

            var mouseY = e.pageY;
            var mouseX = e.pageX;

        $(this).css({
            'transform': 'translate(' + mouseX*0.01 + 'px,' + mouseY*0.01 + 'px)'
        })
        });
    });
});


