document.addEventListener("DOMContentLoaded", function () {
    if (!document.cookie.includes("cookiesAccepted=true")) {
        const cookieBanner = document.getElementById("cookieNotification");
        if (cookieBanner) cookieBanner.style.display = "block";

        document.getElementById("acceptCookies").addEventListener("click", function () {
            document.cookie = "cookiesAccepted=true; path=/; max-age=" + 60 * 60 * 24 * 30;
            if (cookieBanner) cookieBanner.style.display = "none";
        });
    }
});
