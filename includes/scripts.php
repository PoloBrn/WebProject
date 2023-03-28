<!-- jQuery CDN -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<!-- jQuery local fallback -->
<script>
    if (typeof(window.jQuery) === 'undefined') {
        var script = document.createElement("script");
        script.setAttribute('src', '../assets/jquery/jquery-3.6.3.js');
    }
</script>
<!-- Bootstrap CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<!-- Bootstrap local fallback -->
<script>
    if (typeof($.fn.modal) === 'undefined') {
        var script = document.createElement("link");
        script.setAttribute('href', '../assets/bootstrap/css/bootstrap.bundle.min.css');

        var script = document.createElement("script");
        script.setAttribute('src', '../assets/bootstrap/css/bootstrap.bundle.min.js');
    }
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script src="../assets/cities.js"></script>
<script>
    window.addEventListener("load", () => {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('../view/serviceWorker.js');
        }
    });
</script>