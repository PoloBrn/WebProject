<!-- jQuery CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- jQuery local fallback -->
<script>
    window.jQuery || document.write('<script src="../assets/jquery/jquery-3.6.3.js"><\/script>')
</script>

<!-- Bootstrap CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<!-- Bootstrap local fallback -->
<script>
    if (!window.bootstrap) {
        console.log("Bootstrap CDN isn't available. Using local fallback.");
        document.write('<script src="../assets/bootstrap/js/bootstrap.min.js"><\/script>');
        document.write('<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">')
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