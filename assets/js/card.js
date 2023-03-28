$(document).ready(function() {
    $('.card').mousemove(function(event) {
            windowWidth = $(window).width();
            windowHeight = $(window).height();
            
            mouseXpercentage = Math.round(event.pageX / windowWidth * 100);
            mouseYpercentage = Math.round(event.pageY / windowHeight * 100);
            
            var red = 52;
            var green = 152;
            var blue = 219;
            var alpha = 1;

            $(this).css('background', 'radial-gradient(at ' + mouseXpercentage*0.4 + '% ' + mouseYpercentage*0.4 + '%, rgba( 255, 255, 255, 0.5 ), rgba( 255, 255, 255, 0.2))');
    });
    console.log('test');
    $('.card').css('background', 'radial-gradient(at ' + 0 + '% ' + 0 + '%, rgba( 255, 255, 255, 0.5 ), rgba( 255, 255, 255, 0.2))');
});