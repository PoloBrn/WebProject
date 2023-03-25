<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/jquery/jquery-3.6.3.js"></script>
<script src="../assets/cities.js"></script>
<script>
        window.addEventListener("load",()=> {
           if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('../view/serviceWorker.js');
        } 
        });
    </script>