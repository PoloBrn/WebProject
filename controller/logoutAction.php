<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
$_SESSION = [];
session_destroy();
header('Location: ../view/login.php');

?>
<script>
    // supprimer caches
self.addEventListener("activate", (e) => {
    e.waitUntil(
        caches.keys().then((keys) => {
            return Promise.add(
                keys
                    .filter((key) => key !== staticCacheName)
                    .map((key) => caches.delete(key))
            );
        })
    );
});
</script>